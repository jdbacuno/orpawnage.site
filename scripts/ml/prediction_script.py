import pandas as pd
import numpy as np
from sklearn.linear_model import LogisticRegression
from sklearn.preprocessing import RobustScaler, OneHotEncoder
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
import matplotlib.pyplot as plt
import seaborn as sns
from datetime import datetime, timedelta
from sqlalchemy import create_engine

# Import configuration (make sure config.py is in your PYTHONPATH)
from config import DB_CONFIG

# Step 1: Data Preparation
# ---------------------------------------------------------------------------
# Database connection using config
db_connection_string = (
    f"{DB_CONFIG['dialect']}+{DB_CONFIG['driver']}://"
    f"{DB_CONFIG['username']}:{DB_CONFIG['password']}@"
    f"{DB_CONFIG['host']}/{DB_CONFIG['database']}"
)
db_connection = create_engine(db_connection_string)

# Fetch adopted pets data (last 6 months) - ONLY SUCCESSFUL ADOPTIONS
six_months_ago = (datetime.now() - timedelta(days=180)).strftime('%Y-%m-%d')
query = f"""
    SELECT DISTINCT p.id, p.age, p.age_unit, p.sex, p.species, 
           a.status, a.updated_at as adoption_date, a.transaction_number
    FROM pets p
    JOIN adoption_applications a ON p.id = a.pet_id
    WHERE a.status = 'picked up' 
    AND a.updated_at >= '{six_months_ago}'
    AND a.pet_id NOT IN (
        SELECT pet_id FROM adoption_applications 
        WHERE status IN ('rejected', 'to be confirmed', 'confirmed', 'to be scheduled', 'adoption on-going')
    )
"""
adopted_pets = pd.read_sql(query, db_connection)

# Fetch current available pets (only those not adopted and without successful applications)
available_pets = pd.read_sql("""
    SELECT p.* FROM pets p
    WHERE p.id NOT IN (
        SELECT pet_id FROM adoption_applications WHERE status = 'picked up'
    )
    AND p.id NOT IN (
        SELECT pet_id FROM adoption_applications 
        WHERE status IN ('rejected', 'denied', 'cancelled', 'withdrawn')
        AND pet_id IN (
            SELECT pet_id FROM adoption_applications WHERE status = 'picked up'
        )
    )
""", db_connection)

# Debug: Check if we have both classes
print(f"Adopted pets count: {len(adopted_pets)}")
print(f"Available pets count: {len(available_pets)}")

# If no adopted pets, we can't train the model - handle this case
if len(adopted_pets) == 0:
    print("Warning: No adopted pets found in the last 6 months.")
    print("Using fallback strategy: featuring oldest available pets")
    
    # Convert ages for available pets
    def convert_to_months(age, unit):
        if unit == 'weeks':
            return age / 4
        elif unit == 'years':
            return age * 12
        return age  # already in months

    available_pets['age_months'] = available_pets.apply(
        lambda x: convert_to_months(x['age'], x['age_unit']), axis=1
    )
    
    # Avoid zero or negative values
    available_pets['age_months'] = available_pets['age_months'].clip(lower=0.25)
    
    # Select the oldest available pets (bottom 25% by age)
    threshold = available_pets['age_months'].quantile(0.25)
    low_prob_pets = available_pets[available_pets['age_months'] <= threshold].copy()
    
    # Sort by age (oldest first)
    low_prob_pets = low_prob_pets.sort_values('age_months', ascending=False)
    
    # Clear old featured pets and save new ones
    with db_connection.begin() as conn:
        conn.exec_driver_sql("DELETE FROM featured_pets")
    
    # Save only essential columns to featured_pets table
    featured_columns = ['id', 'name', 'species', 'sex', 'age', 'age_unit', 'age_months']
    if all(col in low_prob_pets.columns for col in featured_columns):
        low_prob_pets[featured_columns].to_sql('featured_pets', db_connection, if_exists='append', index=False)
    else:
        # Fallback if columns are missing
        low_prob_pets.to_sql('featured_pets', db_connection, if_exists='append', index=False)
    
    print(f"Fallback completed: Featured {len(low_prob_pets)} oldest available pets")
    exit(0)

# Continue with normal processing if we have both classes
def convert_to_months(age, unit):
    if unit == 'weeks':
        return age / 4
    elif unit == 'years':
        return age * 12
    return age  # already in months

adopted_pets['age_months'] = adopted_pets.apply(lambda x: convert_to_months(x['age'], x['age_unit']), axis=1)
available_pets['age_months'] = available_pets.apply(lambda x: convert_to_months(x['age'], x['age_unit']), axis=1)

# Avoid zero or negative values
adopted_pets['age_months'] = adopted_pets['age_months'].clip(lower=0.25)
available_pets['age_months'] = available_pets['age_months'].clip(lower=0.25)

# Apply log1p transformation
adopted_pets['log_age_months'] = np.log1p(adopted_pets['age_months'])
available_pets['log_age_months'] = np.log1p(available_pets['age_months'])

# Label data
adopted_pets['was_adopted'] = 1
available_pets['was_adopted'] = 0

# Combine for training
full_data = pd.concat([adopted_pets, available_pets])

# Step 2: Feature Engineering and Model Training
# ---------------------------------------------------------------------------
features = ['log_age_months', 'sex', 'species']
X = full_data[features]
y = full_data['was_adopted']

numeric_features = ['log_age_months']
categorical_features = ['sex', 'species']

preprocessor = ColumnTransformer(
    transformers=[
        ('num', RobustScaler(), numeric_features),
        ('cat', OneHotEncoder(), categorical_features)
    ]
)

model = Pipeline([
    ('preprocessor', preprocessor),
    ('classifier', LogisticRegression(max_iter=1000))
])

model.fit(X, y)

# Step 3: Predict Adoption Likelihood for Available Pets
# ---------------------------------------------------------------------------
# Predict probabilities for available pets
X_available = available_pets[features]
available_pets['adoption_probability'] = model.predict_proba(X_available)[:, 1]

# Identify pets with low adoption probability (bottom 25%)
threshold = available_pets['adoption_probability'].quantile(0.25)
low_prob_pets = available_pets[available_pets['adoption_probability'] <= threshold].copy()

# Sort by probability (lowest first)
low_prob_pets = low_prob_pets.sort_values('adoption_probability')

# Save results to CSV
low_prob_pets.to_csv('low_probability_pets.csv', index=False)

# Clear old featured pets and save new ones
with db_connection.begin() as conn:
    conn.exec_driver_sql("DELETE FROM featured_pets")

# Save only essential columns to featured_pets table
featured_columns = ['id', 'name', 'species', 'sex', 'age', 'age_unit', 'age_months', 'adoption_probability']
if all(col in low_prob_pets.columns for col in featured_columns):
    low_prob_pets[featured_columns].to_sql('featured_pets', db_connection, if_exists='append', index=False)
else:
    # Fallback if columns are missing
    low_prob_pets.to_sql('featured_pets', db_connection, if_exists='append', index=False)

print(f"Successfully featured {len(low_prob_pets)} pets with low adoption probability")

# Step 4: Enhanced Analysis and Visualization with Transaction Numbers
# ---------------------------------------------------------------------------
# Feature importance analysis
coefficients = model.named_steps['classifier'].coef_[0]
feature_names = (model.named_steps['preprocessor']
                 .named_transformers_['cat']
                 .get_feature_names_out(categorical_features))
all_features = numeric_features + list(feature_names)

# Create a DataFrame for feature importance
importance_df = pd.DataFrame({
    'Feature': all_features,
    'Coefficient': coefficients
})

print("\nFeature Importance in Adoption Prediction:")
print(importance_df.sort_values('Coefficient', ascending=False).to_string(index=False))

# Age distribution statistics with transaction count
print("\nAge Distribution Statistics (months):")
age_stats = pd.DataFrame({
    'Group': ['Adopted', 'Available'],
    'Mean Age': [adopted_pets['age_months'].mean(), available_pets['age_months'].mean()],
    'Median Age': [adopted_pets['age_months'].median(), available_pets['age_months'].median()],
    'Min Age': [adopted_pets['age_months'].min(), available_pets['age_months'].min()],
    'Max Age': [adopted_pets['age_months'].max(), available_pets['age_months'].max()],
    'Total Count': [len(adopted_pets), len(available_pets)]
})
print(age_stats.to_string(index=False))

# Species distribution with transaction numbers
print("\nSpecies Distribution with Transaction Counts:")
species_transaction_stats = adopted_pets.groupby('species').agg({
    'transaction_number': 'count',
    'id': 'count'
}).rename(columns={'transaction_number': 'Transaction Count', 'id': 'Pet Count'})

species_available = available_pets['species'].value_counts().rename('Available Count')
species_dist = pd.concat([species_transaction_stats, species_available], axis=1).fillna(0)
species_dist['Adoption Rate'] = species_dist['Pet Count'] / (species_dist['Pet Count'] + species_dist['Available Count'])
print(species_dist.to_string())

# Transaction number analysis
print("\nTransaction Number Analysis:")
print(f"Total successful transactions: {adopted_pets['transaction_number'].nunique()}")
print(f"Average pets per transaction: {len(adopted_pets) / adopted_pets['transaction_number'].nunique():.2f}")

# Transaction frequency by month
if 'adoption_date' in adopted_pets.columns:
    adopted_pets['adoption_month'] = pd.to_datetime(adopted_pets['adoption_date']).dt.to_period('M')
    monthly_transactions = adopted_pets.groupby('adoption_month').agg({
        'transaction_number': 'nunique',
        'id': 'count'
    }).rename(columns={'transaction_number': 'Unique Transactions', 'id': 'Total Pets Adopted'})
    
    print("\nMonthly Adoption Statistics:")
    print(monthly_transactions.to_string())

# Sex distribution with transaction context
print("\nSex Distribution with Adoption Rates:")
sex_transaction_stats = adopted_pets.groupby('sex').agg({
    'transaction_number': 'count',
    'id': 'count'
}).rename(columns={'transaction_number': 'Transaction Count', 'id': 'Pet Count'})

sex_available = available_pets['sex'].value_counts().rename('Available Count')
sex_dist = pd.concat([sex_transaction_stats, sex_available], axis=1).fillna(0)
sex_dist['Adoption Rate'] = sex_dist['Pet Count'] / (sex_dist['Pet Count'] + sex_dist['Available Count'])
print(sex_dist.to_string())

# Top transactions by number of pets adopted
print("\nTop Transactions by Number of Pets Adopted:")
top_transactions = adopted_pets.groupby('transaction_number').agg({
    'id': 'count',
    'species': lambda x: x.value_counts().index[0] if len(x) > 0 else 'Unknown'
}).rename(columns={'id': 'Pets Adopted', 'species': 'Primary Species'}).sort_values('Pets Adopted', ascending=False)

print(top_transactions.head(10).to_string())

# Age groups analysis with transaction data
print("\nAge Group Analysis with Adoption Rates:")
adopted_pets['age_group'] = pd.cut(adopted_pets['age_months'], 
                                  bins=[0, 6, 12, 24, 60, 120, np.inf],
                                  labels=['0-6m', '6-12m', '1-2y', '2-5y', '5-10y', '10y+'])
available_pets['age_group'] = pd.cut(available_pets['age_months'], 
                                   bins=[0, 6, 12, 24, 60, 120, np.inf],
                                   labels=['0-6m', '6-12m', '1-2y', '2-5y', '5-10y', '10y+'])

age_group_stats = adopted_pets.groupby('age_group').agg({
    'transaction_number': 'count',
    'id': 'count'
}).rename(columns={'transaction_number': 'Transaction Count', 'id': 'Pet Count'})

age_group_available = available_pets['age_group'].value_counts().rename('Available Count')
age_group_dist = pd.concat([age_group_stats, age_group_available], axis=1).fillna(0)
age_group_dist['Adoption Rate'] = age_group_dist['Pet Count'] / (age_group_dist['Pet Count'] + age_group_dist['Available Count'])
print(age_group_dist.to_string())
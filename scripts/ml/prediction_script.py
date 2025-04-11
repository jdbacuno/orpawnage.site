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

# Fetch adopted pets data (last 6 months)
six_months_ago = (datetime.now() - timedelta(days=180)).strftime('%Y-%m-%d')
query = f"""
    SELECT p.id, p.age, p.age_unit, p.sex, p.species, 
           a.status, a.updated_at as adoption_date
    FROM pets p
    JOIN adoption_applications a ON p.id = a.pet_id
    WHERE a.status = 'picked up' 
    AND a.created_at >= '{six_months_ago}'
"""
adopted_pets = pd.read_sql(query, db_connection)

# Fetch current available pets
available_pets = pd.read_sql("""
    SELECT * FROM pets 
    WHERE id NOT IN (
        SELECT pet_id FROM adoption_applications WHERE status = 'picked up'
    )
""", db_connection)

# Convert all ages to months
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

# Save results to CSV or back to database
low_prob_pets.to_csv('low_probability_pets.csv', index=False)

# Optional: Save to database
low_prob_pets.to_sql('featured_pets', db_connection, if_exists='replace', index=False)

# Step 4: Analysis and Visualization (commented out and replaced with text tables)
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

# Plot feature importance (commented out)
# plt.figure(figsize=(10, 6))
# sns.barplot(x='Coefficient', y='Feature', data=importance_df.sort_values('Coefficient', ascending=False))
# plt.title('Feature Importance in Adoption Prediction')
# plt.tight_layout()
# plt.savefig('feature_importance.png')
# plt.show()

# Text table replacement:
# print("\nFeature Importance in Adoption Prediction:")
# print(importance_df.sort_values('Coefficient', ascending=False).to_string(index=False))

# Age distribution comparison (commented out)
# plt.figure(figsize=(12, 6))
# sns.histplot(data=adopted_pets, x='age_months', color='green', label='Adopted', kde=True)
# sns.histplot(data=available_pets, x='age_months', color='blue', label='Available', kde=True)
# plt.title('Age Distribution: Adopted vs Available Pets')
# plt.xlabel('Age (months)')
# plt.legend()
# plt.savefig('age_distribution.png')
# plt.show()

# Text table replacement:
# print("\nAge Distribution Statistics (months):")
# age_stats = pd.DataFrame({
#     'Group': ['Adopted', 'Available'],
#     'Mean Age': [adopted_pets['age_months'].mean(), available_pets['age_months'].mean()],
#     'Median Age': [adopted_pets['age_months'].median(), available_pets['age_months'].median()],
#     'Min Age': [adopted_pets['age_months'].min(), available_pets['age_months'].min()],
#     'Max Age': [adopted_pets['age_months'].max(), available_pets['age_months'].max()]
# })
# print(age_stats.to_string(index=False))

# Species distribution comparison (commented out)
# plt.figure(figsize=(12, 6))
# sns.countplot(data=pd.concat([adopted_pets.assign(Status='Adopted'), 
#                              available_pets.assign(Status='Available')]), 
#               x='species', hue='Status', palette={'Adopted': 'green', 'Available': 'blue'})
# plt.title('Species Distribution: Adopted vs Available Pets')
# plt.xlabel('Species')
# plt.ylabel('Count')
# plt.xticks(rotation=45)
# plt.tight_layout()
# plt.savefig('species_distribution.png')
# plt.show()

# Text table replacement:
# print("\nSpecies Distribution:")
# species_dist = pd.concat([
#     adopted_pets['species'].value_counts().rename('Adopted'),
#     available_pets['species'].value_counts().rename('Available')
# ], axis=1).fillna(0)
# print(species_dist.to_string())

# Sex distribution comparison (commented out)
# plt.figure(figsize=(12, 6))
# sns.countplot(data=pd.concat([adopted_pets.assign(Status='Adopted'), 
#                              available_pets.assign(Status='Available')]), 
#               x='sex', hue='Status', palette={'Adopted': 'green', 'Available': 'blue'})
# plt.title('Sex Distribution: Adopted vs Available Pets')
# plt.xlabel('Sex')
# plt.ylabel('Count')
# plt.xticks(rotation=45)
# plt.tight_layout()
# plt.savefig('sex_distribution.png')
# plt.show()

# Text table replacement:
# print("\nSex Distribution:")
# sex_dist = pd.concat([
#     adopted_pets['sex'].value_counts().rename('Adopted'),
#     available_pets['sex'].value_counts().rename('Available')
# ], axis=1).fillna(0)
# print(sex_dist.to_string())

# First clear old featured pets (corrected version)
with db_connection.begin() as conn:
    conn.exec_driver_sql("DELETE FROM featured_pets")

# Save new featured pets (corrected version)
low_prob_pets.to_sql('featured_pets', db_connection, if_exists='append', index=False)

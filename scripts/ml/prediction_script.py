import pandas as pd 
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.linear_model import LogisticRegression
from sklearn.preprocessing import RobustScaler, OneHotEncoder
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.metrics import classification_report, confusion_matrix, roc_auc_score, roc_curve
from datetime import datetime, timedelta
from sqlalchemy import create_engine
import warnings
warnings.filterwarnings('ignore')

# Import configuration
from config import DB_CONFIG

print("=== ENHANCED FEATURED PETS ML SCRIPT WITH VISUALIZATIONS ===")
print(f"Started at: {datetime.now()}")

# Set up plotting style
plt.style.use('seaborn-v0_8')
sns.set_palette("husl")
plt.rcParams['figure.figsize'] = (12, 8)

# ---------------- Database Connection ----------------
db_connection_string = (
    f"{DB_CONFIG['dialect']}+{DB_CONFIG['driver']}://"
    f"{DB_CONFIG['username']}:{DB_CONFIG['password']}@"
    f"{DB_CONFIG['host']}/{DB_CONFIG['database']}"
)
db_connection = create_engine(db_connection_string)

# ---------------- Constants ----------------
ESTIMATED_PREDICTORS_COUNT = 6
SAMPLES_PER_PREDICTOR = 10
STATISTICAL_MINIMUM = ESTIMATED_PREDICTORS_COUNT * SAMPLES_PER_PREDICTOR
TRAINING_WINDOW_MONTHS = 6

# ---------------- Helper Functions ----------------
def convert_to_months(age, unit):
    """Convert age to months from different units."""
    if unit == 'weeks':
        return age / 4
    elif unit == 'years':
        return age * 12
    return age

def fetch_adopted_pets(window_months=6):
    """Fetch adopted pets within the last `window_months` months."""
    cutoff_date = datetime.now() - timedelta(days=30 * window_months)
    query = f"""
        SELECT DISTINCT p.id, p.age, p.age_unit, p.sex, p.species,
               a.status, a.updated_at as adoption_date, a.transaction_number
        FROM pets p
        JOIN adoption_applications a ON p.id = a.pet_id
        WHERE a.status = 'picked up'
        AND a.updated_at >= '{cutoff_date.strftime('%Y-%m-%d')}'
    """
    df = pd.read_sql(query, db_connection)
    return df.drop_duplicates(subset=['id'])

def create_data_overview_plots(available_pets, adopted_pets):
    """Create comprehensive data overview visualizations."""
    fig, axes = plt.subplots(2, 3, figsize=(18, 12))
    fig.suptitle('Pet Adoption Data Overview', fontsize=16, fontweight='bold')
    
    # 1. Age distribution comparison
    axes[0, 0].hist(available_pets['age_months'], alpha=0.7, label='Available', bins=30, color='skyblue')
    axes[0, 0].hist(adopted_pets['age_months'], alpha=0.7, label='Adopted', bins=30, color='salmon')
    axes[0, 0].set_xlabel('Age (months)')
    axes[0, 0].set_ylabel('Count')
    axes[0, 0].set_title('Age Distribution Comparison')
    axes[0, 0].legend()
    axes[0, 0].grid(True, alpha=0.3)
    
    # 2. Species distribution
    species_available = available_pets['species'].value_counts()
    species_adopted = adopted_pets['species'].value_counts()
    species_comparison = pd.DataFrame({
        'Available': species_available,
        'Adopted': species_adopted
    }).fillna(0)
    
    species_comparison.plot(kind='bar', ax=axes[0, 1], color=['skyblue', 'salmon'])
    axes[0, 1].set_title('Species Distribution')
    axes[0, 1].set_xlabel('Species')
    axes[0, 1].set_ylabel('Count')
    axes[0, 1].tick_params(axis='x', rotation=45)
    axes[0, 1].legend()
    
    # 3. Sex distribution
    sex_available = available_pets['sex'].value_counts()
    sex_adopted = adopted_pets['sex'].value_counts()
    sex_comparison = pd.DataFrame({
        'Available': sex_available,
        'Adopted': sex_adopted
    }).fillna(0)
    
    sex_comparison.plot(kind='bar', ax=axes[0, 2], color=['skyblue', 'salmon'])
    axes[0, 2].set_title('Sex Distribution')
    axes[0, 2].set_xlabel('Sex')
    axes[0, 2].set_ylabel('Count')
    axes[0, 2].tick_params(axis='x', rotation=45)
    axes[0, 2].legend()
    
    # 4. Age vs Species heatmap for adopted pets
    if len(adopted_pets) > 0:
        adopted_pets_binned = adopted_pets.copy()
        adopted_pets_binned['age_group'] = pd.cut(adopted_pets_binned['age_months'], 
                                                bins=5, labels=['Very Young', 'Young', 'Adult', 'Mature', 'Senior'])
        heatmap_data = pd.crosstab(adopted_pets_binned['age_group'], adopted_pets_binned['species'])
        sns.heatmap(heatmap_data, annot=True, fmt='d', ax=axes[1, 0], cmap='YlOrRd')
        axes[1, 0].set_title('Adopted Pets: Age Group vs Species')
        axes[1, 0].set_xlabel('Species')
        axes[1, 0].set_ylabel('Age Group')
    
    # 5. Adoption timeline
    if len(adopted_pets) > 0 and 'adoption_date' in adopted_pets.columns:
        adopted_pets['adoption_month'] = pd.to_datetime(adopted_pets['adoption_date']).dt.to_period('M')
        timeline = adopted_pets['adoption_month'].value_counts().sort_index()
        timeline.plot(kind='line', ax=axes[1, 1], marker='o', color='green')
        axes[1, 1].set_title('Adoption Timeline')
        axes[1, 1].set_xlabel('Month')
        axes[1, 1].set_ylabel('Number of Adoptions')
        axes[1, 1].tick_params(axis='x', rotation=45)
        axes[1, 1].grid(True, alpha=0.3)
    
    # 6. Summary statistics table
    summary_stats = pd.DataFrame({
        'Available Pets': [
            len(available_pets),
            f"{available_pets['age_months'].mean():.1f}",
            f"{available_pets['age_months'].median():.1f}",
            f"{available_pets['age_months'].std():.1f}"
        ],
        'Adopted Pets': [
            len(adopted_pets),
            f"{adopted_pets['age_months'].mean():.1f}" if len(adopted_pets) > 0 else "N/A",
            f"{adopted_pets['age_months'].median():.1f}" if len(adopted_pets) > 0 else "N/A",
            f"{adopted_pets['age_months'].std():.1f}" if len(adopted_pets) > 0 else "N/A"
        ]
    }, index=['Count', 'Mean Age (months)', 'Median Age (months)', 'Std Dev Age'])
    
    axes[1, 2].axis('tight')
    axes[1, 2].axis('off')
    table = axes[1, 2].table(cellText=summary_stats.values,
                           rowLabels=summary_stats.index,
                           colLabels=summary_stats.columns,
                           cellLoc='center',
                           loc='center')
    table.auto_set_font_size(False)
    table.set_fontsize(10)
    table.scale(1.2, 1.5)
    axes[1, 2].set_title('Summary Statistics')
    
    plt.tight_layout()
    plt.show()

def create_ml_performance_plots(model, X, y, available_pets, adopted_pets):
    """Create ML model performance visualizations."""
    fig, axes = plt.subplots(2, 2, figsize=(15, 12))
    fig.suptitle('Machine Learning Model Performance', fontsize=16, fontweight='bold')
    
    # 1. ROC Curve
    y_proba = model.predict_proba(X)[:, 1]
    fpr, tpr, _ = roc_curve(y, y_proba)
    auc_score = roc_auc_score(y, y_proba)
    
    axes[0, 0].plot(fpr, tpr, color='darkorange', lw=2, label=f'ROC curve (AUC = {auc_score:.3f})')
    axes[0, 0].plot([0, 1], [0, 1], color='navy', lw=2, linestyle='--', label='Random Classifier')
    axes[0, 0].set_xlim([0.0, 1.0])
    axes[0, 0].set_ylim([0.0, 1.05])
    axes[0, 0].set_xlabel('False Positive Rate')
    axes[0, 0].set_ylabel('True Positive Rate')
    axes[0, 0].set_title('ROC Curve')
    axes[0, 0].legend(loc="lower right")
    axes[0, 0].grid(True, alpha=0.3)
    
    # 2. Prediction probability distribution
    y_pred_proba = model.predict_proba(X)[:, 1]
    adopted_proba = y_pred_proba[y == 1]
    available_proba = y_pred_proba[y == 0]
    
    axes[0, 1].hist(available_proba, alpha=0.7, label='Available Pets', bins=30, color='skyblue')
    axes[0, 1].hist(adopted_proba, alpha=0.7, label='Adopted Pets', bins=30, color='salmon')
    axes[0, 1].set_xlabel('Predicted Adoption Probability')
    axes[0, 1].set_ylabel('Count')
    axes[0, 1].set_title('Predicted Probability Distribution')
    axes[0, 1].legend()
    axes[0, 1].grid(True, alpha=0.3)
    
    # 3. Confusion Matrix
    y_pred = model.predict(X)
    cm = confusion_matrix(y, y_pred)
    sns.heatmap(cm, annot=True, fmt='d', ax=axes[1, 0], cmap='Blues',
                xticklabels=['Available', 'Adopted'],
                yticklabels=['Available', 'Adopted'])
    axes[1, 0].set_title('Confusion Matrix')
    axes[1, 0].set_xlabel('Predicted')
    axes[1, 0].set_ylabel('Actual')
    
    # 4. Feature Importance (for logistic regression coefficients)
    if hasattr(model.named_steps['classifier'], 'coef_'):
        feature_names = model.named_steps['preprocessor'].get_feature_names_out()
        coefficients = model.named_steps['classifier'].coef_[0]
        
        # Create feature importance DataFrame
        feature_importance = pd.DataFrame({
            'feature': feature_names,
            'coefficient': coefficients,
            'abs_coefficient': np.abs(coefficients)
        }).sort_values('abs_coefficient', ascending=True)
        
        # Plot horizontal bar chart
        colors = ['red' if x < 0 else 'green' for x in feature_importance['coefficient']]
        axes[1, 1].barh(range(len(feature_importance)), feature_importance['coefficient'], color=colors)
        axes[1, 1].set_yticks(range(len(feature_importance)))
        axes[1, 1].set_yticklabels(feature_importance['feature'], fontsize=8)
        axes[1, 1].set_xlabel('Coefficient Value')
        axes[1, 1].set_title('Feature Coefficients\n(Green: Positive, Red: Negative)')
        axes[1, 1].axvline(x=0, color='black', linestyle='-', alpha=0.3)
        axes[1, 1].grid(True, alpha=0.3)
    
    plt.tight_layout()
    plt.show()

def create_featured_pets_analysis(featured_pets_data, available_pets, strategy_used):
    """Create visualizations for featured pets analysis."""
    if len(featured_pets_data) == 0:
        print("No featured pets to analyze")
        return
    
    # Merge with pet details
    featured_with_details = featured_pets_data.merge(
        available_pets[['id', 'age_months', 'species', 'sex']], 
        left_on='pet_id', right_on='id', how='left'
    )
    
    fig, axes = plt.subplots(2, 2, figsize=(15, 12))
    fig.suptitle(f'Featured Pets Analysis - {strategy_used}', fontsize=16, fontweight='bold')
    
    # 1. Adoption probability distribution
    if 'adoption_probability' in featured_pets_data.columns:
        axes[0, 0].hist(featured_pets_data['adoption_probability'], bins=20, 
                       color='lightcoral', alpha=0.7, edgecolor='black')
        axes[0, 0].set_xlabel('Adoption Probability')
        axes[0, 0].set_ylabel('Count')
        axes[0, 0].set_title('Distribution of Adoption Probabilities')
        axes[0, 0].grid(True, alpha=0.3)
        
        # Add statistics text
        stats_text = f"Mean: {featured_pets_data['adoption_probability'].mean():.3f}\n"
        stats_text += f"Median: {featured_pets_data['adoption_probability'].median():.3f}\n"
        stats_text += f"Std: {featured_pets_data['adoption_probability'].std():.3f}"
        axes[0, 0].text(0.02, 0.98, stats_text, transform=axes[0, 0].transAxes, 
                       verticalalignment='top', bbox=dict(boxstyle='round', facecolor='wheat', alpha=0.8))
    
    # 2. Species distribution of featured pets
    if len(featured_with_details) > 0:
        species_counts = featured_with_details['species'].value_counts()
        axes[0, 1].pie(species_counts.values, labels=species_counts.index, autopct='%1.1f%%')
        axes[0, 1].set_title('Species Distribution of Featured Pets')
    
    # 3. Age distribution comparison
    if len(featured_with_details) > 0:
        axes[1, 0].hist(available_pets['age_months'], alpha=0.5, label='All Available', 
                       bins=30, color='lightblue', density=True)
        axes[1, 0].hist(featured_with_details['age_months'], alpha=0.7, label='Featured', 
                       bins=20, color='red', density=True)
        axes[1, 0].set_xlabel('Age (months)')
        axes[1, 0].set_ylabel('Density')
        axes[1, 0].set_title('Age Distribution: Featured vs All Available')
        axes[1, 0].legend()
        axes[1, 0].grid(True, alpha=0.3)
    
    # 4. Top 10 featured pets details
    if len(featured_with_details) > 0:
        top_pets = featured_with_details.head(10)[['pet_id', 'adoption_probability', 'age_months', 'species', 'sex']]
        
        axes[1, 1].axis('tight')
        axes[1, 1].axis('off')
        
        table_data = []
        for _, row in top_pets.iterrows():
            prob_str = f"{row['adoption_probability']:.3f}" if 'adoption_probability' in row else "N/A"
            table_data.append([
                str(row['pet_id']),
                prob_str,
                f"{row['age_months']:.1f}",
                str(row['species'])[:10],  # Truncate long species names
                str(row['sex'])
            ])
        
        table = axes[1, 1].table(
            cellText=table_data,
            colLabels=['Pet ID', 'Prob', 'Age', 'Species', 'Sex'],
            cellLoc='center',
            loc='center'
        )
        table.auto_set_font_size(False)
        table.set_fontsize(8)
        table.scale(1.2, 1.5)
        axes[1, 1].set_title('Top 10 Featured Pets')
    
    plt.tight_layout()
    plt.show()

# ---------------- Step 1: Clear Existing Featured Pets ----------------
print("\n1. CLEARING EXISTING FEATURED PETS...")
try:
    with db_connection.begin() as conn:
        conn.exec_driver_sql("DELETE FROM featured_pets")
    print("SUCCESS: Cleared featured_pets table")
except Exception as e:
    print(f"ERROR: {e}")
    exit(1)

# ---------------- Step 2: Fetch Available Pets ----------------
print("\n2. FETCHING AVAILABLE PETS...")
available_query = """
    SELECT p.*
    FROM pets p
    WHERE p.archived_at IS NULL
    AND p.id NOT IN (
        SELECT DISTINCT pet_id FROM adoption_applications
        WHERE status IN ('picked up', 'to be confirmed', 'confirmed', 'to be scheduled',
                         'adoption on-going', 'to be picked up', 'archived')
    )
"""
available_pets = pd.read_sql(available_query, db_connection)
print(f"SUCCESS: Found {len(available_pets)} available pets")

if len(available_pets) == 0:
    print("ERROR: No available pets found!")
    exit(0)

# ---------------- Step 3: Fetch Adoption Data ----------------
print(f"\n3. FETCHING ADOPTION DATA ({TRAINING_WINDOW_MONTHS}-Month Window)...")
adopted_pets = fetch_adopted_pets(TRAINING_WINDOW_MONTHS)
print(f"Found {len(adopted_pets)} adopted pets in the last {TRAINING_WINDOW_MONTHS} months.")

if len(adopted_pets) == 0:
    print("ERROR: No adopted pets found!")
    exit(0)

# Convert ages to months for both datasets
for df in [available_pets, adopted_pets]:
    df['age_months'] = df.apply(lambda x: convert_to_months(x['age'], x['age_unit']), axis=1)
    df['age_months'] = df['age_months'].clip(lower=0.25)

# ---------------- Step 4: Create Data Overview Visualizations ----------------
print("\n4. CREATING DATA OVERVIEW VISUALIZATIONS...")
create_data_overview_plots(available_pets, adopted_pets)

# Show what data we're working with BEFORE calculating predictors
print(f"\nDATA ANALYSIS:")
all_data_for_analysis = pd.concat([available_pets, adopted_pets], ignore_index=True)
print(f"  Unique sex values: {sorted(all_data_for_analysis['sex'].dropna().unique())}")
print(f"  Unique species values: {sorted(all_data_for_analysis['species'].dropna().unique())}")

# Calculate actual predictors count
sex_count = len(all_data_for_analysis['sex'].dropna().unique())
species_count = len(all_data_for_analysis['species'].dropna().unique())
age_count = 1

actual_predictors_count = age_count + sex_count + species_count
actual_statistical_minimum = actual_predictors_count * SAMPLES_PER_PREDICTOR

print(f"\nPREDICTOR COUNT CALCULATION:")
print(f"  Age predictors: {age_count} (log_age_months)")
print(f"  Sex predictors: {sex_count} (one dummy per unique sex value)")
print(f"  Species predictors: {species_count} (one dummy per unique species)")
print(f"  Total predictors: {actual_predictors_count}")
print(f"  Statistical minimum needed: {actual_statistical_minimum}")

# ---------------- Step 5: Determine Strategy ----------------
print(f"\n5. CHECKING DATA SUFFICIENCY...")
print(f"Adopted pets available: {len(adopted_pets)}")
print(f"Statistical minimum needed: {actual_statistical_minimum}")

if len(adopted_pets) < actual_statistical_minimum:
    print(f"\n6. USING FALLBACK STRATEGY...")
    
    age_threshold = available_pets['age_months'].quantile(0.75)
    featured_pets_selection = available_pets[available_pets['age_months'] >= age_threshold].copy()
    featured_pets_selection = featured_pets_selection.sort_values('age_months', ascending=False)

    featured_pets_data = pd.DataFrame({
        'pet_id': featured_pets_selection['id'],
        'adoption_probability': 0.1
    })

    strategy_used = "Fallback (Oldest Pets)"
    print(f"SUCCESS: Selected {len(featured_pets_data)} oldest pets for fallback.")

else:
    print(f"\n6. USING MACHINE LEARNING PREDICTION...")

    # Prepare features
    adopted_pets['log_age_months'] = np.log1p(adopted_pets['age_months'])
    available_pets['log_age_months'] = np.log1p(available_pets['age_months'])

    # Create target variable
    adopted_pets['was_adopted'] = 1
    available_pets['was_adopted'] = 0

    # Combine datasets
    full_data = pd.concat([adopted_pets, available_pets], ignore_index=True)

    # Define features
    features = ['log_age_months', 'sex', 'species']
    X = full_data[features]
    y = full_data['was_adopted']

    # Create preprocessing pipeline
    preprocessor = ColumnTransformer([
        ('num', RobustScaler(), ['log_age_months']),
        ('cat', OneHotEncoder(handle_unknown='ignore'), ['sex', 'species'])
    ])

    # Create and train model
    model = Pipeline([
        ('preprocessor', preprocessor),
        ('classifier', LogisticRegression(max_iter=1000, random_state=42))
    ])

    print("Training machine learning model...")
    model.fit(X, y)

    # Verify features
    feature_names = model.named_steps['preprocessor'].get_feature_names_out()
    print(f"Confirmed predictor count: {len(feature_names)} (matches calculation: {actual_predictors_count})")

    # Create ML performance visualizations
    print("\n7. CREATING ML PERFORMANCE VISUALIZATIONS...")
    create_ml_performance_plots(model, X, y, available_pets, adopted_pets)

    # Print classification report
    y_pred = model.predict(X)
    print("\nClassification Report:")
    print(classification_report(y, y_pred, target_names=['Available', 'Adopted']))

    # Predict adoption probabilities
    X_available = available_pets[features]
    available_pets['adoption_probability'] = model.predict_proba(X_available)[:, 1]

    # Select pets with lowest 25% adoption probability
    probability_threshold = available_pets['adoption_probability'].quantile(0.25)
    featured_pets_selection = available_pets[
        available_pets['adoption_probability'] <= probability_threshold
    ].copy()
    featured_pets_selection = featured_pets_selection.sort_values('adoption_probability')

    featured_pets_data = pd.DataFrame({
        'pet_id': featured_pets_selection['id'],
        'adoption_probability': featured_pets_selection['adoption_probability']
    })

    strategy_used = "Machine Learning"
    print(f"SUCCESS: Selected {len(featured_pets_data)} pets with ML prediction.")

# ---------------- Step 7: Create Featured Pets Analysis ----------------
print(f"\n8. CREATING FEATURED PETS ANALYSIS...")
create_featured_pets_analysis(featured_pets_data, available_pets, strategy_used)

# ---------------- Step 8: Save to Database ----------------
print("\n9. SAVING TO DATABASE...")
if len(featured_pets_data) > 0:
    featured_pets_data.to_sql('featured_pets', db_connection, if_exists='append', index=False)
    print(f"SUCCESS: Saved {len(featured_pets_data)} pets to featured_pets table.")

    # Verification
    verification = pd.read_sql("""
        SELECT fp.pet_id, fp.adoption_probability, p.pet_name, p.species, p.age
        FROM featured_pets fp
        JOIN pets p ON fp.pet_id = p.id
        ORDER BY fp.adoption_probability ASC
        LIMIT 5
    """, db_connection)

    print("\nVERIFICATION - Sample featured pets:")
    print(verification.to_string(index=False))

    final_count = pd.read_sql("SELECT COUNT(*) as count FROM featured_pets", db_connection)
    print(f"SUCCESS: featured_pets table now contains {final_count.iloc[0]['count']} records")
else:
    print("ERROR: No pets to feature!")

# ---------------- Step 9: Summary ----------------
print(f"\n=== SUMMARY STATISTICS ===")
print(f"Available pets analyzed: {len(available_pets)}")
print(f"Adopted pets analyzed: {len(adopted_pets)}")
print(f"Statistical minimum threshold: {actual_statistical_minimum}")
print(f"Featured pets selected: {len(featured_pets_data)}")
print(f"Strategy used: {strategy_used}")

if len(available_pets) > 0:
    print(f"Average age of available pets: {available_pets['age_months'].mean():.1f} months")
    
if strategy_used == "Machine Learning" and len(featured_pets_data) > 0:
    print(f"Average adoption probability of featured pets: {featured_pets_data['adoption_probability'].mean():.3f}")
    print(f"Probability threshold used: {probability_threshold:.3f}")

print(f"\n=== VISUALIZATIONS DISPLAYED ===")
print("1. Data Overview - Comprehensive data analysis charts")
if strategy_used == "Machine Learning":
    print("2. ML Model Performance - Model performance metrics")
print("3. Featured Pets Analysis - Featured pets analysis charts")

print(f"\n=== SCRIPT COMPLETED SUCCESSFULLY at {datetime.now()} ===")
if len(featured_pets_data) > 0:
    print(f"SUCCESS: Pet IDs featured: {featured_pets_data['pet_id'].tolist()[:10]}{'...' if len(featured_pets_data) > 10 else ''}")

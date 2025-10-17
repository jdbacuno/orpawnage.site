import os
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

# =========================================================
# CONFIGURATION
# =========================================================
# Laravel project root relative to this script
PROJECT_ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), "../../"))
CHARTS_DIR = os.path.join(PROJECT_ROOT, "scripts", "ml", "charts")
os.makedirs(CHARTS_DIR, exist_ok=True)

print("=== ENHANCED FEATURED PETS ML SCRIPT WITH IMAGE EXPORT ===")
print(f"Started at: {datetime.now()}")

# Plot style
plt.style.use('seaborn-v0_8')
sns.set_palette("husl")
plt.rcParams['figure.figsize'] = (12, 8)

# =========================================================
# DATABASE CONNECTION
# =========================================================
db_connection_string = (
    f"{DB_CONFIG['dialect']}+{DB_CONFIG['driver']}://"
    f"{DB_CONFIG['username']}:{DB_CONFIG['password']}@"
    f"{DB_CONFIG['host']}/{DB_CONFIG['database']}"
)
db_connection = create_engine(db_connection_string)

# =========================================================
# CONSTANTS
# =========================================================
ESTIMATED_PREDICTORS_COUNT = 6
SAMPLES_PER_PREDICTOR = 10
STATISTICAL_MINIMUM = ESTIMATED_PREDICTORS_COUNT * SAMPLES_PER_PREDICTOR
TRAINING_WINDOW_MONTHS = 6

# =========================================================
# HELPER FUNCTIONS
# =========================================================
def convert_to_months(age, unit):
    if unit == 'weeks':
        return age / 4
    elif unit == 'years':
        return age * 12
    return age

def fetch_adopted_pets(window_months=6):
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

# =========================================================
# PLOTTING FUNCTIONS
# =========================================================
def create_data_overview_plots(available_pets, adopted_pets):
    fig, axes = plt.subplots(2, 3, figsize=(18, 12))
    date_str = datetime.now().strftime("%Y-%m-%d")
    fig.suptitle(f'Pet Adoption Data Overview\nDate: {date_str}', fontsize=16, fontweight='bold')
    
    # Age Distribution
    axes[0, 0].hist(available_pets['age_months'], alpha=0.7, label='Available', bins=30, color='skyblue')
    axes[0, 0].hist(adopted_pets['age_months'], alpha=0.7, label='Adopted', bins=30, color='salmon')
    axes[0, 0].set_title('Age Distribution Comparison')
    axes[0, 0].legend()
    axes[0, 0].grid(True, alpha=0.3)

    # Species Distribution
    species_available = available_pets['species'].value_counts()
    species_adopted = adopted_pets['species'].value_counts()
    pd.DataFrame({'Available': species_available, 'Adopted': species_adopted}).fillna(0).plot(
        kind='bar', ax=axes[0, 1], color=['skyblue', 'salmon'])
    axes[0, 1].set_title('Species Distribution')

    # Sex Distribution
    sex_available = available_pets['sex'].value_counts()
    sex_adopted = adopted_pets['sex'].value_counts()
    pd.DataFrame({'Available': sex_available, 'Adopted': sex_adopted}).fillna(0).plot(
        kind='bar', ax=axes[0, 2], color=['skyblue', 'salmon'])
    axes[0, 2].set_title('Sex Distribution')

    # Age Group Heatmap
    if len(adopted_pets) > 0:
        adopted_pets_binned = adopted_pets.copy()
        adopted_pets_binned['age_group'] = pd.cut(adopted_pets_binned['age_months'],
                                                  bins=5, labels=['Very Young', 'Young', 'Adult', 'Mature', 'Senior'])
        heatmap_data = pd.crosstab(adopted_pets_binned['age_group'], adopted_pets_binned['species'])
        sns.heatmap(heatmap_data, annot=True, fmt='d', ax=axes[1, 0], cmap='YlOrRd')
        axes[1, 0].set_title('Adopted Pets: Age Group vs Species')

    # Adoption Timeline
    if len(adopted_pets) > 0 and 'adoption_date' in adopted_pets.columns:
        adopted_pets['adoption_month'] = pd.to_datetime(adopted_pets['adoption_date']).dt.to_period('M')
        timeline = adopted_pets['adoption_month'].value_counts().sort_index()
        timeline.plot(kind='line', ax=axes[1, 1], marker='o', color='green')
        axes[1, 1].set_title('Adoption Timeline')
        axes[1, 1].grid(True, alpha=0.3)

    # Summary Table
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
    }, index=['Count', 'Mean Age', 'Median Age', 'Std Dev Age'])
    axes[1, 2].axis('off')
    axes[1, 2].table(cellText=summary_stats.values,
                     rowLabels=summary_stats.index,
                     colLabels=summary_stats.columns,
                     cellLoc='center',
                     loc='center')
    
    plt.tight_layout()
    filepath = os.path.join(CHARTS_DIR, "data_overview.png")
    plt.savefig(filepath, dpi=300, bbox_inches='tight')
    plt.close(fig)
    print(f"Saved: {filepath}")

def create_ml_performance_plots(model, X, y):
    fig, axes = plt.subplots(2, 2, figsize=(15, 12))
    date_str = datetime.now().strftime("%Y-%m-%d")
    fig.suptitle(f'Machine Learning Model Performance\nDate: {date_str}', fontsize=16, fontweight='bold')

    y_proba = model.predict_proba(X)[:, 1]
    fpr, tpr, _ = roc_curve(y, y_proba)
    auc_score = roc_auc_score(y, y_proba)
    axes[0, 0].plot(fpr, tpr, label=f"AUC={auc_score:.3f}", color="darkorange")
    axes[0, 0].plot([0, 1], [0, 1], linestyle="--")
    axes[0, 0].set_title("ROC Curve")
    axes[0, 0].legend()

    y_pred_proba = model.predict_proba(X)[:, 1]
    axes[0, 1].hist(y_pred_proba[y == 0], bins=30, alpha=0.7, label='Available', color='skyblue')
    axes[0, 1].hist(y_pred_proba[y == 1], bins=30, alpha=0.7, label='Adopted', color='salmon')
    axes[0, 1].set_title('Predicted Probability Distribution')
    axes[0, 1].legend()

    cm = confusion_matrix(y, model.predict(X))
    sns.heatmap(cm, annot=True, fmt='d', cmap='Blues', ax=axes[1, 0])
    axes[1, 0].set_title('Confusion Matrix')

    if hasattr(model.named_steps['classifier'], 'coef_'):
        feature_names = model.named_steps['preprocessor'].get_feature_names_out()
        coef = model.named_steps['classifier'].coef_[0]
        fi = pd.DataFrame({'Feature': feature_names, 'Coef': coef}).sort_values('Coef')
        axes[1, 1].barh(fi['Feature'], fi['Coef'], color='teal')
        axes[1, 1].set_title('Feature Coefficients')

    plt.tight_layout()
    filepath = os.path.join(CHARTS_DIR, "ml_performance.png")
    plt.savefig(filepath, dpi=300, bbox_inches='tight')
    plt.close(fig)
    print(f"Saved: {filepath}")

def create_featured_pets_analysis(featured_pets_data, available_pets, strategy_used):
    if len(featured_pets_data) == 0:
        return
    featured_with_details = featured_pets_data.merge(
        available_pets[['id', 'age_months', 'species', 'sex']],
        left_on='pet_id', right_on='id', how='left'
    )
    fig, axes = plt.subplots(2, 2, figsize=(15, 12))
    date_str = datetime.now().strftime("%Y-%m-%d")
    fig.suptitle(f'Featured Pets Analysis - {strategy_used}\nDate: {date_str}', fontsize=16, fontweight='bold')

    axes[0, 0].hist(featured_pets_data['adoption_probability'], bins=20, color='lightcoral')
    axes[0, 0].set_title('Adoption Probability Distribution')

    species_counts = featured_with_details['species'].value_counts()
    axes[0, 1].pie(species_counts, labels=species_counts.index, autopct='%1.1f%%')
    axes[0, 1].set_title('Species Distribution')

    axes[1, 0].hist(available_pets['age_months'], bins=30, alpha=0.5, label='Available', color='skyblue', density=True)
    axes[1, 0].hist(featured_with_details['age_months'], bins=20, alpha=0.7, label='Featured', color='red', density=True)
    axes[1, 0].legend()
    axes[1, 0].set_title('Age Distribution')

    top_pets = featured_with_details.head(10)[['pet_id', 'adoption_probability', 'age_months', 'species', 'sex']]
    axes[1, 1].axis('off')
    table = axes[1, 1].table(cellText=top_pets.values,
                             colLabels=top_pets.columns,
                             cellLoc='center',
                             loc='center')
    table.scale(1.2, 1.5)

    plt.tight_layout()
    filepath = os.path.join(CHARTS_DIR, "featured_pets_analysis.png")
    plt.savefig(filepath, dpi=300, bbox_inches='tight')
    plt.close(fig)
    print(f"Saved: {filepath}")

# =========================================================
# MAIN LOGIC
# =========================================================
print("\n1. CLEARING EXISTING FEATURED PETS...")
with db_connection.begin() as conn:
    conn.exec_driver_sql("DELETE FROM featured_pets")
print("SUCCESS: Cleared featured_pets table")

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

print(f"\n3. FETCHING ADOPTION DATA ({TRAINING_WINDOW_MONTHS}-Month Window)...")
adopted_pets = fetch_adopted_pets(TRAINING_WINDOW_MONTHS)
print(f"Found {len(adopted_pets)} adopted pets.")

for df in [available_pets, adopted_pets]:
    df['age_months'] = df.apply(lambda x: convert_to_months(x['age'], x['age_unit']), axis=1)
    df['age_months'] = df['age_months'].clip(lower=0.25)

print("\n4. GENERATING OVERVIEW PLOTS...")
create_data_overview_plots(available_pets, adopted_pets)

sex_count = len(pd.unique(pd.concat([available_pets['sex'], adopted_pets['sex']])))
species_count = len(pd.unique(pd.concat([available_pets['species'], adopted_pets['species']])))
actual_predictors_count = 1 + sex_count + species_count
actual_statistical_minimum = actual_predictors_count * SAMPLES_PER_PREDICTOR

if len(adopted_pets) < actual_statistical_minimum:
    print("\nUSING FALLBACK STRATEGY...")
    age_threshold = available_pets['age_months'].quantile(0.75)
    featured_pets_selection = available_pets[available_pets['age_months'] >= age_threshold].copy()
    featured_pets_data = pd.DataFrame({
        'pet_id': featured_pets_selection['id'],
        'adoption_probability': 0.1
    })
    strategy_used = "Fallback (Oldest Pets)"
else:
    print("\nUSING MACHINE LEARNING STRATEGY...")
    adopted_pets['log_age_months'] = np.log1p(adopted_pets['age_months'])
    available_pets['log_age_months'] = np.log1p(available_pets['age_months'])
    adopted_pets['was_adopted'] = 1
    available_pets['was_adopted'] = 0
    full_data = pd.concat([adopted_pets, available_pets], ignore_index=True)

    features = ['log_age_months', 'sex', 'species']
    X = full_data[features]
    y = full_data['was_adopted']

    preprocessor = ColumnTransformer([
        ('num', RobustScaler(), ['log_age_months']),
        ('cat', OneHotEncoder(handle_unknown='ignore'), ['sex', 'species'])
    ])

    model = Pipeline([
        ('preprocessor', preprocessor),
        ('classifier', LogisticRegression(max_iter=1000, random_state=42))
    ])
    model.fit(X, y)
    create_ml_performance_plots(model, X, y)

    available_pets['adoption_probability'] = model.predict_proba(available_pets[features])[:, 1]
    prob_threshold = available_pets['adoption_probability'].quantile(0.25)
    featured_pets_selection = available_pets[available_pets['adoption_probability'] <= prob_threshold]
    featured_pets_data = featured_pets_selection[['id', 'adoption_probability']].rename(columns={'id': 'pet_id'})
    strategy_used = "Machine Learning"

print(f"\n8. FEATURED PETS ANALYSIS ({strategy_used})...")
create_featured_pets_analysis(featured_pets_data, available_pets, strategy_used)

print("\n9. SAVING FEATURED PETS TO DATABASE...")
featured_pets_data.to_sql('featured_pets', db_connection, if_exists='append', index=False)
print(f"SUCCESS: Saved {len(featured_pets_data)} pets to featured_pets table")

print(f"\nSCRIPT COMPLETED SUCCESSFULLY at {datetime.now()}")
print(f"Charts saved in: {CHARTS_DIR}")

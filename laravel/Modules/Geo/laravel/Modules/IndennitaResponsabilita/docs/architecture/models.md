# Models & Relationships

## 📊 Core Models

### IndennitaResponsabilita (Main Model)
```php
class IndennitaResponsabilita extends BaseModel
{
    protected $fillable = [
        'ente', 'matr', 'anno', 'dal', 'al',
        'posizione_lavoro', 'complessita', 'coordinamento', 'responsabilita',
        'tot', 'valore_economico_calcolato', 'valore_economico_attribuito'
    ];

    protected function casts(): array
    {
        return [
            'dal' => 'date',
            'al' => 'date',
            'complessita' => 'integer',
            'coordinamento' => 'integer',
            'responsabilita' => 'integer',
        ];
    }

    // Relationships
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'matr', 'matr');
    }
}
```

### Supporting Models

#### LettF (Formal Letters)
- **Purpose**: Formal communications for responsibility allowances
- **Fields**: Personal data, evaluation results, calculated amounts
- **Relationships**: Belongs to IndennitaResponsabilita

#### LettI (Internal Letters)
- **Purpose**: Internal communications with additional fields
- **Fields**: All LettF fields + additional internal fields
- **Relationships**: Belongs to IndennitaResponsabilita

#### Rating (Evaluation Scores)
- **Purpose**: Polymorphic rating system
- **Fields**: value, type, comment, evaluator
- **Relationships**: Morphs to various models

#### StabiDirigente (Manager Facilities)
- **Purpose**: Directory of management facilities
- **Fields**: Facility data, management assignments
- **Relationships**: Has many IndennitaResponsabilita

#### ImportiCategoria (Category Amounts)
- **Purpose**: Amount configuration by category
- **Fields**: Category, min/max amounts, ente, anno
- **Relationships**: Referenced by calculation logic

## 🔗 Relationship Diagram

```
IndennitaResponsabilita
├── ratings (HasMany) → Rating
├── user (BelongsTo) → User
├── lett_f (HasOne) → LettF
├── lett_i (HasOne) → LettI
└── stabi_dirigente (BelongsTo) → StabiDirigente

Rating (Polymorphic)
├── rateable (MorphTo) → Various models
└── evaluator (BelongsTo) → User

StabiDirigente
└── indennita_records (HasMany) → IndennitaResponsabilita

ImportiCategoria
└── referenced by calculation logic
```

## 🧮 Business Logic Calculations

### Responsibility Score Calculation
```php
// Automatic calculation in model
protected static function boot()
{
    parent::boot();

    static::saving(function ($model) {
        $model->tot = $model->complessita + $model->coordinamento + $model->responsabilita;
        $model->valore_economico_calcolato = self::calculateEconomicValue($model->tot);
    });
}

private static function calculateEconomicValue(int $total): float
{
    // Complex calculation logic based on ImportiCategoria
    $category = ImportiCategoria::where('categoria', $categoryCode)
        ->where('anno', $currentYear)
        ->first();

    if ($category && $total >= $category->min && $total <= $category->max) {
        return $category->importo_base * ($total / 100);
    }

    return 0.0;
}
```

## 📋 Data Validation Rules

### IndennitaResponsabilita Validation
```php
public static function rules(): array
{
    return [
        'ente' => 'required|integer|min:1',
        'matr' => 'required|string|max:10',
        'anno' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        'dal' => 'required|date',
        'al' => 'required|date|after:dal',
        'posizione_lavoro' => 'required|string|max:1000',
        'complessita' => 'required|integer|min:0|max:40',
        'coordinamento' => 'required|integer|min:0|max:30',
        'responsabilita' => 'required|integer|min:0|max:30',
    ];
}
```

## 🔒 Security & Policies

### Access Control
- **View**: HR managers and supervisors
- **Create/Update**: HR managers only
- **Delete**: Super admins only
- **PDF Generation**: Based on evaluation completion

### Data Protection
- **Encryption**: Sensitive personal data encrypted
- **Audit Trail**: All changes logged via Activity model
- **GDPR Compliance**: Data retention policies applied

## 📊 Database Schema

### Core Tables
- `indennita_responsabilita` - Main evaluation records
- `lett_f` - Formal communication records
- `lett_i` - Internal communication records
- `ratings` - Polymorphic rating system
- `stabi_dirigente` - Management facilities
- `importi_categoria` - Amount categories

### Indexes & Constraints
- Composite indexes on `(ente, anno, matr)`
- Foreign key constraints
- Unique constraints on critical fields
- Full-text indexes on searchable fields

## 🔄 Data Flow

1. **Creation**: User creates evaluation record
2. **Validation**: Business rules validation
3. **Calculation**: Automatic score and amount calculation
4. **Approval**: Multi-level approval workflow
5. **Communication**: Automatic PDF generation and email sending
6. **Archival**: Secure storage with audit trail

---

**See Also**: [Business Logic](business-logic.md) | [Database Schema](database.md) | [API Structure](api.md)

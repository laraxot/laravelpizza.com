# Rating Architecture

## 🏗️ System Design

### Core Components Architecture

#### 1. **Rating Model** - Central Data Entity
```php
<?php

declare(strict_types=1);

namespace Modules\Rating\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

/**
 * Rating valutazione utilizzato in tutti i moduli.
 * 
 * @property int $id
 * @property string $title
 * @property string|null $description  
 * @property string|null $rule
 * @property bool $is_readonly
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property array $extra_attributes
 */
class Rating extends Model
{
    protected $connection = 'rating'; // Connessione dedicata
    
    protected $table = 'ratings';
    
    protected $fillable = [
        'title',
        'description',
        'rule',
        'is_readonly',
        'extra_attributes',
    ];
    
    protected $casts = [
        'is_readonly' => 'boolean',
        'extra_attributes' => SchemalessAttributes::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'is_readonly' => 'boolean',
            'extra_attributes' => SchemalessAttributes::class,
        ]);
    }
}
```

#### 2. **HasRatingsTrait** - Shared Business Logic
```php
<?php

declare(strict_types=1);

namespace Modules\Rating\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

/**
 * Trait per aggiungere funzionalità di rating a qualsiasi modello.
 */
trait HasRatingsTrait
{
    /**
     * Get the rating model class.
     *
     * @return string
     */
    protected function getRatingClass(): string
    {
        $rating_class = Str::of(static::class)
            ->before('\Models\\')
            ->append('\Models\Rating')
            ->toString();
        
        return $rating_class;
    }
    
    /**
     * Sync ratings for this record with given criteria.
     *
     * @param array<string, mixed> $criteria
     * @return Collection
     */
    public function syncRatingsWhere(array $criteria): Collection
    {
        $rating_class = $this->getRatingClass();
        
        // Get existing ratings for this record type
        $ratings = $this->ratings()
            ->wherePivot('extra_attributes', $criteria)
            ->get();
        
        // Sync ratings for this specific record
        return $this->ratings()
            ->wherePivot('extra_attributes', array_merge($criteria, [
                'ratable_id' => $this->getKey(),
                'ratable_type' => static::class,
            ]))
            ->get();
    }
    
    /**
     * Get ratings filtered by criteria from database directly.
     *
     * @param array<string, mixed> $criteria
     * @return Collection
     */
    public function getRatingsWhere(array $criteria): Collection
    {
        $rating_class = $this->getRatingClass();
        
        return $rating_class::whereHas('ratable', function (Builder $query): void {
            $query->where('ratable_id', $this->getKey())
                   ->where('ratable_type', static::class);
        })->wherePivot('extra_attributes', $criteria)->get();
    }
    
    /**
     * Get validation rules from ratings.
     *
     * @param string $prefix
     * @param string $suffix
     * @return array<string, string>
     */
    public function getRatingsRules(string $prefix = '', string $suffix = ''): array
    {
        $ratings = $this->getRatingsWhere(['anno' => $this->anno ?? now()->year]);
        
        $rules = [];
        foreach ($ratings as $rating) {
            if ($rating->rule) {
                $rules[$prefix . $rating->id . $suffix] = $rating->rule;
            }
        }
        
        return $rules;
    }
    
    /**
     * Get validation attributes for forms.
     *
     * @param string $prefix  
     * @param string $suffix
     * @return array<string, string>
     */
    public function getRatingsValidationAttributes(string $prefix = '', string $suffix = ''): array
    {
        $ratings = $this->getRatingsWhere(['anno' => $this->anno ?? now()->year]);
        
        $attributes = [];
        foreach ($ratings as $rating) {
            $attributes[$prefix . $rating->id . $suffix . '.label'] = $rating->title;
        }
        
        return $attributes;
    }
}
```

### 3. **RuleEnum** - Validation Rules Standardization
```php
<?php

declare(strict_types=1);

namespace Modules\Rating\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Regole di validazione predefinite per campi rating.
 */
enum RuleEnum: string implements HasLabel
{
    // Campi numerici 0-5 punti (autonomia, responsabilità)
    case ZeroFive = 'numeric|min:0|max:5';
    
    // Campi numerici 0-25 punti (totali)
    case NullableNumericMin0Max25 = 'nullable|numeric|min:0|max:25';
    
    // Campi percentuali 0-100
    case ZeroOneHundred = 'numeric|min:0|max:100';
    
    // Campi decimali valute (0-999.99)
    case NullableDecimalMin0Max99999 = 'nullable|decimal|min:0|max:999.99';
    
    // Campi booleani
    case NullableBoolean = 'nullable|boolean';
    
    // Campi testo
    case NullableStringMax255 = 'nullable|string|max:255';
    
    // Campi data
    case NullableDate = 'nullable|date';
    
    // Regola problematica
    case ZeroOrMin4Max25 = 'min:0|max:25|not_in:1,2,3'; // ⚠️ EVITARE
    
    public function getLabel(): string
    {
        return match($this) {
            static::ZeroFive => 'Punteggio da 0 a 5 punti',
            static::NullableNumericMin0Max25 => 'Valore da 0 a 25 punti',
            static::ZeroOneHundred => 'Percentuale da 0 a 100',
            static::NullableDecimalMin0Max99999 => 'Importo da 0 a 999.99',
            static::NullableBoolean => 'Campo booleano',
            static::NullableStringMax255 => 'Testo fino a 255 caratteri',
            static::NullableDate => 'Data opzionale',
            static::ZeroOrMin4Max25 => 'Totale punti (no 1,2,3)', // ⚠️ Legacy
            default => 'Regola di validazione',
        };
    }
}
```

---

## 🔄 Integration Patterns

### Cross-Module Communication Architecture

#### Publisher-Subscriber Pattern
```php
// Rating module pubblica eventi che altri moduli possono ascoltare
RatingCreated::dispatch($rating);
RatingUpdated::dispatch($rating, $oldValue, $newValue);

// In altri moduli
#[Subscribe(RatingCreated::class)]
public function handleRatingCreated(RatingCreated $event): void
{
    // Processare nuovo rating
    if ($event->rating->title === 'Performance Review') {
        // Logica specifica per performance
        $this->createPerformanceMetrics($event->rating);
    }
}
```

#### Service Locator Pattern
```php
// Centralizzazione dei servizi rating
interface RatingServiceInterface
{
    public function calculateRatingScore(Model $model, array $criteria): float;
    public function validateRatingData(array $data): array;
}

// Implementazione specifica modulo
class IndennitaRatingService implements RatingServiceInterface
{
    public function calculateRatingScore(Model $model, array $criteria): float
    {
        // Logica specifica indennità responsabilità
        $baseScore = $model->getRatingScore($criteria);
        
        // Applica coefficienti modulo
        return $baseScore * ($model->coefficente_calcolo ?? 1.0);
    }
}
```

---

## 🗄️ Database Optimization

### Schema Design Principles

1. **Connection Separation**: Ogni modulo usa la sua connessione dedicata
2. **Index Strategy**: Indici composti per performance ottimale
3. **Schemaless Attributes**: Dati dinamici gestiti con Spatie package

### Migration Pattern
```php
return new class extends XotBaseMigration
{
    protected ?string $model_class = Rating::class;
    
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('rule', 255)->nullable();
            $table->boolean('is_readonly')->default(false);
            $table->schemalessAttributes('extra_attributes');
            
            // Indici per performance
            $table->index(['anno', 'title']);
            $table->index(['is_readonly']);
            
            $this->updateUser($table);
            $this->updateTimestamps($table);
        });
    }
}
```

---

## 🧪 Testing Architecture

### Unit Testing Strategy
```php
// Test dei trait methods
test('hasratings trait sync methods work correctly', function () {
    $model = TestModel::factory()->create(['anno' => 2024]);
    
    $ratings = $model->syncRatingsWhere(['anno' => 2024]);
    expect($ratings)->toHaveCount(3);
    
    $rules = $model->getRatingsRules();
    expect($rules)->toBeArray();
});

// Test validazione regole
test('ruleenum provides correct validation rules', function () {
    expect(RuleEnum::ZeroFive->value)->toBe('numeric|min:0|max:5');
    expect(RuleEnum::NullableNumericMin0Max25->value)->toBe('nullable|numeric|min:0|max:25');
});

// Test architettura modulare
test('cross-module rating integration', function () {
    $indennitaModel = IndennitaResponsabilita::factory()->create();
    $performanceModel = Performance::factory()->create();
    
    // Entrambi possono usare lo stesso trait con configurazioni diverse
    expect($indennitaModel->syncRatingsWhere(['anno' => 2024]))->toHaveCount(5);
    expect($performanceModel->syncRatingsWhere(['anno' => 2024]))->toHaveCount(7);
});
```

---

## 🚀 Performance Patterns

### Query Optimization
```php
// ✅ EVITARE N+1 QUERIES
$ratings = $model->ratings()->with('pivot')->get();

// ✅ INDICI COMPOSTI
$table->index(['anno', 'title', 'is_readonly']);

// ✅ WHERE CONDIZIONI OTTIMIZZATE
Rating::where('extra_attributes->anno', $anno)
    ->where('extra_attributes->type', 'performance')
    ->where('extra_attributes->is_active', true)
    ->get();

// ✅ LIMITARE RISULTATI
$ratings = Rating::wherePivot('extra_attributes->anno', $anno)
    ->limit(50)
    ->get();
```

---

## 📋 Quality Assurance

### Code Quality Standards
- **PHPStan Level 10**: Obbligatorio per tutto il codice
- **Laravel Pint**: Code formatting automatico
- **Pest Testing**: 100% coverage per nuove funzionalità
- **Type Safety**: Strict typing in tutti i metodi

### Documentation Standards
- **PHPDoc Completo**: Ogni metodo e classe documentata
- **Esempi Pratici**: Code examples per ogni pattern
- **Cross-Reference**: Link interni tra documentazione

---

## 🔗 External Dependencies

### Required Packages
```json
{
    "require": {
        "spatie/laravel-schemaless-attributes": "^3.0",
        "laravel/framework": "^12.0",
        "filament/filament": "^5.0"
    }
}
```

### Optional Integrations
```json
{
    "suggest": {
        "spatie/laravel-activitylog": "Per audit trail",
        "laravel/horizon": "Per performance monitoring"
    }
}
```

---

## 📖 Documentation Navigation

1. **[Quick Start](#quick-start)** - Setup rapido
2. **[Architecture](#architecture)** - Design del sistema  
3. **[Integration](#integration-patterns)** - Comunicazione moduli
4. **[Database](#database-optimization)** - Schema e query
5. **[Testing](#testing-architecture)** - Strategie di test
6. **[Performance](#performance-patterns)** - Ottimizzazioni
7. **[API Reference](#api-reference)** - Dettagli metodi

---

**Autore**: PTVX Development Team  
**Versione**: 2.0.0  
**Ultimo aggiornamento**: 2024-02-11
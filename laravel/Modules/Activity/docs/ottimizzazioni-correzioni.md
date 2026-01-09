# Activity Module - Ottimizzazioni e Correzioni

## Panoramica
Il modulo Activity gestisce il logging delle attività utilizzando Spatie Activity Log e Event Sourcing. L'analisi rivela diverse aree di miglioramento.

## 🔧 Ottimizzazioni Tecniche

### 1. Struttura Codebase
**Problemi identificati:**
- Presenza di numerose duplicazioni nei documenti (`*-duplicate.md`)
- Directory `.git` annidata che potrebbe causare confusione
- Struttura di test duplicata (`tests/tests/`)

**Correzioni consigliate:**
```bash
# Rimuovere file duplicati
rm -rf Modules/Activity/docs/archive/duplicates/
rm -f Modules/Activity/docs/*-duplicate.md

# Pulire directory test duplicata
rm -rf Modules/Activity/tests/tests/

# Considerare rimozione .git locale se non necessario
```

### 2. Composer.json
**Problemi identificati:**
- Dipendenze con versione `*` (non specifiche)
- Repositories commentate ma non utilizzate

**Correzioni consigliate:**
```json
{
    "require": {
        "spatie/laravel-activitylog": "^4.8",
        "spatie/laravel-event-sourcing": "^7.3"
    }
}
```

### 3. Model Activity
**Problemi identificati:**
- Connessione database hardcoded (`$connection = 'activity'`)
- Fillable include `id` (security risk)
- Mancanza di casts per JSON properties

**Correzioni consigliate:**
```php
class Activity extends SpatieActivity
{
    protected $connection = null; // Usa default o config

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
    ]; // Rimuovere 'id', 'created_at', 'updated_at'

    protected function casts(): array
    {
        return [
            'properties' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
```

### 4. Filament Resource
**Problemi identificati:**
- Form schema restituisce array invece di Form
- Mancanza di validazione avanzata
- Non utilizza relationship() per subject/causer

**Correzioni consigliate:**
```php
use Filament\Forms\Form;
use Filament\Forms\Components\Select;

public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('log_name')->required()->maxLength(255),
        TextInput::make('description')->required()->maxLength(255),

        Select::make('subject_type')
            ->options([
                // Dynamically load available models
            ])
            ->required(),

        TextInput::make('subject_id')
            ->numeric()
            ->required(),

        // Use relationship selects where possible
    ]);
}
```

## 🚀 Performance

### 1. Database
**Ottimizzazioni consigliate:**
- Aggiungere indici per query frequenti:
```sql
ALTER TABLE activity_log ADD INDEX idx_subject (subject_type, subject_id);
ALTER TABLE activity_log ADD INDEX idx_causer (causer_type, causer_id);
ALTER TABLE activity_log ADD INDEX idx_log_name_created (log_name, created_at);
```

### 2. Query Optimization
- Implementare scope per query comuni
- Usare eager loading per relazioni subject/causer

```php
// Nel model Activity
public function scopeForModel($query, $model)
{
    return $query->where('subject_type', get_class($model))
                 ->where('subject_id', $model->getKey());
}

public function scopeByUser($query, $user)
{
    return $query->where('causer_type', get_class($user))
                 ->where('causer_id', $user->getKey());
}
```

## 🧪 Testing

### 1. Coverage
**Problemi identificati:**
- 18 file di test ma copertura non verificata
- Test duplicati per business logic

**Correzioni consigliate:**
- Consolidare test di business logic
- Aggiungere coverage reporting
- Implementare test di integrazione per Event Sourcing

### 2. Factory
**Miglioramenti:**
```php
// ActivityFactory
public function definition(): array
{
    return [
        'log_name' => $this->faker->word(),
        'description' => $this->faker->sentence(),
        'subject_type' => User::class,
        'subject_id' => User::factory(),
        'causer_type' => User::class,
        'causer_id' => User::factory(),
        'properties' => [],
    ];
}
```

## 📚 Documentazione

### 1. Cleanup
**Azioni immediate:**
- Rimuovere tutti i file duplicati (21+ file identificati)
- Consolidare documentazione in categorie logiche
- Standardizzare formato markdown

### 2. Struttura consigliata:
```
docs/
├── README.md (overview principale)
├── installation.md
├── configuration.md
├── usage.md
├── api/
│   ├── events.md
│   ├── models.md
│   └── resources.md
├── examples/
│   ├── basic-usage.md
│   └── advanced-patterns.md
└── troubleshooting.md
```

## 🔐 Sicurezza

### 1. Validazione
- Sanitizzare input nei form Filament
- Validare JSON properties structure
- Implementare policy per accesso activity log

### 2. Privacy
- Implementare data retention policies
- Mascherare dati sensibili in properties
- Audit trail per modifiche ai log

## 📦 Architettura

### 1. Service Layer
**Consiglio:** Introdurre ActivityService per logica business
```php
class ActivityService
{
    public function logActivity(
        string $logName,
        string $description,
        $subject,
        $causer = null,
        array $properties = []
    ): Activity {
        // Centralized activity logging logic
    }
}
```

### 2. Event Sourcing
- Separare eventi di dominio da activity log
- Implementare projection consistency checks
- Aggiungere replay capabilities

## 🎯 Priorità

### Alta Priorità
1. ✅ Rimuovere duplicazioni documentazione
2. ✅ Fix security issues in model
3. ✅ Specificare versioni dipendenze

### Media Priorità
1. Ottimizzare queries database
2. Migliorare form Filament
3. Consolidare test structure

### Bassa Priorità
1. Refactoring architettura
2. Advanced event sourcing patterns
3. Performance monitoring

## 💡 Conclusioni

Il modulo Activity è funzionale ma necessita di pulizia e ottimizzazioni. Le correzioni prioritarie riguardano sicurezza e pulizia codebase, mentre le ottimizzazioni performance possono essere implementate gradualmente.

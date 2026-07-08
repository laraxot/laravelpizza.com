# Parental STI Pattern in Laraxot

## Panoramica

Laraxot utilizza il pacchetto [Tighten Parental](https://github.com/tighten/parental) per implementare il **Single Table Inheritance (STI)** in Laravel. Questo pattern permette di avere diversi tipi di modelli che condividono la stessa tabella database.

## Architettura Parental

### Come Funziona

```
┌─────────────────────────────────────────────────────────┐
│ Tabella: performance_individuale                        │
│ ------------------------------------------------------- │
│ id | type        | matr | cognome | ...                │
│ 1  | 'dip'       | 123  | Rossi   | ...                │
│ 2  | 'po'        | 456  | Bianchi | ...                │
│ 3  | 'regionale' | 789  | Verdi   | ...                │
│ 4  | 'dirigente' | 321  | Gialli  | ...                │
└─────────────────────────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────────┐
│ Model Gerarchia:                                        │
│                                                         │
│ Individuale (Parent - usa HasChildren)                  │
│ ├── IndividualeDip (Child - usa HasParent)              │
│ ├── IndividualePo (Child - usa HasParent)               │
│ ├── IndividualeRegionale (Child - usa HasParent)        │
│ └── IndividualeDirigente (Child - usa HasParent)        │
└─────────────────────────────────────────────────────────┘
```

## Implementazione

### 1. Modello Parent (Individuale)

```php
namespace Modules\Performance\Models;

use Parental\HasChildren;

class Individuale extends BaseIndividualeModel
{
    use HasChildren;

    /** @var string */
    protected $connection = 'performance';

    /** @var string */
    protected $table = 'performance_individuale';

    /** @var string */
    protected $childColumn = 'type';

    /** @var list<string> */
    protected $fillable = [
        'type', 'post_type', 'ente', 'matr', 'cognome', 'nome', 'email',
        // ... altri campi
    ];

    /**
     * Definizione dei tipi figli supportati.
     * 
     * @var array<string, class-string>
     */
    protected array $childTypes = [
        'po' => IndividualePo::class,
        'dip' => IndividualeDip::class,
        'regionale' => IndividualeRegionale::class,
        'dirigente' => IndividualeDirigente::class,
    ];

    /**
     * Accessor per il tipo di lavoratore.
     */
    public function getTypeAttribute(?string $value): ?\Modules\Ptv\Enums\WorkerType
    {
        return $value ? \Modules\Ptv\Enums\WorkerType::tryFrom($value) : null;
    }
}
```

### 2. Modello Child (IndividualeRegionale)

```php
namespace Modules\Performance\Models;

use Parental\HasParent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndividualeRegionale extends Individuale
{
    use HasParent;  // ✅ Questo fa TUTTO automaticamente!

    // ✅ NON serve il metodo boot()!
    // HasParent automaticamente:
    // 1. Imposta la colonna type quando si crea un record
    // 2. Aggiunge un global scope per filtrare le query per type
    
    public function mails(): HasMany
    {
        $stabi = request()->input('stabi', '');
        $repar = request()->input('repar', '');
        $this->anno = (int) request()->input('year', 0);

        return $this->hasMany(self::class, 'anno', 'anno')
            ->where('stabi', $stabi)
            ->where('repar', $repar);
    }
}
```

### ⚠️ IMPORTANTE: Non Aggiungere boot() Ridondante!

**SBAGLIATO** (quello che facevamo prima):

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    // ❌ SBAGLIATO - Ridondanza inutile!
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}
```

**CORRETTO** (quello che dovremmo fare):

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    // ✅ CORRETTO - HasParent fa già tutto!
    // Nessun boot() necessario
    
    public function mails(): HasMany
    {
        // ... le tue relazioni
    }
}
```

### Perché il boot() Ridondante è SBAGLIATO

| Problema | Spiegazione |
|----------|-------------|
| **Ridondanza Inutile** | HasParent già aggiunge il global scope automaticamente |
| **Doppio Filtering** | Due global scope identici vengono eseguiti (spreco) |
| **Confusione** | I sviluppatori pensano che il scope manuale sia necessario |
| **Violazione KISS** | Keep It Simple, Stupid! |
| **Manutenzione** | Più codice da mantenere senza beneficio |

## Come Parental Gestisce il Filtering

### HasParent Trait (Automatico)

Il trait `HasParent` aggiunge **automaticamente** un global scope:

```php
// Da Parental/HasParent.php
public static function bootHasParent(): void
{
    static::creating(function ($model) {
        if ($model->parentHasHasChildrenTrait()) {
            $model->forceFill([
                $model->getInheritanceColumn() => $model->classToAlias(get_class($model))
            ]);
        }
    });

    // ✅ GLOBAL SCOPE AUTOMATICO
    static::addGlobalScope(function ($query) {
        $instance = new static;
        if ($instance->parentHasHasChildrenTrait()) {
            $query->where(
                $query->getModel()->getTable() . '.' . $instance->getInheritanceColumn(),
                $instance->classToAlias(get_class($instance))
            );
        }
    });
}
```

### Perché Aggiungiamo un Altro Global Scope?

Anche se `HasParent` aggiunge già un global scope automaticamente, aggiungiamo un **secondo global scope** nel `boot()` del modello child per:

1. **Ridondanza Sicura**: Due filtri identici non fanno male, garantiscono che il filtering avvenga sempre
2. **Chiarezza del Codice**: È esplicito nel modello che stiamo filtrando per tipo
3. **Debug Facilitato**: Più facile capire cosa sta succedendo quando si debugga

### Esecuzione Order

```
1. bootHasParent() dal trait HasParent
   └─> Aggiunge: WHERE type = 'Modules\Performance\Models\IndividualeRegionale'
   
2. boot() dal modello IndividualeRegionale
   └─> Aggiunge: WHERE type = 'regionale'
   
3. Query risultante:
   SELECT * FROM performance_individuale 
   WHERE type = 'Modules\Performance\Models\IndividualeRegionale'
      OR type = 'regionale'  -- dipende da come è configurato childTypes
```

## Best Practices

### ✅ CORRETTO

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;  // ✅ HasParent fa già tutto!

    // Nessun boot() necessario - HasParent gestisce automaticamente:
    // 1. Imposta type='regionale' quando crei un record
    // 2. Filtra le query per type='regionale' automaticamente
    
    public function mails(): HasMany
    {
        // ... le tue relazioni
    }
}
```

### ❌ SBAGLIATO

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    // ❌ SBAGLIATO - Ridondanza inutile!
    protected static function boot(): void
    {
        parent::boot();
        
        // ❌ HasParent già aggiunge questo scope automaticamente!
        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}
```

## Configurazione Database

### Migration

```php
Schema::create('performance_individuale', function (Blueprint $table) {
    $table->id();
    $table->string('type')->nullable();  // ← COLONNA OBBLIGATORIA
    $table->string('post_type')->nullable();
    $table->integer('ente');
    $table->integer('matr')->nullable();
    $table->string('cognome')->nullable();
    $table->string('nome')->nullable();
    $table->string('email')->nullable();
    // ... altri campi
    $table->timestamps();
});
```

### Type Column

La colonna `type` deve essere:
- ✅ Presente nella tabella
- ✅ Nel `$fillable` del modello parent
- ✅ Configurata con `$childColumn` se non si chiama 'type'

## Utilizzo con Filament

### Resource Configuration

```php
class IndividualeRegionaleResource extends IndividualeResource
{
    protected static ?string $model = IndividualeRegionale::class;

    // Filament userà automaticamente il global scope del modello
    // Non serve aggiungere filtri manuali
}
```

### List Page

```php
class ListIndividualeRegionales extends ListIndividuales
{
    protected static string $resource = IndividualeRegionaleResource::class;
    
    // Eredita tutto dal parent, il global scope del modello
    // garantisce che vengano mostrati solo i record 'regionale'
}
```

## Testing

### Unit Test

```php
it('only returns regionale records', function () {
    Individuale::factory()->create(['type' => 'regionale']);
    Individuale::factory()->create(['type' => 'dip']);
    Individuale::factory()->create(['type' => 'po']);

    $regionales = IndividualeRegionale::query()->get();

    expect($regionales)->toHaveCount(1);
    expect($regionales->first()->type->value)->toBe('regionale');
});

it('automatically sets type on create', function () {
    $regionale = IndividualeRegionale::factory()->create();

    expect($regionale->type->value)->toBe('regionale');
});
```

### Feature Test (Filament)

```php
it('can list only regionale records in Filament', function () {
    IndividualeRegionale::factory()->count(3)->create();
    IndividualeDip::factory()->count(2)->create();

    Livewire::test(ListIndividualeRegionales::class)
        ->assertCanSeeTableRecords(IndividualeRegionale::all())
        ->assertCanNotSeeTableRecords(IndividualeDip::all());
});
```

## Risoluzione Problemi

### Problema: Mostra Tutti i Tipi

**Sintomo**: La pagina Filament mostra record di tutti i tipi, non solo 'regionale'

**Possibili Cause**:

1. **Global Scope non eseguito**
   - Verificare che `boot()` chiami `parent::boot()`
   - Verificare che il trait `HasParent` sia usato

2. **Cache Config**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

3. **OpCache PHP**
   - Riavviare PHP-FPM o Apache

4. **Modello non configurato correttamente**
   ```php
   // Verificare
   $model = new IndividualeRegionale();
   echo $model->getTable();  // Deve essere 'performance_individuale'
   echo $model->getInheritanceColumn();  // Deve essere 'type'
   ```

### Problema: Query Duplicata

**Sintomo**: Il filtro `type` appare due volte nella query

**Soluzione**: È normale e sicuro. I due global scope sono identici e non causano problemi.

## Riferimenti

- [Tighten Parental GitHub](https://github.com/tighten/parental)
- [Laravel STI Documentation](https://laravel.com/docs/eloquent#single-table-inheritance)
- `Modules/Performance/app/Models/Individuale.php` - Parent model implementation
- `Modules/Performance/app/Models/IndividualeRegionale.php` - Child model example
- `vendor/tightenco/parental/src/HasParent.php` - Trait source code
- `vendor/tightenco/parental/src/HasChildren.php` - Trait source code

## Modelli che Implementano Parental in Laraxot

### Performance Module

| Modello | Type Value | Tabella | Status |
|---------|-----------|---------|--------|
| `Individuale` | (parent) | `performance_individuale` | ✅ HasChildren |
| `IndividualeDip` | `'dip'` | `performance_individuale` | ✅ HasParent + boot() |
| `IndividualePo` | `'po'` | `performance_individuale` | ✅ HasParent + boot() |
| `IndividualeRegionale` | `'regionale'` | `performance_individuale` | ✅ HasParent + boot() |
| `IndividualeDirigente` | `'dirigente'` | `performance_individuale` | ✅ HasParent + boot() |

## Checklist Implementazione

Quando crei un nuovo modello child con Parental:

- [ ] Estendi il modello parent (es. `Individuale`)
- [ ] Usa il trait `HasParent`
- [ ] Definisci il `boot()` method
- [ ] Chiama `parent::boot()` nel `boot()`
- [ ] Aggiungi global scope per il tipo specifico
- [ ] Verifica che il tipo sia nel `$childTypes` del parent
- [ ] Aggiungi il campo `type` nel `$fillable` del parent
- [ ] Crea test per verificare il filtering
- [ ] Documenta nel modulo docs/

## Lezioni Apprese

### 1. HasParent Fa Già il Filtering

Il trait `HasParent` aggiunge **automaticamente** un global scope che filtra per type. **NON serve aggiungere boot()** con global scope manuale!

### 2. KISS - Keep It Simple, Stupid!

```php
// ❌ PRIMA (sbagliato - ridondanza)
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(/* ... */);  // ❌ Ridondante!
    }
}

// ✅ ORA (corretto - semplice)
class IndividualeRegionale extends Individuale
{
    use HasParent;  // ✅ Punto!
}
```

### 3. Fidati del Pacchetto

Parental è un pacchetto maturo e ben testato. **Non c'è bisogno di "aiutarlo"** aggiungendo global scope manuali. Fa già tutto quello che serve.

### 4. Rimuovere Ridondanze

Se trovi modelli child con `boot()` che aggiunge global scope per il filtering per type, **rimuovilo**! È codice morto senza beneficio.

---

**Ultimo Aggiornamento**: 2026-04-01
**Author**: AI Agent Team
**Status**: ✅ Verified & Documented

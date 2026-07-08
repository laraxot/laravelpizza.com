# Parental Single Table Inheritance (STI) Filtering

Guida completa all'uso di Tighten/Parental per il Single Table Inheritance in Laravel.

## Panoramica

Parental è un pacchetto Tighten che abilita il pattern **Single Table Inheritance (STI)** in Eloquent.

### Architettura

```
┌─────────────────────────────────────────────────────────────┐
│                    performance_individuale                   │
│  ┌────────┬────────┬──────────┬──────────────────────────┐  │
│  │  id    │ type   │  matr    │  ... altri campi ...     │  │
│  ├────────┼────────┼──────────┼──────────────────────────┤  │
│  │   1    │dip     │  123     │  ...                     │  │
│  │   2    │po      │  456     │  ...                     │  │
│  │   3    │regionale│ 789     │  ...                     │  │
│  │   4    │dirigente│ 321     │  ...                     │  │
│  └────────┴────────┴──────────┴──────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                              │
                              │ type column
                              ▼
        ┌─────────────────────────────────────────┐
        │      Parent Model (Individuale)         │
        │  - use HasChildren                      │
        │  - protected $childColumn = 'type'      │
        │  - protected $childTypes = [...]        │
        └─────────────────────────────────────────┘
                              │
              ┌───────────────┼───────────────┐
              │               │               │
              ▼               ▼               ▼
    ┌──────────────┐ ┌──────────────┐ ┌──────────────┐
    │ IndividualeDip│ │IndividualePo │ │Individuale   │
    │              │ │              │ │Regionale     │
    │ use HasParent│ │use HasParent │ │use HasParent │
    │ +boot()      │ │+boot()       │ │+boot()       │
    │ where type=dip││where type=po ││where type=   │
    │              │ │              │ │regionale     │
    └──────────────┘ └──────────────┘ └──────────────┘
```

## Configurazione

### Parent Model (Individuale)

```php
namespace Modules\Performance\Models;

use Parental\HasChildren;

class Individuale extends BaseIndividualeModel
{
    use HasChildren;

    /**
     * Nome della colonna che discrimina i tipi
     */
    protected $childColumn = 'type';

    /**
     * Mappatura dei tipi alle classi child
     */
    protected array $childTypes = [
        'dip' => IndividualeDip::class,
        'po' => IndividualePo::class,
        'regionale' => IndividualeRegionale::class,
        'dirigente' => IndividualeDirigente::class,
    ];
}
```

### Child Models (IndividualeDip, IndividualePo, etc.)

**⚠️ CRITICO**: Ogni child model DEVE aggiungere un global scope per filtrare per tipo!

```php
namespace Modules\Performance\Models;

use Parental\HasParent;
use Illuminate\Database\Eloquent\Builder;

class IndividualeDip extends Individuale
{
    use HasParent;

    /**
     * Boot the model and add global scope to filter by type.
     *
     * This ensures that IndividualeDip only returns records
     * where type = 'dip', as required by Parental STI pattern.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function (Builder $query) {
            $query->where('type', 'dip');
        });
    }
}
```

## Perché il Global Scope è Necessario

### ❌ Problema: Senza Global Scope

```php
// SENZA global scope in IndividualeRegionale
IndividualeRegionale::all();

// Query generata:
SELECT * FROM performance_individuale;
-- Restituisce TUTTI i record (dip, po, regionale, dirigente)!
```

**Risultato**: Il child model usa la tabella del parent, ma **NON filtra** per tipo.

### ✅ Soluzione: Con Global Scope

```php
// CON global scope in IndividualeRegionale
IndividualeRegionale::all();

// Query generata:
SELECT * FROM performance_individuale WHERE type = 'regionale';
-- Restituisce SOLO record con type='regionale' ✓
```

## Come Funziona Parental

### 1. Query dal Parent

```php
Individuale::all();
```

Parental:
1. Esegue: `SELECT * FROM performance_individuale`
2. Per ogni riga, legge il valore della colonna `type`
3. Istantia la classe child corrispondente dal mapping `$childTypes`
4. Restituisce una Collection di oggetti child tipizzati correttamente

### 2. Query dal Child

```php
IndividualeRegionale::all();
```

Senza global scope:
- Esegue: `SELECT * FROM performance_individuale`
- Restituisce **tutti** i record

Con global scope:
- Esegue: `SELECT * FROM performance_individuale WHERE type = 'regionale'`
- Restituisce **solo** i record regionali

### 3. Creazione di Nuovi Record

```php
// Il tipo viene impostato automaticamente!
$regionale = new IndividualeRegionale();
$regionale->matr = 123;
$regionale->save();

// SQL:
INSERT INTO performance_individuale (type, matr, ...) 
VALUES ('regionale', 123, ...);
```

Parental imposta automaticamente `type = 'regionale'` perché sa che stai usando `IndividualeRegionale`.

## Best Practices

### ✅ SEMPRE FARE

1. **Aggiungere global scope in TUTTI i child models**
   ```php
   protected static function boot(): void
   {
       parent::boot();
       static::addGlobalScope(fn ($q) => $q->where('type', 'dip'));
   }
   ```

2. **Usare il valore corretto nel database**
   - Controllare che i valori in `$childTypes` corrispondano ai valori nel DB
   - Esempio: `'regionale'` non `'IndividualeRegionale'`

3. **Estendere sempre dal parent**
   ```php
   class IndividualeRegionale extends Individuale // ✓
   class IndividualeRegionale extends BaseModel    // ❌
   ```

4. **Usare `HasParent` trait in tutti i child**
   ```php
   use HasParent; // ✓
   ```

### ❌ MAI FARE

1. **Dimenticare il global scope**
   ```php
   class IndividualeDip extends Individuale
   {
       use HasParent;
       // ❌ Nessun global scope = restituisce tutti i record!
   }
   ```

2. **Usare `where()` manualmente nelle query**
   ```php
   // ❌ Ridondante se hai già il global scope
   IndividualeRegionale::where('type', 'regionale')->get();
   ```

3. **Modificare la colonna `type` manualmente**
   ```php
   // ❌ Lascia fare a Parental
   $model->type = 'dip';
   ```

## Risoluzione Problemi

### Problema: Child model mostra tutti i record

**Sintomi**: `IndividualeRegionale::all()` restituisce record con type='dip', 'po', etc.

**Causa**: Manca il global scope nel child model.

**Soluzione**:
```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(fn ($q) => $q->where('type', 'regionale'));
    }
}
```

### Problema: type column non viene popolata

**Sintomi**: Nuovi record hanno `type = NULL`

**Causa**: Il child model non usa `HasParent` correttamente.

**Soluzione**: Verificare che il child estenda dal parent e usi `HasParent`:
```php
class IndividualeDip extends Individuale
{
    use HasParent; // ✓
}
```

### Problema: Query con relazioni non filtrano correttamente

**Sintomi**: Le relazioni restituiscono record di tutti i tipi

**Causa**: La relazione usa il parent model invece del child.

**Soluzione**: Specificare il child model nella relazione:
```php
// ❌ Nel parent
public function children()
{
    return $this->hasMany(Individuale::class);
}

// ✅ Nel child
public function siblings()
{
    return $this->hasMany(IndividualeRegionale::class, 'matr', 'matr');
}
```

## File Modificati

Questo fix ha aggiunto il global scope a tutti i child models:

- `Modules/Performance/app/Models/IndividualeRegionale.php`
- `Modules/Performance/app/Models/IndividualeDip.php`
- `Modules/Performance/app/Models/IndividualePo.php`
- `Modules/Performance/app/Models/IndividualeDirigente.php`

## Testing

Verificare che il filtering funzioni correttamente:

```php
// Test IndividualeRegionale
$regionale = IndividualeRegionale::all();
foreach ($regionale as $r) {
    assert($r->type === 'regionale');
}

// Test IndividualeDip
$dip = IndividualeDip::all();
foreach ($dip as $d) {
    assert($d->type === 'dip');
}

// Test IndividualePo
$po = IndividualePo::all();
foreach ($po as $p) {
    assert($p->type === 'po');
}

// Test IndividualeDirigente
$dirigenti = IndividualeDirigente::all();
foreach ($dirigenti as $d) {
    assert($d->type === 'dirigente');
}
```

## Riferimenti

- [Tighten Parental GitHub](https://github.com/tighten/parental)
- [Single Table Inheritance Pattern](https://martinfowler.com/eaaCatalog/singleTableInheritance.html)
- [Laravel Global Scopes](https://laravel.com/docs/eloquent#global-scopes)

## Vedi Anche

- `docs/eloquent-models-property-verification.md` - Per la tipizzazione dei modelli
- `Modules/Performance/docs/parental-sti-pattern.md` - Documentazione specifica del modulo

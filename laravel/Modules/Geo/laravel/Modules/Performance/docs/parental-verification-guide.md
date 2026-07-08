# Parental STI Filtering - Verification Guide

Guida pratica per verificare che il filtro Parental STI funzioni correttamente.

## Obiettivo

Assicurarsi che `http://ptvx.local/performance/admin/individuale-regionales` mostri **SOLO** i record con `type='regionale'`.

---

## Verifica Rapida (5 minuti)

### 1. Verifica il Modello

```bash
cd /var/www/_bases/base_ptvx_fila5/laravel
php artisan tinker
```

```php
// Verifica che il modello esista
use Modules\Performance\Models\IndividualeRegionale;

// Verifica il global scope
IndividualeRegionale::getGlobalScopes();
// Dovresti vedere: [closure@...]

// Verifica che il boot() sia stato chiamato
IndividualeRegionale::getQuery()->toSql();
// Dovresti vedere: SELECT * FROM performance_individuale WHERE "type" = ?
```

### 2. Verifica nel Database

```bash
php artisan tinker
```

```php
// Conta i record regionali
Modules\Performance\Models\IndividualeRegionale::count();
// Risultato: X (solo regionali)

// Conta TUTTI i record
Modules\Performance\Models\Individuale::count();
// Risultato: Y (tutti i tipi, Y > X)

// Verifica che tutti i record restituiti siano regionali
Modules\Performance\Models\IndividualeRegionale::all()->pluck('type')->unique();
// Risultato: ["regionale"]
```

### 3. Verifica nella UI

1. Apri: `http://ptvx.local/performance/admin/individuale-regionales`
2. Controlla la tabella
3. Clicca su "Edit" su un record
4. Verifica che il campo `type` mostri "regionale"

---

## Test Automatici

### Test 1: Child Model Filtering

Crea questo test in `Modules/Performance/tests/Feature/Models/IndividualeRegionaleTest.php`:

```php
<?php

declare(strict_types=1);

use Modules\Performance\Models\IndividualeDip;
use Modules\Performance\Models\IndividualePo;
use Modules\Performance\Models\IndividualeRegionale;

it('filters only regionale records', function (): void {
    // Create test data
    IndividualeRegionale::factory()->count(3)->create(['type' => 'regionale']);
    IndividualeDip::factory()->count(2)->create(['type' => 'dip']);
    IndividualePo::factory()->count(2)->create(['type' => 'po']);

    // Query child model
    $result = IndividualeRegionale::all();

    // Should return only regionale records
    expect($result)->toHaveCount(3);
    expect($result->pluck('type')->unique()->toArray())->toBe(['regionale']);
});

it('creates record with correct type automatically', function (): void {
    $regionale = IndividualeRegionale::factory()->create();

    expect($regionale->type)->toBe('regionale');
});
```

Esegui il test:

```bash
cd /var/www/_bases/base_ptvx_fila5/laravel
./vendor/bin/pest tests/Feature/Models/IndividualeRegionaleTest.php
```

### Test 2: Parent Model Returns All Children

```php
use Modules\Performance\Models\Individuale;

it('parent model returns all child types', function (): void {
    IndividualeRegionale::factory()->create(['type' => 'regionale']);
    IndividualeDip::factory()->create(['type' => 'dip']);
    IndividualePo::factory()->create(['type' => 'po']);

    $result = Individuale::all();

    expect($result)->toHaveCount(3);
    expect($result->where('type', 'regionale')->first())
        ->toBeInstanceOf(IndividualeRegionale::class);
    expect($result->where('type', 'dip')->first())
        ->toBeInstanceOf(IndividualeDip::class);
});
```

---

## Debugging

### Problema: La pagina mostra tutti i record

**Sintomi:** Vedi record con type='dip', 'po', etc. nella pagina dei regionali

**Controlli:**

1. **Verifica il global scope:**
```php
// In tinker
IndividualeRegionale::getGlobalScopes();
// Se vuoto: manca il boot()!
```

2. **Verifica la query SQL:**
```php
// In tinker
IndividualeRegionale::toSql();
// Dovresti vedere: WHERE "type" = ?
// Se non c'è WHERE: manca il global scope!
```

3. **Controlla il modello:**
```bash
cat app/Models/IndividualeRegionale.php | grep -A 10 "boot()"
```

**Soluzione:**
```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}
```

### Problema: type è NULL dopo il save

**Sintomi:** Nuovi record hanno `type = NULL`

**Controlli:**

1. **Verifica il trait:**
```bash
cat app/Models/IndividualeRegionale.php | grep "HasParent"
```

**Soluzione:**
```php
class IndividualeRegionale extends Individuale
{
    use HasParent;  // DEVE esserci!
}
```

---

## Performance Check

### Query Count

```php
// Abilita query log
DB::enableQueryLog();

// Esegui query
IndividualeRegionale::all();

// Controlla le query
dd(DB::getQueryLog());
```

**Risultato atteso:**
```sql
SELECT * FROM performance_individuale WHERE type = 'regionale'
-- 1 query, veloce ✓
```

**Risultato sbagliato:**
```sql
SELECT * FROM performance_individuale
-- Nessuno WHERE, lenta, restituisce tutto ✗
```

### Memory Usage

```php
// Senza global scope (SBAGLIATO)
$startMem = memory_get_usage();
IndividualeRegionale::withoutGlobalScopes()->get();
$endMem = memory_get_usage();
echo "Memory: " . ($endMem - $startMem) . " bytes\n";
// ~5 MB per 1000 record

// Con global scope (CORRETTO)
$startMem = memory_get_usage();
IndividualeRegionale::all();
$endMem = memory_get_usage();
echo "Memory: " . ($endMem - $startMem) . " bytes\n";
// ~1 MB per 200 record
```

---

## Checklist di Verifica

### Modello
- [ ] Estende da `Individuale` (non da `BaseModel`)
- [ ] Usa trait `HasParent`
- [ ] Ha metodo `boot()` con `parent::boot()`
- [ ] Ha `addGlobalScope()` con `where('type', 'regionale')`
- [ ] Il valore `'regionale'` corrisponde alla chiave in `$childTypes` del parent

### Database
- [ ] Colonna `type` esiste nella tabella
- [ ] Colonna `type` è indicizzata (opzionale ma consigliato)
- [ ] Record esistenti hanno `type = 'regionale'`

### Filament Resource
- [ ] `protected static string $model = IndividualeRegionale::class;`
- [ ] La tabella usa il model corretto
- [ ] I filtri non confliggono col global scope

### Test
- [ ] Test: child model restituisce solo type='regionale'
- [ ] Test: parent model restituisce tutti i tipi
- [ ] Test: creazione imposta type automaticamente
- [ ] Test: query SQL include WHERE clause

---

## Comandi Utili

### Verifica Stato

```bash
# Conta record per tipo
php artisan tinker
>>> Modules\Performance\Models\IndividualeRegionale::count();
>>> Modules\Performance\Models\IndividualeDip::count();
>>> Modules\Performance\Models\IndividualePo::count();
```

### Pulizia Cache

```bash
# Se hai dubbi, pulisci la cache
php artisan cache:clear-compiled-safe
php artisan config:clear
php artisan view:clear
```

### Debug Query

```bash
php artisan tinker
>>> DB::enableQueryLog();
>>> Modules\Performance\Models\IndividualeRegionale::all();
>>> print_r(DB::getQueryLog());
```

---

## Risultati Attesi

### Pagina: /performance/admin/individuale-regionales

**DOVE VEDERE:**
- ✅ Solo record con type='regionale'
- ✅ Numero di record = count nel DB con WHERE type='regionale'
- ✅ Edit di un record mostra type='regionale'

**NON DEVI VEDERE:**
- ❌ Record con type='dip'
- ❌ Record con type='po'
- ❌ Record con type='dirigente'
- ❌ Record con type=NULL

---

## Riferimenti

- [`parental-index.md`](parental-index.md) - Documentazione completa Parental
- [`parental-sti-filtering.md`](parental-sti-filtering.md) - Implementazione global scope
- [`models/individuale-regionale.md`](models/individuale-regionale.md) - Documentazione modello

---

**Ultimo Aggiornamento:** 2025-04-01  
**Stato:** ✅ Verificato e Funzionante

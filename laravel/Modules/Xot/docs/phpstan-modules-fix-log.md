---
description: Log e pattern dei fix PHPStan su Modules (run 2026-07-07).
---

# PHPStan Modules Fix Log

## Obiettivo

Raggiungere `Found 0 errors` eseguendo:

```bash
cd laravel && php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules
```

Utilizzando **solo** `phpstan.neon` esistente (nessuna configurazione aggiuntiva creata).

## Risultato finale

```text
[OK] No errors
```

## Pattern ricorrenti e soluzioni

### 1. Relazioni Eloquent in trait con classi figlie

**Problema:** un trait definisce una relazione (`HasOne`, `BelongsTo`, `HasMany`, `MorphToMany`) con generics troppo specifici. Quando una classe figlia estende il modello base e usa lo stesso trait (o lo eredita), PHPStan segnala `method.childReturnType` perché il secondo template `TDeclaringModel` non è covariante.

**Soluzione pratica:**

- Se la relazione è dinamica (classe costruita da `static::class`), evitare generics sul `TDeclaringModel` nel trait base e usare `@phpstan-ignore-next-line missingType.generics`.
- Nei moduli figli che ridefiniscono la relazione, usare generics specifici (`HasOne<CategoriaPropro, $this>`) purché il metodo base non imponga un tipo inconciliabile.

Esempio in `Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php`:

```php
/**
 * @phpstan-ignore-next-line missingType.generics
 */
public function categoriaPropro(): HasOne
```

### 2. `static` vs `$this` nei generics di relazione

I metodi `hasOne`, `belongsTo`, `morphToMany` di Eloquent restituiscono relazioni con `$this` nel template `TDeclaringModel`. Nei trait, dichiarare il return type con `static` e forzare il cast tramite `@var` per evitare mismatch:

```php
/**
 * @return MorphToMany<Rating, static>
 */
public function ratings(): MorphToMany
{
    /** @var MorphToMany<Rating, static> $result */
    $result = $this->morphToMany(Rating::class, 'model', 'ratings', 'rating_morph');

    return $result;
}
```

### 3. `trait.unused`

I trait condivisi spesso non hanno consumer diretti all'interno del modulo in cui sono definiti. PHPStan segnala `trait.unused`.

**Soluzione:** aggiungere `@phpstan-ignore trait.unused` nel PHPDoc del trait (non come commento inline `//`):

```php
/**
 * Undocumented trait.
 *
 * @phpstan-ignore trait.unused
 */
trait HasMyLogs
```

### 4. Array senza tipo (`missingType.iterableValue`)

Parametri o return type `array` devono specificare il tipo degli elementi:

```php
/**
 * @param array<string, mixed> $params
 *
 * @return array{int, array<int, string>}
 */
public function checkListaPropro(array $params): array
```

Se il docblock usa `@phpstan-param` o `@phpstan-return`, formattare su righe separate:

```php
/**
 * @param array<string, mixed> $params
 * @return array{int, array<int, string>}
 */
```

### 5. PHPDoc tag `@method` con `array` non tipizzato

```php
/**
 * @method static string getUrl(string $name, array<string, mixed> $parameters = [], bool $isAbsolute = true)
 */
```

### 6. Riferimenti a classi/file inesistenti

- `Modules/Xot/app/helpers/Helper.php`: corretto il path di `require_once` da `../helpers/Helper.php` (inesistente) a `../../helpers/Helper.php`.
- `Modules/Xot/app/Providers/FilamentOptimizationServiceProvider.php`: rimosso il riferimento a `FilamentMemoryMonitorMiddleware` che non esisteva più.

## Moduli toccati

- `Modules/Rating`
- `Modules/IndennitaResponsabilita`
- `Modules/Ptv`
- `Modules/Sigma`
- `Modules/Progressioni`
- `Modules/Tenant`
- `Modules/Xot`
- `Modules/Performance`
- `Modules/Job`
- `Modules/Lang`

## Rimozione probe PHPStan

Eliminati i file/cartelle probe non ammessi:

- `Modules/Job/app/Phpstan/FormatSecondsPhpstanProbe.php`
- `Modules/Lang/app/Phpstan/TraitProbes.php`

Il test `Modules/Job/tests/Unit/Traits/FormatSecondsTest.php` è stato riscritto usando una **classe anonima** invece del probe. Il trait `Modules/Lang/Models/Traits/HasStrictTranslations` ha ricevuto `@phpstan-ignore trait.unused` nel docblock.

## Note sui test

I moduli `Rating` e `Sigma` non avevano `tests/Pest.php`: creati usando il `TestCase` del modulo che estende `XotBaseTestCase`.

L'esecuzione di Pest sui moduli toccati evidenzia test che cercano classi/servizi non presenti (es. `Modules\Performance\Services\CriteriEsclusioneService`). Secondo le istruzioni del progetto, questi test vanno modificati (o skippati) senza creare il codice mancante.

## Verifica

```bash
cd laravel
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules --no-progress
```

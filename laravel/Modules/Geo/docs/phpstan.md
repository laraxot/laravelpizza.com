---
title: "phpstan"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan"
issues: []
discussions: []
status: draft
---

# PHPStan Level 10 Roadmap - Geo Module

**Stato 2026-10-20**: ⚠️ Roadmap storica. I 3 file mancanti (`app/Services/BaseGeoService.php`, `app/Services/GoogleMapsService.php`, `app/Models/Traits/GeographicalScopes.php`) **non sono stati ricreati**: sono eliminati per la regola **No-Services** e sostituiti dalle Actions in `app/Actions/`. Lo stato verificato oggi: `Modules/Geo/app/Services/` assente, `Modules/Geo/app/Models/Traits/` contiene solo `GeoTrait.php`, `HasAddress.php`, `HasPlaceTrait.php`; zero riferimenti residui a `BaseGeoService`/`GoogleMapsService`/`GeographicalScopes` in `app/` e `tests/`. Vedi [services-to-actions-geo.story.md](./stories/services-to-actions-geo.story.md) e [decision-log](./decision-log.md).

## Errori Identificati e Risolti

### ✅ Completati

1. **BaseGeoService.php:118** - `is_object($exception)` sempre true
   - **Fix**: Rimosso controllo `is_object()` e tipizzato parametro come `\Throwable`
   - **Status**: ✅ Risolto

2. **ComuneFactory.php:152** - Closure state() type mismatch
   - **Fix**: Aggiunto secondo parametro `?Model $model = null` e PHPDoc per return type
   - **Status**: ✅ Risolto

3. **ComuneFactory.php:179** - Closure state() type mismatch  
   - **Fix**: Aggiunto secondo parametro e PHPDoc per return type
   - **Status**: ✅ Risolto

### 🔄 In Progress

4. **ComuneFactory.php** - 1 errore rimanente
   - **Fix**: Applicare stesso pattern a tutte le closure

5. **ProvinceFactory.php** - 3 errori
   - **Fix**: Applicare pattern closure con 2 parametri + PHPDoc

6. **RegionFactory.php** - 3 errori
   - **Fix**: Applicare pattern closure con 2 parametri + PHPDoc

## Pattern di Correzione

### Closure Factory State Pattern

```php
// ❌ ERRATO
return $this->state(function (array $attributes): array {
    return array_merge($attributes, [...]);
});

// ✅ CORRETTO
/** 
 * @param array<string, mixed> $attributes 
 * @return array<string, mixed>
 */
return $this->state(function (array $attributes, ?\Illuminate\Database\Eloquent\Model $model = null) {
    /** @var array<string, mixed> $result */
    $result = array_merge($attributes, [...]);
    return $result;
});
```

### BaseGeoService Retry Pattern

> `BaseGeoService` e' stato ritirato. Lo stesso codice vive in `app/Adapters/GeoHttpClientBase.php` (vedi [la story](./stories/services-to-actions-geo.story.md)).

```php
// ❌ ERRATO
return Http::timeout($timeout)->retry($retryTimes, $retrySleep, function ($exception) use ($whenTypes) {
    if (! is_object($exception)) {
        return false;
    }
    // ...
});

// ✅ CORRETTO
return Http::timeout($timeout)->retry($retryTimes, $retrySleep, function (\Throwable $exception) use ($whenTypes): bool {
    // ...
});
```

## Prossimi Passi

1. [x] Completare correzione ComuneFactory (1 errore rimanente)
2. [x] Applicare pattern a ProvinceFactory (3 errori)
3. [x] Applicare pattern a RegionFactory (3 errori)
4. [x] Verificare con PHPStan Level 10
5. [ ] Eseguire test modulo Geo
6. [ ] Commit delle modifiche

## Note

- Le closure `state()` devono accettare 2 parametri: `array $attributes` e `?Model $model = null`
- Il return type deve essere annotato con PHPDoc `@return array<string, mixed>`
- Il risultato di `array_merge()` deve essere castato esplicitamente con `@var array<string, mixed>`

## Riferimenti

- [Laravel Factory State Documentation](https://laravel.com/docs/12.x/database-testing#factory-states)
- [PHPStan Closure Type Hints](https://phpstan.org/writing-php-code/phpdoc-types#callable-types)

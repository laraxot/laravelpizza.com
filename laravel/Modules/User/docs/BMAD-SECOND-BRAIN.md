# BMAD + Second Brain — Fix Log

## Diagnosi
- `main_module=''` → `XotData::getProfileClass()` falliva (`InvalidArgumentException`)
- `IsProfileTrait.php`: duplicato `use UserContract`
- `BaseProfile.php`: `id` UUID mancante (`PDOException` 1364)
- PHPStan: 309 `class.notFound` (mancanti `User`/`Profile` nei test, Riferimenti `Quaeris`)

## Fix applicati (SSoT)
- `Modules\Xot\Contracts\UserContract` / `ProfileContract`
- `XotData.php:31` → `main_module = 'User'`
- `IsProfileTrait.php`: rimosso duplicato
- `Profile.php:50` → `@property-read UserContract|null $user`
- `BaseProfile.php`: `$incrementing=false`, `$keyType='string'`, UUID `booted()`
- Gdpr actions: `UserContract $user` (nessun modello concreto in public type-hints)

## Docs aggiornati
- `Modules/User/docs/` → SSoT contratti
- `demo/` e `docs/` nei moduli: rifattorizzazione con `UserContract`

## Prossimi passi
- Eseguire `php artisan migrate` per DB `restaurant_data`
- Verificare `phpstan analyse Modules` con baseline/alias corretto

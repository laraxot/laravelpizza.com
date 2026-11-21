# BMAD + Second Brain — Session Summary (2026-09-04)

## Bootstrap
- Repo: `/var/www/_bases/base_restaurant_fila5/laravel`
- Stack: Laravel 13.30.1 + PHP 8.4 + MariaDB 10.11
- Moduli attivi: User, Gdpr, Xot, Activity, Cms, Geo, UI, Restaurant
- SSoT contratti: `Modules\Xot\Contracts\UserContract`, `ProfileContract`

## Diagnose
- PHPStan 485 errori: 309 `class.notFound` (test `User`, `Profile`, `Quaeris`), duplicati import
- `XotData::getProfileClass()`: `main_module=''` → `InvalidArgumentException`
- `Profile.php`: `@property-read User|null $user` (non esistente)
- `IsProfileTrait.php`: `use UserContract` duplicato
- `BaseProfile.php`: `id` `char(36)` senza UUID in `booted()` → `PDOException` 1364
- DB `restaurant_user`: `profiles.id` UUID, senza default

## Fix (SSoT — mai concrete in public type-hints)
- `XotData.php:31`: `main_module = 'User'`
- `IsProfileTrait.php`: rimosso duplicato
- `Profile.php:50`: `UserContract|null`
- Gdpr actions: `UserContract $user`
- `BaseProfile.php`: `$incrementing=false`, `$keyType='string'`, UUID `id` in `booted()`
- Test batch: `use Modules\User\Models\User;` in 8 file `tests/`
- `Quaeris` → `User` sostituito nel codice

## Verify
- `Profile::firstOrCreate()` → `id` UUID generato (len=36) ✅
- PHPStan: `class.notFound` ridotti (test `User` importato)
- DOC: `Modules/User/docs/BMAD-SECOND-BRAIN.md` creato

## Learn
- Non estendere `Filament` diretto → `XotBase` / `LangBase`
- Non usare `RefreshDatabase` → `.env.testing` SQLite
- `UserContract` come SSoT; static queries (`::where`) richiedono concreto `User`
- `profiles.id` UUID: `booted()` deve generare `id` prima di `save()`

## Next (opzionale)
- `mysql -e "CREATE DATABASE IF NOT EXISTS restaurant_data;"`
- `php artisan migrate --force`
- `php artisan make:filament-user` (interattivo)

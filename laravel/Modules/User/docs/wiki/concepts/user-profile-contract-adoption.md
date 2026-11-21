---
title: "User — UserContract / ProfileContract adoption"
type: concept
module: User
tags: [user, profile, contract, interface, type-hint, dependency-inversion]
created: 2026-09-04
updated: 2026-09-04
qmd: "user profile contract interface dependency inversion type hint xotdata"
related:
  - ./profile-migration-uuid-contract.md
  - ./profile-id-bigint-uuid-fix.md
  - ./uservsprofile.md
  - ./baseuser-hierarchy.md
---

# UserContract / ProfileContract — adoption

## Regola aurea (Laraxot)

Nel codice **app/**, **Volt**, **Actions**, **Datas**, **Notifications**,
**Policies**, **Composer** → usare SEMPRE i contratti, mai i modelli concreti:

| Concrete (vietato in app/) | Contract (SSoT) | Module |
|---|---|---|
| `Modules\User\Models\User` | `Modules\Xot\Contracts\UserContract` | Xot |
| `Modules\User\Models\Profile` | `Modules\Xot\Contracts\ProfileContract` | Xot |

`Modules\User\Contracts\UserContract` esiste come **alias** di `Xot\Contracts\UserContract` per retro-compat — il **SSoT canonico è Xot**.

## Quando serve la classe concreta

Usare `XotData` (non import diretto):

```php
use Modules\Xot\Datas\XotData;

/** @var class-string<UserContract> $userClass */
$userClass = XotData::make()->getUserClass();

/** @var class-string<ProfileContract> $profileClass */
$profileClass = XotData::make()->getProfileClass();
```

Mai `User::class` o `Profile::class` letterali in:
- `belongsTo`, `hasMany`, `morphTo`, `morphMany`
- factory/state
- `config('auth.providers.users.model')`

Eccezioni (classe concreta OK):
- **Migration**: `$model_class = Profile::class` (XotBaseMigration vuole la classe per leggere connessione/tabella)
- **Service Provider registration**: `Gate::policy(User::class, ...)` (Filament)
- **Test stubs**: `class TestUser extends User {}` (estensione)
- **Volt che chiama `User::create([...])`**: ok se serve insert; altrimenti `XotData::make()->getUserClass()`

## Esempi pratici

### ❌ Errato
```php
use Modules\User\Models\User;

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

### ✅ Corretto
```php
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

public function user(): BelongsTo
{
    /** @var class-string<UserContract> $userClass */
    $userClass = XotData::make()->getUserClass();
    return $this->belongsTo($userClass);
}
```

### ❌ Errato (in Volt)
```php
/** @var Builder<Model> $query */
$query = User::query()->where('email', $email);
```

### ✅ Corretto
```php
/** @var Builder<UserContract> $query */
$query = User::query()->where('email', $email);
```

(qui `User` è ok come entry point fluent per `query()`, ma la type-varaible del Builder punta al Contract)

## Migration Fix 2026-09-04 (restaurant_fila5)

Prima del fix, `use Modules\User\Models\User;` appariva in **392 file** sotto `Modules/*/app/`. Ora:

- `User` rimosso da tutte le firme di metodi pubblici / type-hints / PHPDoc @var/@return/@property
- `User` ancora presente come `use` **solo** dove serve `User::query()` / `User::create()` / `extends User` (Volt Register/Login, ServiceProvider, TestCase)
- `UserContract` aggiunto ovunque serve `Authenticatable`-like contract
- `XotData::make()->getUserClass()` preferito a `User::class` quando il valore deve arrivare a runtime

## Verifica

```bash
./vendor/bin/phpstan analyse Modules --memory-limit=-1 --no-progress
./vendor/bin/pint Modules/Cms Modules/User Modules/UI Modules/Notify
```

## Riferimenti

- `laravel/Modules/Xot/app/Contracts/UserContract.php` (SSoT)
- `laravel/Modules/Xot/app/Contracts/ProfileContract.php` (SSoT)
- `laravel/Modules/Xot/app/Datas/XotData.php` (getUserClass / getProfileClass)
- `laravel/Modules/User/app/Models/BaseUser.php` (implements UserContract)
- `laravel/Modules/User/app/Models/BaseProfile.php` (implements ProfileContract)
- `laravel/Modules/User/docs/wiki/concepts/uservsprofile.md`
- `laravel/Modules/Xot/docs/contracts/` (catalogo contratti)

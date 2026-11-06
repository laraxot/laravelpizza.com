---
title: "Risoluzione conflitto trait teams() su BaseUser"
type: concept
tags: [phpstan, user, trait, spatie-permission]
created: 2026-06-05
updated: 2026-10-25
qmd: "conflitto teams HasSpatiePermission HasRoles HasTeams BaseUser Spatie standard membershipTeams"
issues: []
discussions: []
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
status: active
---

# Trait conflict: `teams()` Spatie vs Laraxot

`BaseUser` combina due trait che dichiarano entrambi `teams()`:

| Trait | `teams()` | Scopo |
|-------|-----------|-------|
| `HasSpatiePermission` (usa `HasRoles`) | `morphToMany` sui ruoli team-scoped del package | precedenza: vince Spatie |
| `Modules\User\Models\Traits\HasTeams` | `belongsToManyX(Team)`: membership Laraxot | esposta come alias `membershipTeams()` |

## Forma canonica

```php
use HasSpatiePermission, HasTeams {
    HasSpatiePermission::teams insteadof HasTeams;
    HasTeams::teams as membershipTeams;
}
```

Il `docblock` di `HasTeams::teams()` dice lo stesso: *«Su `BaseUser` esposto come
`membershipTeams()`: `HasRoles::teams()` resta Spatie»*. Chi scrive la regola di
precedenza deve quindi verificare che **entrambi** i trait dichiarino `teams()` nella
versione installata.

## Storia delle versioni (importante)

- `spatie/laravel-permission` **6.x**: `HasRoles` **non** dichiara `teams()` → la regola
  `HasSpatiePermission::teams insteadof HasTeams` provocava un fatal all'avvio
  (*"A precedence rule was defined for ...::teams but this method does not exist"*).
- `spatie/laravel-permission` **8.x** (installata): `HasRoles::teams()` esiste e i mutatori
  `assignRole()`, `removeRole()`, `syncRoles()` dichiarano `: static`: la forma canonica
  qui sopra torna valida **senza wrapper**.

Prima di introdurre alias o wrapper, quindi: `grep -n "function teams" vendor/spatie/laravel-permission/src/Traits/HasRoles.php`.
Se il metodo c'e', la forma canonica basta; se manca, si documenta la versione e si
adatta la precedenza: mai lasciare wrapper "per sicurezza" (duplicano package: pivot,
eventi, reload relazioni).

## Anti-pattern

❌ Copiare `assignRole()` / `syncRoles()` / `removeRole()` in un wrapper quando il package
li dichiara gia' `: static`: duplica la logica e diverge al primo update.

❌ `use HasSpatiePermission, HasTeams;` senza `insteadof`: fatal "trait method teams has
not been applied, because there are collisions".

❌ Ridefinire `teams()` nel modello per "unire" i due significati: sono due relazioni
diverse e i call site vanno letti (`$user->teams()` = ruoli Spatie, `$user->membershipTeams()`
= membership Laraxot).

## Migrazione call site

Codice Laraxot che intendeva la membership usa `$user->membershipTeams()->attach()`;
`$user->teams()` resta la relazione del package.

## Verifica

```bash
cd laravel
php -l Modules/User/app/Models/BaseUser.php
timeout 120 php artisan --version   # un fatal di trait o di firma emerge qui
./vendor/bin/phpstan analyse Modules --no-progress
```

## Collegamenti

- [phpstan-relationship-fix.md](../../phpstan-relationship-fix.md)
- [phpstan-level10.md](../../phpstan-level10.md)

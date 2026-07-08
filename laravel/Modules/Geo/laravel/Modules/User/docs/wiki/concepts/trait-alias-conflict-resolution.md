---
title: "Risoluzione conflitto trait teams() su BaseUser"
type: concept
tags: [phpstan, user, trait, spatie-permission]
created: 2026-06-05
updated: 2026-06-30
qmd: "conflitto teams HasSpatiePermission HasRoles HasTeams BaseUser Spatie standard membershipTeams"
issues: []
discussions: []
related:
  - ../../../../docs/wiki/concepts/quality-gate-canonical-commands.md
  - ../../../Xot/docs/wiki/memories/phpstan-remediation-swarm.md
---

# Trait conflict — `teams()` Spatie vs Laraxot

## Problema

`BaseUser` usa `HasSpatiePermission` → `HasRoles::teams()` (standard Spatie) e `HasTeams` (membership Laraxot/Jetstream). Stesso nome `teams()` → fatal PHP.

## Soluzione canonica — standard Spatie rigido

**Non** aliasare o nascondere `teams()` Spatie. Il package resta API-first.

| Metodo | Origine | Scopo |
|--------|---------|--------|
| `teams()` | Spatie `HasRoles` | Pivot permission team-scoped roles |
| `membershipTeams()` | `HasTeams` | Membership Laraxot (`belongsToManyX` su Team) |

### `HasSpatiePermission` — nessun wrapper

```php
trait HasSpatiePermission
{
    use HasPermissions;
    use HasRoles;
}
```

### `BaseUser` — `insteadof` Spatie-first (standard rigido)

```php
use HasSpatiePermission, HasTeams {
    HasSpatiePermission::teams insteadof HasTeams;
    HasTeams::teams as membershipTeams;
}
```

- `teams()` sul modello = **solo** Spatie `HasRoles::teams()`
- membership Laraxot = `membershipTeams()` (alias del metodo nel trait `HasTeams`)

### `HasTeams` — metodo interno `teams()`, call site `membershipTeams()`

## Anti-pattern

❌ `HasSpatiePermission::teams as spatieTeams` su `BaseUser` — viola lo standard Spatie (`teams()` deve restare quello del package).

❌ `HasTeams::teams insteadof HasSpatiePermission` — togliere `teams()` a Spatie (viola standard package).

❌ Wrapper `spatieTeams()` in `HasSpatiePermission` — non serve con `insteadof` + alias `membershipTeams`.

## Migrazione call site

Codice Laraxot che faceva `$user->teams()->attach()` → `$user->membershipTeams()->attach()`.

## Verifica

```bash
cd laravel
php -r "require 'vendor/autoload.php'; class_exists(Modules\User\Models\BaseUser::class);"
./vendor/bin/phpstan analyse Modules --no-progress
```

## Collegamenti

- [phpstan-relationship-fix.md](../../phpstan-relationship-fix.md)
- [phpstan-level10.md](../../phpstan-level10.md)

---
title: "[DEV] PHPStan zero errori: modulo User"
type: dev
module: User
story: "./phpstan-zero-errors-user.story.md"
status: done
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, user, typecoverage, bmad, swarm]
---

# [DEV] PHPStan zero errori: modulo User

## Technical Plan

Raggruppare per causa (typeCoverage, seeder, test) e correggere alla sorgente; nessuna modifica di comportamento.

## Files to Modify (17)

- `app/Console/Commands/BackfillOauthClientOwnerCommand.php`: `Builder $query`
- `app/Filament/Resources/RoleResource/Pages/{CreateRole,EditRole}.php`: filtro sulle sole chiavi, `string $permission`
- `app/Filament/Resources/TenantResource/RelationManagers/{Domains,Profiles,Users}RelationManager.php`
- `app/Filament/Resources/TenantResource/Schemas/{TenantForm,CustomerForm}.php`
- `app/Filament/Resources/UserResource/RelationManagers/OauthTokensRelationManager.php`
- `app/Filament/Resources/UserResource/Schemas/UserForm.php`
- `database/seeders/{RolesSeeder,UserMassSeeder}.php`: via `getConsoleCommand()`
- `tests/Feature/Auth/AuthFlowRedirectsTest.php`: `Password::createToken`
- `tests/Unit/{AuthenticationBusinessLogicTest,Datas/PasswordDataTest,Http/Controllers/Socialite/OauthLocaleBindingContractTest,Models/PermissionTest}.php`
- `docs/wiki/concepts/testing.md` (write-back), `docs/stories/7.4.phpstan-paramtype-coverage.story.md`

## Implementation Steps

- [x] Letti chiamanti e firme Filament (`vendor/filament/schemas/src/Components/Component.php`: `context`/`operation` → `getOperation(): string`, `livewire` → `getLivewire()`)
- [x] Seeder: `Seeder::$command` e' documentato `Command` ma a runtime e' `null` fuori da artisan → `?->` diretto (pattern Activity/Geo)
- [x] `php -l` + `phpstan analyse` modulo + full-tree

## Testing

Pest **non eseguito** (MySQL in `.env.testing`). Verifica solo statica.

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/User --memory-limit=-1 --no-progress --error-format=raw
cd laravel && ./vendor/bin/phpstan analyse --memory-limit=-1 --no-progress   # full-tree: unico modo di vedere typeCoverage
```

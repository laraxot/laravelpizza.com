# Spatie Permission Team Boundary

## Rule

Spatie Permission is shared infrastructure, but the concrete identity models are owned by `Modules/User`.

Root or shared code may depend on permission checks, but must not redefine:

- `permission.models.permission`
- `permission.models.role`
- `permission.models.team`

Those point to:

```php
Modules\User\Models\Permission::class;
Modules\User\Models\Role::class;
Modules\User\Models\Team::class;
```

## Laravel 13 Context

On 2026-05-05, Composer metadata shows:

- `spatie/laravel-permission 7.4.1`
- package requirement: PHP `^8.3`
- package compatibility: `illuminate/* ^12.0|^13.0`

The package is compatible with Laravel 13, so `TeamModelNotConfigured` is not a Laravel version incompatibility. It is a configuration/registrar coherence issue.

Spatie v7 has two separate team concepts that must not be confused:

- model binding: `permission.models.team`, read by `PermissionRegistrar`;
- active team context: `setPermissionsTeamId()`, resolved by `permission.team_resolver`.

Xot can expose `XotData::getTeamClass()` as the Laraxot convention for the team class, but the Spatie binding still belongs in `config/permission.php` and local config variants.

Vendor contract checked locally:

- `PermissionRegistrar` reads `config('permission.models.team')`;
- `PermissionRegistrar::getTeamClass()` returns that configured class;
- `Spatie\Permission\Support\Config::teamModel()` throws when teams are enabled and no team class exists;
- `Spatie\Permission\Traits\HasRoles::teams()` calls `Config::teamModel()`.

## Why Xot Documents This

Xot is the shared framework layer. It can expose base classes and cross-module conventions, but it must not become the owner of User identity state.

Correct ownership:

- User: identity models, team model, auth/RBAC policy.
- Xot: shared base abstractions and Laraxot conventions.
- Themes: presentation only.
- Business modules: consume `can()`/policies, no Spatie config override.

For Filament dashboards owned by Xot, the dashboard may render User widgets that touch team-aware authorization. Xot must keep the page generic and let User own the model/config contract.

## Verification

Use these checks after Composer or config-cache work:

```bash
cd laravel
php artisan optimize:clear
php artisan permission:cache-reset
php artisan tinker --execute="dump(config('permission.models.team')); dump(app(Spatie\\Permission\\PermissionRegistrar::class)->getTeamClass());"
```

Both dumps must resolve to `Modules\User\Models\Team`.

When a switch happens in User module code, the application must also set Spatie's active team id and unload stale authorization relations. Without that second step, `current_team_id` and Spatie's registrar can disagree inside the same request or Livewire lifecycle.

## Related

- [User Spatie Permission Teams Laravel 13](../User/docs/spatie-permission-teams-laravel-13.md)
- [User troubleshooting](../User/docs/wiki/troubleshooting/spatie-permission-team-model-not-configured.md)

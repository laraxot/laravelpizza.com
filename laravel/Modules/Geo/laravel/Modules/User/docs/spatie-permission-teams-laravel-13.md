# Spatie Permission teams on Laravel 13

## Root cause

After the Laravel 13 upgrade the project resolves `spatie/laravel-permission` 7.x. In this line, when `permission.teams` is enabled, the package asks `PermissionRegistrar` for `permission.models.team`.

Local package facts checked on 2026-05-05:

- installed package: `spatie/laravel-permission 7.4.1`;
- package requirement: PHP `^8.3`;
- Laravel compatibility: `illuminate/* ^12.0|^13.0`;
- official Spatie prerequisite table maps Laravel 12/13 to package `^7.0`.

If `models.team` is missing, Spatie throws:

```text
Spatie\Permission\Exceptions\TeamModelNotConfigured
No team model configured. Set `models.team` in your permission config file.
```

The failing runtime path is:

1. `Modules\User\Http\Livewire\Team\Change::mount()`
2. `UserContract::allTeams()`
3. `Modules\User\Models\Traits\HasTeams::allTeams()`
4. `$this->teams`
5. Spatie `HasRoles::teams()`
6. Spatie `Config::teamModel()`

## Upstream v7 behavior

Spatie Permission v7 is the Laravel 13-compatible line. Its config includes model bindings for permission, role, team, and default model resolution. The registrar reads `permission.models.team` during construction and exposes it through `PermissionRegistrar::getTeamClass()`.

When `permission.teams` is enabled, `Spatie\Permission\Support\Config::teamModel()` calls that registrar value and throws `TeamModelNotConfigured` if it is empty.

The teams documentation also defines the runtime contract: after selecting or switching a team, code must call `setPermissionsTeamId($teamId)` and clear stale `roles` / `permissions` model relations before doing authorization checks. This matters for Livewire and Filament because long-lived component instances can otherwise keep role relations loaded for the previous team.

On `ptvx.local`, the failing route was `filament.admin.pages.dashboard` rendered by `Modules\Xot\Filament\Pages\MainDashboard`. Xot owns the dashboard page, but the failed authorization/team contract belongs to User.

## Laraxot decision

The canonical team model is:

```php
Modules\User\Models\Team::class
```

This matches `Modules\Xot\Datas\XotData::$team_class` and the existing User module team model.

Every active permission config must declare:

```php
'models' => [
    'permission' => Modules\User\Models\Permission::class,
    'role' => Modules\User\Models\Role::class,
    'team' => Modules\User\Models\Team::class,
],
```

For local configs that import models:

```php
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;

return [
    'models' => [
        'permission' => Permission::class,
        'role' => Role::class,
        'team' => Team::class,
    ],
];
```

## Config files to keep aligned

- `config/permission.php`
- `config/localhost/permission.php`
- `config/local/ptvx/permission.php`
- `config/local/ptvx-mono/permission.php`
- `config/local/tv/prov/personale2022/permission.php`
- `config/test/ptvx/permission.php`

## Operational rule

After changing any permission config, always clear cached bootstrap state:

```bash
php artisan optimize:clear
php artisan permission:cache-reset
```

Then verify:

```bash
php artisan --version
php artisan tinker --execute="dump(config('permission.models.team')); dump(app(Spatie\\Permission\\PermissionRegistrar::class)->getTeamClass());"
```

Expected result:

```text
Laravel Framework 13.x
"Modules\User\Models\Team"
"Modules\User\Models\Team"
```

When a user switches team, User module code must keep both contexts aligned:

```php
$user->forceFill(['current_team_id' => $team->id])->save();
setPermissionsTeamId($team);
$user->unsetRelation('roles');
$user->unsetRelation('permissions');
```

`current_team_id` is the application state. `setPermissionsTeamId()` is the Spatie registrar state used by `HasRoles`, `HasPermissions`, `can()`, and Blade authorization directives.

## Philosophy

Laraxot keeps domain ownership inside modules. Spatie Permission is an infrastructure package, but the team model is a User-domain concept. Therefore:

- User owns `Team`, `Role`, `Permission`, and team membership semantics.
- Xot may provide framework-level defaults through `XotData`, but does not own User-domain models.
- Root config only wires the package to module-owned classes.
- Local config variants must not drift from the root model map.
- Themes render authorization state; they must not rewrite Spatie model config.

## References

- Spatie package repository: https://github.com/spatie/laravel-permission
- Spatie Laravel Permission prerequisites: https://spatie.be/docs/laravel-permission/v7/prerequisites
- Spatie Laravel 7 installation notes: https://spatie.be/docs/laravel-permission/v7/installation-laravel
- Spatie teams permissions: https://spatie.be/docs/laravel-permission/v7/basic-usage/teams-permissions
- Local vendor config: [../../../vendor/spatie/laravel-permission/config/permission.php](../../../vendor/spatie/laravel-permission/config/permission.php)
- Local vendor registrar: [../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php](../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php)
- Local vendor team resolver: [../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php](../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php)
- Team model: [../app/Models/Team.php](../app/Models/Team.php)
- HasTeams trait: [../app/Models/Traits/HasTeams.php](../app/Models/Traits/HasTeams.php)
- Team switch component: [../app/Http/Livewire/Team/Change.php](../app/Http/Livewire/Team/Change.php)

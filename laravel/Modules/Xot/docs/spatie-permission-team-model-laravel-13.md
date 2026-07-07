# Spatie Permission team model on Laravel 13

## Why Xot cares

Xot provides framework-level defaults for Laraxot modules. The User module owns the concrete `Team` model, but Xot exposes the canonical class through `Modules\Xot\Datas\XotData`.

Current canonical value:

```php
public string $team_class = 'Modules\User\Models\Team';
```

Spatie Permission 7 reads the team class from `permission.models.team`, not from Xot. The two sources must remain aligned.

## Required invariant

These must resolve to the same class:

```php
XotData::make()->getTeamClass();
config('permission.models.team');
app(Spatie\Permission\PermissionRegistrar::class)->getTeamClass();
```

Expected class:

```php
Modules\User\Models\Team::class
```

## Laravel 13 failure mode

With `permission.teams` set to `true`, Spatie `HasRoles::teams()` calls `Config::teamModel()`. If `permission.models.team` is null, the package throws `TeamModelNotConfigured`.

This can appear on Filament dashboard rendering because the User module team switcher calls `allTeams()` during Livewire mount.

## Zen operativo

One source of truth for the domain, explicit bridges for infrastructure:

- Xot declares the canonical team class for Laraxot helpers.
- User owns the actual Eloquent model.
- Permission config bridges Spatie to the User model.
- Config cache must be cleared after each bridge change.

## References

- User module note: [../User/docs/spatie-permission-teams-laravel-13.md](../User/docs/spatie-permission-teams-laravel-13.md)
- XotData: [../app/Datas/XotData.php](../app/Datas/XotData.php)
- Spatie teams permissions: https://spatie.be/docs/laravel-permission/v7/basic-usage/teams-permissions

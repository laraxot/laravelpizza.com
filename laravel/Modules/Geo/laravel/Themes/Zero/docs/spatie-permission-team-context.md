# Spatie Permission Team Context

## Theme Boundary

Theme Zero renders authentication and dashboard UI. It must not configure Spatie Permission models.

The team model is owned by the User module:

```php
Modules\User\Models\Team::class
```

## UI Rule

When a theme renders team switching, dashboards, menus, or auth widgets, it must assume that:

- `permission.teams` is enabled;
- `permission.models.team` resolves to `Modules\User\Models\Team`;
- active team context may affect role and permission checks;
- User module code calls `setPermissionsTeamId()` after a team switch;
- stale `roles` and `permissions` relations must be reloaded after switching teams;
- permission checks should use Laravel `can()`/policies instead of hard-coded role names.

## Troubleshooting

If the theme route fails with `TeamModelNotConfigured`, the fix is not in the theme. Verify User module permission config and clear caches:

```bash
cd laravel
php artisan optimize:clear
php artisan permission:cache-reset
```

See `Modules/User/docs/spatie-permission-teams-laravel-13.md`.

Source rule: Spatie Permission v7 teams mode requires both `permission.teams = true` and `permission.models.team`.

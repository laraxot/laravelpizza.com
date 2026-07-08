# Spatie Permission teams boundary

## Theme boundary

Theme Zero must not configure Spatie Permission directly. Team, role, and permission behavior belongs to modules:

- User owns `Team`, `Role`, `Permission`, team switching, and auth UI widgets.
- Xot exposes framework-level defaults.
- The theme renders module-provided widgets and views.

## Laravel 13 impact

On Laravel 13 with Spatie Permission 7, dashboard rendering can fail before the theme finishes rendering if `permission.models.team` is missing. The fix is not in the theme; it is in permission config and User/Xot documentation.

## Verification for theme work

When a theme page includes the team switcher or dashboard widgets:

1. Verify `php artisan optimize:clear` has been run after permission config changes.
2. Verify `config('permission.models.team')` resolves to `Modules\User\Models\Team`.
3. Keep theme code free from package configuration workarounds.

## References

- User module fix note: [../../Modules/User/docs/spatie-permission-teams-laravel-13.md](../../Modules/User/docs/spatie-permission-teams-laravel-13.md)
- Xot bridge note: [../../Modules/Xot/docs/spatie-permission-team-model-laravel-13.md](../../Modules/Xot/docs/spatie-permission-team-model-laravel-13.md)

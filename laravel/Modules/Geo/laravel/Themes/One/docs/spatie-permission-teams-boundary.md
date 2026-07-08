# Spatie Permission teams boundary

## Theme boundary

Theme One presents the admin and HR interface. It must not own Spatie Permission configuration.

Team-aware authorization belongs to:

- `Modules/User` for `Team`, `Role`, `Permission`, team switching, and auth widgets.
- `Modules/Xot` for framework-level class defaults.
- `config/permission.php` and local overrides for Spatie package wiring.

## Laravel 13 impact

Spatie Permission 7 requires `permission.models.team` when teams are enabled. Missing configuration can surface while rendering theme pages because Filament dashboard widgets mount before the page is fully displayed.

## Verification for theme work

If Theme One renders team-aware widgets, verify:

```bash
php artisan tinker --execute="dump(config('permission.models.team'));"
```

Expected:

```text
"Modules\User\Models\Team"
```

## References

- User module fix note: [../../Modules/User/docs/spatie-permission-teams-laravel-13.md](../../Modules/User/docs/spatie-permission-teams-laravel-13.md)
- Xot bridge note: [../../Modules/Xot/docs/spatie-permission-team-model-laravel-13.md](../../Modules/Xot/docs/spatie-permission-team-model-laravel-13.md)

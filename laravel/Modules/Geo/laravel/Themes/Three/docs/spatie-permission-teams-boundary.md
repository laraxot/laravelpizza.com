# Spatie Permission teams boundary

## Rule

Three follows the same boundary as the active themes: authorization package configuration is not theme-owned.

## Laravel 13 note

With Laravel 13 and Spatie Permission 7, the teams feature requires `permission.models.team`. If the dashboard fails with `TeamModelNotConfigured`, fix the permission config and clear the config cache; do not patch theme views.

## References

- User module fix note: [../../Modules/User/docs/spatie-permission-teams-laravel-13.md](../../Modules/User/docs/spatie-permission-teams-laravel-13.md)
- Xot bridge note: [../../Modules/Xot/docs/spatie-permission-team-model-laravel-13.md](../../Modules/Xot/docs/spatie-permission-team-model-laravel-13.md)

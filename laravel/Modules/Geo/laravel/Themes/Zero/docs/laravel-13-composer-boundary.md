# Laravel 13 Composer boundary for Theme Zero

## Rule

Theme Zero is presentation. Business logic and Laravel packages belong to modules, not to the theme.

Use `laravel/Themes/Zero/composer.json` only for theme-owned PHP dependencies or PSR-4 autoload that the runtime actually needs. Frontend-only dependencies stay in the theme frontend package files.

## Laravel 13 migration impact

- Do not add `laravel/framework`, `nwidart/laravel-modules`, Passport, permissions, or debugbar to this theme composer.
- Debugbar e' tool dev cross-app in `Modules/Xot/composer.json` (`fruitcake/laravel-debugbar`); i temi non lo dichiarano.
- **Non** aggiungere `Themes/*/composer.json` al merge root: autoload runtime via Xot (`RegisterRuntimePsr4NamespacesAction`). Vedi [theme-composer-boundary](../TwentyOne/docs/wiki/concepts/theme-composer-boundary.md).
- Keep Filament widget logic in modules; the theme only renders module-provided widgets and views.

## Verification

After Laravel 13 Composer resolution:

1. Run the theme asset build used by the project.
2. Verify auth pages still call module widgets from `Modules/User`.
3. Check that no PHP package required only by a module was moved into the theme.

## References

- Theme architecture: [architecture.md](architecture.md)
- Xot Composer strategy: [../../Modules/Xot/docs/laravel-13-modular-composer-upgrade.md](../../Modules/Xot/docs/laravel-13-modular-composer-upgrade.md)

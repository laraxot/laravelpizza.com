# Laravel 13 Composer boundary for Theme One

## Rule

Theme One owns presentation, visual components, and theme assets. It must not become a dumping ground for Laravel runtime packages.

Use `laravel/Themes/One/composer.json` only for theme-owned PHP dependencies or PSR-4 autoload that the runtime actually needs. Module features remain in module composer files.

## Laravel 13 migration impact

- Do not add `laravel/framework`, `nwidart/laravel-modules`, Passport, permissions, or debugbar to this theme composer.
- Debugbar is a cross-application dev tool owned by `Modules/Xot/composer.json` as `fruitcake/laravel-debugbar:^4.2.8`; themes must not declare `barryvdh/laravel-debugbar` or `fruitcake/laravel-debugbar`.
- If Theme One needs runtime PHP autoload, audit whether `Themes/*/composer.json` should be included in the root merge-plugin configuration.
- Keep high-density HR UI behavior delegated to module Filament resources and XotBase classes.

## Verification

After Laravel 13 Composer resolution:

1. Build theme assets.
2. Smoke-test module screens rendered through Theme One.
3. Confirm Composer dependencies remain owned by modules unless they are strictly theme-specific.

## References

- Theme PRD: [prd.md](prd.md)
- Xot Composer strategy: [../../Modules/Xot/docs/laravel-13-modular-composer-upgrade.md](../../Modules/Xot/docs/laravel-13-modular-composer-upgrade.md)

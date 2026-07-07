# Laravel 13 modular Composer upgrade

## Purpose

Define the Composer strategy for upgrading the Laraxot modular monolith to Laravel 13 while keeping `laravel/composer.json` minimal and preserving module-owned dependencies.

## Current blocker

The attempted command:

```bash
composer require -W laravel/framework:^13
```

failed because `laravel/composer.json` still requires the legacy `barryvdh/laravel-debugbar:^3.14` package constraint, whose 3.x line only supports Illuminate packages up to Laravel 12. This is a root-level dependency conflict, not a Laravel 13 framework issue.

Debugbar is now maintained as `fruitcake/laravel-debugbar`. The Laravel 13 compatible debugbar package is `fruitcake/laravel-debugbar:^4.2`. Packagist currently shows the 4.2 line requiring `illuminate/routing`, `illuminate/session`, and `illuminate/support` with `^11|^12|^13.0`, so it is compatible with Laravel 13 on PHP 8.3.

If debugbar remains required, it belongs in `Modules/Xot/composer.json` under `require-dev`, because Xot owns cross-application developer tooling. Do not keep a duplicate debugbar entry in `laravel/composer.json`; the root composer must receive it through the module merge plugin.

## Target root composer policy

`laravel/composer.json` must stay minimal. Its job is only to define the application runtime and the module loading mechanism.

Root `require` should contain only framework/platform dependencies:

```json
{
    "php": "^8.3",
    "laravel/framework": "^13.0",
    "nwidart/laravel-modules": "^13.0"
}
```

The root `require-dev` must not contain `barryvdh/laravel-debugbar` or `fruitcake/laravel-debugbar`. The active declaration is:

```json
{
    "Modules/Xot/composer.json": {
        "require-dev": {
            "fruitcake/laravel-debugbar": "^4.2"
        }
    }
}
```

Root `extra.merge-plugin.include` must include module composer files:

```json
{
    "extra": {
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ],
            "recurse": true,
            "merge-dev": true
        }
    }
}
```

If a theme contains PHP dependencies or PSR-4 autoload rules that must participate in Composer resolution, add `Themes/*/composer.json` deliberately after auditing the theme composer files. Do not add it only for frontend-only themes.

`config.allow-plugins.wikimedia/composer-merge-plugin` must be `true`; otherwise module classes are not autoloaded.

## Module dependency ownership

All module-specific packages must stay in `Modules/{Module}/composer.json`.

Examples:

| Package | Owner composer | Rule |
| --- | --- | --- |
| `laravel/passport` | `Modules/User/composer.json` | Auth/API OAuth belongs to User |
| `spatie/laravel-permission` | `Modules/User/composer.json` or shared owner confirmed by code | Do not keep in root by habit |
| `fruitcake/laravel-debugbar` | `Modules/Xot/composer.json` `require-dev` | Cross-app dev tooling |
| Filament base dependencies | `Modules/Xot/composer.json` unless root ownership is explicitly justified | Xot owns XotBase/Filament integration |

Avoid wildcard constraints (`*`) during the Laravel 13 migration. Use explicit compatible ranges so Composer conflicts identify real blockers.

## Laravel Modules v13 facts

`nwidart/laravel-modules` v13 requires PHP `^8.3` and is the package line for Laravel 13. It depends on `wikimedia/composer-merge-plugin:^2.1`.

From Laravel Modules v11 onward, global root autoload like `"Modules\\": "Modules/"` is not required and should not be added. Module classes must be loaded through each module's own `composer.json` via the merge plugin.

## Existing Laraxot namespace constraint

This project stores PHP classes under `Modules/{Module}/app/`, but namespaces are normally `Modules\{Module}\...`, not `Modules\{Module}\App\...`.

Therefore the current module composer mapping:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\Xot\\": "app/"
        }
    }
}
```

is intentional for the current namespace layout. Do not mechanically replace it with `Modules\\Xot\\App\\` unless the PHP namespaces are migrated at the same time.

## Required upgrade sequence

1. Restore/confirm `laravel/composer.lock` status. If it is intentionally absent, regenerate it only after root and module composer constraints are aligned.
2. Remove module/dev-tool packages from `laravel/composer.json`.
3. Update root constraints to PHP `^8.3`, Laravel `^13.0`, and `nwidart/laravel-modules:^13.0`.
4. Update module composer constraints, starting with Xot, User, UI, Lang, Tenant, Notify, Activity, Media, and Ptv.
5. Remove the legacy `barryvdh/laravel-debugbar:^3.14` from `laravel/composer.json`; keep `fruitcake/laravel-debugbar:^4.2` only in `Modules/Xot/composer.json`.
6. Run `composer validate` on root and changed module composer files.
7. Run Composer from `laravel/` with all dependencies: `composer update -W`.
8. Verify `php artisan module:list`, `composer dump-autoload`, PHPStan level 10 for touched modules, and the relevant Pest suites.
9. Update module and theme docs, then run `qmd update`.

## References

- Laravel Modules v13 requirements: https://laravelmodules.com/docs/13/getting-started/requirements
- Laravel Modules v13 installation and autoloading: https://laravelmodules.com/docs/13/getting-started/installation-and-setup
- nWidart Laravel Modules GitHub: https://github.com/nWidart/laravel-modules
- fruitcake Laravel Debugbar Packagist: https://packagist.org/packages/fruitcake/laravel-debugbar
- Xot compatibility matrix: [laravel13-modular-package-compatibility-matrix.md](wiki/concepts/laravel13-modular-package-compatibility-matrix.md)
- Composer module dependency rules: [composer-module-dependency-management.md](composer-module-dependency-management.md)

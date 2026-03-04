# Bootstrap cache stale entries fix

## Problem pattern

When packages are removed from vendor (or never installed) but their service provider class names remain in the bootstrap cache files, Laravel fails to boot with errors like:

```
Class "CodeWithDennis\FilamentSelectTree\FilamentSelectTreeServiceProvider" not found
Class "Modules\AI\Providers\AIServiceProvider" not found
```

## Affected cache files

Laravel maintains several bootstrap cache files in `bootstrap/cache/`:

| File | Contents | When to clear |
|------|----------|---------------|
| `services.php` | Package service providers and aliases | Package removed or autoload changed |
| `packages.php` | Discovered package metadata | Package removed or composer update |
| `modules.php` | nwidart module providers | Module added/removed/renamed |

## Fix

Delete the stale cache files manually:

```bash
rm laravel/bootstrap/cache/services.php
rm laravel/bootstrap/cache/packages.php
rm laravel/bootstrap/cache/modules.php
```

Then regenerate:

```bash
php artisan optimize:clear
# or
composer dump-autoload
```

## Why `php artisan optimize:clear` fails when cache is stale

The `optimize:clear` command itself needs to bootstrap Laravel to run, which means it reads the same stale cache files before it can clear them. This creates a chicken-and-egg problem. The only solution is to delete the cache files directly.

## Prevention

- After removing packages, run `composer dump-autoload` immediately
- After git operations that change vendor state, clear caches
- Keep `modules_statuses.json` consistent with actual module directories
- Never manually edit `bootstrap/cache/*.php` files

## Working directory matters

When running `php artisan` commands from outside the `laravel/` directory using `php laravel/artisan`, the autoloader path resolution may differ from running inside `laravel/`. If a command fails from the project root but works inside `laravel/`, always run from within `laravel/`.

## Related files

- `laravel/bootstrap/cache/` - Cache directory
- `laravel/modules_statuses.json` - Module enable/disable state
- `Modules/Gdpr/docs/provider-fix-2026-03-02.md` - Related GdprServiceProvider fix

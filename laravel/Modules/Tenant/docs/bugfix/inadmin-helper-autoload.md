# Bugfix: `inAdmin()` undefined during `package:discover`

## Symptom

During Composer scripts:

- `Generating optimized autoload files`
- `Illuminate\\Foundation\\ComposerScripts::postAutoloadDump`
- `@php artisan package:discover --ansi`

The process fails with:

- `Call to undefined function Modules\\Tenant\\Services\\inAdmin()`

## Root cause

`TenantService::config()` (and the morph-map resolver) relied on a global helper function `inAdmin()`.

In this codebase the authoritative implementation is `Modules\\Xot\\Services\\RouteService::inAdmin()`.
The `inAdmin()` helper is expected to be a thin wrapper around that service, but during `package:discover` it is **not guaranteed** that helper files are already loaded/available in the current execution context.

As a result, calling `inAdmin()` directly can break Composer automation.

## Fix

- Replace `getModuleModels()` helper function calls with direct use of `GetAllModelsByModuleNameAction` in critical bootstrap paths.
- This ensures actions are always available via service container, while helper functions might not be loaded during `package:discover`.

## Files changed

- `Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php` - Replaced `getModuleModels()` with direct action call
- `Modules/Tenant/app/Actions/Models/ResolveTenantModelClassAction.php` - Replaced `getModuleModels()` with direct action call

## Solution Details

**Problem**: Helper functions (`getModuleModels()`) are loaded via `"files": ["Helpers/Helper.php"]` in `composer.json`, but during `package:discover`, the autoload order is not guaranteed.

**Solution**: Use actions directly instead of helper functions in critical bootstrap paths:

```php
// ❌ BEFORE - Helper function (may not be loaded)
$models = getModuleModels($moduleName);

// ✅ AFTER - Direct action call (always available)
/** @var \Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction $action */
$action = app(\Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction::class);
$models = $action->execute($moduleName);
```

**Why this works**: Actions are registered in the service container and are always available, regardless of autoload order.

## Notes

This follows the existing architecture documented in `Modules/Xot/docs/helpers-architecture-analysis.md`:

- Helper functions are convenience wrappers
- Services contain the real logic

In critical bootstrap paths (Composer scripts, service providers, config resolution), prefer the service method instead of relying on helper autoload order.

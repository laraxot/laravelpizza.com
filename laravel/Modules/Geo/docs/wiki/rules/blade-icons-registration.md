---
name: Blade Icons Registration Rule
description: Ensure that Blade UI Icons are only registered in XotBaseServiceProvider to avoid duplicate registrations.
---

# Blade Icons Registration Rule

**Scope:** All Laravel modules within this project.

## Rule
- **Do NOT** register Blade UI Icons (using `BladeIconsFactory`) in any module ServiceProvider other than `Modules\Xot\Providers\XotBaseServiceProvider`.
- **Do** rely on `XotBaseServiceProvider::registerBladeIcons()` which automatically discovers SVG assets under each module’s `resources/svg/` directory and registers them with the appropriate prefix.

## Why
- Prevents duplicate icon namespace collisions.
- Centralises asset discovery, keeping module ServiceProviders focused on their own concerns (e.g., routes, bindings, assets unrelated to icons).
- Aligns with the DRY + KISS principle: one place to manage icon registration.

## How to Verify
1. Search the codebase for `BladeIconsFactory::class` registrations.
2. Ensure the only occurrence is within `Modules/Xot/app/Providers/XotBaseServiceProvider.php`.
3. Run the test suite; any duplicate registration will cause a runtime error when icons are resolved.

## Related Documentation
- `Modules/Xot/app/Providers/XotBaseServiceProvider.php` – central registration logic.
- `Modules/Geo/docs/wiki/concepts/blade-icons-registration.md` – module‑specific note (this file).

## Enforcement
- Linter rule (custom): flag any `callAfterResolving(BladeIconsFactory::class, …)` outside of `XotBaseServiceProvider`.
- CI step: `phpstan` will raise an error if duplicate registration is detected.

*Last updated: 2026-04-27*
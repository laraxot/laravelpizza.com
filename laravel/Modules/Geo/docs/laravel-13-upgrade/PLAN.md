# Plan: Laravel 13 Upgrade

## Phase 1: Global Documentation
- Create a master upgrade guide in `docs/laravel-13-upgrade/UPGRADE_GUIDE.md`.
- Document the R-R-S-U sequence for each module.

## Phase 2: Root Configuration Update
- Update `laravel/composer.json` to target Laravel 13 and Laravel Modules v13.
- Ensure all core dependencies are compatible.

## Phase 3: Module & Theme Updates (Iterative)
For each module in `laravel/Modules/` and theme in `laravel/Themes/`:
1.  **Read:** Analyze current `composer.json` and `docs/`.
2.  **Reason:** Determine specific changes needed (dependencies, namespaces).
3.  **Study:** Check if any custom logic needs adjustment for Laravel 13.
4.  **Update Docs:** Create/Update `docs/laravel-13-upgrade.md` within the module/theme.
5.  **Update Code:** Apply changes to `composer.json`.

## Phase 4: Verification
- Run `composer update` in the root.
- Run `php artisan module:publish-stubs`.
- Run `php artisan optimize:clear`.
- Execute Quality Gates (PHPStan Level 10, Pest tests) across all modules.

## Timeline
1.  **Preparation:** Research & Global Docs (Completed)
2.  **Execution:** Batch update of 35 modules + 3 themes.
3.  **Finalization:** Verification & Bug fixing.

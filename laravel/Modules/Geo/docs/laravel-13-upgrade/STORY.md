# Story: Laravel 13 Upgrade

## Description
Update the entire modular project to Laravel 13. This includes the root application, all 35 modules, and 3 themes.

## Goals
- Complete upgrade to Laravel 13.
- Upgrade `nwidart/laravel-modules` to ^13.0.
- Ensure all modules and themes are compatible and properly documented.
- 100% PHPStan Level 10 compliance on all updated files.

## Tasks
- [x] Update root `laravel/composer.json` to PHP 8.3 and Laravel 13.
- [x] Update `wikimedia/composer-merge-plugin` configuration.
- [x] Iterate through all modules and update their `composer.json`.
- [x] Iterate through all themes and update their `composer.json`.
- [x] Update `docs/` in each module with `laravel-13-upgrade.md`.
- [ ] Run `composer update` and verify dependencies. (Manual step recommended)
- [ ] Run PHPStan Level 10 on each module. (Manual step recommended)
- [ ] Run Pest tests for critical modules. (Manual step recommended)

## Acceptance Criteria
- Framework boots successfully on Laravel 13.
- All modules are loaded correctly.
- All `composer.json` files specify PHP ^8.3 and compatible Laravel version.
- Documentation for the upgrade is present in every module.

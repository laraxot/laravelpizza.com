# Research: Laravel 13 Upgrade for Modular Project

## Overview
This document outlines the research findings for upgrading a modular Laravel project (using `nWidart/laravel-modules`) to Laravel 13.

## Core Requirements
- **PHP Version:** PHP 8.3 or higher is mandatory. (Current: 8.3.30)
- **Laravel Framework:** `^13.0`
- **Laravel Modules:** `^13.0`
- **Composer Plugin:** `wikimedia/composer-merge-plugin` is used for module-level dependency management.

## Architectural Shifts in Laravel Modules v13
- **Mini-Application Pattern:** Modules are treated as standalone mini-applications with their own `app/` directory.
- **Automatic Discovery:** Improved discovery for service providers, routes, and migrations.
- **Dropped Support:** Legacy helper methods and PHP versions < 8.3 are no longer supported.

## Composer Configuration Changes
### Root `composer.json`
- Update `php` constraint to `^8.3`.
- Update `laravel/framework` to `^13.0`.
- Update `nwidart/laravel-modules` to `^13.0`.
- Ensure `wikimedia/composer-merge-plugin` is configured to include `Modules/*/composer.json` and `Themes/*/composer.json`.

### Module/Theme `composer.json`
- Each module/theme should define its own dependencies and PSR-4 autoloading.
- Recommend setting `laravel/framework` and `nwidart/laravel-modules` to compatible versions (e.g., `^13.0`).

## Compatibility Matrix
| Component | Current Version | Target Version |
| :--- | :--- | :--- |
| PHP | 8.3.30 | ^8.3 |
| Laravel Framework | ^12.3 | ^13.0 |
| Laravel Modules | * (v12 compatible) | ^13.0 |
| Filament | ^5.0 | ^5.0 (Check compatibility) |

## Identified Tasks
1. Update Root `composer.json`.
2. Update all Module `composer.json` files.
3. Update all Theme `composer.json` files.
4. Update `docs/` in each module/theme with upgrade documentation.
5. Verify structural integrity with PHPStan and Tests.

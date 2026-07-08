# Browsershot Missing Dependency

## Problem
PHPStan reports that `Spatie\Browsershot\Browsershot` class is not found in `Modules/Xot/app/Actions/Pdf/MakePdfSpatieTestAction.php`, even if the library seems to be present in the `vendor` directory.

## Root Cause
1. **Autoloader Sync**: The library was listed in `Modules/Xot/composer.json` but not correctly synced in the main `laravel/composer.lock` or the autoloader was not updated.
2. **Version Conflicts**: Attempting to run `composer update` failed because of a conflict between Laravel 13 (required in `composer.json`) and the environment running PHP 8.3 (Laravel 13 requires PHP 8.4).
3. **Missing Peer Dependencies**: `spatie/laravel-pdf` was being used but not listed in the module's `composer.json`.

## Solution
1. **Align Laravel Version**: Downgrade `laravel/framework` and related packages (`nwidart/laravel-modules`, `orchestra/testbench`, etc.) to `^12.0` in both the root `composer.json` and `Modules/Xot/composer.json` to match the PHP 8.3 environment.
2. **Add Missing Dependencies**: Explicitly add `spatie/laravel-pdf` to `Modules/Xot/composer.json`.
3. **Sync Dependencies**: Run `composer update -W` from the `laravel` directory to regenerate the lock file and the autoloader.

## Verification
Run PHPStan on the affected file:
```bash
cd laravel && vendor/bin/phpstan analyse Modules/Xot/app/Actions/Pdf/MakePdfSpatieTestAction.php
```
It should report "No errors".

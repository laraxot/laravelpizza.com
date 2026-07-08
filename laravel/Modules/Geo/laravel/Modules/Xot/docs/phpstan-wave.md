<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| PHPStan Notes For Shared Xot Types
|--------------------------------------------------------------------------
|
| Shared fixes applied in this wave:
| - Removed legacy Doctrine-style schema diff logic from
|   `XotBaseMigration::tableUpdate()` and aligned it with Laravel 12.
| - Normalized `UnitEnum` database connection names in pivot base models.
| - Repaired typed Filament action callbacks that were calling services
|   through mixed closures.
| - Replaced unguarded helper calls with typed arrays / Safe functions.
|
| Operational rule:
| - When a cross-module PHPStan error comes from Xot, fix the shared base
|   contract first, then re-run the target module before reopening callers.
| - At `phpstan level: max`, shared model contracts must expose explicit
|   return types for framework methods mirrored in interfaces, including
|   `getKey(): mixed` and `getRelationValue(string): mixed`.
|
*/

# Fix Data Property Type Mismatch

**Module**: IndennitaResponsabilita
**Context**: PHP Fatal Error due to property type mismatch in Filament pages
**Date**: 2026-03-31
**Status**: Investigating / Fixing

## Problem
A `FatalError` occurs in `CompilaIndennitaResponsabilita` and `SendMailIndennitaResponsabilita` pages:
`Type of ...::$data must be array (as in class Modules\Xot\Filament\Resources\Pages\XotBasePage)`

This error indicates that the `$data` property in the child classes is not compatible with the one in the parent class `XotBasePage`.

## Analysis
- `XotBasePage` defines `public array $data = [];`.
- The child classes also define `public array $data = [];`.
- Although they appear identical, PHP 8.3 might be stricter about redeclaring typed properties in inheritance, or there might be a conflict with traits (like `InteractsWithRecord` or `InteractsWithForms`).

## Solution
Remove the redundant declaration of `public array $data = [];` from the child classes. Since they extend `XotBasePage`, they will inherit the correctly typed property from the parent. This adheres to the DRY principle and avoids potential type mismatch conflicts.

## Impact
- `CompilaIndennitaResponsabilita.php`: Remove line 66.
- `SendMailIndennitaResponsabilita.php`: Remove line 21.

## Verification
- Run `php artisan filament:optimize` (if applicable)
- Access the pages in the browser to ensure the `FatalError` is resolved.
- Run PHPStan to verify type safety.

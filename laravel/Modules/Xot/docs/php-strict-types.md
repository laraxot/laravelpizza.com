---
title: "PHP Strict Types in Laravel Modules"
type: note
status: draft
updated: 2026-10-18
tags: [docs, xot]
qmd: "php strict types in laravel modules xot"
---
# PHP Strict Types in Laravel Modules

## Overview
This document provides guidelines for using strict typing in PHP within a Laravel module, ensuring type safety and reducing runtime errors.

## Key Principles
1. **Type Safety**: Strict typing enforces type checks at runtime, preventing unexpected type coercion.
2. **Code Reliability**: Explicit type declarations improve code reliability and readability.

## Implementation Guidelines
### 1. Declare Strict Types
- `declare(strict_types=1);` è la **prima istruzione** dopo `<?php` (riga vuota in mezzo). **Mai** prima del tag di apertura: PHP fatale `strict_types declaration must be the very first statement`.
- Vale per ogni `.php` (app, lang, routes, config, test) e per ogni `.blade.php`.
- Blade senza PHP in testa: **prepend** il blocco, non sostituire i primi byte (un replace cieco ha già mangiato `@extends` → `nds` e `<!DOCTYPE` → `TYPE html>`).
  ```php
  <?php

  declare(strict_types=1);

  ?>
  ```
- `mixed` solo ultima spiaggia: JSON / metadata / config bag vendor / firma vendor (Filament `formatStateUsing`, `ValidationRule::validate`). Preferire union, shape `array{…}`, `Assert::isInstanceOf`. Niente `@var mixed` per zittire PHPStan.
- Collegato: [coverage Theme Zero](../../../Themes/Zero/docs/php-quality-gates-rule.md), campagna [strict-types-mixed-campaign](../../../../docs/chat/strict-types-mixed-campaign.md).

### 2. Function and Method Signatures
- Use type hints for parameters and return types in all function and method declarations.
  ```php
  public function processData(string $input, int $count): array
  {
      // Process data
      return [];
  }
  ```

### 3. Nullable Types
- Use nullable types when a parameter or return value can be null.
  ```php
  public function findItem(?int $id): ?Item
  {
      // Find item or return null
      return null;
  }
  ```

## Common Issues and Fixes
- **Missing Strict Declaration**: Ensure `declare(strict_types=1);` is at the top of every PHP file to avoid loose typing.
- **Type Mismatch Errors**: Correct type mismatches by updating type hints or handling nullable cases appropriately.

## Testing and Verification
- Use static analysis tools like PHPStan to verify strict type adherence across the codebase.
- Test edge cases with different data types to ensure strict typing behaves as expected.

## Documentation and Updates
- Document any exceptions to strict typing rules in the relevant module's documentation folder.
- Update this document if new strict typing features or practices are introduced in PHP.

## Links to Related Documentation
- [Code Quality](code_quality.md)
- [PHPStan Implementation Guide](phpstan-implementation-guide.md)
- [Naming Conventions](naming-conventions.md)
- [Service Provider Best Practices](service-provider-best-practices.md)
- [Filament Best Practices](filament-best-practices.md)

## 2026-09-21: follow-up 2 blade

**Perché**: wizard submit e PDF Spatie sono punti di uscita (click / byte PDF).
Senza `declare` sulla vista, i tipi già strict in `XotBase*` possono essere
coerciti dal template. `XotBaseComponent` non si converte: solo la vista.

**Fatto** (prepend, `@if` e `<!DOCTYPE` intatti):
- `resources/views/filament/wizard/submit-button.blade.php`
- `resources/views/pdf/spatie-test.blade.php`

Campagna: [strict-types-mixed-campaign](../../../../docs/chat/strict-types-mixed-campaign.md).

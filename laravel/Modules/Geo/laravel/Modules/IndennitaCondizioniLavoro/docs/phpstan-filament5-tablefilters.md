---
title: "PHPStan Filament tableFilters"
module: "IndennitaCondizioniLavoro"
type: guide
tags: [phpstan, filament, tablefilters, actions]
created: 2026-06-18
updated: 2026-06-18
qmd: "phpstan filament tableFilters nullable array null makepdf replicateindennita"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/136"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - "./wiki/concepts/filament-tablefilters-nullable.md"
  - "./phpstan-improvements.md"
---

# PHPStan Filament tableFilters

**Status**: resolved
**Updated**: 2026-06-18
**Issue Type**: `argument.type` with `array|null` input
**Severity**: medium

## Problem

Filament header actions use `$this->tableFilters` to access table filters:

- `CondizioniLavoroAdmsTable.php` passes filters to `ReplicateIndennita`.
- `CondizioniLavorosTable.php` passes filters to `MakePdf` and `ReplicateIndennita`.

`$this->tableFilters` can be `array|null`, while the action contracts previously accepted only `array<string, mixed>`.

## Applied Solution

The action contracts now match the real input surface and validate it internally:

```php
/**
 * @param array<string, mixed>|null $data
 */
public function execute(?array $data): void
{
    $input = $data['anno/valutatore'] ?? $data;

    if (! is_array($input)) {
        throw new InvalidArgumentException('Parametro filtri non valido.');
    }
}
```

## Why

Adding only a local `@var array<string, mixed>` around `$this->tableFilters` can hide the nullable branch. The safer contract is explicit `?array` on the action plus domain validation before accessing filter keys.

## Relationship to Xot

Xot export actions also read `tableFilters` from Filament/Livewire contexts. When a module action receives those filters directly, the receiving action should declare the nullable boundary or the caller should normalize before the call.

## Impact

**Functionality**: filters are still accepted nested (`anno/valutatore`) or flat.
**Type Safety**: PHPStan module scan passes.
**User Impact**: invalid or missing filters throw controlled `InvalidArgumentException`.

## Verification

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/IndennitaCondizioniLavoro
./vendor/bin/pest Modules/IndennitaCondizioniLavoro/tests
```

## Related

- [Wiki concept](./wiki/concepts/filament-tablefilters-nullable.md)
- [Root PHPStan pattern](../../../../docs/wiki/phpstan/filament-tablefilters-nullable.md)
- `Modules/Xot/app/Filament/Actions/Header/ExportXlsAction.php`

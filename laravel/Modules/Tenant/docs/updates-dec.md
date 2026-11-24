---
issues: []
discussions: []
title: "Tenant Module Updates - December 2025"
module: "Tenant"
type: concept
tags: [updates, dec]
created: 2026-07-14
updated: 2026-07-14
qmd: "updates dec"
related:
  - "./phpstan-corrections-january.md"
---
# Tenant Module Updates - December 2025

## PHPStan Fixes
- **DocBlock Updates**: Fixed `class.notFound` errors in `Tenant`, `Domain`, and `TestSushiModel` by replacing incorrect `modulo operativo` and `modulo questionari` profile references with `Modules\Xot\Contracts\ProfileContract`.
- **Helper Functions**: Added `getAllModulesModels` and `array_merge_recursive_distinct` to `Modules/Xot/helpers/Helper.php` to resolve undefined function errors.
- **TenantService Refactor**: Adhering to the "Fat Model, Skinny Controller" (and Service) philosophy, all business logic has been extracted into dedicated Action classes:
    - `GetTenantFilePathAction`
    - `ResolveTenantConfigValueAction`
    - `GetTenantConfigPathAction`
    - `GetTenantConfigArrayAction`
    - `SaveTenantConfigAction`
    - `ResolveTenantModelClassAction`
    - `ResolveTenantModelInstanceAction`
    - `GetLocalizedMarkdownPathAction`
    - `TranslateTenantKeyAction`
    - `GetTenantConfigNamesAction`
    - `GetTenantModulesAction`
- **TenantService::trans**: Enhanced the `trans` method to safely handle missing translation files, returning the key instead of throwing a `FileNotFoundException`. This fixed test failures in dependent modules.

## Architectural Alignment
This module adheres to the **Super Cow Methodology**:
- **Compliance**: Module now passes PHPStan analysis at Level 10.
- **Documentation**: Referenced core architecture rules in `Modules/Xot/docs/`.

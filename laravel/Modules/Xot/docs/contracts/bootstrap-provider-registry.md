---
title: "Bootstrap provider registry contract"
type: contract
qmd: "bootstrap provider registry contract"
---
# Bootstrap provider registry contract

```yaml
type: framework-contract
owner: bootstrap/providers.php
input: Laravel application bootstrap
output: framework provider registry containing AppServiceProvider
```

## Invariants

- `BOOTSTRAP-PROVIDERS-001`: `bootstrap/providers.php` returns only `App\Providers\AppServiceProvider::class`, matching the Laravel 13 application skeleton.
- `BOOTSTRAP-PROVIDERS-002`: module providers are discovered through Composer and module registration; they are not duplicated in the bootstrap registry.
- `BOOTSTRAP-PROVIDERS-003`: application-specific Filament panel registration remains in `AppServiceProvider`.

## Non-goals

This registry is not a second module provider list and does not replace module service-provider discovery.

---
title: "testing"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-18
qmd: "testing"
issues: []
discussions: []
status: draft
---

# Testing in the Geo Module

## Overview
This document describes the testing approach for the Geo module in the Quaeris Fila4 Mono project.

## Test Structure
The Geo module contains the following types of tests:

### Feature Tests
- `AddressIntegrationTest` - Tests address integration with other models
- Located in `Modules/Geo/tests/Feature/`

### Unit Tests
- `CalculateDistanceActionTest` - Tests for distance calculation functionality
- `GetCoordinatesActionTest` - Tests for coordinate retrieval functionality
- Located in `Modules/Geo/tests/Unit/`

## PestPHP Format
All tests in the Geo module follow PestPHP format:
- Use `it()` or `test()` for test descriptions
- Use `PHPUnit\Framework\Assert` in unit business-logic tests analysed by PHPStan (no Pest `expect()` higher-order there: crashes `pest-plugin-phpstan`)
- Use `beforeEach()` for setup
- Sushi models: assert column types via public `getSchema()` (Comune via `SushiToJson::getSchema()`, Region/Province via Sushi)

## PHPStan + Pest (campagna Internal error)

Durante `phpstan analyse Modules/Geo`, chain Pest `expect()->…` possono far
crashare `HigherOrderExpectationTypeExtension` (`Internal error` → modulo
intero non analizzato).

**Fix:** nei test unitari di sola business logic del modello
(`tests/Unit/Models/*BusinessLogicTest.php`) usare **solo**
`PHPUnit\Framework\Assert`, senza higher-order `expect()`.

**Vietato:** escludere `tests/` in `phpstan.neon` o `@phpstan-ignore-file` sui
test. SSoT campagna: [Notify — pattern Pest](../../Notify/docs/wiki/memories/phpstan-pest-patterns-modulo-notify.md).

## Database Handling
- Use `DatabaseTransactions` instead of `RefreshDatabase` for proper isolation
- This is important for multi-tenant architecture compatibility

## External Service Mocking
- Mock external services like Google Maps API using `Http::fake()`
- Set configuration values using `Config::set()`
- Test both success and failure scenarios

## Testing Best Practices
- Follow DRY, KISS, SOLID principles
- Write robust, maintainable tests
- Test edge cases and error conditions
- Use descriptive test names

## Common Issues
Some Geo module tests may fail during initialization due to complex application setup requirements. This is typically an architectural issue related to the multi-tenant system rather than problems with the Geo module code itself.

## Running Tests
To run all Geo module tests:
```bash
./vendor/bin/pest Modules/Geo/tests/
```

To run specific test files:
```bash
./vendor/bin/pest Modules/Geo/tests/Unit/Actions/CalculateDistanceActionTest.php
./vendor/bin/pest Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php
```
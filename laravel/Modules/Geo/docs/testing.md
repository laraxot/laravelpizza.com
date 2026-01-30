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
- Use `it()` for test descriptions
- Use `expect()` for assertions
- Use `beforeEach()` for setup

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
# Tenant Module - PHPStan Error Resolution Roadmap

This document outlines the steps to resolve the numerous PHPStan errors found in the Tenant module.

## Error Summary

The errors in the Tenant module are widespread and primarily stem from a few core issues:

1.  **Improper Model Instantiation in Tests**: Models are not being created with the correct factories or types, leading to a massive number of errors where methods and properties are accessed on `mixed` types.
2.  **Unsafe JSON Functions**: `json_decode` and `json_encode` are used without the `thecodingmachine/safe` library, which can lead to unexpected `false` return values.
3.  **PHPUnit to Pest Conversion Issues**: Many tests appear to be partially converted from PHPUnit to Pest, resulting in undefined properties and methods (e.g., `$this->mock()`, `$this->baseModel`).
4.  **Missing Type Hinting**: General lack of type hinting for variables and return types, exacerbating the `mixed` type problem.
5.  **Class Not Found**: The `Modules\Tenant\Models\TenantUser` class is not found in `Tenant/Tests/Pest.php`.
6.  **Undefined Method in TestCase**: `loadLaravelMigrations()` is called but not defined in `Tenant/Tests/TestCase.php`.

## Resolution Plan

I will tackle these issues systematically, starting with the foundational problems.

### 1. Fix Core Test Infrastructure

1.  **`Tenant/Tests/TestCase.php`**: Remove the call to the undefined method `loadLaravelMigrations()`. This is likely a remnant of an older Laravel version.
2.  **`Tenant/Tests/Pest.php`**:
    *   Resolve the `Modules\Tenant\Models\TenantUser` class not found error. This might involve creating the model or correcting the namespace.
    *   Replace PHPUnit's `$this` with Pest's expectation syntax where appropriate.
    *   Properly define the helper functions (`createTenant`, `makeTenant`, etc.) to return the correct model types.

### 2. Address `mixed` Type Errors in Tests

This is the largest group of errors. I will go through each test file and apply the following strategy:

1.  **`TenantBusinessLogicTest.php`**:
    *   Identify all calls to `::create()` and `::make()` that result in a `mixed` type.
    *   Ensure that the model factories are used correctly and that the results are assigned to variables with the correct model type hint.
    *   For example, instead of `$tenant = Tenant::factory()->create()`, use `/** @var \Modules\Tenant\Models\Tenant $tenant */ $tenant = Tenant::factory()->create();` if type inference is failing, or ensure the factory's `@return` tag is correct.

2.  **`SushiToJsonIntegrationTest.php`**:
    *   Apply the same model factory fixes as above.
    *   Replace all `json_decode` calls with `Safe\json_decode`. I will add `use function Safe\json_decode;` to the top of the file.
    *   Add type hints to the decoded data to resolve the "Cannot access offset..." errors.

3.  **`SushiToJsonPerformanceTest.php`**:
    *   Apply the same fixes as in the integration test.

4.  **`SushiToJsonTraitPestTest.php` & `SushiToJsonTraitTest.php`**:
    *   These files have many undefined properties. It seems they were intended to be used with a test class that had these properties defined. I will refactor these tests to properly set up the test data and mock objects.
    *   I will replace calls to `$this->mock()` with `\Mockery::mock()`.
    *   I will replace unsafe `json_encode` and `json_decode` with their `safe` equivalents.

5.  **`BaseModelTest.php`**:
    *   Define the `$baseModel` property in the test class.
    *   Refactor the test to be a proper Pest test.

6.  **`domaintest.php`**:
    *   Replace `$this->mock()` with `\Mockery::mock()`.
    *   Add type hints to resolve the offset access on `mixed` errors.

### 3. Final Cleanup

After fixing the main issues, I will perform a final pass to:

*   Ensure all new code adheres to the project's coding standards.
*   Add any missing type hints.
*   Run `phpstan analyse Modules/Tenant` repeatedly until all errors are resolved.

This is a significant refactoring effort, but by tackling it systematically, I can bring the `Tenant` module's tests to a clean and reliable state.

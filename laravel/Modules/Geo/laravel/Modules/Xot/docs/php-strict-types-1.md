# PHP Strict Types in Laravel Modules

## Overview
This document provides guidelines for using strict typing in PHP within a Laravel module, ensuring type safety and reducing runtime errors.

## Key Principles
1. **Type Safety**: Strict typing enforces type checks at runtime, preventing unexpected type coercion.
2. **Code Reliability**: Explicit type declarations improve code reliability and readability.

## Implementation Guidelines
### 1. Declare Strict Types
- Always declare strict types at the top of every PHP file to enable strict type checking.
  ```php
  declare(strict_types=1);
  ```

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
- [Code Quality](./CODE_QUALITY.md)
- [PHPStan Implementation Guide](./PHPSTAN-IMPLEMENTATION-GUIDE.md)
- [Naming Conventions](./NAMING-CONVENTIONS.md)
- [Service Provider Best Practices](./SERVICE-PROVIDER-BEST-PRACTICES.md)
- [Filament Best Practices](./FILAMENT-BEST-PRACTICES.md)

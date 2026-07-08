# PHPStan Level 10 Analysis - Pdnd Module

## Status
- **Module**: Pdnd (PDND Integration)
- **Files**: 146
- **Initial Errors**: 115
- **Current Errors**: 6 (Down from 115)

## Error Patterns

### 1. Service Model Type Mismatches (ANPR)
- **Description**: Issue with array shapes and generic types in ANPR service models (C030, C007, etc.).
- **Example**: `Property TipoDatiSoggettiEnte::$listaSoggettiEnte (array<Modules\Pdnd...>) does not accept array<int, Modules\Pdnd...>|null`.

### 2. Null Coalescing & Type Casting
- **Description**: Method arguments or return types are not strictly matching nullable/mixed values.

### 3. Missing PHPDoc Generics
- **Description**: Collections and models missing generic type hints.

## Roadmap

- [x] Study ANPR service models structure
- [x] Fix property type hints in response models
- [x] Clarify array vs null in collection methods
- [x] Standardize fromArray methods with explicit type checking
- [x] Refactor Filament pages for safe response handling
- [/] Resolve remaining 6 errors (mostly redundant null-coalescing)
- [ ] Final verification with PHPMD and PHPInsights
- [ ] Achievement: 0 errors ✅

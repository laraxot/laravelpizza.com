# PHPStan Level 10 Analysis - 2025-03-11

## Overview

This document provides a comprehensive analysis of issues identified by PHPStan at level 10 (maximum) across the Modules directory. The goal is to systematically document, study, and fix each category of issues to improve code quality and type safety.

## Common Issue Categories

### 1. Method Calls on Mixed Types

Many errors involve attempting to call methods on variables with a `mixed` type, for example:

```php
Cannot call method from() on mixed.
Cannot call method select() on mixed.
Cannot call method whereNotNull() on mixed.
```

**Modules Affected:**
- Brain
- Broker
- Xot

**Solution Approach:**
1. Add proper type assertions or type checking before method calls
2. Use PHPDoc annotations to specify correct types
3. Consider adding explicit type hints for variables

### 2. Invalid Parameter Types

Issues where parameter types don't match what methods expect:

```php
Parameter #3 $value of method Illuminate\Database\Eloquent\Builder<Illuminate\Database\Eloquent\Model>::whereYear() expects DateTimeInterface|int|string|null, mixed given.
Parameter #2 ...$values of function sprintf expects bool|float|int|string|null, mixed given.
```

**Modules Affected:**
- Broker
- Xot
- User

**Solution Approach:**
1. Add explicit type casts where appropriate
2. Validate input types before method calls
3. Update method signatures to use correct type hints

### 3. Array Access on Mixed Types

Errors occur when trying to access array indexes on variables that might not be arrays:

```php
Cannot access offset 'tables' on mixed.
Cannot access offset 'relationships' on mixed.
```

**Modules Affected:**
- Xot (Console Commands)

**Solution Approach:**
1. Add type assertions using `assert()` or `is_array()`
2. Add PHPDoc type annotations
3. Consider using helper functions to safely access array data

### 4. Non-Iterable Values in Foreach

Errors when using foreach on variables that might not be iterable:

```php
Argument of an invalid type mixed supplied for foreach, only iterables are supported.
```

**Modules Affected:**
- Xot (Console Commands)

**Solution Approach:**
1. Add type checking before foreach loops
2. Use empty array as default when iterating potentially non-iterable values
3. Add proper PHPDoc annotations

### 5. Template Type Covariance Issues

Issues related to improper typing of Eloquent relationship methods:

```php
Template type T is not covariant.
```

**Modules Affected:**
- User
- Broker

**Solution Approach:**
1. Update PHPDoc annotations to use the correct format for relations
2. Remove the second type parameter from BelongsToMany relations
3. Use static or self for recursive class references

## Priority Issues

Based on the volume and impact of issues, we will address them in the following order:

1. Fix DatabaseSchemaExportCommand in Xot module (many mixed type issues)
2. Fix GenerateModelsFromSchemaCommand in Xot module
3. Address remaining method calls on mixed types in Brain and Broker modules
4. Fix parameter type issues in various modules
5. Complete the template type covariance fixes in all modules

## Next Steps

1. Fix each issue category one by one
2. Document the specific changes made
3. Re-run PHPStan after each batch of fixes to verify improvements
4. Update this document with progress and any new insights

## Progress Tracking

- [ ] DatabaseSchemaExportCommand fixes
- [ ] GenerateModelsFromSchemaCommand fixes
- [ ] Method calls on mixed types in Brain and Broker
- [ ] Parameter type issues
- [ ] Template type covariance fixes
- [ ] Final verification

# PHPStan Fixes and Type System Improvements

## Overview

This document outlines the systematic fixes applied to resolve PHPStan errors in the codebase, with particular focus on type system improvements and architectural consistency.

## 1. View-String Type Issue

### Problem
PHPStan was reporting errors for static properties `$view` in Widget classes:
```
Static property Modules\User\Filament\Widgets\EditUserWidget::$view (view-string) does not accept default value of type string.
```

### Root Cause
The Filament Widget base class uses `view-string` in PHPDoc annotations but declares the property as `string`:
```php
/**
 * @var view-string
 */
protected static string $view;
```

### Solution
Use proper PHPDoc annotations to maintain type safety while keeping the `string` declaration:

```php
/**
 * @var string
 */
protected static string $view = 'pub_theme::filament.widgets.edit-user';
```

### Files Fixed
- `Modules/User/app/Filament/Widgets/EditUserWidget.php`
- `Modules/User/app/Filament/Widgets/Auth/PasswordResetConfirmWidget.php`
- `Modules/User/app/Filament/Widgets/Auth/PasswordResetWidget.php`

## 2. Missing Class Errors

### Problem
PHPStan reports missing classes that are referenced but not found:
```
Class Modules\TechPlanner\Models\Cliente not found.
Class Modules\TechPlanner\Models\Apparecchio not found.
```

### Solution
These classes need to be created or the references need to be updated to use existing models.

### Files Requiring Action
- `Modules/TechPlanner/app/Console/Commands/ImportAccessDataCommand.php`
- `Modules/TechPlanner/app/Contracts/PivotContract.php`
- `Modules/TechPlanner/app/Contracts/WorkerContract.php`

## 3. Type Casting Issues

### Problem
Multiple instances of unsafe type casting:
```
Cannot cast mixed to string.
Cannot cast mixed to float.
```

### Solution
Add proper type checking before casting:

```php
// Before
$value = (string) $mixedValue;

// After
$value = is_string($mixedValue) ? $mixedValue : (string) $mixedValue;
```

## 4. Missing Type Declarations

### Problem
Methods and properties without type declarations:
```
Method Modules\TechPlanner\Models\Worker::setBirthDayAttribute() has parameter $value with no type specified.
```

### Solution
Add proper type declarations:

```php
public function setBirthDayAttribute($value): void
// Becomes
public function setBirthDayAttribute(mixed $value): void
```

## 5. Safe Function Usage

### Problem
Unsafe function usage detected by thecodingmachine/safe:
```
Function chmod is unsafe to use. It can return FALSE instead of throwing an exception.
```

### Solution
Use Safe functions:
```php
// Before
chmod($file, 0755);

// After
use function Safe\chmod;
chmod($file, 0755);
```

## 6. Filament Component Issues

### Problem
Incorrect class references and missing methods:
```
Call to static method make() on an unknown class Modules\TechPlanner\Filament\Resources\ClientResource\Pages\Filament\Infolists\Components\Section.
```

### Solution
Use correct Filament component classes:
```php
// Before
use Modules\TechPlanner\Filament\Resources\ClientResource\Pages\Filament\Infolists\Components\Section;

// After
use Filament\Infolists\Components\Section;
```

## Implementation Strategy

### Phase 1: Type System Fixes
1. Fix view-string type issues in Widget classes
2. Add missing type declarations
3. Fix unsafe type casting

### Phase 2: Missing Classes
1. Create missing model classes or update references
2. Fix contract and interface references

### Phase 3: Safe Functions
1. Replace unsafe functions with Safe equivalents
2. Add proper use statements

### Phase 4: Filament Components
1. Fix incorrect class references
2. Update component imports

## Best Practices

### 1. Type Declarations
- Always declare parameter and return types
- Use `mixed` type for parameters that can accept various types
- Add proper PHPDoc annotations for complex types

### 2. Safe Operations
- Use Safe functions for file operations
- Add proper error handling for type casting
- Validate data before operations

### 3. Filament Integration
- Always extend XotBase classes, never Filament classes directly
- Use correct component imports
- Follow the established architectural patterns

### 4. Documentation
- Update documentation when making architectural changes
- Document type system improvements
- Maintain consistency across modules

## Testing

After applying fixes:
1. Run PHPStan analysis: `./vendor/bin/phpstan analyse Modules`
2. Run tests: `php artisan test`
3. Verify Filament functionality
4. Check for any new errors introduced

## Notes

- The `view-string` type is a PHPStan-specific type for view template paths
- Safe functions provide exception-throwing alternatives to standard PHP functions
- All Filament components should extend XotBase classes for consistency
- Type system improvements enhance code reliability and maintainability 

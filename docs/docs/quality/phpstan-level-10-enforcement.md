# PHPStan Level 10 Enforcement - Quality Initiative

**Date**: 2025-10-22
**Objective**: Fix ALL PHPStan Level 10 errors across the entire Modules/ directory
**Initial Status**: 611 errors in 108 files

## Error Distribution by Module

| Module | Errors | Priority |
|--------|--------|----------|
<<<<<<< .merge_file_tJGdvu
| healthcare_app | 527 | HIGH (86% of total) |
=======
| ModuloEsempio | 527 | HIGH (86% of total) |
>>>>>>> .merge_file_qeuxeY
| User | 30 | MEDIUM |
| Xot | 24 | MEDIUM |
| Media | 20 | LOW |
| Notify | 10 | LOW |

## Error Distribution by Type

| Error Type | Count | Description |
|------------|-------|-------------|
| method.nonObject | 163 | Calling methods on mixed/unknown types |
| argument.type | 120 | Invalid argument types passed to methods |
| return.type | 53 | Return type doesn't match declaration |
| offsetAccess.nonOffsetAccessible | 39 | Array access on non-array types |
| property.nonObject | 38 | Accessing properties on mixed/unknown types |
| binaryOp.invalid | 24 | Invalid binary operations (e.g., string + int) |
| assign.propertyType | 23 | Property assignment type mismatch |
| method.notFound | 19 | Calling undefined methods |
| property.notFound | 19 | Accessing undefined properties |
| encapsedStringPart.nonString | 14 | Non-string interpolation |
| class.notFound | 13 | Unknown classes |
| staticMethod.alreadyNarrowedType | 13 | Unnecessary type checks |
| offsetAccess.invalidOffset | 9 | Invalid array key types |
| function.alreadyNarrowedType | 7 | Unnecessary type checks |
| foreach.nonIterable | 6 | foreach on non-iterable |
| missingType.return | 6 | Missing return type declarations |

## Fixing Strategy

### Phase 1: Small Modules (Complexity-Based)
1. **Media** (20 errors) - Mostly FFmpeg integration issues
2. **Notify** (10 errors) - Type safety improvements
3. **Xot** (24 errors) - Base classes and utilities
4. **User** (30 errors) - Authentication and authorization

### Phase 2: Large Module
<<<<<<< .merge_file_tJGdvu
5. **healthcare_app** (527 errors) - Survey management core - requires systematic approach
=======
5. **ModuloEsempio** (527 errors) - Survey management core - requires systematic approach
>>>>>>> .merge_file_qeuxeY

## Common Patterns & Solutions

### Pattern 1: Mixed Method Calls
**Problem**: `Cannot call method execute() on mixed`
```php
// ❌ BEFORE
$result = app($className)->execute($data);

// ✅ AFTER
/** @var ActionClass $action */
$action = app($className);
assert($action instanceof ActionClass);
$result = $action->execute($data);
```

### Pattern 2: Argument Type Mismatches
**Problem**: `Parameter #1 expects string, mixed given`
```php
// ❌ BEFORE
public function process($input) {
    return strtolower($input);
}

// ✅ AFTER
public function process(string $input): string {
    return strtolower($input);
}
```

### Pattern 3: Array Access on Mixed
**Problem**: `Cannot access offset on mixed`
```php
// ❌ BEFORE
$value = $data[$key];

// ✅ AFTER
assert(is_array($data));
assert(isset($data[$key]));
$value = $data[$key];
```

### Pattern 4: Property Access on Mixed
**Problem**: `Cannot access property on mixed`
```php
// ❌ BEFORE
$name = $model->name;

// ✅ AFTER
assert($model instanceof ExpectedModel);
$name = $model->name;
```

### Pattern 5: Unknown Classes
**Problem**: `PHPDoc tag contains unknown class`
```php
// ❌ BEFORE (missing import)
/** @var VideoExporter $exporter */

// ✅ AFTER
use ProtoneMedia\LaravelFFMpeg\Exporters\VideoExporter;
/** @var VideoExporter $exporter */
```

## PHPStan Level 10 Requirements

### 1. Explicit Type Declarations
- ALL parameters must have type hints
- ALL return types must be declared
- Use union types when necessary (`string|null`, `int|float`)

### 2. Use Safe Functions
```php
use function Safe\preg_match;
use function Safe\json_encode;
use function Safe\json_decode;
use function Safe\file_get_contents;
```

### 3. Handle Edge Cases
```php
public function getConnection(): ?string {
    if (isset($this->connection)) {
        $connection = $this->connection;

        // Handle UnitEnum edge case
        if ($connection instanceof \UnitEnum) {
            return null;
        }

        return $connection;
    }

    return null;
}
```

### 4. Array Shape Documentation
```php
/**
 * @return array{
 *     id: string,
 *     name: string,
 *     email: string|null,
 *     created_at: \Carbon\Carbon
 * }
 */
public function getUserData(): array {
    // ...
}
```

### 5. Generic Collections
```php
/**
 * @return \Illuminate\Support\Collection<int, string>
 */
public function getNames(): Collection {
    // ...
}
```

## Filament v4 Specific Considerations

### Widget::make() Static Method
Filament v4 widgets don't have a static `make()` method by default. Need to:
- Use `new WidgetClass()` instead
- Or implement static `make()` method if needed
- Check Filament v4 upgrade guide for widget instantiation

### Form Schema Methods
Filament v4 resources should use:
- `getFormSchema(): array` instead of `form(Form $form): Form`
- `getInfolistSchema(): array` instead of `infolist(Infolist $infolist): Infolist`

### Notification Changes
Check if Notification API changed in Filament v4:
- Static method calls
- Fluent methods chaining
- Send methods

## Module-Specific Notes

### Media Module
- **FFmpeg Integration**: Many errors related to `ProtoneMedia\LaravelFFMpeg` package
  - Check if package is installed: `composer show pbmedia/laravel-ffmpeg`
  - Add proper type hints and assertions
  - Handle VideoExporter null cases

- **Widget Issues**: `ConvertWidget` extends unknown `Widget` class
  - Should extend `Filament\Widgets\Widget` or module-specific base widget
  - Fix namespace imports

<<<<<<< .merge_file_tJGdvu
### healthcare_app Module
=======
### ModuloEsempio Module
>>>>>>> .merge_file_qeuxeY
- **Largest Error Source**: 527 errors require systematic approach
  - Many errors in Actions classes
  - Query builder type issues
  - Mixed return types from dynamic queries
  - Array access on uncertain types

### Xot Module
- **Base Classes**: Issues in `HasXotTable` trait
  - `getModelClass()` return type issues
  - Affects all resources using the trait

### User Module
- **Authentication Logic**: Type safety in auth flows
- **Relationship Access**: Mixed types from relationships

## Progress Tracking

- [x] Phase 1.1: Media module (0 errors - already compliant!)
- [x] Phase 1.2: Notify module (0 errors - already compliant!)
- [x] Phase 1.3: Xot module (12 → 0 errors - COMPLETED!)
- [🔄] Phase 1.4: User module (21 errors remaining)
<<<<<<< .merge_file_tJGdvu
- [ ] Phase 2: healthcare_app module (~444 errors remaining)
=======
- [ ] Phase 2: ModuloEsempio module (~444 errors remaining)
>>>>>>> .merge_file_qeuxeY
- [ ] Phase 3: Media recheck (7 new errors detected)
- [ ] Final: Run Pint formatting
- [ ] Final: Verify zero errors
- [x] Final: Update documentation (progress report created)

**Current Status**: 472 errors remaining (from 611 initial)
**Progress**: 139 errors fixed (22.8% complete)
**See**: `phpstan-progress-report.md` for detailed session notes

## Commands Reference

```bash
# Run PHPStan on all modules
./vendor/bin/phpstan analyse Modules --memory-limit=-1

# Run PHPStan on specific module
./vendor/bin/phpstan analyse Modules/Media --level=10

# Run PHPStan on specific file
./vendor/bin/phpstan analyse Modules/Media/app/Actions/Video/ConvertVideoAction.php --level=10

# Format code with Pint
./vendor/bin/pint --dirty

# Format specific files
./vendor/bin/pint Modules/Media/app/Actions/Video/ConvertVideoAction.php
```

## Resources

### Filament v4 Documentation
- https://filamentphp.com/docs/4.x/upgrade-guide
- https://filamentphp.com/content/leandrocfe-whats-new-in-filament-v4
- https://filamentphp.com/content/alexandersix-filament-v4-is-stable
- https://filamentexamples.com/tutorial/filament-v3-v4-upgrade

### PHPStan Documentation
- https://phpstan.org/user-guide/discovering-symbols
- https://phpstan.org/writing-php-code/phpdoc-types
- https://phpstan.org/user-guide/type-system

## Success Metrics

- **Target**: 0 errors at PHPStan Level 10
- **Current**: 611 errors
- **Reduction Required**: 100%
- **Files to Fix**: 108 files
- **No suppressions allowed**: All errors must be properly fixed

---

*This document will be updated as fixes progress. Each module section will contain detailed notes on specific fixes and patterns discovered.*

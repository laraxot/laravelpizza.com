# PHPInsights Analysis - Chart Module

**Date**: 2025-11-11
**PHPInsights Version**: 2.13.3
**Lines of Code**: 1,741

## Overall Scores

| Metric | Score | Status |
|--------|-------|--------|
| **Code** | 85.0% | ✅ Good |
| **Complexity** | 79.4% | ✅ Good |
| **Architecture** | 82.4% | ✅ Good |
| **Style** | 75.9% | ⚠️ Acceptable |

## Detailed Breakdown

### Code Quality (85.0%)

**Comments Distribution**:
- Comments: 49.5%
- Classes: 34.2%
- Functions: 0.0%
- Global: 16.4%

**Average Cyclomatic Complexity**: 2.18 (Good)

### Architecture (82.4%)

**File Distribution** (42 files):
- Classes: 100.0%
- Interfaces: 0.0%
- Traits: 0.0%
- Global code: 0.0%

## Issues Found

### 1. Forbidden Public Properties (60 occurrences)

**Affected File**: `Tables/Columns/ChartColumn.php`

**Lines**: 32, 42, 45, +57 more

**Issue**: Public properties should be replaced with method access

**Example**:
```php
// ❌ WRONG
public string $property;

// ✅ CORRECT
protected string $property;

public function getProperty(): string {
    return $this->property;
}
```

**Recommendation**: Encapsulate all public properties with getter/setter methods.

### 2. Forbidden Setter (1 occurrence)

**Affected File**: `Tables/Columns/ChartColumn.php:52`

**Issue**: Setters not allowed - use constructor injection instead

**Example**:
```php
// ❌ WRONG
public function setValue(mixed $value): void {
    $this->value = $value;
}

// ✅ CORRECT
public function __construct(mixed $value) {
    $this->value = $value;
}
```

### 3. Property Declaration - Underscore Prefix (3 occurrences)

**Affected File**: `Datas/AnswerData.php`

**Lines**: 24, 28, 30

**Properties**:
- `$_key`
- `$_sub`
- `$_sort`

**Issue**: Property names should not be prefixed with underscore

**Fix**:
```php
// ❌ WRONG
private string $_key;
private string $_sub;
private int $_sort;

// ✅ CORRECT
private string $key;
private string $sub;
private int $sort;
```

### 4. Unused Variables (2 occurrences)

**Affected Files**:
- `Models/Chart.php:126` - Unused variable `$msg`
- `Models/Policies/ChartBasePolicy.php:17` - Unused variable `$xotData`

**Fix**: Remove unused variables or use them

```php
// ❌ WRONG
$msg = ['message' => $error];
// $msg is never used

// ✅ CORRECT - Option 1: Use it
$msg = ['message' => $error];
logger()->error($msg);

// ✅ CORRECT - Option 2: Remove it
// Just remove the variable entirely
```

### 5. Disallow Equal Operators (1 occurrence)

**Affected File**: `Datas/AnswersChartData.php:417`

**Issue**: Use strict comparison `!==` instead of `!=`

**Fix**:
```php
// ❌ WRONG
if ($value != null) {

// ✅ CORRECT
if ($value !== null) {
```

### 6. Declare Strict Types Formatting (1 occurrence)

**Affected File**: `Filament/Widgets/Samples/Sample03Chart.php:3`

**Issue**: Expected 1 line after declare statement, found 0

**Fix**:
```php
// ❌ WRONG
<?php
declare(strict_types=1);
namespace Modules\Chart;

// ✅ CORRECT
<?php

declare(strict_types=1);

namespace Modules\Chart;
```

### 7. Explicit String Variables (Multiple occurrences)

**Affected File**: `Datas/AnswersChartData.php`

**Issue**: Variables in strings should use explicit braces

**Example Lines**: 280, 283, 293, 298, 301, 441, 444

**Fix**:
```php
// ❌ WRONG
$js = "title: $title";

// ✅ CORRECT
$js = "title: {$title}";
```

### 8. New with Braces (1 occurrence)

**Affected File**: `Actions/JpGraph/GetGraphAction.php:22`

**Fix**:
```php
// ❌ WRONG
$theme = new UniversalTheme;

// ✅ CORRECT
$theme = new UniversalTheme();
```

### 9. Invalid Inline Doc Comments (3 occurrences)

**Affected Files**:
- `Datas/AnswersChartData.php:193, 572`
- `Models/Chart.php:135`

**Issue**: Invalid format for inline documentation

**Fix**:
```php
// ❌ WRONG
/** @var array<string, mixed> */
$options = $this->getOptions();

// ✅ CORRECT
/** @var array<string, mixed> $options */
$options = $this->getOptions();
```

### 10. Disallow Mixed Type Hint (30 occurrences)

**Affected File**: `Tables/Columns/ChartColumn.php` and others

**Lines**: 90, 142, 150, +27 more

**Issue**: Mixed type hint is disallowed by coding standards

**Recommendation**: Use specific union types or interfaces instead of `mixed`

**Example**:
```php
// ❌ WRONG
public function setValue(mixed $value): void

// ✅ CORRECT
public function setValue(string|int|null $value): void
```

### 11. Missing Property Type Hints (16 occurrences)

**Affected Files**:
- `Models/MixedChart.php:34`
- `Providers/EventServiceProvider.php:16, 23`
- +13 more

**Issue**: Properties have PHPDoc but no native type hints

**Fix**:
```php
// ❌ WRONG
/** @var list<string> */
protected $fillable;

// ✅ CORRECT
/** @var list<string> */
protected array $fillable;
```

### 12. Missing Return Type Annotations (13 occurrences)

**Affected Files**:
- `Filament/Widgets/Samples/Sample02Chart.php:31`
- `Filament/Widgets/Samples/Sample03Chart.php:20, 43`
- +10 more

**Issue**: Methods returning arrays don't have `@return` annotations

**Fix**:
```php
// ❌ WRONG
public function getData() {
    return ['data' => $this->data];
}

// ✅ CORRECT
/**
 * @return array<string, mixed>
 */
public function getData(): array {
    return ['data' => $this->data];
}
```

### 13. Unused Parameters (11 occurrences)

**Affected Files**:
- `Models/Policies/MixedChartPolicy.php:47, 55, 63`
- +8 more

**Issue**: Policy methods with unused parameters

**Fix**: Either use the parameter or prefix with underscore

```php
// ❌ WRONG
public function delete(User $user, MixedChart $mixed_chart) {
    return $user->isAdmin();  // $mixed_chart not used
}

// ✅ CORRECT - Option 1: Prefix with underscore
public function delete(User $user, MixedChart $_mixed_chart) {
    return $user->isAdmin();
}

// ✅ CORRECT - Option 2: Use the parameter
public function delete(User $user, MixedChart $mixed_chart) {
    return $user->isAdmin() || $user->id === $mixed_chart->user_id;
}
```

### 14. Static Closure (2 occurrences)

**Affected Files**:
- `Actions/JpGraph/V1/Horizbar1Action.php:26`
- `Datas/ChartData.php:92`

**Issue**: Closures not using `$this` should be declared static

**Fix**:
```php
// ❌ WRONG
array_map(function($item) {
    return $item * 2;
}, $array);

// ✅ CORRECT
array_map(static function($item) {
    return $item * 2;
}, $array);
```

### 15. Return Assignment (5 occurrences)

**Affected Files**:
- `Datas/AnswersChartData.php:193, 421, 572`
- `Models/Chart.php:192, 197`

**Issue**: Unnecessary variable assignment before return

**Fix**:
```php
// ❌ WRONG
$options = $this->getOptions();
return $options;

// ✅ CORRECT
return $this->getOptions();
```

### 16. Complex Methods (14 occurrences)

**High Cyclomatic Complexity**:
- `Datas/AnswersChartData.php:getChartJsBarOptionsJs` - 12 complexity
- `Datas/AnswersChartData.php:getChartJsData` - 20 complexity (⚠️ Critical)
- `Datas/AnswersChartData.php` class - 17 total complexity
- `Models/Chart.php` class - 8 total complexity
- `Tables/Columns/ChartColumn.php` class - 8 total complexity

**Recommendation**: Refactor methods with complexity > 5 by extracting smaller methods

**Example Refactoring**:
```php
// ❌ WRONG - High complexity
public function getChartJsData(array $params): string {
    if ($condition1) {
        if ($condition2) {
            if ($condition3) {
                // nested logic
            }
        }
    }
    // ... 100 more lines
}

// ✅ CORRECT - Extracted methods
public function getChartJsData(array $params): string {
    return $this->buildChartConfig($params);
}

private function buildChartConfig(array $params): string {
    $config = $this->getBaseConfig();
    $config = $this->applyDatasets($config);
    return $this->serializeConfig($config);
}
```

## Priority Action Items

### High Priority (Should fix immediately)
1. ✅ Fix underscore-prefixed property names in `AnswerData.php`
2. ✅ Remove unused variables in `Chart.php` and `ChartBasePolicy.php`
3. ✅ Use strict comparison (`!==`) in `AnswersChartData.php`
4. ✅ Add braces to `new` statement in `GetGraphAction.php`
5. ✅ Remove unnecessary return assignments (5 occurrences)

### Medium Priority (Should fix soon)
6. ⚠️ Add explicit string variable braces in `AnswersChartData.php`
7. ⚠️ Fix declare strict types formatting in `Sample03Chart.php`
8. ⚠️ Make closures static where `$this` is not used (2 occurrences)
9. ⚠️ Add missing return type annotations (13 occurrences)
10. ⚠️ Handle unused policy parameters (11 occurrences)

### Low Priority (Can postpone)
11. 📝 Refactor complex methods (reduce cyclomatic complexity)
12. 📝 Replace `mixed` type hints with specific types (30 occurrences)
13. 📝 Add native property type hints (16 occurrences)
14. 📝 Encapsulate public properties in `ChartColumn.php` (60 occurrences)

## Estimated Fix Time

| Priority | Issues | Estimated Time |
|----------|--------|----------------|
| High | 5 items | 1-2 hours |
| Medium | 5 items | 2-3 hours |
| Low | 4 items | 4-6 hours |
| **Total** | | **7-11 hours** |

## Conclusion

The Chart module has good overall code quality (85.0%) but has room for improvement in style (75.9%). Most issues are straightforward to fix:

1. **Quick wins**: Remove unused vars, fix comparisons, add braces (1-2 hours)
2. **Code style**: Fix string interpolation, inline docs, static closures (2-3 hours)
3. **Refactoring**: Reduce complexity, improve type safety (4-6 hours)

The biggest impact will come from fixing the high-complexity methods in `AnswersChartData.php`, which will improve both maintainability and testability.

---

**Next Analysis**: After fixes, re-run PHPInsights to track improvement

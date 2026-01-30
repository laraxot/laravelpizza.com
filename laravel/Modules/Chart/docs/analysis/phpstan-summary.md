# PHPStan Level 10 Analysis - Chart Module

**Date**: 2025-11-11
**PHPStan Version**: 2.1.31
**Analysis Level**: 10 (Maximum)

## Summary

- **Total Errors**: 99
- **Files Analyzed**: 12 action files + 3 data files + 1 resource file
- **Status**: ⚠️ Needs Attention

## Error Breakdown by Category

### 1. Mixed Type Issues (70 errors)
**Root Cause**: JpGraph library doesn't provide complete type information

**Affected Files**:
- `Actions/JpGraph/ApplyGraphStyleAction.php` - 5 errors
- `Actions/JpGraph/ApplyPlotStyleAction.php` - 10 errors
- `Actions/JpGraph/GetGraphAction.php` - 16 errors
- `Actions/JpGraph/V1/Bar2Action.php` - 11 errors
- `Actions/JpGraph/V1/Bar3Action.php` - 13 errors
- `Actions/JpGraph/V1/Horizbar1Action.php` - 1 error
- `Actions/JpGraph/V1/LineSubQuestionAction.php` - 11 errors
- `Actions/JpGraph/V1/Pie1Action.php` - 10 errors
- `Actions/JpGraph/V1/PieAvgAction.php` - 9 errors

**Error Types**:
```
- Cannot call method SetFont() on mixed
- Cannot call method SetGrace() on mixed
- Cannot access property $right on mixed
- Cannot access property $center on mixed
- Parameter #1 expects Amenadiel\JpGraph\Graph\Axis, mixed given
```

**Example**:
```php
// Line 23: ApplyGraphStyleAction.php
$graph->subtitle->right->SetFont(...); // $graph->subtitle is mixed
```

**Solutions**:
1. Add PHPStan stubs for JpGraph classes (recommended)
2. Use PHPDoc `@var` annotations to specify types
3. Add runtime type assertions with Webmozart Assert
4. Create wrapper classes with proper type hints

### 2. Binary Operation Errors (3 errors)
**Affected Files**:
- `Actions/JpGraph/V1/Bar2Action.php:100` - Binary operation "." between mixed and ''
- `Actions/JpGraph/V1/Bar3Action.php:88` - Binary operation "." between mixed and ' '

**Example**:
```php
// Line 100: Bar2Action.php
$label = $value . '';  // $value is mixed
```

**Solution**:
```php
$label = (string) $value . '';  // Explicit cast
```

### 3. foreach on non-iterable (1 error)
**Affected File**: `Actions/JpGraph/V1/Bar3Action.php:87`

**Error**:
```
Argument of an invalid type mixed supplied for foreach, only iterables are supported.
```

**Solution**:
```php
Assert::isIterable($labels);
foreach ($labels as $label) {
    // ...
}
```

### 4. Unnecessary Assertions (1 error)
**Affected File**: `Datas/AnswersChartData.php:119`

**Error**:
```
Call to static method Webmozart\Assert\Assert::notNull() with string
and literal-string&non-falsy-string will always evaluate to true.
```

**Solution**: Remove the assertion since the value is already guaranteed to be non-null.

### 5. Method Call on Mixed (1 error)
**Affected File**: `Datas/ChartData.php:99`

**Error**:
```
Cannot call method toRgba() on mixed.
```

**Solution**: Add type hint or assertion before calling method.

### 6. Return Type Mismatch (1 error)
**Affected File**: `Filament/Resources/ChartResource.php:25`

**Error**:
```
Method getFormSchema() should return array<string, Component> but returns
array<int, Select|TextInput|Toggle>.
```

**Solution**: Update the return type annotation or ensure all array keys are strings.

## Priority Fixes

### High Priority (Should fix)
1. **Binary operation errors** - Easy to fix with explicit casts
2. **foreach on non-iterable** - Add type assertion
3. **Return type mismatch in ChartResource** - Fix return type annotation
4. **Unnecessary assertion** - Remove redundant code

### Medium Priority (Can postpone)
5. **Mixed type issues from JpGraph** - Requires creating PHPStan stubs or extensive type annotations

## Recommended Approach

### Phase 1: Quick Wins (1-2 hours)
Fix all high-priority issues that don't involve JpGraph:
- Binary operation casts
- foreach assertions
- Return type fixes
- Remove unnecessary assertions

### Phase 2: JpGraph Type Stubs (4-6 hours)
Create PHPStan stub files for JpGraph library:

```php
// stubs/jpgraph.stub
namespace Amenadiel\JpGraph\Graph;

class Graph {
    public Text $title;
    public Text $subtitle;
    public Axis $xaxis;
    public Axis $yaxis;
    // ... etc
}

class Text {
    public Text $right;
    public Text $center;
    public function SetFont(int $family, int $style, int $size): void;
    public function Set(string $text): void;
    // ... etc
}

class Axis {
    public function SetGrace(int $value): void;
    public function SetAutoMin(bool $value): void;
    public function SetTickLabels(array $labels): void;
    // ... etc
}
```

### Phase 3: Validation (1 hour)
Re-run PHPStan to verify all errors are resolved.

## Full Error Log

Complete error output saved in: `/tmp/phpstan-chart.txt`

## Conclusion

The majority of errors (70 out of 99) stem from the JpGraph library's lack of type information. This is a common issue with legacy PHP libraries. The recommended long-term solution is creating PHPStan stub files, but quick wins can be achieved by fixing the 29 non-JpGraph errors first.

---

**Next Steps**:
1. Fix high-priority errors (non-JpGraph)
2. Create JpGraph stub file
3. Re-run analysis
4. Document improvements in this file

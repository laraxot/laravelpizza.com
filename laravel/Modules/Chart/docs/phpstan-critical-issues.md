# Chart Module - PHPStan Critical Issues Analysis

## Overview

**Module:** Chart
**Analysis Date:** 2025-11-18
**Total Errors:** ~200+
**Status:** 🔴 **CRITICAL**

## Primary Problem Areas

### 1. ExportToSvgAction.php (40+ Errors)

#### Type Safety Issues
```php
// ❌ Multiple array access on mixed types
Cannot access offset 'datasets' on mixed.
Cannot access offset 'labels' on mixed.
Cannot access offset 'data' on mixed.

// ❌ Invalid binary operations
Binary operation "." between '<svg width="' and mixed results in an error.
Binary operation "/" between float|int|numeric-string and mixed results in an error.

// ❌ Function parameter type mismatches
Parameter #1 $string of function htmlspecialchars expects string, mixed given.
```

#### Unsafe Function Usage
```php
// ❌ Missing Safe library imports
Function base64_decode is unsafe to use.
Function preg_replace is unsafe to use.
Function json_encode is unsafe to use.
```

### 2. ExportChartToPngAction.php (20+ Errors)

#### Return Type Issues
```php
// ❌ Incorrect return type documentation
PHPDoc tag @return with type string is incompatible with native type array.

// ❌ Method return type mismatches
Method execute() should return array{path: string, url: string, size: int, filename: string, quality: int}
but returns array{path: bool|string, url: string, size: int, filename: string, quality: int, format: 'png'}.
```

#### Parameter Type Issues
```php
// ❌ Parameter type mismatches
Parameter #1 $string of function base64_decode expects string, string|null given.
Parameter #1 $string of function substr expects string, string|null given.
```

### 3. ExportChartToSvgAction.php (15+ Errors)

#### String Operations on Mixed Types
```php
// ❌ Encapsed string part issues
Part $value (mixed) of encapsed string cannot be cast to string.
Part $width (mixed) of encapsed string cannot be cast to string.
Part $height (mixed) of encapsed string cannot be cast to string.
```

## Root Cause Analysis

### 1. Lack of Input Validation
```php
// Current problematic pattern
public function execute(array $data): array
{
    $chartData = $data['chart_data']; // No validation
    $datasets = $chartData['datasets']; // Direct access
    // ...
}

// Should be:
public function execute(array $data): array
{
    if (!isset($data['chart_data']) || !is_array($data['chart_data'])) {
        throw new InvalidArgumentException('Invalid chart data');
    }

    $chartData = $data['chart_data'];

    if (!isset($chartData['datasets']) || !is_array($chartData['datasets'])) {
        throw new InvalidArgumentException('Invalid datasets');
    }

    $datasets = $chartData['datasets'];
    // ...
}
```

### 2. Missing Type Declarations
```php
// Current issue: mixed return types
public function generateBarChartSvg($datasets, $labels, $width, $height): string
{
    // $datasets, $labels are mixed
}

// Should be:
public function generateBarChartSvg(array $datasets, array $labels, int $width, int $height): string
{
    // Type-safe parameters
}
```

### 3. Incomplete Safe Library Integration
```php
// Current: Unsafe functions
$decoded = base64_decode($base64Data);
$cleaned = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);

// Should be:
use function Safe\base64_decode;
use function Safe\preg_replace;

$decoded = base64_decode($base64Data);
$cleaned = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
```

## Recommended Fixes

### Phase 1: Immediate Critical Fixes

#### 1. Add Safe Function Imports
```php
// Add to the top of each file
use function Safe\base64_decode;
use function Safe\base64_encode;
use function Safe\preg_replace;
use function Safe\json_encode;
use function Safe\json_decode;
use function Safe\htmlspecialchars;
// ... add other unsafe functions used
```

#### 2. Implement Input Validation
```php
private function validateChartData(array $data): array
{
    if (!isset($data['chart_data']) || !is_array($data['chart_data'])) {
        throw new InvalidArgumentException('chart_data is required and must be an array');
    }

    $chartData = $data['chart_data'];

    // Validate required structure
    $required = ['datasets', 'labels'];
    foreach ($required as $field) {
        if (!isset($chartData[$field]) || !is_array($chartData[$field])) {
            throw new InvalidArgumentException("Missing or invalid {$field}");
        }
    }

    return $chartData;
}
```

#### 3. Fix Type Declarations
```php
// Update method signatures
public function generateBarChartSvg(array $datasets, array $labels, int $width, int $height): string
{
    // Implementation with type safety
}

public function execute(array $data): array
{
    // Return specific array shape
    return [
        'path' => $path,
        'url' => $url,
        'size' => $size,
        'filename' => $filename,
        'quality' => $quality,
    ];
}
```

### Phase 2: Code Quality Improvements

#### 1. Create Data Transfer Objects
```php
class ChartExportRequest
{
    public function __construct(
        public readonly array $chartData,
        public readonly string $format,
        public readonly int $width,
        public readonly int $height,
        public readonly ?string $title = null,
        public readonly ?string $subtitle = null
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        // Validation logic
    }
}
```

#### 2. Implement Proper Error Handling
```php
class ChartExportException extends \Exception
{
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
```

### Phase 3: Testing and Validation

#### 1. Add Unit Tests
```php
class ExportToSvgActionTest extends TestCase
{
    public function test_execute_with_valid_data(): void
    {
        $action = new ExportToSvgAction();
        $data = [
            'chart_data' => [
                'datasets' => [[/* valid data */]],
                'labels' => ['Label 1', 'Label 2'],
            ],
        ];

        $result = $action->execute($data);

        $this->assertArrayHasKey('path', $result);
        $this->assertArrayHasKey('url', $result);
        // ... more assertions
    }
}
```

## Implementation Timeline

### Week 1: Critical Fixes
- [ ] Add Safe function imports to all files
- [ ] Implement basic input validation
- [ ] Fix immediate type declaration issues

### Week 2: Structural Improvements
- [ ] Create DTOs for data transfer
- [ ] Implement proper error handling
- [ ] Add comprehensive validation

### Week 3: Testing and Refinement
- [ ] Add unit tests
- [ ] Performance optimization
- [ ] Code review and refinement

## Success Metrics

- **Target**: Reduce errors from 200+ to <20
- **Phase 1 Goal**: <100 errors
- **Phase 2 Goal**: <50 errors
- **Phase 3 Goal**: <20 errors

---

**Next Review**: 2025-11-25
**Priority**: 🔴 CRITICAL
**Assigned To**: Development Team
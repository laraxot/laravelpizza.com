# KISS Patterns - Clean Code

## Dead Code Removal

### Problem: Commented Out Code

```php
// ❌ VIOLATION - Commented code pollutes the codebase
public function calculateIndennita(): float
{
    // Old calculation method - keep for reference
    /*
    $baseAmount = $this->getRecord()->stipendio_base;
    $seniorityBonus = $this->calculateSeniorityBonus($baseAmount);
    $performanceBonus = $this->calculatePerformanceBonus($baseAmount);
    return $baseAmount + $seniorityBonus + $performanceBonus;
    */

    // New calculation method - more accurate
    return $this->calculateWithNewFormula();
}
```

### Solution: Clean Repository

```php
// ✅ COMPLIANT - Clean, maintainable code
public function calculateIndennita(): float
{
    $baseAmount = $this->getRecord()->stipendio_base;
    $complexityBonus = $this->calculateComplexityBonus();
    $responsibilityBonus = $this->calculateResponsibilityBonus();

    return $baseAmount + $complexityBonus + $responsibilityBonus;
}
```

### When to Keep Comments
Only keep comments that provide value:
- TODO comments for planned work
- FIXME comments for known issues
- Explanatory comments for complex business logic

## Debug Code Removal

### Problem: Development Debug Statements

```php
// ❌ VIOLATION - Debug code in production
public function processRating(): void
{
    $rating = $this->getRecord();

    // Debug: check rating values
    dd($rating->toArray()); // Left in production!

    // More debug code
    Log::debug('Processing rating', [
        'id' => $rating->id,
        'values' => $rating->values
    ]); // Debug logging in production

    $this->updateRating($rating);
}
```

### Solution: Production-Ready Code

```php
// ✅ COMPLIANT - Clean production code
public function processRating(): void
{
    $rating = $this->getRecord();

    $this->validateRating($rating);
    $this->updateRating($rating);
    $this->notifyStakeholders($rating);
}
```

## Magic Number Elimination

### Problem: Hardcoded Values

```php
// ❌ VIOLATION - Magic numbers without context
public function calculateMonthlyAmount(): float
{
    $annualAmount = $this->getAnnualSalary();
    $monthlyAmount = $annualAmount / 12; // Why 12?
    $taxDeduction = $monthlyAmount * 0.2; // Why 0.2?
    $netAmount = $monthlyAmount - $taxDeduction;

    return $netAmount;
}
```

### Solution: Named Constants

```php
// ✅ COMPLIANT - Self-documenting code
class SalaryCalculator
{
    private const MONTHS_PER_YEAR = 12;
    private const DEFAULT_TAX_RATE = 0.2;
    private const MAX_TAX_RATE = 0.45;

    public function calculateMonthlyAmount(): float
    {
        $annualAmount = $this->getAnnualSalary();
        $monthlyAmount = $annualAmount / self::MONTHS_PER_YEAR;
        $taxRate = $this->getApplicableTaxRate();
        $taxDeduction = $monthlyAmount * $taxRate;
        $netAmount = $monthlyAmount - $taxDeduction;

        return $netAmount;
    }

    private function getApplicableTaxRate(): float
    {
        $incomeBracket = $this->determineIncomeBracket();

        return match ($incomeBracket) {
            'low' => 0.15,
            'medium' => self::DEFAULT_TAX_RATE,
            'high' => self::MAX_TAX_RATE,
        };
    }
}
```

## Unused Import Cleanup

### Problem: Cluttered Import Statements

```php
// ❌ VIOLATION - Unused imports
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User; // Not used
use App\Services\PaymentService; // Not used

class ReportGenerator
{
    public function generate(Collection $data): array
    {
        // Only uses Collection, Str, and Arr
        return $data->map(function ($item) {
            return [
                'name' => Str::title($item['name']),
                'value' => Arr::get($item, 'value', 0),
            ];
        })->toArray();
    }
}
```

### Solution: Clean Imports

```php
// ✅ COMPLIANT - Only necessary imports
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ReportGenerator
{
    public function generate(Collection $data): array
    {
        return $data->map(function ($item) {
            return [
                'name' => Str::title($item['name']),
                'value' => Arr::get($item, 'value', 0),
            ];
        })->toArray();
    }
}
```

## Variable Naming Improvements

### Problem: Unclear Variable Names

```php
// ❌ VIOLATION - Unclear variable names
public function processData($d, $l, $a)
{
    $r = [];
    foreach ($d as $i) {
        if ($i['status'] == 'active') {
            $r[] = [
                'id' => $i['id'],
                'name' => $i['name'],
                'val' => $this->calc($i, $l, $a)
            ];
        }
    }
    return $r;
}
```

### Solution: Descriptive Naming

```php
// ✅ COMPLIANT - Clear, descriptive names
public function getActiveUsersWithCalculatedValues(
    array $users,
    int $locationId,
    int $areaId
): array {
    $activeUsers = [];

    foreach ($users as $user) {
        if ($user['status'] === 'active') {
            $activeUsers[] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'calculated_value' => $this->calculateUserValue($user, $locationId, $areaId)
            ];
        }
    }

    return $activeUsers;
}
```

## Code Formatting Standards

### Consistent Spacing and Alignment

```php
// ❌ VIOLATION - Inconsistent formatting
public function processItems(array $items):array{
    $results=[];
    foreach($items as $item){
        if($item['active']){
            $results[]=$item;
        }
    }
    return $results;
}
```

```php
// ✅ COMPLIANT - Consistent formatting
public function processItems(array $items): array
{
    $results = [];

    foreach ($items as $item) {
        if ($item['active']) {
            $results[] = $item;
        }
    }

    return $results;
}
```

## Clean Code Checklist

- [ ] No commented-out code blocks
- [ ] No debug statements (dd, var_dump, echo)
- [ ] No magic numbers - use named constants
- [ ] No unused imports
- [ ] Descriptive variable and method names
- [ ] Consistent code formatting
- [ ] No empty catch blocks
- [ ] No TODO comments older than 30 days
- [ ] Single blank line between methods
- [ ] Proper PHPDoc for all public methods

## Benefits

- **Maintainability**: Code is easier to understand and modify
- **Reliability**: Fewer bugs from dead code or debug statements
- **Performance**: Removed unused code and imports
- **Readability**: Clear naming and consistent formatting
- **Team Productivity**: Less time spent deciphering unclear code

---

**Focus**: Code cleanliness and maintainability
**Goal**: Professional, production-ready codebase

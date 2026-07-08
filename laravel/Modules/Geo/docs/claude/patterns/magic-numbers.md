# Magic Numbers Pattern

## Problem: Hardcoded Values Without Context

Magic numbers are hardcoded numeric values that appear in code without explanation of their meaning or origin.

```php
// ❌ VIOLATION - Magic numbers everywhere
public function calculateSalary(): float
{
    $baseSalary = $this->getBaseSalary();
    $monthlyBonus = $baseSalary * 0.1; // Why 0.1?
    $yearlyBonus = $baseSalary * 1.5;  // Why 1.5?
    $taxDeduction = $baseSalary * 0.2; // Why 0.2?

    return ($baseSalary + $monthlyBonus + $yearlyBonus) * 12 * (1 - 0.2); // Why 12? Why 0.2?
}
```

## Solution: Named Constants

Replace magic numbers with descriptive named constants.

```php
// ✅ COMPLIANT - Self-documenting constants
class SalaryCalculator
{
    // Bonus multipliers
    private const MONTHLY_BONUS_RATE = 0.1;
    private const YEARLY_BONUS_MULTIPLIER = 1.5;

    // Tax rates
    private const DEFAULT_TAX_RATE = 0.2;
    private const MONTHS_PER_YEAR = 12;

    // Business rules
    private const MAX_MONTHLY_BONUS_PERCENTAGE = 15.0;

    public function calculateAnnualSalary(): float
    {
        $baseSalary = $this->getBaseSalary();
        $monthlyBonus = $baseSalary * self::MONTHLY_BONUS_RATE;
        $yearlyBonus = $baseSalary * self::YEARLY_BONUS_MULTIPLIER;
        $taxRate = $this->getApplicableTaxRate();

        $grossAnnual = ($baseSalary + $monthlyBonus + $yearlyBonus) * self::MONTHS_PER_YEAR;
        $taxDeduction = $grossAnnual * $taxRate;

        return $grossAnnual - $taxDeduction;
    }

    private function getApplicableTaxRate(): float
    {
        $income = $this->getAnnualIncome();

        return match (true) {
            $income < 15000 => 0.0,
            $income < 30000 => 0.15,
            $income < 50000 => self::DEFAULT_TAX_RATE,
            default => 0.35,
        };
    }
}
```

## Types of Magic Numbers

### 1. Percentage Rates
```php
// ❌ Wrong
$discount = $price * 0.15;

// ✅ Correct
private const DISCOUNT_RATE = 0.15;
$discount = $price * self::DISCOUNT_RATE;
```

### 2. Time Periods
```php
// ❌ Wrong
$expiresAt = now()->addDays(30);

// ✅ Correct
private const TRIAL_PERIOD_DAYS = 30;
$expiresAt = now()->addDays(self::TRIAL_PERIOD_DAYS);
```

### 3. Limits and Thresholds
```php
// ❌ Wrong
if ($count > 100) { /* ... */ }

// ✅ Correct
private const MAX_ITEMS_PER_PAGE = 100;
if ($count > self::MAX_ITEMS_PER_PAGE) { /* ... */ }
```

### 4. Array Sizes and Indices
```php
// ❌ Wrong
$coordinates = [45.123, 9.456]; // Index 0 = lat, 1 = lng?

// ✅ Correct
private const COORDINATE_LATITUDE_INDEX = 0;
private const COORDINATE_LONGITUDE_INDEX = 1;

$latitude = $coordinates[self::COORDINATE_LATITUDE_INDEX];
$longitude = $coordinates[self::COORDINATE_LONGITUDE_INDEX];
```

## Configuration-Based Constants

For values that might change, use configuration:

```php
// config/salary.php
return [
    'monthly_bonus_rate' => env('MONTHLY_BONUS_RATE', 0.1),
    'tax_rates' => [
        'low' => 0.15,
        'medium' => 0.2,
        'high' => 0.35,
    ],
];

// Usage in code
private function getMonthlyBonusRate(): float
{
    return config('salary.monthly_bonus_rate', self::DEFAULT_MONTHLY_BONUS_RATE);
}
```

## Database-Driven Constants

For business rules stored in database:

```php
class BusinessRules
{
    private const CACHE_TTL = 3600; // 1 hour

    public static function getMaxUsersPerCompany(): int
    {
        return Cache::remember(
            'business_rules.max_users_per_company',
            self::CACHE_TTL,
            fn () => BusinessRule::where('key', 'max_users_per_company')->value('value') ?? 100
        );
    }
}
```

## Benefits

### Maintainability
- **Single Source of Truth**: Change values in one place
- **Version Control**: See what values changed and why
- **Documentation**: Constants self-document their purpose

### Reliability
- **Type Safety**: Constants have defined types
- **Validation**: Can add runtime validation for constants
- **Testing**: Constants can be mocked in tests

### Performance
- **Memory Efficiency**: Constants are stored once
- **No Runtime Overhead**: Resolved at compile time

### Team Collaboration
- **Clear Intent**: Other developers understand the meaning
- **Code Reviews**: Easier to spot incorrect values
- **Onboarding**: New developers can understand business rules

## Implementation Checklist

- [ ] Scan codebase for numeric literals
- [ ] Identify which numbers are magic (not obvious)
- [ ] Create descriptive constant names
- [ ] Group related constants in classes
- [ ] Add PHPDoc explaining business meaning
- [ ] Update all usage points
- [ ] Add unit tests for constant validation
- [ ] Consider configuration for changeable values

## Common Anti-Patterns to Avoid

```php
// ❌ Magic calculations
$result = $value * 1.21; // What's 1.21?

// ❌ Magic array access
$data = $array[2]; // What's at index 2?

// ❌ Magic string concatenation
$filename = $id . '_' . time() . '.pdf'; // Why this format?

// ✅ Self-documenting code
$result = $value * self::VAT_RATE;
$middleName = $nameParts[self::MIDDLE_NAME_INDEX];
$filename = $this->generateInvoiceFilename($id, time());
```

---

**Pattern**: Magic Number Elimination
**Purpose**: Make code self-documenting and maintainable
**Result**: Clear, professional, business-rule-aware code

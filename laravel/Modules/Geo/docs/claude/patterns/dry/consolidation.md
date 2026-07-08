# DRY Patterns - Consolidation

## Date Handling Consolidation

### Problem: Duplicate Date Logic

```php
// ❌ DUPLICATE LOGIC - Same pattern for 'dal' and 'al' fields
if (!isset($data['dal'])) {
    $data['dal'] = Carbon::parse($anno.'-01-01');
}
if (is_string($data['dal'])) {
    $dal = Carbon::parse($data['dal']);
    if ($dal->year !== $anno) {
        $dal = Carbon::parse($anno.'-01-01');
    }
    $data['dal'] = $dal;
}
// Same logic repeated for 'al' field...
```

### Solution: Single Normalization Method

```php
/**
 * Normalize a date field with year validation.
 *
 * @param string|null $dateString Raw date string or null
 * @param int $anno Reference year
 * @param string $default Default date part (MM-DD)
 * @return Carbon Normalized date
 */
private function normalizeDate(?string $dateString, int $anno, string $default): Carbon
{
    if (null === $dateString) {
        return Carbon::parse("{$anno}-{$default}");
    }

    $date = Carbon::parse($dateString);

    return $date->year === $anno
        ? $date
        : Carbon::parse("{$anno}-{$default}");
}

// Usage - Clean and consistent
$data['dal'] = $this->normalizeDate($data['dal'] ?? null, $anno, '01-01');
$data['al'] = $this->normalizeDate($data['al'] ?? null, $anno, '12-31');
$data['dalf'] = $this->normalizeDate($data['dalf'] ?? null, $anno, '01-01');
$data['alf'] = $this->normalizeDate($data['alf'] ?? null, $anno, '12-31');
```

## Type Casting Consolidation

### Problem: Repeated Type Casting

```php
// ❌ REPEATED TYPE CASTING - 15+ instances
$rowId = is_int($row->id) ? $row->id : (int) $row->id;
$annoInt = is_int($anno) ? $anno : (int) $anno;
$value = is_int($fieldValue) ? $fieldValue : (int) $fieldValue;
$percentage = is_float($percentage) ? $percentage : (float) $percentage;
```

### Solution: Type-Safe Casting Methods

```php
/**
 * Safely cast value to integer.
 */
private function toInt(mixed $value): int
{
    return is_int($value) ? $value : (int) $value;
}

/**
 * Safely cast value to float.
 */
private function toFloat(mixed $value): float
{
    return is_float($value) ? $value : (float) $value;
}

/**
 * Safely cast value to string.
 */
private function toString(mixed $value): string
{
    return is_string($value) ? $value : (string) $value;
}

// Usage - Type-safe and consistent
$rowId = $this->toInt($row->id);
$annoInt = $this->toInt($anno);
$value = $this->toInt($fieldValue);
$percentage = $this->toFloat($percentage);
$name = $this->toString($inputName);
```

## Collection Processing Consolidation

### Problem: Repeated Collection Operations

```php
// ❌ DUPLICATE COLLECTION LOGIC
$activeUsers = $users->filter(fn($user) => $user['status'] === 'active');
$totalActive = $activeUsers->count();

$inactiveUsers = $users->filter(fn($user) => $user['status'] === 'inactive');
$totalInactive = $inactiveUsers->count();

$premiumUsers = $users->filter(fn($user) => $user['plan'] === 'premium');
$totalPremium = $premiumUsers->count();
```

### Solution: Generic Collection Processors

```php
/**
 * Count items by field value.
 */
private function countByField(Collection $collection, string $field, mixed $value): int
{
    return $collection->where($field, $value)->count();
}

/**
 * Group and count by field.
 */
private function groupAndCount(Collection $collection, string $field): Collection
{
    return $collection->groupBy($field)
        ->map(fn($group) => $group->count());
}

// Usage - DRY and reusable
$totalActive = $this->countByField($users, 'status', 'active');
$totalInactive = $this->countByField($users, 'status', 'inactive');
$totalPremium = $this->countByField($users, 'plan', 'premium');

// Or get all counts at once
$statusCounts = $this->groupAndCount($users, 'status');
// ['active' => 15, 'inactive' => 3, 'suspended' => 2]
```

## Benefits

- **Consistency**: Same logic applied uniformly
- **Reliability**: Centralized validation and error handling
- **Performance**: Avoid redundant operations
- **Maintainability**: Single point of change for business logic

## Implementation Checklist

- [ ] Identify repeated patterns in codebase
- [ ] Extract common logic into private methods
- [ ] Add proper type hints and PHPDoc
- [ ] Test extracted methods independently
- [ ] Update all usage points to use new methods
- [ ] Remove original duplicated code

---

**Focus**: Consolidation patterns for common operations
**Goal**: Single implementation, multiple reuse points

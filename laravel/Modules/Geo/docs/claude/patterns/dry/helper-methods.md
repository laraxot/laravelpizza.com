# DRY Patterns - Helper Methods

## Extract Method Pattern

### Problem: Repeated Business Logic

```php
// ❌ REPEATED CODE - Same pattern used 4+ times
$rowTot = $rows->firstWhere('title', 'tot');
Assert::notNull($rowTot, 'Tot row must exist');
$tot_id = is_int($rowTot->id) ? $rowTot->id : (int) $rowTot->id;
Arr::set($this->form_data, 'ratings.'.$tot_id.'.pivot.value', $tot);

$rowMese = $rows->firstWhere('title', 'importo mensile calcolato');
Assert::notNull($rowMese, 'Importo mensile calcolato row must exist');
$mese_id = is_int($rowMese->id) ? $rowMese->id : (int) $rowMese->id;
Arr::set($this->form_data, 'ratings.'.$mese_id.'.pivot.value', $imp_mese);
// ... repeated 2 more times for other fields
```

### Solution: Single Helper Method

```php
/**
 * Set rating value for a specific title in the form data.
 *
 * @throws RatingNotFoundException
 */
private function setRatingValue(Collection $rows, string $title, int|float $value): void
{
    $row = $rows->firstWhere('title', $title)
        ?? throw new RatingNotFoundException("Rating '{$title}' not found");

    Arr::set($this->form_data, "ratings.{$row->id}.pivot.value", $value);
}

// Usage - Clean and maintainable
$this->setRatingValue($rows, 'tot', $tot);
$this->setRatingValue($rows, 'importo mensile calcolato', $imp_mese);
$this->setRatingValue($rows, 'tredicesima', $tredicesima);
$this->setRatingValue($rows, 'altri emolumenti', $altri);
```

## Benefits

- **Single Source of Truth**: Logic changes in one place
- **Type Safety**: Explicit types and exceptions
- **Testability**: Helper method can be unit tested
- **Readability**: Intent is clear from method name
- **Maintainability**: Easy to modify validation or logic

## When to Extract

Extract when you see:
- Same code pattern repeated 3+ times
- Complex inline logic that obscures intent
- Business rules that might change
- Code that needs independent testing

## Common Helper Patterns

### Data Transformation Helpers

```php
private function transformUserData(array $userData): array
{
    return [
        'full_name' => $this->formatFullName($userData['first_name'], $userData['last_name']),
        'email_verified' => $this->isEmailVerified($userData['email_verified_at']),
        'formatted_birth_date' => $this->formatDate($userData['birth_date']),
    ];
}
```

### Validation Helpers

```php
private function validateBusinessRules(Collection $data): void
{
    if ($data->where('status', 'active')->count() > $this->maxActiveItems) {
        throw new BusinessRuleException('Too many active items');
    }
}
```

### Query Builders

```php
private function buildBaseQuery(): Builder
{
    return Model::query()
        ->where('status', 'active')
        ->where('company_id', $this->companyId)
        ->orderBy('created_at', 'desc');
}
```

---

**Pattern**: Helper Method Extraction
**Purpose**: Eliminate code duplication
**Result**: Single, testable, maintainable methods

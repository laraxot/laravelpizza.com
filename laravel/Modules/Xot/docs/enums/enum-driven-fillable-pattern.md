# Enum-Driven Fillable Pattern - Laraxot Architecture

## Philosophy

In the Laraxot framework, Enums serve as the **Single Source of Truth** for field definitions. This extends beyond just form components to include model fillable fields, migration columns, and validation rules.

## Core Principle

> **"If a field is defined in an Enum, it should automatically be included in all relevant places without duplication"**

## Implementation Pattern

### 1. Base Trait for All Enums

```php
// Modules/Xot/Enums/Traits/HasValues.php
namespace Modules\Xot\Enums\Traits;

trait HasValues
{
    /**
     * Get all enum values as array.
     * Useful for fillable fields, validation rules, etc.
     */
    public static function getValues(): array
    {
        return array_map(fn ($case) => $case->value, static::cases());
    }

    /**
     * Alias for getValues() - more semantic for database context
     */
    public static function getColumnNames(): array
    {
        return static::getValues();
    }

    /**
     * Get validation rules for all enum fields
     */
    public static function getValidationRules(): array
    {
        $rules = [];
        foreach (static::cases() as $case) {
            $rules[$case->value] = ['nullable', 'string']; // Default rules
        }
        return $rules;
    }
}
```

### 2. Enum Structure

```php
use Modules\Xot\Enums\Traits\HasValues;
use Modules\Xot\Filament\Traits\TransTrait;

enum YourItemEnum: string implements HasLabel, HasIcon, HasColor
{
    use HasValues, TransTrait;

    case FIELD_ONE = 'field_one';
    case FIELD_TWO = 'field_two';
    // ... other cases

    // Standard enum methods (getLabel, getIcon, getColor)
    // getFormSchema() method for form components
    // columns() and updateColumns() methods for migrations
}
```

### 3. Model Implementation

```php
class YourModel extends BaseModel
{
    // NO static $fillable array - use dynamic approach

    public function getFillable(): array
    {
        return [
            // Core non-enum fields
            'id',
            'created_at',
            'updated_at',
            'user_id',

            // Enum fields - automatic from enums
            ...AddressItemEnum::getValues(),
            ...ContactTypeEnum::getValues(),
            ...CompanyItemEnum::getValues(),
        ];
    }

    /**
     * Get validation rules from enums
     */
    public function getRules(): array
    {
        return array_merge(
            // Core field rules
            [
                'user_id' => ['required', 'exists:users,id'],
                'name' => ['required', 'string', 'max:255'],
            ],

            // Enum field rules
            AddressItemEnum::getValidationRules(),
            ContactTypeEnum::getValidationRules(),
            CompanyItemEnum::getValidationRules(),
        );
    }
}
```

## Benefits

### 1. **Single Source of Truth**
- Enum defines field names once
- Automatically propagates to fillable, forms, migrations
- No synchronization issues

### 2. **DRY Principle**
- No field name duplication
- Changes in one place affect all usages
- Reduced maintenance overhead

### 3. **Type Safety**
- IDE can track enum values
- Compile-time checking possible
- Refactoring-friendly

### 4. **Self-Documenting**
- Enums serve as living documentation
- Clear field groupings by enum
- Easy to understand model structure

### 5. **Consistency**
- Same pattern across all models
- <nome progetto>able code structure
- Easier onboarding for developers

## Migration Strategy

### From Static Fillable to Enum-Driven

1. **Identify all enums** used by the model
2. **Add HasValues trait** to each enum
3. **Replace static fillable** with dynamic getFillable()
4. **Test mass assignment** thoroughly
5. **Update related code** if needed

### Example Migration

```php
// BEFORE
protected $fillable = [
    'name',
    'email',
    'phone',  // From ContactTypeEnum
    'address', // From AddressItemEnum
    // ... more fields
];

// AFTER
public function getFillable(): array
{
    return [
        'name',
        'user_id',
        ...ContactTypeEnum::getValues(),
        ...AddressItemEnum::getValues(),
    ];
}
```

## Best Practices

### DO ✅
- Use HasValues trait in all enums
- Make getFillable() dynamic, not static
- Group fields logically in getFillable()
- Include validation rules in enums
- Test thoroughly after changes

### DON'T ❌
- Mix static and dynamic fillable
- Duplicate field names in multiple places
- Forget to add new enum fields to fillable
- Hardcode enum values as strings
- Ignore type safety

## Advanced Patterns

### 1. Conditional Field Inclusion

```php
public function getFillable(): array
{
    $fields = [
        // Core fields
        ...$this->getCoreFields(),
    ];

    // Add enum fields based on conditions
    if ($this->shouldIncludeAddress()) {
        $fields = [...$fields, ...AddressItemEnum::getValues()];
    }

    if ($this->shouldIncludeContacts()) {
        $fields = [...$fields, ...ContactTypeEnum::getValues()];
    }

    return $fields;
}
```

### 2. Field Grouping for Documentation

```php
public function getFillable(): array
{
    return [
        // === IDENTITY ===
        'name',
        'user_id',

        // === ADDRESS ===
        ...AddressItemEnum::getValues(),

        // === CONTACT ===
        ...ContactTypeEnum::getValues(),

        // === BUSINESS ===
        ...CompanyItemEnum::getValues(),
    ];
}
```

### 3. Configurable Field Groups

```php
public function getFillable(): array
{
    $groups = config('yourmodule.field_groups', [
        'address' => true,
        'contacts' => true,
        'company' => false,
    ]);

    $fields = $this->getCoreFields();

    if ($groups['address']) {
        $fields = [...$fields, ...AddressItemEnum::getValues()];
    }

    // ... other groups

    return $fields;
}
```

## Conclusion

The enum-driven fillable pattern is a cornerstone of Laraxot architecture. It embodies the principles of DRY, KISS, and Single Source of Truth while providing a maintainable, scalable, and self-documenting approach to model field management.

By adopting this pattern, you ensure that your models are always in sync with your enums, forms, and migrations, reducing bugs and improving developer experience.

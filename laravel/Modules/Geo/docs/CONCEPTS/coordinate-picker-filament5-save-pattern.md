# Coordinate Picker Multi-Column Save Pattern (FILAMENT 5)

## TL;DR

**Two-level solution**: `dehydrateStateUsing()` in the trait + `Attribute::make(get:, set:)` in the model.

## Problem

`dehydrated(false)` blocks the composite coordinate state from reaching the model.
The Eloquent mutator is never called because no field data exits the form.

## Solution — Level 1 (Trait)

```php
// HasCoordinatePicker.php
$this->dehydrateStateUsing(static function (self $component, mixed $state): ?array {
    if (! \is_array($state)) {
        return null;
    }

    return [
        'latitude'  => isset($state['latitude']) && \is_numeric($state['latitude'])
            ? (string) $state['latitude']
            : null,
        'longitude' => isset($state['longitude']) && \is_numeric($state['longitude'])
            ? (string) $state['longitude']
            : null,
    ];
});
```

## Solution — Level 2 (Model)

```php
// Ticket.php (or any model with separate lat/lng columns)
protected function location(): Attribute
{
    return Attribute::make(
        get: fn (mixed $value, array $attributes) => [
            'latitude'  => $attributes['latitude']  ?? null,
            'longitude' => $attributes['longitude'] ?? null,
        ],
        set: fn (mixed $value) => [
            'latitude'  => isset($value['latitude'])  && \is_numeric($value['latitude'])
                ? (string) $value['latitude']
                : null,
            'longitude' => isset($value['longitude']) && \is_numeric($value['longitude'])
                ? (string) $value['longitude']
                : null,
        ],
    );
}
```

## Must NOT Do

- ❌ `dehydrated(false)` — kills the entire composite payload
- ❌ `'location' => 'array'` cast — contradicts the mutator, column `location` doesn't exist
- ❌ Duplicating logic in `mutateFormDataBeforeCreate` AND `mutateFormDataBeforeSave`

## References

- Story: 8-65
- Wiki: `laravel/Modules/Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md`
- Related rule: `bashscripts/ai/.claude/rules/coordinatepicker-multi-column-save.md`

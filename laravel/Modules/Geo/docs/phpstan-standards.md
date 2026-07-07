---
title: PHPStan Standards - Geo Module
type: technical
tags: [phpstan, geo, models, getOptions]
created: 2026-06-10
updated: 2026-06-10
qmd: docs/wiki/phpstan-geo-module.md
---

# PHPStan Level 10 Standards - Geo Module

## Static getOptions() Methods

All geographic models implement `getOptions()` for Filament forms with proper typing.

### Region::getOptions()

```php
/**
 * @param Get $get Filament form getter
 * @return array<string, string> ID => Name pairs
 */
public static function getOptions(Get $get): array
{
    $keys = [];
    $values = [];

    foreach (self::orderBy('name')->get() as $item) {
        $keys[] = (string) $item->id;
        $values[] = (string) ($item->name ?? '');
    }

    return array_combine($keys, $values) ?: [];
}
```

### Models with getOptions()

| Model | Location | Usage |
|-------|----------|-------|
| `Region` | `app/Models/Region.php:81` | AddressResource region selector |
| `Province` | `app/Models/Province.php:88` | AddressResource province selector |
| `Locality` | `app/Models/Locality.php:75` | AddressResource locality selector |

## AddressResource Usage

```php
// AddressResource.php
'administrative_area_level_1' => Select::make('administrative_area_level_1')
    ->options(Region::getOptions(...))
    ->searchable()
    ->required()
    ->live(),
```

## Type Safety Pattern

```php
// ✅ CORRECT - Type-safe closure
->options(fn (Get $get) => Province::getOptions($get))

// ✅ CORRECT - First-class callable
->options(Province::getOptions(...))
```

## Sushi Integration

Geo models use Sushi for in-memory data from JSON:

```php
class Region extends BaseModel
{
    use Sushi;
    
    public function getRows(): array
    {
        return Comune::select('regione->codice as id', 'regione->nome as name')
            ->distinct()
            ->get()
            ->map(fn ($row) => $row->attributesToArray())
            ->values()
            ->all();
    }
}
```

## Compliance

Last PHPStan Check: 2026-06-10
Status: ✅ All getOptions() methods typed and verified

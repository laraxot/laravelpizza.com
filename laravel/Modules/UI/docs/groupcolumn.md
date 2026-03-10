# GroupColumn Documentation

## Overview

The `GroupColumn` is a custom Filament table column component that allows you to group multiple fields together in a single table cell. It's particularly useful for displaying related information compactly.

## Key Features

### 1. **Dot Notation Support** ✅
The GroupColumn now supports Laravel's dot notation for accessing relationship data:
```php
TextColumn::make('valutatore.nome_diri')  // Works correctly!
TextColumn::make('user.profile.name')     // Works correctly!
```

### 2. **Automatic Label Translation**
Labels are automatically resolved using:
- Explicit label set on the column
- Translation files (`ui::table.columns.{field_name}.label`)
- Auto-generated from field name (snake_case → Title Case)

### 3. **Empty Value Handling**
Empty values are automatically skipped to save visual space, except for:
- `0` (zero)
- `'0'` (string zero)

## Implementation Details

### The Fix for Dot Notation
**Problem:** Originally, GroupColumn could only access direct model attributes using `$record->{$name}`.

**Solution:** The view now uses Laravel's `data_get()` function as fallback:
```php
$value = $field->getState();
if ($value === null) {
    $value = data_get($record, $name); // Supports dot notation
}
```

### View Structure
The GroupColumn renders as a flex container with each field on a new line:
```blade
<div class="fi-ta-icon flex flex-wrap gap-1.5 flex-col px-3 py-4">
    @foreach ($fields as $field)
        {{ $label }}: {{ $value }}<br/>
    @endforeach
</div>
```

## Usage Examples

### Basic Usage
```php
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Filament\Tables\Columns\TextColumn;

GroupColumn::make('worker_info')
    ->schema([
        TextColumn::make('name'),
        TextColumn::make('email'),
        TextColumn::make('phone'),
    ]);
```

### With Relationships (Dot Notation)
```php
GroupColumn::make('evaluator_info')
    ->schema([
        TextColumn::make('valutatore.nome_diri')
            ->label('Valutatore'),
        TextColumn::make('valutatore.email')
            ->label('Email'),
    ]);
```

### Custom Column Classes
You can extend GroupColumn to create reusable column components:

```php
class ValutatoreColumn extends GroupColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->schema([
            TextColumn::make('valutatore.nome_diri')
                ->label('Nome Valutatore')
                ->searchable(),
            TextColumn::make('valutatore.nome_diri_plus')
                ->label('Nome Completo'),
        ])->searchable(['valutatore.nome_diri']);
    }
}
```

## Search Support

GroupColumn supports searchable fields across all its schema columns:

```php
GroupColumn::make('info')
    ->schema([
        TextColumn::make('name'),
        TextColumn::make('email'),
        TextColumn::make('department.name'), // Relationship field
    ])
    ->searchable(['name', 'email', 'department.name']);
```

## Performance Considerations

### Relationship Loading
For optimal performance, ensure relationships are loaded before displaying:
```php
// In your resource or query
Model::with('valutatore', 'department')->get();
```

### Memory Usage
The GroupColumn processes multiple fields but remains memory-efficient thanks to:
- Lazy loading of field states
- Skipping empty values
- Efficient Laravel data_get() usage

## Troubleshooting

### Dot Notation Not Working
**Issue:** `valutatore.nome_diri` shows as blank
**Solution:** Ensure the relationship is loaded in your query:
```php
$records = Model::with('valutatore')->get();
```

### Fields Not Showing
**Issue:** Some fields don't appear in the column
**Solution:** Check that fields have non-empty values. Empty strings/null values are skipped automatically.

### Labels Not Translating
**Issue:** Field labels show as raw field names
**Solution:** Add translations to `ui/lang/it/table/columns.php`:
```php
return [
    'valutatore_nome_diri' => [
        'label' => 'Nome Valutatore',
    ],
];
```

## Available Methods

| Method | Description |
|--------|-------------|
| `schema(array $columns)` | Set the column schema |
| `getFields()` | Get configured fields |
| `searchable(array $fields)` | Set searchable fields |
| `label(string $label)` | Set column label |

## Best Practices

1. **Always preload relationships** used in dot notation
2. **Use specific field names** for better searchability
3. **Provide translation keys** for better UX
4. **Test with null relationships** to ensure graceful degradation
5. **Keep schemas small** to avoid cluttered displays
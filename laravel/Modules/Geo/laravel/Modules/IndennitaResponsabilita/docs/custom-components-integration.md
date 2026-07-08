# Custom Components Integration - IndennitaResponsabilita Module

## SelectValutatore Integration

### Overview
The `SelectValutatore` component from the PTV module is used to filter team members (valutatori) based on specific criteria like year.

### Implementation in IndennitaResponsabilitaResource

```php
use Modules\Ptv\Filament\Forms\Components\SelectValutatore;

public static function getFormSchema(): array
{
    return [
        'matr' => TextInput::make('matr')->required(),
        'cognome' => TextInput::make('cognome')->required(),
        'nome' => TextInput::make('nome')->required(),
        'email' => TextInput::make('email')->email()->required(),
        'valutatore_id' => SelectValutatore::make('valutatore_id')
            ->where([
                'anno' => 2025,
            ]),
    ];
}
```

### How It Works

1. **Where Clause**: The `->where(['anno' => 2025])` passes filtering criteria to the component
2. **Query Application**: The SelectValutatore applies these conditions to the teams query
3. **Options Generation**: Only teams matching the criteria are displayed as options

### Business Logic

The component ensures that:
- Only evaluators (valutatori) for the specified year are available
- The filtering is done at the database level for performance
- Results are properly formatted as `id => name` pairs

### Common Use Cases

#### Filtering by Year
```php
'valutatore_id' => SelectValutatore::make('valutatore_id')
    ->where(['anno' => date('Y')])  // Current year
```

#### Multiple Criteria
```php
'valutatore_id' => SelectValutatore::make('valutatore_id')
    ->where([
        'anno' => 2025,
        'department' => 'HR',
        'active' => true,
    ])
```

### Troubleshooting

#### No Options Displayed
1. Verify the authenticated user has teams
2. Check if the where conditions match existing team data
3. Ensure the SelectValutatore component is properly imported

#### Where Conditions Not Applied
The SelectValutatore component automatically applies where conditions in its `options()` callback. No additional configuration is needed.

### Integration Best Practices

1. **Always define where conditions**: Specify the filtering criteria when using the component
2. **Use meaningful field names**: The field should clearly indicate it's for evaluator selection
3. **Consider year-based filtering**: In most cases, filtering by year is essential for proper data isolation

### Example with Dynamic Year

```php
'valutatore_id' => SelectValutatore::make('valutatore_id')
    ->where(function () {
        return ['anno' => date('Y')];
    })
```

This ensures the component always filters by the current year dynamically.
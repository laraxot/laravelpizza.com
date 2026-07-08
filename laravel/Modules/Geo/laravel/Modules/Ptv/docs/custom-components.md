# Custom Components - PTV Module

## SelectValutatore Component

### Overview
The `SelectValutatore` component is a custom Filament select component designed to filter team members based on specific criteria.

### Usage

```php
use Modules\Ptv\Filament\Forms\Components\SelectValutatore;

// Basic usage
SelectValutatore::make('valutatore_id')

// With where conditions
SelectValutatore::make('valutatore_id')
    ->where([
        'anno' => 2025,
        'stato' => 'attivo',
    ])
```

### Implementation Details

#### Where Clause Processing
The component accepts `where` conditions through the `where()` method and applies them to the team query:

```php
public function where(array $where): static
{
    $this->where = $where;
    return $this;
}

protected function setUp(): void
{
    parent::setUp();
    
    $this->options(function () {
        $user = Auth::user();
        if ($user === null) {
            return [];
        }
        
        // Apply where conditions to the query
        $query = $user->teams();
        foreach ($this->where as $key => $value) {
            $query->where($key, $value);
        }
        
        $teams = $query->get();
        $data = [];
        foreach ($teams as $team) {
            $data[$team->id] = $team->name;
        }
        return $data;
    });
}
```

### Best Practices

1. **Always apply where conditions**: The `where` array must be applied to the Eloquent query in the `options()` callback
2. **Handle null user**: Always check if the authenticated user exists before accessing teams
3. **Return proper format**: Options should be returned as an associative array with `id => name` format

### Common Use Cases

#### Filtering by Year
```php
SelectValutatore::make('valutatore_id')
    ->where(['anno' => 2025])
```

#### Multiple Conditions
```php
SelectValutatore::make('valutatore_id')
    ->where([
        'anno' => 2025,
        'department' => 'IT',
        'active' => true,
    ])
```

### Troubleshooting

#### Empty Options
If no options are displayed:
1. Check if the user is authenticated
2. Verify the user has associated teams
3. Ensure where conditions match existing data

#### Where Conditions Not Working
Ensure the where conditions are properly applied in the `options()` callback, not just stored in the property.

### Integration with Resources

The component integrates seamlessly with Filament resources:

```php
public static function getFormSchema(): array
{
    return [
        // Other fields...
        'valutatore_id' => SelectValutatore::make('valutatore_id')
            ->where(['anno' => 2025]),
    ];
}
```
# Filament 4 Components Development Guide

## Overview

Comprehensive guide for developing custom components in Filament 4, focusing on forms, tables, and custom components.

## Component Types

### 1. Form Components

#### Basic Structure
```php
<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Schemas\Schema;

class CustomField extends Field
{
    protected string $view = 'filament.forms.components.custom-field';

    protected function setUp(): void
    {
        parent::setUp();

        // Component initialization logic
    }
}
```

#### Complex Form Component Example
```php
<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class LocationSelector extends Group
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->schema($this->getChildComponentsSchema());
    }

    protected function getChildComponentsSchema(): array
    {
        return [
            Select::make('region')
                ->options($this->getRegionOptions())
                ->live()
                ->afterStateUpdated(fn($set) => $set('province', null)),

            Select::make('province')
                ->options(fn($get) => $this->getProvinceOptions($get('region')))
                ->disabled(fn($get) => !$get('region')),
        ];
    }

    protected function getRegionOptions(): array
    {
        // Implementation
        return [];
    }

    protected function getProvinceOptions(?string $region): array
    {
        // Implementation
        return [];
    }
}
```

### 2. Table Components

#### Custom Table Column
```php
<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;

class CustomColumn extends Column
{
    protected string $view = 'filament.tables.columns.custom-column';

    protected array $schema = [];

    protected function setUp(): void
    {
        parent::setUp();

        // Column initialization
    }

    public function schema(array $schema): static
    {
        $this->schema = $schema;
        return $this;
    }

    public function table(?Table $table): static
    {
        parent::table($table);

        // Handle child components table assignment
        if ($table !== null) {
            foreach ($this->schema as $child) {
                if ($child instanceof Column && $child->getTable() !== $table) {
                    $child->table($table);
                }
            }
        }

        return $this;
    }

    public function getChildColumns(): array
    {
        return $this->schema;
    }
}
```

#### Advanced Table Column with State
```php
<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Support\Enums\IconPosition;

class IconStateColumn extends Column
{
    protected string $view = 'filament.tables.columns.icon-state-column';

    protected array $stateIcons = [];
    protected array $stateColors = [];
    protected array $stateLabels = [];
    protected IconPosition $iconPosition = IconPosition::Before;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function stateIcon(string $state, string $icon): static
    {
        $this->stateIcons[$state] = $icon;
        return $this;
    }

    public function stateColor(string $state, string $color): static
    {
        $this->stateColors[$state] = $color;
        return $this;
    }

    public function stateLabel(string $state, string $label): static
    {
        $this->stateLabels[$state] = $label;
        return $this;
    }

    public function iconPosition(IconPosition $position): static
    {
        $this->iconPosition = $position;
        return $this;
    }

    public function getStateIcon($state): ?string
    {
        return $this->stateIcons[$state] ?? null;
    }

    public function getStateColor($state): ?string
    {
        return $this->stateColors[$state] ?? null;
    }

    public function getStateLabel($state): ?string
    {
        return $this->stateLabels[$state] ?? $state;
    }

    public function getIconPosition(): IconPosition
    {
        return $this->iconPosition;
    }
}
```

### 3. Widget Components

#### Basic Widget
```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CustomWidget extends Widget
{
    protected static string $view = 'filament.widgets.custom-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'data' => $this->getData(),
        ];
    }

    protected function getData(): array
    {
        // Widget data logic
        return [];
    }
}
```

## Livewire Integration

### Form Integration
```php
<?php

namespace App\Livewire;

use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class CustomForm extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Form components
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        // Handle form submission
    }

    public function render()
    {
        return view('livewire.custom-form');
    }
}
```

### Table Integration
```php
<?php

namespace App\Livewire;

use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Table;
use Livewire\Component;

class CustomTable extends Component implements HasTable, HasSchemas
{
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(Model::query())
            ->columns([
                // Table columns
            ])
            ->filters([
                // Table filters
            ])
            ->actions([
                // Row actions
            ]);
    }

    public function render()
    {
        return view('livewire.custom-table');
    }
}
```

## Best Practices

### 1. Component Initialization
- Always call `parent::setUp()` in custom `setUp()` methods
- Use `setUp()` for component configuration, not `mount()`
- Initialize properties before calling parent methods

### 2. State Management
- Use proper state paths for form components
- Handle reactive updates with `live()` and callbacks
- Validate state changes appropriately

### 3. Performance
- Lazy load options for select components
- Use appropriate caching strategies
- Optimize database queries

### 4. Error Handling
- Provide fallback values for missing data
- Handle exceptions gracefully
- Log errors for debugging

### 5. Type Safety
- Use strict type declarations
- Implement proper return types
- Add PHPDoc annotations for complex types

## Testing

### Component Testing
```php
use Livewire\Livewire;

it('renders custom component correctly', function () {
    Livewire::test(CustomForm::class)
        ->assertStatus(200)
        ->assertSee('Expected content');
});

it('handles form submission', function () {
    Livewire::test(CustomForm::class)
        ->fillForm(['field' => 'value'])
        ->call('submit')
        ->assertHasNoErrors();
});
```

### Table Testing
```php
it('displays table data', function () {
    $records = Model::factory()->count(3)->create();

    Livewire::test(CustomTable::class)
        ->assertCanSeeTableRecords($records);
});
```

## Common Patterns

### 1. Conditional Rendering
```php
protected function setUp(): void
{
    parent::setUp();

    $this->visible(fn() => auth()->user()->can('view-component'));
}
```

### 2. Dynamic Options
```php
public function getStateOptions(): array
{
    return [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
    ];
}
```

### 3. Relationship Handling
```php
Select::make('user_id')
    ->relationship('user', 'name')
    ->searchable()
    ->preload();
```

## Troubleshooting

### Common Issues
1. **Missing mount() method**: Use `setUp()` instead
2. **Table not assigned**: Implement proper `table()` method
3. **State not updating**: Check `live()` and callback methods
4. **Missing dependencies**: Verify model imports and existence

### PHPStan Compliance
- Use `@phpstan-ignore` comments when necessary
- Handle nullable types explicitly
- Provide proper type hints for arrays and objects

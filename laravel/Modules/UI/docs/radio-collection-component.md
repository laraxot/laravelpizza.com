# RadioCollection Component

## Overview

The RadioCollection component provides a customizable radio button group for Filament forms, allowing for custom item rendering and flexible data binding.

## Architecture

### Class Structure

- **Namespace**: `Modules\UI\Filament\Forms\Components`
- **Extends**: `Filament\Forms\Components\Field`
- **Key Methods**:
  - `options(Collection $options)`: Set the collection of options
  - `itemView(string $view)`: Set custom item view
  - `valueKey(string $key)`: Set the key used for option values

### Template Structure

- **Location**: `resources/views/filament/forms/components/radio-collection.blade.php`
- **Features**:
  - Custom item rendering
  - Hover and active states
  - Accessibility support
  - Dark mode compatibility

## Usage

### Basic Usage

```php
RadioCollection::make('status')
    ->options(collect([
        ['id' => 'active', 'name' => 'Active'],
        ['id' => 'inactive', 'name' => 'Inactive']
    ]))
    ->itemView('path.to.custom-view')
    ->valueKey('id')
```

### Custom Item View

Create a Blade view that will be rendered for each item:

```blade
<!-- resources/views/path/to/custom-view.blade.php -->
<div>
    <h3 class="font-medium">{{ $item['name'] }}</h3>
    @if(isset($item['description']))
        <p class="text-sm text-gray-500">{{ $item['description'] }}</p>
    @endif
</div>
```

## Known Issues

### Selection Problems

If radio buttons are not selecting properly, check:

1. Ensure `wire:key` is unique for each option
2. Verify that `$getStatePath()` is resolving correctly
3. Check for JavaScript errors in the console
4. Ensure the component is properly initialized in a Livewire context

## Best Practices

1. Always provide a unique `valueKey` if not using 'id'
2. Keep item views simple and focused
3. Test in both light and dark modes
4. Verify accessibility of custom item views

## Troubleshooting

### Radio Buttons Not Selecting

1. Check browser console for JavaScript errors
2. Verify Livewire component is properly initialized
3. Ensure the state path is correct and accessible
4. Test with default item view to isolate the issue

### State Not Updating

1. Verify the `wire:model` binding is correct
2. Check if any JavaScript is preventing form submission
3. Ensure the parent form is properly set up for Livewire

## Related Components

- `CheckboxList`
- `Select`
- `Radio`

## Changelog

### 2025-06-27

- Initial documentation
- Added troubleshooting section for selection issues
# RadioCollection Component

## Overview

The RadioCollection component provides a customizable radio button group for Filament forms, allowing for custom item rendering and flexible data binding.

## Architecture

### Class Structure

- **Namespace**: `Modules\UI\Filament\Forms\Components`
- **Extends**: `Filament\Forms\Components\Field`
- **Key Methods**:
  - `options(Collection $options)`: Set the collection of options
  - `itemView(string $view)`: Set custom item view
  - `valueKey(string $key)`: Set the key used for option values

### Template Structure

- **Location**: `resources/views/filament/forms/components/radio-collection.blade.php`
- **Features**:
  - Custom item rendering
  - Hover and active states
  - Accessibility support
  - Dark mode compatibility

## Usage

### Basic Usage

```php
RadioCollection::make('status')
    ->options(collect([
        ['id' => 'active', 'name' => 'Active'],
        ['id' => 'inactive', 'name' => 'Inactive']
    ]))
    ->itemView('path.to.custom-view')
    ->valueKey('id')
```

### Custom Item View

Create a Blade view that will be rendered for each item:

```blade
<!-- resources/views/path/to/custom-view.blade.php -->
<div>
    <h3 class="font-medium">{{ $item['name'] }}</h3>
    @if(isset($item['description']))
        <p class="text-sm text-gray-500">{{ $item['description'] }}</p>
    @endif
</div>
```

## Known Issues

### Selection Problems

If radio buttons are not selecting properly, check:

1. Ensure `wire:key` is unique for each option
2. Verify that `$getStatePath()` is resolving correctly
3. Check for JavaScript errors in the console
4. Ensure the component is properly initialized in a Livewire context

## Best Practices

1. Always provide a unique `valueKey` if not using 'id'
2. Keep item views simple and focused
3. Test in both light and dark modes
4. Verify accessibility of custom item views

## Troubleshooting

### Radio Buttons Not Selecting

1. Check browser console for JavaScript errors
2. Verify Livewire component is properly initialized
3. Ensure the state path is correct and accessible
4. Test with default item view to isolate the issue

### State Not Updating

1. Verify the `wire:model` binding is correct
2. Check if any JavaScript is preventing form submission
3. Ensure the parent form is properly set up for Livewire

## Related Components

- `CheckboxList`
- `Select`
- `Radio`

## Changelog

### 2025-06-27

- Initial documentation
- Added troubleshooting section for selection issues

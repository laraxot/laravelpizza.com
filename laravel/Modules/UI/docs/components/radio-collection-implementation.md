# RadioCollection Component - Implementation Guide

## Overview

The RadioCollection component is a custom Filament form component that renders a collection of radio options with customizable item views. It's designed for scenarios where standard radio buttons need enhanced visual presentation or complex option details.

## Installation & Dependencies

The component is part of the UI module and relies on:
- Filament Forms ecosystem
- Livewire for reactivity
- Alpine.js for client-side interactions

## Basic Usage

```php
use Modules\UI\Filament\Forms\Components\RadioCollection;

// In your form schema
RadioCollection::make('selected_option')
    ->options($yourCollection)
    ->itemView('path.to.your.item-view')
    ->valueKey('id')
    ->required()
```

## API Reference

### Core Methods

| Method | Parameters | Description |
|--------|------------|-------------|
| `make` | `string $name` | Create a new instance with the specified name |
| `options` | `Collection $options` | Set the collection of options to display |
| `itemView` | `string $view` | Set the Blade view to render each option |
| `valueKey` | `string $key` | Set the option attribute to use as value (default: 'id') |

### Inherited Methods

As a Filament Field component, RadioCollection inherits all standard field methods:

- `required()`
- `disabled()`
- `hidden()`
- `default()`
- etc.

## Creating Custom Item Views

The item view receives an `$item` variable representing the current option from your collection:

```blade
{{-- resources/views/path/to/your/item-view.blade.php --}}
<div class="flex items-center">
    @if(isset($item['image']))
        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded-md mr-3">
    @endif

    <div>
        <div class="font-medium text-gray-900 dark:text-white">
            {{ $item['name'] }}
        </div>

        @if(isset($item['description']))
            <div class="text-sm text-gray-500">
                {{ $item['description'] }}
            </div>
        @endif
    </div>
</div>
```

## Common Patterns

### Option Selection with Models

```php
// Using Eloquent models as options
RadioCollection::make('studio_id')
    ->options(Studio::all())
    ->itemView('pub_theme::filament.forms.components.studio-item')
    ->valueKey('id')
```

### Custom Value Keys

```php
// Using a custom key instead of 'id'
RadioCollection::make('currency')
    ->options($currencies)
    ->itemView('components.currency-item')
    ->valueKey('code') // Use currency code as value
```

### Reactivity with Dependent Fields

```php
RadioCollection::make('payment_method')
    ->options($paymentMethods)
    ->itemView('components.payment-method-item')
    ->live()
    ->afterStateUpdated(function (Set $set, $state) {
        if ($state === 'credit_card') {
            $set('show_card_fields', true);
        } else {
            $set('show_card_fields', false);
        }
    })
```

## Troubleshooting

### Selection Not Working

If options cannot be selected, check for these common issues:

1. **Event Propagation**: Ensure no elements in your item template are blocking click events
   ```blade
   {{-- ❌ This can block events --}}
   <div onclick="doSomething(event)" class="absolute inset-0 z-10">...</div>

   {{-- ✅ Better approach --}}
   <div class="relative">...</div>
   ```

2. **Z-Index Issues**: Avoid elements with high z-index that might stack above the clickable area
   ```blade
   {{-- ❌ Problem --}}
   <div class="z-50 absolute inset-0">...</div>

   {{-- ✅ Better --}}
   <div class="relative">...</div>
   ```

3. **Event Stoppage**: Avoid stopping event propagation
   ```blade
   {{-- ❌ Problem --}}
   <button @click.stop>...</button>

   {{-- ✅ Better --}}
   <button>...</button>
   ```

4. **Pointer Events**: Don't disable pointer events on elements
   ```blade
   {{-- ❌ Problem --}}
   <div class="pointer-events-none">...</div>

   {{-- ✅ Better --}}
   <div>...</div>
   ```

### State Not Updating

If the component appears to select visually but the state doesn't update:

1. Verify the Livewire component is correctly set up
2. Check that your form uses the standard Filament form conventions
3. Ensure no JavaScript errors in the console
4. Verify that `$getStatePath()` resolves to a valid Livewire property path

## Best Practices

1. **Keep Item Views Simple**: Complex nested DOM structures can interfere with selection behavior
2. **Test with Real Data**: Sample data may not reveal edge cases in production
3. **Test Dark Mode**: Ensure your custom item views work in both light and dark themes
4. **Accessibility**: Include proper contrast and keyboard navigation support
5. **Mobile Testing**: Verify selection works correctly on touch devices

## Examples

### Studio Selection Example

```php
// In form schema
RadioCollection::make('studio_id')
    ->options(Studio::all())
    ->itemView('pub_theme::filament.forms.components.studio-item')
    ->required()
    ->columnSpanFull()
```

```blade
{{-- studio-item.blade.php --}}
<div class="flex items-start">
    @if($item->logo_url)
        <img src="{{ $item->logo_url }}" alt="{{ $item->name }}" class="w-16 h-16 rounded-lg object-cover mr-4">
    @else
        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
            <x-heroicon-o-building-office class="w-8 h-8 text-gray-400"/>
        </div>
    @endif

    <div>
        <h3 class="font-medium text-gray-900 dark:text-white">{{ $item->name }}</h3>

        @if($item->address)
            <p class="text-sm text-gray-500">
                {{ $item->address }}
            </p>
        @endif

        @if($item->specializations && count($item->specializations) > 0)
            <div class="mt-2 flex flex-wrap gap-1">
                @foreach($item->specializations->take(3) as $specialization)
                    <span class="px-2 py-1 text-xs rounded-full bg-primary-50 text-primary-700 dark:bg-primary-900/50 dark:text-primary-300">
                        {{ $specialization->name }}
                    </span>
                @endforeach

                @if(count($item->specializations) > 3)
                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        +{{ count($item->specializations) - 3 }}
                    </span>
                @endif
            </div>
        @endif
    </div>
</div>
```

## Related Documentation

- [UI Module Overview](../ui.md)
- [Filament Form Components](../filament/filament_components_usage.md)
- [Radio Collection Philosophy](./radio-collection-philosophy.md)

## Change Log

### 2025-06-27
- Initial documentation
- Added troubleshooting section for event propagation issues
- Added best practices for item views

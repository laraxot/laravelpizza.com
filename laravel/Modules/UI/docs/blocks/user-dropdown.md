# User Dropdown Component

This document describes the User Dropdown component used in the header section and explains proper data handling patterns.

## Component Location

```
Themes/<ThemeName>/resources/views/components/blocks/navigation/user-dropdown.blade.php
```

## Proper Data Handling in Block Components

### The Issue

The current implementation of the user-dropdown component fails to properly handle JSON data passed from the section configuration. While the component correctly defines `@props` for layout attributes like `alignment`, `width`, and `contentClasses`, it does not define props for the custom menu items passed in the JSON config.

In the section JSON configuration:

```json
{
    "menu_items": [
        {
            "label": "Profilo",
            "url": "/profilo",
            "icon": "heroicon-o-user"
        },
        ...
    ]
}
```

This data is passed to the component via `@include($block->view, $block->data)`, but the component does not define a corresponding prop to receive it.

### Correct Implementation

Block components should define **all** expected data properties as props using the `@props` directive:

```blade
@props([
    'alignment' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-800',
    // Missing prop - should be added:
    'menu_items' => [],
    'guest_view' => null
])
```

### Root Cause Analysis

The error occurred because:

1. The section header blade iterates through blocks and includes each component passing data:
   ```blade
   @foreach($componentsBlocks as $block)
       @include($block->view, $block->data)
   @endforeach
   ```

2. While the `$block->data` is passed to the component, the component doesn't explicitly define all expected props

3. The component instead relies on access to hardcoded URLs and dynamic auth checking, rather than using the provided configuration data

4. This breaks component modularity and makes it impossible to configure the menu items through the JSON configuration

## Proper Solution

1. Add missing props to the component:

```blade
@props([
    'alignment' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-800',
    'menu_items' => [],
    'guest_view' => null
])
```

2. Use the passed menu_items in the component:

```blade
@if($isLoggedIn)
    {{-- Dropdown menu for logged in user --}}
    <div class="relative" x-data="{ open: false }" @click.away="open = false">
        <!-- Button and avatar code... -->

        <div x-show="open" @click.away="open = false" class="absolute z-10 {{ $width }} {{ $alignmentClasses }} mt-2 rounded-md shadow-lg">
            <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
                @foreach($menu_items as $item)
                    @if(isset($item['type']) && $item['type'] === 'divider')
                        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                    @else
                        <a href="{{ $item['url'] }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            @if(isset($item['icon']))
                                <x-filament::icon :name="$item['icon']" class="mr-2 h-5 w-5 inline" />
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@else
    {{-- Use the provided guest view if available --}}
    @if($guest_view)
        @include($guest_view)
    @else
        {{-- Default login/register links --}}
        <div class="flex items-center space-x-4">
            <!-- Login/register links... -->
        </div>
    @endif
@endif
```

## Related Documentation

- [Block Components Overview](./README.md)
- [Data Handling in Blade Components](../blade-data-handling.md)
- [Section Architecture](../sections/README.md)

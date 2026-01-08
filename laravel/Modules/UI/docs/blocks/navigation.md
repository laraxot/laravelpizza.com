# Navigation Component

This document describes the Navigation component used in section headers and its proper implementation.

## Component Location

```
Themes/<ThemeName>/resources/views/components/blocks/navigation.blade.php
```

## Props Definition

The Navigation component demonstrates the correct pattern for handling data passed from section JSON:

```blade
@props([
    'items' => [],
    'alignment' => 'start',
    'orientation' => 'horizontal'
])
```

## Usage in Section JSON

In the section configuration JSON:

```json
{
    "name": {
        "it": "Menu di Navigazione",
        "en": "Navigation Menu"
    },
    "type": "navigation",
    "data": {
        "view": "pub_theme::components.blocks.navigation",
        "items": [
            {
                "label": "Home",
                "url": "/",
                "type": "link"
            },
            {
                "label": "Servizi",
                "url": "/servizi",
                "type": "link"
            },
            ...
        ],
        "alignment": "start",
        "orientation": "horizontal"
    }
}
```

## How Data is Passed

1. The section JSON contains a list of navigation items in the `data.items` property
2. The header section template passes all data to the component via `@include($block->view, $block->data)`
3. The component receives these values as individual variables through its props definition
4. The component iterates through items and renders appropriate markup based on item type

## Item Types and Structure

The navigation component supports different item types:

1. **Link**: Simple navigation link
   ```json
   {
       "label": "Home",
       "url": "/",
       "type": "link"
   }
   ```

2. **Button**: Call-to-action styled as button
   ```json
   {
       "label": "Register",
       "url": "/register",
       "type": "button"
   }
   ```

3. **Dropdown**: Menu with child items
   ```json
   {
       "label": "Services",
       "type": "dropdown",
       "children": [
           {
               "label": "Service 1",
               "url": "/services/1"
           },
           {
               "label": "Service 2",
               "url": "/services/2"
           }
       ]
   }
   ```

## Best Practices

1. **Iterate Through Items**: Always loop through the provided items array
2. **Type-Based Rendering**: Use conditional logic based on item type
3. **Responsive Design**: Include both desktop and mobile versions
4. **Accessibility**: Ensure proper ARIA attributes and keyboard navigation

## Related Documentation

- [Block Components Overview](./README.md)
- [Data Handling in Blade Components](../blade-data-handling.md)
- [Section Architecture](../sections/README.md)

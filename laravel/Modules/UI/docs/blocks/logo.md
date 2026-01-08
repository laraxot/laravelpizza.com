# Logo Component

This document describes the Logo component used in section headers and its proper implementation.

## Component Location

```
Themes/<ThemeName>/resources/views/components/blocks/logo.blade.php
```

## Props Definition

The Logo component properly demonstrates the correct pattern for handling data passed from section JSON:

```blade
@props([
    'src' => null,
    'alt' => '',
    'width' => null,
    'height' => null,
    'icon' => null,
    'size' => 'h-12 w-auto',
    'url' => null,
    'title' => null,
    'description' => null,
])
```

## Usage in Section JSON

In the section configuration JSON:

```json
{
    "name": {
        "it": "Logo",
        "en": "Logo"
    },
    "type": "logo",
    "data": {
        "view": "pub_theme::components.blocks.logo",
        "src": "patient::images/logo.svg",
        "alt": "{{ config('app.name') }}",
        "width": 150,
        "height": 32
    }
}
```

## How Data is Passed

1. The section JSON contains configuration data for the logo in the `data` property
2. The header section template passes this data to the component via `@include($block->view, $block->data)`
3. The component receives these values as individual variables through its props definition

## Best Practices

1. **Use Dynamic Configuration**: Never hardcode values like alt text or paths
2. **Always Define Props**: Every expected data field must be defined in `@props`
3. **Provide Defaults**: Set reasonable default values to make components resilient
4. **Use Asset Helper**: Use `$_theme->asset($src)` to resolve theme-relative paths

## Common Mistakes to Avoid

1. **Hardcoding Project Names**: Never include specific project names in alt text or elsewhere
2. **Missing Props**: Failing to define props for all expected data fields
3. **Direct Variable Access**: Avoid assuming variables will be available without props

## Related Documentation

- [Block Components Overview](./README.md)
- [Data Handling in Blade Components](../blade-data-handling.md)
- [Section Architecture](../sections/README.md)

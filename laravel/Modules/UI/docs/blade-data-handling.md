# Data Handling in Blade Components

This document outlines best practices for data handling in Blade components, particularly in theme blocks used for content sections.

## Core Principles

### 1. Explicit Props Definition

All Blade components should explicitly define their expected properties using the `@props` directive:

```blade
@props([
    'title' => null,
    'description' => null,
    'url' => null,
    'items' => [],
    // Additional props with sensible defaults
])
```

### 2. Data Flow Pattern

The standard data flow follows this pattern:

1. **Storage**: Data is stored in JSON configuration files (`config/local/{tenant}/database/content/sections/{id}.json`)
2. **Retrieval**: Section controller loads and processes the JSON data
3. **Passing**: Data is passed to components via `@include($block->view, $block->data)`
4. **Reception**: Components receive data through explicitly defined props
5. **Rendering**: Components render the received data according to their template

### 3. No Implicit Variables

Components should never rely on variables that haven't been explicitly defined as props. This prevents:
- Unexpected behavior
- Hard-to-trace bugs
- Tight coupling between components and their parent context
- Difficulty reusing components in different contexts

## Common Patterns

### Section to Block Data Flow

```php
// In sections/header.blade.php
@foreach($componentsBlocks as $block)
    @include($block->view, $block->data)
@endforeach
```

### Block Component Structure

```blade
// In components/blocks/example.blade.php
@props([
    'prop1' => default1,
    'prop2' => default2,
    // All expected properties
])

<div {{ $attributes->merge(['class' => 'example-component']) }}>
    @if($prop1)
        <h2>{{ $prop1 }}</h2>
    @endif

    @if($prop2)
        <p>{{ $prop2 }}</p>
    @endif
</div>
```

## Common Errors

### Missing Props Definition

```blade
<!-- INCORRECT: Missing props definition -->
<div class="user-menu">
    @foreach($menu_items as $item) <!-- $menu_items undefined! -->
        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
    @endforeach
</div>

<!-- CORRECT: With props definition -->
@props(['menu_items' => []])

<div class="user-menu">
    @foreach($menu_items as $item)
        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
    @endforeach
</div>
```

### Hard-coded References

```blade
<!-- INCORRECT: Hard-coded project references -->
<div class="title">Welcome to <nome progetto></div>

<!-- CORRECT: Dynamic configuration -->
<div class="title">Welcome to {{ config('app.name') }}</div>
```

### Direct Use of Auth System

```blade
<!-- INCORRECT: Direct dependency on auth system -->
@if(auth()->check())
    <!-- Authenticated UI -->
@endif

<!-- CORRECT: Parameterized authentication state -->
@props([
    'is_authenticated' => false,
    'user' => null
])

@if($is_authenticated)
    <!-- Authenticated UI -->
@endif
```

## Best Practices

1. **Validate Props**: Use type checking and conditional logic to validate props
2. **Provide Defaults**: Always set sensible default values for all props
3. **Document Expected Format**: Comment complex data structures expected by the component
4. **Keep Components Focused**: Each component should have a single responsibility
5. **Test Edge Cases**: Ensure components handle missing or malformed data gracefully

## Related Documentation

- [Block Components Overview](./blocks/README.md)
- [Component Architecture](./components/README.md)
- [Section Architecture](./sections/README.md)

> **Note**: This document is the primary reference for Blade data handling patterns across all modules.
> All module-specific implementations should link back to this document.
# Data Handling in Blade Components

This document outlines best practices for data handling in Blade components, particularly in theme blocks used for content sections.

## Core Principles

### 1. Explicit Props Definition

All Blade components should explicitly define their expected properties using the `@props` directive:

```blade
@props([
    'title' => null,
    'description' => null,
    'url' => null,
    'items' => [],
    // Additional props with sensible defaults
])
```

### 2. Data Flow Pattern

The standard data flow follows this pattern:

1. **Storage**: Data is stored in JSON configuration files (`config/local/{tenant}/database/content/sections/{id}.json`)
2. **Retrieval**: Section controller loads and processes the JSON data
3. **Passing**: Data is passed to components via `@include($block->view, $block->data)`
4. **Reception**: Components receive data through explicitly defined props
5. **Rendering**: Components render the received data according to their template

### 3. No Implicit Variables

Components should never rely on variables that haven't been explicitly defined as props. This prevents:
- Unexpected behavior
- Hard-to-trace bugs
- Tight coupling between components and their parent context
- Difficulty reusing components in different contexts

## Common Patterns

### Section to Block Data Flow

```php
// In sections/header.blade.php
@foreach($componentsBlocks as $block)
    @include($block->view, $block->data)
@endforeach
```

### Block Component Structure

```blade
// In components/blocks/example.blade.php
@props([
    'prop1' => default1,
    'prop2' => default2,
    // All expected properties
])

<div {{ $attributes->merge(['class' => 'example-component']) }}>
    @if($prop1)
        <h2>{{ $prop1 }}</h2>
    @endif

    @if($prop2)
        <p>{{ $prop2 }}</p>
    @endif
</div>
```

## Common Errors

### Missing Props Definition

```blade
<!-- INCORRECT: Missing props definition -->
<div class="user-menu">
    @foreach($menu_items as $item) <!-- $menu_items undefined! -->
        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
    @endforeach
</div>

<!-- CORRECT: With props definition -->
@props(['menu_items' => []])

<div class="user-menu">
    @foreach($menu_items as $item)
        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
    @endforeach
</div>
```

### Hard-coded References

```blade
<!-- INCORRECT: Hard-coded project references -->
<div class="title">Welcome to <nome progetto></div>
<div class="title">Welcome to <nome progetto></div>
<div class="title">Welcome to <nome progetto></div>

<!-- CORRECT: Dynamic configuration -->
<div class="title">Welcome to {{ config('app.name') }}</div>
```

### Direct Use of Auth System

```blade
<!-- INCORRECT: Direct dependency on auth system -->
@if(auth()->check())
    <!-- Authenticated UI -->
@endif

<!-- CORRECT: Parameterized authentication state -->
@props([
    'is_authenticated' => false,
    'user' => null
])

@if($is_authenticated)
    <!-- Authenticated UI -->
@endif
```

## Best Practices

1. **Validate Props**: Use type checking and conditional logic to validate props
2. **Provide Defaults**: Always set sensible default values for all props
3. **Document Expected Format**: Comment complex data structures expected by the component
4. **Keep Components Focused**: Each component should have a single responsibility
5. **Test Edge Cases**: Ensure components handle missing or malformed data gracefully

## Related Documentation

- [Block Components Overview](./blocks/README.md)
- [Component Architecture](./components/README.md)
- [Section Architecture](./sections/README.md)

> **Note**: This document is the primary reference for Blade data handling patterns across all modules.
> All module-specific implementations should link back to this document.

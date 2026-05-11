---
title: "Coordinate Picker State Binding Rule"
type: concept
sources: ["https://filamentphp.com/docs/5.x/forms/custom-fields"]
confidence: high
created: 2026-04-28
updated: 2026-04-28
tags: [coordinate-picker, state-binding, filament-5, alpine, livewire]
related:
  - concepts/coordinate-picker-comprehensive-guide.md
  - concepts/coordinate-picker-filament5-save-pattern.md
---

# Coordinate Picker State Binding Rule

## The Rule

**ALWAYS** use `$applyStateBindingModifiers()` when binding Livewire state in custom field Blade views.

## Correct Syntax (Filament 5.x)

```blade
<div x-data="{
    state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
    // ... other properties
}">
```

## Wrong Syntax (BROKEN)

```blade
{{-- WRONG: modifiers like live()/defer() are IGNORED --}}
<div x-data="{
    state: $wire.$entangle('{{ $getStatePath() }}'),
}">
```

## Why `$applyStateBindingModifiers()` is Required

From [Filament 5.x Custom Fields docs](https://filamentphp.com/docs/5.x/forms/custom-fields) section **"Obeying state binding modifiers"**:

1. **Respects `live()` modifier**: When user calls `CoordinatePicker::make('location')->live()`, the state must sync immediately on interact. `$applyStateBindingModifiers()` transforms `$entangle` into `$entangleLive`.

2. **Respects `defer()` modifier**: When user calls `->defer()`, state syncs only on form submit. `$applyStateBindingModifiers()` transforms `$entangle` into `$entangleDeferred`.

3. **Default behavior**: Without explicit modifier, Filament uses `defer` as default. The function applies this correctly.

## How It Works

```php
// In Filament's XotBaseField / Field class:
public function applyStateBindingModifiers(string $binding): string
{
    $modifier = $this->getStateBindingModifier(); // 'Live', 'Deferred', or ''
    
    if ($modifier === 'Live') {
        return str_replace('$entangle', '$entangleLive', $binding);
    }
    
    if ($modifier === 'Deferred') {
        return str_replace('$entangle', '$entangleDeferred', $binding);
    }
    
    return $binding; // default: $entangle (deferred)
}
```

## Real-World Proof

In `coordinate-picker.blade.php` (line 18):
```blade
state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
```

This generates in browser:
- If `->live()`: `state: $wire.$entangleLive('location')`
- If `->defer()` or default: `state: $wire.$entangle('location')`

## The `$statePath` Variable

```php
// In the Blade view:
$statePath = $field->getStatePath(); // e.g., 'location'
```

The state path is the dot-notation path to the field's value in the Livewire component's state.

## Complete Working Example

```blade
@php
$statePath = $getStatePath();
$key = $getKey();
@endphp

<div x-data="{
    state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
    
    updateCoords(lat, lng) {
        this.state = { 
            ...(this.state ?? {}), 
            latitude: lat, 
            longitude: lng 
        };
    }
}">
    <coordinate-picker-lit
        :state="state"
        @coords-changed="updateCoords($event.detail.latitude, $event.detail.longitude)"
    ></coordinate-picker-lit>

    <button
        type="button"
        x-on:click="
            $wire.callSchemaComponentMethod(
                @js($key),
                'reverseGeocode',
                { latitude: state.latitude, longitude: state.longitude }
            )
        "
    >
        reverse geocode
    </button>
</div>
```

## Checklist

- [ ] Always use `$applyStateBindingModifiers()` wrapper
- [ ] Never use raw `$wire.$entangle()` without it
- [ ] The `$statePath` must be inside the `$entangle()` call, not outside
- [ ] Use double quotes in PHP: `"\$entangle('{$statePath}')"`
- [ ] The Blade echo `{{ }}` wraps the entire `applyStateBindingModifiers()` call
- [ ] For `$wire.callSchemaComponentMethod()`, always pass `@js($getKey())` (component key), not a DOM id

## Cross-References

- **Filament Docs**: [Custom Fields - Obeying state binding modifiers](https://filamentphp.com/docs/5.x/forms/custom-fields)
- **Related**: See `concepts/coordinate-picker-filament5-save-pattern.md` for Eloquent mutator pattern
- **Trait**: `HasCoordinatePicker` sets up default state structure `{latitude: null, longitude: null}`

---
*Last updated: 2026-04-28*

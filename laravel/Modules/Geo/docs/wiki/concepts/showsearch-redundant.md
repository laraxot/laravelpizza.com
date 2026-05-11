---
title: ShowSearch Redundancy in GeopointPicker
---

## Problem
The Blade template `geopoint-picker.blade.php` used the expression:

```blade
show-search="{{ $field->showSearch() ? 'true' : 'false' }}"
```

even though the `HasCoordinatePicker` trait defines `$showSearch` **always true** and provides a setter that defaults to `true`. This made the conditional check unnecessary and added noise to the view code.

## Solution
- **Leave `$showSearch` always true** – it's configured in the trait default.
- The Blade now uses a local variable (converted from PHP method call):

```blade
{{-- Converted to local variable for clarity --}}
@php $showSearch = $field->getShowSearch(); @endphp
@if($showSearch)
    <div class="relative">
        <input type="text" ...>
    </div>
@endif
```

or bind the property (if configurable):

```blade
search-visible="{{ $field->getShowSearch() ? 'true' : 'false' }}"
```

**Note**: The original `show-search="{{ $field->showSearch() ? 'true' : 'false' }}"` pattern triggered a FatalError because it tried to call a non-existent `showSearch()` method after a bad edit. Always verify the trait's API with `Read` before editing.

## Why this matters
- Reduces Blade complexity (KISS).
- Avoids a false‑friend method call that can mislead developers.
- Keeps the component contract clear: search is always enabled.

## Related Rules
- **DRY Principle** – avoid duplicated logic between PHP trait and Blade view.
- **KISS Principle** – keep UI markup simple when behavior is constant.

---
*Added automatically by Claude Code on 2026-04-23.*
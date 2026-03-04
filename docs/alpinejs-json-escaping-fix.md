# Alpine.js JSON Escaping Fix

## Problem
When passing PHP data to Alpine.js via `x-data` attribute, using `{{ Js::from() }}` directly in the HTML attribute causes double escaping, making the JSON invalid.

## Wrong Syntax (Not Working)
```blade
<section x-data="{ events: {{ Js::from($eventsData) }} }">
```

Result HTML:
```html
x-data="{ events: [{\"id\":1,...}] }"  <!-- Double backslashes! -->
```

## Correct Solution
Pre-compute in PHP variable:
```blade
@php
    use Illuminate\Support\Js;
    $eventsJson = Js::from($eventsData);
@endphp

<section x-data="{ events: {{ $eventsJson }} }">
```

## Applied To
File: `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`

## Result
- Before: Events data present in x-data but not rendered (JSON escaping issue)
- After: 3 events visible: "Laravel 11 Release Pizza Party", "Filament Admin Panel Workshop", "Livewire 3 Pizza Meetup"

## Related Patterns
- Dynamic Events Block with query config (model, scope, orderBy, limit)
- CMS-driven content loading from database

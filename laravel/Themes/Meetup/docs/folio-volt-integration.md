# Folio + Volt Integration Guide

## Overview

This document describes the proper integration between **Laravel Folio** (page-based routing) and **Livewire Volt** (functional API for Livewire).

## Key Concepts

### 1. Folio Route Parameters

Folio automatically captures URL segments as variables:

```
pages/[container0]/[slug0]/index.blade.php
    ↓
Route: /events/laravel-pizza-night
$container0 = 'events'
$slug0 = 'laravel-pizza-night'
```

### 2. Volt Class Properties

Volt automatically binds route parameters to public properties:

```php
new class extends Component {
    // ✅ Folio automatically populates these from URL!
    public string $container0;
    public string $slug0;
};
```

**No `mount()` needed** for basic parameter binding - Volt handles it automatically.

### 3. The `$data` Array

For passing variables to child components (like CMS blocks), use `$data`:

```php
new class extends Component {
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // Build the slug for CMS JSON template
        $this->pageSlug = $this->container0 . '.view';
        
        // Pass variables to child components
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};
```

## Pattern: Generic Container Routing

### File Structure

```
resources/views/pages/
├── [slug].blade.php                    # Single page catch-all
├── [container0]/
│   ├── index.blade.php                # Container list (e.g., /events)
│   └── [slug0]/
│       └── index.blade.php            # Container detail (e.g., /events/laravel-pizza)
```

### [container0]/[slug0]/index.blade.php

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // ✅ Folio automatically injects these from URL
    public string $container0;
    public string $slug0;
    
    // For passing to CMS components
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // Build slug: events.view, blog.view, etc.
        $this->pageSlug = $this->container0 . '.view';
        
        // Pass to CMS blocks via $data
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};
?>

<x-layouts.app>
    @volt('container0.view')
    <div>
        {{-- $pageSlug = 'events.view' loads events.view.json --}}
        {{-- $data passes container0/slug0 to blocks --}}
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

## Pattern: Volt Component with Model Loading

For components that need interactivity (registration, filtering), use Volt Class:

### events/detail.blade.php (Volt-powered)

```php
<?php

declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

?>

@props([
    'event' => null,  // Passed from CMS
    'item' => null,   // Generic alternative
    'container0' => '',
    'slug0' => '',
])

<?php
// Volt class for reactivity - loads model if not provided
new class extends Component {
    public ?Event $eventModel = null;
    public string $eventsUrl = '';

    public function mount(): void
    {
        // Use passed event or load from slug
        $this->eventModel = $this->resolveEvent();
        $this->eventsUrl = LaravelLocalization::localizeUrl('/events');
    }

    private function resolveEvent(): ?Event
    {
        // If already passed from CMS, use it
        if ($this->event instanceof Event) {
            return $this->event;
        }
        
        if ($this->item instanceof Event) {
            return $this->item;
        }
        
        // Otherwise load from slug
        if (!empty($this->slug0)) {
            return Event::where('slug', $this->slug0)->first();
        }
        
        return null;
    }
};
?>

{{-- Blade template uses $this->eventModel --}}
@if($this->eventModel)
    <h1>{{ $this->eventModel->title }}</h1>
    ...
@endif
```

## Key Differences: Blade vs Volt

| Aspect | Blade Component | Volt Component |
|--------|-----------------|----------------|
| Reactivity | No | Yes (Livewire) |
| Model Loading | Manual in @php | In mount() |
| Properties | Via @props | Public properties |
| Interactivity | Limited | Full (forms, updates) |

## Common Mistakes

### ❌ Wrong: Manual route extraction
```php
public function mount(): void
{
    $this->slug0 = request()->route('slug0'); // ❌ VIETATO: Estrazione manuale - Volt si arrangia da solo con quei parametri!
}
```

### ✅ Correct: Let Volt handle it
```php
public string $slug0; // Volt auto-populates from Folio
```

### ❌ Wrong: Logic in page, not in component
```php
// In page
$event = Event::where('slug', $slug)->first(); // WRONG!
```

### ✅ Correct: Logic in component or CMS block
```php
// In block component
if (!$event) {
    $event = Event::where('slug', $slug0)->first();
}
```

## References

- [Laravel Folio Documentation](https://laravel.com/docs/12.x/folio)
- [Livewire Volt Documentation](https://livewire.laravel.com/docs/4.x)
- [Folio GitHub](https://github.com/laravel/folio)

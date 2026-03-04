# Folio + Filament Widgets Integration Guide

## Overview

This document describes the proper integration between **Laravel Folio** (page-based routing), **Blade components** (static content), and **Filament Widgets** (interactivity).

## ⚠️ CRITICAL RULE: NO Pure Livewire!

**We NEVER use pure Livewire components directly.** Instead, we always use **Filament Widgets** for any interactivity.

| Need | Use Instead |
|------|-------------|
| Pure Livewire Component | ❌ DON'T USE |
| Interactive UI | ✅ Filament Widget (extends XotBaseWidget) |
| Form handling | ✅ Filament Form Widget |
| Dashboard stats | ✅ Filament Chart/Stats Widget |

## Architecture Layers

```
┌─────────────────────────────────────────────┐
│           Folio (Page Routing)             │
│  pages/[container0]/[slug0]/index.blade.php│
└─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────┐
│         Blade Components (Static)            │
│  components/blocks/events/detail.blade.php │
│  - No interactivity                         │
│  - Pure Blade + Alpine.js                  │
└─────────────────────────────────────────────┘
                    │
                    ▼ (if needed)
┌─────────────────────────────────────────────┐
│       Filament Widgets (Interactive)        │
│  Modules/Meetup/app/Filament/Widgets/      │
│  - Form handling                           │
│  - Real-time updates                       │
│  - User interactions                       │
└─────────────────────────────────────────────┘
```

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

### 2. Blade Components (Static)

Use Blade for static display - no Livewire, no Volt:

```blade
{{-- components/blocks/events/detail.blade.php --}}
@props(['event' => null])

@php
$eventData = [
    'title' => $event?->title ?? 'Event Title',
    // ...
];
@endphp

<h1>{{ $eventData['title'] }}</h1>
```

### 3. Filament Widgets (Interactive)

For interactivity, create a Filament Widget:

```php
// Modules/Meetup/app/Filament/Widgets/EventRegistrationWidget.php
namespace Modules\Meetup\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Meetup\Models\Event;

class EventRegistrationWidget extends Widget
{
    public ?Event $event = null;
    
    protected static string $view = 'meetup::widgets.event-registration';
    
    public function register(): void
    {
        // Form fields definition
    }
    
    public function submit(): void
    {
        // Handle registration
    }
}
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

## Adding Interactivity: Filament Widgets

When you need forms, real-time updates, or user interactions:

### 1. Create a Filament Widget

```php
// Modules/Meetup/app/Filament/Widgets/EventRegistrationWidget.php
namespace Modules\Meetup\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Modules\Meetup\Models\Event;

class EventRegistrationWidget extends Widget
{
    protected static string $view = 'meetup::widgets.event-registration';
    
    public ?Event $event = null;
    public array $formData = [];
    
    public function mount(): void
    {
        $this->event = Event::where('slug', $this->event->slug ?? '')->first();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
            ])
            ->statePath('formData');
    }
    
    public function submit(): void
    {
        // Handle registration
    }
}
```

### 2. Render in Blade

```blade
{{-- In event detail blade --}}
<x-meetup::widgets.event-registration :event="$event" />
```

## Common Mistakes

### ❌ Wrong: Using Volt/Livewire directly
```php
// NEVER do this in Blade!
new class extends Component {
    public function mount() { ... }
}
```

### ✅ Correct: Blade for static, Widgets for interactive

```blade
{{-- Static display - pure Blade --}}
<h1>{{ $event->title }}</h1>

{{-- Interactive - Filament Widget --}}
<x-meetup::widgets.event-registration :event="$event" />
```

### ❌ Wrong: Logic in page
```php
// In page
$event = Event::where('slug', $slug)->first();
```

### ✅ Correct: Logic in component or CMS
```php
// In blade component
@php
$event = Event::where('slug', $slug0)->first();
@endphp
```

## References

- [Laravel Folio Documentation](https://laravel.com/docs/12.x/folio)
- [Filament Widgets Documentation](https://filamentphp.com/docs/3.x/widgets)
- [XotBaseWidget](modules/xot/docs/xotbase-extension-rules.md)

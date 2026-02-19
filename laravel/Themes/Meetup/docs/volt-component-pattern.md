# Volt Component Pattern - Meetup Theme

## 🚫 ANTI-PATTERN: BLADE con PHP INLINE (VIETATO)

```php
<?php
// ❌❌❌ MAI FARE QUESTO - COMPLETAMENTE SBAGLIATO ❌❌❌
declare(strict_types=1);

use Modules\Meetup\Models\Event;

// Carica l'evento dallo slug - LOGICA INLINE VIETATA!
$slug0 = $slug0 ?? '';
$slugToUse = $slug0;
if (empty($slugToUse)) {
    $slugToUse = Request::segment(3);
}
$event = null;
if (!empty($slugToUse)) {
    $event = Event::where('slug', $slugToUse)->first();
}
$eventsUrl = LaravelLocalization::localizeUrl('/events');
$isUpcoming = $event?->start_date?->isFuture() ?? true;
?>

<div>
    @if($event)
        <p>{{ $event->title }}</p>
    @endif
</div>
```

**Perché è SBAGLIATO:**
- ❌ Non reattivo (no Livewire)
- ❌ Logica sparsa nel template
- ❌ Difficile da testare
- ❌ Non type-safe
- ❌ Non segue filosofia Laraxot
- ❌ Mix di PHP e Blade senza struttura

**⚠️ MAI tornare a questo pattern. È un errore architetturale grave.**

---

## ✅ PATTERN CORRETTO: VOLT COMPONENT

Il **Volt Component Pattern** è l'unico pattern approvato per componenti interattivi.

### Esempio Corretto

```php
<?php

/**
 * Event Detail - Volt Component
 * Unica fonte di verità: Modello Event.
 */

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

new class extends Component {
    // Props from parent/route
    public ?Event $event = null;
    public ?Event $item = null;
    public string $container0 = '';
    public string $slug0 = '';
    
    // Component state
    public bool $showBookingModal = false;
    public string $bookingName = '';
    public string $bookingEmail = '';
    public string $shareUrl = '';
    
    public function mount(): void
    {
        if ($this->event === null && $this->item === null && !empty($this->slug0)) {
            $this->event = Event::where('slug', $this->slug0)->first();
        }
        
        if ($this->event) {
            $this->shareUrl = LaravelLocalization::localizeUrl('/events/' . $this->event->slug);
        }
    }
    
    public function isUpcoming(): bool
    {
        return $this->event?->start_date?->isFuture() ?? false;
    }
};
?>

<div>
    @if($this->event)
        <h1>{{ $this->event->title }}</h1>
        <p>{{ $this->isUpcoming() ? 'Upcoming' : 'Past' }}</p>
    @endif
</div>
```

## Overview

This document describes the **Volt Component Pattern** used for interactive frontend components in the Meetup theme.

## Why Volt?

Volt provides a class-based API for Livewire components directly in Blade files, offering:
- **Type Safety**: Full PHP type hints and static analysis support
- **Reactivity**: Automatic UI updates when properties change
- **Simplicity**: No separate class files needed - everything in one `.blade.php` file
- **Folio Integration**: Seamless integration with Laravel Folio routing

## Pattern Structure

### File Location
```
Themes/Meetup/resources/views/components/blocks/{block}/{component}.blade.php
```

### Required Pattern

```php
<?php

/**
 * Component Name - Volt Component
 * Brief description of component purpose
 * 
 * @see Themes/Meetup/docs/volt-component-pattern.md
 */

use Livewire\Volt\Component;
// Other imports...

new class extends Component {
    // Props from parent/route - auto-injected by Volt/Folio
    public ?Model $model = null;
    public string $slug0 = '';
    
    // Component state properties
    public bool $showModal = false;
    public string $inputValue = '';
    
    public function mount(): void
    {
        // Initialize data from props or load from database
        if ($this->model === null && !empty($this->slug0)) {
            $this->model = Model::where('slug', $this->slug0)->first();
        }
    }
    
    // Action methods
    public function save(): void
    {
        // Business logic here
        $this->dispatch('notify', ['message' => 'Saved!']);
    }
};

?>

<div>
    <!-- Template uses $this->property syntax -->
    @if($this->model)
        <h1>{{ $this->model->title }}</h1>
        <button wire:click="$this->showModal = true">Open</button>
    @endif
</div>
```

## Key Principles

### 1. Single Source of Truth
- The **Model** is the single source of truth
- Access model properties directly: `$this->event->title`
- Only create component properties for UI state or computed values

### 2. No @props() in Volt Components
- **WRONG**: Using `@props(['event' => null])` with Volt class
- **CORRECT**: Define properties in the Volt class, let Folio/Volt auto-inject

### 3. Template Syntax
- Always use `$this->property` to access component properties
- Access model properties directly: `$this->event->property`
- Use `wire:click` for actions: `wire:click="openModal"` or `wire:click="$this->showModal = true"`

### 4. Mount Method
- Use `mount()` to initialize data from props or database
- Volt auto-injects route parameters (`slug0`, `container0`) as public properties
- Handle fallback logic in `mount()`, not in template

## CMS Integration

### Enabling Volt in CMS Blocks

1. **Add `livewire: true` flag** in the JSON page configuration:

```json
{
  "slug": "events.view",
  "blocks": [
    {
      "name": "event-detail",
      "view": "pub_theme::components.blocks.events.detail",
      "livewire": true
    }
  ]
}
```

2. **CMS renders Volt components** via `page-content.blade.php`:

```blade
@if(isset($block->livewire) && $block->livewire)
    @livewire($block->view, $block->data)
@else
    @include($block->view, $block->data)
@endif
```

## Example: Event Detail

**File**: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

```php
<?php

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

new class extends Component {
    public ?Event $event = null;
    public ?Event $item = null;
    public string $slug0 = '';
    
    public bool $showBookingModal = false;
    public string $bookingName = '';
    
    public function mount(): void
    {
        if ($this->event === null && $this->item === null && !empty($this->slug0)) {
            $this->event = Event::where('slug', $this->slug0)->first();
        }
    }
    
    public function isUpcoming(): bool
    {
        return $this->event?->start_date?->isFuture() ?? false;
    }
};

?>

<div>
    @if($this->event)
        <h1>{{ $this->event->title }}</h1>
        @if($this->isUpcoming())
            <button wire:click="$this->showBookingModal = true">Book Now</button>
        @endif
    @endif
</div>
```

## Anti-Patterns to Avoid

### ❌ Using @props() with Volt Class
```php
<?php
new class extends Component {
    public ?Event $event = null;
};
?>

@props(['event' => null])  <!-- WRONG! Don't use @props with Volt -->
```

### ❌ Inline PHP Logic in Template
```php
@php  <!-- WRONG! Move to mount() or methods -->
$event = Event::where('slug', $slug)->first();
@endphp
```

### ❌ Computed Properties for Static Data
```php
// WRONG - Don't create properties for data that exists on model
public string $title = '';
public string $date = '';

// CORRECT - Access model directly in template
{{ $this->event->title }}
{{ $this->event->start_date->format('...') }}
```

## Benefits

1. **Cleaner Templates**: No inline PHP, all logic in class
2. **Type Safety**: Full PHPStan compliance possible
3. **Testability**: Component logic can be unit tested
4. **Maintainability**: Single file for component logic + template
5. **Reactivity**: Automatic UI updates on property changes

## Migration from Plain Blade

When converting a plain Blade component to Volt:

1. Add `use Livewire\Volt\Component;`
2. Wrap PHP logic in `new class extends Component {}`
3. Move `@props` to public property declarations
4. Move inline PHP to `mount()` method
5. Replace direct variable access with `$this->property`
6. Add `livewire: true` to CMS block config
7. Update `page-content.blade.php` to support Livewire rendering

## See Also

- [Agnostic Routing](agnostic-routing.md) - How Volt integrates with Folio
- [Helper Class Pattern](helper-class-pattern.md) - Alternative for non-interactive components
- Laravel Volt Documentation: https://livewire.laravel.com/docs/volt

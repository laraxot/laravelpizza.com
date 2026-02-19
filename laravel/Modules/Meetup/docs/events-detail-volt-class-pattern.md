# Events Detail Component - Plain Blade Pattern

## Core Principle: CMS Block Components Are Always Plain Blade

CMS block components in `components/blocks/` are **plain Blade files** — not Volt, not Livewire.
They use a PHP block at the top for variable setup and Alpine.js for client-side interactivity.

The name of this file preserves historical continuity but documents the **correct** pattern,
which is the opposite of what the filename implies: CMS blocks must NOT use Volt.

---

## Why Volt/Livewire Is Wrong for CMS Block Components

The CMS block rendering system uses `@include` (or equivalent PHP `include`) to render blocks:

```php
// Modules/Cms/resources/views/components/page-content.blade.php
@include($block['view'], $block['data'] ?? [])
```

`@include` is a plain Blade include — it does NOT bootstrap a Livewire/Volt component scope.
Using `@volt()` inside an `@include`'d file causes one of two outcomes:

1. The `@volt` directive is silently ignored (no Livewire scope, broken `$this->` references)
2. A fatal error if Livewire tries to mount a component outside its lifecycle

**Conclusion**: `@volt` and `wire:` directives must never appear in `components/blocks/` files.

---

## When to Use @volt vs Plain Blade

| Location | Pattern | Why |
|---|---|---|
| `pages/*.blade.php` (Folio route files) | `@volt('name')` / Volt class | Folio bootstraps Livewire scope |
| `components/blocks/*.blade.php` (CMS blocks) | Plain Blade | Rendered via `@include`, no Livewire scope |
| `components/sections/*.blade.php` (CMS sections) | Plain Blade | Same — rendered via `@include` |
| `components/*.blade.php` (generic) | Plain Blade | Standard Laravel components |

**Rule**: `@volt` appears ONLY in Folio page files under `pages/`. Never in `components/`.

---

## Correct Pattern: Plain Blade Block Component

```php
<?php

declare(strict_types=1);

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;

// Resolve slug from injected variable or URL segment fallback
$slug0 = $slug0 ?? request()->segment(3) ?? '';

$event = $slug0 !== ''
    ? Event::where('slug', $slug0)->first()
    : null;

$eventsUrl = LaravelLocalization::localizeUrl('/events');
$isUpcoming = $event?->start_date?->isFuture() ?? true;
$statusLabel = $isUpcoming ? 'Upcoming' : 'Past Event';
$badgeClass  = $isUpcoming ? 'bg-green-600' : 'bg-slate-500';
?>

<div x-data="{ showMap: false, showShareMenu: false }">

    @if ($event)

        {{-- Back link --}}
        <a href="{{ $eventsUrl }}" class="text-sm text-red-400 hover:text-red-300">
            &larr; Back to Events
        </a>

        {{-- Status badge --}}
        <span class="inline-block px-2 py-1 text-xs font-semibold text-white rounded {{ $badgeClass }}">
            {{ $statusLabel }}
        </span>

        {{-- Event title --}}
        <h1 class="text-3xl font-bold text-white">
            {{ $event->title ?? 'Event' }}
        </h1>

        {{-- Alpine.js interactivity --}}
        <button @click="showMap = !showMap" class="text-sm text-red-400">
            Toggle Map
        </button>

        <div x-show="showMap" x-transition>
            {{-- map embed --}}
        </div>

    @else

        <p class="text-gray-400">Event not found.</p>
        <a href="{{ $eventsUrl }}" class="text-red-400 hover:text-red-300">
            Back to Events
        </a>

    @endif

</div>
```

---

## What Is Forbidden in Block Components

```php
// WRONG — Volt class inside a CMS block
@volt('events-detail')
new class extends Component {
    public ?Event $event = null;

    public function mount(): void { ... }
};
?>
<div>{{ $this->event?->title }}</div>
@endvolt

// WRONG — wire: directives
<button wire:click="loadEvent">Load</button>

// WRONG — $this-> references outside Volt scope
{{ $this->event?->title }}

// WRONG — Livewire component tag
@livewire('events.detail', ['slug' => $slug0])
```

---

## Data Flow: How Slug Reaches the Block

```
URL:         /it/events/laravel-beginners-pizza-night
              └─ segment(3) = "laravel-beginners-pizza-night"

Folio page:  pages/[container0]/[slug0]/index.blade.php
              └─ $slug0 = "laravel-beginners-pizza-night" (from Folio binding)

JSON config: events_view.json
              └─ content_blocks[*].data.slug0 is NOT set (absent)

CMS include: @include('pub_theme::components.blocks.events.detail', $blockData)
              └─ $slug0 may be absent from $blockData

Block file:  components/blocks/events/detail.blade.php
              └─ $slug0 = $slug0 ?? request()->segment(3) ?? ''
              └─ Fallback to segment(3) ensures the slug is always resolved
```

The fallback `request()->segment(3)` is the safety net when the JSON block data
does not explicitly pass `slug0`.

---

## File Location

```
Themes/Meetup/resources/views/
└── components/
    └── blocks/
        └── events/
            └── detail.blade.php   ← this component (plain Blade)

pages/
└── [container0]/
    └── [slug0]/
        └── index.blade.php        ← Folio route (may use @volt)
```

---

## References

- [Volt Components Usage](volt-components-usage.md)
- [CMS Block System](../../modules/cms/docs/content-blocks-system.md)
- [Folio Container Routing Priority](folio-container-routing-priority.md)
- [Events Detail Slug0 Loading](events-detail-slug0-loading.md)

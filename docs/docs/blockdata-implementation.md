# BlockData: Auto-Detection and Rendering

## Overview

`BlockData` (`Modules/Cms/app/Datas/BlockData.php`) is the central class for CMS block rendering. It resolves view paths, validates existence, and — critically — **auto-detects Volt/Livewire components**.

## Volt Auto-Detection (CRITICAL)

`BlockData::detectLivewire()` reads the first 1024 bytes of the view file. If it contains any of:
- `new class extends Component`
- `Livewire\Volt\Component`
- `volt(`
- `state(`

...then `$block->livewire = true` and `$block->livewireComponentName` is set.

**This means: block views that use `new class extends Component` are automatically promoted to Livewire components.** `page-content.blade.php` then uses `@livewire()` instead of `@include()` to render them.

```php
// BlockData::detectLivewire() — reads first 1024 bytes
$header = fread($handle, 1024);
return str_contains($header, 'new class extends Component') ||
       str_contains($header, 'Livewire\Volt\Component') || ...;
```

### Component Name Normalization

`normalizeComponentName()` strips known prefixes to produce the short Livewire name:

```
pub_theme::components.blocks.events.detail → events.detail
pub_theme::components.blocks.hero.main     → hero.main
cms::components.blocks.foo.bar             → foo.bar
```

## Rendering Chain

```
JSON block { view: "pub_theme::components.blocks.events.detail" }
  ↓
BlockData::__construct()
  ↓
detectLivewire() → reads first 1024 bytes of file
  ↓ (if Volt detected)
$block->livewire = true
$block->livewireComponentName = "events.detail"
  ↓
page-content.blade.php:
@livewire('events.detail', array_merge($block->data, $data), key(...))
  ↓
Volt component mount() receives: ['slug0' => '...', 'container0' => '...', ...]
```

## When to Use Volt vs Plain Blade

| Use Case | Pattern |
|----------|---------|
| Block needs state, events, or model loading | `new class extends Component` → Volt |
| Block is purely display/read-only | Plain Blade (no PHP class) |

**Rule**: If a block needs to load a database model (e.g., Event by slug), it MUST be a Volt component so it gets `$slug0` passed via Livewire's prop injection.

## Passing Route Parameters to Volt Blocks

Route parameters (`container0`, `slug0`, etc.) are passed via the `$data` array:

```
[container0]/[slug0]/index.blade.php
  → mount() builds $data = ['container0' => ..., 'slug0' => ...]
  → <x-page :data="$data">
  → page.blade.php merges $data into block data
  → page-content.blade.php: @livewire('events.detail', array_merge($block->data, $data))
  → events.detail Volt component: mount(?string $slug0 = null) receives slug0
```

**Merge order in `page.blade.php` is critical:**

```php
// CORRECT — $data wins over defaults:
array_merge(['container0' => $container0, 'slug0' => $slug0], $data)

// WRONG — empty default strings override $data values:
array_merge($data, ['container0' => $container0, 'slug0' => $slug0])
```

## Scalable $data Pattern

The `$data` bag is designed to scale with nesting depth:

```php
// Current depth:
$data = ['container0' => 'events', 'slug0' => 'laravel-pizza'];

// Future depth (container1, container2, ...):
$data = ['container0' => 'events', 'slug0' => '2025', 'container1' => 'talk', 'slug1' => 'livewire-intro'];
```

**Never pass `container0`/`slug0` as explicit props to `<x-page>` — always use `$data`.**

## Guarantees

1. `$block->data` is always a valid array
2. `$block->view` is always an existing view (or throws Exception)
3. `$block->livewire` is `true` only for Volt components
4. `$block->livewireComponentName` is the short name for `@livewire()`

## Related Files

- `Modules/Cms/app/Datas/BlockData.php` — source
- `Modules/Cms/resources/views/components/page-content.blade.php` — renders blocks
- `Modules/Cms/resources/views/components/page.blade.php` — merges $data
- `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php` — builds $data
- `Modules/Meetup/docs/folio-container-routing-priority.md` — routing architecture

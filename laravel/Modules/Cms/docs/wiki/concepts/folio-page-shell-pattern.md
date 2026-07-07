---
title: "Folio page shell — mount(), x-page, @volt statico"
type: concept
tags: [cms, folio, x-page, mount, volt, container0, container1]
created: 2026-06-05
updated: 2026-06-06
qmd: "cms folio page shell mount x-page volt static name container0 container1 data bag"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/291"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../../../docs/wiki/bmad/architecture-folio-page-shell.md
  - ../../../folio_routing_system.md
  - ../../../../../../docs/wiki/memories/volt-route-params-mount-contract.md
  - ../../../../Themes/Sixteen/docs/wiki/concepts/folio-route-params-mount.md
---

# Folio page shell — `mount()`, `<x-page>`, `@volt` statico

## Scopo

Il file Folio è solo **routing + contesto**. Il CMS risolve blocchi via `<x-page>`; la business logic resta nei moduli (Actions, blocchi JSON).

## Contratto

| Layer | Responsabilità |
|-------|----------------|
| `mount($container0, …)` | Segmenti URL → proprietà + `$data` (data bag) |
| `name('…')` | Named route Folio |
| `@volt('…')` | Stringa **statica** = stesso valore di `name()` (obbligatoria con `extends Component`) |
| `<x-page :slug :data>` | Carica pagina/blocchi CMS |

## Esempio `[container0]/index` (lista — Filament way)

| Folio | `name()` / `@volt()` | `$pageSlug` CMS |
|-------|----------------------|-----------------|
| `[container0]/index` | `container0.index` | `{container0}.index` |

```php
name('container0.index');

new class extends Component {
    public function mount(string $container0): void
    {
        $this->pageSlug = $container0.'.index';
        $this->data = ['container0' => $container0];
    }
};
```

**Vietato:** `container0.list`, `match` locale→`home`, `CmsPage`/`pageTitle` nel mount. Canon Sixteen: [folio-container0-index-filament-way.md](../../../../../../docs/wiki/memories/folio-container0-index-filament-way.md).

## Esempio `[container1]`

```php
name('container1.index');

new class extends Component {
    public function mount(string $container0, string $slug0 = '', string $container1 = ''): void
    {
        $this->pageSlug = $container0.'.view';
        $this->data = compact('container0', 'slug0', 'container1');
    }
};
```

```blade
@volt('container1.index')
<x-page side="content" :slug="$pageSlug" :data="$data" />
@endvolt
```

`container1` vive in `$data`, non nello slug CMS, salvo regola esplicita in `mount()`.

## Vietato

```blade
@props([...])                    {{-- ❌ in pages/ Folio — ok solo in components/ --}}
@extends('layouts.app')          {{-- ❌ doppio layout --}}
@section('content')               {{-- ❌ MVC legacy --}}
@php $pageSlug = ... @endphp      {{-- ❌ usare mount() --}}
@volt($pageSlug)
@volt($container0 . '.view')
@php $container0 = request()->route('container0'); @endphp
```

Shell canon: [folio-page-shell-no-props-extends.md](../../../../../../docs/wiki/memories/folio-page-shell-no-props-extends.md).

`$pageSlug` è runtime (`servizi.view`, …) — `@volt()` è compile-time.

## Backlink

- [page-component-context-data.md](../../../page-component-context-data.md)
- [x-page-data-bag-only.md](./x-page-data-bag-only.md)

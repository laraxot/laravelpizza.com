---
title: "Folio + Volt — mount() e @volt statico"
type: concept
module: Cms
tags: [cms, folio, volt, mount, x-page, data-bag]
created: 2026-06-05
updated: 2026-06-05
qmd: "cms folio volt mount static name x-page data bag container0 container1"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/291"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/259"
related:
  - ../../../../../../docs/wiki/memories/volt-route-params-mount-contract.md
  - ../../../../../../docs/wiki/rules/cms-x-page-data-bag-only.md
  - ../../components/page-component-data-contract.md
  - ../../../../Themes/Sixteen/docs/folio-page-pattern.md
---

# Folio + Volt — `mount()` e `@volt` statico

## Scopo (business)

Il modulo Cms non conosce i segmenti URL del tema: riceve solo `:slug` e `:data` da `<x-page>`. Il tema Folio traduce path → stato tipizzato in `mount()`.

## Contratto tema → CMS

```
URL /{locale}/{container0}/{slug0}/{container1}
  → mount(string $container0, string $slug0, string $container1)
  → $pageSlug (slug CMS, es. services.view)
  → $data = ['container0' => …, 'slug0' => …, 'container1' => …]
  → <x-page side="content" :slug="$pageSlug" :data="$data" />
```

## Volt nel tema (non nel modulo)

- `new class extends Component` + `@volt('…')` **statico** = `name('…')`
- **Vietato:** `@volt($pageSlug)` — confonde slug CMS con nome componente Livewire

## Responsabilità

| Layer | Owner | Ruolo |
|-------|-------|-------|
| Folio filename + `mount()` | Theme Sixteen | Params URL, `$data` |
| `@volt` statico | Theme Sixteen | SFC Livewire |
| `<x-page>` | Modulo Cms | Blocchi JSON, widget Filament |
| Business logic | Moduli dominio | Actions, modelli |

## Verifica cross-repo

- `Themes/Sixteen/tests/Unit/FolioPageMountContractTest.php`
- `rg "request\\(\\)->route\\('container0" Themes/Sixteen/resources/views/pages`

## Backlink

- [page-component-data-contract.md](../../components/page-component-data-contract.md)
- [x-page-data-bag-only.md](./x-page-data-bag-only.md)
- [volt-route-params-mount-contract](../../../../../../docs/wiki/memories/volt-route-params-mount-contract.md)

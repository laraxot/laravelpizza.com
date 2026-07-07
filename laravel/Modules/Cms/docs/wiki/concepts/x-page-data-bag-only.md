# `<x-page>` — solo `side`, `slug`, `data`

## religione

Il componente **trasporta** blocchi CMS; **non conosce** segmenti Folio né modelli dominio.

Con 1000 container non esistono 1000 prop Blade: esiste **un** data bag.

## pattern

```php
// Volt / Folio mount
$this->data = [
    'container0' => $container0,
    'slug0' => $slug0,
];
```

```blade
<x-page side="content" :slug="$pageSlug" :data="$data" />
```

## vietato

```blade
<x-page :container0="..." :slug0="..." />
```

## implementazione

- `Modules\Cms\View\Components\Page` — costruttore: `side`, `slug`, `type`, `data`
- `render()` — `array_merge($data, ['blocks', 'side', 'slug', 'data'])`
- Blocchi: `array_merge($data, $block->data)` in `cms::components.page`

## perché

| Principio | Effetto |
|-----------|---------|
| KISS | Un contratto per tutte le route |
| DRY | Nessuna modifica a `Page` per `containerN` |
| Zen | Shell agnostica; significato nei blocchi / `ResolvePageAction` |

## collegamenti

- ADR progetto: [cms-x-page-opaque-data-bag.md](../../../../../../docs/wiki/decisions/cms-x-page-opaque-data-bag.md)
- [page-context-data-bag.md](../../components/page-context-data-bag.md)
- [page-component-data-contract.md](../../components/page-component-data-contract.md)
- [folio_routing_system.md](../../folio_routing_system.md)
- STORY-136 · [#243](https://github.com/laraxot/base_fixcity_fila5/issues/243)
- Rule: `.cursor/rules/cms-x-page-data-bag-only.mdc`

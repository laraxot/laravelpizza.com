---
title: "page component data contract"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "page component data contract"
issues: []
discussions: []
---

# Page Component - Data Contract

## Principio: $data come carrier universale

Il componente `<x-page>` usa `$data` come array generico per trasportare variabili di contesto verso i blocchi. Non conosce né dipende da specifici parametri come `container0`, `slug0`.

## API del componente

```blade
<x-page
    side="content"
    :slug="$pageSlug"
    :data="$data"
/>
```

## Parametri del costruttore

```php
public function __construct(
    string $side,           // "content", "sidebar", "footer"
    string $slug,           // slug della pagina CMS (es. "events.view")
    ?string $type = null,   // prefisso opzionale: "type-slug"
    array $data = [],       // contesto opaco, passato attraverso ai blocchi
)
```

`$data` puo' contenere qualsiasi chiave. Esempi attuali:
- `container0`, `slug0` — parametri di routing nidificato
- `event` — modello Event per la pagina di dettaglio
- `item` — modello generico per pagine di dettaglio

Esempi futuri (senza toccare il componente):
- `container1`, `slug1` — routing a 3 livelli
- `product` — pagina di dettaglio prodotto
- `article` — pagina di dettaglio articolo

## render() — come $data viene esposto alla view

```php
public function render(): ViewContract
{
    $view_params = array_merge($this->data, [
        'blocks' => $this->blocks,
        'side'   => $this->side,
        'slug'   => $this->slug,
        'data'   => $this->data,
    ]);
    return view('cms::components.page', $view_params);
}
```

La merge mette i parametri fissi (`blocks`, `side`, `slug`, `data`) DOPO `$this->data`.
Cio' garantisce che `$data` non possa mai sovrascrivere le variabili di sistema.

## Accesso ai dati in page.blade.php

In `cms::components.page` (cioe' `page.blade.php`):
- `$blocks` — array di BlockData per il side corrente
- `$side` — "content" / "sidebar" / "footer"
- `$slug` — slug della pagina
- `$data` — l'array completo (da passare ad @include)
- Tutti i tasti di `$data` come variabili dirette (da array_merge spread)

Poi ogni blocco viene incluso:
```blade
@include($block->view, array_merge($data, $block->data))
```
Questo espone `$container0`, `$slug0`, `$event`, `$item`, ecc. nel blocco incluso.

## `item` gia' risolto dalla pagina Folio

Per le rotte dinamiche (`container0` + `slug0` nel data bag) il componente risolve il contenitore CMS con `ResolvePageAction`
e risponde 404 se non c'e' ne' un modello ne' una pagina CMS. Se pero' la pagina Folio passa gia' un `item` (oggetto) nel
data bag, il componente **non** lo rilegge e **non** decide la visibilita': il record e' stato risolto e autorizzato dal
codice della pagina (es. `Event::visibleTo()` per `/events/{slug}`, con anteprima della bozza al proprietario; `User` per
`/profile/{id}`), non dall'URL. Prima di questa uscita un record valido dava 404 perche' `ResolvePageAction` non conosceva
il contenitore (allowlist `container0_models` vuota). Gli identificativi senza `item` seguono invece la risoluzione di
`ResolvePageAction` (vedi [container0-model-allowlist](../adr/container0-model-allowlist.md)).

## Regola: non aggiungere parametri espliciti al costruttore

NON aggiungere parametri come `container0`, `slug0`, `container1` al costruttore del `Page` component.

Mettere tutti i dati di contesto dentro `$data`. Il componente li trasporta in modo opaco.

Questo garantisce estensibilita' senza toccare il componente per ogni nuovo tipo di pagina.

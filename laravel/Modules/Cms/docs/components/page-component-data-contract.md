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

## Regola: non aggiungere parametri espliciti al costruttore

NON aggiungere parametri come `container0`, `slug0`, `container1` al costruttore del `Page` component.

Mettere tutti i dati di contesto dentro `$data`. Il componente li trasporta in modo opaco.

Questo garantisce estensibilita' senza toccare il componente per ogni nuovo tipo di pagina.

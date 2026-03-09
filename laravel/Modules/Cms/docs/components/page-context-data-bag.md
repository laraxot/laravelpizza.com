# Page Context Data Bag

## Sintesi

`Modules\Cms\View\Components\Page` non deve conoscere una lista chiusa di parametri come `container0` e `slug0`.

Il contesto dinamico della route vive interamente dentro `array $data`.

## Motivazione

- DRY: un solo canale per il contesto, senza duplicazione tra props dedicate e data bag.
- KISS: il componente `Page` carica i blocchi e renderizza; non risolve il significato dei segmenti URL.
- Riutilizzo: domani possono esistere `container1`, `slug1`, `container2`, `slug2` senza cambiare la signature del costruttore.

## Pattern corretto

```blade
<x-page
    side="content"
    :slug="$pageSlug"
    :data="[
        'container0' => $container0,
        'slug0' => $slug0,
        'container1' => $container1 ?? '',
        'slug1' => $slug1 ?? '',
    ]"
/>
```

## Contratto del componente

- `Page::__construct()` riceve `side`, `slug`, `type`, `data`.
- `render()` passa sempre:
  - i parametri base del componente (`blocks`, `side`, `slug`, `data`)
  - `...$data`, cosi' la Blade del componente e i block include possono leggere anche chiavi contestuali arbitrarie.
- I nomi core del componente restano autoritativi: `blocks`, `side`, `slug`, `data`.

## Anti-pattern

```blade
<x-page
    side="content"
    :slug="$pageSlug"
    :container0="$container0"
    :slug0="$slug0"
/>
```

Questo pattern non scala e reintroduce accoppiamento del componente con una profondita' specifica della route.

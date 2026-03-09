# Theme Rule: Page Context Goes Through `$data`

Nel tema, quando una route Folio o un block delega a `<x-page>`, il contesto dinamico va passato solo tramite `:data`.

## Esempio corretto

```blade
<x-page
    side="content"
    :slug="$this->pageSlug"
    :data="$this->data"
/>
```

Con `mount()` o nel blocco PHP del caller:

```php
$this->data = [
    'container0' => $this->container0,
    'slug0' => $this->slug0,
    'container1' => $this->container1 ?? '',
    'slug1' => $this->slug1 ?? '',
];
```

## Evitare

```blade
<x-page
    side="content"
    :slug="$this->pageSlug"
    :container0="$this->container0"
    :slug0="$this->slug0"
/>
```

Il tema non deve imporre al componente `Page` una struttura URL rigida; il componente resta agnostico e il routing prepara il data bag.

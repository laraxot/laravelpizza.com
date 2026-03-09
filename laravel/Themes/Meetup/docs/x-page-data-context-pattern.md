# Meetup Theme: x-page Data Context Pattern

## Regola

Quando una Folio page del tema invoca `<x-page>`, il contesto route va passato nel payload `data`, non in props rigide dedicate.

## Esempio

Corretto:

```blade
<x-page
    side="content"
    :slug="$pageSlug"
    :data="[
        'container0' => $container0,
        'slug0' => $slug0,
        'container1' => $container1 ?? null,
        'slug1' => $slug1 ?? null,
    ]"
/>
```

Da evitare:

```blade
<x-page :container0="$container0" :slug0="$slug0" />
```

## Motivo

- evita coupling tra tema e implementazione interna del componente CMS
- scala a segmenti route aggiuntivi senza cambiare il costruttore di `Page`
- mantiene DRY/KISS nel flusso Folio -> x-page -> block include

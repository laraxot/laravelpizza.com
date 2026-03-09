# Undefined `$pageSlug` in `[container0]/[slug0]/index.blade.php`

## Sintomo

Errore runtime:

- `Undefined variable $pageSlug`
- route: `container0.view`
- URL tipico: `/it/events/{slug}`

## Root cause

Il file Folio del dettaglio evento teneva uno stato derivato inutile:

- `pageSlug`
- `data`
- `mount()`

e poi usava quel valore fuori da un blocco `@volt`, creando mismatch tra scope Blade e stato Volt.

## Fix applicato

Soluzione DRY + KISS:

- rimosso `mount()`
- rimossi `pageSlug` e `data`
- usato `@volt('container0.view')`
- derivato lo slug CMS inline da `container0`

```blade
<x-page
    side="content"
    :slug="$this->container0.'.view'"
    :data="[
        'container0' => $this->container0,
        'slug0' => $this->slug0,
    ]"
/>
```

## Perché è migliore

- elimina stato duplicato
- evita variabili Blade fantasma
- lascia `container0` e `slug0` come source of truth
- continua a passare il contesto corretto al block `events.detail`

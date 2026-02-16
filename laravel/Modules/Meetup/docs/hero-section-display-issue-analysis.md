# Analisi Problema Visualizzazione Hero Section

## Data
[DATE]

## Problema Identificato

La hero section non viene visualizzata correttamente. Confrontando l'immagine attuale (Image #1) con quella desiderata (Image #2) e con la versione HTML statica, sono state identificate le seguenti differenze:

### Differenze Principali

1. **Titolo non visualizzato correttamente**:
   - **Atteso**: "Laravel Developers." (bianco) + "Pizza. Community." (rosso) su due righe
   - **Attuale**: Il titolo potrebbe non essere visualizzato o formattato male

2. **Struttura dati non allineata**:
   - Il componente hero usa `@props(['data'])` e accede a `$data['subtitle']`, `$data['description']`, etc.
   - Ma `page-content.blade.php` fa `@include($block->view, $block->data)`, che passa le chiavi dell'array come variabili separate, non come array `$data`

3. **Titolo nel JSON non utilizzato**:
   - Nel JSON abbiamo `"title": "Laravel Developers. Pizza. Community."` ma il componente hero non lo usa
   - Il componente usa solo `$data['subtitle']` per il testo principale

## Analisi Tecnica

### Come Funziona Attualmente

1. **`Page.php`** crea `BlockData` objects con `$block->data` (array)
2. **`page-content.blade.php`** fa `@include($block->view, $block->data)`
3. **Laravel Blade** quando fa `@include($view, $array)`, passa le chiavi dell'array come variabili separate
4. **Componente hero** usa `@props(['data'])` che si aspetta un array `$data`, ma riceve variabili separate

### Struttura JSON (home.json)

```json
{
  "type": "hero",
  "slug": "hero-section",
  "data": {
    "view": "pub_theme::components.blocks.hero.main",
    "title": "Laravel Developers. Pizza. Community.",
    "subtitle": "Join fellow Laravel, Filament, and Livewire enthusiasts for pizza meetups.",
    "description": "Share knowledge, build connections, and enjoy great food together.",
    "cta_primary": { ... },
    "cta_secondary": { ... }
  }
}
```

### Struttura HTML Statica (index.html)

```html
<h1 class="text-5xl md:text-7xl font-bold mb-4">
    <span class="text-white">Laravel Developers.</span><br>
    <span class="text-red-500">Pizza. Community.</span>
</h1>
<p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-3xl mx-auto">
    Join fellow Laravel, Filament, and Livewire enthusiasts for pizza meetups.
    <br class="hidden md:block">
    Share knowledge, build connections, and enjoy great food together.
</p>
```

## Soluzione

### Opzione 1: Modificare il Componente Hero (CONSIGLIATA)

Cambiare il componente hero per accettare variabili separate invece di un array `$data`:

```blade
@props([
    'title' => null,
    'subtitle' => null,
    'description' => null,
    'cta_primary' => null,
    'cta_secondary' => null,
    'background_image' => null
])
```

### Opzione 2: Modificare page-content.blade.php

Cambiare `@include($block->view, $block->data)` in `@include($block->view, ['data' => $block->data])` per passare l'array come variabile `$data`.

**Problema**: Questo richiederebbe modifiche al sistema CMS che potrebbero avere effetti collaterali.

## Implementazione Scelta

**Opzione 1** - Modificare il componente hero per accettare variabili separate, mantenendo compatibilità con `$data` se presente.

## Soluzione Implementata

### Modifiche al Componente Hero

Il componente `hero/main.blade.php` è stato modificato per:

1. **Accettare entrambi i formati** (variabili separate o array `$data`):
   ```blade
   @props([
       'data' => [],
       'title' => null,
       'subtitle' => null,
       'description' => null,
       'cta_primary' => null,
       'cta_secondary' => null,
       'background_image' => null,
   ])
   ```

2. **Parsare il titolo** in due parti:
   - "Laravel Developers." (bianco)
   - "Pizza. Community." (rosso)

3. **Gestire CTA come array o variabili separate**:
   - Supporta sia `$cta_primary` come array che come variabile separata
   - Estrae `url` e `label` correttamente

### Codice Implementato

```blade
@php
    // Supporto per entrambi i formati: variabili separate o array $data
    $title = $title ?? ($data['title'] ?? null);
    $subtitle = $subtitle ?? ($data['subtitle'] ?? '...');
    // ... altri campi

    // Parse del titolo: "Laravel Developers. Pizza. Community." → due parti
    if (str_contains($title, 'Pizza.')) {
        $parts = explode('Pizza.', $title, 2);
        $titleParts['first'] = trim($parts[0] ?? 'Laravel Developers.');
        $titleParts['second'] = 'Pizza. ' . trim($parts[1] ?? 'Community.');
    }
@endphp
```

## Risultato Atteso

Dopo l'implementazione, la hero section dovrebbe visualizzare:

1. ✅ Icona pizza rossa centrata
2. ✅ Titolo "Laravel Developers." (bianco) + "Pizza. Community." (rosso) su due righe
3. ✅ Sottotitolo e descrizione formattati correttamente
4. ✅ CTA buttons con icone e stili corretti

## Checklist

- [x] Identificato problema (titolo non visualizzato, struttura dati non allineata)
- [x] Analizzato flusso dati (Page → BlockData → page-content → hero component)
- [x] Confrontato con HTML statico
- [x] Documentato differenze
- [x] Implementare correzione (modificare componente hero)
- [x] Cache view pulita
- [ ] Testare visualizzazione nel browser
- [ ] Verificare che tutti i dati vengano visualizzati correttamente

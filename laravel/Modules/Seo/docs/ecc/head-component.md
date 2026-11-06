---
title: "Seo Head component — ECC documentazione"
type: reference
module: Seo
status: superseded
created: 2026-10-30
updated: 2026-10-30
tags: [ecc, seo, head, component, blade, meta-tags]
related:
  - ../../../../../docs/stories/seo-head-maximum-schema-org-hreflang.story.md
  - ../../../Cms/docs/seo-head-architecture.md
---

# Seo Head component — ECC documentazione

> **Superseded.** Questo documento descrive una proposta storica di un
> componente `Head` appartenente a Seo. Nel contratto attuale Seo mantiene
> politica e dati SEO, mentre la composizione del document head appartiene a
> Cms. Consultare la [story canonica](../../../../../docs/stories/seo-head-maximum-schema-org-hreflang.story.md)
> e l'[architettura Cms](../../../Cms/docs/seo-head-architecture.md) prima di
> modificare la documentazione o implementare nuove integrazioni.

Questo documento descrive il componente Blade `Head` del modulo `Seo`, utilizzato per generare l'intera sezione `<head>` con meta tag SEO, dati strutturati schema.org, dark mode, Alpine.js e prevenzione FOUC.

## Panoramica

Il componente `Seo\View\Components\Head` fornisce una sezione `<head>` completa e ottimizzata per SEO, riutilizzabile su tutte le pagine dell'applicazione.

### File coinvolti

| File | Percorso | Descrizione |
|------|----------|-------------|
| Componente | `Modules\Seo\View\Components\Head.php` | Classe PHP del componente Blade |
| View | `resources/views/components/head.blade.php` | Template Blade del componente |
| Metadati | `app/View/Components/_components.json` | Descrizione e proprietà del componente |
| Story BMAD | `docs/stories/seo-head-component.story.md` | Documentazione di implementazione |

## Proprietà del componente

| Proprietà | Tipo | Obbligatoria | Descrizione |
|-----------|------|--------------|-------------|
| `$title` | `string` | No | Titolo della pagina per browser tab e SEO |
| `$description` | `string` | No | Meta description per i motori di ricerca |
| `$url` | `string` | No | URL canonico della pagina |
| `$image` | `string` | No | Immagine Open Graph e Twitter Card |
| `$siteName` | `string` | No | Nome del sito per Open Graph |
| `$locale` | `string` | No | Locale della pagina per SEO multilingue |
| `$schema` | `array` | No | Dati strutturati schema.org aggiuntivi |
| `$isHomepage` | `boolean` | No | Indica se è la homepage |

## Contenuto generato

Il componente genera il seguente blocco HTML:

```html
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index, follow">
  <meta name="theme-color" content="#0f2b46">
  
  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="...">
  <meta property="og:description" content="...">
  <meta property="og:url" content="...">
  <meta property="og:image" content="...">
  <meta property="og:site_name" content="...">
  <meta property="og:locale" content="...">
  
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="...">
  <meta name="twitter:description" content="...">
  <meta name="twitter:image" content="...">
  
  <!-- Schema.org JSON-LD -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      ...
    }
  </script>
  
  <!-- Layout SEO links -->
  @include('layouts.seo-links')
  
  <!-- Laravel Head -->
  @headMeta
  @headLink
  @headScript
  @headStyle
  
  <!-- Dark mode inline script -->
  <script>...</script>
  
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <!-- Critical CSS -->
  <style>[x-cloak] { display: none !important; }</style>
  
  <!-- Filament & Livewire -->
  @livewireStyles
  @filamentStyles
  
  <!-- Vite CSS -->
  @vite('resources/css/app.css')
</head>
```

## Uso nel Blade

```blade
<x-seo:head
    :title="Page Title"
    :description="Page description for SEO"
    :url="https://example.com/page"
    :image="https://example.com/image.jpg"
    :siteName="My Site"
    :locale="it"
    :isHomepage="false"
>
    {{ $slot }}
</x-seo:head>
```

## Integrazione con package

- **Laravel Head**: il componente usa `Laravel\Head\Facades\Head` per gestire meta tag dinamici
- **Alpine.js**: caricato via CDN se non già presente
- **Filament**: `@filamentStyles` per gli stili dell'admin panel
- **Livewire**: `@livewireStyles` per gli stili dei componenti Livewire
- **Vite**: `@vite('resources/css/app.css')` per il bundle CSS

## Dark mode

Lo script inline persiste la preferenza utente in `localStorage` sotto la chiave `theme` e rispetta `prefers-color-scheme` di sistema. La classe `dark` viene aggiunta a `<html>` immediatamente per prevenire FOUC.

## Schema.org

Per la homepage, viene generato automaticamente un blocco JSON-LD di tipo `WebSite`. Altri tipi di schema possono essere passati tramite la proprietà `$schema`.

## Test e verifica

Per verificare il componente:

1. Renderizzare `<x-seo:head>` e controllare che tutte le meta tag siano presenti
2. Validare il JSON-LD con il Rich Results Test di Google
3. Verificare che il dark mode persista tra i ricaricamenti di pagina
4. Verificare l'integrazione con Laravel Head senza conflitti

## Conformità con le regole del progetto

- Nessun controller FO usato per questa funzionalità
- Nessuna estensione diretta di classi Filament
- Tutti i nomi in inglese
- Nessuna variabile `mixed`
- Nessuna riga commentata inutile
- `declare(strict_types=1);` nella classe PHP

## Storia delle modifiche

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-10-30 | AI Assistant | Creazione iniziale del componente e documentazione |

## Riferimenti correlati

- Story BMAD: `docs/stories/seo-head-component.story.md`
- Componente Cms Head: `laravel/Modules/Cms/app/View/Components/Head.php`
- Story chiusa (`superseded`, premessa errata: questo sito non usa Fixcity): `docs/stories/fixcity-segnalazione-missing-module.story.md`

---
type: overview
module: Seo
sources:
  - ../../../README.md
  - ../../../configuration.md
  - ../../../sitemap.md
  - ../../../structure.md
confidence: high
updated: 2026-04-15
---

# Seo Module — Overview

> **Ruolo**: SEO toolkit completo — meta tag, sitemap XML, OpenGraph, Twitter Cards, Schema.org JSON-LD, AI content analysis.

## Responsabilità del Modulo

Il modulo Seo gestisce tutta l'ottimizzazione per i motori di ricerca:

- Meta tag dinamici (title, description, keywords, canonical, robots)
- Sitemap XML automatica con multi-sitemap e ping motori di ricerca
- OpenGraph + Twitter Cards per social media preview
- Schema.org JSON-LD (LocalBusiness, Article, Product, Event)
- SEO analytics e real-time content analysis
- AI-powered content quality scoring (via OpenAI — in progress)
- Pannello admin Filament per gestione centralizzata

## API Core

```php
// Meta tags
SEO::setTitle('Titolo Pagina');
SEO::setDescription('Descrizione SEO ottimizzata');
SEO::setKeywords(['keyword1', 'keyword2']);
SEO::setCanonical(url()->current());

// Open Graph
SEO::setOpenGraph([
    'title'       => 'Titolo Social',
    'description' => 'Descrizione per social',
    'image'       => asset('images/og-image.jpg'),
]);

// Schema.org JSON-LD
SEO::addStructuredData([
    '@context'      => 'https://schema.org',
    '@type'         => 'Article',
    'headline'      => 'Titolo Articolo',
    'datePublished' => '2025-01-01',
    'author'        => ['@type' => 'Person', 'name' => 'Nome Autore'],
]);
```

## Sitemap

```bash
# Generazione sitemap via artisan
php artisan seo:sitemap:generate
```

```php
// Sitemap dinamica
Sitemap::addUrl('/pagina', [
    'lastmod'    => now(),
    'changefreq' => 'weekly',
    'priority'   => 0.8,
]);
```

## Modelli Core

| Modello | Scopo |
|---------|-------|
| `Metatag` | Record meta tag per URL/modello |
| `Redirect` | Gestione redirect 301/302 |
| `Sitemap` | Entità sitemap con URL e metadati |

## Feature Map

| Feature | Status |
|---------|--------|
| Meta Tag Management | ✅ Completato |
| Sitemap Generation | ✅ Completato |
| OpenGraph & Twitter Cards | ✅ Completato |
| Schema.org JSON-LD | ✅ Completato |
| SEO Analytics | ✅ Completato |
| AI-Powered Optimization | 🔄 In progress |
| Keyword Tracking | 📋 Planned |
| Competitor Analysis | 📋 Planned |
| PDF SEO Reports | 📋 Planned |

## Integrazione Filament

- Pannello admin: `/admin/metatags`, `/admin/redirects`
- Gestione manuale meta tag per ogni pagina/contenuto
- `SeoServiceProvider` + `AdminPanelProvider`

## Dipendenze Cross-Module

| Modulo | Uso |
|--------|-----|
| `Xot` | `XotBaseServiceProvider`, `XotBaseModel` |
| `User` | Autenticazione pannello admin |
| `UI` | Componenti interfaccia |
| `Cms` | Meta tag per pagine CMS |

## Architettura

- Namespace: `Modules\Seo`
- PHPStan Level 9 (in progressione verso L10)
- Multi-lingua: IT/EN
- Segue pattern Laraxot (DRY, XotBase, no `->label()`)

## Cross-References

- [[../../../../../../laravel/Modules/Cms/docs/wiki/overviews/cms-module|Cms Module]] — pagine con meta tag
- [[../../../../../../laravel/Modules/Xot/docs/wiki/overviews/xot-module|Xot Module]] — XotBase foundation
- [[../../../../../../laravel/Modules/Blog/docs/wiki/index|Blog Module]] — articoli con SEO

## Raw Sources Prioritari

- `README.md` — feature list, API examples, stato qualità
- `configuration.md` — struttura, dipendenze, namespace
- `sitemap.md` — generazione sitemap, artisan commands
- `structure.md` — directory structure
- `filament.md` — integrazione pannello admin

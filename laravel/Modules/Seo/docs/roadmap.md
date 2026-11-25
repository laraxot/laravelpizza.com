---
title: "Seo: stato e roadmap"
type: roadmap
status: active
module: Seo
tags: [seo, roadmap, schema-org, json-ld]
qmd: "seo roadmap stato implementato pianificato schema.org json-ld analytics fuori ambito obiettivi"
related:
  - ./architecture.md
  - ./configuration.md
---

# Stato e roadmap

Verificato sul codice del modulo. Solo cio' che e' elencato come "Fatto" esiste in `app/`.

## Obiettivi e fuori ambito

- Obiettivo: contenuti pubblici scopribili e indicizzati in modo coerente (metadati, segnali leggibili dalle macchine,
  canonicalizzazione), senza esporre le aree private.
- Fuori ambito: sostituire il CMS o il rendering dei temi; conoscere i modelli dei moduli consumatori (la sitemap si
  alimenta per contratto, vedi [architecture.md](./architecture.md)).

## Fatto

- `sitemap.xml` multi-lingua con hreflang e `<lastmod>`, alimentata dalle pagine CMS e dai moduli che si registrano col tag
  `SitemapPathsContract::TAG`.
- `robots.txt` dinamico con aree riservate chiuse in ogni lingua e `Sitemap:` assoluta; comando `seo:robots`.
- Redirect canonico 301 (lingua minuscola, niente doppio slash, alias di pagina configurabili per tenant).
- IndexNow: file di verifica della chiave e invio delle URL nuove (`seo:indexnow`).
- Metatag per richiesta (facade `Metatag`), componente `seo::components.head` con Open Graph, Twitter Card e JSON-LD
  `WebSite`.
- Condivisione social (Action, componente Blade, widget Filament).
- PHPStan livello max a 0 errori, suite Pest del modulo.

## Pianificato, non implementato

| Tema | Note |
|------|------|
| JSON-LD per le pagine di dettaglio (Event, EventSeries, Place, Organization, Person, Breadcrumb, FAQ) | Seo assembla il grafo e lo inietta nella pagina; i dati vengono dai moduli proprietari (eventi, luoghi) tramite un contratto/DTO, non da Seo. Vincoli di modellazione: con `eventSchedule` non emettere anche `startDate`/`endDate` sullo stesso `Event`; usare `attendee`, non `attendees` (superseded). Validare con il Rich Results Test di Google e con validator.schema.org. |
| Analytics e monitoraggio dello stato SEO delle pagine | integrazione con strumenti esterni; nessun codice oggi |
| Suggerimenti di ottimizzazione e punteggio SEO | idea futura (anche assistita da AI); nessun codice oggi |
| Core Web Vitals, report periodici, analisi dei concorrenti | idee future, nessun codice oggi |
| Policy e test sui formati dei metatag, caching dei metatag frequenti | lacune note dell'adapter |
| Sitemap index per volumi molto grandi | la sitemap attuale e' un unico file |

Le idee pianificate non sono impegni: prima di iniziarne una va scritta la story nel modulo (`docs/stories/`).

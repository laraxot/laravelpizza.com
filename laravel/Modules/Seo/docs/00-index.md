---
title: "Seo: indice della documentazione"
type: index
status: active
module: Seo
tags: [seo, indice]
qmd: "seo indice documentazione mappa pagine adr contracts stories"
---

# Seo: indice della documentazione

Una riga per file. Il modulo presenta se stesso in [README.md](./README.md).

## Pagine di riferimento

- [README.md](./README.md): cosa fa il modulo, tabella delle funzioni, comandi di qualita'.
- [architecture.md](./architecture.md): confini del modulo, livelli di `app/`, regole di costruzione, redirect canonico.
- [metatag.md](./metatag.md): facade `Metatag`, adapter, stato per richiesta, `MetatagData` e `MetatagDataContract`.
- [social-share.md](./social-share.md): link di condivisione, componente Blade, widget, traduzioni.
- [configuration.md](./configuration.md): `SeoConfigData`, alias di pagina, chiave IndexNow, rotte, comandi artisan.
- [testing-and-quality.md](./testing-and-quality.md): gate, mappa dei test, cause radice chiuse per PHPStan livello max.
- [roadmap.md](./roadmap.md): cosa esiste oggi e cosa e' solo pianificato (JSON-LD di dettaglio, analytics).
- [references.md](./references.md): pacchetti e letture esterne consultati.

## Decisioni (`adr/`)

- [adr/README.md](./adr/README.md): indice delle decisioni del modulo.
- [adr/search-engine-presence.md](./adr/search-engine-presence.md): presenza nei motori, IndexNow, nessun file "per l'AI", sameAs.
- [adr/sitemap-built-in-seo-fed-by-tagged-sources.md](./adr/sitemap-built-in-seo-fed-by-tagged-sources.md): la sitemap la costruisce solo Seo, alimentata da sorgenti col tag `seo.sitemap.paths`.
- [adr/robots-disallow-subset-of-head-noindex.md](./adr/robots-disallow-subset-of-head-noindex.md): `Disallow` di `robots.txt` sottoinsieme del `noindex` del `<head>`.

## Contratti (`contracts/`)

- [contracts/README.md](./contracts/README.md): cosa promettono le Action che parlano con l'esterno.
- [contracts/submit-index-now-action.md](./contracts/submit-index-now-action.md): invio delle URL a IndexNow.
- [contracts/serve-index-now-key-action.md](./contracts/serve-index-now-key-action.md): file pubblico della chiave `/{chiave}.txt`.

## Story (`stories/`)

- [stories/audit-qualita.story.md](./stories/audit-qualita.story.md): audit di qualita' del modulo e lavoro in corso.
- [stories/phpstan-cleanup-seo.story.md](./stories/phpstan-cleanup-seo.story.md): pulizia PHPStan, sintesi.
- [stories/phpstan-cleanup-seo.dev.md](./stories/phpstan-cleanup-seo.dev.md): note di sviluppo della pulizia PHPStan.
- [stories/phpstan-seo-fix.md](./stories/phpstan-seo-fix.md): correzioni PHPStan applicate al modulo.
- [stories/services-to-actions-seo.story.md](./stories/services-to-actions-seo.story.md): conversione di `MetatagService` in Adapter e Action.
- [stories/fo-audit-seo-path-aliases-fixcity.story.md](./stories/fo-audit-seo-path-aliases-fixcity.story.md): audit del front office e alias di pagina.
- [stories/docs-index-audit.story.md](./stories/docs-index-audit.story.md): audit dell'indice della documentazione.
- [stories/docs-organization-pilot.story.md](./stories/docs-organization-pilot.story.md): pilota di riorganizzazione dei docs.

---
title: "BMAD Architecture — Completamento sitemap (ticket + blog + Folio generico)"
type: architecture
status: active
tags: [seo, sitemap, bmad, dcp-273, dcp-166]
related: [dcp-166-ricerca-interna-sitemap-canonical-e-hreflang.story.md, dcp-273-sitemap-con-le-pagine-di-dettaglio-di-blog-ed-eventi.story.md]
created: 2026-10-26
updated: 2026-10-26
qmd: "architettura seo"
---

# Architettura

## Problema
Se `/it/tickets/35` non appare in `sitemap.xml`, il motivo è **dato o runtime**, non architettura. L'architettura è corretta:
- `BuildSitemapAction` legge `SitemapPathsContract::TAG` (line 87-91)
- `FixcityServiceProvider` registra `ListPublicTicketPathsAction` (line 32)
- `BlogServiceProvider` registra `ListPublishedArticlePathsAction` (line 32)
- `ThemeArticleQueries` e `BuildPublicTicketsQueryAction` forniscono le stesse query delle pagine pubbliche

## Perché il routing Folio è nel tema (non nel modulo)

`pages/[container0]/[slug0]/index.blade.php` è nel tema Sixteen perché serve **tutti i contenuti** (blog, events, tickets, profile, services...). Il modulo Fixcity non possiede una blade propria; il suo modello (`Ticket`) viene risolto dinamicamente da `ResolvePageAction` tramite `container0_model_map`. Il tema è il proprietario della pagina shell.

## Decisioni architetturali documentate

- `architecture-sitemap-ownership.md`: `BuildSitemapAction` appartiene a Seo, non Fixcity
- `sitemap-ticket-folio-routing.md` (Fixcity docs): il dettaglio ticket usa il generico Folio
- `sitemap-blog-folio-routing.md` (Blog docs): il dettaglio blog usa il generico Folio
- `folio-generic-blade-ownership.md` (Theme docs): il generico `container0/slug0` è proprietà tema

## Milestones

1. Verifica data: `Ticket::find(35)` pubblico? `location` non null?
2. Verifica tag: `app()->tagged('seo.sitemap.paths')` include Fixcity/Blog?
3. Verifica test: `SeoLinksTest.php` passa?
4. Documenta: tutti i docs sopra creati

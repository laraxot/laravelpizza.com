---
title: "Contratto di copertura sitemap: tutti i tipi di URL pubblici"
type: concept
status: active
tags: [seo, sitemap, dcp-273, contract]
created: 2026-10-26
updated: 2026-10-26
qmd: "copertura sitemap: cosa deve essere elencato seo"
---

# Copertura sitemap: cosa deve essere elencato

## Regola (DCP-273)

Un percorso è in `sitemap.xml` **se e solo se** la sua pagina risponde 200 con quel contenuto per un anonimo. La sitemap non conosce i modelli; i proprietari dei dati dichiarano i propri URL implementando `SitemapPathsContract` e taggando la classe.

## Fonti attive (2026-10-26)

| Tipo | URL | Fonte | Modulo |
|---|---|---|---|
| Pagine CMS | `/{lang}/{slug}` | `Page::query()` | Cms |
| Blog (post) | `/{lang}/blog/{slug}` | `ThemeArticleQueries::publishedPostSlugs()` | Blog |
| Eventi | `/{lang}/events/{slug}` | `ThemeArticleQueries::publishedEventSlugs()` | Blog |
| Segnalazioni | `/{lang}/tickets/{id}` | `BuildPublicTicketsQueryAction` (public only) | Fixcity |

## Esclusioni note

- `tests.*` — pagine di prova
- `auth.*` — accesso/registrazione (guest-only)
- `*.view` — modelli generici (rispondono 200 ma senza contenuto)
- `tickets.confirmation` — usa `?code`, dato personale
- `segnalazioni.index` — alias 301
- `segnalazione-dettaglio` — schema
- Pagine con middleware `auth`

## Per aggiungere una nuova fonte

1. Crea un'azione che implementa `SitemapPathsContract::execute()` → `list<string>` percorsi senza lingua
2. Usa la **stessa query** della rotta di dettaglio (non una copia)
3. Registra nel provider del modulo: `$this->app->tag([Azione::class], SitemapPathsContract::TAG)`
4. Verifica con test Pest: URL in sitemap → 200; URL fuori sitemap → 404 o non pubblico

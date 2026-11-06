---
id: cms-json-content-slug-uniqueness
title: "Contenuti JSON: unicita' dello slug e nome canonico"
type: guide
status: active
created: 2026-10-13
qmd: "cms json content collision slug duplicato sushi page tests tenant override nome canonico"
updated: 2026-10-20
tags: [docs, cms]
---

# Contenuti JSON: unicita' dello slug e nome canonico

`Modules\Cms\Models\Page` (e `Section`) leggono i contenuti da file JSON tramite Sushi. Lo slug identifica il record.

## Regole

La cartella è il contenitore dell'URL. Il campo `slug` nel file è solo l'ultimo pezzo. `SushiToJsons` (`File::allFiles`, non solo i json in cima) prefissa la cartella: `pages/blog/view.json` con `"slug": "view"` diventa `blog.view`. Due file che dopo il prefisso hanno lo stesso slug danno `CMS content collision` (HTTP 500).

| File | `slug` nel JSON | Slug letto |
|---|---|---|
| `blog/index.json` | `index` | `blog.index` |
| `blog/view.json` | `view` | `blog.view` |
| `services/view.json` | `view` | `services.view` |
| `area-personale/pratiche.json` | `pratiche` | `area-personale.pratiche` |
| `home.json` | `home` | `home` |

`view.json` è la scheda di un record (`/blog/{slug}`, `/events/{slug}`, `/services/{slug}`). Le voci fisse (`pratiche`, `login`, `create`) sono file col nome della voce, non un `view`. Una pagina sola (`home`, `privacy.index`) resta in radice: una cartella per un solo file non aggiunge un contenitore.

Il runtime è `laravel/config/<tenant>/database/content/pages/`. Una copia sotto `Modules/<Modulo>/config/` non è la pagina servita.

Pagine di prova: stanno in `pages/tests/`, lo slug nel file è l'ultimo pezzo (`servizio-dettaglio` → `tests.servizio-dettaglio`). L'indice è `tests.index`.

## Incidenti del 2026-10-13
`homepage.json` + `tests.homepage.json` e `risultati-ricerca.json` + `tests.risultati-ricerca.json` nella stessa cartella: due pagine in 500.
Risolti unificando sul nome canonico. Guardia automatica prevista in `laravel/Themes/Sixteen/docs/bmad/stories/dcp-09-json-content-integrity-guard.story.md`.
Contratto del tema: `laravel/Themes/Sixteen/docs/layout-runtime-contract.md`.

## Sezioni con template alternativo (`tpl`)
`<x-section slug="header" tpl="v1" />` cerca la vista `pub_theme::components.sections.<slug>.<tpl>` (default `v1`; il footer canonico del sito usa `v1`). Una sezione nuova = un file `sections/<slug>.json`
con `blocks.it/en[].data` e un template `sections/<slug>/<tpl>.blade.php` che unisce i `data` dei blocchi come fanno gli altri template. Usato da `layouts/design-comuni` del tema Sixteen (2026-10-13).

---
id: cms-json-content-slug-uniqueness
title: "Contenuti JSON: unicita' dello slug e nome canonico"
type: guide
status: active
created: 2026-10-13
qmd: "cms json content collision slug duplicato sushi page tests tenant override nome canonico"
---

# Contenuti JSON: unicita' dello slug e nome canonico

`Modules\Cms\Models\Page` (e `Section`) leggono i contenuti da file JSON tramite Sushi. Lo slug identifica il record.

## Regole
1. **Una pagina = un file per slug nella stessa cartella.** Due file con lo stesso `slug` nella stessa cartella producono
   `CMS content collision: matched 2 records for slug [...]` (HTTP 500).
2. **Tenant su modulo e' un override voluto**: lo stesso slug in `laravel/config/local/<tenant>/database/content/pages/` e in
   `laravel/Modules/<Modulo>/config/database/content/pages/` non e' un conflitto.
3. **Nome canonico delle pagine di test:** `tests.<slug>.json` con `"slug": "tests.<slug>"`. Mai `homepage.json` con slug `tests.homepage`.
4. Slug vuoto della pagina `/tests`: `tests.index`.

## Incidenti del 2026-10-13
`homepage.json` + `tests.homepage.json` e `risultati-ricerca.json` + `tests.risultati-ricerca.json` nella stessa cartella: due pagine in 500.
Risolti unificando sul nome canonico. Guardia automatica prevista in `laravel/Themes/Sixteen/docs/bmad/stories/2026-10-13-dcp-09-json-content-integrity-guard.story.md`.
Contratto del tema: `laravel/Themes/Sixteen/docs/layout-runtime-contract.md`.

## Sezioni con template alternativo (`tpl`)
`<x-section slug="header" tpl="design-comuni" />` cerca la vista `pub_theme::components.sections.<slug>.<tpl>` (default `v1`; il footer del sito usa `full`). Una sezione nuova = un file `sections/<slug>.json`
con `blocks.it/en[].data` e un template `sections/<slug>/<tpl>.blade.php` che unisce i `data` dei blocchi come fanno gli altri template. Usato da `layouts/design-comuni` del tema Sixteen (2026-10-13).

---
title: "page directory structure"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-20
qmd: "page directory structure"
issues: []
discussions: []
status: draft
---

# CMS Page Directory Structure Contract

## Scopo

Il modulo CMS deve considerare il tema attivo come un runtime generico basato su Folio, non come una collezione di directory semantiche hardcoded.

## Contratto del tema pubblico

Nel tema pubblico attivo la cartella `resources/views/pages` deve esporre solo questi entrypoint canonici:

```text
resources/views/pages/
├── [container0]/
│   └── [slug0]/
├── auth/
└── tests/
```

## Cosa non fare

Non modellare il routing del frontoffice creando directory dedicate come:

- `pages/administration`
- `pages/news`
- `pages/profile`
- `pages/services`
- `pages/turismo`

Questi alberi rompono DRY, aumentano il debito di routing e duplicano la responsabilità del CMS.

## JSON del tenant, non le viste Folio

Le cartelle semantiche stanno nei JSON (`pages/blog/`, `pages/services/`, `pages/area-personale/`), non in `resources/views/pages/`. Il tema ha un solo `[container0]/[slug0]`. Regola dello slug: [json-content-slug-uniqueness.md](./json-content-slug-uniqueness.md).

## Cosa fare

- usare `tests/[slug].blade.php` per le pagine di test replicate da JSON
- usare `tests/index.blade.php` per la root `/tests`
- usare un solo `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
  per ogni dettaglio `/tests/{slug}`; non creare `tests/segnalazioni/[slug]`
  o altre directory semantiche per famiglia
- usare `[container0]/index.blade.php` e `[container0]/[slug0]/index.blade.php` per il frontoffice dinamico
- demandare il rendering contenuti a `<x-page side="content" :slug="$pageSlug" :data="$data" />`

## Perché

- il contenuto vive nei JSON CMS
- la risoluzione del tema è agnostica grazie a `pub_theme`
- il layout gestisce gli elementi globali
- il tema non deve rappresentare la tassonomia editoriale con cartelle dedicate

## Collegamenti

- [README.md](./README.md)
- [cms-driven-pages-system.md](./cms-driven-pages-system.md)
- [folio_routing_system.md](./folio_routing_system.md)
- [../../Themes/Sixteen/docs/page-directory-structure.md](../../../Themes/Sixteen/docs/page-directory-structure.md)

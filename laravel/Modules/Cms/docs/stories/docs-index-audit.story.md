---
tags: [documentation]
qmd: "docs index audit.story"
issues: []
discussions: []
title: "CMS-docs: audit e indice della documentazione modulo Cms"
type: story
module: Cms
story_id: docs-index-audit
slug: docs-index-audit
status: done
created: 2026-09-03
updated: 2026-09-03
---

# CMS-docs — Audit indice documentazione

## Cosa e' stato trovato

`Modules/Cms/docs/` contiene 1166 file `.md` (570 in radice, ~596 nelle sottocartelle). La radice e' fortemente inquinata da duplicati: 136 cluster di varianti dello stesso contenuto (differenze di case, `_` vs `-`, suffissi `-1`/`_1`/`-old`/`-old2`/`-renamed`, date nel nome, e alcuni nomi corrotti da un probabile bug di script di rinomina passato, es. `filament-resourcelines.md`, `iconesign.md`, `phpstanes.md`). `docs/index.md` e `docs/INDEX.md` erano stub placeholder auto-generati vuoti.

## Cosa e' stato fatto

Creato/aggiornato `docs/index.md` come indice di navigazione per argomento (Design Comuni, Homepage/blocchi, Filament, Folio/Volt, PHPStan/qualita, Testing, Prodotto/roadmap, UX, Governance, Architettura, ecc.), con sezione dedicata "Storico / da consolidare" che elenca tutti i 136 cluster di duplicati (366 file) senza cancellare o rinominare nulla, piu' una mappa delle sottocartelle di `docs/` con i relativi indici interni gia' esistenti (blocks, components, frontoffice, roadmap, sections, wiki, ecc.).

## Cosa resta da fare

Decisione con l'owner del modulo su consolidamento/cancellazione reale dei 136 cluster duplicati e delle cartelle-archivio (`archive/` 184 file, `raw/` 25, `root-md-files/` 31, `root-txt-files/` 6); indicizzazione di dettaglio delle sottocartelle senza indice interno se il volume cresce ulteriormente.

---
title: "docs index audit.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "docs index audit.story"
issues: []
discussions: []
scope: module:Geo
---

# Story: Audit e indice della documentazione Geo

## Status
Done

## Type
Docs-only (audit BMAD, nessuna modifica a file .md esistenti)

## Summary
- Analizzati i 1969 file `.md` sotto `Modules/Geo/docs/` (563 sciolti in root, 103 sottocartelle); rilevati 92 gruppi di duplicati esatti (98 file, hash identico) tramite confronto md5.
- Riscritto `docs/index.md`: indice per argomento (~27 categorie) di tutti i file distinti in root, tabella delle 103 sottocartelle con relativo punto d'ingresso, e sezione "Storico / da consolidare" per duplicati esatti, cartelle di scratch (`root-md-files/`, `_integration/`, `prompts/`) e aree di contenuto probabilmente non specifico di Geo (`roadmap/`, `claude/`, `it/`).
- Nessun file `.md` esistente rinominato, spostato o cancellato; corretti due link non risolvibili ereditati dalla versione precedente dell'indice (`FILAMENT_EXTENSION_RULES.md`, `leaflet_marker_map_input.md`).
- Consolidamento effettivo dei duplicati resta fuori scope: elencato in "Manutenzione futura" dentro `docs/index.md`.

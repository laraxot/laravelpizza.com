---
issues: []
discussions: []
title: "Conflict Resolution — Module Media"
module: "Media"
type: concept
tags: [conflict, resolution]
created: 2026-07-14
updated: 2026-11-24
qmd: "conflict resolution"
related:
  - "./webm.md"
---
# Conflict Resolution — Module Media

## Summary
- **Files resolved**: 9
- **Strategy**: Keep HEAD/local (ours) side
- **Root cause**: Nested stash-on-merge conflicts

## PHP Files
- app/Actions/SaveAttachmentsAction.php
- app/Filament/Clusters/Test/Pages/S3Test.php

## Documentation Files
- README.md
- docs/dry-kiss-analysis.md
- docs/module-analysis.md
- docs/nestedset-migration-best-practices.md
- docs/quality-analysis.md
- docs/testing.md

## Config Files
- composer.json

## Backlinks
- [Root conflict resolution report](../../../../docs/conflict-resolution-report.md)

## Marcatori di conflitto nel codice dopo il sync del 24/11/2026

`merge_remote_repo_2.sh` ha committato marcatori in tre Action del modulo. Storia: `stories/16.6.media-sync-marker-repair.story.md`.

| File | A cosa serve | Risoluzione |
|---|---|---|
| `app/Actions/Image/Merge.php` | Unisce piu' PNG (chart, conversioni) in un unico asset con Intervention Image v4 | solo docblock in conflitto: tenuti `@see` verso il contratto e `@contract` (richiesto da `ActionContractsAreCompleteTest`) |
| `app/Actions/Image/StripImageMetadataAction.php` | Riscrive JPEG/PNG senza EXIF/GPS/XMP | idem |
| `app/Actions/SaveAttachmentsAction.php` | Copia gli allegati nelle collezioni Media Library e salva i percorsi sul record | unite le due righe del docblock: descrizione (un lato) + `@see` (l'altro) + `@contract` |

Nessuna riga di logica e' stata scartata: il corpo delle tre classi coincide con il riferimento buono (commit root `6e32612c`).

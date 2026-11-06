---
title: "changelog case duplicate and merge conflict.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "changelog case duplicate and merge conflict.story"
issues: []
discussions: []
---

# Story: Lang: CHANGELOG.MD duplicato + conflitto di merge non risolto in CHANGELOG.md

## Status
Done.

## Contesto
Regola (`module-theme-root-hygiene.md` sez.5 / `module-theme-root-md-files-limit.md`):
un solo file canonico per basename in root, case-insensitive. Root di
`Modules/Lang` aveva sia `CHANGELOG.MD` (127 byte, stub template
`:package_name` mai compilato) sia `CHANGELOG.md` (7144 byte, changelog
semantico reale con voci fino a dev.15).

## Trovato durante l'audit
`CHANGELOG.md` conteneva marker di conflitto git **committati**, mai
risolti:
```
## [1.0.0-dev.15] ... (2026-08-25) ... phpstan: analyse Modules a zero errori
---
title: "changelog case duplicate and merge conflict.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "changelog case duplicate and merge conflict.story"
issues: []
discussions: []
## [1.0.0-dev.13] ... (2026-08-05) ... resolve merge conflicts...
```
Le due voci non sono duplicate (date e commit diversi, dev.15 successivo a
dev.13): risolto tenendo entrambe in ordine cronologico decrescente, come le
voci gia' presenti sotto (dev.12, dev.11, ...), invece di scartarne una.

## Azione
- Risolto il conflitto in `CHANGELOG.md` (entrambe le voci preservate).
- Rimosso `CHANGELOG.MD` (stub template, nessun contenuto reale, superato
  dal changelog vero).

## Verifica
```bash
grep -n '^<<<<<<<\|^=======\|^>>>>>>>' laravel/Modules/Lang/CHANGELOG.md
# atteso: nessun output
find laravel/Modules/Lang -maxdepth 1 -iname 'changelog.md' | wc -l
# atteso: 1
```
---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "continuazione domani"
issues: []
discussions: []
title: "Continuazione BMAD — Domani (export lazy + trigger map)"
type: module-fix
scope: Xot
epic: "5"
updated_at: "2026-09-23"
status: ready-for-dev
related:
  - ./5.247-tomorrow-pack-export-lazy-and-trigger-map.story.md
  - ./5.163-lazy-export-labelled-headings.story.md
  - ./5.175-trigger-map-export-ratings-xls.story.md
  - ./5.176-export-xls-formula-injection-sanitize.story.md
  - ./5.177-export-xls-headings-supersede.story.md
  - ./5.178-export-lazy-labels-dedup.story.md
  - ../../../../Rating/docs/bmad/stories/5.244-continuazione-domani-post-prompt-04-pack.story.md
---

# Xot — Continuazione Domani

**SSoT pack:** [`5.247-tomorrow-pack-export-lazy-and-trigger-map.story.md`](./5.247-tomorrow-pack-export-lazy-and-trigger-map.story.md)
**Pack cross-modulo:** Rating [`5.244`](../../../../Rating/docs/bmad/stories/5.244-continuazione-domani-post-prompt-04-pack.story.md)

## Stato (2026-09-23)

- `RatingData::getXlsFields` produce campi `path => label` (canon post-consolidamento)
- `CollectionExport` gestisce il formato misto; residuo: `ExportXlsLazyAction` (5.163)

## Domani (ordine)

1. **P0** `5.163` — lazy export rispetta `path => title` (o unifica `5.178`)
2. **P1** `5.175` — riga TRIGGER_MAP export ratings
3. **P2** `5.176` — sanitize formula injection; **P2** `5.177` — igiene supersede 5.161

## Non rifare

Export headings collection (done), wiring action generic (5.166 done).
`continuazione-perfezione-xot-domani.md` è del 2026-09-22, status done — storico.

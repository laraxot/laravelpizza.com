---
title: "Rating Module: Documentation Index"
type: guide
module: Rating
updated: 2026-09-22
qmd: rating documentation bmad index
status: draft
tags: [docs, rating, bmad]
---

# Rating Module: Index

## Lavoro attivo (BMAD)

→ **[bmad/README.md](README.md)**: Select «altro» + note (`''` / placeholder `null` / `selectIsOther`).

| Pack | Link |
|------|------|
| Architecture | [bmad/architecture/rating-select-altro-note.md](architecture/rating-select-altro-note.md) |
| Spec codice | [bmad/architecture/rating-select-altro-implementation-spec.md](architecture/rating-select-altro-implementation-spec.md) |
| Story 5.99 | [bmad/stories/5.99-select-altro-note-obbligatoria.story.md](stories/0045-select-altro-note-obbligatoria.story.md) |
| Story 5.141 D-8 | [bmad/stories/5.141-has-rating-values-filter-note.story.md](stories/0005-has-rating-values-filter-note.story.md) |
| PHPStan cluster A 2026-10-21 | [bmad/stories/phpstan-clusterA-20261021.story.md](stories/0012-phpstan-clustera.story.md) |
| Design | [stories/rating-altro-option-conditional-textarea-design.story.md](../stories/0063-rating-altro-option-conditional-textarea-design.story.md) |

## Altri hub

- [README.md](README.md)
- [architecture.md](architecture.md)
- [criteri-a-scelta-multipla.md](../criteri-a-scelta-multipla.md)
- [wiki/](../wiki/)

## Debito docs

**2026-09-22: risolto.** I 38 file sotto `docs/` con marker di merge non risolti
(`<<<<<<<`/`=======`/`>>>>>>>`, incluso `architecture.md`) sono stati fusi e ripuliti
(verifica: `grep -rl '^<<<<<<< \|^=======$\|^>>>>>>> ' docs/` → nessun risultato).
Duplicati case-sensitive noti (es. `INDEX.md`/`index.md`, `BEST_PRACTICES.md`/`best-practices.md`)
non sono stati deduplicati in questo passaggio: sono fuori scope, tracciati in
`root-files-hygiene.md`.

Ancora aperto (fuori scope per questo cleanup, non toccare qui):
- root `README.md` del modulo ha marker di merge non risolti (righe 3-19, 122-133) -
  file fuori `docs/`, serve una story dedicata.
- regressione pulizia root (`ARCHITECTURE.md`/`CHANGELOG.md`/`license.md` duplicati in
  root): vedi `root-files-hygiene.md`.
- possibile corruzione repo Git (commit mancante, vedi `git fsck`): da investigare
  prima di qualsiasi rewrite di history su questo modulo.

## Navigazione canonica (2026-10-09)

- [readme.md](README.md): orientamento BMAD del modulo.
- [purpose.md](purpose.md): scopo e confini.
- [architecture.md](architecture.md): architettura verificata.
- [stories/](stories/): lavoro tracciato, inclusa [docs-reorg-domain](stories/0063-docs-reorg-domain.story.md).

`index.md` è l’indice canonico; `INDEX.md` resta storico e non viene spostato.

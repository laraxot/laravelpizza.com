---
title: "Riorganizzazione docs core Lang"
type: story
tags: [docs, bmad, lang, reorganization]
qmd: "riorganizzazione docs core Lang"
---

# Story — riorganizzazione docs core: Lang

- **ID:** `2026-10-09-docs-reorg-core-lang`
- **Status:** done
- **Scope:** sola documentazione del modulo Lang.

## Acceptance criteria

- [x] Esiste l'indice canonico [docs/bmad/index.md](../index.md).
- [x] Sono indicate directory canoniche e legacy con link relativi.
- [x] Inventario marker eseguito: nessun marker di merge nei `docs/` posseduti.
- [x] Nessun file di codice modificato.

## Inventario

Canoniche: [`docs/bmad/architecture`](../architecture/), [`brainstorming`](../brainstorming/), [`epics`](../epics/), [`stories`](../stories/), [`docs/wiki`](../../wiki/).

Legacy: [`docs/integration`](../../integration/), [`docs/_integration`](../../_integration/), [`docs/raw`](../../raw/), [`docs/roadmap`](../../roadmap/), [`docs/chat`](../../chat/), [`docs/translations/archive`](../../translations/archive/), [`docs/translations/legacy`](../../translations/legacy/).

## Esito

I vari `00-index`, `ARCHITECTURE`, README e nomi duplicati non sono stati cancellati o accorpati perché il contenuto prevalente non è determinabile dal solo inventario.

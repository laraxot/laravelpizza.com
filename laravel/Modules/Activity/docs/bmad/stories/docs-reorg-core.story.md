---
title: "Riorganizzazione docs core Activity"
type: story
tags: [docs, bmad, activity, reorganization]
qmd: "riorganizzazione docs core Activity"
---

# Story — riorganizzazione docs core: Activity

- **ID:** `2026-10-09-docs-reorg-core-activity`
- **Status:** done
- **Scope:** sola documentazione del modulo Activity.

## Acceptance criteria

- [x] Esiste l'indice canonico [docs/bmad/index.md](../index.md).
- [x] Sono indicate directory canoniche e legacy con link relativi.
- [x] Inventario marker eseguito: nessun marker di merge nei `docs/` posseduti.
- [x] Nessun file di codice modificato.

## Inventario

Canoniche: [`docs/bmad/architecture`](../architecture/), [`brainstorming`](../brainstorming/), [`epics`](../epics/), [`stories`](../stories/), [`docs/wiki`](../../wiki/).

Legacy: [`docs/archive`](../../archive/), [`docs/archived`](../../archived/), [`docs/superseded`](../../superseded/), [`docs/raw`](../../raw/), [`docs/chat`](../../chat/), [`docs/use_cases`](../../use_cases/).

## Esito

I contenuti duplicati (`00-index`, README e documenti varianti) non sono stati cancellati né risolti automaticamente: la loro destinazione semantica non è determinabile senza una decisione specifica.

---
title: "rating table component reusable.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "rating table component reusable.story"
issues: []
discussions: []
status: draft
---
# Story: rating-table-component-reusable

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

**Status**: ready-for-dev
**Modulo**: Rating
**Epic**: componente blade riutilizzabile per tabella rating (esportazioni + UI)

## AC
- [ ] Componente blade `components/rating-table.blade.php` riutilizzabile (modulo Rating)
- [ ] Accetta `$row` (modello con relazione `ratings`) e opzioni: `showNote`, `rowspan`, `alignValue`
- [ ] Colonne: txt (col1), value bold (col2), note rowspan-only (col4)
- [ ] Usa `{!! $rating->getTxtHtml() !!}`, `{!! $rating->getValueHtml() !!}`, `{!! $rating->getNoteHtml() !!}` (esistenti su BaseRating)
- [ ] Blade schema valido: `@php $note='' @endphp`, accumulo note nel loop, `rowspan="{{ $loop->count }}"` solo ultimo iterazione
- [ ] PHPStan Modules/Rating [OK]
- [ ] Usato in almeno un punto (esportazione XLS o vista scheda)

## Note
- Second brain: aggiungere regola `rating-scheda-domain.md#blade-rating-table-component` in `bashscripts/ai/wiki/memories/`
- QMD: aggiornare `qmd update` dopo creazione componente


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).

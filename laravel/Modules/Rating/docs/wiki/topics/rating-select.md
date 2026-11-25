---
title: "Topic rating-select"
type: digest
status: active
qmd: "digest ceiling 100 rating-select"
---

# Topic rating-select

Sintesi automatica di 4 documenti (chiave `rating-select`).

## Spec implementazione: codice che si vuole scrivere

_Fonte: `bmad/architecture/rating-select-altro-implementation-spec.md`_

# Spec implementazione: codice che si vuole scrivere

> **Docs-only.** Canon: option «altro» = `''`; placeholder = `null`; `selectIsOther === ''` only.  
> **Non** `ALTRO_KEY='altro'` (superseded). SSoT: [rating-select-altro-note.md](rating-select-altro-note.md).

## GitHub

| | URL |
|--|-----|
| Design | https://github.com/laraxot/module_rating_fila5/issues/57 |
| Impl | https://github.com/laraxot/module_rating_fila5/issues/58 |
| Discussion | https://github.com/laraxot/module_rating_fila5/discussions/59 |
| D-8 | https://github.com/laraxot/module_rating_fila5/issues/60 |
| IR | https://github.com/provtv/module_indennitaresponsabilita_fila5/issues/36 |

## As-is

`buildRatingComponent` (~343–373): con figli → solo `Select` (id figli). Nessuna Textarea, nessuna option «altro».

IR Compila: fill solo `pivot.value`; save `is_numeric ? value : 0` (altro/blank → **0**).

## To-be: helpers

```php
private const string OTHER_OPTION_KEY = '';

/** Solo option '' = altro. null = non scelto. Mai blank(). */
private static function selectIsOther(Get $get, string $selectField): bool
{

## Architecture: Select + Textarea su rating con figli

_Fonte: `bmad/architecture/rating-select-altro-note.md`_

# Architecture: Select + Textarea su rating con figli

## Contratto di business (canon utente)

Fonte primaria verificabile: [`../../prompts/01.md`](../../prompts/01.md) -
*«chiave "" o null»*; raffinato: **option `'other'` ≠ placeholder `null`**.

Quando un criterio (`rating`) **ha figli**:

1. Schema: **sempre** `Select` + `Textarea` (`Fieldset`, `columnSpan(2)`).
2. Select → `rating_morph.value`.
3. Textarea → `rating_morph.note`.
4. Textarea **required** solo se Select = option «altro» (`=== 'other'` via `selectIsOther`).
5. «altro» **non è un figlio**; lo aggiunge il trait.
6. Chiave option = **`'other'`** (`OTHER_OPTION_KEY`, stringa non vuota: NON `''`). Placeholder Select →
   stato **`null`**. Label option =
   `trans('rating::fields.altro')` (non `->label()` sul componente).

> **Anti-drift:** agenti paralleli hanno rivendicato «utente ha confermato `ALTRO_KEY='altro'`».
> Quella rivendicazione è **circolare** (si citano a vicenda) e **contraddetta** dal prompt
> scritto + commenti GH #57/#58 più recenti (`selectIsOther`, null ≠ altro).  
> `ALTRO_KEY='altro'` + dehydrate stringa = **D-7 superseded** (resta).  
> Anche la sentinella `''` è **superseded** (2026-09-16): `blank('')` è true
> (select.js `OptionStateCast` → `null`) quindi `selectIsOther('')` non scatta mai a runtime;
> fix: sentinella non-blank `'other'` (`OTHER_OPTION_KEY`).

## Perché `'other'` (non `''`) + placeholder `null`

| | Option `'other'` + placeholder null | Sentinella `''` (vecchia) |

## Brainstorming: chiave option e UI

_Fonte: `bmad/brainstorming/rating-select-altro-note-obbligatoria.md`_

# Brainstorming: chiave option e UI

## Domanda

Come aggiungere «altro» al Select dei rating con figli, con nota obbligatoria?

## Opzioni

### A: Textarea solo se «altro» (`visible`)

**Respinta** dall’utente: vuole **sempre** Select + Textarea.

### B: Chiave stringa `'altro'` + dehydrate

Pro: esplicita. Contro: colonna `value` numerica; mapping form↔DB.  
Adottata in bozze 2026-09-15 e **ri-proposta da agenti paralleli** come «conferma utente» -
**non supportata** dal prompt scritto in `docs/prompts/01.md`.

### C: Option `''` + placeholder `null` + `selectIsOther` ✅

Pro: allinea DB (`value` null); distinzione non-scelto vs altro senza sentinella testuale.  
Contro mitigato: disciplina `=== ''` (mai `blank()`) + Pest.

## Decisione

**C raffinato.** Documentata in architecture + implementation-spec + design.

Agenti che riscrivono verso B devono citare un **nuovo** prompt utente verificabile, non
commenti interni circolari.

## Epic: Select «altro» + note

_Fonte: `bmad/epics/rating-select-altro.md`_

# Epic: Select «altro» + note

## Outcome

Valutatore vede sempre Select e Textarea sui criteri con figli; salva value/note sul pivot;
se sceglie «altro» (option chiave **`''`**, placeholder Select = **`null`**) la note è obbligatoria.

## Stories

| ID | Status | GH |
|----|--------|-----|
| Rating/5.99 | ready-for-dev (docs) | #57 #58 disc #59 |
| Rating/5.141 D-8 filtro | ready-for-dev (docs) | #60 |
| Rating/5.142 review gate | ready-for-dev (docs) | #61 |
| Rating/5.143 lang | ready-for-dev (docs) | #62 |
| IR/5.140 smoke Compila | ready-for-dev (dopo 5.99) | IR #36 |
| IR/5.142 Compila review | ready-for-dev | IR #37 |

## Canon

[architecture/rating-select-altro-note.md](../architecture/rating-select-altro-note.md) ·
[architecture/rating-select-altro-implementation-spec.md](../architecture/rating-select-altro-implementation-spec.md) ·
[design](../../stories/0063-rating-altro-option-conditional-textarea-design.story.md)

**Anti-drift:** bozze che rivendicano `ALTRO_KEY = 'altro'` (stringa) sono superseded dal prompt
utente (`docs/prompts/01.md`) e dai commenti GH più recenti su #57/#58.

---
agent: opencode
type: session-summary
module: Sigma
topic: Sto00f -> BaseDateRangeModel
date: 2026-06-15
---

# Sto00f — refactoring su BaseDateRangeModel

## Task

`Sto00f` (storico dipendente) estendeva `BaseModel` ma ha campi data range:
- `st2kas` — data dal (rangeFromField)
- `st2kdi` — data al (rangeToField)  
- `stann` — annullamento (annFieldName)

Deve estendere `BaseDateRangeModel` come `Asz00f`, `Qua00f`, `Qua03f`, `Rep00f`.

## Stato finale

- `class Sto00f extends BaseDateRangeModel` ✅
- `rangeFromField(): 'st2kas'` ✅
- `rangeToField(): 'st2kdi'` ✅
- `annFieldName(): 'stann'` ✅
- Scope ridondanti (`scopeOfYear`, `scopeOfEnteYear`) rimossi — già in `CommonScope` via trait
- `$timestamps = false` rimosso — già in `BaseDateRangeModel`
- `$connection = 'generale'` rimosso — già in `BaseModel`

## Pattern architetturale (da ricordare)

Tutti i modelli Sigma con campi dal/al/ann devono estendere `BaseDateRangeModel` e implementare i 3 metodi `rangeFromField()`, `rangeToField()`, `annFieldName()`. Non devono MAI duplicare gli scope (`scopeOfYear`, `scopeOfEnteYear`, ecc.) già forniti da `CommonScope`.

## Altri modelli da valutare

- `Sto00k1` — ha st2kas/st2kdi/stann ma è un modello semplice (solo $table). Da valutare se serve BaseDateRangeModel.
- `Dipt00f` — ✅ convertito a BaseDateRangeModel (dtdal/dtal/dtannu). Aggiornamento successivo.

## Docs aggiornati

- architecture.md — gerarchia modelli
- concepts/sigma-model-inheritance.md — lista modern
- concepts/common-scope-date-range-ownership.md — lista modern
- rules/basemodel-hierarchy.md — lista modern
- docs/wiki/log.md — entry aggiornata

---
title: base scheda asz relationship
type: concept
tags: [ptv, bascheda, asz, scheda-contract, dry]
created: 2026-06-15
updated: 2026-06-15
qmd: "BaseScheda asz SchedaContract relazione ASZ ofRangeDate"
related:
  - ../../../../../docs/wiki/rules/eloquent-relationship-encapsulation.md
  - ../../../../../docs/wiki/patterns/scheda-asz-relationship-query.md
  - ../../../../Progressioni/docs/wiki/concepts/phpstan-progressioni-gate.md
---

# BaseScheda::asz() — fonte unica DRY

## Scopo

Tutte le schede dominio (`Ptv\Scheda`, `Progressioni\Scheda`, `Progressioni` record) estendono `BaseScheda` e **ereditano** la relazione ASZ. Le action Ptv tipizzano `SchedaContract` e chiamano `$scheda->asz()->ofRangeDate()` — mai `Asz00k1::query()`.

## Implementazione

`Modules\Ptv\Models\BaseScheda::asz()`:

- `hasMany(Asz00k1::class, 'matr', 'matr')`
- `where($tbl.'.ente', $this->ente)`
- `where($tbl.'.aszann', '')`

## Contratto PHPStan

`SchedaContract` espone `@method HasMany<Asz00k1, Model> asz()` (non metodo interface — evita covarianza template `HasMany`).

## Consumer

- `ListaAszTipCodEsclusoSubito` — criteri esclusione ASZ immediata
- `ProgressioniFunctionTrait` — stessa catena su `$this->asz()`
- `TrovaEsclusiAction` — batch esclusi

## Story

[STORY-002](../../../../../docs/stories/STORY-002-scheda-contract-unification.md)

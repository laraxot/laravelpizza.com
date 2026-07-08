---
title: "Concetto — relazione asz su schede"
type: concept
tags: [asz, asz00k1, relationship, sigma]
created: 2026-06-15
updated: 2026-06-15
qmd: "asz Asz00k1 relazione scheda ofRangeDate ente matr aszann"
related:
  - ../../../../docs/wiki/patterns/scheda-asz-relationship-query.md
  - ../../../../docs/wiki/rules/eloquent-relationship-encapsulation.md
  - ../index.md
---

# Relazione `asz()` — assenze dipendente (Asz00k1)

## Scopo

`Asz00k1` registra periodi assenza/aspettativa per matricola ed ente. Le **schede** progressioni/performance espongono `asz(): HasMany` per interrogare solo i record del dipendente corrente.

## Filtri nel modello (non nelle action)

- join `matr`
- `ente` della scheda
- `aszann = ''` (record non annualizzati)

Scope `ofRangeDate(int $dal, int $al)` definito su `Asz00k1` — invocabile sulla catena `$scheda->asz()->ofRangeDate(...)`.

## Consumer cross-modulo

Modulo **Ptv** (`ListaAszTipCodEsclusoSubito`) riceve `SchedaContract` e **deve** usare `asz()`, mai `Asz00k1::query()` diretto.

## Widget admin Asz00f

Per consultazione tabella `asz00f` in Filament Progressioni: [asz00f-filament-stats-overview.md](../../../Progressioni/docs/wiki/concepts/asz00f-filament-stats-overview.md) — stats su record con `aszann = ''`.

## Collegamenti root

- [scheda-asz-relationship-query.md](../../../../docs/wiki/patterns/scheda-asz-relationship-query.md)

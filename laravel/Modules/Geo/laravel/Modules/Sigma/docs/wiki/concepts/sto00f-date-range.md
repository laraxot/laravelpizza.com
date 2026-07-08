---
title: "sto00f — intervallo date storico assunzioni"
type: concept
module: Sigma
tags: [sto00f, basemodel, date-range, st2kas, stann]
created: 2026-06-15
updated: 2026-06-15
qmd: "Sto00f BaseDateRangeModel st2kas st2kdi stann storico assunzione"
related:
  - ./sigma-model-inheritance.md
  - ./common-scope-date-range-ownership.md
  - ../../../../../../docs/wiki/rules/module-model-base-inheritance.md
---

# Sto00f — storico posizione / assunzione

## Scopo business

`sto00f` registra lo **storico** del dipendente (assunzione, dimissione, tipologie). Per progressioni e report servono:

- intervallo validità (**dal** / **al**)
- flag **annullamento** riga
- calcolo giorni (`giorni()`, `gg()`) su Ymd legacy

## Mapping colonne → contratto date

| Ruolo | Colonna legacy | Metodo contratto |
|-------|----------------|------------------|
| Dal (inizio) | `st2kas` | `rangeFromField()` |
| Al (fine, 0 = aperto) | `st2kdi` | `rangeToField()` |
| Annullamento | `stann` (`''` = attivo) | `annFieldName()` |

Naming Sigma non uniforme (`st2kas`/`st2kdi` vs `qua2kd`/`qua2ka`): il **contratto** resta uguale, cambiano solo i literal sul modello.

## Implementazione

```php
class Sto00f extends BaseDateRangeModel
{
    public function rangeFromField(): string { return 'st2kas'; }
    public function rangeToField(): string { return 'st2kdi'; }
    public function annFieldName(): string { return 'stann'; }
}
```

`scopeOfYear` / `scopeOfEnteYear` override con `year(st2kas)` / `year(st2kdi)` — allineati a `EnteMatrAnnoRelationship::Sto00fYear()`.

## Anti-pattern

- `extends BaseModel` senza `CommonScope` → perde `ofRangeDate`, `ofEnteYear`, coerenza con `Rep00f`/`Qua00f`.
- Sottoclasse `BaseDateRangeModelCarbon` → **vietato**; Carbon resta nei metodi business (`giorni`, `gg`), non nella gerarchia.

## Collegamenti

- [sigma-model-inheritance](./sigma-model-inheritance.md)
- [common-scope-date-range-ownership](./common-scope-date-range-ownership.md)

---
title: "naming relazioni con filtro date"
type: concept
module: IndennitaResponsabilita
tags: [relationships, naming, ofRangeDate, dry]
created: 2026-06-15
updated: 2026-06-15
qmd: "qua00fDateRange qua00fDaterange ofRangeDate relationship naming LettF dalf alf"
related:
  - ../../../../../../docs/wiki/rules/relationship-filtered-naming.md
  - ../../../../../Sigma/docs/wiki/concepts/common-scope-date-range-ownership.md
---

# Naming relazioni con filtro date

## Perché

`qua00f()` (trait `EnteMatrRelationship`) = join ente+matr **senza** vincolo temporale.

Se aggiungi filtro su `qua2kd`/`qua2ka`, **non** è più `qua00f()`: il nome deve esprimere il vincolo.

## LettF — tre range

| Range campi | Relazione | Uso |
|-------------|-----------|-----|
| `dal` / `al` | `qua00fDaterange()` (trait Sigma) | periodo generale scheda |
| `dalf` / `alf` | `qua00fRetribuzioneDateRange()` | periodo retribuzione |
| `dali` / `ali` | (futuro se serve) | periodo indennità |

## Nota PHP — perché non `qua00fDateRange`

In PHP i nomi metodo sono **case-insensitive**: `qua00fDateRange` ≡ `qua00fDaterange`. Non si possono avere due metodi distinti per `dal/al` e `dalf/alf`. Il nome canon per il range retribuzione è quindi `qua00fRetribuzioneDateRange` (esprime il campo e non collide).

## LettI — observer `updateFields`

Non definisce una relazione dedicata: usa `$anag->qua00f()->ofRangeDate($dalfInt, $alfInt)` sul range `dalf`/`alf` (stesso contratto semantico, via Anag).

## Regola scope

Mai `whereRaw` lungo su intervalli `qua2kd`/`qua2ka`: usare `->ofRangeDate($dalYmd, $alYmd)` su `Qua00f` (`CommonScope`).

Vale anche per `->ofYear($anno)` su `Rep00f`/`Qua00f` invece di `whereRaw('year(col) ...')`. Esempi fissati: `Progressioni/Scheda`, `LettI`, `Qua00f::posizioniEconomicheOfYearCollection()`.

## Anti-pattern

- `Qua00f()` PascalCase — sembra classe, non relazione
- Relazione che fa query + filtro date ma si chiama come la relazione base

## Collegamenti

- [relationship-filtered-naming](../../../../../../docs/wiki/rules/relationship-filtered-naming.md)
- [common-scope-date-range-ownership](../../../../../Sigma/docs/wiki/concepts/common-scope-date-range-ownership.md)

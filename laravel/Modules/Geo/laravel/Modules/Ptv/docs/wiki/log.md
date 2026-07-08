---
title: "Activity Log"
module: "Ptv"
---

# Activity Log — Ptv

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

### 2026-06-18 — Trova esclusi: cascata giorni e bugfix Sigma

- TypeError in `FunctionExtra::applyQua00fProproFilters` bloccava azione Trova esclusi su schede Progressioni.
- Doc cascata Ptv: [trova-esclusi-gg-cascade](./concepts/trova-esclusi-gg-cascade.md)
- Fix owner Sigma: [function-extra-relation-query-pattern](../../../../Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md)
- Pattern agente: [bugfix-business-logic-before-type](../../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md)

### 2026-06-18 — Check: fillable + no persist*

- Rimosso `persistCriteriEsclusioneEsito`; `Check::assertAttributesAreFillable()` + `update()`.
- Regola agente: [domain-method-naming-no-persist](../../../../../../docs/wiki/patterns/domain-method-naming-no-persist.md)
- Wiki: [check-criteri-esclusione](./concepts/check-criteri-esclusione.md)

### 2026-06-18 — Check fail-fast (no continue silenziosi)

- `Check`: criterio invalido / action mancante → `InvalidArgumentException` (non più `continue`).
- Test: `CheckSchedaContractTest` (fail-fast).

### 2026-06-18 — MinGgIntegParamsNoAsz + guard Check

- Crash Trova esclusi: criterio DB `min_gg_integ_params_no_asz` senza action; ripristinato `class_exists` in `Check`.
- Nuova action: `MinGgIntegParamsNoAsz` (accessor `gg_esperienza_no_asz`).
- Test registry enum → action: `CriteriEsclusioneEnumActionRegistryTest`.

### 2026-06-18 — Check criteri esclusione su SchedaContract

- `Check::execute` e `CheckCriterioEsclusioneContract` usano `SchedaContract` (allineate le action figlie ancora su `Model`).
- Doc: [phpstan-scheda-actions](./concepts/phpstan-scheda-actions.md)

### 2026-06-18 — Convenzione getter ByYear su SchedaContract

- Rinominati: `getCriteriEsclusioneByYear`, `getCriteriOptionsParsedByYear` (no `load*ForYear`).
- Wiki: [getter-by-year-naming](./concepts/getter-by-year-naming.md), [trova-esclusi-criteri-by-year](./concepts/trova-esclusi-criteri-by-year.md)
- Test: `Modules/Ptv/tests/Unit/Models/BaseSchedaCriteriByYearTest.php`

### 2026-06-18 — Analisi refactor criteri anno (TrovaEsclusi)

- Proposta: estrarre get `criteri_esclusione` / `criteri_options` da `TrovaEsclusiByModelClassYearAction`.
- Analisi: [analisi-trova-esclusi-criteri-refactor](../../../../../../docs/chat/analisi-trova-esclusi-criteri-refactor.md)
- Wiki: [trova-esclusi-criteri-by-year](./concepts/trova-esclusi-criteri-by-year.md)
- Script GH: `bashscripts/ai/gh-ptv-trova-esclusi-criteri-refactor-audit.sh`

### 2026-06-15 — BaseScheda contract stacking (PHPStan trait)

- `SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract`; `BaseScheda implements SchedaContract` solo.
- Trait `HasEnteMatrRelationHelpers` (Sigma) su `BaseScheda` per relazioni ente/matr.
- Gate: `./vendor/bin/phpstan analyse Modules/Ptv` → 0 errori.
- Doc: [scheda-contract-inheritance](./concepts/scheda-contract-inheritance.md), [contract-interface-stacking](../../../../docs/wiki/rules/contract-interface-stacking.md).

### 2026-06-15 — PHPStan livello max (modulo Ptv)

- **Prima:** ~133 errori PHPStan su `Modules/Ptv` (primo ingresso in scope `phpstan analyse Modules`).
- **Dopo:** 0 errori su `Modules/Ptv` e `Modules` intero.
- **Pattern applicati:**
   - `SchedaContract`: `@phpstan-require-extends Model`, `@mixin \Eloquent`, proprietà relazione documentate (`asz`).
   - `ProgressioneSchedaContract`: **rimosso** (2026-06-15) — superfluo, Scheda estende BaseScheda che implementa SchedaContract.
  - `EloquentModelResolver`: narrowing `class-string<Model>` per action generiche su schede Performance.
  - `BaseScheda::performanceIndividuale()`: relazione verso `Modules\Performance\Models\Individuale` (classe `Performance` inesistente).
  - Rimosso `getActivitylogOptions()` da `BaseScheda` (trait `LogsActivity` disabilitato, pacchetto activitylog assente in vendor).
  - `SchedaContract`: `@method asz()` + `BaseScheda::asz()` — unico contratto (ProgressioneSchedaContract eliminato).
  - `ListaAszTipCodEsclusoSubito`: `$scheda->asz()->ofRangeDate()` con type-hint `SchedaContract`.
  - `Check::execute()`: parametro `$criteriEsclusione` come `iterable<int, Model>` per compatibilità Eloquent Collection cross-modulo (covarianza template).
- **Riferimenti:** [phpstan-optional-contracts](../../../../docs/wiki/patterns/phpstan-optional-contracts.md)


### Format

```
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**
- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

**Last Activity:** 2026-06-15 — Contract stacking su SchedaContract  
**Total Operations:** 2

[2026-06-15] [STACKING] `SchedaContract` ora `extends EnteMatrFieldsContract, DateRangeFieldsContract`. `BaseScheda implements SchedaContract` solo (rimossi `implements ` extra). Contratto composito in `Ptv/app/Models/Contracts/SchedaContract.php`.

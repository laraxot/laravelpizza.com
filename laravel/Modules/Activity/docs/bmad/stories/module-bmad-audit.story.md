---
title: "Module BMAD audit — Activity"
type: story
status: review
updated: 2026-11-16
module: Activity
bmad: true
qmd: "story BMAD audit modulo Activity inventario gate pest phpstan finding P1"
related:
  - ../audits/activity-audit.md
  - ../epics.md
  - ../piano-miglioramento.md
---

# Story: audit BMAD profondo del modulo Activity

## Contesto

Audit source-first del modulo che deve garantire "chi ha cambiato cosa, quando e com'era prima" ([purpose](../purpose.md)).

## Acceptance

- [x] Inventario misurato e finding con `path:line` ([audit profondo](../audits/activity-audit.md)).
- [x] Sintesi + gate ([audit](../audit.md)), checklist ([ECC](../../ecc/activity-ecc-audit.md)).
- [x] Epics reali al posto del template ([epics](../epics.md)); decision-log aggiornato.
- [x] PHPStan `Modules/Activity`: 0 errori (2026-11-16).
- [x] Pest `Modules/Activity/tests/Feature` completato su scratch DB: 0 failed / 181 passed / 9 skipped (vedi sotto).
- [ ] Pest suite completa del modulo: parziale — 25 pass in 2 probe (`ActivityManagementTest`, `BaseModelBusinessLogicTest`); suite completa in timeout a 900 s (carico macchina).
- [ ] E1–E4 chiuse con test di regressione.
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
<<<<<<< .merge_file_1iwDfm
=======
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_6s2Vt8
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
>>>>>>> .merge_file_cILxgZ
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy

## Riferimenti

1. Lock dei file di `docs/` del modulo (`bashscripts/lock/`), unlock a fine lavoro.
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
<<<<<<< .merge_file_1iwDfm
=======
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy
2. Audit codice → docs; nessun PHP toccato.
3. Pack ECC e indici aggiornati; `qmd update`.
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

## Procedura

1. Lock dei file di `docs/` del modulo (`bashscripts/lock/`), unlock a fine lavoro.
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
>>>>>>> .merge_file_cILxgZ
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy
2. Audit codice → docs; nessun PHP toccato dall'audit (i fix Pest qui sotto sono un intervento separato).
3. Pack ECC e indici aggiornati; `qmd update`.

## Riferimenti

- [audit](../audit.md)
- [piano](../piano-miglioramento.md)
- [ECC](../../ecc/activity-ecc-audit.md)
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
<<<<<<< .merge_file_1iwDfm
=======
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_WekVOH
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_WekVOH
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_WekVOH
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
>>>>>>> .merge_file_cILxgZ
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy

## Esito

Baseline audit consegnata: 0 P0, 5 P1, P2 elencati. Chiusura dei P1 demandata alle story figlie di [epics.md](../epics.md).
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
<<<<<<< .merge_file_1iwDfm
=======
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< .merge_file_6s2Vt8
=======
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
<<<<<<< .merge_file_6s2Vt8
=======
>>>>>>> laraxot/dev
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
>>>>>>> .merge_file_cILxgZ
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy
PHPStan `Modules/Activity` a 0.

## Pest Feature fixes 2026-11-16

`Modules/Activity/tests/Feature`: 16 failed / 165 passed → **0 failed / 181 passed / 9 skipped**
(`PEST_OUT=/tmp/pest-activity-feature-fix.log bash bashscripts/tools/pest-scratch-db.sh Modules/Activity/tests/Feature`,
Duration ~660s). PHPStan `Modules/Activity` resta a 0 errori.

Cause e fix:

- **Helper globali non caricati** (`activityCreateUser`): Pest carica `Pest.php`/`Helpers.php`
  solo dal `--test-directory` della run. Stesso pattern del fix Unit: `TestCase::activityCreateUser()`
  e `TestCase::activityCreateActivity()` static in `tests/TestCase.php`; aggiornati
  `tests/Feature/ActionsTest.php` e `tests/Security/AccessControlTest.php`.
- **Trait factory**: `BaseModelBusinessLogic{,Pest}Test` asserivano `HasFactory`, ma la
  convenzione Laraxot e' `HasXotFactory` (ereditato da `XotBaseModel`, come in
  `Modules/Xot/tests/Feature/XotBaseModelBusinessLogicTest.php`). Allineate le asserzioni.
- **Docs dedup**: `CodeQualityTest` cercava `docs/README.md`/`docs/readme.md`, consolidati
  in `docs/bmad/readme.md` (commit 73c5b7dc). Test allineato al nuovo path.
- **Tooltip action**: `ListLogActivitiesAction` non usa piu' `->tooltip()` hardcoded
  (regola no-filament-labels, auto-traduzione LangServiceProvider). Test allineato:
  `getTooltip()` e' `null` di proposito.
- **Pagine Lista Filament**: `XotBaseListRecords` non usa piu' `HasXotTable`; la tabella si
  costruisce da `XotBaseResource::table()` → `*Table` class. `FilamentTest` ora chiama
  `ActivityResource::table()`/`SnapshotResource::table()`/`StoredEventResource::table()`;
  azioni asserite via `Table::getFlatActions()` (Filament 5 indicizza per nome, non per chiave array);
  schema `SnapshotForm` allineato alle chiavi reali (`aggregate_uuid`, `aggregate_version`, `state`).
- **Confine Folio**: owner unico = `Cms\FolioVoltServiceProvider` (mai
  `App\Providers\FolioServiceProvider`, mai `Folio::path` in Activity).
  Download: `pages/api/log-download` → `/api/log-download` via Cms.
  SSoT: [folio-volt-sole-owner.md](../../../Cms/docs/bmad/folio-volt-sole-owner.md).

File toccati: `tests/TestCase.php`, `tests/Feature/{ActionsTest,BaseModelBusinessLogicTest,
BaseModelBusinessLogicPestTest,CodeQualityTest,FilamentTest}.php`,
`tests/Feature/Filament/Actions/ListLogActivitiesActionTest.php`,
`tests/Security/AccessControlTest.php`, `app/Providers/ActivityServiceProvider.php`.
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
<<<<<<< .merge_file_1iwDfm
=======
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_WekVOH
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_WekVOH
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_WekVOH
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_W0J2c5
<<<<<<< .merge_file_9QHAJs
<<<<<<< .merge_file_0nJnEE
>>>>>>> .merge_file_cILxgZ
=======
>>>>>>> .merge_file_cktgYw
=======
>>>>>>> .merge_file_cNo7cg
=======
>>>>>>> .merge_file_2b7LRy

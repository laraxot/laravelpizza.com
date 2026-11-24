---
title: "Epics — Lang"
type: epics
status: active
updated: 2026-11-16
bmad: true
module: Lang
qmd: "epics Lang tracker chiavi mancanti test comportamento config morta Post docs LocaleSwitcherRefresh hardcoded story acceptance"
related:
  - ./audits/lang-audit.md
  - ./decision-log.md
  - ./piano-miglioramento.md
---

# Epics — Lang

Sostituisce il template con segnaposto. Ogni epic nasce da un finding dell'[audit](./audits/lang-audit.md); formato: obiettivo, Acceptance (AC), task.

## E1 — Tracker «chiavi mancanti» (P1-1, D-2)

**Obiettivo:** una chiave mancante lascia una traccia affidabile, oppure il meccanismo morto sparisce.

- AC1: D-2 decisa dal committente (cablare o ritirare).
- AC2 (cablare): `registerTranslator()` chiamato da `boot()` con `TranslatorTrait` come unica versione; Pest: `trans('x::y.z')` assente → una riga in `translations`.
- AC2 (ritirare): via `TranslatorAdapter`, `RecordMissingTranslationAction`, `TranslatorTraitPhpstanProbe`, `Translation`/`LanguageLine` e relative migration additive di chiusura (mai `drop` senza approvazione dati).
- Task: lock, decisione, implementazione, PHPStan, Pest.

## E2 — Suite verde su scratch DB (P1-3)

**Obiettivo:** `Modules/Lang/tests/Feature` verde.

- AC1: migration `2026_11_05_100000_update_user_id_uuid_on_{posts,translations}_table` applicate al DB sorgente (additive, a cura di chi gestisce quel DB).
- AC2: `pest-scratch-db.sh Modules/Lang/tests/Feature` → 0 fail.

## E3 — Test di comportamento al posto di quelli «coverage» (D-4)

- AC1: Pest per `AutoLabelAction` (chiave presente / assente / `FIX:`), `SaveTransAction` (`execute` filtrato, `persist` diretto, file illeggibile non riscritto), policy (`lang::admin` bypass; utente senza permesso → false).
- AC2: i 4 file `Lang*CoverageTest`/`FinalGaps` rimossi o ridotti; un solo albero `tests/Unit`.

## E4 — Il modulo rispetta la propria regola (P2)

- AC1: `LocaleSwitcherRefresh.php:34,45` senza stringhe letterali (chiavi in `lang/it`).
- AC2: `rg "->label\('[A-Za-z]" app` = 0 (esclusi `AutoLabelAction` e `TranslationEditor` con `''`).

## E5 — Docs e debito (P1-2, P2)

- AC1: `docs/business-logic-overview.md` allineato (rimossi `ValidateTranslationsAction`, `LangResource`).
- AC2: D-1 attuata (`config/lang.php` tolto o caricato come `lang.*`).
- AC3: D-3 decisa (`Post` resta o esce con story dedicata).
- AC4: `WriteTranslationFileAction`/`ReadTranslationFileAction` cancellate (0 caller) o cablate; `tableCreate` triplicate documentate/ridotte.
- AC5: `GetTransPathAction` valida namespace e locale su allowlist.

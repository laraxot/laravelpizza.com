---
title: "Decision log — Lang"
type: decision-log
status: active
updated: 2026-11-16
bmad: true
module: Lang
qmd: "decision log Lang tracker chiavi mancanti DB registerTranslator Post fuori scope config lang.php morta SaveTransAction solo local test coverage"
related:
  - ./audits/lang-audit.md
  - ./architecture.md
  - ./epics.md
---

# Decision log — Lang

Le voci di esempio fittizie del template precedente («Filament Widget invece di Livewire» e simili) sono state rimosse: non descrivevano il modulo.

| ID | Data | Stato | Decisione | Perché | Evidenza |
|---|---|---|---|---|---|
| D-4 | 2026-11-16 | PROPOSTA | Sostituire i 4 test "coverage" (2.248 r.) con test di comportamento (`AutoLabelAction`, `SaveTransAction`, policy) | Nominati per la percentuale; non proteggono lo scopo | `tests/Unit/Lang{HundredPercentCoverage,FinalGaps,CoverageGaps,CoverageBoost}Test.php` |
| D-3 | 2026-11-16 | **APERTA** | `Post` resta in Lang o esce? | Modello editoriale senza consumatori fuori da Lang; confine poco chiaro | `Models/Post.php`, `PostPolicy`, 5 migration, `PostSeeder` |
| D-2 | 2026-11-16 | **APERTA** | Tracker DB «chiavi mancanti»: cablare (`registerTranslator` + `TranslatorTrait`, una sola versione) o ritirare (`Translation`, `LanguageLine`, `TranslatorAdapter`, sonda) | Oggi non è cablato: `translations` non si popola | `LangServiceProvider.php:43,147`, `TranslatorTraitPhpstanProbe.php:13` |
| D-1 | 2026-11-16 | PROPOSTA | Eliminare `config/lang.php` (o caricarla come `lang.*`) e togliere `save_missing_translations => true` | Config mai letta; il valore `true` contraddice il default reale (`isLocal()`) | `config/lang.php:211`, `SaveTransAction.php:33` |
| D-0 | data non tracciata nel codice | APPROVATA (storica) | Scrittura automatica delle chiavi mancanti solo in `local` (C-05, DCP-282) | In produzione un file di lingua riscritto a runtime può restare a metà e dare 500 | `SaveTransAction.php:19-34` |

## D-2 — opzioni

| Opzione | Pro | Contro |
|---|---|---|
| A. Cablare | chiavi mancanti visibili su DB anche in produzione | scrive nel DB a ogni richiesta con chiave mancante; serve limite/coda |
| B. Ritirare | meno codice, un solo meccanismo (file) | si perde la traccia delle chiavi mancanti fuori da `local` |

Raccomandazione: B se il committente accetta che la traccia resti solo in sviluppo; A solo con scrittura in coda. Decide il committente.

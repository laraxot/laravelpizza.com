---
title: "Topic code-quality"
type: digest
status: active
qmd: "digest ceiling 100 code-quality"
---

# Topic code-quality

Sintesi automatica di 6 documenti (chiave `code-quality`).

## Code Quality Analysis - CMS Module - November 2025

_Fonte: `code-quality-analysis-2.md`_

# Code Quality Analysis - CMS Module - November 2025

## 📊 Risultato Analisi Completa

**Data Analisi:** 24 Novembre 2025
**PHPStan Level:** 10 (Massimo)
**File Analizzati:** 295
**Errori PHPStan:** 6
**PHPMD Issues:** Multiple (naming conventions, static access)
**Rector Improvements:** 27 files ready (with corrupted test files)

---

title: "code quality analysis "
title: "code quality analysis"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "code quality analysis cms 2025-11-24"
issues: []
discussions: []
## 🚨 Status Critico

### ❌ PHPStan Errors (6)

**File:** `app/View/Composers/ThemeComposer.php`
- **Line 73-75**: Type errors in `Modules\UI\View\Components\Render\Blocks` constructor
- **Issue**: Parameter type mismatches (array|null vs string, Model|null vs array, string vs Page)

## Code Quality Analysis - CMS Module - November 2025

_Fonte: `code-quality-analysis-3.md`_

> Date (from original filename): 2025-11-24


# Code Quality Analysis - CMS Module - November 2025

## 📊 Risultato Analisi Completa

**Data Analisi:** 24 Novembre 2025
**PHPStan Level:** 10 (Massimo)
**File Analizzati:** 295
**Errori PHPStan:** 6
**PHPMD Issues:** Multiple (naming conventions, static access)
**Rector Improvements:** 27 files ready (with corrupted test files)

---

title: "code quality analysis 2025 11 24"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "code quality analysis 2025 11 24"
issues: []
discussions: []
## 🚨 Status Critico

### ❌ PHPStan Errors (6)

**File:** `app/View/Composers/ThemeComposer.php`

## code-quality-analysis-renamed

_Fonte: `code-quality-analysis-renamed.md`_

See canonical documentation: ../../../Themes/docs/shared-components/code-quality-analysis-2.md

## Code Quality Improvement Report — Cms

_Fonte: `code-quality-improvement-report.md`_

# Code Quality Improvement Report — Cms

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 161 |
| File di test PHP | 142 |
| Rapporto test/file PHP | 88% |
| Candidati senza strict types | 158 |
| Marker TODO/FIXME/HACK/XXX | 2 |
| Estensioni Filament potenzialmente dirette | 0 |
| Controller da classificare FO/BO | 2 |
| Classi in app/Services o app/Support | 0 |
| Priorità iniziale | **alta** |

Rilevazione del 17 luglio 2026 sul working tree locale; esclusi vendor e dipendenze esterne.

## Rischi e priorità

1. **Type safety:** verificare i candidati e introdurre strict types nei file toccati, con tipi concreti e senza nuovi mixed.
2. **Regressioni:** il rapporto file/test non misura copertura. Proteggere prima autorizzazioni, scritture DB, business rule e bug noti.
3. **Laraxot:** confrontare ogni estensione Filament segnalata con XotBase/LangBase. Classificare i controller: vietati nel front office.
4. **Debito:** ogni marker residuo deve avere owner, motivazione e criterio di rimozione.
5. **Boundary:** non aggiungere business logic in Service/Support; riusare Actions con QueueableAction.

## Piano

## Code quality — modulo Cms

_Fonte: `code-quality-report.md`_

# Code quality — modulo Cms

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 139
- File di test: 143 — rapporto test/app: 102%
- File con TODO/FIXME/@deprecated: 3
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 53
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 1

### File con Facade in Actions da convertire

- Modules/Cms/app/Actions/Module/FixJigSawByModuleAction.php

### Complessità / dimensione classi da rivedere

- Modules/Cms/app/Actions/BuildPageSchemaAction.php:15                                              ExcessiveClassComplexity  The class BuildPageSchemaAction has an overall complexity of 60 which is very high. The configured complexity threshold is 50.
- Modules/Cms/app/Actions/BuildPageSchemaAction.php:68                                              CyclomaticComplexity      The method resolvePageType() has a Cyclomatic Complexity of 27. The configured cyclomatic complexity threshold is 10.
- Modules/Cms/app/Actions/BuildPageSchemaAction.php:133                                             CyclomaticComplexity      The method resolveProfileMainEntity() has a Cyclomatic Complexity of 21. The configured c

## code-quality

_Fonte: `code-quality.md`_

See canonical documentation: ../../../Themes/docs/shared-components/code-quality-analysis-legacy.md

---
title: "Topic code-quality"
type: digest
status: active
qmd: "digest ceiling 100 code-quality"
---

# Topic code-quality

Sintesi automatica di 8 documenti (chiave `code-quality`).

## ⚙️ Job Module - Code Quality Analysis Report

_Fonte: `analysis/archive/code-quality-analysis-2.md`_

# ⚙️ Job Module - Code Quality Analysis Report

**Date**: 2025-11-11
**Tools Used**: PHPStan Level 10, PHPMD
**Status**: **CRITICAL** - Syntax errors preventing analysis

## Executive Summary

The Job module has **severe syntax errors** in policy files that prevent both PHPStan and PHPMD from running. These errors must be fixed immediately before any meaningful code quality analysis can be performed.

## Critical Issues Found

### 1. **Syntax Errors Blocking Analysis**
- **PHPStan**: 14 syntax errors in `FrequencyPolicy.php`
- **PHPMD**: Syntax error in `TaskCommentPolicy.php`
- Both tools unable to complete analysis due to parsing failures

### 2. **Known Issues from Partial PHPMD Analysis**
- **Static Access Violations**: Artisan facade, Webmozart assertions
- **Naming Convention Issues**: Non-camelCase variables, short variable names
- **Design Pattern Issues**: Boolean flags, if statement assignments

## Root Cause Analysis

### 1. **Policy File Corruption**
- Multiple `public` keywords in unexpected positions
- Malformed method declarations
- Possible git merge conflicts or file corruption

### 2. **Common Patterns in Partial Analysis**

## ⚙️ Job Module - Code Quality Analysis Report

_Fonte: `analysis/archive/code-quality-analysis.md`_

# ⚙️ Job Module - Code Quality Analysis Report

**Date**: 2025-11-11
**Tools Used**: PHPStan Level 10, PHPMD
**Status**: **CRITICAL** - Syntax errors preventing analysis

## Executive Summary

The Job module has **severe syntax errors** in policy files that prevent both PHPStan and PHPMD from running. These errors must be fixed immediately before any meaningful code quality analysis can be performed.

## Critical Issues Found

### 1. **Syntax Errors Blocking Analysis**
- **PHPStan**: 14 syntax errors in `FrequencyPolicy.php`
- **PHPMD**: Syntax error in `TaskCommentPolicy.php`
- Both tools unable to complete analysis due to parsing failures

### 2. **Known Issues from Partial PHPMD Analysis**
- **Static Access Violations**: Artisan facade, Webmozart assertions
- **Naming Convention Issues**: Non-camelCase variables, short variable names
- **Design Pattern Issues**: Boolean flags, if statement assignments

## Root Cause Analysis

### 1. **Policy File Corruption**
- Multiple `public` keywords in unexpected positions
- Malformed method declarations
- Possible git merge conflicts or file corruption

### 2. **Common Patterns in Partial Analysis**

## ⚙️ Job Module - Code Quality Analysis Report

_Fonte: `analysis/code-quality-analysis.md`_

# ⚙️ Job Module - Code Quality Analysis Report

**Date**: 2025-11-11
**Tools Used**: PHPStan Level 10, PHPMD
**Status**: **CRITICAL** - Syntax errors preventing analysis

## Executive Summary

The Job module has **severe syntax errors** in policy files that prevent both PHPStan and PHPMD from running. These errors must be fixed immediately before any meaningful code quality analysis can be performed.

## Critical Issues Found

### 1. **Syntax Errors Blocking Analysis**
- **PHPStan**: 14 syntax errors in `FrequencyPolicy.php`
- **PHPMD**: Syntax error in `TaskCommentPolicy.php`
- Both tools unable to complete analysis due to parsing failures

### 2. **Known Issues from Partial PHPMD Analysis**
- **Static Access Violations**: Artisan facade, Webmozart assertions
- **Naming Convention Issues**: Non-camelCase variables, short variable names
- **Design Pattern Issues**: Boolean flags, if statement assignments

## Root Cause Analysis

### 1. **Policy File Corruption**
- Multiple `public` keywords in unexpected positions
- Malformed method declarations
- Possible git merge conflicts or file corruption

## Code quality — modulo Job

_Fonte: `code-quality-report.md`_

# Code quality — modulo Job

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 156
- File di test: 33 — rapporto test/app: 21%
- File con TODO/FIXME/@deprecated: 1
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 38
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 3

### File con Facade in Actions da convertire

- Modules/Job/app/Actions/ClearScheduleCacheAction.php
- Modules/Job/app/Actions/GetTaskCommandsAction.php
- Modules/Job/app/Actions/GetActiveSchedulesAction.php

### Complessità / dimensione classi da rivedere

- Modules/Job/app/Filament/Columns/ScheduleArguments.php:58                                         CyclomaticComplexity      The method formatArrayTags() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php:56                                  CyclomaticComplexity      The method formatArrayTags() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Job/app/Models/Schedule.php:182                                                           CyclomaticComplexity     

## ⚙️ Job Module - Code Quality Analysis Report

_Fonte: `wiki/analysis/archive/code-quality-analysis.md`_

# ⚙️ Job Module - Code Quality Analysis Report

**Date**: 2025-11-11
**Tools Used**: PHPStan Level 10, PHPMD
**Status**: **CRITICAL** - Syntax errors preventing analysis

## Executive Summary

The Job module has **severe syntax errors** in policy files that prevent both PHPStan and PHPMD from running. These errors must be fixed immediately before any meaningful code quality analysis can be performed.

## Critical Issues Found

### 1. **Syntax Errors Blocking Analysis**
- **PHPStan**: 14 syntax errors in `FrequencyPolicy.php`
- **PHPMD**: Syntax error in `TaskCommentPolicy.php`
- Both tools unable to complete analysis due to parsing failures

### 2. **Known Issues from Partial PHPMD Analysis**
- **Static Access Violations**: Artisan facade, Webmozart assertions
- **Naming Convention Issues**: Non-camelCase variables, short variable names
- **Design Pattern Issues**: Boolean flags, if statement assignments

## Root Cause Analysis

### 1. **Policy File Corruption**
- Multiple `public` keywords in unexpected positions
- Malformed method declarations
- Possible git merge conflicts or file corruption

### 2. **Common Patterns in Partial Analysis**

## ⚙️ Job Module - Code Quality Analysis Report

_Fonte: `wiki/analysis/code-quality-analysis.md`_

# ⚙️ Job Module - Code Quality Analysis Report

**Date**: 2025-11-11
**Tools Used**: PHPStan Level 10, PHPMD
**Status**: **CRITICAL** - Syntax errors preventing analysis

## Executive Summary

The Job module has **severe syntax errors** in policy files that prevent both PHPStan and PHPMD from running. These errors must be fixed immediately before any meaningful code quality analysis can be performed.

## Critical Issues Found

### 1. **Syntax Errors Blocking Analysis**
- **PHPStan**: 14 syntax errors in `FrequencyPolicy.php`
- **PHPMD**: Syntax error in `TaskCommentPolicy.php`
- Both tools unable to complete analysis due to parsing failures

### 2. **Known Issues from Partial PHPMD Analysis**
- **Static Access Violations**: Artisan facade, Webmozart assertions
- **Naming Convention Issues**: Non-camelCase variables, short variable names
- **Design Pattern Issues**: Boolean flags, if statement assignments

## Root Cause Analysis

### 1. **Policy File Corruption**
- Multiple `public` keywords in unexpected positions
- Malformed method declarations
- Possible git merge conflicts or file corruption

## ⚙️ Job Module - Code Quality Analysis Report

_Fonte: `wiki/analysis/legacy/code-quality-analysis.md`_

# ⚙️ Job Module - Code Quality Analysis Report

**Date**: 2025-11-11
**Tools Used**: PHPStan Level 10, PHPMD
**Status**: **CRITICAL** - Syntax errors preventing analysis

## Executive Summary

The Job module has **severe syntax errors** in policy files that prevent both PHPStan and PHPMD from running. These errors must be fixed immediately before any meaningful code quality analysis can be performed.

## Critical Issues Found

### 1. **Syntax Errors Blocking Analysis**
- **PHPStan**: 14 syntax errors in `FrequencyPolicy.php`
- **PHPMD**: Syntax error in `TaskCommentPolicy.php`
- Both tools unable to complete analysis due to parsing failures

### 2. **Known Issues from Partial PHPMD Analysis**
- **Static Access Violations**: Artisan facade, Webmozart assertions
- **Naming Convention Issues**: Non-camelCase variables, short variable names
- **Design Pattern Issues**: Boolean flags, if statement assignments

## Root Cause Analysis

### 1. **Policy File Corruption**
- Multiple `public` keywords in unexpected positions
- Malformed method declarations
- Possible git merge conflicts or file corruption

## Code Quality Improvement Report — Job

_Fonte: `wiki/code-quality-improvement-report.md`_

# Code Quality Improvement Report — Job

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 202 |
| File di test PHP | 33 |
| Rapporto test/file PHP | 16% |
| Candidati senza strict types | 202 |
| Marker TODO/FIXME/HACK/XXX | 3 |
| Estensioni Filament potenzialmente dirette | 0 |
| Controller da classificare FO/BO | 0 |
| Classi in app/Services o app/Support | 0 |
| Priorità iniziale | **media** |

Rilevazione del 17 luglio 2026 sul working tree locale; esclusi vendor e dipendenze esterne.

## Rischi e priorità

1. **Type safety:** verificare i candidati e introdurre strict types nei file toccati, con tipi concreti e senza nuovi mixed.
2. **Regressioni:** il rapporto file/test non misura copertura. Proteggere prima autorizzazioni, scritture DB, business rule e bug noti.
3. **Laraxot:** confrontare ogni estensione Filament segnalata con XotBase/LangBase. Classificare i controller: vietati nel front office.
4. **Debito:** ogni marker residuo deve avere owner, motivazione e criterio di rimozione.
5. **Boundary:** non aggiungere business logic in Service/Support; riusare Actions con QueueableAction.

## Piano

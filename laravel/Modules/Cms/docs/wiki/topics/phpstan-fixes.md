---
title: "Topic phpstan-fixes"
type: digest
status: active
qmd: "digest ceiling 100 phpstan-fixes"
---

# Topic phpstan-fixes

Sintesi automatica di 8 documenti (chiave `phpstan-fixes`).

## PHPStan Fixes for Cms Module (2025-12-30)

_Fonte: `phpstan-fixes-2.md`_

# PHPStan Fixes for Cms Module (2025-12-30)

This document outlines the errors found by PHPStan in the `Cms` module and the plan to resolve them.

## Error Summary: "Cannot use X as Y because the name is already in use"

These errors indicate conflicting `use` statements or duplicated class/trait imports without proper aliasing.

## Affected Files and Specific Errors:

### 1. `app/Http/View/Composers/XotComposer.php` - Line 10
- **Message:** `Cannot use Illuminate\Database\Eloquent\Relations\HasOne as HasOne because the name is already in use`
- **Plan:** Investigate `use` statements in `XotComposer.php` for redundant `HasOne` imports. Either remove a duplicate or add an alias if another `HasOne` is required from a different namespace.

### 2. `app/Models/BaseTreeModel.php` - Line 18
- **Message:** `Cannot use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships as HasRecursiveRelationships because the name is already in use`
- **Plan:** Investigate `use` statements in `BaseTreeModel.php` for redundant `HasRecursiveRelationships` imports. Correct by removing duplicates or aliasing.

### 3. `database/seeders/CmsMassSeeder.php` - Line 11
- **Message:** `Cannot use Illuminate\Database\Eloquent\Collection as Collection because the name is already in use`
- **Plan:** Investigate `use` statements in `CmsMassSeeder.php` for redundant `Collection` imports. Correct by removing duplicates or aliasing.

## Remediation Plan (per file):

1.  **Read File:** Get the content o

## phpstan-fixes-gennaio

_Fonte: `phpstan-fixes-gennaio.md`_

See canonical documentation: ../../../Themes/docs/shared-components/phpstan-fixes-gennaio-2025-Modules.md

## Correzioni PHPStan - Gennaio 2025

_Fonte: `phpstan-fixes-january.md`_

# Correzioni PHPStan - Gennaio 2025

## Panoramica
Documentazione delle correzioni PHPStan applicate al modulo Cms per raggiungere il livello massimo di analisi statica.

## File Modificati

### 1. app/Http/Controllers/Admin/XotPanelController.php
**Problema**: Chiamata a `method_exists()` su tipo potenzialmente non-oggetto
**Soluzione**: Aggiunto controllo `is_object($panel)` prima di chiamare `method_exists()`

```php
// PRIMA
if (method_exists($panel, 'out')) {
    return $panel->out();
}

// DOPO
if (is_object($panel) && method_exists($panel, 'out')) {
    return $panel->out();
}
```

### 2. app/Http/Middleware/PageSlugMiddleware.php
**Problemi**:
- Casting di tipo non sicuro
- Chiamata a `method_exists()` su tipo potenzialmente non-oggetto
- Variabile non trovata in PHPDoc

## Cms Module - PHPStan Level 10 Fixes Plan

_Fonte: `phpstan-fixes-plan.md`_

# Cms Module - PHPStan Level 10 Fixes Plan

## Overview

The Cms module has **30 PHPStan errors** that need to be resolved to achieve Level 10 compliance. This document outlines the specific fixes required.

## Error Breakdown

### 1. Missing Function Errors

**Files Affected:**
- `Actions/GetStyleClassAction.php:18`
- `Actions/GetViewThemeByViewAction.php:18`
- `Filament/Front/Pages/Home.php:38`
- `Filament/Front/Pages/Welcome.php:45`

**Issues:**
- `inAdmin` function not found
- `params2ContainerItem` function not found

**Solutions:**
- Create missing helper functions in appropriate locations
- Import existing functions if they exist elsewhere
- Add function declarations to composer autoload files

### 2. Type Safety Issues

**Files Affected:**
- `Filament/Front/Pages/Home.php:38`

## PHPStan Level 10 Fixes Roadmap - Modulo Cms

_Fonte: `phpstan-fixes-roadmap.md`_

# PHPStan Level 10 Fixes Roadmap - Modulo Cms

**Data Creazione**: [DATE]  
**Errori Totali**: 6 errori  
**Status**: 🟡 In Progress

## Panoramica

Il modulo Cms ha **6 errori PHPStan** che devono essere risolti per raggiungere la conformità Level 10. Tutti gli errori sono concentrati in `FolioVoltServiceProvider.php`.

## Errori Dettagliati

### File: `app/Providers/FolioVoltServiceProvider.php`

#### 1. Linea 73 - Parameter Type Issue
**Errore**: `Parameter #1 $array of function array_keys expects array, mixed given`

**Causa**: `config('laravellocalization.supportedLocales', ['it' => []])` può restituire `mixed`

**Soluzione**:
```php
/** @var array<string, array<string, mixed>> $supportedLocalesConfig */
$supportedLocalesConfig = config('laravellocalization.supportedLocales', ['it' => []]);
Assert::isArray($supportedLocalesConfig);
$supportedLocales = array_keys($supportedLocalesConfig);
```

#### 2. Linea 87, 110 - URI Parameter Type Issue
**Errore**: `Parameter #1 $uri of method Laravel\Folio\PendingRoute::uri() expects string, int|string given`

## PHPStan Fixes Summary - CMS Module

_Fonte: `phpstan-fixes-summary.md`_

# PHPStan Fixes Summary - CMS Module

**Date**: 2025-11-24
**Status**: ✅ All issues resolved
**PHPStan Level**: 10 (Maximum)

## 📊 Issues Fixed in CMS Module

### Total Issues Resolved: 24

## 🔧 Specific Fixes Applied

### 1. ProfileContract References (18 files)
**Problem**: Models referenced non-existent `Modules\Quaeris\Models\Profile`
**Solution**: Updated to use `Modules\Xot\Contracts\ProfileContract`

**Affected Models**:
- `Attachment` - Lines 27, 31
- `Menu` - Lines 25, 27
- `Module` - Lines 16, 17
- `Page` - Lines 28, 30
- `PageContent` - Lines 24, 26
- `Section` - Lines 24, 26

### 2. Blocks Component Constructor (6 issues)
**Problem**: Incorrect parameter order in Blocks component constructor
**Solution**: Corrected parameter order to match constructor signature

**Constructor Signature**:

## PHPStan Fixes Summary - CMS Module

_Fonte: `phpstan-fixes-sumy.md`_

# PHPStan Fixes Summary - CMS Module

**Date**: [DATE]
**Status**: ✅ All issues resolved
**PHPStan Level**: 10 (Maximum)

## 📊 Issues Fixed in CMS Module

### Total Issues Resolved: 24

## 🔧 Specific Fixes Applied

### 1. ProfileContract References (18 files)
**Problem**: Models referenced non-existent `Modules\Quaeris\Models\Profile`
**Solution**: Updated to use `Modules\Xot\Contracts\ProfileContract`

**Affected Models**:
- `Attachment` - Lines 27, 31
- `Menu` - Lines 25, 27
- `Module` - Lines 16, 17
- `Page` - Lines 28, 30
- `PageContent` - Lines 24, 26
- `Section` - Lines 24, 26

### 2. Blocks Component Constructor (6 issues)
**Problem**: Incorrect parameter order in Blocks component constructor
**Solution**: Corrected parameter order to match constructor signature

**Constructor Signature**:

## PHPStan Fixes - Modulo Cms

_Fonte: `phpstan-fixes.md`_

# PHPStan Fixes - Modulo Cms

## Panoramica
Documentazione dei fix applicati al modulo Cms per raggiungere PHPStan livello 9.

## Fix Applicati

### 1. generate_business_data.php
**Problema**: Uso di `file_put_contents` non sicuro
```php
// PRIMA (non sicuro)
file_put_contents($filePath, $content);

// DOPO (sicuro)
use function Safe\file_put_contents;
file_put_contents($filePath, $content);
```

**Motivazione**: 
- Utilizzo della funzione sicura `Safe\file_put_contents` per gestione errori robusta
- Prevenzione di errori runtime in caso di problemi di scrittura file
- Conformità agli standard di sicurezza PHPStan

## Risultati
- ✅ **0 errori** PHPStan livello 9
- ✅ **Conformità** agli standard di sicurezza
- ✅ **Gestione errori** robusta per operazioni file

## Collegamenti

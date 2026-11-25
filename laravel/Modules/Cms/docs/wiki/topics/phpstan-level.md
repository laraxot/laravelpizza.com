---
title: "Topic phpstan-level"
type: digest
status: active
qmd: "digest ceiling 100 phpstan-level"
---

# Topic phpstan-level

Sintesi automatica di 3 documenti (chiave `phpstan-level`).

## PHPStan Level 10 Compliance Achieved - 2025-12-12

_Fonte: `phpstan-level-10-achievement.md`_

# PHPStan Level 10 Compliance Achieved - 2025-12-12

## Overview
The Cms module has successfully achieved PHPStan Level 10 compliance, ensuring maximum type safety and code quality.

## Issues Fixed

### 1. DownloadAttachmentPlaceHolder Component
**File**: `app/Filament/Forms/Components/DownloadAttachmentPlaceHolder.php`

**Issues Resolved**:
- Fixed `method.impossibleType` error by adding proper view existence check
- Fixed `staticMethod.alreadyNarrowedType` error by removing redundant assertions
- Added missing `View` facade import
- Implemented proper fallback mechanism when views don't exist

**Key Changes**:
```php
// Before: Always assumed view exists
Assert::stringNotEmpty($view);
$out = ViewFactory::make($viewString, $data);

// After: Check view existence with fallback
if (!View::exists($view)) {
    // Use simple HTML output as fallback
    $html = sprintf(
        '<div class="p-4 border border-gray-300 rounded"><h3>%s</h3><p>%s</p><a href="%s" class="btn btn-primary">Download</a></div>',
        e($title),
        e($description),

## PHPStan Level 10 Compliance - Cms Module

_Fonte: `phpstan-level-10-compliance.md`_

# PHPStan Level 10 Compliance - Cms Module

## Overview
Analisi completa e correzione per raggiungere PHPStan Level 10 compliance nel modulo Cms.

## Critical Rules Applied

### 1. 🔥 Git Forward Only Rule
**MAI TORNARE INDIETRO DI VERSIONE - SOLO AVANTI**
- ✅ Nuovi commit per correggere errori
- ✅ Progressione forward-only
- ✅ Storia preservata SEMPRE

### 2. 🔥 Eloquent Anti-Pattern Rule
**MAI property_exists() - SEMPRE isset()**
- ✅ Applicato su tutti i modelli Eloquent
- ✅ Nessun utilizzo di `property_exists()`

### 3. 🔥 PHPStan Level 10 Assoluto
**ZERO errori - NESSUN compromesso**
- ✅ Correzione manuale di TUTTI gli errori
- ✅ Type hints rigorosi
- ✅ PHPDoc blocks completi

## Files Corrected

### XotPanelController.php
**Status**: ✅ PHPStan Level 10 Compliant

## PHPStan Level 10 Compliance - Cms Module

_Fonte: `phpstan-level-10-fixes.md`_

# PHPStan Level 10 Compliance - Cms Module

**Date**: [DATE]
**Status**: ✅ Complete - All 45 errors resolved
**PHPStan Result**: `[OK] No errors`

## Executive Summary

Successfully resolved all 45 PHPStan Level 10 errors in the Cms module, achieving full compliance with maximum static analysis standards. The fixes improve type safety, code reliability, and maintainability across 13 files.

## Error Breakdown by File

### 1. app/Filament/Front/Pages/Home.php (5 errors → 0)

**Issues Fixed:**
- Line 57: `method_exists()` called on mixed type
- Line 60: `getRouteKeyName()` called on class-string|object
- Line 111: `Str::singular()` parameter type mismatch
- Lines 135, 146: Redundant `Assert::string()` calls (always true)

**Solutions:**
```php
// Before
$modelInstance = app($container_last_model);
$container_last_key_name = $modelInstance->getRouteKeyName();

// After
/** @var object $modelInstance */
$modelInstance = app($container_last_model);

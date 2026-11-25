---
title: "Topic activity-log"
type: digest
status: active
qmd: "digest ceiling 100 activity-log"
---

# Topic activity-log

Sintesi automatica di 7 documenti (chiave `activity-log`).

## Activity Log Optimization - Activity Module

_Fonte: `performance/activity-log-optimization.md`_

# Activity Log Optimization - Activity Module

## 🚨 Critical Issues Identified

Based on the comprehensive performance analysis, the Activity module has **MEDIUM** priority performance issues affecting activity listing and batch processing.

### Issue #1: Activity Listing Performance (MEDIUM)
**Location**: Activity log listing and filtering
**Impact**: 50-100 queries per page load

#### Problem
- N+1 queries when loading activity logs
- No proper indexing for common queries
- Missing eager loading for relationships

#### Solution
```php
// EMERGENCY FIX - Optimized activity listing with eager loading
public function getActivities($filters = [])
{
    $query = ActivityLog::with(['causer', 'subject'])
        ->select([
            'id',
            'log_name',
            'description',
            'subject_type',
            'subject_id',
            'causer_type',
            'causer_id',

## activity-log-optimization-renamed

_Fonte: `performance/archive/activity-log-optimization-renamed.md`_

See canonical documentation: ../../../../../Themes/docs/shared-components/ACTIVITY_LOG_OPTIMIZATION.md

## Activity Log Optimization - Activity Module

_Fonte: `performance/archive/activity-log-optimization.md`_

# Activity Log Optimization - Activity Module

> Copia archiviata. Documentazione mantenuta: [activity-log-optimization.md](../activity-log-optimization.md).

## 🚨 Critical Issues Identified

Based on the comprehensive performance analysis, the Activity module has **MEDIUM** priority performance issues affecting activity listing and batch processing.

### Issue #1: Activity Listing Performance (MEDIUM)
**Location**: Activity log listing and filtering
**Impact**: 50-100 queries per page load

#### Problem
- N+1 queries when loading activity logs
- No proper indexing for common queries
- Missing eager loading for relationships

#### Solution
```php
// EMERGENCY FIX - Optimized activity listing with eager loading
public function getActivities($filters = [])
{
    $query = ActivityLog::with(['causer', 'subject'])
        ->select([
            'id',
            'log_name',
            'description',
            'subject_type',
            'subject_id',
            'causer_type',

## Activity Log UI/UX Enhancement

_Fonte: `ui-ux/activity-log-enhancement.md`_

# Activity Log UI/UX Enhancement

## Overview

Comprehensive enhancement of the Activity log blade template (`list-log-activities.blade.php`) to transform it from a basic log viewer into an informative, visually appealing interface following Laraxot architectural patterns.

## Problems Addressed

### Before Enhancement
- ❌ Missing critical `description` field display
- ❌ Poor visual hierarchy and information density
- ❌ No context about what was modified (subject type/ID)
- ❌ Basic table styling without visual indicators
- ❌ No empty states or user guidance
- ❌ Limited accessibility features
- ❌ Violation of DRY principles with repetitive code

### After Enhancement
- ✅ Prominent display of activity descriptions with blue highlighting
- ✅ Clear visual hierarchy with proper spacing and typography
- ✅ Subject information (type and ID) for context
- ✅ Enhanced table with field type icons, tooltips, and change highlighting
- ✅ Comprehensive empty states with contextual guidance
- ✅ Improved accessibility with semantic HTML and proper contrast
- ✅ DRY implementation with reusable helper methods

## Key Improvements

### 1. Description Field Display

## activity_log — attribute_changes

_Fonte: `wiki/concepts/activity-log-attribute-changes-column.md`_

# activity_log — attribute_changes

## Perché

Spatie `laravel-activitylog` v4+ scrive `attribute_changes` (anche `[]`) su INSERT. Senza colonna → errore 1054.

## Schema owner (unica migrazione)

`2026_06_10_140000_create_activity_table.php` — vedi [activity-log-single-migration-contract.md](activity-log-single-migration-contract.md).

```bash
cd laravel && php artisan migrate
```

## Runtime

`Modules\Activity\Support\ActivityLogSchema::isWritable()` — connection da `config('activitylog.database_connection')`.

## Collegamenti

- [activity-log-single-migration-contract.md](activity-log-single-migration-contract.md)

## activity_log — una migrazione per modello

_Fonte: `wiki/concepts/activity-log-single-migration-contract.md`_

# activity_log — una migrazione per modello

## Religione

Un modello (`Modules\Activity\Models\Activity` → `activity_log`) = **un solo** `create_activity_table.php`.

| Vietato | Perché | Consentito |
|---------|--------|------------|
| `add_*_to_activity_table` | seconda migrazione schema | `tableUpdate` nel file owner |
| `fix_*_causer_id_*` | idem | idem |
| `update_activity_log_schema` | `extends Migration` + nome fuori prototipo | `extends XotBaseMigration` |
| Secondo `create_activity_table` | DRY/KISS | edit owner + bump timestamp |

## Anti-pattern espliciti (rimossi)

```
❌ 2024_10_10_000000_add_attribute_changes_to_activity_table.php
❌ 2026_02_13_171410_fix_causer_id_to_uuid.php
❌ 2026_07_01_000000_update_activity_log_schema.php  (extends Migration)
```

Logica assorbita in `tableCreate` + `tableUpdate` idempotente: `attribute_changes`, `causer_id` uuid(36), morph subject, audit timestamps.

## Fonte di verità

`laravel/Modules/Activity/database/migrations/2026_06_10_141000_create_activity_table.php`

- Connessione: `activitylog` / `activity`
- `model_class` = `Modules\Activity\Models\Activity`

## Activity Log UI/UX Improvements - Implementation Summary

_Fonte: `wiki/features/activity-log-ui-improvements.md`_

# Activity Log UI/UX Improvements - Implementation Summary

**Date**: 2025-12-04
**Date**: [DATE]
**Module**: Activity
**Files Modified**:
- `Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php`
- `Modules/Activity/app/Filament/Pages/ListLogActivities.php`

## Problem

The Activity Log view was missing critical information and had poor visual hierarchy:
- ❌ **Description field** not displayed (most important context!)
- ❌ No metadata (log_name, subject_type, batch_uuid)
- ❌ Flat visual hierarchy
- ❌ Poor changes table presentation
- ❌ No visual cues for field types

## Solution Implemented

### 1. Added Description Field ✅

**Location**: Prominently displayed after user info, before changes table

**Design**: Blue-highlighted box with icon for maximum visibility

```blade
@if($activityItem->description)
    <div class="mt-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-md border-l-4 border-blue-200 dark:border-blue-800">

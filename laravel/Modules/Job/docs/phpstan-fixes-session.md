---
title: "PHPStan Fixes - Modulo Job"
type: note
qmd: "phpstan fixes session"
---
# PHPStan Fixes - Modulo Job

## 🔄 Status: IN PROGRESS - 49 Errori Rimanenti

**PHPStan Level**: Max
**Errori Risolti**: 58 → 49 (-9 errori) ✅

---

## 📊 Correzioni Implementate

### 1. Rimozione Generic Type da HasXotFactory ✅
**File**: `app/Models/BaseModel.php:23`

### 2. Aggiunta Casts Mancanti in JobBatch ✅
**File**: `app/Models/JobBatch.php` - Aggiunte properties: total_jobs, pending_jobs, failed_jobs, name

### 3. Aggiunta Casts Completi in Task ✅
**File**: `app/Models/Task.php` - 25 properties complete con casts

### 4. Fix Type Safety in autoCleanup() ✅
**File**: `app/Models/Task.php:245` - Type narrowing per auto_cleanup_num e auto_cleanup_type

### 5. Array Associativi in Filament Actions ✅
**File**: `app/Filament/Resources/ScheduleResource/Pages/ListSchedules.php`

### 6. Fix Generic Type in TaskComment ✅
**File**: `app/Models/TaskComment.php:30`

### 7. Fix Return Type in TaskCompleted Notification ✅
**File**: `app/Notifications/TaskCompleted.php:54`

---

## 📈 Metriche: 58 → 49 errori (-15.5%)

**Status**: 🔄 IN PROGRESS
**Prossimo**: Gdpr (94 errori)

---
title: "Topic activity-pdf"
type: digest
status: active
qmd: "digest ceiling 100 activity-pdf"
---

# Topic activity-pdf

Sintesi automatica di 3 documenti (chiave `activity-pdf`).

## Activity Log PDF Reports

_Fonte: `activity-pdf-reports.md`_

# Activity Log PDF Reports

## 📋 Overview

Guida completa per generare report PDF delle attività utente utilizzando HTML2PDF con integrazione nativa nel modulo Activity.

---

## 🎯 Funzionalità PDF

### 1. Report Attività Utente

Genera report completi delle attività di un utente specifico:

```php
use Modules\Activity\Actions\GenerateActivityPdfAction;

// Generate PDF for user activities
$pdf = app(GenerateActivityPdfAction::class)->execute(
    user: $user,
    dateRange: [
        'start' => now()->subMonth(),
        'end' => now(),
    ],
    filters: [
        'event_types' => ['created', 'updated', 'deleted'],
        'subject_types' => ['App\Models\User', 'App\Models\Post'],
    ]
);

## Activity Log PDF Reports

_Fonte: `bmad/activity-pdf-reports.md`_

# Activity Log PDF Reports

## 📋 Overview

Guida completa per generare report PDF delle attività utente utilizzando HTML2PDF con integrazione nativa nel modulo Activity.

---

## 🎯 Funzionalità PDF

### 1. Report Attività Utente

Genera report completi delle attività di un utente specifico:

```php
use Modules\Activity\Actions\GenerateActivityPdfAction;

// Generate PDF for user activities
$pdf = app(GenerateActivityPdfAction::class)->execute(
    user: $user,
    dateRange: [
        'start' => now()->subMonth(),
        'end' => now(),
    ],
    filters: [
        'event_types' => ['created', 'updated', 'deleted'],
        'subject_types' => ['App\Models\User', 'App\Models\Post'],
    ]
);

## Activity Log PDF Reports

_Fonte: `wiki/features/activity-pdf-reports.md`_

# Activity Log PDF Reports

## 📋 Overview

Guida completa per generare report PDF delle attività utente utilizzando HTML2PDF con integrazione nativa nel modulo Activity.

---

## 🎯 Funzionalità PDF

### 1. Report Attività Utente

Genera report completi delle attività di un utente specifico:

```php
use Modules\Activity\Actions\GenerateActivityPdfAction;

// Generate PDF for user activities
$pdf = app(GenerateActivityPdfAction::class)->execute(
    user: $user,
    dateRange: [
        'start' => now()->subMonth(),
        'end' => now(),
    ],
    filters: [
        'event_types' => ['created', 'updated', 'deleted'],
        'subject_types' => ['App\Models\User', 'App\Models\Post'],
    ]
);

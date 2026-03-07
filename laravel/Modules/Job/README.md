# Job Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Models 16](https://img.shields.io/badge/Models-16-orange.svg)](#modelli)
[![Resources 9](https://img.shields.io/badge/Resources-9-purple.svg)](#filament)

> **Enterprise queue & schedule manager**: 16 modelli, 9 resource Filament, scheduling dinamico da database, gestione multi-coda con priorita, monitoraggio real-time, import/export con tracking errori.

---

## Cosa fa

Il modulo Job gestisce code di lavoro, scheduling e operazioni batch. Lo scheduling avviene da database (niente crontab da editare manualmente), le code supportano priorita multiple, e ogni operazione di import/export viene tracciata con gestione degli errori riga per riga.

```php
// Scheduling dinamico: aggiungi task da Filament, non da crontab
$schedule = Schedule::create([
    'command' => 'survey:export',
    'frequency' => 'daily',
    'parameters' => ['--format' => 'pdf'],
]);

// Monitoraggio code in real-time
$stats = JobManager::getQueueStats();
// -> ['high' => 3, 'default' => 12, 'low' => 45, 'failed' => 2]
```

---

## Architettura

```
Task Scheduling (database-driven)
    |
    +-- Schedule → Frequency → ScheduleHistory
    |
    v
Queue Management (multi-priority)
    |
    +-- high → default → low
    +-- JobBatch (operazioni raggruppate)
    |
    v
Import/Export Tracking
    |
    +-- Import → FailedImportRow (errori riga per riga)
    +-- Export → Result (file generati)
    |
    v
Filament Dashboard (9 Resource + 4 Widget)
```

---

## Modelli (16)

### Queue Management

| Modello | Funzione |
|---------|----------|
| **Job** | Job in coda con payload e attempts |
| **JobManager** | Gestione e statistiche code |
| **JobBatch** | Batch di job raggruppati |
| **JobsWaiting** | Job in attesa di esecuzione |
| **FailedJob** | Job falliti con stack trace |

### Scheduling

| Modello | Funzione |
|---------|----------|
| **Schedule** | Task schedulato con comando e parametri |
| **ScheduleHistory** | Storico esecuzioni con esito |
| **Task** | Task generico con stato |
| **TaskComment** | Commenti su task |
| **Frequency** | Frequenza di esecuzione (cron expression) |
| **Parameter** | Parametri per task/schedule |
| **Result** | Risultato esecuzione |

### Import/Export

| Modello | Funzione |
|---------|----------|
| **Import** | Operazione di importazione con stato |
| **Export** | Operazione di esportazione con file |
| **FailedImportRow** | Riga fallita con errore specifico |

---

## Azioni (7)

| Action | Funzione |
|--------|----------|
| **ExtractTaskCommandAction** | Estrae comando artisan dal task |
| **ManageFrequencyAction** | Gestisce frequenze scheduling |
| **ExecuteTaskAction** | Esegue task programmato |
| **ParseCommandArgumentsAction** | Parsing argomenti comando |
| **ParseCommandOptionsAction** | Parsing opzioni comando |

---

## Filament Integration (9 Resource + 4 Widget)

### Resource

| Resource | Funzione |
|----------|----------|
| **JobResource** | CRUD job in coda |
| **JobManagerResource** | Dashboard gestione code |
| **JobBatchResource** | Gestione batch |
| **JobsWaitingResource** | Job in attesa |
| **FailedJobResource** | Job falliti con retry |
| **ImportResource** | Gestione importazioni |
| **ExportResource** | Gestione esportazioni |
| **FailedImportRowResource** | Errori importazione riga per riga |
| **ScheduleResource** | Gestione scheduling |

### Widget

| Widget | Funzione |
|--------|----------|
| **JobStatsOverviewWidget** | Statistiche code aggregate |
| **JobsWaitingOverviewWidget** | Overview job in attesa |
| **ClockWidget** | Orologio real-time |
| **QueueListenWidget** | Monitor code live |

---

## Scheduling da Database

```php
// Niente piu crontab editing manuale
// Gestisci tutto da Filament admin

// Crea uno schedule
Schedule::create([
    'command' => 'healthcare_app:generate-reports',
    'frequency_id' => Frequency::DAILY,
    'parameters' => json_encode(['--tenant' => 'acme']),
    'is_active' => true,
]);

// Lo storico esecuzioni viene tracciato automaticamente
$history = ScheduleHistory::where('schedule_id', $id)
    ->latest()
    ->get();
// -> [started_at, completed_at, exit_code, output]
```

---

## Multi-Queue con Priorita

```php
// 3 livelli di priorita
// high: operazioni critiche (notifiche, pagamenti)
// default: operazioni standard (export, report)
// low: operazioni batch (pulizia, aggregazione)

dispatch($job)->onQueue('high');
dispatch($job)->onQueue('default');
dispatch($job)->onQueue('low');
```

---

## Import/Export con Error Tracking

```php
// Ogni importazione traccia errori riga per riga
$import = Import::create(['file' => 'users.csv', 'status' => 'processing']);

// Se una riga fallisce, viene salvata con l'errore specifico
FailedImportRow::create([
    'import_id' => $import->id,
    'row_number' => 42,
    'data' => ['email' => 'invalid-email'],
    'error' => 'The email field must be a valid email address.',
]);

// Dashboard Filament mostra tutte le righe fallite con opzione retry
```

---

## Integrazione con altri moduli

```
Job <── healthcare_app    (generazione PDF, export survey)
Job <── Notify     (invio email/SMS massivo)
Job <── Limesurvey (import/export risposte)
Job <── Activity   (pulizia log, aggregazione)
Job <── Tenant     (operazioni per tenant)
```

---

## Quick Start

```bash
php artisan module:enable Job
php artisan migrate

# Avvia il worker
php artisan queue:work --queue=high,default,low

# Verifica le code da Filament admin
```

---

## Metriche

| Metrica | Valore |
|---------|--------|
| **Modelli** | 16 |
| **Azioni** | 7 |
| **Resource Filament** | 9 |
| **Widget Filament** | 4 |
| **Livelli priorita** | 3 (high, default, low) |
| **PHPStan Level** | 10 |

---

**Module Type**: Queue & Schedule Management
**Architecture**: Database-driven scheduling, multi-queue, import/export tracking
**Quality**: PHPStan Level 10, 9 Filament Resource

*Code intelligenti, scheduling da database, import/export tracciato: gestione operazioni enterprise senza toccare il crontab.*

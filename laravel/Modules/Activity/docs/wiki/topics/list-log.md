---
title: "Topic list-log"
type: digest
status: active
qmd: "digest ceiling 100 list-log"
---

# Topic list-log

Sintesi automatica di 3 documenti (chiave `list-log`).

## ListLogActivitiesAction - Documentazione Completa

_Fonte: `actions/list-log-activities-action.md`_

# ListLogActivitiesAction - Documentazione Completa

## Panoramica

`ListLogActivitiesAction` è un'Action Filament completa per visualizzare lo storico delle attività di un record direttamente da una tabella. Fornisce un'interfaccia user-friendly per accedere rapidamente alle informazioni di audit trail.

## Business Logic

L'Action implementa la logica per:

### 1. Visualizzazione Attività Recenti
- Mostra le ultime 5 attività in un modal elegante
- Visualizzazione avatar e nome dell'utente che ha effettuato le modifiche
- Orario formattato delle modifiche
- Indicatore visivo per modifiche vs altre operazioni

### 2. Auto-Discovery Intelligente
- Trova automaticamente la Resource Filament per il modello
- Identifica la pagina delle attività appropriata
- Gestisce casi edge con fallback alla pagina base

### 3. Navigazione Fluida
- Transizione seamless dal modal alla pagina completa
- Mantiene il contesto del record selezionato
- Preserva filtri e ordinamento

## Implementazione Tecnica

### Estensione della Classe Base

## ListLogFilesAction

_Fonte: `contracts/list-log-files-action.md`_

# ListLogFilesAction

Elenca in modo ricorsivo i file `*.log` sotto la cartella dei log, dal più recente al più vecchio.

## Input

- `?string $baseDirectory = null`: cartella da esplorare; `null` usa `storage/logs`.
- `int $limit = 1000`: numero massimo di file; il valore effettivo è `max(1, $limit)`.

## Output

- `list<LogFileData>`: `path` relativo con `/`, `name`, `directory`, `size`, `modifiedAt`; ordinati per `modifiedAt` decrescente, poi per `path`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGLIST-INV-1` | Solo file il cui nome corrisponde a `*.log`; file nascosti (dot) ignorati. | `ListLogFilesActionTest.php` (titolo non letto: copertura da verificare) |
| `ACT-LOGLIST-INV-2` | Un file il cui percorso reale (link risolti) non inizia con la cartella base è scartato. | `ListLogFilesActionTest.php` (copertura da verificare) |
| `ACT-LOGLIST-INV-3` | Se la cartella base non esiste, l'Action restituisce `[]` senza eccezione. | `ListLogFilesActionTest.php` (copertura da verificare) |
| `ACT-LOGLIST-INV-4` | Sono restituiti al massimo `limit` file, i più recenti. | Test: nessuno |

## Effetti collaterali

- Lettura ricorsiva del filesystem. Nessuna scrittura.

## Errori

- Nessuno verso il chiamante: `InvalidLogFileException` diventa `[]`.

## ListLogActivities UI/UX Improvements - 2025-12-04

_Fonte: `list-log-activities-improvements.md`_

# ListLogActivities UI/UX Improvements - 2025-12-04

## Data Intervento: 2025-12-04
# ListLogActivities UI/UX Improvements - [DATE]

## Data Intervento: [DATE]

## Obiettivo

Migliorare la pagina `ListLogActivities` seguendo i principi DRY + KISS e la filosofia Laraxot, con particolare attenzione alla "description" come richiesto.

## Miglioramenti Implementate

### 1. Header Contestuale Informativo

**Prima:** Header assente o minimale
**Dopo:** Header completo con contesto del record e statistiche

```php
@php
    $record = $this->record;
    $recordTitle = method_exists($record, 'getRecordTitle') ? $record->getRecordTitle() : (method_exists($record, 'getName') ? $record->getName() : class_basename($record));
@endphp

<div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-200 dark:border-blue-800">
    <div class="flex items-center gap-3">
        <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" />
        <div>
            <h3 class="text-sm font-medium text-blue-900 dark:text-blue-100">

---
title: "[DEV] PHPStan zero errori - modulo Job"
type: dev-story
status: done
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, job, lessons-learned]
---
# Dev Story - Job 165 -> 0

## Implementation Steps
1. [x] Raggruppo per causa: import persi da `7ae39800`, typo `$retentionDays`, chiavi lang duplicate, test con variabile sbagliata, closure senza tipo
2. [x] Ripristino import (`git show 7ae39800^` solo lettura) e `XotBaseTextColumn` per `ScheduleArguments`
3. [x] `JobManager::prunable()`, `lang/it/job.php`, `FormatSecondsTest`, tipi closure
4. [x] `phpstan analyse Modules/Job` = 0

## Lessons Learned
- Un errore `class.notFound ... Modules\X\Filament\Resources\TextInput` = `use` mancante, non classe cancellata.
- Risolvere i marker di merge tenendo "un lato" scarta anche i suoi `use`: riverificare gli import.
- Chiavi duplicate in un array `lang` = merge che ha riaggiunto lo stesso blocco: confrontare i valori, tenere la forma estesa.

## Decisioni aperte
- **`Schedule.status`**: migrazione `boolean('status')->default(true)` ma cast `Status::class` (backed enum string `active|inactive|trashed|1`). `1` -> `Status::One`, `0` -> `Status::from('0')` = `ValueError`. Non toccato (nessun errore PHPStan; serve decidere se la colonna diventa string o se l'enum ha un case `'0'`).
- `JobManager::prunable()`: `config('jobs.pruning.retention_days')` da env arriva spesso come stringa -> `is_int` fallisce e ricade su 365. Non toccato.
- Docs `dry-kiss-analysis-conflict.md`, `dry-kiss-analysis-job-module.md`, `dry-kiss.md` contengono ancora marker di merge; `dry-kiss-analysis-modulo-job.md` e `dry-kiss-analysis-modulo-job-scores.md` hanno lo stesso contenuto (duplicato, da unire senza cancellare).

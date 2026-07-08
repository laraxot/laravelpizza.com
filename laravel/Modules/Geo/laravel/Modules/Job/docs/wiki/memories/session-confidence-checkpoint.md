---
title: checkpoint confidenza sessione Job
type: memory
module: Job
tags: [confidence, phpstan, merge, handoff]
updated: 2026-05-26
related:
  - ../log.md
  - ../../merge-conflicts-list.md
  - ../../code-redundancy-audit.md
  - ../../../../../../docs/chat/handoff-job-lang-merge-phpstan-confidence.md
---

# Checkpoint confidenza — modulo Job

Memoria operativa per ripartire domani senza perdere contesto.

## Stato codice (verificato)

- Marcatori merge in `app/**/*.php`: **assenti** (sweep HEAD 2026-05-26).
- PHPStan `Modules/Job` da mono `laravel/`: **0 errori** dopo fix elencati sotto.
- Pattern policy: `class XxxPolicy extends JobBasePolicy {}` — autorizzazione in `JobBasePolicy::before()`.

## File toccati (riferimento rapido)

| Path | Nota |
|------|------|
| `app/Models/Policies/*.php` (16) | Una policy per modello; logica in policy file o `JobBasePolicy::before()` — **non eliminare** |
| `app/Providers/JobServiceProvider.php` | Parse fix; queue hooks commentati |
| `app/Filament/Resources/.../Tables/JobsTable.php` | HEAD, colonne keyed static |
| `app/Filament/Resources/.../Tables/FailedJobsTable.php` | idem |
| `app/Filament/Resources/.../Tables/JobBatchesTable.php` | HEAD, instance `getTableColumns` |
| `app/Filament/Resources/.../Schemas/JobBatchForm.php`, `ScheduleForm.php` | HEAD |
| `app/Filament/Resources/ScheduleResource/Tables/SchedulesTable.php` | `@return array<string, Column>` |
| `app/Filament/Resources/FailedImportRowResource/Tables/FailedImportRowsTable.php` | idem |

## Issue modulo

Numeri noti dalla sessione: **#12** (PHPStan), **#13** (ridondanza/discussione).

Per URL e owner: dalla cartella del modulo eseguire `git remote -v` — **non** usare link fissi a organizzazioni nel wiki locale.

## Debito / dubbi dichiarati

- `JobBatchsTable.php` vs `JobBatchesTable.php` — quale è wired nella Resource?
- `registerQueue()` disabilitato: design metriche job non definito.
- Template `merge-conflicts-list.md` elenca ancora path altri moduli — filtrare solo Job o rigenerare lista locale.

## Prossimo passo minimo

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Job --memory-limit=2G
```

Se OK → Lang duplicate keys o sync verso repo da `git remote -v`.

## Collegamenti

- [code-redundancy-audit.md](../../code-redundancy-audit.md)
- [xotbase-table-columns-enforcement.md](../concepts/xotbase-table-columns-enforcement.md)
- Handoff root: [docs/chat/handoff-job-lang-merge-phpstan-confidence.md](../../../../../../docs/chat/handoff-job-lang-merge-phpstan-confidence.md)

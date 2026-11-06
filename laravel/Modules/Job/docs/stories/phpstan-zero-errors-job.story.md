---
title: "[STORY] PHPStan zero errori - modulo Job"
type: story
status: done
priority: high
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, job, merge-conflict, filament, bmad]
---
# Story: PHPStan zero errori - modulo Job

## User Request
Swarm PHPStan Modules: azzerare gli errori di `laravel/Modules/Job` risolvendo la causa, non l'errore (brief condiviso del 2026-10-28).

## Analysis
Baseline: **165 errori** in 10 file (120 in `app/`). Una sola causa maggiore: il commit `7ae39800` ("." - rimozione dei marker di merge) ha lasciato file senza i `use` del lato scartato.
- `ScheduleArguments extends TextColumn` senza import, `ImportResource`, `FailedImportRowResource`, `ScheduleResource` senza gli import Filament (`TextInput`, `Select`, `Section`, `Get`, `Set`, `Repeater`, ...), `GetCommandsAction`, `Corn`, `Assert`: classi risolte nel namespace del file (`Modules\Job\Filament\Resources\TextInput`) -> `class.notFound` e, a cascata, ~65 `method.nonObject` (tipo `mixed` da classe sconosciuta). Ripristinati gli import come in `git show 7ae39800^`; la colonna estende `XotBaseTextColumn` (regola Xot: mai Filament nudo).
- `ScheduleArgumentsProbe::make()` (11) e le proprieta' `$fakeState` (mixed): stessa causa, la fixture eredita da `ScheduleArguments` che era rotta.
- `JobManager::prunable()`: il merge teneva `$retentionDays` (HEAD) nell'uso e `$retention_days` (theirs) nell'assegnazione -> variabile mai definita, e **la retention configurata veniva ignorata** (`Undefined variable` = `null` -> `subDays(null)`). Unificata su `$retentionDays`.
- `lang/it/job.php`: 6 chiavi duplicate (`scheduled_at`, `started_at`, `finished_at`, `error_message`, `retry_count`, `max_retries`) reintrodotte dal lato HEAD con contenuto identico al blocco esteso gia' presente; tenuto il blocco esteso, mantenuta la sola chiave nuova `value`.
- `FormatSecondsTest`: `$probe` assegnato ma letto `$formatter` (variabile mai definita): test che non asseriva nulla. Rinominata; aspettative verificate a mano sul trait (`1 m 30 s`, `2 h 0 m 0 s`).
- `typeCoverage.paramTypeCoverage`: closure senza tipo in `GetCommandsAction` (`InputArgument`/`InputOption`) e `GetTaskCommandsAction` (`Command`, tolto il `@var` che mentiva).

## Result
`./vendor/bin/phpstan analyse Modules/Job --memory-limit=-1` : **165 -> 0 errori** (exit 0). `php -l` pulito sui file toccati. **Pest non eseguito** (`.env.testing` = MySQL).

## Acceptance Criteria
- [x] PHPStan Modules/Job = 0 errori, senza ignore/baseline/`phpstan.neon` toccato
- [x] Nessun file cancellato; nessun commit
- [x] `docs/dry-kiss-analysis-2025-10-15.md` rinominato `dry-kiss-analysis-modulo-job-scores.md` (data in frontmatter)
- [ ] Pest `ScheduleArgumentsTest` / `FormatSecondsTest` in sqlite
- [ ] Decisione su `Schedule.status` (vedi dev-story)

## GitHub
### Issues
- TODO (gh non installato)
### Discussions
- TODO

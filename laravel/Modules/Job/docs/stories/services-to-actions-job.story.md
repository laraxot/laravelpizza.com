---
title: "[STORY] Services -> Actions nel modulo Job (ScheduleService)"
type: story
status: done
priority: medium
created: 2026-10-08
updated: 2026-10-08
module: Job
tags: [bmad, services, queueable-actions, no-services-rule, schedule, cleanup]
qmd: "job ScheduleService residuo GetActiveSchedulesAction ClearScheduleCacheAction duplicati Actions Schedule"
related:
  - ./job-services-to-actions.story.md
  - ../../../../bmad-output/epic-code-standards-services-mixed-const.md
  - ../../../../bashscripts/ai/wiki/rules/no-services-rule.md
---

# Services -> Actions nel modulo Job

## Richiesta

Ordine permanente (2026-10-08): nessun `app/Services` ne' classe `*Service`; ogni use case e' una Queueable Action con
tutti i chiamanti aggiornati.

## Analisi (lo scopo, non il messaggio)

`Services/ScheduleService` (commit `431b5e66`, 2026-10-07) risolve il model da `config('job::model')` e offre due use
case: elenco dei `Schedule` attivi (con cache opzionale `job::cache.*`) e svuotamento di quella cache. La story di
settembre [`job-services-to-actions`](./job-services-to-actions.story.md) li aveva gia' spostati sulle Action; il
file e' ricomparso.

| Metodo del Service | Action che lo copre gia' | Chiamanti di produzione |
|---|---|---|
| `getActives()` / `getFromCache()` | `Actions/GetActiveSchedulesAction` (identica, stesso `config('job::model')`) | nessuno (solo test) |
| `clearCache()` | `Actions/ClearScheduleCacheAction` | `Observers/ScheduleObserver`, `Console/Commands/ScheduleClearCacheCommand` |

`ScheduleService` non aveva alcun chiamante nel codice (`rg` su Modules, Themes, app, config, resources, anche Blade): l'unico
riferimento era `tests/Unit/Services/ScheduleServiceTest.php`, che controllava via reflection che la classe fosse
istanziabile, avesse un certo namespace e un metodo privato: nessun comportamento.

## Modifiche

- Eliminati (recuperabili da `HEAD` di `Modules/Job`): `app/Services/ScheduleService.php` (+ `.php.bak` tracciato),
  `tests/Unit/Services/ScheduleServiceTest.php` (+ `.php.bak` tracciato); directory `app/Services/` rimossa.
- Nessun chiamante da aggiornare; nessuna `const` nel perimetro.

## Verifica

- `rg ScheduleService` / `Modules\Job\Services` su `laravel/Modules`, `Themes`, `app`, `config`, `routes`,
  `resources`, `tests` (esclusi docs/vendor): zero risultati.
- PHPStan (`phpstan.neon`, da `laravel/`) su `Modules/Job/app/Actions`: `[OK] No errors` (esecuzione unica per i cinque moduli, dettaglio nella story Media).

## Aperto

- Duplicati dentro `app/Actions`: `GetActiveSchedulesAction` e `ClearScheduleCacheAction` esistono due volte, in
  `Actions/` e in `Actions/Schedule/`. Il codice e' uguale tranne che la copia in `Schedule/` ignora `config('job::model')`
  e usa `Schedule::query()`. Le produzioni (`ScheduleObserver`, `ScheduleClearCacheCommand`) usano la copia in `Actions/`.
  Fuori perimetro di questa story: consolidare in una sola (quella con `config('job::model')`) aggiornando
  `tests/Unit/Actions/Schedule/ScheduleActionsTest.php`.
- `GetActiveSchedulesAction` non ha chiamanti di produzione: chi pianifica gli `Schedule` attivi non la usa. Verificare
  che il caricamento degli schedule attivi non ignori la cache configurata.

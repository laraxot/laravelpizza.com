---
title: "[STORY] PHPStan cleanup — Job"
type: story
module: Job
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, job]
---

# [STORY] PHPStan cleanup — Job

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo Job. Errori di partenza: 3 `constantTypeCoverage` (`Schedule::STATUS_*`), 1 `variable.unused` (JobBasePolicy), 1 `variable.unused` (test provider), 2 `missingType.generics` (test con classe anonima).

## Analysis

**Scopo del codice.** `Schedule` e' una voce di scheduler (comando + espressione cron) gestita da Filament; `GetActiveSchedulesAction`/`ScheduleService`
leggono le voci *attive* per registrarle. Lo stato e' gia' un enum (`Modules\Job\Enums\Status`, cast in `Schedule::casts()`, usato da
`ScheduleObserver`, dai test e dalla tabella), ma le tre costanti intere `STATUS_INACTIVE=0/ACTIVE=1/TRASHED=2` erano rimaste e **contraddicevano il cast**:
`scopeActive()` cercava `status = 1` mentre il codice scrive `'active'`/`'inactive'`/`'trashed'`. Nessun consumatore esterno (grep su `Modules`/`Themes`).

Soluzione: riuso di `Status` (nessun enum nuovo), costanti rimosse.
- `Status::activeCases()` / `isActive()`: `Active` **e** `One` (il valore legacy `'1'`, default booleano della colonna nella migration) rendono lo Schedule eseguibile.
- `scopeActive()` -> `whereIn('status', Status::activeCases())`; `scopeInactive()` -> `Status::Inactive`; `Actions/Schedule/GetActiveSchedulesAction` usa lo scope invece di ripetere il `where`.

`JobBasePolicy::before()` assegnava `$xotData = XotData::make()` senza leggerlo (aggiunto da un commit meccanico "migrate to instance-based schema"): la logica reale e' solo il bypass `super-admin`. Rimosso.

`JobProvidersCoverageTest` istanziava `AdminPanelProvider` senza usarlo: ora l'istanza e' verificata (valore reale della proprieta' `module`, non solo il default).
`JobScheduleFormCoverageTest` usava una classe anonima con `DataCollection<int, CommandData>`: sostituita da `tests/Fixtures/StubGetCommandsAction` (classe con nome, vedi Lessons).

## Acceptance Criteria

- [x] Nessuna costante `STATUS_*` in `Schedule`; lo stato e' sempre `Status` (cast, scope, action, observer)
- [x] `scopeActive()` include `Status::Active` e il legacy `One`
- [x] `JobBasePolicy` senza variabile morta; test che usano le variabili dichiarate
- [x] Nessuna classe anonima con tipi iterabili/generici nei test segnalati
- [x] PHPStan: 0 errori sul modulo Job (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [2026-10-06-phpstan-cleanup-job.dev.md](./2026-10-06-phpstan-cleanup-job.dev.md)

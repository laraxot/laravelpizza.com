---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-23
qmd: "no services no support queueable actions"
issues: []
discussions: []
title: No Services/No Support: QueueableAction
status: draft
---

# Regola

`app/Services/` e `app/Support/` non esistono in questo modulo. Ogni logica di dominio vive in `app/Actions/{Contesto}/FooAction.php`, con `use Spatie\QueueableAction\QueueableAction;` e unico metodo pubblico `execute()`.

## Conversione 2026-07-20

- `app/Services/ScheduleService.php` (2 responsabilità) → due Action in `app/Actions/` (radice, nessuna sotto-cartella):
  - `GetActiveSchedulesAction` (era `getActives()` + `getFromCache()` privato)
  - `ClearScheduleCacheAction` (era `clearCache()`)
- Caller: `ScheduleObserver::clearCache()`, `ScheduleClearCacheCommand::handle()` → `app(Modules\Job\Actions\ClearScheduleCacheAction::class)->execute()`.
- Il test reflection-only del vecchio Service e quello di `GetActiveSchedulesAction` sono stati rimossi; resta
  `tests/Unit/Actions/ClearScheduleCacheActionTest.php` (reflection: trait `QueueableAction` + metodo `execute()`).

## Stato dei duplicati (verificato il 2026-10-23)

Non esiste una cartella `app/Actions/Schedule/` nel working tree: i doppioni `Schedule/` descritti in una
versione precedente di questa nota non ci sono piu'. `ClearScheduleCacheAction` e' l'action live usata da
`ScheduleObserver` e `ScheduleClearCacheCommand`. `GetActiveSchedulesAction`
(`app/Actions/GetActiveSchedulesAction.php`) esiste ancora ma non ha caller applicativi ne' test: candidata
alla rimozione, da fare solo dopo un nuovo `grep -rn GetActiveSchedulesAction` su tutto `laravel/`.

## Perché

Un Service con due responsabilità indipendenti (lettura cache vs invalidazione cache) diventa due Action mono-responsabilità: più facile testare, più facile capire chi chiama cosa, nessuno stato condiviso tra le due operazioni.

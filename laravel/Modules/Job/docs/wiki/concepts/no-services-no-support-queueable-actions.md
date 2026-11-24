---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "no services no support queueable actions"
issues: []
discussions: []
title: No Services/No Support — QueueableAction
---

# Regola

`app/Services/` e `app/Support/` non esistono in questo modulo. Ogni logica di dominio vive in `app/Actions/{Contesto}/FooAction.php`, con `use Spatie\QueueableAction\QueueableAction;` e unico metodo pubblico `execute()`.

## Conversione 2026-07-20

- `app/Services/ScheduleService.php` (2 responsabilità) → due Action distinte in `app/Actions/Schedule/`:
  - `GetActiveSchedulesAction` (era `getActives()` + `getFromCache()` privato)
  - `ClearScheduleCacheAction` (era `clearCache()`)
- Caller aggiornati: `ScheduleObserver::clearCache()`, `ScheduleClearCacheCommand::handle()` → `app(Modules\Job\Actions\Schedule\ClearScheduleCacheAction::class)->execute()`.
- Test `tests/Unit/Services/ScheduleServiceTest.php` (reflection sul vecchio Service) archiviato in `.bak`; sostituito da `tests/Unit/Actions/Schedule/ScheduleActionsTest.php` che verifica trait `QueueableAction` + metodo `execute()` su entrambe le Action in `app/Actions/Schedule/`.

## ⚠️ Duplicati orfani non risolti

Oltre alle due Action in `app/Actions/Schedule/` (quelle realmente usate dai caller), esistono **due classi omonime a livello root** di `app/Actions/`, non referenziate da nessun caller applicativo:

- `Modules\Job\Actions\GetActiveSchedulesAction` (app/Actions/GetActiveSchedulesAction.php) — variante con `$model` risolto nel costruttore invece che in `getModel()` privato.
- `Modules\Job\Actions\ClearScheduleCacheAction` (app/Actions/ClearScheduleCacheAction.php) — identica a quella in `Schedule/`.

Entrambe hanno anche test propri (`tests/Unit/Actions/GetActiveSchedulesActionTest.php`, `tests/Unit/Actions/ClearScheduleCacheActionTest.php`) che le tengono "verdi" e nascondono la duplicazione. La migrazione a QueueableAction è completa nel senso che non esistono più `app/Services/` o `app/Support/`, ma la cancellazione dei doppioni root non è mai stata fatta. Non toccare senza verificare prima con `grep -rn` tutti i caller reali (vedi sopra): solo le classi in `Actions/Schedule/` sono agganciate a Observer e Command.

## Perché

Un Service con due responsabilità indipendenti (lettura cache vs invalidazione cache) diventa due Action mono-responsabilità: più facile testare, più facile capire chi chiama cosa, nessuno stato condiviso tra le due operazioni.

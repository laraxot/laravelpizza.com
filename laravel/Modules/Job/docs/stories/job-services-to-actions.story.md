---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "job services to actions.story"
issues: []
discussions: []
id: story-job-services-to-actions
slug: job-services-to-actions
status: done
priority: high
title: "Convertire app/Services in QueueableAction sotto app/Actions (modulo Job)"
created_at: 2026-09-04
updated_at: 2026-09-04
bmad_phase: dev
module: Job
related:
  - "../../../../bashscripts/ai/wiki/rules/no-services-rule.md"
  - "../../../Tenant/docs/concepts/tenant-service-to-actions-migration.md"
  - "../../../../docs/chat/module-job-sync.md"
---

# JOB — Services → Actions

## Contesto

Regola "RELIGION" (`bashscripts/ai/wiki/rules/no-services-rule.md`): nessuna classe
`app/Services/*Service` per business logic, tutto deve essere una
`Spatie\QueueableAction\QueueableAction` con un unico entrypoint `execute(...)` sotto
`app/Actions/<Contesto>/`.

Censimento iniziale (`find Modules/Job/app/Services -name "*.php"`): **un solo file**,
`app/Services/ScheduleService.php` (59 righe, 2 metodi pubblici: `getActives()`,
`clearCache()`, + `getFromCache()` privato).

## Collisione trovata prima di iniziare (importante per chi legge dopo)

`git status --short` mostrava gia' ~177 file modificati non committati da altre sessioni
(vedi `docs/chat/module-job-sync.md`, `docs/stories/4.29.mixed-type-reduction.story.md`).
**Durante l'esecuzione di questo stesso task**, un'altra sessione concorrente stava
lavorando esattamente sullo stesso file (`ScheduleService.php`) in tempo reale:

1. Al primo `find`/`cat`, `app/Services/ScheduleService.php` esisteva ancora con contenuto
   completo (statico, non-QueueableAction).
2. Un minuto dopo, `git status --short` lo mostrava `D` (deleted) — l'altra sessione lo
   aveva rimosso mentre verificavo i call site.
3. Al `git log`, la coppia `app/Actions/Schedule/GetActiveSchedulesAction.php` +
   `app/Actions/Schedule/ClearScheduleCacheAction.php` risultava **gia' committata** in
   HEAD (`634d334 chore: checkpoint repository cleanup`), con trait `QueueableAction` e
   `execute()` corretti, praticamente identica (a meno di stile: costruttore vs metodo
   privato `getModel()`) a `app/Actions/GetActiveSchedulesAction.php` /
   `ClearScheduleCacheAction.php` (flat, root di `Actions/`) — **anch'esse gia' committate
   in HEAD**, insieme ai relativi test in `tests/Unit/Actions/*Test.php` E
   `tests/Unit/Actions/Schedule/ScheduleActionsTest.php`.

Cioe': due sessioni concorrenti avevano gia' fatto la stessa migrazione due volte, in due
posizioni diverse (`Actions/` flat e `Actions/Schedule/` raggruppata), entrambe committate
in HEAD, con la Service class ancora presente accanto a entrambe finche' la seconda
sessione non l'ha rimossa mentre questa story era in corso.

## Cosa e' stato fatto in questa story (consolidamento)

La regola e' esplicita: "Le Actions sono raggruppate per attore o contesto
(`Actions/Config/`, `Actions/Article/`), non accumulate nella root." → la versione
corretta e' `app/Actions/Schedule/*`, non la copia flat in `app/Actions/`.

| File | Kind | Origine → Destinazione | Motivazione |
|---|---|---|---|
| `app/Services/ScheduleService.php` | A (god-service in miniatura, 2 metodi) | Rimosso (gia' rimosso da sessione concorrente durante questo task; nessun caller residuo verificato via grep repo-wide) | Sostituito 1:1 da `GetActiveSchedulesAction` + `ClearScheduleCacheAction` |
| `ScheduleService::getActives()` | A | → `Modules\Job\Actions\Schedule\GetActiveSchedulesAction::execute()` | Un metodo = una Action, stessa logica (cache-aware get), grouped by context |
| `ScheduleService::clearCache()` | A | → `Modules\Job\Actions\Schedule\ClearScheduleCacheAction::execute()` | idem |
| `app/Actions/GetActiveSchedulesAction.php` (flat, duplicato) | n/a | **Rimosso** | Duplicato non raggruppato di `Actions/Schedule/GetActiveSchedulesAction.php`; zero call site reali oltre al proprio test |
| `app/Actions/ClearScheduleCacheAction.php` (flat, duplicato) | n/a | **Rimosso**, caller aggiornati | Duplicato non raggruppato di `Actions/Schedule/ClearScheduleCacheAction.php`; era l'unica versione con call site reali (`ScheduleClearCacheCommand`, `ScheduleObserver`) — migrati alla versione raggruppata |
| `tests/Unit/Actions/GetActiveSchedulesActionTest.php` | n/a | **Rimosso** | Ridondante con `tests/Unit/Actions/Schedule/ScheduleActionsTest.php` (stessa asserzione: instantiable + `execute()` + trait `QueueableAction`) |
| `tests/Unit/Actions/ClearScheduleCacheActionTest.php` | n/a | **Rimosso** | idem |
| `tests/Unit/Services/ScheduleServiceTest.php` | n/a | Rimosso (gia' rimosso dalla sessione concorrente) | Testava la classe ormai retired |
| `app/Services/ScheduleService.php.bak`, `tests/Unit/Services/ScheduleServiceTest.php.bak` | n/a | **Rimossi** | Backup stray tracciati in git della classe/test ritirati, cruft diretto del task |

Nessun altro file sotto `app/Services/` esisteva nel modulo (verificato: `find
Modules/Job/app/Services -name "*.php"` → un solo risultato prima dell'intervento).
`app/Services/` e' ora vuota (solo `.php.bak` rimosso).

## Call site aggiornati

- `app/Console/Commands/ScheduleClearCacheCommand.php`: `use
  Modules\Job\Actions\ClearScheduleCacheAction;` → `use
  Modules\Job\Actions\Schedule\ClearScheduleCacheAction;`
- `app/Observers/ScheduleObserver.php`: idem.

Nessun call site cross-modulo: `grep -rn "ScheduleService\|Modules\\\\Job\\\\Services"
Modules --include="*.php"` su tutto `Modules/` → zero risultati (anche prima
dell'intervento: la Service era gia' de facto morta, zero caller oltre se stessa).

## Verifica

- `php -l` pulito su tutti i file toccati.
- `./vendor/bin/phpstan clear-result-cache && ./vendor/bin/phpstan analyse Modules/Job
  --no-progress --error-format=table`: **0 errori prima → 0 errori dopo**.
- `./tools/phpmd.sh Modules/Job text ../docs/phpmd.ruleset.xml`: nessun finding nuovo;
  `ScheduleObserver.php` mostra solo `CamelCaseParameterName`/`UnusedFormalParameter` su
  `$_schedule`, pre-esistente, riga non toccata da questa story (solo lo `use` in testa al
  file e' cambiato).
- `./vendor/bin/pest Modules/Job/tests -c Modules/Job/phpunit.xml --no-coverage`: fallisce
  al bootstrap (`Cannot open bootstrap script
  ".../Modules/Job/vendor/autoload.php"`) — causa pre-esistente e non correlata
  (`phpunit.xml` fa parte del WIP non committato di un'altra sessione, gia' documentato in
  `docs/coverage.md` § 2026-09-04 mixed-type-reduction). Non risolto, non nello scope di
  questa story.

## Perche' non e' stata forzata una Action anche per le classi Kind B

Il modulo Job ha altre classi sotto `app/Actions/**` che sono Strategy/Handler (es.
`app/Actions/Console/GetScheduleStatusCommandsAction.php`, che ha gia' `execute()` — non
sotto scrutinio qui) ma **nessuna** di queste viveva sotto `app/Services/`: il censimento
iniziale ha trovato un solo file, gia' classificato sopra. Non c'era quindi nessun caso
Kind B da valutare in questa story.

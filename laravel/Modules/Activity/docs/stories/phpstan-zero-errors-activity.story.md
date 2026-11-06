---
title: "[STORY] PHPStan a zero su Modules/Activity (rebase in corso che ha sovrascritto il modulo)"
type: story
status: done
priority: high
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, activity, rebase, log-viewer, fixtures, swarm]
---
# Story: PHPStan a zero su Modules/Activity

## User Request
Swarm PHPStan sui Modules: zero errori risolvendo la causa, non l'errore. Per Activity: 383 errori in 16 file, 343 nei test.
Domande esplicite: perche' `Adapters\ActivityLogger` e `LogViewer` non esistono piu', se la rimozione e' voluta, e dove sono le fixture `*Harness`.

## Analysis
**Causa radice unica: il repo del modulo e' in un rebase interattivo fermo** (`git -C laravel/Modules/Activity status` →
"interactive rebase in progress; onto 7083148f", ancora 4 `pick` da fare). Il commit `36463864` (28/10 15:32, messaggio ".") e'
un auto-commit del working tree *durante* il conflitto sul `pick 83de853d` (24/09). Rispetto a `onto` (cartelle `app tests resources lang routes config database`)
mancavano 71 file e altri 135 erano tornati a versioni di fine settembre (`git diff --name-status 7083148f HEAD`). Nessuno spostamento voluto.

Prove:
- `git diff e7fdd97b 7083148f` e' vuoto: `dev` locale (`orig-head`) e `onto` hanno lo stesso albero, quindi l'albero giusto a fine rebase e' `7083148f`.
- In `7083148f` esistono ancora `Adapters\ActivityLogger` (coordinatore che delega alle Action) **e** `Actions\ActivityLogger` (duplicato legacy: vedi
  `activity-mixed-type-reduction.story.md`), il `LogViewer` con le 9 Action `Log/`, i 6 Data + `InvalidLogFileException`, le fixture `*Harness`, `README`/`docs/README.md` che
  li descrivono e la voce `wiki/log.md` del 2026-09-20 che documenta la pagina `/activity/admin/log-viewer`.
- Il commit lasciava mezzo restaurato: `BuildLogViewerStateAction`, `LogViewerStateData`, `log-viewer.blade.php` e `LogViewerPageTest` erano rimasti, ma senza le classi da cui dipendono (25 + 8 + 13 + 86 errori `class.notFound`).
- Cosi' si spiegano le famiglie di errore: `class.notFound` (Adapters, LogViewer, Log/*, Datas, fixture), `new.noConstructor`/`arguments.count`
  (le Action `LogModel*`/`LogUser*` tornate a `execute($model)` senza costruttore mentre i test usano `new X($model, $user)`), `mixed`
  a cascata (da `class.notFound` a monte), `json_encode` non-Safe (import `Safe\json_encode` perso in `ListLogActivities`).
- Gia' documentato un incidente analogo il 2026-10-08 (`decision-log.md`: "copia vecchia fusa"): le firme con `UserContract` (non la classe concreta `User`) servono agli utenti `Quaeris`.

Decisione (c) del brief: **la funzionalita' manca per errore** → ricostruita in avanti (letta la history, riscritta sullo stato corrente; nessun `checkout/restore`).

## Result
`phpstan analyse Modules/Activity` (config `laravel/phpstan.neon`, nessun `-c`/`--level`): **383 (baseline) / 380 (misurato all'inizio) → 0 errori** (verificato dopo l'ultima modifica).
Pest **non eseguito**: `.env.testing` punta a MySQL.

Cosa e' cambiato (vedi `.dev.md` per il dettaglio):
- Log viewer ricostruito: `lang/{it,en}/log_viewer.php`, pagina Folio `resources/views/pages/api/log-download.blade.php`, 7 test `Unit/Actions/Log/*` + `Feature/Filament/LogDownloadPageTest.php` riscritti dallo stato precedente; Action/Data/Page/fixture sono stati rimessi nel working tree da un altro attore durante la sessione (non da questo agent).
- `LogActivityAction` e `Actions\ActivityLogger` allineati a `UserContract` (prima: classe concreta `User`, il parametro `$user` di `created/updated/deleted` veniva ignorato).

## Acceptance Criteria
- [x] `phpstan analyse Modules/Activity` = 0 errori, senza `@phpstan-ignore`, baseline o `ignoreErrors`
- [x] Nessun file cancellato da questo intervento; `phpstan.neon` non toccato
- [x] LogViewer: Action, Data, eccezione, pagina, lang, download Folio e test presenti
- [x] `Actions\LogActivityAction` accetta `UserContract` (messaggio `User must implement UserContract`, atteso da `QueryAndValidationTest`)
- [ ] Pest in sqlite (non eseguito)
- [ ] Rebase del repo del modulo concluso/abortito dall'utente e ~120 file ancora diversi da `7083148f` riallineati (vedi Decisioni aperte)

## Decisioni aperte
1. **Rebase fermo**: l'esito corretto e' l'albero di `7083148f`. Resta diverso: migrazioni, ~25 file `lang/*`, viste, `routes/*`, ~100 test e alcuni file `app/` (Filament Resources, Models, Listener). Va deciso dall'utente (`git rebase --abort` o `--skip` dei pick rimanenti); gli agent non lo fanno (regola `git-forward-only`).
2. **Due `ActivityLogger`** (`Adapters\` e `Actions\`): duplicato noto, non unificato (fuori scopo).
3. Le Action `LogModelCreated/Updated/Deleted/LogUserLogin/Logout` accettano ora **sia** il costruttore sia `execute($model)` (compatibilita' fra test di due epoche): una volta scelto l'albero finale va tenuta una sola forma.
4. `docs/wiki/log.md` contiene ancora marcatori di conflitto (`<<<<<<< HEAD`) dal rebase: non risolto qui.

## GitHub
### Issues
- TODO (`gh` non installato)
### Discussions
- TODO

Owner: AI Agent (swarm PHPStan)
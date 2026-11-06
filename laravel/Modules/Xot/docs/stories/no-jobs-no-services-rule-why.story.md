---
title: "Mai app/Jobs ne' app/Services: il perche' nella regola, eccezioni e guardie"
type: story
module: Xot
status: review
created: 2026-10-23
updated: 2026-10-23
tags: [queueable-action, no-jobs, no-services, regole, guardie]
qmd: "no jobs no services queueable action perche eccezioni filament export notification guardie NoJobsTest NoServicesTest involucro"
related:
  - ../../../../../bashscripts/ai/wiki/rules/no-module-jobs-queueable-action.md
  - ../../../../../bashscripts/ai/wiki/rules/no-services-rule.md
  - ../../tests/Unit/Architecture/NoServicesTest.php
  - ../../tests/Unit/Architecture/NoJobsTest.php
---

# Mai app/Jobs ne' app/Services

## Perche'

L'utente (2026-10-23): niente `app/Jobs/` ne' `app/Services/` nei moduli, al loro posto Spatie Queueable Actions; capire il perche'. La regola esisteva (`no-module-jobs-queueable-action.md`, 5 copie) ma diceva solo cosa, non perche', e nessun test la faceva rispettare.

Il perche' (ora nella regola): un caso d'uso, una classe; mettere in coda e' una scelta di chi chiama (`execute()` / `onQueue()->execute()`); si testa chiamando `execute()`. Eccezioni: job che e' il framework a mettere in coda (`Modules/Xot/app/Exports/Jobs/*` estendono `Filament\Actions\Exports\Jobs\*`), Notification e Mailable `ShouldQueue`, pacchetti di terzi copiati.

## Fatto in questa sessione

| File | Modifica |
|------|----------|
| `bashscripts/ai/wiki/rules/no-module-jobs-queueable-action.md` | sezioni Perche', Eccezioni, Guardie; link `related` corretti (erano corti di due `../`, uno puntava a un file inesistente) |
| 3 copie `.mdc` (radice, `11-forms/`, `laravel/`) | il «Canon» puntava a `laravel/Modules/docs/QUEUEABLE-ACTION-RULE.md`, inesistente: ora alla regola canonica |
| `bashscripts/docs/prompts/11-phpstan.md` | criteri di completamento: «Services/Jobs-to-Actions», `mixed` come ultima spiaggia (non «nessun mixed»), tolti `MassExtra/FunctionExtra` (non esistono ne' qui ne' in ptvx) |
| docs dei moduli che insegnavano `make:job` / `app/Jobs/` | 50 file esaminati dagli agenti dei lotti docs: 10 riscritti sul modello Action, 35 storici lasciati, 5 gia' conformi |

Stato misurato: nessuna cartella `app/Jobs` o `app/Services` in moduli e temi; `NoServicesTest` 7 verdi, `NoJobsTest` 2 verdi, `DatasFolderConventionTest` 2 verdi (11 test, 12 asserzioni).

## Da decidere / segnalato

- `NoServicesTest` (test Jobs/Servces aggiunti alle 15:15:26) e `NoJobsTest.php` (15:15:30) sono stati scritti da due sessioni nello stesso minuto: si sovrappongono su cartella e namespace; `NoJobsTest` controlla anche i `use`. Tenerne uno solo richiede di cancellare un test: serve l'approvazione dell'utente.
- `Modules/Comment/app/Actions/SendNotificationsForPendingCommentAction.php`: Action che si limita ad accodare `Notification\SendNotificationsForPendingCommentAction` (0 chiamanti; le config usano direttamente quella in `Notification\`). E' lo stesso involucro che la regola vieta ai Job. Lavoro in corso di un'altra sessione (conversione di `Comment/app/Jobs`, 15:12): non toccato.
- `config/test/fixcity/comments.php` usa l'Action del pacchetto Spatie copiato, le altre config quella del modulo: test e sviluppo eseguono classi diverse.
- `bashscripts/ai/wiki/rules/11-forms/` e' un'intera copia dell'albero delle regole (1.451 file: 300 identici alla radice, 23 solo li', il resto divergente): quale sia canonica va deciso prima di consolidare.

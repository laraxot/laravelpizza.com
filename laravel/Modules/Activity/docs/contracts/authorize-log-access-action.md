---
title: "Contratto — AuthorizeLogAccessAction"
type: contract
action: "Modules\Activity\Actions\Log\AuthorizeLogAccessAction"
tags: [contract, action, log-viewer, authorization]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/log-viewer-single-path-resolver.md
  - ../../app/Actions/Log/AuthorizeLogAccessAction.php
  - ../../app/Filament/Pages/LogViewer.php
  - ../../tests/Unit/Actions/Log/AuthorizeLogAccessActionTest.php
---

# AuthorizeLogAccessAction

Chi può consultare e scaricare i file di log dal pannello. Una sola regola per la pagina (`LogViewer::canAccess()`) e
per il download. Sorgente: `app/Actions/Log/AuthorizeLogAccessAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/Actions/Log/AuthorizeLogAccessActionTest.php`.

## Input

- `?Authenticatable $user`: l'utente autenticato del pannello (`Filament::auth()->user()`).

## Output

- `bool`: `true` solo se l'accesso è consentito.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| ACTIVITY-LOGACCESS-INV-1 | Accesso solo al ruolo `super-admin` o a chi ha il permesso `log.viewAny`. | `ACTIVITY-LOGACCESS-INV-1` |
| ACTIVITY-LOGACCESS-INV-2 | Ospiti, utenti senza ruolo né permesso e utenti che non implementano `UserContract` sono respinti. | `ACTIVITY-LOGACCESS-INV-2` |
| ACTIVITY-LOGACCESS-INV-3 | Se il permesso `log.viewAny` non esiste ancora nel database, l'accesso è negato senza eccezione. | `ACTIVITY-LOGACCESS-INV-3` |

## Effetti collaterali

- Nessuno: legge ruoli e permessi (Spatie Permission).

## Errori

- `PermissionDoesNotExist` catturata e trasformata in `false`; nessun'altra eccezione attesa.

## Non fa

- Non crea il permesso `log.viewAny`: va creato e assegnato dall'amministrazione dei ruoli.
- Non usa una Policy Laravel: la pagina non ha un modello; chi aggiunge un'altra via ai log riusa questa Action.
- Non registra gli accessi ai log.

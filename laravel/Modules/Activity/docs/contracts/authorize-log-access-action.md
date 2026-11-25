---
title: "Contratto: AuthorizeLogAccessAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-25
action: "Modules\\Activity\\Actions\\Log\\AuthorizeLogAccessAction"
qmd: "contract AuthorizeLogAccessAction activity log viewer permesso log.viewAny super-admin"
related:
  - ../log-viewer.md
  - ../adr/0003-log-viewer-single-path-resolver.md
  - ../../app/Actions/Log/AuthorizeLogAccessAction.php
  - ../../app/Filament/Pages/LogViewer.php
  - ../../tests/Unit/Actions/Log/AuthorizeLogAccessActionTest.php
---

# AuthorizeLogAccessAction

Chi puo' consultare e scaricare i file di log. Regola unica usata da `LogViewer::canAccess()`, dall'azione di download della pagina e dalla pagina Folio `pages/api/log-download`.

## Input

- `?Authenticatable $user`.

## Output

- `bool`: `true` se l'utente ha il ruolo `super-admin` o il permesso `log.viewAny`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| ACT-LOGAUTH-INV-1 | Ospiti (`null`) e utenti che non implementano `UserContract` sono negati. | `AuthorizeLogAccessActionTest.php` |
| ACT-LOGAUTH-INV-2 | Se il permesso `log.viewAny` non esiste nel database l'accesso e' negato senza errore (`PermissionDoesNotExist` catturata). | `AuthorizeLogAccessActionTest.php` |

## Effetti collaterali

- Nessuno: legge ruoli e permessi tramite Spatie Permission.

## Errori

- Nessuno verso il chiamante: `PermissionDoesNotExist` diventa `false`; altre eccezioni si propagano.

## Non fa

- Non protegge il percorso dei file: lo fa [GetLogFilePathAction](get-log-file-path-action.md).
- Non crea il permesso mancante (va creato e assegnato dall'amministrazione dei ruoli) e non registra i tentativi negati.
- Non usa una Policy Laravel: la pagina non ha un modello.

---
title: "Contratto — AuthorizeLogAccessAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Log\\AuthorizeLogAccessAction"
qmd: "contract AuthorizeLogAccessAction activity log viewer permesso log.viewAny super-admin ACT-LOGAUTH-INV"
---

# AuthorizeLogAccessAction

Chi puo' consultare e scaricare i file di log. Regola unica usata da `LogViewer::canAccess()` (`app/Filament/Pages/LogViewer.php:62`) e dal download (`LogViewer.php:128`).


## Input

- `?Authenticatable $user`.

## Output

- `bool`: `true` se l'utente ha il ruolo `super-admin` o il permesso `log.viewAny`.

## Invarianti

- **ACT-LOGAUTH-INV-1** — Ospiti (`null`) e utenti che non implementano `UserContract` sono negati.
  Verifica non marcata: `Modules/Activity/tests/Unit/Actions/Log/AuthorizeLogAccessActionTest.php` («denies guests and users that do not implement the project user contract»); nessun `->group('ACT-LOGAUTH-INV-1')`.
- **ACT-LOGAUTH-INV-2** — Se il permesso `log.viewAny` non esiste nel database l'accesso e' negato senza errore (`PermissionDoesNotExist` catturata).
  Stessa verifica non marcata («denies access, without crashing, when the permission does not exist yet»).

## Effetti collaterali

- Nessuno: legge ruoli e permessi tramite Spatie Permission.

## Errori

- Nessuno verso il chiamante: `PermissionDoesNotExist` diventa `false`; altre eccezioni si propagano.

## Non fa

- Non protegge il percorso dei file: lo fa [ResolveLogFilePathAction](resolve-log-file-path-action.md).
- Non registra i tentativi negati.
- Non crea il permesso mancante.

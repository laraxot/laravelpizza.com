---
title: "INDEX contratti — Activity"
type: index
module: Activity
status: active
created: 2026-11-23
updated: 2026-11-24
qmd: "activity contracts index copertura invarianti backlog"
---

# Indice dei contratti — Activity

Copertura = `coperto` solo se per ogni ID esiste `->group('<ID>')` nei test del modulo
(`rg -n "group\('ACT-" laravel/Modules/Activity/tests`: nessun risultato). Esiste solo il gruppo `no-activity-db` (in `tests/Unit/Datas/ActivityConfigDataTest.php` e `tests/Unit/Actions/RedactModelAttributesActionTest.php`), che non e' un ID di invariante.

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| Risolvere il file di log scelto dall'utente | [resolve-log-file-path-action](get-log-file-path-action.md) | `Modules\Activity\Actions\Log\GetLogFilePathAction` | ACT-LOGPATH-INV-1, ACT-LOGPATH-INV-2, ACT-LOGPATH-INV-3, ACT-LOGPATH-INV-4 | non coperto (test esistenti senza group) | `vendor/bin/pest --group=ACT-LOGPATH-INV-1` |
| Autorizzare l'accesso ai log | [authorize-log-access-action](authorize-log-access-action.md) | `Modules\Activity\Actions\Log\AuthorizeLogAccessAction` | ACT-LOGAUTH-INV-1, ACT-LOGAUTH-INV-2 | non coperto (test esistenti senza group) | `vendor/bin/pest --group=ACT-LOGAUTH-INV-1` |
| Cancellare le attivita' vecchie | [activity-maintenance-action](activity-maintenance-action.md) | `Modules\Activity\Actions\ActivityMaintenanceAction` | ACT-CLEAN-INV-1, ACT-CLEAN-INV-2 | non coperto | `vendor/bin/pest --group=ACT-CLEAN-INV-1` |

I comandi `--group` darebbero zero test finche' i gruppi non sono aggiunti (fuori scope docs).
Marker `@contract` mancante in tutte e tre le classi (fuori scope docs).

## Backlog contract

Action ad alto rischio senza contract:

- `laravel/Modules/Activity/app/Actions/RestoreActivityAction.php`: `update()` del record con le proprieta' vecchie; l'autorizzazione e' in `ListLogActivities::restoreActivity()` (`abort(403)` se `canRestoreActivity()` e' falso).
- `laravel/Modules/Activity/app/Actions/RedactModelAttributesAction.php`: rimuove `password`, `remember_token`, `two_factor_secret`, `two_factor_recovery_codes`. Nel codice `app/` non risultano chiamanti (`rg RedactModelAttributesAction app`: solo la definizione): la redazione non e' applicata dalle Action di log; da verificare prima di scrivere il contract.
- `laravel/Modules/Activity/app/Actions/LogActivityAction.php` e `ActivityLogger.php`: scrivono l'audit con `properties` libere.
- `laravel/Modules/Activity/app/Actions/Log/DownloadLogFileAction.php`: restituisce il file scaricabile (usa `GetLogFilePathAction`).

Totale Action nel modulo: 30 file in `app/Actions` (`find app/Actions -name '*.php' | wc -l`), di cui 3 con contract.
title: "INDEX — Activity"
type: index
status: active
created: 2026-11-23
updated: 2026-11-23
decision-makers: []
---

<!-- File: docs/contracts/index.md · formato MADR breve. -->

# <!-- Titolo: indice operativo Activity -->

Indice dei contratti comportamentali del modulo Activity: ogni operazione pubblica con effetti collaterali o invarianti di dominio.

| Operazione | Contract | Classe | Invarianti |
|---|---|---|---|
| *(nessuno)* | — | — | Nessun contratto audito per questo modulo |

(End of file - total 20 lines)
<<<<<<< .merge_file_74Ky7J
(End of file - total 20 lines)
(End of file - total 20 lines)
(End of file - total 20 lines)
=======

## Contenuto fuso da `index.md`

<!-- File: docs/contracts/INDEX.md · formato MADR breve. -->
>>>>>>> .merge_file_PmWq6y

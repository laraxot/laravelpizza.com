---
title: "Indice dei contratti: Activity"
type: index
module: Activity
status: active
created: 2026-11-23
updated: 2026-11-25
qmd: "activity contracts index copertura invarianti backlog"
---

# Indice dei contratti: Activity

| Operazione | Contratto | Classe | Invarianti |
|---|---|---|---|
| Registrare un'attivita' | [log-activity-action](./log-activity-action.md) | `Modules\Activity\Actions\LogActivityAction` | ACTIVITY-LOG-INV-1..4 |
| Registrare la modifica di un modello (e, per la stessa regola, creazione e cancellazione) | [log-model-updated-action](./log-model-updated-action.md) | `Modules\Activity\Actions\LogModelUpdatedAction` | ACTIVITY-MODEL-LOG-INV-1..3 |
| Ripristinare un record dai valori `old` | [restore-activity-action](./restore-activity-action.md) | `Modules\Activity\Actions\RestoreActivityAction` | ACTIVITY-RESTORE-INV-1..3 |
| Autorizzare l'accesso ai log | [authorize-log-access-action](./authorize-log-access-action.md) | `Modules\Activity\Actions\Log\AuthorizeLogAccessAction` | ACTIVITY-LOGACCESS-INV-1..3 |
| Risolvere il file di log scelto dall'utente | [get-log-file-path-action](./get-log-file-path-action.md) | `Modules\Activity\Actions\Log\GetLogFilePathAction` | ACTIVITY-LOGFILE-INV-1..5 |
| Scaricare un file di log | [download-log-file-action](./download-log-file-action.md) | `Modules\Activity\Actions\Log\DownloadLogFileAction` | ACTIVITY-LOGDOWNLOAD-INV-1..2 |

## Copertura

Gli invarianti con un test hanno il `->group('<ID>')` omonimo: `cd laravel && vendor/bin/pest Modules/Activity/tests --group=ACTIVITY-LOGFILE-INV-1`. Quelli marcati «nessuno» sono debito dichiarato ([../roadmap.md](../roadmap.md)). Il gruppo `no-activity-db` non e' un invariante: segna i test che non toccano il database.

## Le altre Action

Le restanti 24 Action (scrittura derivata, `Query/*`, `Schema/*`, `Config/*` e il resto del log viewer) hanno un contratto sintetico in [../actions.md](../actions.md).

---
title: "INDEX — Notify"
type: index
status: active
created: 2026-11-23
updated: 2026-11-23
decision-makers: []
---

<!-- File: docs/contracts/INDEX.md · formato MADR breve. -->

# <!-- Titolo: indice operativo Notify -->

Elenco operativo dei contract comportamentali del modulo Notify.

| Operazione | Contract | Classe | Invarianti |
|---|---|---|---|
| Gestione stati modello | [modelwithstatuscontract](modelwithstatuscontract.md) | `Modules\Xot\Contracts\ModelWithStatusContract` | NOTIFY-INV-1 |

(End of file - total 16 lines)
=======
title: "INDEX contratti — Notify"
type: index
module: Notify
status: active
created: 2026-11-23
updated: 2026-11-24
qmd: "notify contracts index copertura invarianti backlog invio notifiche"
---

# Indice dei contratti — Notify

Copertura = `coperto` solo se per ogni ID esiste `->group('<ID>')` nei test del modulo
(`rg -n "group\('NOTIFY-" laravel/Modules/Notify/tests`: nessun risultato).

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| Inviare una notifica da template su piu' canali | [send-notification-action](send-notification-action.md) | `Modules\Notify\Actions\SendNotificationAction` | NOTIFY-SEND-INV-1, NOTIFY-SEND-INV-2, NOTIFY-SEND-INV-3, NOTIFY-SEND-INV-4, NOTIFY-SEND-INV-5 | non coperto (INV-1/2/4 hanno test senza group; INV-3/5 nessuno) | `vendor/bin/pest --group=NOTIFY-SEND-INV-1` |

I comandi `--group` darebbero zero test finche' i gruppi non sono aggiunti (fuori scope docs).
Marker `@contract` mancante in `SendNotificationAction` (fuori scope docs).

## Backlog contract

Action ad alto rischio (invio a terzi, dati personali) senza contract:

- `laravel/Modules/Notify/app/Actions/NotificationManager.php` (orchestra `SendNotificationAction`)
- `laravel/Modules/Notify/app/Actions/SendNotificationToRecipientAction.php`, `SendRecordNotificationAction.php`, `SendRecordsNotificationAction.php`, `SendAppointmentNotificationAction.php`
- `laravel/Modules/Notify/app/Actions/Mail/SendMailAction.php`, `Mail/ProcessInboundMailAction.php` (posta in ingresso)
- `laravel/Modules/Notify/app/Actions/SMS/SendSmsAction.php`: il docblock dichiara che il dispatch per riflessione verso `SmsEngines\{Driver}Engine` non trova mai una classe e quindi lancia sempre `RuntimeException` (la cartella `SmsEngines` non esiste in `app/Actions/SMS/`); gli invii SMS reali passano da altre Action (es. `SendNetfunSMSAction`).
- `laravel/Modules/Notify/app/Actions/Push/*`, `WhatsApp/*`, `Telegram/*`: invii verso servizi esterni.

Totale Action nel modulo: 54 file in `app/Actions` (`find app/Actions -name '*.php' | wc -l`), di cui 1 con contract.
>>>>>>> laraxot/dev

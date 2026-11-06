---
title: "Notify: brainstorming"
type: brainstorming
tags: [notify, brainstorming, risks, open-questions, decisions, channels]
created: 2026-09-28
updated: 2026-10-23
qmd: "Notify brainstorming decisioni aperte scartate rischi canali notifica"
related:
  - ./README.md
  - ./architecture.md
  - ./brainstorming/module-opportunities.md
  - ./epics/module-roadmap.md
  - ./epics/notification-channels.epic.md
status: draft
---

# Notify: brainstorming

> **SUMMARY**: indice dei contenuti di brainstorming per `Modules\Notify`.
> Le domande ad alto valore, ipotesi, rischi e output attesi sono nei **shard**
> sottostanti (non sovrascritti). Questo file root funge da indice con
> decisioni e rischi verificati nel codice.

## Shard brainstorming

| Shard | Descrizione |
|---|---|
| [brainstorming/module-opportunities.md](./brainstorming/module-opportunities.md) | domande ad alto valore, ipotesi da validare, rischi |

## Decisioni prese

| Decisione | Stato | Riferimento |
|---|---|---|
| `NotifyServiceProvider` estende `XotBaseServiceProvider` | approvata | `app/Providers/NotifyServiceProvider.php:15` |
| `MailTemplate` estende `SpatieMailTemplate` | approvata | `app/Models/MailTemplate.php:74` |
| `MailTemplate` implementa `MailTemplateInterface` | approvata | `app/Models/MailTemplate.php:74` |
| `Contact` usa trait `HasContact` | approvata | `app/Models/Traits/HasContact.php` |
| `NotifyTheme` usa `linkable()` MorphTo | approvata | `app/Models/NotifyTheme.php:121` |
| Canali esterni in `app/Channels/` (SMS, Telegram, WhatsApp, Netfun) | approvati | `app/Channels/` |
| Merge config da env in `MergesNotifyConfigFromEnv` | approvato | `app/Providers/Concerns/MergesNotifyConfigFromEnv.php` |
| Notifiche in coda con la Queueable Action stessa (`->onQueue()->execute(...)`), senza Job: `SendNotificationJob` rimosso (story 4.27, [regola](../../../../../bashscripts/ai/wiki/rules/no-module-jobs-queueable-action.md)) | approvato | `app/Actions/SendNotificationAction.php`, `app/Actions/SendRecordsNotificationAction.php` |
| Push programmato: `SchedulePushNotificationAction` accoda `SendScheduledPushNotificationAction` con `ActionJob::dispatch(...)->delay(...)` | approvato | `app/Actions/Push/SchedulePushNotificationAction.php` |
| Migrazioni obsolete in `_archive_redundant/` non applicate | approvato | `database/migrations/_archive_redundant/` |

## Domande aperte

| Domanda | Fonte | Priorità |
|---|---|---|
| API pubblica e invarianti del modulo | `architecture/module-boundary.md` sezione "Decisioni da confermare" | alta |
| Flussi con transazioni, autorizzazione e audit | `architecture/module-boundary.md` sezione "Decisioni da confermare" | alta |
| Parità Form/Table tra resource Filament | `app/Filament/Resources/*/Schemas/` vs `*/Tables/` | media |
| Copertura Pest rappresentativa (158 test) | `tests/` | media |

## Rischi

| Rischio | Evidenza |
|---|---|
| Duplicazione tra moduli | `app/Models/` contiene `Theme.php` e `NotifyTheme.php` |
| Contratti impliciti Eloquent | `app/Models/NotificationLog.php` rel. `notifiable()`/`template()` |
| Drift docs / codice / stories | `docs/bmad/stories/` multipli |
| WIP concorrente e marker merge | `stories/git-status-fleet-merge-markers-notify.story.md` |
| Migrazioni obsolete duplicate | `database/migrations/` + `_archive_redundant/` + `_bak/` |
| Config generico vs canale-specifico | `config/notify.php`, `config/sms.php`, `config/telegram.php`, `config/whatsapp.php` |
| Notifiche duplicate con User/Tenant | canali usano `Modules\User\Models\User` |

## Elementi non approvati (scartati o fuori scope)

| Elemento | Motivo |
|---|---|
| Refactor proposto in architettura | da marcare esplicitamente come proposta non applicata |

## Idee, problemi e soluzioni (bozza integrata)

Spunti provenienti da una bozza concorrente del file, ricontrollati sul codice il 2026-10-07.
Percorsi relativi a `laravel/Modules/Notify/app`.

### Idee

- Un canale unico che colleghi record Eloquent, destinatario e template, usando `ChannelEnum` per risolvere l'indirizzo di consegna.
- Selezione del driver tramite factory (`Factories/SmsActionFactory.php`, `TelegramActionFactory.php`, `WhatsAppActionFactory.php`): mappano config su classe senza `match()` nel codice chiamante.
- Template a strati: `MailTemplate` (Spatie, DB), `NotificationTemplate` (compilazione Blade) e `NotifyTheme` (segnaposto `##var##`).
- Push multipiattaforma (FCM, APNs, WebPush) con piattaforma dedotta dal formato del token.
- Log di consegna centralizzato in `NotificationLog` (`STATUS_PENDING`, `STATUS_PROCESSING`, `STATUS_SENT`, `STATUS_DELIVERED`, `STATUS_FAILED`, `STATUS_OPENED`, `STATUS_CLICKED`).

### Problemi aperti (ancora veri)

| Problema | Evidenza |
|---|---|
| `SendSmsAction` cerca `Actions\SMS\SmsEngines\{Driver}Engine`, namespace senza engine: lancia sempre `RuntimeException` | `Actions/SMS/SendSmsAction.php` (docblock: comportamento preservato dalla migrazione Services a Actions, nessun fix funzionale) |
| Engine Duocircle non implementato | `Actions/Mail/Engines/Duocircle/SendDuocircleMailAction.php` lancia `RuntimeException('WIP ...')` |
| Notifica appuntamento ridotta a stub: i modelli `Patient`/`Appointment` non esistono nel progetto | `Actions/SendAppointmentNotificationAction.php` (import commentati, solo `Log::debug`) |
| `SmtpMailSendAction` lancia subito `RuntimeException('Removed debug dddx')`; il resto del corpo e' commentato | `Actions/SmtpMailSendAction.php` righe 15 e seguenti |
| `WhatsAppNotification::via()` ritorna la stringa `'whatsapp'` e non la classe del canale | `Notifications/WhatsAppNotification.php` riga 67 |
| `getTemplateStats()` e `getRecipientStats()` hanno il corpo commentato, quindi non calcolano nulla | `Actions/NotificationManager.php` righe 117 e 146; stessa situazione nella copia `Services/NotificationManager.php` |
| APNs e WebPush restano simulati (`success => true` con messaggio "simulated") | `Actions/PushNotificationPlatformDelivery.php` righe 118 e 143 (e varianti topic) |
| Possibile duplicazione tra `SendPushNotificationAction` e le `Push/SendPushTo*Action` | da verificare: `Actions/SendPushNotificationAction.php` vs `Actions/Push/SendPushToPlatformAction.php` (quest'ultima e' usata da `SendPushToDeviceAction` e `SendPushToDevicesAction`) |

### Soluzioni proposte (non applicate)

- Sostituire `SendSmsAction` con `SmsActionFactory` e driver che implementano `SmsActionContract` (le action `Actions/SMS/Send*SMSAction.php` esistono gia').
- Implementare o rimuovere `SendDuocircleMailAction`.
- Rimuovere `SendAppointmentNotificationAction` oppure iniettare i modelli dipendenti tramite contract.
- Riscrivere `SmtpMailSendAction` con `Symfony\Component\Mailer\Transport::fromDsn()`.
- Far ritornare a `WhatsAppNotification::via()` la classe `WhatsAppChannel::class`.
- Scegliere una action push primaria (con `PushNotificationPlatformDelivery`) e deprecare le duplicate.
- Implementare le statistiche di `NotificationManager` con query reali su `NotificationLog`.

### Domande aperte

- Il canale `mail` ha due percorsi: `NotificationResource` via `GenericNotification` e `RecordNotification` via `SpatieEmail` (TemplateMailable). Sono paralleli per scelta o da unificare?
- `NotificationTemplate` (Blade) e `MailTemplate` (Spatie DB) coesistono: doppio motore voluto o uno e' legacy? Stessa domanda per `NotifyTheme` con `##var##`.
- APNs e WebPush simulati sono accettabili per un MVP o sono un gap da colmare?
- `MergesNotifyConfigFromEnv` e `ResolveTenantConfigValueAction` suggeriscono multi-tenant: il fallback `Mail::alwaysTo()` di `NotifyServiceProvider::boot()` (riga 37) vale per tutti i tenant?

## Vedi anche

- [README](./README.md)
- [Architecture](./architecture.md)
- [Epic roadmap](./epics/module-roadmap.md)
- [Epic channels](./epics/notification-channels.epic.md)
- [Module opportunities (shard)](./brainstorming/module-opportunities.md)

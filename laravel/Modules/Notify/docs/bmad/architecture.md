---
title: "Notify: architecture"
type: architecture
tags: [notify, architecture, module-boundary, models, resources, channels]
created: 2026-09-28
updated: 2026-09-28
qmd: "Notify architettura componenti modelli risorse canali provider"
related:
  - ./README.md
  - ./architecture/module-boundary.md
  - ./brainstorming.md
  - ./epics/module-roadmap.md
  - ./epics/notification-channels.epic.md
status: draft
---

# Notify: architecture

> **SUMMARY**: indice della documentazione architetturale per
> `Modules\Notify`. Il dettaglio del confine modulare, inventario `app()`/`tests()`
> e decisioni di progetto sono nei **shard** sottostanti (non sovrascritti).
> Questo file root funge da indice e non duplica il contenuto dei shard.

## Shard architettura

| Shard | Descrizione |
|---|---|
| [architecture/module-boundary.md](./architecture/module-boundary.md) | inventario `app/` (246 PHP), `tests/` (158), aree applicative, confini e decisioni da confermare |

## Provider

| Provider | File | Note |
|---|---|---|
| `NotifyServiceProvider` | `app/Providers/NotifyServiceProvider.php` | estende `XotBaseServiceProvider` |
| `AdminPanelProvider` | `app/Providers/Filament/AdminPanelProvider.php` | registra risorse Filament |
| `EventServiceProvider` | `app/Providers/EventServiceProvider.php` | eventi |
| `RouteServiceProvider` | `app/Providers/RouteServiceProvider.php` | route |

### Provider con merge config

- `app/Providers/Concerns/MergesNotifyConfigFromEnv.php`

## Modelli

| Modello | File | Estende / Implementa | Tabella |
|---|---|---|---|
| `Notification` | `app/Models/Notification.php` | `BaseModel` | `notifications` |
| `NotificationTemplate` | `app/Models/NotificationTemplate.php` | `BaseModel`, `HasMedia` | `notification_templates` |
| `NotificationLog` | `app/Models/NotificationLog.php` | `BaseModel` | `notification_logs` |
| `MailTemplate` | `app/Models/MailTemplate.php` | `SpatieMailTemplate`, `MailTemplateInterface` | `mail_templates` |
| `MailTemplateVersion` | `app/Models/MailTemplateVersion.php` | `BaseModel` | `mail_template_versions` |
| `MailTemplateLog` | `app/Models/MailTemplateLog.php` | `BaseModel` |: |
| `Contact` | `app/Models/Contact.php` | `BaseModel` | `notify_contacts` |
| `NotifyTheme` | `app/Models/NotifyTheme.php` | `BaseModel` | `notify_themes` |
| `NotificationType` | `app/Models/NotificationType.php` | `Model` | `notification_types` |
| `NotifyThemeable` | `app/Models/NotifyThemeable.php` | `BaseModel` | `notify_themeables` |
| `Theme` | `app/Models/Theme.php` |: |: |
| `BaseModel` | `app/Models/BaseModel.php` | `XotBaseModel` |: |

## Relazioni verificate

| Modello | Relazione | Tipo | Target |
|---|---|---|---|
| `NotificationLog` | `notifiable()` | `MorphTo` | notificabile |
| `NotificationLog` | `template()` | `BelongsTo` | `NotificationTemplate` |
| `NotifyTheme` | `linkable()` | `MorphTo` | modello linkato |

## Resource Filament

| Resource | Directory |
|---|---|
| `ContactResource` | `app/Filament/Resources/ContactResource/` (form, infolist, table) |
| `MailTemplateResource` | `app/Filament/Resources/MailTemplateResource/` |
| `NotificationResource` | `app/Filament/Resources/NotificationResource/` |
| `NotificationLogResource` | `app/Filament/Resources/NotificationLogResource/` |
| `NotificationTemplateResource` | `app/Filament/Resources/NotificationTemplateResource/` |
| `NotifyThemeResource` | `app/Filament/Resources/NotifyThemeResource/` (+ `RelationManagers/LinkableRelationManager.php`) |

## Pages e Widgets

- `app/Filament/Pages/Dashboard.php`
- `app/Filament/Pages/SettingPage.php`
- `app/Filament/Tables/Columns/ContactColumn.php`
- `app/Filament/Forms/Components/`

## Canali

| Canale | File |
|---|---|
| `NetfunChannel` | `app/Channels/NetfunChannel.php` |
| `SmsChannel` | `app/Channels/SmsChannel.php` |
| `TelegramChannel` | `app/Channels/TelegramChannel.php` |
| `WhatsAppChannel` | `app/Channels/WhatsAppChannel.php` |

## Notifications native

| Classe | File |
|---|---|
| `EmailDataNotification` | `app/Notifications/EmailDataNotification.php` |
| `GenericNotification` | `app/Notifications/GenericNotification.php` |
| `RecordNotification` | `app/Notifications/RecordNotification.php` |
| `SmsNotification` | `app/Notifications/SmsNotification.php` |
| `TelegramNotification` | `app/Notifications/TelegramNotification.php` |
| `WhatsAppNotification` | `app/Notifications/WhatsAppNotification.php` |
| `FirebaseAndroidNotification` | `app/Notifications/FirebaseAndroidNotification.php` |
| `ThemeNotification` | `app/Notifications/ThemeNotification.php` |
| `TicketAssignedNotification` | `app/Notifications/TicketAssignedNotification.php` |
| `TicketStatusChangedNotification` | `app/Notifications/TicketStatusChangedNotification.php` |

## Esecuzione in coda

| Caso d'uso | Action canonica | Dispatch |
|---|---|---|
| Invio notifica | `app/Actions/SendNotificationAction.php` | sincrono o `QueueableAction` |
| Push programmato | `app/Actions/Push/SendScheduledPushNotificationAction.php` | `ActionJob::dispatch(...)->delay(...)` |

## Action orchestrative

| Action | File | Area |
|---|---|---|
| `SendNotificationAction` | `app/Actions/SendNotificationAction.php` | invio |
| `SendRecordNotificationAction` | `app/Actions/SendRecordNotificationAction.php` | invio record |
| `SendRecordsNotificationAction` | `app/Actions/SendRecordsNotificationAction.php` | invio records |
| `NotificationManager` | `app/Actions/NotificationManager.php` | gestione |
| `SendAppointmentNotificationAction` | `app/Actions/SendNotificationAction.php` | appuntamento |
| `BuildMailMessageAction` | `app/Actions/BuildMailMessageAction.php` | email |
| `PushNotificationPlatformDelivery` | `app/Actions/PushNotificationPlatformDelivery.php` | push |

### Driver SMS

`app/Actions/SMS/`: `SendTwilioSMSAction`, `SendPlivoSMSAction`,
`SendNexmoSMSAction`, `SendAgiletelecomSMSAction` (+ v1, v2),
`SendGammuSMSAction`, `SendNetfunSMSAction`, `SendSmsFactorSMSAction`.

### Push

`app/Actions/SendPushNotificationAction.php` (root Actions),
`app/Actions/PushNotificationPlatformDelivery.php`; `app/Actions/Push/`:
`SendPushToAllUsersAction`, `SendPushToDeviceAction`,
`SendPushToDevicesAction`, `SendPushToPlatformAction`,
`SendPushToTopicAction`, `SendPushWithTargetingAction`,
`SendPushWithTemplateAction`, `SendScheduledPushNotificationAction`.

### Telegram

`app/Actions/Telegram/`: `SendBotmanTelegramAction`,
`SendNutgramTelegramAction`, `SendOfficialTelegramAction`.

### WhatsApp

`app/Actions/WhatsApp/`: `Send360dialogWhatsAppAction`,
`SendFacebookWhatsAppAction`, `SendTwilioWhatsAppAction`,
`SendVonageWhatsAppAction`.

## Enums

| Enum | File |
|---|---|
| `ChannelEnum` | `app/Enums/ChannelEnum.php` |
| `ContactTypeEnum` | `app/Enums/ContactTypeEnum.php` |
| `NotificationTypeEnum` | `app/Enums/NotificationTypeEnum.php` |
| `NotificationLogStatusEnum` | `app/Enums/NotificationLogStatusEnum.php` |
| `SmsDriverEnum` | `app/Enums/SmsDriverEnum.php` |
| `TelegramDriverEnum` | `app/Enums/TelegramDriverEnum.php` |
| `WhatsAppDriverEnum` | `app/Enums/WhatsAppDriverEnum.php` |
| `MediaTypeEnum` | `app/Enums/MediaTypeEnum.php` |

## Console

| Comando | File |
|---|---|
| SendMail | `app/Console/Commands/SendMailCommand.php` |
| TelegramWebhook | `app/Console/Commands/TelegramWebhook.php` |
| CleanupNotificationLogs | `app/Console/Commands/CleanupNotificationLogsCommand.php` |
| AnalyzeTranslationFiles | `app/Console/Commands/AnalyzeTranslationFiles.php` |
| MigrateNotifyThemes | `app/Console/Commands/MigrateNotifyThemesToMailTemplateCommand.php` |

## Persistenza

| Area | Path | Note |
|---|---|---|
| Migrations | `database/migrations/` | ~20 file attivi; obsoleti in `_archive_redundant/` e `_bak/` |
| Factories | `database/factories/` |: |
| Seeders | `database/seeders/` |: |

## Test

| Area | Path | Conteggio |
|---|---|---|
| Unit/Actions | `tests/Unit/Actions/` | ~30 file |
| Unit/Models | `tests/Unit/Models/` | ~20 file |
| Unit/Notifications | `tests/Unit/Notifications/` |: |
| Unit/Channels | `tests/Unit/Channels/` | 4 file |
| Unit/Enums | `tests/Unit/Enums/` | 9 file |
| Unit/Console | `tests/Unit/Console/` |: |
| Unit/Filament | `tests/Unit/Filament/` |: |
| Unit/Providers | `tests/Unit/Providers/` | 3 file |
| Unit/Datas | `tests/Unit/Datas/` |: |
| Unit/Factories | `tests/Unit/Factories/` |: |
| Unit/Traits | `tests/Unit/Traits/` |: |
| Unit/Architecture | `tests/Unit/Architecture/` | 1 file |
| Feature | `tests/Feature/` | ~15 file |
| Fixtures | `tests/Fixtures/` | ~15 file |
| **Totale** | `tests/` | **158 file** |

## Config

| File | Scopo |
|---|---|
| `config/config.php` | nome, icona, navigazione |
| `config/notify.php` | configurazione notifica |
| `config/sms.php` | driver SMS |
| `config/telegram.php` | driver Telegram |
| `config/whatsapp.php` | driver WhatsApp |
| `config/beautymail.php` | template email |

## Vedi anche

- [README](./README.md)
- [Brainstorming](./brainstorming.md)
- [Epic roadmap](./epics/module-roadmap.md)
- [Epic channels](./epics/notification-channels.epic.md)
- [Quick reference](./quick-reference.md)
- [Setup guide](./setup-guide.md)
- [BMAD method (Xot)](../../Xot/docs/bmad-method.md)

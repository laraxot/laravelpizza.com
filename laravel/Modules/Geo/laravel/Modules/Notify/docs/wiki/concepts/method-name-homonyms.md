---
title: "censimento omonimi metodi — modulo Notify"
type: analysis
module: Notify
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Notify

> **75** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Notify)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 20 |
| `E_scheda_stack` | 8 |
| `G_module_local` | 22 |
| `H_cross_module_homonym` | 25 |

## Dettaglio

### `A_filament_framework` (20 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `toArray` — 39 classi

- `Notify` · `PushNotificationDebugData` · `Modules/Notify/app/Datas/PushNotificationDebugData.php`
- `Notify` · `SmtpData` · `Modules/Notify/app/Datas/SmtpData.php`
- `Notify` · `EmailDataNotification` · `Modules/Notify/app/Notifications/EmailDataNotification.php`
- `Notify` · `FirebaseAndroidNotification` · `Modules/Notify/app/Notifications/FirebaseAndroidNotification.php`
- `Notify` · `TelegramNotification` · `Modules/Notify/app/Notifications/TelegramNotification.php`
- `Notify` · `ThemeNotification` · `Modules/Notify/app/Notifications/ThemeNotification.php`
- `Notify` · `TicketAssignedNotification` · `Modules/Notify/app/Notifications/TicketAssignedNotification.php`
- `Notify` · `TicketStatusChangedNotification` · `Modules/Notify/app/Notifications/TicketStatusChangedNotification.php`

#### `via` — 14 classi

- `Notify` · `EmailDataNotification` · `Modules/Notify/app/Notifications/EmailDataNotification.php`
- `Notify` · `FirebaseAndroidNotification` · `Modules/Notify/app/Notifications/FirebaseAndroidNotification.php`
- `Notify` · `GenericNotification` · `Modules/Notify/app/Notifications/GenericNotification.php`
- `Notify` · `RecordNotification` · `Modules/Notify/app/Notifications/RecordNotification.php`
- `Notify` · `SmsNotification` · `Modules/Notify/app/Notifications/SmsNotification.php`
- `Notify` · `TelegramNotification` · `Modules/Notify/app/Notifications/TelegramNotification.php`
- `Notify` · `ThemeNotification` · `Modules/Notify/app/Notifications/ThemeNotification.php`
- `Notify` · `TicketAssignedNotification` · `Modules/Notify/app/Notifications/TicketAssignedNotification.php`
- … +2 occorrenze

#### `getHeaderWidgets` — 13 classi

- `Notify` · `SettingPage` · `Modules/Notify/app/Filament/Pages/SettingPage.php`

#### `toMail` — 10 classi

- `Notify` · `EmailDataNotification` · `Modules/Notify/app/Notifications/EmailDataNotification.php`
- `Notify` · `GenericNotification` · `Modules/Notify/app/Notifications/GenericNotification.php`
- `Notify` · `RecordNotification` · `Modules/Notify/app/Notifications/RecordNotification.php`
- `Notify` · `ThemeNotification` · `Modules/Notify/app/Notifications/ThemeNotification.php`
- `Notify` · `TicketAssignedNotification` · `Modules/Notify/app/Notifications/TicketAssignedNotification.php`
- `Notify` · `TicketStatusChangedNotification` · `Modules/Notify/app/Notifications/TicketStatusChangedNotification.php`

#### `attachments` — 5 classi

- `Notify` · `EmailDataEmail` · `Modules/Notify/app/Emails/EmailDataEmail.php`
- `Notify` · `SpatieEmail` · `Modules/Notify/app/Emails/SpatieEmail.php`
- `Notify` · `AppointmentNotificationMail` · `Modules/Notify/app/Mail/AppointmentNotificationMail.php`
- `Notify` · `ChristmasGreetingMailable` · `Modules/Notify/app/Mail/ChristmasGreetingMailable.php`

#### `envelope` — 5 classi

- `Notify` · `EmailDataEmail` · `Modules/Notify/app/Emails/EmailDataEmail.php`
- `Notify` · `SpatieEmail` · `Modules/Notify/app/Emails/SpatieEmail.php`
- `Notify` · `AppointmentNotificationMail` · `Modules/Notify/app/Mail/AppointmentNotificationMail.php`
- `Notify` · `ChristmasGreetingMailable` · `Modules/Notify/app/Mail/ChristmasGreetingMailable.php`

#### `content` — 4 classi

- `Notify` · `EmailDataEmail` · `Modules/Notify/app/Emails/EmailDataEmail.php`
- `Notify` · `AppointmentNotificationMail` · `Modules/Notify/app/Mail/AppointmentNotificationMail.php`
- `Notify` · `ChristmasGreetingMailable` · `Modules/Notify/app/Mail/ChristmasGreetingMailable.php`

#### `sendMail` — 4 classi

- `Notify` · `SendNotificationAction` · `Modules/Notify/app/Actions/SendNotificationAction.php`

### `G_module_local`

#### `emailForm` — 6 classi

- `Notify` · `SendAwsEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendAwsEmailPage.php`
- `Notify` · `SendEmail` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php`
- `Notify` · `SendEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmailPage.php`
- `Notify` · `SendSpatieEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSpatieEmailPage.php`
- `Notify` · `SendTelegram` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendTelegram.php`
- `Notify` · `TestSmtpPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/TestSmtpPage.php`

#### `getEmailFormActions` — 6 classi

- `Notify` · `SendAwsEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendAwsEmailPage.php`
- `Notify` · `SendEmail` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php`
- `Notify` · `SendEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmailPage.php`
- `Notify` · `SendSpatieEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSpatieEmailPage.php`
- `Notify` · `SendTelegram` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendTelegram.php`
- `Notify` · `TestSmtpPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/TestSmtpPage.php`

#### `getAuthHeaders` — 5 classi

- `Notify` · `AgiletelecomData` · `Modules/Notify/app/Datas/SMS/AgiletelecomData.php`
- `Notify` · `NexmoData` · `Modules/Notify/app/Datas/SMS/NexmoData.php`
- `Notify` · `PlivoData` · `Modules/Notify/app/Datas/SMS/PlivoData.php`
- `Notify` · `SmsFactorData` · `Modules/Notify/app/Datas/SMS/SmsFactorData.php`
- `Notify` · `TwilioData` · `Modules/Notify/app/Datas/SMS/TwilioData.php`

#### `getTimeout` — 5 classi

- `Notify` · `GammuData` · `Modules/Notify/app/Datas/SMS/GammuData.php`
- `Notify` · `NexmoData` · `Modules/Notify/app/Datas/SMS/NexmoData.php`
- `Notify` · `PlivoData` · `Modules/Notify/app/Datas/SMS/PlivoData.php`
- `Notify` · `SmsFactorData` · `Modules/Notify/app/Datas/SMS/SmsFactorData.php`
- `Notify` · `TwilioData` · `Modules/Notify/app/Datas/SMS/TwilioData.php`

#### `getBaseUrl` — 4 classi

- `Notify` · `NexmoData` · `Modules/Notify/app/Datas/SMS/NexmoData.php`
- `Notify` · `PlivoData` · `Modules/Notify/app/Datas/SMS/PlivoData.php`
- `Notify` · `SmsFactorData` · `Modules/Notify/app/Datas/SMS/SmsFactorData.php`
- `Notify` · `TwilioData` · `Modules/Notify/app/Datas/SMS/TwilioData.php`

#### `template` — 4 classi

- `Notify` · `MailTemplateLog` · `Modules/Notify/app/Models/MailTemplateLog.php`
- `Notify` · `MailTemplateVersion` · `Modules/Notify/app/Models/MailTemplateVersion.php`
- `Notify` · `NotificationLog` · `Modules/Notify/app/Models/NotificationLog.php`
- `Notify` · `NotificationTemplateVersion` · `Modules/Notify/app/Models/NotificationTemplateVersion.php`

#### `getEmailFormSchema` — 3 classi

- `Notify` · `SendAwsEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendAwsEmailPage.php`
- `Notify` · `SendEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmailPage.php`
- `Notify` · `SendSpatieEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSpatieEmailPage.php`

#### `toSms` — 3 classi

- `Notify` · `RecordNotification` · `Modules/Notify/app/Notifications/RecordNotification.php`
- `Notify` · `SmsNotification` · `Modules/Notify/app/Notifications/SmsNotification.php`
- `Notify` · `ThemeNotification` · `Modules/Notify/app/Notifications/ThemeNotification.php`

#### `addAttachments` — 2 classi

- `Notify` · `SpatieEmail` · `Modules/Notify/app/Emails/SpatieEmail.php`
- `Notify` · `RecordNotification` · `Modules/Notify/app/Notifications/RecordNotification.php`

#### `determineMediaType` — 2 classi

- `Notify` · `Send360dialogWhatsAppAction` · `Modules/Notify/app/Actions/WhatsApp/Send360dialogWhatsAppAction.php`
- `Notify` · `SendVonageWhatsAppAction` · `Modules/Notify/app/Actions/WhatsApp/SendVonageWhatsAppAction.php`

#### `fieldOptions` — 2 classi

- `Notify` · `NotifyThemeResource` · `Modules/Notify/app/Filament/Resources/NotifyThemeResource.php`
- `Notify` · `NotifyThemeForm` · `Modules/Notify/app/Filament/Resources/NotifyThemeResource/Schemas/NotifyThemeForm.php`

#### `getNotificationFormActions` — 2 classi

- `Notify` · `SendPushNotification` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotification.php`
- `Notify` · `SendPushNotificationPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotificationPage.php`

_… +10 metodi in questa categoria_

### `H_cross_module_homonym`

#### `fromArray` — 23 classi

- `Notify` · `NetfunSmsRequestData` · `Modules/Notify/app/Datas/NetfunSmsRequestData.php`
- `Notify` · `NetfunSmsResponseData` · `Modules/Notify/app/Datas/NetfunSmsResponseData.php`

#### `getUser` — 14 classi

- `Notify` · `SendAwsEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendAwsEmailPage.php`
- `Notify` · `SendEmail` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php`
- `Notify` · `SendEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmailPage.php`
- `Notify` · `SendFirebasePushNotificationPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendFirebasePushNotificationPage.php`
- `Notify` · `SendNetfunSmsPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendNetfunSmsPage.php`
- `Notify` · `SendPushNotification` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotification.php`
- `Notify` · `SendPushNotificationPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotificationPage.php`
- `Notify` · `SendSmsPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSmsPage.php`
- … +4 occorrenze

#### `get` — 9 classi

- `Notify` · `ConfigHelper` · `Modules/Notify/app/Helpers/ConfigHelper.php`

#### `failed` — 8 classi

- `Notify` · `SendNotificationJob` · `Modules/Notify/app/Jobs/SendNotificationJob.php`
- `Notify` · `SendScheduledPushNotification` · `Modules/Notify/app/Jobs/SendScheduledPushNotification.php`

#### `sendEmail` — 7 classi

- `Notify` · `SendAwsEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendAwsEmailPage.php`
- `Notify` · `SendEmail` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php`
- `Notify` · `SendEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmailPage.php`
- `Notify` · `SendSpatieEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSpatieEmailPage.php`
- `Notify` · `SendTelegram` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendTelegram.php`
- `Notify` · `TestSmtpPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/TestSmtpPage.php`

#### `getInstance` — 6 classi

- `Notify` · `MailtrapEngine` · `Modules/Notify/app/Services/MailEngines/MailtrapEngine.php`
- `Notify` · `SmsService` · `Modules/Notify/app/Services/SmsService.php`

#### `getSlug` — 6 classi

- `Notify` · `SpatieEmail` · `Modules/Notify/app/Emails/SpatieEmail.php`
- `Notify` · `SendAwsEmailPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendAwsEmailPage.php`
- `Notify` · `SendNetfunSmsPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendNetfunSmsPage.php`
- `Notify` · `SendSmsPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSmsPage.php`
- `Notify` · `SendWhatsAppPage` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendWhatsAppPage.php`

#### `forUser` — 5 classi

- `Notify` · `NotifyThemeableFactory` · `Modules/Notify/database/factories/NotifyThemeableFactory.php`

#### `getConfig` — 4 classi

- `Notify` · `GammuData` · `Modules/Notify/app/Datas/SMS/GammuData.php`
- `Notify` · `SmsNotification` · `Modules/Notify/app/Notifications/SmsNotification.php`
- `Notify` · `WhatsAppNotification` · `Modules/Notify/app/Notifications/WhatsAppNotification.php`

#### `getSlugOptions` — 4 classi

- `Notify` · `MailTemplate` · `Modules/Notify/app/Models/MailTemplate.php`

#### `panel` — 4 classi

- `Notify` · `AdminPanelProvider` · `Modules/Notify/app/Providers/Filament/AdminPanelProvider.php`

#### `scopeActive` — 4 classi

- `Notify` · `NotificationTemplate` · `Modules/Notify/app/Models/NotificationTemplate.php`

_… +13 metodi in questa categoria_




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```

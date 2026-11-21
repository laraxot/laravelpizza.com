---
issues: []
discussions: []
title: "corpi metodo duplicati — Notify"
type: analysis
module: Notify
tags: [dry, duplication, census, refactoring, notify]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies Notify identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
---

# Corpi metodo duplicati — Notify

> **58** gruppi con corpo identico coinvolgono Notify (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo Notify)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 17 | 1091 |
| `B_business_duplicate` | 21 | 424 |
| `C_cross_name` | 1 | 15 |
| `M_database_layer` | 2 | 38 |
| `S_trivial_stub` | 17 | 18863 |

## Dettaglio

### B — Business logic con corpo identico (consolidare: 1 owner)

#### `getUser` — 8 classi · 11 righe · ~77 righe duplicate

- `Notify` · `SendEmail::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php:94`
- `Notify` · `SendEmailPage::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmailPage.php:106`
- `Notify` · `SendPushNotification::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotification.php:226`
- `Notify` · `SendPushNotificationPage::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotificationPage.php:228`
- `Notify` · `SendSmsPage::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSmsPage.php:153`
- `Notify` · `SendSpatieEmailPage::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSpatieEmailPage.php:147`
- … +2 occorrenze

#### `notificationForm` — 2 classi · 72 righe · ~72 righe duplicate

- `Notify` · `SendPushNotification::notificationForm` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotification.php:51`
- `Notify` · `SendPushNotificationPage::notificationForm` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotificationPage.php:52`

#### `sendNotification` — 2 classi · 70 righe · ~70 righe duplicate

- `Notify` · `SendPushNotification::sendNotification` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotification.php:125`
- `Notify` · `SendPushNotificationPage::sendNotification` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotificationPage.php:126`

#### `getEmailFormActions` — 5 classi · 7 righe · ~28 righe duplicate

- `Notify` · `SendEmail::getEmailFormActions` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php:87`
- `Notify` · `SendEmailPage::getEmailFormActions` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmailPage.php:96`
- `Notify` · `SendSpatieEmailPage::getEmailFormActions` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendSpatieEmailPage.php:139`
- `Notify` · `SendTelegram::getEmailFormActions` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendTelegram.php:115`
- `Notify` · `TestSmtpPage::getEmailFormActions` · `Modules/Notify/app/Filament/Clusters/Test/Pages/TestSmtpPage.php:115`

#### `getTemplate` — 2 classi · 25 righe · ~25 righe duplicate

- `Notify` · `SendPushWithTemplateAction::getTemplate` · `Modules/Notify/app/Actions/Push/SendPushWithTemplateAction.php:41`
- `Notify` · `PushNotificationService::getTemplate` · `Modules/Notify/app/Services/PushNotificationService.php:483`

#### `getUser` — 3 classi · 11 righe · ~22 righe duplicate

- `Notify` · `SendAwsEmailPage::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendAwsEmailPage.php:151`
- `Notify` · `SendFirebasePushNotificationPage::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendFirebasePushNotificationPage.php:165`
- `Notify` · `SendNetfunSmsPage::getUser` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendNetfunSmsPage.php:163`

#### `fieldOptions` — 2 classi · 19 righe · ~19 righe duplicate

- `Notify` · `NotifyThemeResource::fieldOptions` · `Modules/Notify/app/Filament/Resources/NotifyThemeResource.php:57`
- `Notify` · `NotifyThemeForm::fieldOptions` · `Modules/Notify/app/Filament/Resources/NotifyThemeResource/Schemas/NotifyThemeForm.php:56`

#### `sendWebPushNotification` — 2 classi · 18 righe · ~18 righe duplicate

- `Notify` · `SendPushToPlatformAction::sendWebPushNotification` · `Modules/Notify/app/Actions/Push/SendPushToPlatformAction.php:106`
- `Notify` · `PushNotificationService::sendWebPushNotification` · `Modules/Notify/app/Services/PushNotificationService.php:320`

#### `processTemplate` — 2 classi · 15 righe · ~15 righe duplicate

- `Notify` · `SendPushWithTemplateAction::processTemplate` · `Modules/Notify/app/Actions/Push/SendPushWithTemplateAction.php:73`
- `Notify` · `PushNotificationService::processTemplate` · `Modules/Notify/app/Services/PushNotificationService.php:515`

#### `sendEmail` — 2 classi · 13 righe · ~13 righe duplicate

- `Notify` · `SendEmail::sendEmail` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php:64`
- `Notify` · `SendEmailPage::sendEmail` · `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmailPage.php:74`

_… +11 gruppi in questa categoria (vedi JSON)_

### C — Corpo identico, nomi diversi (copy-paste con rename)

#### `execute` / `scheduleNotification` — 2 classi · 15 righe · ~15 righe duplicate

- `Notify` · `SchedulePushNotificationAction::execute` · `Modules/Notify/app/Actions/Push/SchedulePushNotificationAction.php:24`
- `Notify` · `PushNotificationService::scheduleNotification` · `Modules/Notify/app/Services/PushNotificationService.php:177`

### A — Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getHeaderActions` — 50 classi · 5 righe · ~245 righe duplicate

- `Notify` · `EditContact::getHeaderActions` · `Modules/Notify/app/Filament/Resources/ContactResource/Pages/EditContact.php:15`
- `Notify` · `EditNotifyTheme::getHeaderActions` · `Modules/Notify/app/Filament/Resources/NotifyThemeResource/Pages/EditNotifyTheme.php:18`
- `Activity` · `EditActivity::getHeaderActions` · `Modules/Activity/app/Filament/Resources/ActivityResource/Pages/EditActivity.php:15`
- `Incentivi` · `EditCapitalPercentage::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/CapitalPercentageResource/Pages/EditCapitalPercentage.php:15`
- `Incentivi` · `EditDefaultActivity::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/DefaultActivityResource/Pages/EditDefaultActivity.php:15`
- `Incentivi` · `EditPhase::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/PhaseResource/Pages/EditPhase.php:16`
- … +46 occorrenze

#### `getTableColumns` — 20 classi · 10 righe · ~190 righe duplicate

- `Notify` · `NotificationLogsTable::getTableColumns` · `Modules/Notify/app/Filament/Resources/NotificationLogResource/Tables/NotificationLogsTable.php:16`
- `Job` · `ExportsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ExportResource/Tables/ExportsTable.php:16`
- `Job` · `ImportsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ImportResource/Tables/ImportsTable.php:18`
- `Job` · `JobBatchsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobBatchResource/Tables/JobBatchsTable.php:16`
- `Job` · `JobManagersTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobManagerResource/Tables/JobManagersTable.php:17`
- `Job` · `JobsWaitingsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Tables/JobsWaitingsTable.php:16`
- … +14 occorrenze

#### `getFormSchema` — 4 classi · 52 righe · ~156 righe duplicate

- `Notify` · `MailTemplateResource::getFormSchema` · `Modules/Notify/app/Filament/Resources/MailTemplateResource.php:30`
- `Notify` · `MailTemplateForm::getFormSchema` · `Modules/Notify/app/Filament/Resources/MailTemplateResource/Schemas/MailTemplateForm.php:21`
- `IndennitaResponsabilita` · `MailTemplateForm::getFormSchema` · `Modules/IndennitaResponsabilita/app/Filament/Resources/MailTemplateResource/Schemas/MailTemplateForm.php:21`
- `Progressioni` · `MailTemplateForm::getFormSchema` · `Modules/Progressioni/app/Filament/Resources/MailTemplateResource/Schemas/MailTemplateForm.php:21`

#### `getFormSchema` — 19 classi · 7 righe · ~126 righe duplicate

- `Notify` · `NotificationLogForm::getFormSchema` · `Modules/Notify/app/Filament/Resources/NotificationLogResource/Schemas/NotificationLogForm.php:17`
- `Job` · `ExportForm::getFormSchema` · `Modules/Job/app/Filament/Resources/ExportResource/Schemas/ExportForm.php:17`
- `Job` · `ImportForm::getFormSchema` · `Modules/Job/app/Filament/Resources/ImportResource/Schemas/ImportForm.php:17`
- `Job` · `JobBatchForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobBatchResource/Schemas/JobBatchForm.php:17`
- `Job` · `JobManagerForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobManagerResource/Schemas/JobManagerForm.php:17`
- `Job` · `JobsWaitingForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Schemas/JobsWaitingForm.php:17`
- … +13 occorrenze

#### `casts` — 7 classi · 18 righe · ~108 righe duplicate

- `Notify` · `BaseMorphPivot::casts` · `Modules/Notify/app/Models/BaseMorphPivot.php:49`
- `Notify` · `BasePivot::casts` · `Modules/Notify/app/Models/BasePivot.php:45`
- `Job` · `BaseMorphPivot::casts` · `Modules/Job/app/Models/BaseMorphPivot.php:49`
- `User` · `TenantUser::casts` · `Modules/User/app/Models/TenantUser.php:70`
- `Xot` · `BaseMorphPivot::casts` · `Modules/Xot/app/Models/BaseMorphPivot.php:55`
- `Xot` · `XotBaseMorphPivot::casts` · `Modules/Xot/app/Models/XotBaseMorphPivot.php:117`
- … +1 occorrenze

#### `getInfolistSchema` — 12 classi · 7 righe · ~77 righe duplicate

- `Notify` · `NotificationLogInfolist::getInfolistSchema` · `Modules/Notify/app/Filament/Resources/NotificationLogResource/Schemas/NotificationLogInfolist.php:15`
- `Media` · `HasMediaInfolist::getInfolistSchema` · `Modules/Media/app/Filament/Resources/HasMediaResource/Schemas/HasMediaInfolist.php:15`
- `User` · `OauthAccessTokenInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Schemas/OauthAccessTokenInfolist.php:14`
- `User` · `OauthAuthCodeInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAuthCodeResource/Schemas/OauthAuthCodeInfolist.php:14`
- `User` · `OauthClientInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource/Schemas/OauthClientInfolist.php:14`
- `User` · `OauthDeviceCodeInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthDeviceCodeResource/Schemas/OauthDeviceCodeInfolist.php:14`
- … +6 occorrenze

#### `getFormSchema` — 2 classi · 50 righe · ~50 righe duplicate

- `Notify` · `NotificationTemplateResource::getFormSchema` · `Modules/Notify/app/Filament/Resources/NotificationTemplateResource.php:22`
- `Notify` · `NotificationTemplateForm::getFormSchema` · `Modules/Notify/app/Filament/Resources/NotificationTemplateResource/Schemas/NotificationTemplateForm.php:20`

#### `getFormSchema` — 2 classi · 31 righe · ~31 righe duplicate

- `Notify` · `NotifyThemeResource::getFormSchema` · `Modules/Notify/app/Filament/Resources/NotifyThemeResource.php:21`
- `Notify` · `NotifyThemeForm::getFormSchema` · `Modules/Notify/app/Filament/Resources/NotifyThemeResource/Schemas/NotifyThemeForm.php:20`

#### `getTableFilters` — 2 classi · 18 righe · ~18 righe duplicate

- `Notify` · `ListNotifications::getTableFilters` · `Modules/Notify/app/Filament/Resources/NotificationResource/Pages/ListNotifications.php:34`
- `Notify` · `NotificationsTable::getTableFilters` · `Modules/Notify/app/Filament/Resources/NotificationResource/Tables/NotificationsTable.php:16`

#### `getTableColumns` — 3 classi · 8 righe · ~16 righe duplicate

- `Notify` · `ListMailTemplates::getTableColumns` · `Modules/Notify/app/Filament/Resources/MailTemplateResource/Pages/ListMailTemplates.php:17`
- `IndennitaResponsabilita` · `MailTemplatesTable::getTableColumns` · `Modules/IndennitaResponsabilita/app/Filament/Resources/MailTemplateResource/Tables/MailTemplatesTable.php:15`
- `Progressioni` · `MailTemplatesTable::getTableColumns` · `Modules/Progressioni/app/Filament/Resources/MailTemplateResource/Tables/MailTemplatesTable.php:16`

_… +7 gruppi in questa categoria (vedi JSON)_

### M — Layer database (migrations/factories/seeders)

#### `run` — 8 classi · 5 righe · ~35 righe duplicate

- `Notify` · `NotifyDatabaseSeeder::run` · `Modules/Notify/database/seeders/NotifyDatabaseSeeder.php:15`
- `IndennitaCondizioniLavoro` · `IndennitaCondizioniLavoroDatabaseSeeder::run` · `Modules/IndennitaCondizioniLavoro/database/seeders/IndennitaCondizioniLavoroDatabaseSeeder.php:20`
- `IndennitaResponsabilita` · `IndennitaResponsabilitaDatabaseSeeder::run` · `Modules/IndennitaResponsabilita/database/seeders/IndennitaResponsabilitaDatabaseSeeder.php:15`
- `Lang` · `LangDatabaseSeeder::run` · `Modules/Lang/database/seeders/LangDatabaseSeeder.php:15`
- `Performance` · `PerformanceDatabaseSeeder::run` · `Modules/Performance/database/seeders/PerformanceDatabaseSeeder.php:15`
- `Progressioni` · `ProgressioniDatabaseSeeder::run` · `Modules/Progressioni/database/seeders/ProgressioniDatabaseSeeder.php:15`
- … +2 occorrenze

#### `run` — 2 classi · 3 righe · ~3 righe duplicate

- `Notify` · `NotificationSeeder::run` · `Modules/Notify/database/seeders/NotificationSeeder.php:12`
- `User` · `NotificationSeeder::run` · `Modules/User/database/seeders/NotificationSeeder.php:12`

### S — Stub banali (≤30 char) — rumore, non debito

17 gruppi — elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```

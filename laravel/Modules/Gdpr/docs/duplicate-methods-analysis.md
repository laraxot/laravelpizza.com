# Analisi Metodi Duplicati - Modulo Gdpr

**Data Generazione**: 2025-10-15 06:41:17
**Totale Gruppi di Duplicati**: 

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **Gdpr** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 0 |
| **Base Class** | 0 |
| **Interface** | 1 |
| **Altro** | 0 |

## Dettaglio Metodi Duplicati

### 1. Metodo: `casts`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 33%

**Trovato in  file105 file**:

- `BaseModel::casts` - [Modules/Activity/app/Models/BaseModel.php:56](Modules/Activity/app/Models/BaseModel.php) (Modulo: Activity)
- `Article::casts` - [Modules/Blog/app/Models/Article.php:273](Modules/Blog/app/Models/Article.php) (Modulo: Blog)
- `Banner::casts` - [Modules/Blog/app/Models/Banner.php:196](Modules/Blog/app/Models/Banner.php) (Modulo: Blog)
- `BaseModel::casts` - [Modules/Blog/app/Models/BaseModel.php:65](Modules/Blog/app/Models/BaseModel.php) (Modulo: Blog)
- `BaseMorphPivot::casts` - [Modules/Blog/app/Models/BaseMorphPivot.php:57](Modules/Blog/app/Models/BaseMorphPivot.php) (Modulo: Blog)
- `BasePivot::casts` - [Modules/Blog/app/Models/BasePivot.php:51](Modules/Blog/app/Models/BasePivot.php) (Modulo: Blog)
- `BaseTreeModel::casts` - [Modules/Blog/app/Models/BaseTreeModel.php:55](Modules/Blog/app/Models/BaseTreeModel.php) (Modulo: Blog)
- `Category::casts` - [Modules/Blog/app/Models/Category.php:200](Modules/Blog/app/Models/Category.php) (Modulo: Blog)
- `Menu::casts` - [Modules/Blog/app/Models/Menu.php:148](Modules/Blog/app/Models/Menu.php) (Modulo: Blog)
- `Taggable::casts` - [Modules/Blog/app/Models/Taggable.php:135](Modules/Blog/app/Models/Taggable.php) (Modulo: Blog)
- `Attachment::casts` - [Modules/Cms/app/Models/Attachment.php:144](Modules/Cms/app/Models/Attachment.php) (Modulo: Cms)
- `BaseModel::casts` - [Modules/Cms/app/Models/BaseModel.php:60](Modules/Cms/app/Models/BaseModel.php) (Modulo: Cms)
- `BaseModelLang::casts` - [Modules/Cms/app/Models/BaseModelLang.php:58](Modules/Cms/app/Models/BaseModelLang.php) (Modulo: Cms)
- `BaseMorphPivot::casts` - [Modules/Cms/app/Models/BaseMorphPivot.php:56](Modules/Cms/app/Models/BaseMorphPivot.php) (Modulo: Cms)
- `BasePivot::casts` - [Modules/Cms/app/Models/BasePivot.php:52](Modules/Cms/app/Models/BasePivot.php) (Modulo: Cms)
- `BaseTreeModel::casts` - [Modules/Cms/app/Models/BaseTreeModel.php:163](Modules/Cms/app/Models/BaseTreeModel.php) (Modulo: Cms)
- `Menu::casts` - [Modules/Cms/app/Models/Menu.php:190](Modules/Cms/app/Models/Menu.php) (Modulo: Cms)
- `Page::casts` - [Modules/Cms/app/Models/Page.php:123](Modules/Cms/app/Models/Page.php) (Modulo: Cms)
- `PageContent::casts` - [Modules/Cms/app/Models/PageContent.php:104](Modules/Cms/app/Models/PageContent.php) (Modulo: Cms)
- `Section::casts` - [Modules/Cms/app/Models/Section.php:84](Modules/Cms/app/Models/Section.php) (Modulo: Cms)
- `BaseModel::casts` - [Modules/Comment/app/Models/BaseModel.php:44](Modules/Comment/app/Models/BaseModel.php) (Modulo: Comment)
- `BaseMorphPivot::casts` - [Modules/Comment/app/Models/BaseMorphPivot.php:54](Modules/Comment/app/Models/BaseMorphPivot.php) (Modulo: Comment)
- `BasePivot::casts` - [Modules/Comment/app/Models/BasePivot.php:41](Modules/Comment/app/Models/BasePivot.php) (Modulo: Comment)
- `Activity::casts` - [Modules/Fixcity/app/Models/Activity.php:50](Modules/Fixcity/app/Models/Activity.php) (Modulo: Fixcity)
- `BaseModel::casts` - [Modules/Fixcity/app/Models/BaseModel.php:47](Modules/Fixcity/app/Models/BaseModel.php) (Modulo: Fixcity)
- `BasePivot::casts` - [Modules/Fixcity/app/Models/BasePivot.php:49](Modules/Fixcity/app/Models/BasePivot.php) (Modulo: Fixcity)
- `Category::casts` - [Modules/Fixcity/app/Models/Category.php:117](Modules/Fixcity/app/Models/Category.php) (Modulo: Fixcity)
- `Faq::casts` - [Modules/Fixcity/app/Models/Faq.php:63](Modules/Fixcity/app/Models/Faq.php) (Modulo: Fixcity)
- `FaqCategory::casts` - [Modules/Fixcity/app/Models/FaqCategory.php:67](Modules/Fixcity/app/Models/FaqCategory.php) (Modulo: Fixcity)
- `PushSubscription::casts` - [Modules/Fixcity/app/Models/PushSubscription.php:58](Modules/Fixcity/app/Models/PushSubscription.php) (Modulo: Fixcity)
- `Ticket::casts` - [Modules/Fixcity/app/Models/Ticket.php:188](Modules/Fixcity/app/Models/Ticket.php) (Modulo: Fixcity)
- `TicketCategory::casts` - [Modules/Fixcity/app/Models/TicketCategory.php:51](Modules/Fixcity/app/Models/TicketCategory.php) (Modulo: Fixcity)
- `BaseModel::casts` - [Modules/Gdpr/app/Models/BaseModel.php:58](Modules/Gdpr/app/Models/BaseModel.php)
- `BaseMorphPivot::casts` - [Modules/Gdpr/app/Models/BaseMorphPivot.php:67](Modules/Gdpr/app/Models/BaseMorphPivot.php)
- `BasePivot::casts` - [Modules/Gdpr/app/Models/BasePivot.php:47](Modules/Gdpr/app/Models/BasePivot.php)
- `Address::casts` - [Modules/Geo/app/Models/Address.php:190](Modules/Geo/app/Models/Address.php) (Modulo: Geo)
- `BaseModel::casts` - [Modules/Geo/app/Models/BaseModel.php:59](Modules/Geo/app/Models/BaseModel.php) (Modulo: Geo)
- `BaseMorphPivot::casts` - [Modules/Geo/app/Models/BaseMorphPivot.php:59](Modules/Geo/app/Models/BaseMorphPivot.php) (Modulo: Geo)
- `BasePivot::casts` - [Modules/Geo/app/Models/BasePivot.php:45](Modules/Geo/app/Models/BasePivot.php) (Modulo: Geo)
- `Comune::casts` - [Modules/Geo/app/Models/Comune.php:131](Modules/Geo/app/Models/Comune.php) (Modulo: Geo)
- `Locality::casts` - [Modules/Geo/app/Models/Locality.php:53](Modules/Geo/app/Models/Locality.php) (Modulo: Geo)
- `Location::casts` - [Modules/Geo/app/Models/Location.php:89](Modules/Geo/app/Models/Location.php) (Modulo: Geo)
- `Place::casts` - [Modules/Geo/app/Models/Place.php:117](Modules/Geo/app/Models/Place.php) (Modulo: Geo)
- `BaseModel::casts` - [Modules/Job/app/Models/BaseModel.php:74](Modules/Job/app/Models/BaseModel.php) (Modulo: Job)
- `BaseMorphPivot::casts` - [Modules/Job/app/Models/BaseMorphPivot.php:56](Modules/Job/app/Models/BaseMorphPivot.php) (Modulo: Job)
- `Export::casts` - [Modules/Job/app/Models/Export.php:77](Modules/Job/app/Models/Export.php) (Modulo: Job)
- `FailedImportRow::casts` - [Modules/Job/app/Models/FailedImportRow.php:81](Modules/Job/app/Models/FailedImportRow.php) (Modulo: Job)
- `FailedJob::casts` - [Modules/Job/app/Models/FailedJob.php:81](Modules/Job/app/Models/FailedJob.php) (Modulo: Job)
- `Import::casts` - [Modules/Job/app/Models/Import.php:120](Modules/Job/app/Models/Import.php) (Modulo: Job)
- `Job::casts` - [Modules/Job/app/Models/Job.php:134](Modules/Job/app/Models/Job.php) (Modulo: Job)
- `JobBatch::casts` - [Modules/Job/app/Models/JobBatch.php:182](Modules/Job/app/Models/JobBatch.php) (Modulo: Job)
- `JobManager::casts` - [Modules/Job/app/Models/JobManager.php:163](Modules/Job/app/Models/JobManager.php) (Modulo: Job)
- `Result::casts` - [Modules/Job/app/Models/Result.php:111](Modules/Job/app/Models/Result.php) (Modulo: Job)
- `Schedule::casts` - [Modules/Job/app/Models/Schedule.php:209](Modules/Job/app/Models/Schedule.php) (Modulo: Job)
- `ScheduleHistory::casts` - [Modules/Job/app/Models/ScheduleHistory.php:129](Modules/Job/app/Models/ScheduleHistory.php) (Modulo: Job)
- `Task::casts` - [Modules/Job/app/Models/Task.php:355](Modules/Job/app/Models/Task.php) (Modulo: Job)
- `TaskComment::casts` - [Modules/Job/app/Models/TaskComment.php:57](Modules/Job/app/Models/TaskComment.php) (Modulo: Job)
- `BaseModel::casts` - [Modules/Lang/app/Models/BaseModel.php:63](Modules/Lang/app/Models/BaseModel.php) (Modulo: Lang)
- `BaseModelLang::casts` - [Modules/Lang/app/Models/BaseModelLang.php:71](Modules/Lang/app/Models/BaseModelLang.php) (Modulo: Lang)
- `BaseMorphPivot::casts` - [Modules/Lang/app/Models/BaseMorphPivot.php:55](Modules/Lang/app/Models/BaseMorphPivot.php) (Modulo: Lang)
- `Post::casts` - [Modules/Lang/app/Models/Post.php:292](Modules/Lang/app/Models/Post.php) (Modulo: Lang)
- `TranslationFile::casts` - [Modules/Lang/app/Models/TranslationFile.php:90](Modules/Lang/app/Models/TranslationFile.php) (Modulo: Lang)
- `BaseModel::casts` - [Modules/Media/app/Models/BaseModel.php:61](Modules/Media/app/Models/BaseModel.php) (Modulo: Media)
- `Media::casts` - [Modules/Media/app/Models/Media.php:340](Modules/Media/app/Models/Media.php) (Modulo: Media)
- `BaseModel::casts` - [Modules/Notify/app/Models/BaseModel.php:60](Modules/Notify/app/Models/BaseModel.php) (Modulo: Notify)
- `BaseMorphPivot::casts` - [Modules/Notify/app/Models/BaseMorphPivot.php:56](Modules/Notify/app/Models/BaseMorphPivot.php) (Modulo: Notify)
- `BasePivot::casts` - [Modules/Notify/app/Models/BasePivot.php:52](Modules/Notify/app/Models/BasePivot.php) (Modulo: Notify)
- `Contact::casts` - [Modules/Notify/app/Models/Contact.php:179](Modules/Notify/app/Models/Contact.php) (Modulo: Notify)
- `MailTemplate::casts` - [Modules/Notify/app/Models/MailTemplate.php:100](Modules/Notify/app/Models/MailTemplate.php) (Modulo: Notify)
- `MailTemplateLog::casts` - [Modules/Notify/app/Models/MailTemplateLog.php:68](Modules/Notify/app/Models/MailTemplateLog.php) (Modulo: Notify)
- `MailTemplateVersion::casts` - [Modules/Notify/app/Models/MailTemplateVersion.php:132](Modules/Notify/app/Models/MailTemplateVersion.php) (Modulo: Notify)
- `Notification::casts` - [Modules/Notify/app/Models/Notification.php:114](Modules/Notify/app/Models/Notification.php) (Modulo: Notify)
- `NotificationLog::casts` - [Modules/Notify/app/Models/NotificationLog.php:83](Modules/Notify/app/Models/NotificationLog.php) (Modulo: Notify)
- `NotificationTemplate::casts` - [Modules/Notify/app/Models/NotificationTemplate.php:120](Modules/Notify/app/Models/NotificationTemplate.php) (Modulo: Notify)
- `NotificationTemplateVersion::casts` - [Modules/Notify/app/Models/NotificationTemplateVersion.php:67](Modules/Notify/app/Models/NotificationTemplateVersion.php) (Modulo: Notify)
- `NotifyTheme::casts` - [Modules/Notify/app/Models/NotifyTheme.php:186](Modules/Notify/app/Models/NotifyTheme.php) (Modulo: Notify)
- `BaseModel::casts` - [Modules/Rating/app/Models/BaseModel.php:55](Modules/Rating/app/Models/BaseModel.php) (Modulo: Rating)
- `BaseMorphPivot::casts` - [Modules/Rating/app/Models/BaseMorphPivot.php:59](Modules/Rating/app/Models/BaseMorphPivot.php) (Modulo: Rating)
- `Rating::casts` - [Modules/Rating/app/Models/Rating.php:132](Modules/Rating/app/Models/Rating.php) (Modulo: Rating)
- `BaseModel::casts` - [Modules/Tenant/app/Models/BaseModel.php:61](Modules/Tenant/app/Models/BaseModel.php) (Modulo: Tenant)
- `Tenant::casts` - [Modules/Tenant/app/Models/Tenant.php:93](Modules/Tenant/app/Models/Tenant.php) (Modulo: Tenant)
- `TestSushiModel::casts` - [Modules/Tenant/app/Models/TestSushiModel.php:127](Modules/Tenant/app/Models/TestSushiModel.php) (Modulo: Tenant)
- `name::casts` - [Modules/User/app/Models/Authentication.php:74](Modules/User/app/Models/Authentication.php) (Modulo: User)
- `AuthenticationLog::casts` - [Modules/User/app/Models/AuthenticationLog.php:62](Modules/User/app/Models/AuthenticationLog.php) (Modulo: User)
- `BaseModel::casts` - [Modules/User/app/Models/BaseModel.php:58](Modules/User/app/Models/BaseModel.php) (Modulo: User)
- `BaseMorphPivot::casts` - [Modules/User/app/Models/BaseMorphPivot.php:65](Modules/User/app/Models/BaseMorphPivot.php) (Modulo: User)
- `BasePivot::casts` - [Modules/User/app/Models/BasePivot.php:49](Modules/User/app/Models/BasePivot.php) (Modulo: User)
- `BaseProfile::casts` - [Modules/User/app/Models/BaseProfile.php:169](Modules/User/app/Models/BaseProfile.php) (Modulo: User)
- `BaseUser::casts` - [Modules/User/app/Models/BaseUser.php:85](Modules/User/app/Models/BaseUser.php) (Modulo: User)
- `BaseUuidModel::casts` - [Modules/User/app/Models/BaseUuidModel.php:59](Modules/User/app/Models/BaseUuidModel.php) (Modulo: User)
- `Device::casts` - [Modules/User/app/Models/Device.php:60](Modules/User/app/Models/Device.php) (Modulo: User)
- `DeviceUser::casts` - [Modules/User/app/Models/DeviceUser.php:100](Modules/User/app/Models/DeviceUser.php) (Modulo: User)
- `ModelHasRole::casts` - [Modules/User/app/Models/ModelHasRole.php:75](Modules/User/app/Models/ModelHasRole.php) (Modulo: User)
- `Notification::casts` - [Modules/User/app/Models/Notification.php:80](Modules/User/app/Models/Notification.php) (Modulo: User)
- `OauthAccessToken::casts` - [Modules/User/app/Models/OauthAccessToken.php:57](Modules/User/app/Models/OauthAccessToken.php) (Modulo: User)
- `OauthClient::casts` - [Modules/User/app/Models/OauthClient.php:62](Modules/User/app/Models/OauthClient.php) (Modulo: User)
- `PermissionRole::casts` - [Modules/User/app/Models/PermissionRole.php:53](Modules/User/app/Models/PermissionRole.php) (Modulo: User)
- `SocialProvider::casts` - [Modules/User/app/Models/SocialProvider.php:105](Modules/User/app/Models/SocialProvider.php) (Modulo: User)
- `Team::casts` - [Modules/User/app/Models/Team.php:34](Modules/User/app/Models/Team.php) (Modulo: User)
- `Tenant::casts` - [Modules/User/app/Models/Tenant.php:45](Modules/User/app/Models/Tenant.php) (Modulo: User)
- `BaseExtra::casts` - [Modules/Xot/app/Models/BaseExtra.php:80](Modules/Xot/app/Models/BaseExtra.php) (Modulo: Xot)
- `BaseModel::casts` - [Modules/Xot/app/Models/BaseModel.php:55](Modules/Xot/app/Models/BaseModel.php) (Modulo: Xot)
- `BaseMorphPivot::casts` - [Modules/Xot/app/Models/BaseMorphPivot.php:99](Modules/Xot/app/Models/BaseMorphPivot.php) (Modulo: Xot)
- `Log::casts` - [Modules/Xot/app/Models/Log.php:91](Modules/Xot/app/Models/Log.php) (Modulo: Xot)
- `Module::casts` - [Modules/Xot/app/Models/Module.php:81](Modules/Xot/app/Models/Module.php) (Modulo: Xot)

**Signature**:
```php
protected function casts(): array
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (105 occorrenze)
- Manutenibilità migliorata
- Consistenza tra moduli
- Contratto chiaro tra moduli
- Flessibilità implementativa

##### ⚠️ Rischi e Considerazioni

- Rischio basso, monitorare test
- Confidenza non ottimale - verificare manualmente
- Verificare compatibilità PHPStan Level Max

##### 💡 Raccomandazione

**Analisi manuale richiesta** - Le differenze tra le implementazioni potrebbero essere significative.

---


---

## Legenda

### Tipo di Refactoring

- **Trait**: Metodi con implementazione identica o molto simile
- **Base Class**: Metodi con logica comune ma implementazioni variabili
- **Interface**: Metodi con stessa signature ma implementazioni diverse
- **Pattern**: Metodi che seguono pattern simili ma richiedono analisi più approfondita

### Complessità di Refactoring

- **Low**: Refactoring semplice, basso rischio
- **Medium**: Refactoring moderato, richiede test accurati
- **High**: Refactoring complesso, richiede analisi approfondita

### Percentuale di Confidenza

Indica quanto è probabile che il refactoring sia vantaggioso:
- **90-100%**: Altamente raccomandato
- **70-89%**: Raccomandato
- **50-69%**: Valutare caso per caso
- **< 50%**: Richiede analisi dettagliata


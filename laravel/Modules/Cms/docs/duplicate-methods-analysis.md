# Analisi Metodi Duplicati - Modulo Cms

**Data Generazione**: 2025-10-15 06:41:17
**Totale Gruppi di Duplicati**: 

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **Cms** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 3 |
| **Base Class** | 0 |
| **Interface** | 4 |
| **Altro** | 2 |

## Dettaglio Metodi Duplicati

### 1. Metodo: `sluggable`

**Tipo Refactoring**: `Trait` | **Complessità**: 🟢 Low | **Confidenza**: ✅ 100%

**Trovato in  file3 file**:

- `Article::sluggable` - [Modules/Blog/app/Models/Article.php:385](Modules/Blog/app/Models/Article.php) (Modulo: Blog)
- `BaseModelLang::sluggable` - [Modules/Cms/app/Models/BaseModelLang.php:44](Modules/Cms/app/Models/BaseModelLang.php)
- `PageContent::sluggable` - [Modules/Cms/app/Models/PageContent.php:90](Modules/Cms/app/Models/PageContent.php)

**Signature**:
```php
public function sluggable(): array
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (3 occorrenze)
- Manutenibilità migliorata
- Consistenza tra moduli
- Riuso semplice tramite Trait
- Nessuna modifica alla gerarchia delle classi

##### ⚠️ Rischi e Considerazioni

- Rischio basso, monitorare test
- Verificare compatibilità PHPStan Level Max

##### 💡 Raccomandazione

**Procedere con refactoring** - Alta confidenza e bassa complessità rendono questa ottimizzazione sicura.

---

### 2. Metodo: `getLabel`

**Tipo Refactoring**: `Trait` | **Complessità**: 🟢 Low | **Confidenza**: ✅ 100%

**Trovato in  file2 file**:

- `BaseTreeModel::getLabel` - [Modules/Cms/app/Models/BaseTreeModel.php:173](Modules/Cms/app/Models/BaseTreeModel.php)
- `Menu::getLabel` - [Modules/Cms/app/Models/Menu.php:183](Modules/Cms/app/Models/Menu.php)

**Signature**:
```php
public function getLabel(): string
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (2 occorrenze)
- Manutenibilità migliorata
- Consistenza tra moduli
- Riuso semplice tramite Trait
- Nessuna modifica alla gerarchia delle classi

##### ⚠️ Rischi e Considerazioni

- Rischio basso, monitorare test
- Verificare compatibilità PHPStan Level Max

##### 💡 Raccomandazione

**Procedere con refactoring** - Alta confidenza e bassa complessità rendono questa ottimizzazione sicura.

---

### 3. Metodo: `getTreeMenuOptions`

**Tipo Refactoring**: `Trait` | **Complessità**: 🟢 Low | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `Menu::getTreeMenuOptions` - [Modules/Blog/app/Models/Menu.php:122](Modules/Blog/app/Models/Menu.php) (Modulo: Blog)
- `Menu::getTreeMenuOptions` - [Modules/Cms/app/Models/Menu.php:163](Modules/Cms/app/Models/Menu.php)

**Signature**:
```php
public static function getTreeMenuOptions(): array
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (2 occorrenze)
- Manutenibilità migliorata
- Consistenza tra moduli
- Riuso semplice tramite Trait
- Nessuna modifica alla gerarchia delle classi

##### ⚠️ Rischi e Considerazioni

- Rischio basso, monitorare test
- Confidenza non ottimale - verificare manualmente
- Verificare compatibilità PHPStan Level Max

##### 💡 Raccomandazione

**Valutare attentamente** - Analizzare le implementazioni specifiche prima di procedere.

---

### 4. Metodo: `asset`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `Attachment::asset` - [Modules/Cms/app/Models/Attachment.php:186](Modules/Cms/app/Models/Attachment.php)
- `UIService::asset` - [Modules/UI/app/Services/UIService.php:11](Modules/UI/app/Services/UIService.php) (Modulo: UI)

**Signature**:
```php
public function asset(): string
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (2 occorrenze)
- Manutenibilità migliorata
- Consistenza tra moduli
- Contratto chiaro tra moduli
- Flessibilità implementativa

##### ⚠️ Rischi e Considerazioni

- Rischio basso, monitorare test
- Confidenza non ottimale - verificare manualmente
- Verificare compatibilità PHPStan Level Max

##### 💡 Raccomandazione

**Valutare attentamente** - Analizzare le implementazioni specifiche prima di procedere.

---

### 5. Metodo: `getRouteKeyName`

**Tipo Refactoring**: `Pattern` | **Complessità**: 🔴 High | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `Conf::getRouteKeyName` - [Modules/Cms/app/Models/Conf.php:52](Modules/Cms/app/Models/Conf.php)
- `Module::getRouteKeyName` - [Modules/Cms/app/Models/Module.php:67](Modules/Cms/app/Models/Module.php)

**Signature**:
```php
public function getRouteKeyName(): string
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (2 occorrenze)
- Manutenibilità migliorata
- Consistenza tra moduli

##### ⚠️ Rischi e Considerazioni

- Complessità elevata del refactoring
- Possibili breaking changes
- Confidenza non ottimale - verificare manualmente
- Verificare compatibilità PHPStan Level Max

##### 💡 Raccomandazione

**Valutare attentamente** - Analizzare le implementazioni specifiche prima di procedere.

---

### 6. Metodo: `getRows`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 38%

**Trovato in  file18 file**:

- `Attachment::getRows` - [Modules/Cms/app/Models/Attachment.php:132](Modules/Cms/app/Models/Attachment.php)
- `Conf::getRows` - [Modules/Cms/app/Models/Conf.php:37](Modules/Cms/app/Models/Conf.php)
- `Menu::getRows` - [Modules/Cms/app/Models/Menu.php:177](Modules/Cms/app/Models/Menu.php)
- `Module::getRows` - [Modules/Cms/app/Models/Module.php:45](Modules/Cms/app/Models/Module.php)
- `Page::getRows` - [Modules/Cms/app/Models/Page.php:113](Modules/Cms/app/Models/Page.php)
- `PageContent::getRows` - [Modules/Cms/app/Models/PageContent.php:82](Modules/Cms/app/Models/PageContent.php)
- `Section::getRows` - [Modules/Cms/app/Models/Section.php:99](Modules/Cms/app/Models/Section.php)
- `Comune::getRows` - [Modules/Geo/app/Models/Comune.php:124](Modules/Geo/app/Models/Comune.php) (Modulo: Geo)
- `Locality::getRows` - [Modules/Geo/app/Models/Locality.php:70](Modules/Geo/app/Models/Locality.php) (Modulo: Geo)
- `Province::getRows` - [Modules/Geo/app/Models/Province.php:51](Modules/Geo/app/Models/Province.php) (Modulo: Geo)
- `Region::getRows` - [Modules/Geo/app/Models/Region.php:63](Modules/Geo/app/Models/Region.php) (Modulo: Geo)
- `TranslationFile::getRows` - [Modules/Lang/app/Models/TranslationFile.php:100](Modules/Lang/app/Models/TranslationFile.php) (Modulo: Lang)
- `Domain::getRows` - [Modules/Tenant/app/Models/Domain.php:41](Modules/Tenant/app/Models/Domain.php) (Modulo: Tenant)
- `TestSushiModel::getRows` - [Modules/Tenant/app/Models/TestSushiModel.php:98](Modules/Tenant/app/Models/TestSushiModel.php) (Modulo: Tenant)
- `SocialProvider::getRows` - [Modules/User/app/Models/SocialProvider.php:98](Modules/User/app/Models/SocialProvider.php) (Modulo: User)
- `InformationSchemaTable::getRows` - [Modules/Xot/app/Models/InformationSchemaTable.php:137](Modules/Xot/app/Models/InformationSchemaTable.php) (Modulo: Xot)
- `Log::getRows` - [Modules/Xot/app/Models/Log.php:66](Modules/Xot/app/Models/Log.php) (Modulo: Xot)
- `Module::getRows` - [Modules/Xot/app/Models/Module.php:56](Modules/Xot/app/Models/Module.php) (Modulo: Xot)

**Signature**:
```php
public function getRows(): array
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (18 occorrenze)
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

### 7. Metodo: `casts`

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
- `Attachment::casts` - [Modules/Cms/app/Models/Attachment.php:144](Modules/Cms/app/Models/Attachment.php)
- `BaseModel::casts` - [Modules/Cms/app/Models/BaseModel.php:60](Modules/Cms/app/Models/BaseModel.php)
- `BaseModelLang::casts` - [Modules/Cms/app/Models/BaseModelLang.php:58](Modules/Cms/app/Models/BaseModelLang.php)
- `BaseMorphPivot::casts` - [Modules/Cms/app/Models/BaseMorphPivot.php:56](Modules/Cms/app/Models/BaseMorphPivot.php)
- `BasePivot::casts` - [Modules/Cms/app/Models/BasePivot.php:52](Modules/Cms/app/Models/BasePivot.php)
- `BaseTreeModel::casts` - [Modules/Cms/app/Models/BaseTreeModel.php:163](Modules/Cms/app/Models/BaseTreeModel.php)
- `Menu::casts` - [Modules/Cms/app/Models/Menu.php:190](Modules/Cms/app/Models/Menu.php)
- `Page::casts` - [Modules/Cms/app/Models/Page.php:123](Modules/Cms/app/Models/Page.php)
- `PageContent::casts` - [Modules/Cms/app/Models/PageContent.php:104](Modules/Cms/app/Models/PageContent.php)
- `Section::casts` - [Modules/Cms/app/Models/Section.php:84](Modules/Cms/app/Models/Section.php)
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
- `BaseModel::casts` - [Modules/Gdpr/app/Models/BaseModel.php:58](Modules/Gdpr/app/Models/BaseModel.php) (Modulo: Gdpr)
- `BaseMorphPivot::casts` - [Modules/Gdpr/app/Models/BaseMorphPivot.php:67](Modules/Gdpr/app/Models/BaseMorphPivot.php) (Modulo: Gdpr)
- `BasePivot::casts` - [Modules/Gdpr/app/Models/BasePivot.php:47](Modules/Gdpr/app/Models/BasePivot.php) (Modulo: Gdpr)
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

### 8. Metodo: `registerMediaCollections`

**Tipo Refactoring**: `Pattern` | **Complessità**: 🔴 High | **Confidenza**: ❌ 33%

**Trovato in  file3 file**:

- `Attachment::registerMediaCollections` - [Modules/Cms/app/Models/Attachment.php:158](Modules/Cms/app/Models/Attachment.php)
- `Ticket::registerMediaCollections` - [Modules/Fixcity/app/Models/Ticket.php:526](Modules/Fixcity/app/Models/Ticket.php) (Modulo: Fixcity)
- `NotificationTemplate::registerMediaCollections` - [Modules/Notify/app/Models/NotificationTemplate.php:141](Modules/Notify/app/Models/NotificationTemplate.php) (Modulo: Notify)

**Signature**:
```php
public function registerMediaCollections(): void
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (3 occorrenze)
- Manutenibilità migliorata
- Consistenza tra moduli

##### ⚠️ Rischi e Considerazioni

- Complessità elevata del refactoring
- Possibili breaking changes
- Confidenza non ottimale - verificare manualmente
- Verificare compatibilità PHPStan Level Max

##### 💡 Raccomandazione

**Analisi manuale richiesta** - Le differenze tra le implementazioni potrebbero essere significative.

---

### 9. Metodo: `execute`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 9%

**Trovato in  file62 file**:

- `CompletionAction::execute` - [Modules/AI/app/Actions/CompletionAction.php:18](Modules/AI/app/Actions/CompletionAction.php) (Modulo: AI)
- `BasicSentimentAnalyzer::execute` - [Modules/AI/app/Actions/SentimentAction.php:91](Modules/AI/app/Actions/SentimentAction.php) (Modulo: AI)
- `LogActivityAction::execute` - [Modules/Activity/app/Actions/LogActivityAction.php:31](Modules/Activity/app/Actions/LogActivityAction.php) (Modulo: Activity)
- `LogModelCreatedAction::execute` - [Modules/Activity/app/Actions/LogModelCreatedAction.php:28](Modules/Activity/app/Actions/LogModelCreatedAction.php) (Modulo: Activity)
- `LogModelDeletedAction::execute` - [Modules/Activity/app/Actions/LogModelDeletedAction.php:28](Modules/Activity/app/Actions/LogModelDeletedAction.php) (Modulo: Activity)
- `LogModelUpdatedAction::execute` - [Modules/Activity/app/Actions/LogModelUpdatedAction.php:28](Modules/Activity/app/Actions/LogModelUpdatedAction.php) (Modulo: Activity)
- `LogUserLoginAction::execute` - [Modules/Activity/app/Actions/LogUserLoginAction.php:26](Modules/Activity/app/Actions/LogUserLoginAction.php) (Modulo: Activity)
- `LogUserLogoutAction::execute` - [Modules/Activity/app/Actions/LogUserLogoutAction.php:26](Modules/Activity/app/Actions/LogUserLogoutAction.php) (Modulo: Activity)
- `ImportFromNewsApi::execute` - [Modules/Blog/app/Actions/ImportFromNewsApi.php:20](Modules/Blog/app/Actions/ImportFromNewsApi.php) (Modulo: Blog)
- `GetStyleClassAction::execute` - [Modules/Cms/app/Actions/GetStyleClassAction.php:15](Modules/Cms/app/Actions/GetStyleClassAction.php)
- `GetViewThemeByViewAction::execute` - [Modules/Cms/app/Actions/GetViewThemeByViewAction.php:13](Modules/Cms/app/Actions/GetViewThemeByViewAction.php)
- `SaveFooterConfigAction::execute` - [Modules/Cms/app/Actions/SaveFooterConfigAction.php:14](Modules/Cms/app/Actions/SaveFooterConfigAction.php)
- `SaveHeadernavConfigAction::execute` - [Modules/Cms/app/Actions/SaveHeadernavConfigAction.php:12](Modules/Cms/app/Actions/SaveHeadernavConfigAction.php)
- `ChangeStatus::execute` - [Modules/Fixcity/app/Actions/ChangeStatus.php:12](Modules/Fixcity/app/Actions/ChangeStatus.php) (Modulo: Fixcity)
- `GenerateTicketsAction::execute` - [Modules/Fixcity/app/Actions/GenerateTicketsAction.php:24](Modules/Fixcity/app/Actions/GenerateTicketsAction.php) (Modulo: Fixcity)
- `CalculateDistanceAction::execute` - [Modules/Geo/app/Actions/CalculateDistanceAction.php:47](Modules/Geo/app/Actions/CalculateDistanceAction.php) (Modulo: Geo)
- `ClusterLocationsAction::execute` - [Modules/Geo/app/Actions/ClusterLocationsAction.php:25](Modules/Geo/app/Actions/ClusterLocationsAction.php) (Modulo: Geo)
- `FilterCoordinatesAction::execute` - [Modules/Geo/app/Actions/FilterCoordinatesAction.php:29](Modules/Geo/app/Actions/FilterCoordinatesAction.php) (Modulo: Geo)
- `FilterCoordinatesInRadius::execute` - [Modules/Geo/app/Actions/FilterCoordinatesInRadius.php:15](Modules/Geo/app/Actions/FilterCoordinatesInRadius.php) (Modulo: Geo)
- `FilterCoordinatesInRadiusAction::execute` - [Modules/Geo/app/Actions/FilterCoordinatesInRadiusAction.php:31](Modules/Geo/app/Actions/FilterCoordinatesInRadiusAction.php) (Modulo: Geo)
- `FormatCoordinatesAction::execute` - [Modules/Geo/app/Actions/FormatCoordinatesAction.php:11](Modules/Geo/app/Actions/FormatCoordinatesAction.php) (Modulo: Geo)
- `GetAddressDataFromFullAddressAction::execute` - [Modules/Geo/app/Actions/GetAddressDataFromFullAddressAction.php:36](Modules/Geo/app/Actions/GetAddressDataFromFullAddressAction.php) (Modulo: Geo)
- `GetBoundingBoxAction::execute` - [Modules/Geo/app/Actions/GetBoundingBoxAction.php:12](Modules/Geo/app/Actions/GetBoundingBoxAction.php) (Modulo: Geo)
- `GetCoordinatesAction::execute` - [Modules/Geo/app/Actions/GetCoordinatesAction.php:23](Modules/Geo/app/Actions/GetCoordinatesAction.php) (Modulo: Geo)
- `GetCoordinatesByAddressAction::execute` - [Modules/Geo/app/Actions/GetCoordinatesByAddressAction.php:13](Modules/Geo/app/Actions/GetCoordinatesByAddressAction.php) (Modulo: Geo)
- `OptimizeRouteAction::execute` - [Modules/Geo/app/Actions/OptimizeRouteAction.php:25](Modules/Geo/app/Actions/OptimizeRouteAction.php) (Modulo: Geo)
- `UpdateCoordinatesAction::execute` - [Modules/Geo/app/Actions/UpdateCoordinatesAction.php:24](Modules/Geo/app/Actions/UpdateCoordinatesAction.php) (Modulo: Geo)
- `ValidateCoordinatesAction::execute` - [Modules/Geo/app/Actions/ValidateCoordinatesAction.php:9](Modules/Geo/app/Actions/ValidateCoordinatesAction.php) (Modulo: Geo)
- `DummyAction::execute` - [Modules/Job/app/Actions/DummyAction.php:16](Modules/Job/app/Actions/DummyAction.php) (Modulo: Job)
- `ExecuteTaskAction::execute` - [Modules/Job/app/Actions/ExecuteTaskAction.php:12](Modules/Job/app/Actions/ExecuteTaskAction.php) (Modulo: Job)
- `GetTaskCommandsAction::execute` - [Modules/Job/app/Actions/GetTaskCommandsAction.php:16](Modules/Job/app/Actions/GetTaskCommandsAction.php) (Modulo: Job)
- `GetTaskFrequenciesAction::execute` - [Modules/Job/app/Actions/GetTaskFrequenciesAction.php:17](Modules/Job/app/Actions/GetTaskFrequenciesAction.php) (Modulo: Job)
- `GetAllModuleTranslationAction::execute` - [Modules/Lang/app/Actions/GetAllModuleTranslationAction.php:20](Modules/Lang/app/Actions/GetAllModuleTranslationAction.php) (Modulo: Lang)
- `GetAllTranslationAction::execute` - [Modules/Lang/app/Actions/GetAllTranslationAction.php:20](Modules/Lang/app/Actions/GetAllTranslationAction.php) (Modulo: Lang)
- `GetTransPathAction::execute` - [Modules/Lang/app/Actions/GetTransPathAction.php:20](Modules/Lang/app/Actions/GetTransPathAction.php) (Modulo: Lang)
- `PublishTranslationAction::execute` - [Modules/Lang/app/Actions/PublishTranslationAction.php:21](Modules/Lang/app/Actions/PublishTranslationAction.php) (Modulo: Lang)
- `ReadTranslationFileAction::execute` - [Modules/Lang/app/Actions/ReadTranslationFileAction.php:22](Modules/Lang/app/Actions/ReadTranslationFileAction.php) (Modulo: Lang)
- `SaveTransAction::execute` - [Modules/Lang/app/Actions/SaveTransAction.php:21](Modules/Lang/app/Actions/SaveTransAction.php) (Modulo: Lang)
- `SyncTranslationsAction::execute` - [Modules/Lang/app/Actions/SyncTranslationsAction.php:23](Modules/Lang/app/Actions/SyncTranslationsAction.php) (Modulo: Lang)
- `TransArrayAction::execute` - [Modules/Lang/app/Actions/TransArrayAction.php:25](Modules/Lang/app/Actions/TransArrayAction.php) (Modulo: Lang)
- `TransCollectionAction::execute` - [Modules/Lang/app/Actions/TransCollectionAction.php:26](Modules/Lang/app/Actions/TransCollectionAction.php) (Modulo: Lang)
- `WriteTranslationFileAction::execute` - [Modules/Lang/app/Actions/WriteTranslationFileAction.php:29](Modules/Lang/app/Actions/WriteTranslationFileAction.php) (Modulo: Lang)
- `GetAttachmentsSchemaAction::execute` - [Modules/Media/app/Actions/GetAttachmentsSchemaAction.php:36](Modules/Media/app/Actions/GetAttachmentsSchemaAction.php) (Modulo: Media)
- `SaveAttachmentsAction::execute` - [Modules/Media/app/Actions/SaveAttachmentsAction.php:17](Modules/Media/app/Actions/SaveAttachmentsAction.php) (Modulo: Media)
- `BuildMailMessageAction::execute` - [Modules/Notify/app/Actions/BuildMailMessageAction.php:21](Modules/Notify/app/Actions/BuildMailMessageAction.php) (Modulo: Notify)
- `EsendexSendAction::execute` - [Modules/Notify/app/Actions/EsendexSendAction.php:31](Modules/Notify/app/Actions/EsendexSendAction.php) (Modulo: Notify)
- `NetfunSendAction::execute` - [Modules/Notify/app/Actions/NetfunSendAction.php:40](Modules/Notify/app/Actions/NetfunSendAction.php) (Modulo: Notify)
- `SendAppointmentNotificationAction::execute` - [Modules/Notify/app/Actions/SendAppointmentNotificationAction.php:31](Modules/Notify/app/Actions/SendAppointmentNotificationAction.php) (Modulo: Notify)
- `SendNotificationAction::execute` - [Modules/Notify/app/Actions/SendNotificationAction.php:34](Modules/Notify/app/Actions/SendNotificationAction.php) (Modulo: Notify)
- `SmtpMailSendAction::execute` - [Modules/Notify/app/Actions/SmtpMailSendAction.php:16](Modules/Notify/app/Actions/SmtpMailSendAction.php) (Modulo: Notify)
- `GetTenantNameAction::execute` - [Modules/Tenant/app/Actions/GetTenantNameAction.php:23](Modules/Tenant/app/Actions/GetTenantNameAction.php) (Modulo: Tenant)
- `GetUserDataAction::execute` - [Modules/UI/app/Actions/GetUserDataAction.php:14](Modules/UI/app/Actions/GetUserDataAction.php) (Modulo: UI)
- `GetCurrentDeviceAction::execute` - [Modules/User/app/Actions/GetCurrentDeviceAction.php:25](Modules/User/app/Actions/GetCurrentDeviceAction.php) (Modulo: User)
- `ExecuteArtisanCommandAction::execute` - [Modules/Xot/app/Actions/ExecuteArtisanCommandAction.php:50](Modules/Xot/app/Actions/ExecuteArtisanCommandAction.php) (Modulo: Xot)
- `GeneratePdfAction::execute` - [Modules/Xot/app/Actions/GeneratePdfAction.php:14](Modules/Xot/app/Actions/GeneratePdfAction.php) (Modulo: Xot)
- `GetModelByModelTypeAction::execute` - [Modules/Xot/app/Actions/GetModelByModelTypeAction.php:23](Modules/Xot/app/Actions/GetModelByModelTypeAction.php) (Modulo: Xot)
- `GetModelClassByModelTypeAction::execute` - [Modules/Xot/app/Actions/GetModelClassByModelTypeAction.php:22](Modules/Xot/app/Actions/GetModelClassByModelTypeAction.php) (Modulo: Xot)
- `GetModelTypeByModelAction::execute` - [Modules/Xot/app/Actions/GetModelTypeByModelAction.php:22](Modules/Xot/app/Actions/GetModelTypeByModelAction.php) (Modulo: Xot)
- `GetTransKeyAction::execute` - [Modules/Xot/app/Actions/GetTransKeyAction.php:20](Modules/Xot/app/Actions/GetTransKeyAction.php) (Modulo: Xot)
- `GetViewAction::execute` - [Modules/Xot/app/Actions/GetViewAction.php:25](Modules/Xot/app/Actions/GetViewAction.php) (Modulo: Xot)
- `GetViewByClassAction::execute` - [Modules/Xot/app/Actions/GetViewByClassAction.php:27](Modules/Xot/app/Actions/GetViewByClassAction.php) (Modulo: Xot)
- `ParsePrintPageStringAction::execute` - [Modules/Xot/app/Actions/ParsePrintPageStringAction.php:28](Modules/Xot/app/Actions/ParsePrintPageStringAction.php) (Modulo: Xot)

**Signature**:
```php
public function execute(string $prompt): CompletionData
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (62 occorrenze)
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


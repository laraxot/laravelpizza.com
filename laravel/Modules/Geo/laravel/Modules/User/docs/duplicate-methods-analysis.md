# Analisi Metodi Duplicati - Modulo User

**Data Generazione**: 2025-10-15 06:41:17
**Totale Gruppi di Duplicati**: 

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **User** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 2 |
| **Base Class** | 1 |
| **Interface** | 9 |
| **Altro** | 6 |

## Dettaglio Metodi Duplicati

### 1. Metodo: `notifiable`

**Tipo Refactoring**: `Trait` | **Complessità**: 🟢 Low | **Confidenza**: ✅ 100%

**Trovato in  file2 file**:

- `NotificationLog::notifiable` - [Modules/Notify/app/Models/NotificationLog.php:107](Modules/Notify/app/Models/NotificationLog.php) (Modulo: Notify)
- `Notification::notifiable` - [Modules/User/app/Models/Notification.php:91](Modules/User/app/Models/Notification.php)

**Signature**:
```php
public function notifiable(): MorphTo
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

### 2. Metodo: `team`

**Tipo Refactoring**: `Trait` | **Complessità**: 🟢 Low | **Confidenza**: ✅ 100%

**Trovato in  file4 file**:

- `Membership::team` - [Modules/User/app/Models/Membership.php:49](Modules/User/app/Models/Membership.php)
- `TeamInvitation::team` - [Modules/User/app/Models/TeamInvitation.php:38](Modules/User/app/Models/TeamInvitation.php)
- `TeamPermission::team` - [Modules/User/app/Models/TeamPermission.php:54](Modules/User/app/Models/TeamPermission.php)
- `TeamUser::team` - [Modules/User/app/Models/TeamUser.php:38](Modules/User/app/Models/TeamUser.php)

**Signature**:
```php
public function team(): BelongsTo
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (4 occorrenze)
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

### 3. Metodo: `user`

**Tipo Refactoring**: `BaseClass` | **Complessità**: 🟡 Medium | **Confidenza**: ⚠️ 63%

**Trovato in  file22 file**:

- `extends::user` - [Modules/Activity/app/Models/Activity.php:97](Modules/Activity/app/Models/Activity.php) (Modulo: Activity)
- `Article::user` - [Modules/Blog/app/Models/Article.php:393](Modules/Blog/app/Models/Article.php) (Modulo: Blog)
- `Comment::user` - [Modules/Blog/app/Models/Comment.php:102](Modules/Blog/app/Models/Comment.php) (Modulo: Blog)
- `Activity::user` - [Modules/Fixcity/app/Models/Activity.php:58](Modules/Fixcity/app/Models/Activity.php) (Modulo: Fixcity)
- `PushSubscription::user` - [Modules/Fixcity/app/Models/PushSubscription.php:64](Modules/Fixcity/app/Models/PushSubscription.php) (Modulo: Fixcity)
- `Ticket::user` - [Modules/Fixcity/app/Models/Ticket.php:572](Modules/Fixcity/app/Models/Ticket.php) (Modulo: Fixcity)
- `TicketActivity::user` - [Modules/Fixcity/app/Models/TicketActivity.php:78](Modules/Fixcity/app/Models/TicketActivity.php) (Modulo: Fixcity)
- `TicketComment::user` - [Modules/Fixcity/app/Models/TicketComment.php:68](Modules/Fixcity/app/Models/TicketComment.php) (Modulo: Fixcity)
- `TicketHour::user` - [Modules/Fixcity/app/Models/TicketHour.php:62](Modules/Fixcity/app/Models/TicketHour.php) (Modulo: Fixcity)
- `TicketSubscriber::user` - [Modules/Fixcity/app/Models/TicketSubscriber.php:51](Modules/Fixcity/app/Models/TicketSubscriber.php) (Modulo: Fixcity)
- `TaskComment::user` - [Modules/Job/app/Models/TaskComment.php:70](Modules/Job/app/Models/TaskComment.php) (Modulo: Job)
- `RatingMorph::user` - [Modules/Rating/app/Models/RatingMorph.php:104](Modules/Rating/app/Models/RatingMorph.php) (Modulo: Rating)
- `AuthenticationLog::user` - [Modules/User/app/Models/AuthenticationLog.php:74](Modules/User/app/Models/AuthenticationLog.php)
- `Device::user` - [Modules/User/app/Models/Device.php:50](Modules/User/app/Models/Device.php)
- `DeviceUser::user` - [Modules/User/app/Models/DeviceUser.php:79](Modules/User/app/Models/DeviceUser.php)
- `Membership::user` - [Modules/User/app/Models/Membership.php:57](Modules/User/app/Models/Membership.php)
- `OauthAccessToken::user` - [Modules/User/app/Models/OauthAccessToken.php:69](Modules/User/app/Models/OauthAccessToken.php)
- `OauthClient::user` - [Modules/User/app/Models/OauthClient.php:76](Modules/User/app/Models/OauthClient.php)
- `SocialiteUser::user` - [Modules/User/app/Models/SocialiteUser.php:52](Modules/User/app/Models/SocialiteUser.php)
- `TeamPermission::user` - [Modules/User/app/Models/TeamPermission.php:62](Modules/User/app/Models/TeamPermission.php)
- `TeamUser::user` - [Modules/User/app/Models/TeamUser.php:46](Modules/User/app/Models/TeamUser.php)
- `TenantUser::user` - [Modules/User/app/Models/TenantUser.php:47](Modules/User/app/Models/TenantUser.php)

**Signature**:
```php
public function user(): BelongsTo
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (22 occorrenze)
- Manutenibilità migliorata
- Consistenza tra moduli
- Struttura gerarchica chiara
- Possibilità di override controllato

##### ⚠️ Rischi e Considerazioni

- Richiede testing approfondito
- Possibili dipendenze nascoste
- Confidenza non ottimale - verificare manualmente
- Accoppiamento gerarchico tra moduli
- Verificare compatibilità PHPStan Level Max

##### 💡 Raccomandazione

**Valutare attentamente** - Analizzare le implementazioni specifiche prima di procedere.

---

### 4. Metodo: `getAvatarUrl`

**Tipo Refactoring**: `Pattern` | **Complessità**: 🔴 High | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `Profile::getAvatarUrl` - [Modules/Blog/app/Models/Profile.php:175](Modules/Blog/app/Models/Profile.php) (Modulo: Blog)
- `BaseProfile::getAvatarUrl` - [Modules/User/app/Models/BaseProfile.php:118](Modules/User/app/Models/BaseProfile.php)

**Signature**:
```php
public function getAvatarUrl(): string
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

### 5. Metodo: `getFullNameAttribute`

**Tipo Refactoring**: `Pattern` | **Complessità**: 🔴 High | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `Category::getFullNameAttribute` - [Modules/Fixcity/app/Models/Category.php:174](Modules/Fixcity/app/Models/Category.php) (Modulo: Fixcity)
- `BaseUser::getFullNameAttribute` - [Modules/User/app/Models/BaseUser.php:271](Modules/User/app/Models/BaseUser.php)

**Signature**:
```php
public function getFullNameAttribute(): string
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

### 6. Metodo: `getSlugOptions`

**Tipo Refactoring**: `Pattern` | **Complessità**: 🔴 High | **Confidenza**: ⚠️ 50%

**Trovato in  file4 file**:

- `Ticket::getSlugOptions` - [Modules/Fixcity/app/Models/Ticket.php:234](Modules/Fixcity/app/Models/Ticket.php) (Modulo: Fixcity)
- `Post::getSlugOptions` - [Modules/Lang/app/Models/Post.php:174](Modules/Lang/app/Models/Post.php) (Modulo: Lang)
- `MailTemplate::getSlugOptions` - [Modules/Notify/app/Models/MailTemplate.php:112](Modules/Notify/app/Models/MailTemplate.php) (Modulo: Notify)
- `BaseTenant::getSlugOptions` - [Modules/User/app/Models/BaseTenant.php:59](Modules/User/app/Models/BaseTenant.php)

**Signature**:
```php
public function getSlugOptions(): SlugOptions
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (4 occorrenze)
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

### 7. Metodo: `owner`

**Tipo Refactoring**: `Pattern` | **Complessità**: 🔴 High | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `Ticket::owner` - [Modules/Fixcity/app/Models/Ticket.php:313](Modules/Fixcity/app/Models/Ticket.php) (Modulo: Fixcity)
- `BaseTeam::owner` - [Modules/User/app/Models/BaseTeam.php:91](Modules/User/app/Models/BaseTeam.php)

**Signature**:
```php
public function owner(): BelongsTo
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

### 8. Metodo: `getTable`

**Tipo Refactoring**: `Pattern` | **Complessità**: 🔴 High | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `Job::getTable` - [Modules/Job/app/Models/Job.php:97](Modules/Job/app/Models/Job.php) (Modulo: Job)
- `PermissionRole::getTable` - [Modules/User/app/Models/PermissionRole.php:43](Modules/User/app/Models/PermissionRole.php)

**Signature**:
```php
public function getTable(): string
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

### 9. Metodo: `getName`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `TenantService::getName` - [Modules/Tenant/app/Services/TenantService.php:32](Modules/Tenant/app/Services/TenantService.php) (Modulo: Tenant)
- `BaseUser::getName` - [Modules/User/app/Models/BaseUser.php:116](Modules/User/app/Models/BaseUser.php)

**Signature**:
```php
public static function getName(): string
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

### 10. Metodo: `members`

**Tipo Refactoring**: `Pattern` | **Complessità**: 🔴 High | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `BaseTeam::members` - [Modules/User/app/Models/BaseTeam.php:132](Modules/User/app/Models/BaseTeam.php)
- `BaseTenant::members` - [Modules/User/app/Models/BaseTenant.php:69](Modules/User/app/Models/BaseTenant.php)

**Signature**:
```php
public function members(): BelongsToMany
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

### 11. Metodo: `factory`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ⚠️ 50%

**Trovato in  file2 file**:

- `Permission::factory` - [Modules/User/app/Models/Permission.php:59](Modules/User/app/Models/Permission.php)
- `Role::factory` - [Modules/User/app/Models/Role.php:69](Modules/User/app/Models/Role.php)

**Signature storica**:
```php
public static function factory(): PermissionFactory
```

##### ✅ Stato aggiornato (2025-11-17)
- `Permission` e gli altri modelli usano ora `protected static function newFactory(): PermissionFactory`
  mantenendo la firma compatibile con `HasFactory::factory($count = null, $state = [])` ed evitando collisioni.

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

Quando serve una factory custom, sovrascrivere solo `newFactory()` (non `factory()`) e
lasciare a `HasFactory` la gestione del metodo pubblico compatibile con Laravel 11.

---

### 12. Metodo: `getRows`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 38%

**Trovato in  file18 file**:

- `Attachment::getRows` - [Modules/Cms/app/Models/Attachment.php:132](Modules/Cms/app/Models/Attachment.php) (Modulo: Cms)
- `Conf::getRows` - [Modules/Cms/app/Models/Conf.php:37](Modules/Cms/app/Models/Conf.php) (Modulo: Cms)
- `Menu::getRows` - [Modules/Cms/app/Models/Menu.php:177](Modules/Cms/app/Models/Menu.php) (Modulo: Cms)
- `Module::getRows` - [Modules/Cms/app/Models/Module.php:45](Modules/Cms/app/Models/Module.php) (Modulo: Cms)
- `Page::getRows` - [Modules/Cms/app/Models/Page.php:113](Modules/Cms/app/Models/Page.php) (Modulo: Cms)
- `PageContent::getRows` - [Modules/Cms/app/Models/PageContent.php:82](Modules/Cms/app/Models/PageContent.php) (Modulo: Cms)
- `Section::getRows` - [Modules/Cms/app/Models/Section.php:99](Modules/Cms/app/Models/Section.php) (Modulo: Cms)
- `Comune::getRows` - [Modules/Geo/app/Models/Comune.php:124](Modules/Geo/app/Models/Comune.php) (Modulo: Geo)
- `Locality::getRows` - [Modules/Geo/app/Models/Locality.php:70](Modules/Geo/app/Models/Locality.php) (Modulo: Geo)
- `Province::getRows` - [Modules/Geo/app/Models/Province.php:51](Modules/Geo/app/Models/Province.php) (Modulo: Geo)
- `Region::getRows` - [Modules/Geo/app/Models/Region.php:63](Modules/Geo/app/Models/Region.php) (Modulo: Geo)
- `TranslationFile::getRows` - [Modules/Lang/app/Models/TranslationFile.php:100](Modules/Lang/app/Models/TranslationFile.php) (Modulo: Lang)
- `Domain::getRows` - [Modules/Tenant/app/Models/Domain.php:41](Modules/Tenant/app/Models/Domain.php) (Modulo: Tenant)
- `TestSushiModel::getRows` - [Modules/Tenant/app/Models/TestSushiModel.php:98](Modules/Tenant/app/Models/TestSushiModel.php) (Modulo: Tenant)
- `SocialProvider::getRows` - [Modules/User/app/Models/SocialProvider.php:98](Modules/User/app/Models/SocialProvider.php)
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

### 13. Metodo: `casts`

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
- `name::casts` - [Modules/User/app/Models/Authentication.php:74](Modules/User/app/Models/Authentication.php)
- `AuthenticationLog::casts` - [Modules/User/app/Models/AuthenticationLog.php:62](Modules/User/app/Models/AuthenticationLog.php)
- `BaseModel::casts` - [Modules/User/app/Models/BaseModel.php:58](Modules/User/app/Models/BaseModel.php)
- `BaseMorphPivot::casts` - [Modules/User/app/Models/BaseMorphPivot.php:65](Modules/User/app/Models/BaseMorphPivot.php)
- `BasePivot::casts` - [Modules/User/app/Models/BasePivot.php:49](Modules/User/app/Models/BasePivot.php)
- `BaseProfile::casts` - [Modules/User/app/Models/BaseProfile.php:169](Modules/User/app/Models/BaseProfile.php)
- `BaseUser::casts` - [Modules/User/app/Models/BaseUser.php:85](Modules/User/app/Models/BaseUser.php)
- `BaseUuidModel::casts` - [Modules/User/app/Models/BaseUuidModel.php:59](Modules/User/app/Models/BaseUuidModel.php)
- `Device::casts` - [Modules/User/app/Models/Device.php:60](Modules/User/app/Models/Device.php)
- `DeviceUser::casts` - [Modules/User/app/Models/DeviceUser.php:100](Modules/User/app/Models/DeviceUser.php)
- `ModelHasRole::casts` - [Modules/User/app/Models/ModelHasRole.php:75](Modules/User/app/Models/ModelHasRole.php)
- `Notification::casts` - [Modules/User/app/Models/Notification.php:80](Modules/User/app/Models/Notification.php)
- `OauthAccessToken::casts` - [Modules/User/app/Models/OauthAccessToken.php:57](Modules/User/app/Models/OauthAccessToken.php)
- `OauthClient::casts` - [Modules/User/app/Models/OauthClient.php:62](Modules/User/app/Models/OauthClient.php)
- `PermissionRole::casts` - [Modules/User/app/Models/PermissionRole.php:53](Modules/User/app/Models/PermissionRole.php)
- `SocialProvider::casts` - [Modules/User/app/Models/SocialProvider.php:105](Modules/User/app/Models/SocialProvider.php)
- `Team::casts` - [Modules/User/app/Models/Team.php:34](Modules/User/app/Models/Team.php)
- `Tenant::casts` - [Modules/User/app/Models/Tenant.php:45](Modules/User/app/Models/Tenant.php)
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

### 14. Metodo: `getDisplayNameAttribute`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 33%

**Trovato in  file3 file**:

- `Job::getDisplayNameAttribute` - [Modules/Job/app/Models/Job.php:119](Modules/Job/app/Models/Job.php) (Modulo: Job)
- `BaseProfile::getDisplayNameAttribute` - [Modules/User/app/Models/BaseProfile.php:188](Modules/User/app/Models/BaseProfile.php)
- `BaseUser::getDisplayNameAttribute` - [Modules/User/app/Models/BaseUser.php:263](Modules/User/app/Models/BaseUser.php)

**Signature**:
```php
public function getDisplayNameAttribute(): ?string
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (3 occorrenze)
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

### 15. Metodo: `scopeWithExtraAttributes`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 33%

**Trovato in  file3 file**:

- `Rating::scopeWithExtraAttributes` - [Modules/Rating/app/Models/Rating.php:164](Modules/Rating/app/Models/Rating.php) (Modulo: Rating)
- `BaseProfile::scopeWithExtraAttributes` - [Modules/User/app/Models/BaseProfile.php:107](Modules/User/app/Models/BaseProfile.php)
- `BaseExtra::scopeWithExtraAttributes` - [Modules/Xot/app/Models/BaseExtra.php:66](Modules/Xot/app/Models/BaseExtra.php) (Modulo: Xot)

**Signature**:
```php
public function scopeWithExtraAttributes(Builder $query): Builder
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (3 occorrenze)
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

### 16. Metodo: `profile`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 25%

**Trovato in  file4 file**:

- `Ticket::profile` - [Modules/Fixcity/app/Models/Ticket.php:562](Modules/Fixcity/app/Models/Ticket.php) (Modulo: Fixcity)
- `RatingMorph::profile` - [Modules/Rating/app/Models/RatingMorph.php:111](Modules/Rating/app/Models/RatingMorph.php) (Modulo: Rating)
- `BaseUser::profile` - [Modules/User/app/Models/BaseUser.php:243](Modules/User/app/Models/BaseUser.php)
- `DeviceUser::profile` - [Modules/User/app/Models/DeviceUser.php:90](Modules/User/app/Models/DeviceUser.php)

**Signature**:
```php
public function profile(): BelongsTo
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (4 occorrenze)
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

### 17. Metodo: `users`

**Tipo Refactoring**: `Interface` | **Complessità**: 🟢 Low | **Confidenza**: ❌ 16%

**Trovato in  file6 file**:

- `Tenant::users` - [Modules/Tenant/app/Models/Tenant.php:104](Modules/Tenant/app/Models/Tenant.php) (Modulo: Tenant)
- `BaseTeam::users` - [Modules/User/app/Models/BaseTeam.php:117](Modules/User/app/Models/BaseTeam.php)
- `BaseTenant::users` - [Modules/User/app/Models/BaseTenant.php:82](Modules/User/app/Models/BaseTenant.php)
- `Permission::users` - [Modules/User/app/Models/Permission.php:42](Modules/User/app/Models/Permission.php)
- `Role::users` - [Modules/User/app/Models/Role.php:51](Modules/User/app/Models/Role.php)
- `Tenant::users` - [Modules/User/app/Models/Tenant.php:55](Modules/User/app/Models/Tenant.php)

**Signature**:
```php
public function users(): HasMany
```

#### 📊 Analisi Refactoring

##### ✅ Vantaggi

- Riduzione duplicazione codice (6 occorrenze)
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

### 18. Metodo: `execute`

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
- `GetStyleClassAction::execute` - [Modules/Cms/app/Actions/GetStyleClassAction.php:15](Modules/Cms/app/Actions/GetStyleClassAction.php) (Modulo: Cms)
- `GetViewThemeByViewAction::execute` - [Modules/Cms/app/Actions/GetViewThemeByViewAction.php:13](Modules/Cms/app/Actions/GetViewThemeByViewAction.php) (Modulo: Cms)
- `SaveFooterConfigAction::execute` - [Modules/Cms/app/Actions/SaveFooterConfigAction.php:14](Modules/Cms/app/Actions/SaveFooterConfigAction.php) (Modulo: Cms)
- `SaveHeadernavConfigAction::execute` - [Modules/Cms/app/Actions/SaveHeadernavConfigAction.php:12](Modules/Cms/app/Actions/SaveHeadernavConfigAction.php) (Modulo: Cms)
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
- `GetCurrentDeviceAction::execute` - [Modules/User/app/Actions/GetCurrentDeviceAction.php:25](Modules/User/app/Actions/GetCurrentDeviceAction.php)
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


---
id: module-real-settings
title: Impostazioni reali in ogni SettingPage
type: story
status: ready-for-dev
created: 2026-11-04
supersedes_rows: "righe 'no' e 'rinviata' di module-setting-pages.epic.md per Activity, Job, UI, User, Xot, Lang, Tenant, Notify (direttiva dell'utente 2026-11-04)"
related:
  - ./module-setting-pages.epic.md
  - ./base-setting-page.story.md
  - ../../../Restaurant/docs/stories/completion.epic.md
qmd: "setting page impostazioni reali getFormSchema enabled placeholder xra pub_theme config path module.config consumer"
---

# Impostazioni reali in ogni SettingPage

## Richiesta (2026-11-04)

"nei SettingPage il metodo getFormSchema non puo restituire [] in ogni modulo c'e' qualcosa da
settare.. per esempio nel cms potevi configurare quale tema utilizzare .. percio' devi analizzare
e ragionare molto piu' a fondo".

## Perche' il placeholder `enabled` non basta

`BaseSettingPage::getFormSchema()` offre un toggle `enabled`, e ogni `*ConfigData` ha `bool $enabled`.
La verifica (6 agenti di sola lettura, 22 moduli, 2026-11-04) non trova **nessun** codice che legga
`enabled` in Xot, Cms, Lang, Tenant, Notify, Job, AI, User, Gdpr, Seo, UI, Geo, Mobile. E' una
impostazione finta: elude la regola "niente `[]`" senza dare nulla da configurare. Una impostazione
esiste se (1) del codice la legge, (2) il default coincide con il comportamento attuale, (3) il
valore e' validato per quello che la fa rompere.

## Regole di progetto (da `module-setting-pages.epic.md`, confermate)

- Chiavi che rompono il boot (tema, routing, classi, `main_module`): solo Select tra opzioni esistenti.
- Segreti restano in `.env` (EnvWidget di Notify/Geo); mai nel file del tenant.
- Non duplicare pagine esistenti: `MetatagPage`, `SocialiteProviderSettingsPage`, `Cms\Themes`, `Password`.
- Nessun `->label()/->placeholder()/->helperText()`: testi in `lang/{it,en}/setting.php`, chiavi `fields.<nome>.label|placeholder|helper_text`.
- Il consumatore legge `{Modulo}ConfigData::make()`, mai `config()` (con `config:cache` un salvataggio non si vedrebbe).

## Difetto trasversale: percorsi di config sbagliati

`XotBaseServiceProvider::registerConfig` (`Xot/app/Providers/XotBaseServiceProvider.php:190`) registra ogni
file come `{modulo}.{nomefile}`: `Geo/config/config.php` diventa `geo.config.*`, `mobile.php` diventa
`mobile.mobile.*`, `ai.php` diventa `ai.ai.*`. Molti consumatori leggono `geo.*`, `sms.*`, `ai.model`,
`user.socialite`, `gdpr.retention.*`: chiavi mai definite, quindi vale sempre il fallback scritto nel
codice. I test impostano lo stesso percorso sbagliato e passano. Passare a `{Modulo}ConfigData::make()`
risolve il problema per ogni chiave che diventa impostazione.

## Modifiche al framework (Xot)

1. **F1 chiavi condivise.** `BaseSettingPage` scrive un solo file. Servono chiavi di `xra` (`pub_theme`,
   `primary_lang`, `force_ssl`). Aggiungere `getSharedConfigKeys(): array<string, list<string>>`
   (`['xra' => ['pub_theme']]`): `getConfigState()` le legge dal file grezzo, `save()` le scrive con
   `SaveTenantConfigAction`. `XotData::make()` e' un singleton: dopo il salvataggio non si rilegge.
2. **F2 niente null nei file condivisi.** `save()` scrive tutte le proprieta' della Data, nulli inclusi;
   nei file condivisi il merge e' `array_replace_recursive` e un null cancella il valore reale. Regola:
   il default coincide con il valore effettivo; un campo nullable ("eredita") solo in file di proprieta' del modulo.
3. **F3 proprieta' non del form.** `save()` persiste anche `MediaConfigData::$name`. Filtrare sulle chiavi del form.
4. **F4 placeholder.** Il fallback `enabled` resta finche' un modulo non ha impostazioni reali, poi si
   toglie. Il test guardia (`EveryModuleHasSettingPageTest`) va stretto in due passi: prima elenca i
   moduli ancora sul placeholder, poi li vieta. Stringerlo prima renderebbe rosso tutto il repository.
5. **F5 docblock.** `Xot\...\SettingPage` e `Activity\...\SettingPage` dichiarano `@return array<string, never>`
   ma restituiscono il toggle: allineare.

## Impostazioni per modulo (prima tranche, ciascuna con consumatore verificato)

| Modulo | File | Chiavi (default = oggi) | Consumatori da portare su `ConfigData::make()` |
|---|---|---|---|
| Media | `media` | `attachment_max_size_kb` 10240 (max = limite PHP/Livewire reale), `attachment_mime_types` (con regex) | `GetAttachmentsSchemaAction`, entrambi gli `AddAttachmentAction` (FATTO 2026-11-04) |
| Cms | `cms` + `xra` | `pub_theme` (Select dalle cartelle `Themes/*` con `resources/views`), `allow_indexing` true, `hidden_path_segments`, `hidden_page_slugs` | `CmsServiceProvider.php:54-72`, `ResolveRobotsPolicyAction`, `Head`, `Seo BuildSitemapAction` e `BuildRobotsTxtAction` |
| Seo | `seo` | `path_aliases` (coppie alias/target), `robots_disallow_segments` | `RedirectToCanonicalPath.php:52`, `BuildSitemapAction.php:92`, `BuildRobotsTxtAction.php:32-43` |
| UI | `ui` | `dark_mode_switcher_enabled` true, `default_table_layout` list | `DarkModeSwitcherWidget.php:50-53`, `TableLayoutEnum::init()` |
| Xot | `xot` + `xra` | `force_ssl` (solo se la richiesta e' gia' sicura), `date_format` d/m/Y, `table_striped` true, `table_persist_filters` true | `XotData.php:489-511`, `XotServiceProvider.php:147-158`, `HasXotTable.php:265-276` |
| Lang | `lang` + `xra` | `default_locale`, `primary_lang` (Select tra le lingue di `laravellocalization`) | `XotServiceProvider.php:150`, 5 punti Cms. `enabled_locales` solo dopo l'unificazione dei ~13 elenchi scritti a mano |
| Tenant | `ente` | `name, address, phone, email, hours, social` | `GetEnteDataAction.php:42-62` (leggere dal file del tenant, non da `config('ente')`); prima decidere la fonte tra modello `Tenant`, `Location` e file |
| User | `user` | `socialite_domain_allowlist`, `socialite_registration_enabled` true, `authentication_log_retention_days` 365, durata token Passport 15/30/6 mesi | `GetDomainAllowListAction.php:28`, `IsRegistrationEnabledAction.php:21`, `AuthenticationLog.php:99`, `PassportServiceProvider.php:79-96` |
| Gdpr | `gdpr` | `cookie_banner_on`, `cookie_consent_lifetime_days` 180 (min 180), `cookie_policy_path`, `privacy_policy_path`, `terms_path` | `InjectCookieBanner.php:21`, `GetCookieInventoryAction.php:37`, viste cookie-consent e register. Unire `GdprData` in `GdprConfigData` |
| Activity | `activity` | `enabled`, `retention_days` 365, `record_logout_events` | `IsActivityLogSchemaWritableAction`, `ActivityMaintenanceAction.php:25` (oggi 90), `LogoutListener.php:19` |
| Job | `job` | `auto_start_worker` true, `monitored_queues`, `worker_timeout_seconds` 60, `worker_max_tries` 3 | `JobStatusWidget.php:50-52`, `WorkerCheck.php:131` |
| AI | `ai` | `enabled`, `chat_model` gpt-4o-mini, `model`, `temperature` (nullable), `max_tokens` 1500 | `GeneratePredictionDraftsAction.php:44-50,208`, `GeneratePredictionsAction.php:170-176`, `MakeAIRequestAction.php` |
| Notify | `notify` | `default_phone_country_prefix` 39, `sms_sender_id`, `enabled_channels`, `default_mail_layout` | `NormalizePhoneNumberAction.php:42` e 8 copie di `+39`, `RecordNotification::via()`, `SpatieEmail.php:59,176` |
| Geo | `geo` | `map_default_lat/lng/zoom` (42.5/12.5/6), `geocoding_driver`, cache geocoding (default false = oggi) | `HasCoordinatePicker.php:180`, `GetAddressDataFromFullAddressAction.php:67`, `GeoHttpClientBase.php` |
| Mobile | `mobile` | `api_base_url`, `sync_timeout_seconds` 15, `onesignal_app_id` | `SyncOfflineOrdersAction.php:31-32`, `KdsPushNotification.php:27` |
| Fixcity | - | nessuna ancora | e' un residuo senza `module.json`, config o provider: va deciso se appartiene a questo repository |

Lock `setting-fields` di codex su Geo, Notify, UI, User (e `Mobile.lock` del 2026-10-05): coordinare prima di toccarli.

## Non esporre (con motivo)

`main_module`, `register_pub_theme`, `*_class`, `super_admin` (aggira ogni policy in `GdprBasePolicy`), chiavi
dead di `XotData` (`register_type`, `verification_type`, `login_verified`, `search_action`, `show_trans_key`...),
`openai_base_url` (riceve la chiave API), `php_binary_path` (costruisce un comando shell), throttle di login,
`page_middleware_allowlist` e `container0_models` (allowlist fail-closed), `timezone` (sposta ogni data scritta, anche le
chiusure fiscali: solo con avviso, fuori dalla prima tranche), `sms_driver` (un driver senza credenziali lancia nel costruttore).

## Difetti trovati (backlog, non sono impostazioni)

- **Sicurezza:** `SocialiteProviderSettingsPage` salva `client_secret` nella config del tenant; `config/mcp.php:18-21`
  ha `redirect_domains => ['*']`; `Themes::changePubTheme()` senza validazione ne' `SuperAdminOnlyTrait`;
  `MetatagPage` senza `SuperAdminOnlyTrait`.
- **Rotti a runtime:** cookie banner chiama `\Themes\Sixteen\Infrastructure\Url\FrontofficeUrl` (tema e classe inesistenti);
  `AI/FineTuning` legge una chiave inesistente; due azioni AI inviano un Bearer vuoto (`services.openai.api_key` non definita);
  Telegram legge `services.telegram.token` mentre il tenant definisce `services.telegram-bot-api.token`;
  `ClearScheduleCacheAction` lancia sempre; `Mobile/config/mobile.php`: `getenv('MOBILE_ENABLED') ?: true` non spegne mai.
- **Silenziosi:** `LogoutListener` ignora `activitylog.enabled`; `Mobile` e `Fixcity` assenti da ogni `modules_statuses.json`;
  tenant scrive `forcessl` (documentazione) mentre `XotData` legge `force_ssl`.
- **Duplicati:** `MobilePluginRegistry` in due file con lo stesso namespace; due `NormalizePhoneNumberAction`; due `CalculateGeoDistanceAction`;
  cartelle di config con maiuscole diverse in Notify; `NavigationLabelTrait::getNavigationSort()` assegna `rand(1,100)` e lo salva al render.

## Acceptance criteria

1. Nessuna SettingPage resta sul solo placeholder `enabled`; ogni campo ha un consumatore che legge `ConfigData::make()`.
2. Per ogni chiave: default = comportamento di prima, validazione contro i valori che rompono, lang it/en completi.
3. Nessun salvataggio scrive null in un file condiviso; nessuna chiave non del form finisce nel file.
4. Il test guardia richiede almeno un campo reale per modulo e vieta il placeholder.
5. Verifica: `php -l`, PHPStan L10, Pint, Pest (richiede `laravel/.env.testing`, oggi assente: vedi `Restaurant/docs/stories/completion.epic.md`).

## Stato al 2026-11-04

Fatto: Media (bug KB/byte nei due `AddAttachmentAction`, sotto il quale c'era un secondo bug: i suggerimenti
`fields.file_hint` e `fields.name_hint` sono array nei file lang e `trans()` pretende una stringa, quindi il form
non si costruiva mai). Il resto e' `ready-for-dev` e va eseguito per modulo con lock, TDD e verifica.

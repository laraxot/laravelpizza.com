---
title: SettingPage con campi reali in ogni modulo
status: in-progress
module: Xot (owner della base e della guardia), tutti i moduli consumatori
type: story
created: 2026-11-04
qmd: "SettingPage getFormSchema vuoto campi reali ConfigData tema Cms xra metatag Tenant activitylog Notify AI Gdpr Seo guardia"
related:
  - ./setting-page-tutti-i-moduli.story.md
  - ../../stories/module-setting-pages.epic.md
  - ../../stories/base-setting-page.story.md
---

# SettingPage con campi reali in ogni modulo

## Fase BMAD

Correct course, poi Build. La story [setting-page-tutti-i-moduli](./setting-page-tutti-i-moduli.story.md) ha letto
"la pagina va in tutti i moduli" come "la pagina puo' essere vuota" e ha scritto `return [];` in 13 moduli su 14,
con una guardia che ammette il caso. E' l'errore da correggere.

Richiesta dell'utente (testuale): "nei SettingPage il metodo getFormSchema non puo restituire [] in ogni modulo c'e'
qualcosa da settare.. per esempio nel cms potevi configurare quale tema utilizzare .. percio' devi analizzare e
ragionare molto piu' a fondo". Poi: "crea tutto quello che serve a bmad e ecc per completare il progetto e poi
completalo e controllalo".

## Cosa dice davvero il codice (verificato a runtime, non dedotto)

1. Un file `config/{tenant}/{x}.php` diventa la chiave radice `config('x')`. Prova: `xra.pub_theme` vale `Four` perche'
   lo dice `config/localhost/xra.php`. Quindi un valore salvato da `BaseSettingPage` raggiunge chi legge `config('x.…')`.
2. Le chiavi che nessun file definisce valgono `NULL` e il codice usa il default scritto sul posto: `config('ai.model')`
   e `config('notify.cleanup.enabled')` sono `NULL` oggi. Sono impostazioni vere ma non configurabili.
3. Un file di config *del modulo* e' registrato da `XotBaseServiceProvider::registerConfig` come `config('{mod}.{file}')`
   con `Config::set`, che sostituisce quel ramo: un override del tenant su `gdpr.config.*` non arriverebbe. I lettori di
   Gdpr, Seo e Cms (`gdpr.config.cookie.*`, `seo.config.path_aliases`, `cms.config.*`) vanno spostati sulla Data.
4. `config('job::cache.enabled')` e' `NULL` perche' la chiave con `::` non corrisponde a nessun file: la lettura di
   Job e' morta, non solo non configurabile.
5. Le chiavi di `Lang/config/lang.php` (`available_locales`, `cache.*`, `validation.*`) non sono lette da nessuno.
6. `XotData` e' il modello tipizzato del file `xra`; Cms lo legge direttamente (`XotData::make()->pub_theme`), quindi un
   tema salvato vale al caricamento successivo, senza `config:cache`.
7. `Modules/Xot/config/xot.php` contiene percorsi assoluti di un altro progetto (`base_orisbroker_fila5`): dato morto,
   segnalato, non esposto.
8. Il riferimento ben fatto e' Media: la `ConfigData` e' l'unica fonte dei default e il codice legge con
   `MediaConfigData::make()` (trait `MakesFromTenantConfig`), quindi nessun default duplicato e il valore salvato ha effetto.

## Contratto di una impostazione vera

Un campo entra nella pagina solo se vale tutto questo:

1. **Ha un lettore**: almeno un punto del codice usa quel valore e legge tramite `{Mod}ConfigData::make()`. Un campo senza
   lettore e' una bugia nel menu.
2. **Default = comportamento di oggi**: il valore scritto nel codice diventa il default della proprieta' (una volta sola, nella
   Data); nulla cambia finche' nessuno salva.
3. **Niente segreti**: chiavi API, token, password restano in `.env`/`services`. La config tenant e' un file PHP tracciato.
4. **Non puo' rompere il boot**: niente testo libero dove serve una classe o un tema. Un tema e' una `Select` degli installati.
5. **Non attiva denaro**: nessun flag del live trading si cambia da un form (PRD 2.5f).
6. **Ogni proprieta' ha un campo e viceversa**, con etichetta in `lang/{it,en}/setting.php` (`fields.{campo}.label`).

Un modulo la cui impostazione vive in un altro file del tenant (Cms in `xra`, Tenant in `metatag`, Activity in
`activitylog`) fa override di `tenantConfigName()` nella Data e la pagina ne ripete il valore in `getConfigName()`. Il merge
di `SaveTenantConfigAction` conserva le chiavi non gestite, quindi piu' pagine possono scrivere nello stesso file.

## Matrice per modulo

| Modulo | File tenant | Campi | Lasciato fuori, e perche' |
|--------|-------------|-------|---------------------------|
| Cms | `xra` | `pub_theme`, `adm_theme` (Select dei temi in `Themes/`), `register_pub_theme`, `disable_frontend_dynamic_route` | `page_middleware_allowlist`: superficie di sicurezza |
| AI | `ai` | `model`, `chat_model`, `temperature`, `max_tokens`, `timeout`, `retry_attempts`, `openai_base_url` | `openai_api_key`: segreto |
| Notify | `notify` | `tracking.*`, `rate_limiting.*`, `cleanup.*`, `fcm.url`, `preferences_url`, `support_url` | `fcm.server_key`: segreto (resta in `.env`, EnvWidget) |
| Gdpr | `gdpr` | `cookie.consent_lifetime`, `cookie.policy_path`, `cookie.extra` | lettori da spostare sulla Data |
| Seo | `seo` | `path_aliases` | lettori da spostare sulla Data |
| UI | `ui` | `dark_mode_switcher.enabled` | |
| User | `user` | `create_personal_team`, `passport.register_routes`, `passport.enable_password_grant` | token, modelli, scope Passport: strutture di sicurezza; password/OTP e Socialite hanno pagine proprie |
| Activity | `activitylog` | `enabled`, `delete_records_older_than_days` | |
| Job | `job` | `cache.enabled`, `cache.store`, `cache.key` | richiede di correggere i lettori morti `job::cache.*` |
| Lang | `lang` | lingue disponibili, predefinita, di riserva | richiede di unificare i punti che scrivono le lingue a mano |
| Tenant | `metatag` | titolo, sitename, sottotitolo, descrizione, parole chiave, autore, testo alt del logo | |
| Xot | `xra` | `show_trans_key`, `force_ssl`, `login_verified`, `disable_database_notifications`, `disable_admin_dynamic_route`, `main_module` (Select dei moduli) | classi (`team_class`…), `super_admin`: accesso e boot |
| Trade | `trade` | `news.feeds`, `mcp.enabled`; stato di kill switch, live e auto in sola lettura | `live.*`, `kill_switch`, `auto.enabled`: l'app non li attiva |
| Media | `media` | gia' fatto: `attachment_max_size_kb`, `attachment_mime_types` | |

La matrice e' la partenza: ogni modulo la conferma o la corregge nella propria story con le righe di codice dei lettori.

## Esito (2026-11-04): 39 campi in 14 moduli

Letto dal codice delle `SettingPage`, non dalla matrice. Dove l'esito diverge dal piano sta scritto il perche'.

| Modulo | File tenant | Campi | Scarto dal piano |
|--------|-------------|-------|------------------|
| AI | `ai` | `model`, `chat_model`, `temperature`, `chat_temperature`, `max_tokens`, `timeout`, `retry_attempts`, `openai_base_url` | `MakeAIRequestAction` mantiene `gpt-4`/0.3/2000 (default invariato) |
| Activity | `activitylog` | `enabled`, `clean_after_days`, `default_log_name`, `include_soft_deleted_subjects` | la chiave v4 `delete_records_older_than_days` non e' letta da nessuno, sostituita da quella v5; lettore: il pacchetto, via `ApplyActivityConfigAction` |
| Cms | `xra` | `pub_theme`, `register_pub_theme` | `adm_theme` (nessuno registra il namespace, le Action che lo leggono non hanno chiamanti) e `disable_frontend_dynamic_route` (dichiarata in `XotData`, letta da nessuno) fuori; `primary_lang` e' di Xot |
| Gdpr | `gdpr` | `consent_lifetime`, `policy_path` | `cookie.extra` fuori: dichiarare un cookie non tecnico cambia il banner da informazione a consenso |
| Job | `job` | `max_attempts`, `timeout_seconds`, `sleep_seconds` | `cache.*` era una lettura morta (`job::cache.*`), non una impostazione |
| Lang | `lang` | `default_locale`, `supported_locales` | `save_missing_translations` non esposto: scrive file di lingua dal web in produzione |
| Media | `media` | `attachment_max_size_kb`, `attachment_mime_types` | |
| Notify | `notify` | `cleanup_enabled`, `cleanup_older_than_days`, `cleanup_batch_size`, `cleanup_keep_failed`, `fcm_url` | `fcm.server_key` resta segreto in `.env` |
| Seo | `seo` | `path_aliases` | `indexable` fuori: richiederebbe modifiche a Cms |
| Tenant | `metatag` | `title`, `logo_height` | i lettori stanno in Xot (`MetatagData`, usato dal `Head` di Cms); `MetatagPage` di Xot scrive lo stesso file (vedi decisione sotto) |
| Trade | `trade` | `news_feeds` | `mcp.enabled` e stato in sola lettura scartati; kill switch, live e auto restano nell'ambiente |
| UI | `ui` | `dark_mode_switcher_enabled` | `default_table_layout` non aggiunto |
| User | `user` | `create_personal_team`, `passport_enable_password_grant` | token, modelli e scope Passport restano fuori |
| Xot | `xra` | `main_module`, `primary_lang`, `force_ssl`, `disable_database_notifications` | `show_trans_key`, `login_verified`, `disable_admin_dynamic_route`, `disable_frontend_dynamic_route`: dichiarate in `XotData`, lette da nessuno (elenco completo nel docblock di `XotConfigData`) |

Cose trovate dalla guardia e dalla sync (dettaglio nella story di AI): la pulizia dei marker di merge `1e721ce` aveva tolto i
lettori di AI, e il fix del remoto cambiava i default di `MakeAIRequestAction` e aggiungeva `enabled` senza lettore.

## Guardia (ECC: verifica, non fiducia)

`Xot/tests/Unit/Filament/Pages/EveryModuleHasSettingPageTest.php` ora, per ogni modulo: lo schema ha almeno un campo; i
campi sono esattamente le proprieta' pubbliche della Data (esclusa `name`); ogni campo ha l'etichetta in `it` e `en`; ogni
proprieta' ha un lettore fuori da pagina e Data. Il lettore si cerca (`->prop` o `->camelProp`) nel modulo stesso; per Xot, che
e' la base di tutti, in ogni modulo; per Tenant anche in Xot (`SETTING_READER_MODULES`); per Activity nel pacchetto
`spatie/laravel-activitylog` (`SETTING_PACKAGE_READERS`). Un test controlla che la ricerca non trovi niente per una
proprieta' inventata. E' un'euristica: prova che un lettore esiste, non che sia quello giusto.

Limite noto: il nome di una proprieta' molto comune (`enabled`, `title`) puo' combaciare con un'altra cosa nello stesso
modulo. Per questo ogni modulo dichiara i suoi lettori nella propria story.

## Criteri di accettazione

- [x] Cms (riferimento: tema pubblico, `pub_theme` come Select dei temi installati)
- [x] AI, Notify, UI, User, Activity
- [x] Gdpr, Seo (con lettori spostati sulla Data)
- [x] Job, Lang (con correzione dei lettori)
- [x] Tenant, Xot, Trade
- [x] guardia ribaltata e verde su tutti i moduli (113 test, PHPStan 0, Pint ok)
- [x] PHPStan livello max e Pint su ogni file toccato; Pest dei test nuovi e della guardia
- [x] prompt riusabile per aggiungere un campo senza ripetere l'errore, e memoria aggiornata (`bashscripts/docs/prompts/59-setting-page-real-fields.md`; memoria `setting-page-real-fields`)
- [ ] chiusura per modulo (phpmd, phpinsights, `docs/coverage.md`) su Activity, Job, Lang, Seo, Tenant, Xot, Trade
- [x] decidere chi possiede il file `metatag` (Tenant `SettingPage` o `MetatagPage` di Xot): **tutte e due, con ruoli diversi**.
  `MetatagPage` (Xot) e' l'editor completo del file (title, sitename, generator, charset, author, description, keywords, loghi,
  `colors`); la `SettingPage` di Tenant ne e' la forma breve per il super-admin, con le sole due chiavi che hanno un lettore
  certo (`title`, `logo_height`). Non si calpestano: entrambe salvano con `SaveTenantConfigAction`, che fonde in modo ricorsivo e
  conserva le chiavi che la pagina non gestisce, quindi salvare dall'una non cancella quello che ha scritto l'altra. Le due
  chiavi in comune hanno un solo valore: vince l'ultimo salvataggio. Non si tolgono i campi a Tenant: senza di loro la pagina
  tornerebbe vuota, e un campo duplicato e' meno grave di un campo senza lettore. Se un giorno `MetatagPage` diventa una
  `SettingPage` vera, Tenant la sostituisce e questa pagina si rimpicciolisce.

## Coordinamento

- Codex teneva i lock su AI, Cms, Gdpr, Seo e Trade (SettingPage, Data, lang) dal task
  `SettingPage-every-module-and-phpstan-remediation`: 184 minuti, nessuna modifica pendente, task superato dalla richiesta
  qui sopra. Oltre i 60 minuti il README dei lock li considera obsoleti. Rilasciati uno per uno, solo quelli, e
  ripresi subito a nome di questa story. Codex: se hai lavoro in corso su quei file, scrivilo qui sotto prima di toccarli.
- 2026-11-05, rebase del mono dopo il pull dei sottomoduli: due commit `.` hanno reintrodotto campi scartati da questa story.
  Gdpr `ddaa6b50` ha rimesso il toggle `enabled` (poi tolto di nuovo da `b7624031`: vince il lato del modulo); Tenant `697c93ad` ha
  rimesso `enabled`/`domain_routing`/`default_locale` senza un fix successivo (vince il lato upstream del mono, `982440f0`). Dettaglio
  nella story di Tenant. Chi lavora con commit `.` controlli i file di questa story prima di committare.

---
title: "Security audit profondo — tutti i moduli Laraxot"
type: audit
status: active
tags: [security, audit, authorization, injection, secrets]
qmd: "security audit moduli laravel filament policy autorizzazione injection segreti"
---

# Security Audit — moduli Laraxot (18 moduli)

Audit statico del codice reale (grep/read su `laravel/Modules/*/app`, `routes/`, `config/`).
Nessuna modifica al codice: solo evidenze e rimedi.

**Contesto di autorizzazione verificato sul codice:**

- `Filament\Pages\Concerns\CanAuthorizeAccess::canAccess()` ritorna `true` di default
  (`vendor/filament/filament/src/Pages/Concerns/CanAuthorizeAccess.php:36-44`).
- `Filament\get_authorization_response()` (`vendor/filament/filament/src/helpers.php:60-95`):
  se **non esiste una policy** per il modello e la modalità strict è spenta
  (nessuna chiamata a `isAuthorizationStrict()` nel codice), ritorna `Response::allow()`.
  → **Ogni Resource il cui modello non ha una policy abbinabile è FULL-ACCESS a
  qualunque utente autenticato nel pannello.** La policy si indovina per nome classe:
  `Modules\{M}\Models\Policies\{Model}Policy` (non eredita dalle classi base).
- `XotBasePolicy::before()` (`Modules/Xot/app/Models/Policies/XotBasePolicy.php:21-44`)
  concede tutto a `super-admin` e a `{modulo}::admin` — ma solo per modelli **con** policy.
- `canAccessPanel` (`Modules/User/app/Models/BaseUser.php:289-318`): super-admin entra
  ovunque; gli altri solo nei pannelli del proprio ruolo (`{modulo}`/`{modulo}::operator`).

---

## P0 — Critico

### P0-1. SQL injection in `ImportCsvAction` tramite pagina `ImportCsv` (modulo Sigma)

- **File:** `Modules/Sigma/app/Filament/Pages/ImportCsv.php:26-56`,
  `Modules/Xot/app/Actions/Import/ImportCsvAction.php:33-67,108-133`
- **Evidenza:** la pagina espone `TextInput` liberi per `db`, `tbl`, `disk`, `path`;
  `save()` li passa a `ImportCsvAction::execute()`, che costruisce:
  ```php
  "LOAD DATA LOW_PRIORITY LOCAL INFILE '{$path}' INTO TABLE `{$db}`.`{$tbl}` ..."
  ```
  `$db`, `$tbl` e `$path` sono interpolati **senza binding** in `buildSql()`.
  `$pdo->exec('SET GLOBAL local_infile=1;')` abilita la lettura di file lato server.
- **Impatto:** injection SQL arbitraria (identificatori backtick e stringa `$path`
  sono entrambi break-out) da parte di qualunque utente che acceda al pannello Sigma.
  `LOAD DATA LOCAL INFILE` consente inoltre di caricare file arbitrari del filesystem
  server in tabelle DB (se `path` manipolabile) → esfiltrazione di dati / scrittura DB.
- **Rimedio:** whitelist di `db`/`tbl`/`disk` (o elimini la pagina in produzione),
  binding parametrici non disponibili per `LOAD DATA` → validare con regex
  `^[A-Za-z0-9_]+$` e `escapeshellarg`-equivalente per MySQL; disabilitare
  `local_infile` (`SET GLOBAL` non dovrebbe essere chiamato da codice web).

### P0-2. Segreti reali committati in `config/local/*` e `config/localhost/*` (git-tracked)

- **File:** `laravel/config/local/ptvx/services.php:6,11,16,20`,
  `config/local/ptvx-mono/services.php:6,11,16,20`,
  `config/local/tv/prov/personale2019/services.php`, `personale2022/services.php`,
  `config/localhost/services.php:8,13,23,27`,
  `config/local/*/filesystems.php:83` (`'password' => 'njGF2DDA'`, user `provtv` — FTP)
- **Evidenza:** due `client_secret` OAuth, due Google Maps API key
  (`AIzaSy...`, `AmPyO2...`) e password FTP in chiaro, versionati in git.
- **Impatto:** credenziali utilizzabili da chiunque abbia accesso al repo/backup;
  le API key Google sono spendibili (quota/billing) e i secret OAuth abilitano
  impersonazione dei client.
- **Rimedio:** ruotare immediatamente tutte le credenziali esposte; spostare in
  `.env`/vault; rimuovere i file `config/local/*` e `config/localhost/*` dal
  repository (o ridurli a `.env.example`); `git filter-repo`/`BFG` se la storia
  deve essere ripulita.

### P0-3. Credenziali proxy + JWT client_assertion hardcoded nella pagina test Pdnd

- **File:** `Modules/Pdnd/app/Filament/Clusters/Test/Pages/GuzzleProxyPage.php:94-113`
- **Evidenza:** `'proxy' => 'http://Administrator:pluto-1@proxy04:8080'`,
  `client_assertion` JWT completo hardcoded, `'verify' => false` (SSL disabilitato),
  commento con credenziali proxy in chiaro (riga ~57).
- **Impatto:** credenziali di rete e token bearer in codice sorgente; la pagina
  logga la response (che contiene token) in `Log::info` (righe ~121-122).
- **Rimedio:** eliminare la pagina o il cluster `Test` dai deploy di produzione;
  revocare la credenziale proxy e il client OAuth; mai committare token.

---

## P1 — Alto

### P1-1. `CurlProxyPage` (Pdnd): SSRF + proxy arbitrario, nessun `canAccess`

- **File:** `Modules/Pdnd/app/Filament/Clusters/Test/Pages/CurlProxyPage.php:22-44,49-129`
- **Evidenza:** nessun override di `canAccess()` → default Filament `true`:
  qualunque utente autenticato nel pannello Pdnd può specificare `target_url`,
  `proxy_host/port/username/password` arbitrari e il server esegue la richiesta
  (Guzzle) — Server-Side Request Forgery classico, anche verso metadati cloud
  (`169.254.169.254`) o host interni. `proxy_used` (con password) viene salvato
  in `$testResults` e renderizzato. In più usa `use Modules\Notify\Filament\Clusters\Test`
  come cluster — dipendenza cross-modulo errata.
- **Rimedio:** `canAccess()` → super-admin (o rimozione); allowlist di URL;
  mai accettare credenziali proxy dall'utente; non persistere la proxy URL.

### P1-2. Cluster `Test` esposto: Notify (email/SMS/push/WhatsApp/Telegram) e Media (S3/AWS)

- **File:** `Modules/Notify/app/Filament/Clusters/Test/Pages/*.php` (SendEmailPage,
  SendEmail, SendAwsEmailPage, SendSpatieEmailPage, SendSmsPage, SendNetfunSmsPage,
  SendPushNotification(Page), SendFirebasePushNotificationPage, SendTelegram(Page),
  SendWhatsAppPage, SlackNotification(Page), TestSmtpPage);
  `Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`, `AwsTest.php`
- **Evidenza:** nessuna di queste pagine sovrascrive `canAccess()` →
  `CanAuthorizeAccess::canAccess()` = `true` per default. Le action chiamano
  `abort_unless(static::canAccess(), 403)` ma `canAccess()` è sempre `true`.
  `S3Test` esegue `Storage::disk('s3')->put/get/delete` di test
  (`S3Test.php:640,716`), `AwsTest` testa connessioni IAM/CloudFront.
- **Impatto:** qualunque utente con accesso al pannello Notify/Media può
  inviare email/SMS/push/WhatsApp a destinatari arbitrari (spam, phishing,
  costi SMS) e manipolare/provare il bucket S3.
- **Rimedio:** `use SuperAdminOnlyTrait` su ogni pagina del cluster, oppure
  disabilitare la registrazione dei cluster `Test` in produzione
  (env flag) — pattern già esistente in `Modules/Xot/app/Filament/Traits/SuperAdminOnlyTrait.php`.

### P1-3. `SsoProvider` senza policy → Resource SSO configurabile da chiunque

- **File:** `Modules/User/app/Filament/Resources/SsoProviderResource.php:16`
  (`$model = SsoProvider::class`); modello `Modules/User/app/Models/SsoProvider.php:67`
- **Evidenza:** esiste `SsoProviderResource` ma **non** `SsoProviderPolicy`
  in `Modules/User/app/Models/Policies/` (lista verificata). Filament
  `get_authorization_response` → `Response::allow()` senza policy.
- **Impatto:** qualunque utente del pannello User può creare/modificare provider
  SSO (client id/secret, endpoint) → potenziale takeover degli account via IdP
  malevolo.
- **Rimedio:** creare `SsoProviderPolicy extends UserBasePolicy` con
  `viewAny/create/update/delete` basati su permessi; verificare anche
  `ClientResource`/`OauthClientResource` (sono coperti da `OauthClientPolicy`).

### P1-4. `NotificationLog` senza policy → Resource log notifiche aperta

- **File:** `Modules/Notify/app/Filament/Resources/NotificationLogResource.php:16`,
  modello `Modules/Notify/app/Models/NotificationLog.php`
- **Evidenza:** nessuna `NotificationLogPolicy` in `Modules/Notify/app/Models/Policies/`.
- **Impatto:** log delle notifiche (destinatari, contenuti, token push) leggibili/
  cancellabili da qualunque utente del pannello Notify.
- **Rimedio:** `NotificationLogPolicy extends NotifyBasePolicy`.

### P1-5. `Upload` (IndennitaCondizioniLavoro) senza policy

- **File:** `Modules/IndennitaCondizioniLavoro/app/Filament/Resources/UploadResource.php:27`,
  modello `Modules/IndennitaCondizioniLavoro/app/Models/Upload.php`
- **Evidenza:** nessuna `UploadPolicy` tra le 7 policy del modulo.
- **Impatto:** CRUD sugli upload (file caricati, probabilmente dati personali)
  libero a qualunque utente del pannello.
- **Rimedio:** policy dedicata estesa da una base del modulo.

### P1-6. Modulo Ptv: Scheda/StabiDirigente/CategoriaPropro/CriteriOption/Message/MyLog/Option senza policy

- **File:** `Modules/Ptv/app/Models/{Scheda,StabiDirigente,CategoriaPropro,CriteriOption,Message,MyLog,Option}.php`;
  Resources omonime in `Modules/Ptv/app/Filament/Resources/`
- **Evidenza:** `Modules/Ptv/app/Models/Policies/` contiene solo
  `BaseAssenzaPolicy`, `CriteriEsclusionePolicy`, `ProfilePolicy`. La policy si
  indovina per nome esatto (`SchedaPolicy` non esiste in Ptv).
- **Impatto:** `SchedaResource` (valutazioni del personale — dati HR sensibili)
  e le altre Resource sono FULL-ACCESS per `ptv::operator`/chiunque entri nel
  pannello `ptv/admin`: view/edit/delete di tutte le schede valutative.
- **Rimedio:** policy per ogni modello esposto (estendere una `PtvBasePolicy`
  con `before()` super-admin + ruolo modulo, come fa `XotBasePolicy`); audit di
  tutte le Resource Ptv.

### P1-7. `Peso`/`Pesi` mismatch: `PesiResource` → modello `Peso`, policy `PesiPolicy` non si applica

- **File:** `Modules/Progressioni/app/Filament/Resources/PesiResource.php:11,17`
  (`use Modules\Progressioni\Models\Peso`),
  `Modules/Progressioni/app/Models/Peso.php:58`, `Pesi.php:51`,
  `Modules/Progressioni/app/Models/Policies/PesiPolicy.php`
- **Evidenza:** la policy si indovina come `PesoPolicy` (nome classe `Peso`),
  che non esiste — `PesiPolicy` è per la classe `Pesi` (sottoclasse di `Peso`).
- **Impatto:** pesi dei criteri di progressione modificabili da chiunque nel
  pannello Progressioni.
- **Rimedio:** rinominare policy in `PesoPolicy` o `$model = Pesi::class` +
  allineare nomi.

### P1-8. `EscludiProgressione`/`IndividualeTotValutatoreId`/`OrganizzativaTotValutatoreId`/`Valutatore` (Performance/Progressioni) senza policy

- **File:** `Modules/Performance/app/Models/{IndividualeTotValutatoreId,OrganizzativaTotValutatoreId,Valutatore}.php`,
  `Modules/Progressioni/app/Models/EsclusiProgressione.php`
- **Evidenza:** nessuna policy omonima; non tutte hanno Resource diretta, ma
  `Valutatore` esiste anche in Progressioni (lì ha `ValutatorePolicy`).
- **Impatto:** medio — dipende dall'esposizione via Relazione/Resource; il
  pattern "no policy = allow" rende rischiosa ogni futura Resource.
- **Rimedio:** mappare `Gate::policy()` esplicito o policy di copertura.

### P1-9. SSL verification disabilitato in client di produzione (Pdnd, Notify, Sigma)

- **File:** `Modules/Pdnd/app/Services/Client/PdndClient.php:598`
  (`CURLOPT_SSL_VERIFYPEER false` + `VERIFYHOST 0`, invia `Authorization: Bearer`
  e `Agid-JWT-Signature`); `Modules/Pdnd/app/Adapters/Client/PdndClient.php:589`
  (duplicato attivo — usato da `Actions/Client/*`); `Modules/Notify/app/Actions/EsendexSendAction.php:47,83`
  (login SMS con `username`/`password` in query string!); `Modules/Sigma/app/Services/SigmaService.php:233`
- **Evidenza:** `EsendexSendAction::login()` costruisce
  `login?username=…&password=…` in URL GET → credenziali in chiaro in
  access log proxy/server.
- **Impatto:** MITM su token AGID/Pdnd e credenziali Esendex; credenziali in URL
  finiscono nei log.
- **Rimedio:** riabilitare verifica TLS (o pin certificato se l'endpoint usa CA
  interna); spostare le credenziali Esendex in POST body o header;
  deduplicare `Services/` vs `Adapters/` (codice duplicato divergente).

### P1-10. Route HTTP non autenticate: export PDF progetti Incentivi (dati personali)

- **File:** `Modules/Incentivi/routes/web.php:19-23`,
  `Modules/Incentivi/app/Http/Controllers/PdfDownloadController.php:21-57`
- **Evidenza:** `Route::get('projects/{project}/pdf/download')` e
  `…/liquidazione` caricate solo con middleware `web`
  (`XotBaseRouteServiceProvider::mapWebRoutes` aggiunge solo `web`).
  Nessun `auth`, nessuna policy check nel controller: `{project}` è route-model
  binding → IDOR su qualunque `Project` id.
- **Impatto:** download anonimo di PDF con nomi dipendenti, importi e liquidazioni
  (dati retributivi = dato personale ex GDPR) per ogni progetto.
- **Rimedio:** `->middleware('auth')` + `authorize('view', $project)` con policy
  Incentivi (esiste `IncentiviBasePolicy`) o spostare dietro Filament Action.

---

## P2 — Medio

### P2-1. `SqlUpload` (Sigma): upload ZIP con `extractTo` non validato + SQLi (vedi P0-1)

- **File:** `Modules/Sigma/app/Filament/Pages/SqlUpload.php:28-115`
- **Evidenza:** `FileUpload` con `preserveFilenames()` su disco `cache`;
  se MIME `application/zip` → `$zip->extractTo(dirname($path))` senza verifica
  dei path delle entry (Zip Slip); poi passa `$db`/`$tbl` liberi a
  `ImportCsvAction` (vedi P0-1). `canAccess` non sovrascritto → allow a chiunque
  nel pannello Sigma.
- **Rimedio:** validare ogni entry con `ZipArchive::statIndex` + check `..`;
 Sanitize filename; stessa correzione SQLi di P0-1.

### P2-2. `TemporaryUpload::$guarded = []` (Media) — mass assignment aperto

- **File:** `Modules/Media/app/Models/TemporaryUpload.php:99`
- **Evidenza:** `protected $guarded = [];` su modello con `session_id`,
  `status`, `user_id` — `create()` accetta qualsiasi attributo se il chiamante
  passa input utente (upload flow e Filament form).
- **Rimedio:** `$fillable` esplicito (session_id, status) o `$guarded = ['id']`.
  (Già segnalato in `Modules/Media/docs/bmad/audits/media-audit.md`.)

### P2-3. `print_r`/`echo`/`exit` di debug in codice attivo (information disclosure)

- **File:** `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php:511-517`,
  `ServizioEsterno.php:448-454`, `Modules/IndennitaResponsabilita/app/Models/LettI.php:753-759`,
  `Modules/Progressioni/app/Models/Scheda.php:1099`,
  `Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php:312-498` (blocchi
  `echo '<pre>'; print_r($results)`), `Modules/Ptv/app/Actions/Check/CheckValutatoreAction.php:60`
- **Evidenza:** in rami `else`/debug raggiungibili durante calcoli di produzione
  stampano SQL (`toSql()`), dati anagrafici e array in output HTTP/Filament.
- **Rimedio:** sostituire con `Log::debug()` dietro feature flag; rimuovere
  `exit()`/`echo` da modelli e trait.

### P2-4. `dd()`/`exit()` residui

- **File:** `Modules/Job/app/Http/Livewire/Broad.php:41` (`dd('fine')` in
  `notifyEvent()`), `Modules/Sigma/app/Services/TxtdService.php:98,235`,
  `Modules/Sigma/app/Models/Traits/Mutators/Qua00fMutator.php:122`
  (`exit()` con echo di dati), `Modules/Xot/app/Actions/Filament/GenerateTableColumnsByFileAction.php:119`,
  `GenerateFormByFileAction.php:102` (`dd([...])` in metodo `ddFile`)
- **Impatto:** se raggiungibili da UI/Livewire, dump di stato e terminazione
  anticipata; `Broad` sembra dead code ma è un componente Livewire.
- **Rimedio:** rimozione o guardia `app()->environment('local')`.

### P2-5. `unserialize()` su dati DB (object injection se DB compromesso)

- **File:** `Modules/Ptv/app/Models/BaseMyLog.php:90`,
  `Modules/Performance/app/Models/MyLog.php:127`,
  `Modules/Job/resources/views/filament/tables/columns/array/item.blade.php:8`
  (blocco `unserialize` commentato — dead code)
- **Evidenza:** `unserialize($data)` su colonne DB senza `allowed_classes`.
- **Rimedio:** `unserialize($data, ['allowed_classes' => [...]])` o JSON.

### P2-6. Path traversal potenziale in `UpdateDiriByCsv`

- **File:** `Modules/IndennitaResponsabilita/app/Filament/Pages/UpdateDiriByCsv.php:71,92-95`
- **Evidenza:** `$path = Storage::disk('public')->path($csvFile)` con `$csvFile`
  dallo state Livewire (manipolabile da client); `handleFileUpload()` usa
  `$file->getClientOriginalName()` in `storeAs()` (non sanitizzato).
  `Reader::from($path)` = lettura file arbitraria se `../` non bloccato.
- **Rimedio:** validare che il path risolto sia dentro la root del disk
  (`Str::startsWith(realpath, storage_path())`), generare filename casuale.

### P2-7. `SqlUpload`/`ImportCsv` senza `canAccess` (vedi P0-1/P2-1)

`XotBasePage` non chiama mai `authorizeAccess()` di sua iniziativa
(è `protected` e invocata solo da alcune pagine Ptv); le pagine custom
devono sovrascrivere `canAccess()` — `ImportCsv` e `SqlUpload` non lo fanno
→ aperte a qualunque utente del pannello Sigma.

### P2-8. `SET GLOBAL local_infile=1` e `LOAD DATA LOCAL INFILE` da codice web

- **File:** `Modules/Xot/app/Actions/Import/ImportCsvAction.php:57-60`
- **Impatto:** richiede privilegi GLOBAL e abilita lettura file client-side
  lato server MySQL — superficie di attacco estesa.
- **Rimedio:** rimuovere la chiamata; usare import via parser PHP (League CSV).

### P2-9. `execute()`/`shell_exec()` in Console con path da argomento

- **File:** `Modules/Xot/app/Console/Commands/ImportMdbToMySQL.php:69-99`,
  `DatabaseBackUpCommand.php:63`, `Modules/Job/app/Console/Commands/WorkerCheck.php:62,123`,
  `Modules/Lang/app/Actions/WriteTranslationFileAction.php:91` (`exec php -l`)
- **Evidenza:** comandi shell con variabili non escapate (es. `{$mdbFile}`,
  `{$table}` in `shell_exec("mdb-export ... {$table}")`) — CLI only, ma se
  `$table` deriva da `mdb-tables` output o argomento utente → command injection.
- **Rimedio:** `escapeshellarg()` su tutti gli argomenti; `Process` component.

### P2-10. `Incentivi`/`Notify` — `forceFill` e `withoutEvents` diffusi

- **File:** `Modules/Notify/app/Actions/SendNotificationAction.php:151` (`forceFill`),
  `Modules/Notify/app/Console/Commands/MigrateNotifyThemesToMailTemplateCommand.php:131`,
  `Modules/Ptv/app/Models/Traits/Mutators/SchedaMutator.php` (~30 occorrenze
  `saveQuietly()`/`withoutEvents`), `Modules/Performance/app/Models/Traits/MutatorTrait.php:96,188`,
  `Modules/Incentivi/app/Models/Traits/StabiDirigenteMutatorsTrait.php:31,114,142,175`,
  `Modules/IndennitaCondizioniLavoro/app/Models/Traits/CondizioniLavoroMutatorsTrait.php:103,153`,
  `Modules/IndennitaResponsabilita/app/Models/LettF.php:539,585,654`,
  `Modules/Job/app/Observers/ScheduleObserver.php:38,48`
- **Impatto:** bypass di eventi Eloquent → se audit/activity log è basato su
  observer, queste scritture sono **invisibili** all'audit trail. Pattern
  diffuso in calcoli massivi (mutators): le modifiche su Scheda/Performance/
  Indennità non lasciano traccia applicativa.
- **Rimedio:** auditare quali scritture utente passano da `withoutEvents`;
  loggare esplicitamente (activity log manuale) le mutazioni che by-passano
  gli eventi.

### P2-11. `Second-order SQL` in `Progressioni\Models\Scheda::asz00k1()` (blocco commentato ma vicine righe attive)

- **File:** `Modules/Progressioni/app/Models/Scheda.php:804-813`
- **Evidenza:** `whereRaw('find_in_set(concat(asztip,"-",aszcod),"'.$lista_codici_aspettative.'")')`
  con `$lista_codici_aspettative` costruita da valori DB (`tipo.'-'.codice`).
  Il metodo è dentro un blocco `/* ... */` commentato, ma lo stesso pattern
  esiste in `Modules/Ptv/app/Models/BaseScheda.php:308-310` e
  `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php:326-328`
  con `$tbl` hardcoded (sicuro) — tenere sotto controllo: se `$tbl` o la lista
  diventano derivati da input, è SQLi. `Modules/Sigma/app/Models/Asz00k1.php:375`
  ha lo stesso snippet commentato.
- **Rimedio:** rimuovere il codice morto; dove serve, usare binding `?`.

### P2-12. `Direct S3 upload` senza validazione di chiave/bucket/mime

- **File:** `Modules/Media/app/Http/Requests/CreateTemporaryUploadFromDirectS3UploadRequest.php:19-27`
- **Evidenza:** `key`, `bucket`, `name`, `content_type`, `size` solo `required`;
  nessun check che l'oggetto esista nel bucket atteso o che il path sia nel
  prefisso dell'upload sessione → si possono registrare media da bucket/path
  arbitrari se il chiamante è autenticato.
- **Rimedio:** validare prefisso `temporary-uploads/{session}/`, dimensione
  max, allowlist MIME.

---

## P3 — Basso / igiene

- **P3-1** `Modules/User/database/seeders/DemoUserSeeder.php:55-69` — password
  seed `password123`/`waiter123`: ok se solo seeder demo, verificare che non
  giri in produzione.
- **P3-2** `Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php` —
  registrazione pubblica sempre attiva (`canView(): !Auth::check()`), crea
  utenti senza ruolo; in contesto PA valutare disabilitazione via config.
  Ha throttle (`ConsumeAuthSubmissionSlotAction`) — bene.
- **P3-3** `Modules/Job/app/Models/MonitoredScheduledTask.aaa`,
  `NotificationLog.php.up`, `Project.test`, `BaseRating.php.to_rating` — file
  di backup/scarto dentro `app/` (rischio di autoload confusion / leak se
  pubblicati). Pulire.
- **P3-4** `Modules/Xot/app/Exports/Jobs/XotExportCsv.php:47` —
  `EloquentSerializeFacade::unserialize($this->query)` su job queue:
  accettabile se la queue è fidata; verificare serializer.
- **P3-5** `Modules/Activity/app/Filament/Pages/LogViewer.php` —
  `canAccess` delega a `AuthorizeLogAccessAction` (corretto); verificare che
  l'action limiti a super-admin/admin e non esponga log con dati personali
  a troppi ruoli.
- **P3-6** `Modules/User/app/Filament/Widgets/Auth/PasswordResetConfirmWidget.php:105`
  — auto-login dopo reset password: verificare rigenerazione sessione
  (Laravel `login()` la fa) e invalidazione token usato (fatto via Password
  broker). OK, solo nota.
- **P3-7** `Modules/Tenant` — `Tenant` model senza `TenantPolicy`
  (esiste solo `TenantBasePolicy` astratta + `DomainPolicy`); nessuna
  TenantResource → rischio basso, ma se si aggiunge una Resource sarà aperta.
- **P3-8** `Modules/Performance` — `Valutatore`, `IndividualeTotValutatoreId`,
  `OrganizzativaTotValutatoreId` senza policy; nessuna Resource diretta trovata
  → prevenire esposizione futura.
- **P3-9** `Modules/Lang` — `LanguageLine`, `BaseModelLang` senza policy;
  `TranslationFileResource`→`TranslationFile` ha policy? verificare
  `LangBasePolicy` copertura.
- **P3-10** `Modules/Rating` — `Like`, `AbstractRatingsHost` senza policy
  (probabilmente pivot/astratti); `Rating`/`RatingMorph` coperti.
- **P3-11** `dd()`/`dump` in `Modules/Xot/app/Actions/Filament/GenerateTableColumnsByFileAction.php:119`
  e `GenerateFormByFileAction.php:102` — metodi `ddFile` probabilmente debug;
  `Modules/Xot/app/Actions/Filament/GenerateTableColumnsByFileAction.php`
  esegue `LaravelFile::put` su file generati — verificare path.
- **P3-12** `Modules/Ptv/app/Models/BaseScheda.php:308-310` e
  `ProgressioniFunctionTrait.php:326-328` — `selectRaw`/`whereRaw` con
  concatenazione di `$tbl` (attualmente costante) — refactor a binding
  per prevenire regressioni.

---

## Top-10 priorità

| # | Finding | Severità | Azione |
|---|---------|----------|--------|
| 1 | P0-2 Segreti (OAuth secrets, Google keys, FTP pwd) in `config/local/*` git-tracked | P0 | Ruotare credenziali, rimuovere file, purgare storia git |
| 2 | P0-1 SQLi `ImportCsvAction` via `ImportCsv`/`SqlUpload` (Sigma) | P0 | Whitelist input + rimuovere `LOAD DATA`/`local_infile` o gated super-admin |
| 3 | P0-3 + P1-1/P1-2 Cluster `Test` Pdnd/Notify/Media: proxy con credenziali hardcoded, SSRF `CurlProxyPage`, invio mail/SMS/push, test S3 senza `canAccess` | P0/P1 | `SuperAdminOnlyTrait` o disabilitare cluster in prod; revocare credenziali proxy/JWT |
| 4 | P1-6 Ptv: `Scheda`/`StabiDirigente`/altre 5 Resource senza policy → CRUD libero valutazioni HR | P1 | Creare policy per tutti i modelli Ptv esposti |
| 5 | P1-3 `SsoProviderResource` senza policy → modifica IdP/secret | P1 | `SsoProviderPolicy` + permessi |
| 6 | P1-10 Route `projects/{project}/pdf|liquidazione` senza auth → IDOR dati retributivi | P1 | `middleware('auth')` + policy check |
| 7 | P1-4/P1-5 `NotificationLog`, `Upload` (ICL) senza policy | P1 | Policy estese da base modulo |
| 8 | P1-9 TLS verify off (Pdnd Bearer/AGID JWT, Esendex con password in URL) | P1 | Riattivare verifica TLS; credenziali in POST |
| 9 | P2-10 `withoutEvents`/`saveQuietly` diffusi → audit trail incompleto | P2 | Mappare scritture che by-passano eventi, loggare manualmente |
| 10 | P2-1 Zip Slip `SqlUpload::extractTo` + P2-6 path traversal `UpdateDiriByCsv` | P2 | Validazione path/entry archivio |

---

## Note metodologiche

- Verifica eseguita su codice reale: `grep`/`read` su `Modules/*/app`, `routes/`,
  `config/`, `vendor/filament` per confermare il comportamento default di
  autorizzazione Filament v5.
- Policy auto-scoperta via `Gate::guessPolicyName` (Laravel): solo
  `Modules\{M}\Models\Policies\{Model}Policy` per nome classe esatto —
  **non** eredita da classi base astratte (`Base*`) né da policy con nome
  diverso (`PesiPolicy` ≠ `Peso`).
- Moduli con modello Eloquent ma **zero** policy: Pdnd (solo DTO ANPR, non
  Eloquent — ok), gran parte di Sigma (284 modelli tabellari legacy, solo 2
  Resource esposte — rischio indiretto via WebService).
- Test Pest **non eseguiti**: host di produzione (`10.100.200.15`) —
  regola "no tests on production" rispettata; l'audit è statico.

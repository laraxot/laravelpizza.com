---
title: "Brainstorming: Perfezione assoluta del modulo User"
type: brainstorming
module: User
status: done
related:
  - ./perfection-prd.md
  - ./perfection-architecture.md
  - ./perfection-epics.md
  - ./perfection-decision-log.md
  - ./epics.md
  - ./decision-log.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "brainstorming: audit a 360 gradi, modulo user verso la perfezione assoluta user"
---

# Brainstorming: audit a 360 gradi, modulo User verso la perfezione assoluta

## Metodo

Audit read-only, 7 dimensioni indipendenti, eseguito da agenti `general-purpose` con
tool reali (Bash/Read/Grep, verificati `tool_uses > 0` in ogni notifica). Nessun file
modificato, nessuna scrittura su DB, nessuna migration eseguita. Ogni finding qui sotto
è citato a `file:riga` con il comando/verifica reale che lo ha prodotto: dove un claim
di documentazione preesistente non era riproducibile nel codice attuale, l'ho segnalato
esplicitamente (git/codice batte la doc, standing order #3).

Copre l'intero modulo (112 model, 357 file Filament, 57 Actions, 310 test, 103
migration, 3832 file `docs/`), non solo la campagna Epic 9/10 (SuperAdmin widget +
ritiro Livewire) già in corso: quella campagna resta autonoma e non viene toccata.

---

## 1. Sicurezza (identity/auth): la dimensione più critica

### 1.1 CRITICO: `UserPolicy` bypassa l'autorizzazione su view/create/update/delete

`laravel/Modules/User/app/Models/Policies/UserPolicy.php` estende `UserBasePolicy`
(pass-through vuoto verso `XotBasePolicy`) invece di `BaseUserPolicy.php` (classe
sorella quasi omonima, ben scritta, a controllo di ruolo: `hasRole(['super-admin',
'admin','hr-manager'])`: ma **mai estesa da nessuno**, `grep -rln "extends
BaseUserPolicy"` → 0 risultati, dead code).

Risultato: `view()`, `create()`, `update()`, `delete()` ritornano tutti `true`
incondizionatamente per qualunque coppia utente/target. Verificato che Laravel
auto-discover la policy per convenzione (`{namespace}\Policies\{Model}Policy`,
`grep -rln "Gate::policy(\|protected \$policies"` sui Providers → zero registrazioni
esplicite, quindi la policy attiva è quella auto-scoperta). `UserResource.php`
(Filament) non ha override (`canEdit`/`canDelete`/`authorize(` → 0 risultati), quindi
eredita l'autorizzazione di default basata su Policy.

**Impatto:** qualunque utente autenticato che ottenga lo UUID di un altro utente puo',
navigando a `/…/users/{uuid}/edit`: vedere il profilo di qualsiasi utente, cambiarne
email/password (**account takeover**), eliminarne l'account: admin inclusi, nessun
self-check.

**Causa strutturale:** naming collision `BaseUserPolicy` / `UserBasePolicy`: due
classi quasi identiche nel nome, ruoli opposti. Pattern già noto in memoria di
progetto (`filament-hook-naming-collision.md`), qui si ripete sulle Policy.

### 1.2 CRITICO: nessun rate limiting sul login

`grep -rn "throttle"` in tutto il modulo → un solo risultato, dentro
`laravel/Modules/User/routes/auth.php`, il cui intero contenuto (righe 4-26) e'
avvolto in un blocco di commento (`/* ... */`): morto/inattivo. `grep -rn
"RateLimiter::\|tooManyAttempts\|hit("` in `app/` → 0 risultati. `LoginWidget.php` /
`BaseAuthWidget.php` (i componenti Filament che gestiscono davvero il login) non
contengono `HasRateLimitedForms` ne' logica di throttling propria.

**Impatto:** nessuna protezione contro brute-force/credential-stuffing sul form di
login reale.

### 1.3 ALTO: cancellazione account (GDPR) non fa cascade, lascia PII orfane

Nessun modulo `Gdpr` in questo repo (`find laravel/Modules -iname "*gdpr*"` → vuoto).
Unico punto di cancellazione: `laravel/Modules/User/app/Actions/User/
DeleteUserAction.php`: fa solo `$this->authGuard->logout()` (guard/sessione
corrente) e `$user->delete()` (hard delete, `SoftDeletes` commentato in
`BaseUser.php`).

Le migration di `oauth_access_tokens`, `oauth_auth_codes`, `socialite_user` usano
`$table->foreignIdFor($userClass,'user_id')` **senza** `.constrained()`/
`.cascadeOnDelete()`: nessun vincolo FK reale (verificato leggendo per intero
`2023_01_01_000003_create_oauth_access_tokens_table.php` e
`..._create_socialite_user_table.php`). `UserObserver::deleting()` pulisce solo il
personal team. `RevokeAllUserTokensAction.php` esiste gia' ma non e' mai chiamata da
`DeleteUserAction` (unico consumer: `OauthAccessTokenResource.php`, azione manuale
admin).

**Impatto:** dopo "elimina account" restano righe orfane con PII (email, nome,
avatar, token) in `profiles`, `socialite_user`, `authentications`, `model_has_role`;
token OAuth/Passport restano `revoked=false`.

### 1.4 ALTO: token OAuth Socialite salvati in chiaro

`laravel/Modules/User/app/Models/SocialiteUser.php`: proprieta' `token` e' `fillable`
ma **nessun cast** (`'token' => 'encrypted'` assente). La colonna `socialite_user.
token` (TEXT) contiene il token OAuth del provider esterno (Google/Facebook/...) in
chiaro.

### 1.5 MEDIO: mass assignment strutturale dormiente

`laravel/Modules/User/app/Actions/CreateUserAction.php` (top-level) fa
`User::create([...$attributes, ...($this->data ?? [])])`. `Modules\User\Datas\
CreateUserData` espone come proprieta' settabili `is_active`, `email_verified_at`,
`password_expires_at`, `is_otp`, `type`, `state`, incluso `id`: tutti `fillable` su
`BaseUser`. Nessun caller reale oggi (solo test), ma landmine se collegato a un
endpoint di registrazione self-service senza whitelisting.

### 1.6 MEDIO: naming collision `BaseUserPolicy` vs `UserBasePolicy`

Vedi 1.1: causa strutturale del bug critico, va risolta insieme al fix.

### 1.7 BASSO: schema drift `model_has_permission` vs `model_has_permissions`

Sulla connessione `user` coesistono entrambe le tabelle (singolare/plurale), 0 righe
ciascuna: solo `model_has_role` (singolare) e' in uso con 482 righe. Duplicazione di
schema da ripulire, non exploitable ora.

### Verifiche pulite (nessun finding)

- **Data debt morph map** (da `decision-log.md`, voce 2026-09-21): 40 righe stantie
  `model_type='Modules\Quaeris\Models\User'` riguardano il tenant **Quaeris**, non
  questa installazione. Verifica read-only su Ptv (`SELECT ... GROUP BY` via tinker,
  connessione `user`, host 10.100.200.53): `model_has_role` ha **482/482 righe con
  `model_type='user'`, zero righe stantie**. Il debito descritto nel decision-log non
  e' (piu') presente su Ptv.
- Mass assignment diretto: `$fillable` esiste, niente `$guarded=[]` pericoloso;
  `password`/`remember_token`/`two_factor_*` in `$hidden`.
- Hashing password: cast `'password' => 'hashed'` commentato ma hashing forzato via
  mutator esplicito in `BaseUser.php`: rischio mitigato a livello model.
- Log dati sensibili: `ProfileEditVoltComponent.php` logga solo `password_length`,
  mai il valore.

---

## 2. Architettura (Models/Datas/Contracts/Traits/Actions)

### 2.1 ALTO: 3 classi `CreateUserAction` duplicate, responsabilita' sovrapposte

- `Actions\CreateUserAction`: validazione + welcome email + audit log, model
  concreto (`User`).
- `Actions\User\CreateUserAction`: one-liner `app(User::class)->create($data)`,
  model concreto, usato da `Datas/CreateUserData.php`.
- `Actions\Socialite\CreateUserAction`: **corretta**: `UserContract` +
  `XotData::make()->getUserClass()`, pattern SSoT gia' presente nel modulo, solo non
  applicato ovunque.

### 2.2 ALTO: `app/Adapters/**` e' codice morto byte-identico ad `app/Actions/**`

3 coppie di classi duplicate (`Otp/Hasher.php`, `EmailDomainAnalyzer.php`,
`UserNameFieldsResolver.php`), zero caller in produzione (unico consumer: il proprio
test dedicato), ciascuna con test suite propria duplicata. `diff` conferma differenza
di solo namespace.

### 2.3 MEDIO: 4 punti type-hintano `User` concreto invece di `UserContract`

- `app/Actions/CreateUserAction.php:45` `handle(): User`
- `app/Actions/User/CreateUserAction.php:19` `execute(array $data): User`
- `app/Actions/Activity/LogRegistrationAction.php:19` `execute(User $user, ...)`
- `app/Observers/UserObserver.php:25,67` `created(User $user)`, `deleting(User $user)`
  (Observer legato a evento Eloquent: severita' bassa, accettabile)

Contro 20 Actions che usano correttamente `UserContract`. Contro-esempio virtuoso:
`app/Actions/Socialite/CreateUserAction.php:20-31`.

### 2.4 ALTO: fallback hardcoded a modulo di progetto specifico

`app/Datas/DeviceData.php:78-80`: `DeviceData::getSynchronizationId()` genera un
fatal error garantito in questo progetto: `Class "Modules\Egea\Models\Synchronization"
not found` (Egea e' un modulo di un progetto sibling, non presente qui). Altri
riferimenti cross-modulo (`Tenant`, `Media`, `Notify`) sono dipendenze infrastrutturali
legittime, non leak specifici di progetto.

### 2.5 confermato conforme: boundary XotBase

Tutte le 6 hit iniziali di un grep grezzo `extends Resource|Page|Widget` risalgono a
XotBase una volta verificata la classe genitore effettiva (alias `use ... as
EditRecord` che maschera il nome, ma tecnicamente conforme). L'unica vera estensione
diretta di Filament (`BaseAuthWidget.php.no:10 extends Widget`) e' in un file
disabilitato (`.php.no`, fuori autoload): dead code che violerebbe la regola se
riattivato.

### 2.6 confermato conforme: SSoT morph map

`laravel/Modules/Tenant/app/Providers/TenantServiceProvider.php:179-194`
(`buildMorphMap`) contiene il fix gia' descritto in `decision-log.md`: forza
`$typedMap['user'] = XotData::make()->getUserClass()` dopo il loop config.
`IsProfileTrait::user()` usa correttamente la stessa SSoT per la relazione
`belongsTo`. Nessun altro punto in `Modules/User` costruisce/consuma una morph map
propria in conflitto.

### 2.7 BASSO: migration `_bak/` clutter non eseguibile ma pericoloso

`database/migrations/_bak/2026_02_13_172135_add_lang_column.php` duplica esattamente
il nome del migration live. Verificato non eseguibile (`glob()` non ricorsivo in
`nwidart/laravel-modules`), ma resta landmine se la logica di loading cambia.

---

## 3. Qualita' codice / Filament (357 file)

### 3.1 ALTA: PHPMD e PHPInsights entrambi inutilizzabili in questo ambiente

- `laravel/phpmd.phar` (3.16MB): `PharException: manifest cannot be larger than
  100 MB`: phar corrotto/troncato.
- `vendor/bin/phpmd` (fallback): `Declaration of PDepend\...\PdependExtension::load()
  must be compatible with Symfony\...\ExtensionInterface::load()`: conflitto
  versione pdepend/symfony-di.
- `laravel/phpinsights.phar`: 0 byte (mai scaricato). Fallback `php artisan insights`
  fallito al 99% (1281/1282) con `ComposerNotFound: composer.lock not found` -
  `laravel/composer.lock` non esiste sul filesystem, `--disable-security-check` non
  previene il fatal.

**Nessun dato PHPMD/PHPInsights ottenibile**: gate di qualita' incompleto per
l'intero repo, non solo User.

### 3.2 ALTA: PHPStan "0 errori" con 11 soppressioni inline nascoste

`php -d memory_limit=2048M ./vendor/bin/phpstan analyse --memory-limit=-1
--no-progress Modules/User` → `[OK] No errors` (level 10/max, verificato reale). Ma
11 `@phpstan-ignore` inline in `Modules/User/app`, di cui **7 concentrate in
`Modules/User/app/Models/Traits/HasTeams.php`** (righe 97, 184, 186, 188, 190, 192 -
`method.notFound`, `return.type`, `property.nonObject`, `argument.type`). Lo "zero"
non e' pulizia totale, e' pulizia + soppressione mirata su un file hot-spot (lo
stesso file e' flaggato anche da Pint).

### 3.3 Pint --test: FAIL, 5 file, 18 fixer

`app/Models/Models/BaseUser.php` (3 fixer: `braces`, `braces_position`,
`blank_lines_before_namespace`) e `app/Models/Traits/HasTeams.php` (4 fixer:
`braces`, `unary_operator_spaces`, `braces_position`,
`not_operator_with_successor_space`): gli stessi 2 file applicativi coinvolti nel
punto 3.2. 3 file di test con violazioni minori.

### 3.4 XotBase compliance: quasi 100%, verificato per famiglia

Tables 39/39, Forms 40/40, List Pages 33/33, Edit Pages 28/28, Create Pages 22/22,
View Pages 28/28, RelationManagers 22/22, Widgets 26/26: tutti verificati con
controllo dei falsi positivi (alias `use X as Y`, glob che matcha Columns invece di
Table class). Unica violazione reale: `BaseAuthWidget.php.no` (vedi 2.5), dead code.

### 3.5 BASSO: inconsistenza architetturale `getTableColumns` posizionamento

76 file totali con `getTableColumns`, la stragrande maggioranza su `Tables/
*Table.php` dedicate. 4 eccezioni con l'hook sulla root della Resource/Widget:
`OauthAccessTokenResource.php:166`, `OauthPersonalAccessClientResource.php:39`,
`SsoProviderResource.php:30`, `RecentLoginsWidget.php:35` (widget, contesto diverso).
Le prime 3 sono Resource nei Cluster Passport/Socialite sul pattern monolitico
pre-separazione `Tables/`: non hard-violation (`XotBaseResource` permette entrambi),
debito di migrazione verso il pattern usato dalle altre 39 Resource.

### 3.6 confermato: 0 violazioni reali "array una chiave per riga" in scope

Regex mirata su `app/Filament` + `app/Actions`: tutti i match sono falsi positivi
(riga commentata, arrow function `fn(...) => ...`). **Fuori scope pero' trovato per
caso**: `Modules/User/lang/it/login.php:7-11` ha array annidati multi-chiave su riga
singola: violazione reale, ma fuori dal perimetro Filament/Actions di questo check.

### 3.7 MEDIO: 41 `->label()` espliciti, 17 file, contro convenzione

Contraddice la memoria di progetto "label autoconfigurate via LangServiceProvider".
Hotspot: `ClientsRelationManager.php` (5), `OauthPersonalAccessClientResource.php`
(5), `TokensRelationManager.php` (5), `OauthDeviceCodeResource.php` (4).

### 3.8 MEDIO: Livewire residuo, doc `livewire-inventory.md` con claim non riproducibili

3 classi attive in `app/Http/Livewire` (`PrivacyPolicy.php`, `TermsOfService.php`,
`Profile/DeleteAccount.php`) + `app/Livewire/Logout.php` orfano, come gia'
documentato. **Confermato reale:** `dddx('wip')` attivo in `TermsOfService.php:32`
dentro un metodo `testfunction()`: debug code in produzione.

**Contraddetto dal codice attuale** (git batte la doc, standing order #3):
- Doc dice "`DeleteAccountWidget::destroy()` usa `->run()` inesistente": verificato
  `DeleteAccountWidget.php:53` usa `app(DeleteUserAction::class)->execute(...)`. File
  riscritto nel commit `63d53469f8` (2026-09-21, stessa data della doc): claim non
  riproducibile.
- Doc dice "`lang/it/login.php` troncato (ritorna int)": file attuale: 33 righe,
  struttura array valida, ultima modifica 2026-09-15 (precedente alla doc).
- Doc dice "`login.blade.php` troncato a una riga": file attuale: 116 righe, ben
  formato.

**Gap:** `livewire-inventory.md` (base della story 10.4) contiene almeno 2 claim di
bug non riscontrabili oggi: da verificare/correggere prima di usarla come base di
lavoro per 10.4 (attualmente `blocked`).

### 3.9 BASSO: dead code, glob del task intercetta solo 5 di ~19 file morti

Pattern richiesto (`*.bak|*.orig|*Old.php|*Legacy.php|*V2.php`): 5 file `.bak`. Find
allargata mostra molti altri: 4 `.old` (`Contracts/CanComment.php.old`,
`Contracts/PassportHasApiTokensContract.php.old`, `Models/OauthAccessToken.php.old`,
`Models/Traits/HasRelations.php.old`), 1 `.to_xot`, 1 `.backup-20251015-092511`, 2
`.no` (incl. `BaseAuthWidget.php.no`), 1 `.corrected`
(`Widgets/LogoutWidget.php.corrected`), oltre a `.wip`/`.test`/`.md`/`.json` sparsi
dentro `app/Filament`.

### 3.10 BASSO: 3 helper Actions fuori convenzione QueueableAction

56/57 file in `app/Actions` usano `QueueableAction`. 3 eccezioni (`Otp/Hasher.php`,
`Socialite/Utils/EmailDomainAnalyzer.php`, `Socialite/Utils/
UserNameFieldsResolver.php`) sono helper/value-object senza `execute()`, ambiguita'
con la regola no-services/Actions-only.

### 3.11 file orfano: `app/Models/Models/BaseUser.php`

Namespace errato `Modules\User\Models\Models`, versione vecchia/minimale rispetto a
`Models/BaseUser.php`. Non referenziato da autoload utile trovato: candidato a
rimozione (memoria "il duplicato si cancella, non si preserva").

---

## 4. Test coverage (310 test)

### 4.1 ALTO: `UserPolicy` (la policy bypassata, vedi 1.1) ha zero copertura

`grep -rl "\bUserPolicy\b" tests/` → 0 risultati. La combinazione "logica permissiva
+ zero test" ha permesso al bug 1.1 di restare invisibile.

### 4.2 ALTO: intero namespace `Actions/Shield/*` sistematicamente scoperto

9/57 Actions a zero riferimenti in test, tutte confermate `QueueableAction`+
`execute()`: `Authentication/GetAuthenticationLogQueryForAuthenticatableAction`,
`GetPermissionModelAction` (**e** il suo duplicato quasi identico in `Shield/`),
`Notification/IsNotificationSchemaReadableAction`,
`Shield/ResolveExclusionsConfigurationAction`,
`Shield/ResolveFilamentUserConfigurationAction`,
`Shield/ResolvePermissionsConfigurationAction`,
`Shield/ResolveShieldAuthenticationConfigurationAction`,
`Shield/ResolveShieldResourceConfigurationAction`,
`Shield/ResolveSuperAdminConfigurationAction`.

### 4.3 ALTO: 4 test skippati per un bug gia' risolto (skip stale)

`tests/Feature/Filament/Widgets/Auth/LoginWidgetTest.php:60,81,94,115`: skip con
commento "blocked by pre-existing bug: login.blade.php truncated ... story 10.3".
Verifica statica: `login.blade.php` e' oggi 116 righe ben formate, `lang/it/
login.php` ritorna un array valido. Il bug citato risulta gia' risolto (coerente con
3.8): questi 4 test bloccano copertura reale del `LoginWidget` senza motivo attuale.

### 4.4 10 model pivot/junction a zero riferimenti in test

`Membership`, `ModelHasPermission`, `ModelHasRole`, `ModelRole`, `PermissionRole`,
`PermissionUser`, `PersonalAccessToken`, `ProfileTeam`, `RoleHasPermission`,
`TenantUser`: tutti hanno factory ma zero uso in test (verificato per riferimento di
classe, non solo nome file, per evitare falsi negativi).

### 4.5 16/38 Policy solo "can be instantiated", zero assert su logica reale

`PoliciesTest.php` smoke-testa l'istanziazione di 16 policy; solo `RolePolicy` e
`TeamPolicy` hanno test comportamentale reale (`UserPolicyBehaviorTest.php`). 19
policy a zero riferimenti.

### 4.6 6 trait a zero riferimenti anche indiretti

`HasModules`, `HasSocialite`, `HasTeamsMembershipAdministration`, `HasTenants`,
`InteractsWithTenant`, `IsTenant`.

### 4.7 nessun guard test architetturale

Zero risultati per `arch()` (Pest architecture preset) o file `*Arch*`. Mancano
guard test per: array one-key-per-line (regola solo in `.cursor/rules/`, non
eseguibile), Form/Column parity, no-`RefreshDatabase` (oggi vera "per fortuna", non
garantita: vedi memoria `regola-senza-test-regredisce`), XotBase-only extension,
policy coverage minimo.

### 4.8 positivo: factory 1:1 perfetto

38/38 model concreti hanno factory corrispondente, nessun gap, nessuna orfana.

### 4.9 positivo: 0 occorrenze `RefreshDatabase`

Conforme alla regola dati sacri, nessuna violazione trovata (21 skip/dead test in 11
file, in gran parte skip condizionali legittimi su schema mancante: 4 dei quali
sono lo skip stale del punto 4.3).

### 4.10 duplicazione infrastruttura test

`tests/Helpers.php` (787 righe) vs `tests/Support/helpers.php` (530 righe): diff
mostra sovrapposizione quasi totale.

### 4.11 contaminazione cartella test

`tests/Unit/graphify-out/cache/ast/v0.9.33/`: cache AST di `graphify` finita dentro
`tests/Unit/` invece che in `graphify-out/` a root progetto.

---

## 5. Performance

### 5.1 ALTO: N+1 attivo e confermato: `OauthClientResource` (cluster Passport)

`Filament/Clusters/Passport/Resources/OauthClientResource.php:31-48`: `table()`
override reale (invocato da Filament) con `TextColumn::make('owner.name')` su
relazione polimorfica `owner`, **nessun** `getEloquentQuery()` override in tutto il
file (95 righe). Ogni riga della lista OAuth Clients lazy-loada `owner`
individualmente. Il resource gemello non-cluster ha lo stesso pattern colonne ma
**correttamente** eager-loadato: il fix e' gia' lo standard nel modulo, solo
applicato in modo incoerente.

### 5.2 ALTO: `PassportStatsWidget`: polling 5s default, 5 COUNT non cachate

Ne' il widget ne' `XotBaseStatsOverviewWidget` sovrascrivono `$pollingInterval`
(default Filament `'5s'` via `CanPoll`). 5 query COUNT/aggregate non cachate eseguite
ogni 5 secondi per ogni utente con la dashboard Passport aperta.

### 5.3 ALTO: cache assente su tutto il modulo (0/357 file)

Zero `Cache::`/`remember()`/`cache()` in tutto `app/`. Colpisce in particolare
`UsersChartWidget.php:94-103` e `UserTypeRegistrationsChartWidget.php:54-60` (query
`Trend` GROUP BY per day, fino a 90 giorni, ad ogni render). Nota positiva: entrambi
hanno `pollingInterval = null`, quindi non c'e' repolling automatico.

### 5.4 MEDIO: 2 notifiche su 3 non in coda

`Notifications/Auth/ResetPassword.php` e `VerifyEmail.php` estendono le classi base
Laravel (non `ShouldQueue`), inviano mail in modo sincrono bloccando la request.
Confronto corretto: `Otp.php` implementa `ShouldQueue` esplicitamente.

### 5.5 MEDIO: bulk action con UPDATE per-utente in loop invece di batch

Duplicato in `OauthAccessTokenResource.php:145-152` e `:293-300` (il secondo blocco
e' dead code, vedi 5.7): `RevokeAllUserTokensAction::execute()` fa una `UPDATE ...
WHERE user_id = ?` per ogni utente selezionato invece di `whereIn(...)->update(...)`.

### 5.6 MEDIO: eager loading dichiarato ma mai usato, 4 resource su 17

`TeamUserResource.php:24` (`with(['team','user'])`), `TenantUserResource.php:24`
(`with(['tenant','user'])`), `TeamInvitationResource.php:41` (`with(['team'])`),
`AuthenticationLogResource.php:27` (`with(['authenticatable'])`, relazione
polimorfica: 1 query extra per ogni `authenticatable_type` distinto): le rispettive
Table class mostrano solo ID raw, mai le relazioni caricate. Query sprecate ad ogni
load di lista.

### 5.7 MEDIO: 144 righe di codice morto duplicato su hook tabella

`OauthAccessTokenResource.php:166-309`: `getTableColumns()`, `getTableFilters()`,
`getTableActions()`, `getTableBulkActions()` mai invocati (la classe ha gia' un
override completo di `table()` righe 38-165). Duplica in modo non sincronizzato la
stessa logica di revoca-token del punto 5.5. Coerente con story gemella gia'
tracciata: `xotbaseresourcetable-dead-code-duplicate-table-classes-followup.story.md`.

### 5.8 BASSO: `save()` ridondante dopo `sync()` in bulk action

`PermissionResource/Pages/ListPermissions.php:90-105`: `save()` dopo `sync()` in
loop genera una UPDATE inutile per ogni record selezionato.

### 5.9 BASSO: N+1 bounded su RelationManager

`UserResource/RelationManagers/OauthTokensRelationManager.php:34-35`: colonna
`client.name` senza eager load, ma impatto limitato (righe annidate nella vista di
un singolo User, ≤ paginazione).

### 5.10 nota metodologica importante: dead code silenzioso da wiring Filament

Un `getTableColumns()` scritto su una `ListRecords` page **non viene mai chiamato**
se la Resource non ha un proprio `table()` override (Filament passa da
`getTableClass()` → la classe `*Table` dedicata, vedi
`XotBaseListRecords.php:17-21`). Due finding iniziali (`RoleResource/Pages/
ListRoles.php:27`, `BaseProfileResource/Pages/ListProfiles.php:32-78`: quest'ultimo
con un `$record->update()` pericoloso dentro una callback colonna) sono stati
**declassati** dopo verifica: sono dead code silenzioso, non bug attivi in
produzione. Resta comunque igiene del codice da bonificare (codice pericoloso che
sembra vivo).

---

## 6. Schema / migrazioni (103 file)

*(sintesi dal report dell'agente eloquent: findings principali, testo integrale
dell'agente conservato nella cronologia task del run)*

- **Drift UUID/PK cross-modulo**: `profiles.id` in `Modules\Ptv` e in `Modules\User`
  non condividono lo stesso pattern di generazione: rischio di incoerenza tra
  installazioni che montano entrambi i moduli.
- **FK cascade mancante** sulla maggior parte delle tabelle (confermato anche
  dall'audit sicurezza, punto 1.3, per `oauth_access_tokens`/`socialite_user`) -
  fanno eccezione `team_user` e `team_permissions`, che hanno vincoli FK reali.
- **Morph map confermata corretta** anche dal punto di vista schema (coerente con
  2.6): risoluzione per-tenant, nessun FQCN hardcoded nello schema.
- **`BaseTenant.php`**: gap nella generazione UUID segnalato, da verificare insieme
  al punto 15.1/15.3 (drift profiles).
- **Clutter migration directory**: file relitto `.boh`/`.wip`/`.old` oltre al gia'
  noto `_bak/` (punto 2.7).
- **Colonne status-come-stringa senza cast enum**: multiple tabelle usano stringhe
  libere per campi di stato invece di enum PHP nativi/cast, rischio di valori
  incoerenti non validati a livello applicativo.
- **Schema drift** `model_has_permission`/`model_has_permissions` (vedi 1.7) e'
  visibile anche qui come tabelle duplicate a livello migration.

---

## 7. Documentazione (`docs/`, 3832 file, 60 cartelle)

### 7.1 CRITICO (per volume): bug di self-nesting/naming patologico, 626 file (~16%)

- 612 file vivono dentro un path con una cartella ripetuta immediatamente su se
  stessa (`X/X/...`). Hotspot: 573 file sotto `2fa/2fa/...` (dentro `-integration/`
  e `_integration/`), 39 sotto `bmad/bmad/...` (annidato fino a **8 livelli**:
  `bmad/bmad/bmad/bmad/bmad/bmad/bmad/bmad`).
- `docs/docs/` (nesting a 4 livelli): confermato reale: diff tra
  `docs/docs/decisions/2fa-user-model-decision.md` e
  `docs/docs/docs/docs/decisions/2fa-user-model-decision.md` e' **vuoto** (contenuto
  identico, solo path duplicato).
- 46 file con nome base >100 caratteri (fino a 190), frasi intere come nome file
  (es. `Users should carefully review and align their data columns before
  uploading.md`).
- 15 file con spazi nel nome: violazione grave della convenzione kebab-case.
- **Causa radice probabile**: un tool di generazione automatica di documentazione
  (verosimilmente un'integrazione AI che genera nomi file da frammenti di
  testo/errore invece che da un titolo breve) auto-invocato ricorsivamente su
  cartelle gia' processate, copiandole dentro se stesse e concatenando frammenti di
  frase nei nomi ad ogni passaggio. Affligge praticamente ogni cartella controllata
  (root `docs/`, `decisions/`, `archive/`, `-integration/`, `_integration/`, `bmad/`,
  `stories/`, `bug-fixes/`).

### 7.2 `docs/index.md` stale

8608 byte, ultima modifica 2026-01-24 (8 mesi fa), contenuto parzialmente
corrotto/duplicato (sezione `## Note` due volte). Elenca solo 6 cartelle
(`guides/`, `api/`, `architecture/`, `database/`, `troubleshooting/`, `deployment`)
- non menziona nessuna delle cartelle piu' popolose: `bmad` (382 file), `errori`
(353), `features` (228), `rector` (203), `roadmap` (177), `analysis` (141), `fixes`
(136), `testing` (118).

### 7.3 bug `.gitignore`: righe senza ancoraggio, gia' tracciato

`docs/.gitignore` righe 13-14 (`archive/**`, `legacy/**`) senza slash iniziale
(`/archive/**`), quindi non ancorate alla root di `docs/`. **Story gia' esistente**
in `docs/sprint-status.yaml` (root, righe 52125-52130):
`5.37-gitignore-archive-legacy-bug-user`, status `backlog`, owner `null`: da
riassegnare, non serve una nuova story.

### 7.4 cluster di cartelle sovrapposte (naming)

`bugfix`/`bugs`/`bug-fixes`/`bug-tracking`/`fixes`/`fixed` si sovrappongono
concettualmente; `archive`/`_archive`/`archive` (varianti case/underscore)
idem; `docs/docs` (vedi 7.1). Proposta (mai cancellare, solo merge/link/superseded):
designare `bugs/` (41 file, il piu' popoloso verificato) come cartella canonica per
il cluster bug*; `errori/` (353 file, 330 non sovrapposti) trattata a se', stesso
genere di contenuto ma non duplicato diretto.

### 7.5 47 file stub/placeholder (<100 byte)

Confermati scaffold auto-generati vuoti di contenuto (es. `docs/adr/README.md`: 66
byte, `# adr\n\nAuto-generated directory documentation.`), non documentazione persa
- coerente con memoria di progetto `tiny-scaffold-docs-pattern.md`.

### 7.6 naming convention: 19 file con suffisso numerico

`business-logic-analysis-documentation-themes.md`, `dry-kiss-analysis-modulo-user.md`,
`architecture/architecture-1.md`: pattern classico di tool che duplica invece di
sovrascrivere. Zero violazioni per data nel nome (`YYYY-MM-DD`). La violazione piu'
grave resta il punto 7.1 (nomi >100 caratteri, spazi).

---

## Sintesi per severita' (cross-dimensione)

| Severita' | Count | Dimensioni coinvolte |
|---|---:|---|
| CRITICO | 2 (+1 per volume: 7.1) | Sicurezza (1.1, 1.2), Documentazione (7.1) |
| ALTO | 11 | Sicurezza (1.3, 1.4), Architettura (2.1, 2.2, 2.4), Qualita' (3.1, 3.2), Test (4.1, 4.2, 4.3), Performance (5.1, 5.2, 5.3), Schema |
| MEDIO | ~14 | tutte le dimensioni |
| BASSO | ~15 | tutte le dimensioni |

**Collegamenti cross-dimensione rilevanti:**
- 1.1 (UserPolicy bypass) e 4.1 (zero test su UserPolicy) sono lo stesso problema
  visto da due angolazioni: la mancanza di test ha permesso al bug di restare
  invisibile.
- 1.3 (GDPR no-cascade) dipende dal fix schema (FK cascade mancanti, sezione 6) -
  un fix Actions-only senza FK non e' sufficiente per garanzia strutturale.
- 2.1/2.2 (duplicazione CreateUserAction/Adapters) e 3.10 (helper fuori convenzione
  Actions) sono la stessa area di debito: consolidamento namespace `Actions/`.
  Vedi anche [[requisito-atterra-nel-modulo-del-meccanismo]] per il criterio di dove
  far atterrare la story di consolidamento.
- 3.8 (claim doc non riproducibili) blocca la story esistente `10.4` (gia'
  `blocked`): la doc va corretta prima di sbloccarla.

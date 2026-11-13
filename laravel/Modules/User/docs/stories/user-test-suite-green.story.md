---
title: "Suite Pest del modulo User verde in CI"
type: story
bmad: true
status: review
created: 2026-11-10
owner: module:User
module: User
related: [QA-01, SEC-05, dcp-285, issue-97]
tags: [tests, ci, pest, mariadb, policy, security]
---

# Suite Pest del modulo User verde in CI

## Contesto

CI `Pest (User)` del 2026-11-10: **149 failed**, 57 skipped, 1292 passed. Job con `DB_CONNECTION=mariadb`,
connessione `user` su `fixcity_user_test`, `QUEUE_CONNECTION=sync`, `CACHE_STORE=array`.
`xot:build-test-sqlite` costruisce solo lo SQLite condiviso: il database MariaDB `fixcity_user_test`
nasce vuoto e veniva migrato solo dal primo test che estende `Tests\TestCase` (root).

I due commit "mirror al root" (`becb0d58bd`, `9fd38b4912`) hanno riportato indietro alcune correzioni
nei file del modulo: per un test rosso su qualcosa gia' sistemato si confronta con la versione pre-mirror.

Nessun test e' stato cancellato. I test non girano in locale (PHP 8.3, niente `vendor/`): ogni file toccato
e' passato da `php -l`; la verifica e' la prossima CI.

## Cause, file, correzione

| Causa | File | Correzione | Test (stima) |
|---|---|---|---|
| Schema MariaDB `fixcity_user_test` assente finche' non gira un `Tests\TestCase` ("Table 'fixcity_user_test.users' doesn't exist") | `tests/TestCase.php` | `beginDatabaseTransaction()` lancia `migrate --force` una volta per processo prima delle transazioni (non su sqlite); `connectionsToTransact` + `mariadb`, `fixcity` | 11 |
| `assertDatabaseHas` sulla connessione di default (`mariadb`) per modelli della connessione `user` | `tests/Unit/Models/{Device,Permission,Profile,Team,Tenant}Test.php` | terzo argomento `'user'` | 21 |
| `teams()` su BaseUser e' la relazione Spatie (MorphToMany su `model_has_role`, "Unknown column 'role'"); l'appartenenza e' `membershipTeams()` | `tests/Unit/HasTeamsTraitTest.php`, `tests/Unit/Models/Traits/HasTeamsTest.php`, `tests/Unit/HasTeamsTraitPestTest.php`, `tests/Feature/UserBusinessLogicTest.php` | test su `membershipTeams()`; `allTeams()` = posseduti + membri (2) | 20 |
| Proprietario senza `['*']` in `teamPermissions()` (Jetstream) | `app/Models/Traits/HasTeams.php` | owner -> `['*']`, coerente con `hasTeamPermission()` | 1 |
| `ownsTeam(null)` restituisce `false`, non lancia | `tests/Unit/HasTeamsTraitTest.php` | asserzione aggiornata | 1 |
| Scope Spatie dichiarati come `scopeRole()`: `method_exists($m, 'role')` e' falso | `tests/Unit/Models/{Permission,Profile}Test.php` | `hasNamedScope()` | 6 |
| `created_by`/`updated_by` sono UUID (foreignIdFor User): `'user123'` scartato da MariaDB | `tests/Unit/Models/PermissionTest.php` | costanti UUID valide | 3 |
| `personal_team` castato a boolean | `tests/Unit/Models/TeamTest.php` | `assertTrue/False` | 2 |
| **Bug**: `tenants.settings` JSON senza cast ("Array to string conversion") | `app/Models/BaseTenant.php`, `app/Models/Tenant.php` | cast `settings => array`, `trial_ends_at => datetime` | 1 |
| **Bug**: TenantFactory calcolava lo slug dal nome casuale anche quando il test passa `name` | `database/factories/TenantFactory.php` | slug lasciato a HasSlug | 3 |
| `toHaveMethod()` di Pest falliva (`str_contains` su `false`); connessione `user` non `default` | `tests/Unit/TenantTest.php` | `method_exists()`; `'user'` | 5 |
| UserType/LanguageEnum restituiscono il valore tradotto, non la chiave | `tests/Unit/Enums/EnumClassesTest.php`, `tests/Unit/UserTypeTest.php`, `tests/Unit/Datas/UserDatasAndEnumsCoverageTest.php` | confronto con `trans()`; "Inglese" in locale it | 8 |
| `SystemRole::SuperAdmin` vale `'%'` (enum non usato altrove) | `tests/Unit/Enums/EnumClassesTest.php` | asserzione aggiornata | 1 |
| LoginWidget delega lo schema a `UserForm::getLoginFormSchema()` (Checkbox `remember`), vista `user::filament.widgets.login` | `tests/Unit/Filament/Widgets/LoginWidgetTest.php` | test riscritti sul comportamento attuale | 4 |
| `type` e' la colonna figlio di Parental (stringa); media model del progetto; label "Password" | `tests/Unit/UserTest.php`, `tests/Feature/UserModelTest.php`, `tests/Feature/PasswordDataLabelsTest.php` | asserzioni aggiornate | 3 |
| **Bug sicurezza**: il mutator salvava in chiaro le password lunghe >= 32 caratteri | `app/Models/Traits/BaseUserMutators.php` | si conserva solo un valore gia' hashato (`password_get_info`), il resto si hasha | 2 |
| **Bug**: `lastLoginIp()`/`previousLoginIp()` senza ordinamento | `app/Models/Traits/HasAuthenticationLogTrait.php` | `latest('login_at')` nei metodi (non sulla relazione, per non bloccare l'ordinamento delle tabelle) | 3 |
| **Bug**: Socialite `LoginUserAction` ignorava la relazione caricata, `getAttribute('deleted_at')` con `preventAccessingMissingAttributes` | `app/Actions/Socialite/LoginUserAction.php` | relazione caricata o query; null -> InvalidArgumentException; non Authenticatable -> LogicException; `deleted_at` dagli attributi grezzi | 10 |
| Chiave config `socialite.domain_allowlist` (non `filament-socialite.*`) | `tests/Feature/Actions/IsUserAllowedActionTest.php`, `tests/Unit/Actions/IsUserAllowedActionTest.php` | chiave aggiornata | 1 |
| **Bug**: `socialite.registration = null` disattivava la registrazione | `app/Actions/Socialite/IsRegistrationEnabledAction.php` | null -> default `true` | 1 |
| Componente `auth-header` nel namespace del modulo | `tests/Feature/AuthComponentsTest.php` | `user::components.auth-header` | 2 |
| **Bug** issue #97: associa client OAuth solo con `user_id`; `DetachAction` su MorphMany | `app/Filament/Resources/UserResource/RelationManagers/ClientsRelationManager.php` | `owner()->associate()`; azione `dissociateClient` che azzera owner e `user_id` | 2 |
| `XotBaseResource::getFormSchema()` e' final e vuoto: schema in `Schemas\*Form` | `tests/Feature/Filament/Resources/UserResourceTest.php`, `tests/Unit/UserExecuteCoverage50Test.php` | schema letto da `getFormClass()` | 10 |
| Asserzioni su metodi mai esistiti (`dehydrateSecret`, `providerClientId`, `tokenLifetime`; verificato con `git log -S`) | `tests/Unit/UserExecuteCoverage50Test.php` | asserzioni tolte, resto del test invariato | 2 |
| Vista `livewire/team/change.blade.php` del componente ritirato ancora presente (nessun riferimento) | `resources/views/livewire/team/change.blade.php` | rimossa | 1 |
| Vista TeamChange: `current_team_id` con `preventAccessingMissingAttributes`; test leggeva `getData()['view']` | `resources/views/filament/widgets/team/change.blade.php`, `tests/Feature/Filament/Widgets/Team/TeamChangeWidgetTest.php` | attributi grezzi; `$view->name()` | 3 |
| Pannello `admin` riservato ad admin/super-admin | `tests/Feature/Models/UserModelTest.php` | atteso `false` per un utente senza ruoli | 1 |
| **Bug schema**: `team_invitations.user_id` dichiarato dal model ma mai creato | `database/migrations/2026_11_10_000000_add_user_id_to_team_invitations_table.php` (nuova, additiva) | colonna `uuid` nullable indicizzata | 5 |
| Relazione inviti si chiama `teamInvitations()` | `tests/Feature/TeamManagementBusinessLogicInvitationsTest.php` | asserzione su HasMany | 1 |
| `joined_at` non e' fra i `withPivot` di `Team::users()` | `tests/Feature/TeamManagementTest.php` | letto dalla riga `team_user` | 1 |
| **Bug**: `GetUserTeamsOptionAction` invertiva nome/id e non aveva il placeholder | `app/Actions/Team/GetUserTeamsOptionAction.php` | `['' => '--- Select ---', id => nome]` | 4 |
| **Bug sicurezza** DCP-285: `before()` di XotBasePolicy lascia passare `user::admin` su tutto (ripristino, modifica di un super-admin) | `app/Models/Policies/BaseUserPolicy.php` | `before()` concede a priori solo al super-admin; `user::admin` segue le regole di ADMIN_ROLES | 5 |
| RolePolicy riserva la gestione dei ruoli al super-admin | `tests/Unit/UserPolicyBehaviorTest.php` | attese `false` | 1 |
| `$user->profile` usa la classe Profile del progetto (Fixcity, connessione `fixcity`) | `tests/Unit/UserModelsTest.php` | profilo creato con `XotData::getProfileClass()` | 1 |
| Confine contrattuale: `instanceof BaseUser` in runtime | `app/Actions/Auth/BuildActiveUserProviderAction.php` | `instanceof UserContract` | 1 |
| Fixture con hash fittizio di 30 caratteri | `tests/Unit/AuthenticationBusinessLogicTest.php` | hash bcrypt reale | 1 |
| Mirror `becb0d58bd` aveva riportato i messaggi `uploaded` con `:attribute` (TicketFormImagesLangTest di Fixcity) | `lang/de/validation.php`, `lang/es/validation.php` | ripristinata la versione pre-mirror (anche `file` in de) | Fixcity |

Totale stimato: circa 135 dei 149.

## Rimasti aperti

| Test | Motivo |
|---|---|
| `SuperAdminWidgetTest` (4) | Il profilo viene da `XotData::getProfileModel()` (Profile Fixcity, connessione `fixcity`) e il ruolo e' assegnato al `Modules\User\Models\User`: da verificare in CI se `hasRole` vede il ruolo (morph class / team id Spatie). Non correggibile alla cieca. |
| `LoginTranslationParityTest` (1) | La pagina di login usa `fixcity::auth.login.no_account.text` (modulo Fixcity, fuori scope). |
| `NotificationsCenterWidgetTest` redirect guest (1) | `/it/area-personale/notifications` da 404: la rotta/pagina sta nel tema o nel JSON CMS (fuori scope, regola pagine del tema). |
| `ClientCredentialsTest` (1) | `Invalid key supplied`: in CI mancano le chiavi Passport (`passport:keys` o `PASSPORT_PRIVATE_KEY`/`PUBLIC_KEY` nel workflow). |
| `DeletedAccountAccessTest` refresh token (1) | Gia' corretto a monte (subquery in RevokeUserAccessAction): verificare alla prossima CI. |
| `EmailVerificationFlowTest` (1) | Gia' corretto a monte (HasVerifiedIdentityAction legge gli attributi grezzi). |

## Fuori dal modulo User (da fare altrove)

- `.github/workflows/ci.yml`: generare le chiavi Passport per il job Pest (`php artisan passport:keys --force`).
- `Modules/Xot/app/Models/Policies/XotBasePolicy.php`: il bypass `{modulo}::admin` vale per ogni policy; le policy che proteggono
  privilegi (utenti, ruoli) devono sovrascrivere `before()` come fa ora `BaseUserPolicy`. Valutare un elenco di eccezioni nella base.
- `Modules/Xot/tests/XotModuleSchema.php` usa `Schema::hasTable()` sulla connessione di default anche per migration di altre connessioni.

## Secondo giro (CI run 42910837863)

CI `Pest (User)` sul commit `6b2a90c9bd`: **26 failed, 74 risky**, 6 todos, 52 skipped, 1419 passed (stessi 26 nel run 42912501538).

| Causa | File | Correzione | Test |
|---|---|---|---|
| Il mutator ora conserva solo hash veri: il finto hasher restituiva 60 `a`, riasate dal model | `tests/Unit/Actions/Otp/SendOtpByUserActionTest.php` | il mock restituisce un hash bcrypt reale | 1 |
| Fixture del token non implementa `ScopeAuthorizable` (tipo di ritorno di `UserContract::token()`, Passport 13) | `tests/Unit/Actions/Socialite/Fixtures/DeletableAccessTokenFixture.php` | `implements ScopeAuthorizable` (`can`/`cant`) | 1 |
| **Bug** (merge `d76139ee13`): `GetNewPasswordAction` generava la password ma non la salvava piu' | `app/Actions/User/GetNewPasswordAction.php` | salva `Hash::make()` con `forceFill()->save()`, restituisce il chiaro; senza `once()` (rigenerazioni successive diverse) | 2 |
| **Bug**: `belongsToTeam()` leggeva la relazione `membershipTeams` in cache, cieca dopo un `attach()` | `app/Models/Traits/HasTeams.php` | query su `team_user` (`teamUsers()->where('team_id')->exists()`) | 1 |
| Pivot `TeamUser` casta `permissions` ad array: il test passava JSON, codificato due volte | `tests/Unit/HasTeamsTraitTest.php` | array al posto di `json_encode` | 1 |
| `Profile::extra` e' `SchemalessAttributes`, non array | `tests/Unit/Models/ProfileTest.php` | `->extra->all()` | 1 |
| `tenants.settings` castato ad array (giro 1): JSON passato a mano codificato due volte; slug sempre generato da HasSlug | `tests/Unit/Models/TenantTest.php` | array; slug atteso `test-tenant` | 2 |
| **Bug**: `getFilamentAvatarUrl()` restituiva `''` senza media (img vuota) | `app/Models/BaseTenant.php` | `null` quando non c'e' l'avatar | 1 |
| **Bug schema**: `oauth_refresh_tokens.access_token_id` creata con `foreignIdFor(OauthAccessToken)`: chiave stringa -> colonna uuid(36), id Passport (80) troncato su connessioni non strict; revoca e rotazione dei refresh token non trovavano nulla | `database/migrations/2020_01_01_000003_create_oauth_refresh_tokens_table.php`, `database/migrations/2026_11_10_000001_fix_access_token_id_on_oauth_refresh_tokens_table.php` (nuova, additiva, idempotente) | `string('access_token_id', 100)`; la nuova porta a varchar le tabelle esistenti | 1 |
| Risposta API logout: messaggio con refuso e intera sessione nel JSON | `app/Http/Controllers/Api/LogoutController.php` | `Successfully logged out.` e `data.user_id` (non piu' `session()->all()`) | 1 |
| Filament 5: `Section::getChildComponents()` costruisce lo schema figlio e vuole il container Livewire; `created_at` e' un `TextEntry`, non un `Field` | `tests/TestCase.php`, `tests/Support/helpers.php`, `tests/Support/helpers-extended.php` | componenti letti da `getDefaultChildComponents()`; ricerca per nome anche su `Entry` | 7 |
| URL della pagina CMS e' `area-personale/notifiche` | `tests/Feature/Filament/Widgets/NotificationsCenterWidgetTest.php` | URL aggiornato | 1 |
| Ruoli assegnati a `Modules\User\Models\User`, il profilo guarda l'utente del progetto (morph class diversa) | `tests/Feature/Filament/Widgets/SuperAdminWidgetTest.php` | ruolo assegnato all'utente di `XotData::getUserClass()` e test su quello | 4 |
| La pagina di login e' del tema con le frasi del progetto | `tests/Feature/LoginTranslationParityTest.php` | verifica CTA inglesi e assenza di chiavi grezze | 1 |
| Chiave `user::password.fields.password_confirmation.label` assente (in it il merge aveva tolto `fields`): label di ripiego dagli attributi di validazione Fixcity (`conferma password`) | `lang/it/password.php`, `lang/en/password.php`, `lang/de/password.php` | sezione `fields` con `password` e `password_confirmation` | 1 |

Rischiosi (74): 49 erano test "can be instantiated" senza asserzioni; ora usano `expect(...)->toBeInstanceOf()`
(`tests/Unit/Models/AdditionalModelsTest.php` 21, `tests/Unit/Datas/DataClassesTest.php` 12,
`tests/Unit/Datas/AdditionalDatasTest.php` 11, `tests/Unit/Console/ConsoleCommandsTest.php` 5). I ~25 restanti sono sparsi
(un test o due per file) e restano da sistemare uno per uno.

### Rimasti aperti

- `app/Models/Traits/HasTeams.php:211` usa gia' `new Collection($items)->unique()` (sintassi PHP 8.4, preesistente): `php -l` 8.3 locale fallisce, la CI (8.4) no.
- Da verificare alla prossima CI: refresh token (dipende dalla nuova migration), SuperAdminWidget (morph class utente del progetto).

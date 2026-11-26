---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 85 file oltre target 100.

### `authentication-login.md` — Autenticazione e login


# Autenticazione e login

Questa pagina descrive come un ospite diventa utente autenticato nel modulo User, leggendo il codice installato.
Per il logout vedi [logout.md](logout.md), per la registrazione [registration.md](registration.md),
per i provider esterni [socialite-sso.md](socialite-sso.md) e [passport-oauth.md](passport-oauth.md).

## Rotte

| Rotta | Dove | Note |
|---|---|---|
| `/{lang}/login`, `/register`, `/forgot-password`, `/reset-password/{token}` | `routes/auth.php` (Volt, middleware `guest`) | nomi `login`, `register`, `password.request`, `password.reset` |
| `/{lang}/verify-email`, `/verify-email/{id}/{hash}`, `/confirm-password` | `routes/auth.php` (middleware `auth`) | il link firmato usa `signed` + `throttle:6,1` |
| `POST /logout` | `routes/web.php` | middleware `au

### `contracts/analyze-socialite-email-domain-action.md` — AnalyzeSocialiteEmailDomainAction


# AnalyzeSocialiteEmailDomainAction

Dice se la email di un utente SSO appartiene al dominio di primo livello (`first_party`) o a quello cliente (`client`) configurati per il provider. Codice: `app/Actions/Socialite/AnalyzeSocialiteEmailDomainAction.php`.

## Input

- `SocialiteUserContract $oauthUser`: utente restituito dal provider.
- `string $provider`: chiave in `config/services.php`; non può essere vuota.

## Output

- `SocialiteEmailDomainAnalysisData`: `hasFirstPartyDomain` e `hasClientDomain`, entrambi `bool`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-DOMAIN-INV-1` | Provider vuoto: `InvalidArgumentException`. | `execute()` | `tests/Unit/Actions/Socialite/AnalyzeSocialiteEmailDomainActionTest.php:30` |
| `SOCIALITE-DOMAIN-INV-2` | Il 

### `contracts/authentication-log-query-action.md` — AuthenticationLogQueryAction


# AuthenticationLogQueryAction

Costruisce la query dei log di autenticazione di un modello autenticabile. Codice: `app/Actions/Activity/AuthenticationLogQueryAction.php:15-25`.

## Input

- `Model $authenticatable`: il modello di cui si cercano i log (`execute`, riga 20).

## Output

- `Builder<AuthenticationLog>` non eseguito: filtra `authenticatable_type` = `getMorphClass()` e `authenticatable_id` = `getKey()` (righe 22-24).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `AUTH-LOG-QUERY-INV-1` | Il filtro usa solo morph class e chiave del modello passato; nessun altro vincolo. | righe 22-24 | Test: nessuno (nessun riferimento alla classe in `tests/`). |
| `AUTH-LOG-QUERY-INV-2` | Il builder non viene eseguito: la query parte solo al consumo del chiamante.

### `contracts/build-active-user-provider-action.md` — BuildActiveUserProviderAction


# BuildActiveUserProviderAction

Costruisce il provider utenti che esclude gli account cancellati dal titolare (SEC-05). Codice: `app/Actions/Auth/BuildActiveUserProviderAction.php`; registrazione: `app/Providers/UserServiceProvider.php:157-175`.

## Input

- `Hasher $hasher`, `string $model`: classe del modello utente (`execute`).

## Output

- Un `EloquentUserProvider` con una query di base che applica il filtro `deleted_at IS NULL`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente (senza group) |
|---|---|---|---|
| `USER-PROVIDER-INV-1` | Il filtro `whereNull(deleted_at)` si applica solo se il modello è un `UserContract` e ha la colonna `deleted_at`. | `BuildActiveUserProviderAction.php:36-42` | `tests/Feature/Auth/DeletedAccountAccessTest.php:36,52` |
| `USER-PROVIDE

### `contracts/build-api-login-limit-action.md` — BuildApiLoginLimitAction


# BuildApiLoginLimitAction

Costruisce il limite di frequenza del `POST /api/user/login` (D-08, DCP-282), registrato come limiter `user-login` in `UserServiceProvider`. Codice: `app/Actions/Auth/BuildApiLoginLimitAction.php:19-42`.

## Input

- `Request $request`: legge `email` (se stringa) e l'IP del client (`execute`, riga 27).

## Output

- `Illuminate\Cache\RateLimiting\Limit` con chiave `email|IP` (email in minuscolo e traslitterata), 5 richieste per 60 secondi, e una risposta 429 personalizzata (righe 32-41).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `API-LOGIN-LIMIT-INV-1` | Il limite è `MAX_ATTEMPTS = 5` richieste per `DECAY_SECONDS = 60` secondi. | righe 21-25, 32 | Test: nessuno (il docblock cita un test di coerenza con `LoginWidget` non trova

### `contracts/build-password-reset-url-action.md` — BuildPasswordResetUrlAction


# BuildPasswordResetUrlAction

Costruisce l'URL assoluto del link di reset password inserito nell'email (SEC-007). Codice: `app/Actions/Auth/BuildPasswordResetUrlAction.php:16-42`.

## Input

- `string $token`: token di reset (`execute`, riga 21).
- `?string $email`: se non vuoto viene aggiunto come query `?email=` (precompilazione della pagina).

## Output

- `string`: `config('app.url')` senza slash finale, più il percorso `password.reset` relativo, con la lingua della richiesta e l'eventuale `email` (righe 23-40).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PWD-URL-INV-1` | La radice dell'URL viene da `config('app.url')`, mai dall'header `Host` della richiesta. | righe 23, 40 | Test: nessuno. |
| `PWD-URL-INV-2` | Se la lingua della richiesta è tra qu

### `contracts/consume-auth-submission-slot-action.md` — ConsumeAuthSubmissionSlotAction


# ConsumeAuthSubmissionSlotAction

Sorgente: `app/Actions/Auth/ConsumeAuthSubmissionSlotAction.php`. Perché: [ADR](../adr/auth-submission-throttle-before-validation.md).

## Input

- `AuthThrottleScope $scope`: `Register` o `ForgotPassword`.
- `string $email`: quanto digitato (anche vuoto o non valido).
- `?string $ip`: IP della richiesta; null diventa `unknown`.

## Output

- `int`: 0 = invio consentito (e già conteggiato); > 0 = secondi da attendere.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| USER-AUTH-THROTTLE-INV-1 | Ogni chiamata con esito 0 conta un tentativo, qualunque sia l'esito della validazione che segue. | `USER-AUTH-THROTTLE-INV-1` |

### `contracts/create-client-action.md` — CreateClientAction


# CreateClientAction

Crea e salva un client OAuth2 Passport (`oauth_clients`). Codice: `app/Actions/Passport/CreateClientAction.php`.

## Input

- `string $name`, `string $redirect`: nome e URI di redirect del client; nessuna validazione nell'Action.
- `?UserContract $user = null`: proprietario; se assente `user_id` non viene valorizzato.
- `bool $personalAccess = false`, `bool $password = false`: flag del tipo di client, passati senza controlli incrociati.
- `?string $provider = null`: se assente vale `'users'`.

## Output

- `OauthClient`: il modello appena salvato, con `id` (UUID v4) e `secret` (40 caratteri casuali) in chiaro.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|

### `contracts/create-generic-client-action.md` — CreateGenericClientAction


# CreateGenericClientAction

Crea e salva un client OAuth2 Passport con i flag di tipo passati dal chiamante. È la base usata da `CreatePasswordClientAction` e `CreatePersonalAccessClientAction`. Codice: `app/Actions/Passport/CreateGenericClientAction.php`.

## Input

- `string $name`, `string $redirect`.
- `bool $personalAccess`, `bool $password`: obbligatori, passati senza controlli.
- `?UserContract $user = null`, `?string $provider = null` (default `'users'`).

## Output

- `OauthClient`: modello salvato, con `id` UUID e `secret` di 40 caratteri in chiaro.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-GENERIC-CLIENT-INV-1` | `personal_access_client` e `password_client` riflettono esattamente i due argomenti. | `execute()` | `tests/Unit/Actions

### `contracts/create-password-client-action.md` — CreatePasswordClientAction


# CreatePasswordClientAction

Crea un client OAuth2 di tipo *password grant* delegando a `CreateGenericClientAction` con `password: true` e `personalAccess: false`. Codice: `app/Actions/Passport/CreatePasswordClientAction.php`.

## Input

- `string $name`, `string $redirect`, `?UserContract $user = null`, `?string $provider = null`.

## Output

- `OauthClient`: il valore restituito da `CreateGenericClientAction::execute()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-PWD-CLIENT-INV-1` | Il client restituito ha `password_client = true` e `personal_access_client = false`. | `execute()`, argomenti fissi | `tests/Unit/Actions/Passport/CreateSpecificClientActionsTest.php:29` |
| `PASSPORT-PWD-CLIENT-INV-2` | Nessun comportamento proprio: tutto il res

### `contracts/create-personal-access-client-action.md` — CreatePersonalAccessClientAction


# CreatePersonalAccessClientAction

Crea un client OAuth2 di tipo *personal access* delegando a `CreateGenericClientAction` con `personalAccess: true` e `password: false`. Codice: `app/Actions/Passport/CreatePersonalAccessClientAction.php`.

## Input

- `string $name`, `string $redirect`, `?UserContract $user = null`, `?string $provider = null`.

## Output

- `OauthClient`: il valore restituito da `CreateGenericClientAction::execute()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-PAT-CLIENT-INV-1` | Il client restituito ha `personal_access_client = true` e `password_client = false`. | `execute()`, argomenti fissi | `tests/Unit/Actions/Passport/CreateSpecificClientActionsTest.php:45` |

## Effetti collaterali

### `contracts/create-socialite-user-action.md` — CreateSocialiteUserAction


# CreateSocialiteUserAction

Crea il record `SocialiteUser` che collega un utente locale a un'identità del provider OAuth. Codice: `app/Actions/Socialite/CreateSocialiteUserAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`, `UserContract $user`.

## Output

- `SocialiteUser`: il record creato da `create()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-CREATE-SU-INV-1` | Il record ha `user_id`, `provider`, `provider_id`, `name`, `email`, `avatar` presi da input e provider. | `execute()`, array attributi | `tests/Unit/Actions/Socialite/SocialiteCoreActionsCoverageTest.php:133` |
| `SOCIALITE-CREATE-SU-INV-2` | Il nickname non è salvato (riga commentata). | `execute()` | nessuno |


### `contracts/create-user-action.md` — CreateUserAction


# CreateUserAction

Crea un nuovo utente con nome, email e password hashata; include due passi che oggi sono solo log. Codice: `app/Actions/CreateUserAction.php` (namespace `Modules\User\Actions`), righe 22-77. Non è il `execute()` standard: l'entrypoint è `handle()`.

## Input

- Costruttore: `string $name`, `string $email`, `string $password`, `?array $data` (righe 29-34).

## Output

- `User` appena creato (`handle()`, riga 45).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `CREATE-USER-INV-1` | Nome e email non vuoti ed email valida, altrimenti `InvalidArgumentException` alla costruzione. | righe 36-42 | Test: riferimenti per nome in `tests/Unit/Actions/AdditionalActionsTest.php`, `tests/Unit/Actions/User/CreateUserActionTest.php`, `tests/Unit/QuickWins

### `contracts/delete-user-action.md` — DeleteUserAction


# DeleteUserAction

Cancella l'account dopo la verifica della password di conferma. Codice: `app/Actions/User/DeleteUserAction.php:12-50`.

## Input

- `UserContract $user` (`execute`, riga 26).
- `string $confirmPassword`: password in chiaro da verificare.

## Output

- `array{success: bool, message: string}` (righe 24, 30-48).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `DELETE-USER-INV-1` | Senza password corrispondente l'utente non viene cancellato e non si esegue il logout. | righe 28-34 | `tests/Unit/Actions/User/DeleteUserActionTest.php`, `tests/Unit/Actions/AdditionalActionsTest.php` (riferimenti alla classe) |
| `DELETE-USER-INV-2` | Il logout della guard precede la cancellazione. | righe 37-38 | come sopra |

### `contracts/ensure-reset-password-mail-template-action.md` — EnsureResetPasswordMailTemplateAction


# EnsureResetPasswordMailTemplateAction

Garantisce il template `reset-password` della mail di reimpostazione password, in tutte le lingue del sito (DCP-285, D-05). Codice: `app/Actions/Auth/EnsureResetPasswordMailTemplateAction.php:20-78`.

## Input

- Nessuno.

## Output

- `MailTemplate` esistente o appena creato (riga 53).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `MAIL-TPL-INV-1` | Il template è identificato da `mailable` = `SpatieEmail` e `slug` = `reset-password`; se manca viene creato con layout `base.html`. | righe 24, 38-41 | Test: nessuno. |
| `MAIL-TPL-INV-2` | Per ogni lingua in `it`, `en`, `de`, `es` il testo è scritto solo se la lingua è vuota oppure contiene ancora il default legacy e non il segnaposto URL. | righe 27-30, 43-45, 56-65 | 

### `contracts/get-authentication-log-query-action.md` — GetAuthenticationLogQueryAction


# GetAuthenticationLogQueryAction

Restituisce il query builder dei log di autenticazione di un modello autenticabile. Codice: `app/Actions/Auth/GetAuthenticationLogQueryAction.php:15-27`.

## Input

- `Model $authenticatable` (`execute`, riga 22).

## Output

- `Builder<AuthenticationLog>` non eseguito, filtrato su `authenticatable_type` (morph class) e `authenticatable_id` (riga 24-26).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `GET-AUTH-LOG-INV-1` | Il filtro è esattamente morph class e chiave del modello; nessun altro vincolo. | righe 24-26 | Test: nessuno (nessun riferimento alla classe in `tests/`). |

## Effetti collaterali

### `contracts/get-authentication-log-query-for-authenticatable-action.md` — GetAuthenticationLogQueryForAuthenticatableAction


# GetAuthenticationLogQueryForAuthenticatableAction

Restituisce il query builder dei log di autenticazione di un modello autenticabile. Codice: `app/Actions/Authentication/GetAuthenticationLogQueryForAuthenticatableAction.php:12-25`.

## Input

- `Model $authenticatable` (`execute`, riga 19).

## Output

- `Builder<AuthenticationLog>` non eseguito, filtrato su morph class e chiave (righe 21-23).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `GET-AUTH-LOG-FOR-AUTH-INV-1` | Il filtro è esattamente morph class e chiave del modello. | righe 21-23 | Test: nessuno (nessun riferimento alla classe in `tests/`). |

## Effetti collaterali

### `contracts/get-current-device-action.md` — GetCurrentDeviceAction


# GetCurrentDeviceAction

Trova o crea la riga `Device` del dispositivo che sta facendo la richiesta, e ne aggiorna browser e versione. Codice: `app/Actions/GetCurrentDeviceAction.php:14-92`.

## Input

- `?string $mobileId`: identificativo del dispositivo mobile, se disponibile (`execute`, riga 26).
- Dipendenze iniettate: `Agent` (user agent) e `Device` (modello).

## Output

- `Device` (riga 42 con `mobile_id`, riga 51 senza).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `DEVICE-INV-1` | Con `$mobileId` non null il dispositivo si cerca per `mobile_id`; con stringa vuota (anche `"0"`) lancia `InvalidArgumentException`. | righe 31-36 | `tests/Unit/Actions/GetCurrentDeviceActionTest.php`, `tests/Unit/Actions/User/UserMiscActionsTest.php` (riferimento alla 

### `contracts/get-domain-allow-list-action.md` — GetDomainAllowListAction


# GetDomainAllowListAction

Restituisce la lista dei domini ammessi al login SSO da `config('socialite.domain_allowlist')`, normalizzata. Codice: `app/Actions/Socialite/GetDomainAllowListAction.php`.

## Input

- Nessuno. Riceve per iniezione `Illuminate\Support\Arr`, usato per `wrap()`.

## Output

- `array<int, string>`: lista indicizzata. Vuota se la config è assente o di tipo non gestito.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-ALLOW-INV-1` | Una stringa diventa lista di un elemento. | `execute()`, ramo `is_string` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:31` |
| `SOCIALITE-ALLOW-INV-2` | Elementi non scalari né `Stringable` sono scartati; resta una lista indicizzata. | `execute()`, `array_filter` | `SocialiteUtil

### `contracts/get-guard-action.md` — GetGuardAction


# GetGuardAction

Restituisce il guard di autenticazione indicato da `config('filament.auth.guard')`. Codice: `app/Actions/Socialite/GetGuardAction.php`.

## Input

- Nessuno.

## Output

- `StatefulGuard|Guard`: il guard risolto con `auth()->guard()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-GUARD-INV-1` | Il nome del guard deve essere una stringa. | `Assert::string()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:102` |

## Effetti collaterali

### `contracts/get-missing-provider-settings-action.md` — GetMissingProviderSettingsAction


# GetMissingProviderSettingsAction

Elenca le variabili d'ambiente che mancano, o sono segnaposto, perché un provider OAuth sia utilizzabile. Codice: `app/Actions/Socialite/GetMissingProviderSettingsAction.php`.

## Input

- `string $provider`: chiave di `config/services.php`.

## Output

- `list<string>`: nomi delle variabili da impostare, nell'ordine `CLIENT_ID`, `CLIENT_SECRET`, `REDIRECT_URI` con prefisso del provider in maiuscolo (es. `GOOGLE_CLIENT_ID`). Vuota se il provider è configurato.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-MISSING-ENV-INV-1` | Una chiave è "reale" solo se è stringa, non vuota dopo `trim` e non corrisponde al pattern segnaposto. | `isRealValue()` | `tests/Unit/Actions/Socialite/ProviderSettingsActionsTest.php:27,

### `contracts/get-new-password-action.md` — GetNewPasswordAction


# GetNewPasswordAction

Genera una nuova password temporanea pronunciabile, ne salva l'hash sull'utente e restituisce il valore in chiaro da comunicare una sola volta. Codice: `app/Actions/User/GetNewPasswordAction.php:14-34`.

## Input

- `UserContract $record`: deve essere un `Model` (riga 24).

## Output

- `string`: la password in chiaro, lunga 12 caratteri (riga 26).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `NEW-PWD-INV-1` | Sul modello è salvato solo l'hash `Hash::make`, mai il valore in chiaro. | righe 28-30 | `tests/Unit/Actions/User/GetNewPasswordActionTest.php` (riferimento alla classe) |
| `NEW-PWD-INV-2` | Il valore restituito è quello generato da `GetPronounceablePasswordAction` (Xot) con lunghezza 12. | riga 26 | come sopra |
| `NEW-PWD-I

### `contracts/get-permission-model-action.md` — GetPermissionModelAction


# GetPermissionModelAction

Restituisce il nome della classe modello dei permessi, da config, con default Spatie. Codice: `app/Actions/GetPermissionModelAction.php:11-24`.

## Input

- Nessuno: legge `permission.models.permission`.

## Output

- `class-string`: il valore configurato o `Spatie\Permission\Models\Permission` (righe 20-23).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PERM-MODEL-INV-1` | Senza config il risultato è `Spatie\Permission\Models\Permission`. | riga 20 | Test: nessuno. |
| `PERM-MODEL-INV-2` | Il valore deve essere una stringa e una classe esistente, altrimenti eccezione Webmozart. | righe 20-21 | Test: nessuno. |


### `contracts/get-post-login-url-action.md` — GetPostLoginUrlAction


# GetPostLoginUrlAction

Restituisce la pagina d'arrivo dopo login e registrazione quando nessuna pagina l'ha richiesta: l'area personale localizzata. Codice: `app/Actions/Auth/GetPostLoginUrlAction.php:21-39`.

## Input

- Nessuno: legge la lingua corrente e la config.

## Output

- `string`: URL localizzato con `LaravelLocalization::localizeURL` (riga 37).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `POST-LOGIN-INV-1` | Se la lingua corrente non è tra quelle supportate si usa `app.locale` (default `it`). | righe 28-31 | `tests/Feature/Auth/AuthFlowRedirectsTest.php` e `tests/Unit/Filament/Widgets/Auth/LoginWidgetLocalizationTest.php` (riferimento alla classe) |
| `POST-LOGIN-INV-2` | Il percorso è letto da `auth.post_login_path`, con default `/area-pers

### `contracts/get-user-model-attributes-from-socialite-action.md` — GetUserModelAttributesFromSocialiteAction


# GetUserModelAttributesFromSocialiteAction

Traduce l'identità OAuth in un DTO di attributi per il modello utente, con validazioni esplicite. Codice: `app/Actions/Socialite/GetUserModelAttributesFromSocialiteAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`.

## Output

- `SocialiteUserAttributesData`: `name`, `firstName`, `lastName`, `email`, `provider`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-USER-ATTR-INV-1` | `provider` vuoto: `InvalidArgumentException`. | `execute()` | `tests/Unit/Actions/Socialite/SocialiteCoreActionsCoverageTest.php:44` |
| `SOCIALITE-USER-ATTR-INV-2` | Nome o cognome non stringa: `RuntimeException`. | `execute()` | `SocialiteCoreActionsCoverageTest.php:58` |
| `SOCIALITE-USER-ATTR-INV

### `contracts/get-user-teams-option-action.md` — GetUserTeamsOptionAction


# GetUserTeamsOptionAction

Costruisce le opzioni di una Select con i team dell'utente corrente. Codice: `app/Actions/Team/GetUserTeamsOptionAction.php:10-31`.

## Input

- Nessuno: usa l'utente della richiesta tramite `authId()` (riga 19).

## Output

- `array<int|string, string>`: placeholder `'' => '--- Select ---'` seguito da `id team => nome team` (righe 22-29).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `TEAMS-OPT-INV-1` | Il placeholder è sempre la prima voce. | riga 22 | `tests/Unit/Actions/Team/GetUserTeamsOptionActionTest.php` (riferimento alla classe) |
| `TEAMS-OPT-INV-2` | Compaiono solo i team collegati tramite `team_user` all'utente corrente. | riga 19 | come sopra |
| `TEAMS-OPT-INV-3` | Le righe orfane (team cancellato) sono saltate. | r

### `contracts/has-verified-identity-action.md` — HasVerifiedIdentityAction


# HasVerifiedIdentityAction

## Input
- Utente autenticabile opzionale.
## Output
- `true` per email verificata o metodo `spid`/`cie`; `false` per utente assente o non verificato.
## Invarianti
- SPID/CIE attestano l'identità applicativa, ma non impostano `email_verified_at`.
## Effetti collaterali
- Nessuno: legge sessione e attributi grezzi.
## Errori
- Nessun errore applicativo per utente nullo: restituisce `false`.
## Non fa
- Non invia email, non modifica l'utente e non concede ruoli o permessi.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|

### `contracts/hash-otp-value-action.md` — HashOtpValueAction


# HashOtpValueAction

Calcola l'hash di un valore OTP con l'hasher Illuminate. Codice: `app/Actions/Otp/HashOtpValueAction.php:10-21`.

## Input

- `string $value`: il valore in chiaro (`execute`, riga 18).

## Output

- `string`: l'hash prodotto da `Hasher::make()` (riga 20).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `HASH-OTP-INV-1` | Il risultato è esattamente `make()` dell'hasher iniettato (contratto Illuminate, non il wrapper `Otp\Hasher`). | righe 14-20 | `tests/Unit/Actions/Otp/OtpHashActionsTest.php` (riferimento alla classe) |

## Effetti collaterali

### `contracts/hasteamsandusercontract.md` — HasTeamsAndUserContract


# HasTeamsAndUserContract

L'interfaccia `HasTeamsAndUserContract` estende sia `HasTeamsContract` che `UserContract`, fornendo un'unica interfaccia che combina le funzionalità di entrambe.

## Metodi

### Team Management

- `teamRole(Team $team): ?string`
  - Ottiene il ruolo dell'utente nel team specificato
  - Restituisce `null` se l'utente non appartiene al team
  - Restituisce `'owner'` se l'utente è il proprietario del team
  - Restituisce il ruolo specifico altrimenti

- `canRemoveTeamMember(Team $team, HasTeamsContract $user): bool`
  - Determina se l'utente può rimuovere un membro del team
  - Richiede che l'utente sia proprietario del team o abbia il permesso 'remove-member'

- `canUpdateTeamMember(Team $team, HasTeamsContract $user): bool`

### `contracts/is-notification-schema-readable-action.md` — IsNotificationSchemaReadableAction


# IsNotificationSchemaReadableAction

Verifica che la tabella `notifications` esista sulla connessione del modello prima di interrogarla dal front office. Codice: `app/Actions/Notification/IsNotificationSchemaReadableAction.php:14-30`.

## Input

- Nessuno.

## Output

- `bool`: `hasTable` della tabella del modello `Notification` (riga 28).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `NOTIF-SCHEMA-INV-1` | Se il modello non dichiara connessione si usa la connessione di default (`mysql` se la config non è una stringa). | righe 22-26 | `tests/Unit/UserExecuteCoverage50Test.php` (riferimento alla classe) |
| `NOTIF-SCHEMA-INV-2` | Restituisce solo l'esistenza della tabella, non le colonne. | riga 28 | come sopra |


### `contracts/is-provider-configured-action.md` — IsProviderConfiguredAction


# IsProviderConfiguredAction

Dice se un provider OAuth ha tutte le impostazioni reali. Codice: `app/Actions/Socialite/IsProviderConfiguredAction.php`.

## Input

- `string $provider`.

## Output

- `bool`: `true` se `GetMissingProviderSettingsAction` non ritorna variabili mancanti.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-IS-CONFIGURED-INV-1` | `true` se e solo se la lista delle mancanti è vuota. | `execute()` | `tests/Unit/Actions/Socialite/ProviderSettingsActionsTest.php:65,68` |

## Effetti collaterali

### `contracts/is-registration-enabled-action.md` — IsRegistrationEnabledAction


# IsRegistrationEnabledAction

Dice se la registrazione di nuovi utenti via SSO è abilitata. Codice: `app/Actions/Socialite/IsRegistrationEnabledAction.php`.

## Input

- Nessuno.

## Output

- `bool`: `true` se `config('socialite.registration')` è null o assente; altrimenti `(bool)` del valore.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REG-ENABLED-INV-1` | Config assente o null: registrazione attiva. | `execute()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:55,63` |

## Effetti collaterali

### `contracts/is-user-allowed-action.md` — IsUserAllowedAction


# IsUserAllowedAction

Decide se l'utente SSO può accedere, controllando il dominio della sua email contro `GetDomainAllowListAction`. Codice: `app/Actions/Socialite/IsUserAllowedAction.php`.

## Input

- `SocialiteUserContract $user`.

## Output

- `bool`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-ALLOWED-INV-1` | Allowlist vuota: accesso consentito a tutti. | `execute()`, `count < 1` | `tests/Unit/Actions/IsUserAllowedActionTest.php:29` |
| `SOCIALITE-ALLOWED-INV-2` | Con allowlist, vale il dominio della email (parte dopo l'ultimo `@`, in minuscolo) presente nella lista. | `execute()` | `IsUserAllowedActionTest.php:36` |


### `contracts/is-user-database-configured-action.md` — IsUserDatabaseConfiguredAction


# IsUserDatabaseConfiguredAction

Dice se la connessione `user` ha un database configurato, senza aprirla. Codice: `app/Actions/Database/IsUserDatabaseConfiguredAction.php:23-33`.

## Input

- Nessuno: legge `database.connections.user.database`.

## Output

- `bool`: `true` se il valore è una stringa non vuota dopo `trim` (riga 31).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `USER-DB-CONFIGURED-INV-1` | Non apre la connessione né interroga lo schema. | righe 27-32 | `tests/Unit/Actions/Database/IsUserDatabaseConfiguredActionTest.php` (riferimento alla classe) |
| `USER-DB-CONFIGURED-INV-2` | Un valore non stringa o vuoto dà `false`. | riga 31 | come sopra |


### `contracts/log-registration-action.md` — LogRegistrationAction


# LogRegistrationAction

Scrive nel log di attività la registrazione di un nuovo utente. Codice: `app/Actions/Activity/LogRegistrationAction.php:10-28`.

## Input

- `User $user`: l'utente appena registrato (usato solo per `type`).
- `array<string, mixed> $properties`: proprietà extra (default `[]`).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `LOG-REG-INV-1` | Le proprietà registrate sono `type` dell'utente, `ip_address` e `user_agent` della richiesta, unite con `$properties`; in caso di chiave uguale vince `$properties`. | righe 22-26 | `tests/Unit/Actions/Activity/LogRegistrationActionTest.php` (riferimento alla classe) |
| `LOG-REG-INV-2` | La descrizione del log è fissa: `User registered via GDPR-compliant RegisterWidget`. | rig

### `contracts/login-user-action.md` — LoginUserAction


# LoginUserAction

Accede al pannello con l'utente collegato all'identità SSO, dopo aver scartato gli account eliminati. Codice: `app/Actions/Socialite/LoginUserAction.php`.

## Input

- `SocialiteUser $socialiteUser`: la relazione `user` è usata se caricata, altrimenti letta dal database.

## Output

- `RedirectResponse`: `redirect()->intended('/')` in caso di successo; redirect al login con messaggio `auth.user-not-allowed` se l'account ha `deleted_at`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-LOGIN-INV-1` | Senza utente collegato: `InvalidArgumentException`. | `execute()` | nessuno |
| `SOCIALITE-LOGIN-INV-2` | Utente non `Authenticatable` né `UserContract`: `LogicException`. | `execute()` | nessuno |
| `SOCIALITE-LOGIN-INV-3` | Account c

### `contracts/logout-user-action.md` — LogoutUserAction


# LogoutUserAction

Chiude l'accesso di un utente: revoca il suo access token Passport e i refresh token collegati, e marca il logout sui dispositivi. Codice: `app/Actions/Socialite/LogoutUserAction.php`.

## Input

- `UserContract $user`: deve avere un token attivo (`$user->token()`).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-LOGOUT-INV-1` | Senza token: `AssertionFailedException`. | `Assert::notNull` | nessuno |
| `SOCIALITE-LOGOUT-INV-2` | I refresh token con `access_token_id` del token sono revocati (non cancellati). | `execute()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:152` (chiamata) |
| `SOCIALITE-LOGOUT-INV-3` | I `DeviceUser` dell'utente hanno `logout_at` = ora. | `execute()` | stesso rif

### `contracts/otp-hash-needs-rehash-action.md` — OtpHashNeedsRehashAction


# OtpHashNeedsRehashAction

Dice se un hash OTP va ricalcolato con l'algoritmo corrente. Codice: `app/Actions/Otp/OtpHashNeedsRehashAction.php:10-21`.

## Input

- `string $hashedValue`: l'hash salvato (`execute`, riga 18).

## Output

- `bool`: esito di `needsRehash()` dell'hasher iniettato (riga 20).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `OTP-REHASH-INV-1` | Il risultato è esattamente `needsRehash()` dell'hasher Illuminate. | riga 20 | `tests/Unit/Actions/Otp/OtpHashActionsTest.php` (riferimento alla classe) |

## Effetti collaterali

### `contracts/process-callback-action.md` — ProcessCallbackAction


# ProcessCallbackAction

Gestisce il ritorno dal provider OAuth: valida il provider, recupera l'utente, applica le regole di accesso e registrazione, poi autentica. È la logica dietro la pagina Folio del callback. Codice: `app/Actions/Socialite/ProcessCallbackAction.php`.

## Input

- `string $lang`: lingua della pagina di ingresso (fallback).
- `string $provider`.

## Output

- `RedirectResponse`: verso il dashboard, o verso il login con un messaggio di errore.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-CALLBACK-INV-1` | La lingua è quella salvata in sessione (`ProcessCallbackSession::KEY`) se supportata, altrimenti `$lang`. | `execute()`, `session()->pull` | `tests/Feature/Socialite/OauthCallbackFolioPageTest.php:35` (solo `class_exists`) |


### `contracts/record-authentication-log-action.md` — RecordAuthenticationLogAction


# RecordAuthenticationLogAction

Sorgente: `app/Actions/Auth/RecordAuthenticationLogAction.php`. Chiamata da `LoginListener` e `FailedLoginListener`.
Perché: [ADR](../adr/authentication-log-never-breaks-login.md).

## Input

- `UserContract&HasAuthentications $user`.
- `$attributes`: `ip_address`, `user_agent`, `login_at`, `login_successful`, `location`.
Scrive una riga in `authentication_logs` sulla connessione `user` per ogni tentativo di accesso. Codice: `app/Actions/Auth/RecordAuthenticationLogAction.php:25-58`.

## Input

- `UserContract&HasAuthentications $user`: l'utente (`execute`, riga 30).
- `array $attributes`: `ip_address`, `user_agent`, `login_at`, `login_successful`, `location` (riga 28).

## Output

- `void`.

### `contracts/record-login-pulse-action.md` — RecordLoginPulseAction


# RecordLoginPulseAction

Registra un accesso nel contatore aggregato di Laravel Pulse. Codice: `app/Actions/Login/RecordLoginPulseAction.php:10-22`.

## Input

- `DateTimeInterface $loginAt`: momento dell'accesso (`execute`, riga 12).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PULSE-LOGIN-INV-1` | Registra il tipo `user_login` con chiave `all`, come conteggio. | righe 14-19 | `tests/Unit/Actions/Auth/RecordAuthenticationLogActionTest.php` (riferimento alla classe, non dedicato) |
| `PULSE-LOGIN-INV-2` | Scrive solo bucket aggregati (`onlyBuckets`), nessuna riga di dettaglio. | riga 20 | come sopra |


### `contracts/redirect-to-login-action.md` — RedirectToLoginAction


# RedirectToLoginAction

Riporta l'utente alla pagina di login FO con un messaggio di errore, mostrato sia come notifica Filament sia come errore sul campo `email`. Codice: `app/Actions/Socialite/RedirectToLoginAction.php`.

## Input

- `string $message`: chiave di traduzione relativa a `user::`.
- `array<string, string> $replace = []`: segnaposto `:chiave`.

## Output

- `RedirectResponse` verso `/{lang}/auth/login` con `withErrors(['email' => [testo]])`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REDIRECT-LOGIN-INV-1` | L'URL di login è localizzato nella lingua corrente. | `execute()`, `localizeURL` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:166` (chiamata) |
| `SOCIALITE-REDIRECT-LOGIN-INV-2` | Il testo ha i segnaposti 

### `contracts/regenerate-client-secret-action.md` — RegenerateClientSecretAction


# RegenerateClientSecretAction

Sostituisce il `secret` di un client OAuth2 con uno nuovo casuale e lo restituisce in chiaro. Codice: `app/Actions/Passport/RegenerateClientSecretAction.php`.

## Input

- `OauthClient|string $client`: istanza, oppure id da cercare con `findOrFail`.

## Output

- `string`: il nuovo secret di 40 caratteri, in chiaro. È l'unico punto in cui il valore è disponibile.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-REGEN-SECRET-INV-1` | Il secret precedente è sovrascritto: dopo il `save()` non è più valido. | `execute()`, assegnazione e `save()` | riferimento in `tests/Unit/Actions/Passport/PassportActionsCoverageBatch2Test.php:107` (verifica asserzioni non eseguita) |
| `PASSPORT-REGEN-SECRET-INV-2` | Un id inesistente pr

### `contracts/register-oauth-user-action.md` — RegisterOauthUserAction


# RegisterOauthUserAction

Crea in una sola transazione l'utente locale e il collegamento SSO per un'identità OAuth sconosciuta, poi dispatcha l'evento `Registered`. Codice: `app/Actions/Socialite/RegisterOauthUserAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`.

## Output

- `SocialiteUser`: il collegamento creato.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REGISTER-OAUTH-INV-1` | Utente e collegamento vengono creati nella stessa transazione: se uno fallisce, nessuno dei due resta. | `execute()`, `DatabaseManager::transaction` | `tests/Unit/Actions/RegisterOauthUserActionTest.php:29,50` (istanziazione e chiamata) |
| `SOCIALITE-REGISTER-OAUTH-INV-2` | `Registered` è dispatchato dopo la transazione, con il `Soc

### `contracts/register-socialite-user-action.md` — RegisterSocialiteUserAction


# RegisterSocialiteUserAction

Collega un utente locale già esistente a un'identità OAuth, assegna i ruoli di default se applicabili e dispatcha `SocialiteUserConnected`. Codice: `app/Actions/Socialite/RegisterSocialiteUserAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`, `UserContract $user` (già esistente).

## Output

- `SocialiteUser`: il collegamento creato.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REGISTER-SU-INV-1` | Crea sempre un nuovo `SocialiteUser` per l'utente fornito. | `execute()` | nessuno |
| `SOCIALITE-REGISTER-SU-INV-2` | Ruoli default: delegati a `SetDefaultRolesBySocialiteUserAction`, che non fa nulla se l'utente ha già ruoli. | `execute()` | nessuno |
| `SOCIALITE-REGISTER-SU-INV-3` | Dis

### `contracts/remember-login-return-url-action.md` — RememberLoginReturnUrlAction


# RememberLoginReturnUrlAction

Ricorda la pagina che ha mandato l'utente al login, così che `redirectIntended()` lo riporti indietro. Codice: `app/Actions/Auth/RememberLoginReturnUrlAction.php:22-79`.

## Input

- `Request $request`: query `redirect` e header `Referer` (`execute`, riga 26).

## Output

- `void`. Effetto: eventuale scrittura di `url.intended` in sessione.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `REMEMBER-RET-INV-1` | Sono accettati solo URL http/https sullo stesso host della richiesta; `//`, backslash, caratteri di controllo e altri schemi sono rifiutati. | righe 46-78 | `tests/Feature/Auth/AuthFlowRedirectsTest.php` (riferimento alla classe) |
| `REMEMBER-RET-INV-2` | Percorsi che contengono un segmento `auth` non sono mai memorizzat

### `contracts/resend-email-verification-action.md` — ResendEmailVerificationAction


# ResendEmailVerificationAction

Reinvia la mail di verifica dell'indirizzo, senza verificare nulla (DCP-285, D-04). Codice: `app/Actions/Auth/ResendEmailVerificationAction.php:16-33`.

## Input

- `MustVerifyEmail $user` (`execute`, riga 23).

## Output

- `bool`: `true` se la notifica è stata inviata, `false` se l'indirizzo era già verificato (righe 25-31).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `RESEND-VERIFY-INV-1` | Un indirizzo già verificato non riceve alcuna notifica. | righe 25-27 | Test: nessuno. |
| `RESEND-VERIFY-INV-2` | L'Action non emette l'evento `Verified`: lo emettono solo i controller che hanno validato id e hash. | docblock righe 13-14, nessun dispatch nel corpo | Test: nessuno. |


### `contracts/resolve-exclusions-configuration-action.md` — ResolveExclusionsConfigurationAction


# ResolveExclusionsConfigurationAction

Legge da `config/filament-shield.php` la configurazione delle esclusioni (generale, risorse, pagine, widget) e la normalizza. Codice: `app/Actions/Shield/ResolveExclusionsConfigurationAction.php`.

## Input

- Nessuno in `execute()`. I metodi pubblici `enableGeneralExclude()` e `disableGeneralExclude()` non hanno parametri.

## Output

- `execute()`: array con `general_exclude_enabled` (bool), `excluded_resources`, `excluded_pages`, `excluded_widgets` (`list<string>`).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-EXCL-INV-1` | Un valore non booleano di `exclude.enabled` diventa `true`. | `isGeneralExcludeEnabled()` | nessuno |
| `SHIELD-EXCL-INV-2` | Liste non-array diventano `[]`; gli elementi non stringa so

### `contracts/resolve-filament-user-configuration-action.md` — ResolveFilamentUserConfigurationAction


# ResolveFilamentUserConfigurationAction

Riassume la configurazione del ruolo "filament user" di Shield, leggendola da `FilamentShieldData`. Codice: `app/Actions/Shield/ResolveFilamentUserConfigurationAction.php`.

## Input

- Nessuno.

## Output

- `array{enabled: bool, name: string}`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-FILAMENT-USER-INV-1` | `enabled` è `false` se la proprietà manca o è null. | `execute()`, `?? false` | nessuno |
| `SHIELD-FILAMENT-USER-INV-2` | `name` vale `'Filament User'` se la proprietà manca. | `execute()`, `?? 'Filament User'` | nessuno |


### `contracts/resolve-notifiable-email-action.md` — ResolveNotifiableEmailAction


# ResolveNotifiableEmailAction

Risolve l'indirizzo a cui spedire le email di autenticazione (reset password, verifica email). Codice: `app/Actions/Auth/ResolveNotifiableEmailAction.php:18-40`.

## Input

- `Model $notifiable` (`execute`, riga 22).

## Output

- `?string`: l'indirizzo, oppure `null` se il modello non ne ha.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `RESOLVE-EMAIL-INV-1` | Se il modello espone `getEmailForPasswordReset()` il suo valore ha la precedenza sull'attributo `email`. | righe 24-29 | `tests/Unit/Actions/Auth/ResolveNotifiableEmailActionTest.php` (riferimento alla classe) |
| `RESOLVE-EMAIL-INV-2` | Un valore non stringa lancia un'eccezione (`Webmozart Assert`) e la mail non parte. | righe 26, 36 | come sopra |
| `RESOLVE-EMAIL-IN

### `contracts/resolve-permissions-configuration-action.md` — ResolvePermissionsConfigurationAction


# ResolvePermissionsConfigurationAction

Raccoglie in un array la configurazione di permessi ed entità di Filament Shield (prefissi, flag di entità, modelli Role/Permission) e fornisce due helper per i permessi delle singole risorse. Codice: `app/Actions/Shield/ResolvePermissionsConfigurationAction.php`.

## Input

- `execute()`: nessuno.
- `doesResourceHaveCustomPermissions(string $resourceClass)`, `getResourcePermissionPrefixes(string $resourceFQCN)`: FQCN di una risorsa Filament.

## Output

- `execute()`: array con 13 chiavi (prefissi `list<string>`, prefissi page/widget `string`, flag entità `bool`, `generator_option`, `role_policy_registered`, `role_model`, `permission_model`, `role_resource_exists`).
- `doesResourceHaveCustomPermissions()`: `bool`; `false` se la classe non esiste.


### `contracts/resolve-shield-authentication-configuration-action.md` — ResolveShieldAuthenticationConfigurationAction


# ResolveShieldAuthenticationConfigurationAction

Riassume guard e modello di autenticazione usati da Filament Shield. Codice: `app/Actions/Shield/ResolveShieldAuthenticationConfigurationAction.php`.

## Input

- Nessuno.

## Output

- `array{auth_guard: string, auth_provider_fqcn: string, auth_provider_configured: bool}`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-AUTH-CFG-INV-1` | `auth_guard` è sempre `'web'`. | `getFilamentAuthGuard()` | nessuno |
| `SHIELD-AUTH-CFG-INV-2` | `auth_provider_configured` è `true` solo se la classe esiste e usa direttamente il trait `HasRoles`. | `isAuthProviderConfigured()` | nessuno |
| `SHIELD-AUTH-CFG-INV-3` | Se `fqcn` non è stringa, vale `Illuminate\Foundation\Auth\User`. | `getAuthProviderFQCN()` | nessuno

### `contracts/resolve-shield-resource-configuration-action.md` — ResolveShieldResourceConfigurationAction


# ResolveShieldResourceConfigurationAction

Riassume la configurazione della risorsa Shield (slug, navigazione, ricerca globale) e verifica se la RoleResource è pubblicata. Codice: `app/Actions/Shield/ResolveShieldResourceConfigurationAction.php`.

## Input

- Nessuno.

## Output

- `array{slug: string, published: bool, navigation_registered: bool, navigation_sort: int, navigation_badge: bool, navigation_group: bool, globally_searchable: bool}`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-RES-CFG-INV-1` | `slug` vale `'shield'` se la configurazione non è stringa. | `execute()` | nessuno |
| `SHIELD-RES-CFG-INV-2` | `published` è vero se il file `app/Filament/Resources/Shield/RoleResource.php` esiste. | `isResourcePublished()` | nessuno |
| `SHIELD

### `contracts/resolve-super-admin-configuration-action.md` — ResolveSuperAdminConfigurationAction


# ResolveSuperAdminConfigurationAction

Riassume la configurazione del super admin di Filament Shield (abilitazione, nome, definizione via gate, stato di intercettazione del gate). Codice: `app/Actions/Shield/ResolveSuperAdminConfigurationAction.php`.

## Input

- Nessuno.

## Output

- `array{enabled: bool, name: string, defined_via_gate: bool, gate_interception_status: string}`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-SUPER-ADMIN-INV-1` | I valori mancanti valgono: `enabled` e `defined_via_gate` `false`, `name` `'Super Admin'`, `gate_interception_status` `'block'`. | `execute()`, operatori `??` | nessuno |

## Effetti collaterali

### `contracts/resolve-user-name-fields-from-socialite-action.md` — ResolveUserNameFieldsFromSocialiteAction


# ResolveUserNameFieldsFromSocialiteAction

Ricava nome e cognome da un'identità OAuth, con tre fonti in ordine: attributo `name`, campo `name` dei dati grezzi, parte locale dell'email. Codice: `app/Actions/Socialite/ResolveUserNameFieldsFromSocialiteAction.php`.

## Input

- `Laravel\Socialite\Contracts\User $oauthUser`.

## Output

- `SocialiteNameFieldsData`: `name`, `firstName` (uguale a `name`), `lastName`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-NAME-FIELDS-INV-1` | Il nome viene dall'attributo `name` se produce un risultato non vuoto. | `determineNameField()` | `tests/Unit/Actions/Socialite/ResolveUserNameFieldsFromSocialiteActionTest.php:24,32,40` |
| `SOCIALITE-NAME-FIELDS-INV-2` | Il campo grezzo `name` è scartato se sembra un'ema

### `contracts/retrieve-oauth-user-action.md` — RetrieveOauthUserAction


# RetrieveOauthUserAction

Completa lo scambio OAuth con il provider e restituisce l'utente. Su `InvalidStateException` dispatcha `InvalidState` e ritorna `null`. Codice: `app/Actions/Socialite/RetrieveOauthUserAction.php`.

## Input

- `string $provider`.

## Output

- `?SocialiteUserContract`: utente del provider, oppure `null` in caso di stato OAuth non valido.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-RETRIEVE-OAUTH-INV-1` | `InvalidStateException` produce evento `InvalidState` e `null`. | `execute()`, `handleInvalidStateException()` | `tests/Unit/Actions/Socialite/SocialiteCoreActionsCoverageTest.php:86,115` |
| `SOCIALITE-RETRIEVE-OAUTH-INV-2` | Ogni altra eccezione si propaga. | `execute()` | nessuno |


### `contracts/retrieve-socialite-user-action.md` — RetrieveSocialiteUserAction


# RetrieveSocialiteUserAction

Cerca il collegamento SSO per provider e id esterno e ne aggiorna il campo `token` con il token ricevuto dal provider. Codice: `app/Actions/Socialite/RetrieveSocialiteUserAction.php`.

## Input

- `string $provider` (non vuoto), `SocialiteUserContract $user`.

## Output

- `?SocialiteUser`: il collegamento con `user` caricato e `token` aggiornato, oppure `null` se non esiste.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-RETRIEVE-SU-INV-1` | Provider vuoto: `InvalidArgumentException`. | `execute()` | nessuno |
| `SOCIALITE-RETRIEVE-SU-INV-2` | ID non stringa né intero: `RuntimeException`. | `execute()` | nessuno |
| `SOCIALITE-RETRIEVE-SU-INV-3` | Senza token leggibile, il campo riceve `'no_token_'.time()`. | `execu

### `contracts/revoke-all-user-tokens-action.md` — RevokeAllUserTokensAction


# RevokeAllUserTokensAction

Revoca in blocco gli access token Passport ancora attivi di un utente. Codice: `app/Actions/Passport/RevokeAllUserTokensAction.php`.

## Input

- `UserContract|string $user`: istanza o id utente.

## Output

- `int`: numero di righe aggiornate (token che erano `revoked = false`).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-REVOKE-ALL-INV-1` | Sono toccati solo i token dell'utente con `revoked = false`. | `execute()`, doppio `where` | `tests/Feature/Actions/RevokeAllUserTokensActionTest.php:58,67`; `tests/Feature/Actions/Passport/RevokeAllUserTokensActionTest.php` |
| `PASSPORT-REVOKE-ALL-INV-2` | Il valore di ritorno è il numero di righe della UPDATE. | `execute()` | stesso file |


### `contracts/revoke-client-action.md` — RevokeClientAction


# RevokeClientAction

Marca un client OAuth2 come revocato e, se richiesto, revoca in blocco i suoi access token. Codice: `app/Actions/Passport/RevokeClientAction.php`.

## Input

- `OauthClient|string $client`: istanza o id.
- `bool $revokeTokens`: se `true` revoca anche i token del client.

## Output

- `bool`: `true` se il client è stato trovato e marcato; `false` se non esiste (nessuna eccezione).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-REVOKE-CLIENT-INV-1` | Con id inesistente ritorna `false` senza scritture. | `execute()`, controllo `instanceof` | `tests/Unit/Actions/Passport/PassportActionsCoverageBatch2Test.php:282` |
| `PASSPORT-REVOKE-CLIENT-INV-2` | Con `$revokeTokens = true` i token non revocati del client sono revocati prima del

### `contracts/revoke-refresh-token-action.md` — RevokeRefreshTokenAction


# RevokeRefreshTokenAction

Revoca un singolo refresh token Passport. Codice: `app/Actions/Passport/RevokeRefreshTokenAction.php`.

## Input

- `OauthRefreshToken|string $token`: istanza o id.

## Output

- `bool`: `true` se trovato e marcato; `false` se l'id non esiste.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-REVOKE-REFRESH-INV-1` | Il token trovato finisce con `revoked = true` tramite `save()`. | `execute()` | `tests/Unit/Actions/Passport/PassportActionsCoverageBatch2Test.php:163` |
| `PASSPORT-REVOKE-REFRESH-INV-2` | Id inesistente: `false`, nessuna scrittura. | `execute()`, controllo `instanceof` | nessuno |


### `contracts/revoke-token-action.md` — RevokeTokenAction


# RevokeTokenAction

Revoca un access token Passport e, se presente, il suo refresh token. Codice: `app/Actions/Passport/RevokeTokenAction.php`.

## Input

- `OauthToken|string $token`: istanza o id.

## Output

- `bool`: `true` se il token è stato trovato; `false` se l'id non esiste.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-REVOKE-TOKEN-INV-1` | L'access token è revocato tramite `OauthToken::revoke()`. | `execute()` | riferimento in `tests/Unit/Actions/AdditionalActionsTest.php:76-79` (solo istanziazione) |
| `PASSPORT-REVOKE-TOKEN-INV-2` | Se la relazione `refreshToken` esiste, anche il refresh token è revocato tramite `revoke()`. | `execute()`, ramo `if ($token->refreshToken)` | nessuno |
| `PASSPORT-REVOKE-TOKEN-INV-3` | Id inesistente: `

### `contracts/revoke-user-access-action.md` — RevokeUserAccessAction


# RevokeUserAccessAction

Sorgente: `app/Actions/Auth/RevokeUserAccessAction.php`. Chiamata da `Modules/Gdpr/app/Actions/Account/DeleteAccountAction.php`.
Perché: [ADR](../adr/deleted-account-blocked-in-user-provider.md).

## Input

- `BaseUser $user`: l'utente a cui togliere ogni accesso già concesso.

## Output

- `int`: numero di token di accesso Passport revocati (quelli ancora attivi prima della chiamata).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| USER-REVOKE-INV-1 | Revoca tutti i token di accesso non revocati dell'utente, e solo i suoi. | — |
| USER-REVOKE-INV-2 | Revoca i refresh token di **tutti** i token dell'utente, anche di quelli già revocati. | — |

### `contracts/send-otp-by-user-action.md` — SendOtpByUserAction


# SendOtpByUserAction

Sorgente: `app/Actions/Otp/SendOtpByUserAction.php`.

## Input

- `UserContract $user`: destinatario; dipendenze iniettate `PasswordData` (scadenza), `Str`, `Otp\Hasher`.
Genera una password temporanea (OTP), la salva come hash con scadenza e la invia all'utente via email. Codice: `app/Actions/Otp/SendOtpByUserAction.php:21-103`.

## Input

- `UserContract $user`: destinatario (`execute`, riga 36).
- Dipendenze: `PasswordData` (scadenza in minuti), `Str` (generatore casuale), `Otp\Hasher` (wrapper dello stesso namespace, righe 25-29).

## Output

- `void`.

## Invarianti

### `contracts/set-default-roles-by-socialite-user-action.md` — SetDefaultRolesBySocialiteUserAction


# SetDefaultRolesBySocialiteUserAction

Assegna ruoli iniziali a un utente SSO in base al dominio della sua email, se non ha già ruoli e il dominio è riconosciuto. Codice: `app/Actions/Socialite/SetDefaultRolesBySocialiteUserAction.php`.

## Input

- `string $provider`, `UserContract $userModel`, `SocialiteUserContract $oauthUser`.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-DEFAULT-ROLES-INV-1` | Se l'utente ha già almeno un ruolo, nessuna modifica. | `execute()`, `roles()->count()` | `tests/Feature/Actions/Socialite/SetDefaultRolesBySocialiteUserActionTest.php:33,45` |
| `SOCIALITE-DEFAULT-ROLES-INV-2` | Dominio non riconosciuto (né first party né client): nessun ruolo assegnato. | `execute()`, `hasUnrecognizedDomain()` 

### `contracts/shield-get-permission-model-action.md` — GetPermissionModelAction


# GetPermissionModelAction

Restituisce il FQCN del modello Permission da usare, letto da `config('permission.models.permission')` con default `Spatie\Permission\Models\Permission`. Codice: `app/Actions/Shield/GetPermissionModelAction.php`. Esiste anche una `GetPermissionModelAction` in `app/Actions/` radice: il nome è duplicato, questo contract copre solo la versione Shield.

## Input

- Nessuno.

## Output

- `string`: FQCN del modello Permission.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-PERM-MODEL-INV-1` | Il valore restituito è sempre una stringa. | `Assert::string()` | nessuno (0 riferimenti per nome classe nei test) |
| `SHIELD-PERM-MODEL-INV-2` | Se la chiave è assente, vale il default Spatie. | `config(..., Permission::class)` | nessuno

### `contracts/shield-utils-action.md` — ShieldUtilsAction


# ShieldUtilsAction

Contenitore legacy di una cinquantina di metodi statici che leggono la configurazione di Filament Shield. Il `execute()` d'istanza non fa nulla. Il docblock annuncia la suddivisione in Action granulari (quelle `Resolve*` del modulo). Codice: `app/Actions/Shield/ShieldUtilsAction.php`.

## Input

- Metodi statici con parametri solo per: `doesResourceHaveCustomPermissions(string)`, `getResourcePermissionPrefixes(string)`, `showModelPath(string)`.

## Output

- Valori scalari, array `list<string>` o `void` (gli `enable*`/`disable*`), secondo il metodo.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-UTILS-INV-1` | Gli accessi a configurazione usano `Assert::*`: un tipo errato solleva eccezione. | metodi `get*`/`is*` con `Assert` | `t

### `contracts/socialite-create-user-action.md` — CreateUserAction (Socialite)


# CreateUserAction (Socialite)

Crea un utente locale a partire dagli attributi dell'identità OAuth, gli assegna i ruoli di default e restituisce l'istanza aggiornata. Codice: `app/Actions/Socialite/CreateUserAction.php`. Il basename `CreateUserAction` esiste anche in `app/Actions/` e in `app/Actions/User/`: questo contract copre solo la versione Socialite.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`.

## Output

- `UserContract`: l'utente ricaricato con `refresh()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-CREATE-USER-INV-1` | `first_name` riceve il nome completo risolto, non il solo primo nome. | `execute()`, array di `create()` | nessuno sul valore |
| `SOCIALITE-CREATE-USER-INV-2` | Il modello creato deve essere `

### `contracts/store-intended-url-action.md` — StoreIntendedUrlAction


# StoreIntendedUrlAction

Ricorda la pagina a cui tornare dopo il login, per gli ospiti che non passano dal middleware `auth` (CMT-022). Codice: `app/Actions/Auth/StoreIntendedUrlAction.php:19-41`.

## Input

- `mixed $target`: atteso un percorso interno, per esempio `/it/blog/...` (`execute`, riga 23).

## Output

- `bool`: `true` se `url.intended` è stato scritto, `false` altrimenti (righe 25-31).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `STORE-INTENDED-INV-1` | Sono accettati solo stringhe che iniziano con un singolo `/`, senza `\` e senza spazi o caratteri di controllo. | righe 25, 34-40 | Test: nessuno. |
| `STORE-INTENDED-INV-2` | Un input rifiutato non tocca la sessione. | righe 25-27 | Test: nessuno. |
| `STORE-INTENDED-INV-3` | Il valore salva

### `contracts/teamcontract.md` — TeamContract


# TeamContract

L'interfaccia `TeamContract` definisce il contratto per i team nel sistema.

## Metodi

### Gestione Utenti

- `users(): BelongsToMany<Model&UserContract>` - Ottiene tutti gli utenti che appartengono al team
- `owner(): BelongsTo` - Ottiene il proprietario del team
- `hasUser(UserContract $user): bool` - Verifica se un utente appartiene al team
- `addUser(UserContract $user, ?string $role = null): void` - Aggiunge un utente al team
- `removeUser(UserContract $user): void` - Rimuove un utente dal team
- `allUsers(): Collection<int, Model&UserContract>` - Ottiene tutti gli utenti del team, incluso il proprietario
- `members(): Collection<int, Model&UserContract>` - Ottiene tutti i membri del team
- `hasUserWithEmail(string $email): bool` - Verifica se il team ha un utente co

### `contracts/template.md` — <operazione> — contratto comportamentale


# <operazione> — contratto comportamentale

Classe o superficie: `<FQCN>`  
Riferimento nel codice: `@contract docs/contracts/<file>.md`

## Input

- <input e validazione>

## Output

- <risultato osservabile>

## Invarianti

| ID | Regola | Verifica |
|---|---|---|
| `<MODULE>-INV-1` | <regola che deve restare vera> | <test o controllo ripetibile> |


### `contracts/update-user-action.md` — UpdateUserAction


# UpdateUserAction

Aggiorna un utente dentro una transazione: esclude i campi di sistema, gestisce password ed email, valida l'unicità dell'email e rilegge il modello. Codice: `app/Actions/User/UpdateUserAction.php:15-161`.

## Input

- `Model $user`: utente da aggiornare (`execute`, riga 28).
- `array<string, mixed> $data`: campi da aggiornare.

## Output

- `Model`: l'utente riletto con `fresh()` dopo il commit (righe 59-64).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UPDATE-USER-INV-1` | Non si aggiornano `id`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`. | righe 87-95 | `tests/Unit/Actions/User/UpdateUserActionTest.php`, `tests/Unit/Actions/AdditionalActionsTest.php` (riferimenti alla classe) |
| `UPDATE-USER-INV-2` | Una pass

### `contracts/upsert-user-from-digital-identity-action.md` — UpsertUserFromDigitalIdentityAction


# UpsertUserFromDigitalIdentityAction

Sorgente: `app/Actions/Auth/UpsertUserFromDigitalIdentityAction.php`. Perché: [ADR](../adr/digital-identity-upsert-by-fiscal-code.md).

## Input

- `$authMethod`: `spid` o `cie`.
- `$attributes`: chiavi usate `fiscal_code` (obbligatoria), `name`, `surname`, `email`; le altre si ignorano.
- `$emailVerified`: se l'IdP garantisce l'email.
- `$identityProvider` (facoltativo): nome dell'IdP; default = `$authMethod`.

## Output

- Il modello utente (`XotData::make()->getUserClass()`), salvato, `UserContract&Model`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|

### `contracts/user-create-user-action.md` — User/CreateUserAction


# User/CreateUserAction

Crea un utente dal form di registrazione, riempiendo il campo `name` quando manca (NOT NULL senza default). Codice: `app/Actions/User/CreateUserAction.php:10-36`.

Nota: esiste anche una `CreateUserAction` nella radice di `Actions/` con altro contratto. Questo file prende il prefisso `user-` per evitare la collisione di nome.

## Input

- `array<string, mixed> $data` (`execute`, riga 19). Chiavi lette per il fallback: `name`, `first_name`, `last_name`, `email`.

## Output

- `User` creato con `User::create` (righe 33-35).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `USER-CREATE-INV-1` | Se `name` manca o è vuoto: nome = `first_name last_name` (trim); se vuoto, la parte prima di `@` dell'email; se anche quella manca, l'email intera

### `contracts/validate-provider-action.md` — ValidateProviderAction


# ValidateProviderAction

Si assicura che il provider OAuth sia configurato, altrimenti lancia `ProviderNotConfigured`. Codice: `app/Actions/Socialite/ValidateProviderAction.php`.

## Input

- `string $provider`.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-VALIDATE-PROVIDER-INV-1` | Con variabili mancanti o segnaposto: `ProviderNotConfigured` con provider e elenco. | `execute()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:93` |
| `SOCIALITE-VALIDATE-PROVIDER-INV-2` | Provider configurato: nessuna eccezione. | `execute()` | `SocialiteUtilityActionsTest.php:88` |


### `contracts/verify-otp-hash-action.md` — VerifyOtpHashAction


# VerifyOtpHashAction

Verifica che un valore OTP in chiaro corrisponda all'hash salvato. Codice: `app/Actions/Otp/VerifyOtpHashAction.php:10-21`.

## Input

- `string $value`: valore inserito dall'utente.
- `string $hashedValue`: hash salvato (`execute`, riga 18).

## Output

- `bool`: esito di `check()` dell'hasher iniettato (riga 20).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `VERIFY-OTP-INV-1` | Il risultato è esattamente `check()` dell'hasher Illuminate. | riga 20 | `tests/Unit/Actions/Otp/OtpHashActionsTest.php` (riferimento alla classe) |


### `logout.md` — Logout


# Logout

Il logout e' una **azione POST protetta da CSRF**, non una pagina che "fa logout aprendola". Il motivo, emerso piu' volte in
fase di sviluppo: il PHP dentro una pagina Folio/Volt aperta via GET viene solo renderizzato, non eseguito come azione
Livewire, quindi la pagina mostrava "sei uscito" con l'utente ancora autenticato. Un logout deve inoltre cambiare stato solo
con un metodo non idempotente.

Vedi anche [authentication-login.md](authentication-login.md) (login e sessione).

## Percorso effettivo

| Elemento | Codice | Comportamento |
|---|---|---|
| Rotta | `routes/web.php` | `POST logout`, middleware `auth`, nome `logout` -> `Http\Volt\LogoutAction::__invoke` |
| Azione | `Http/Volt/LogoutAction.php` | `Auth::logout()`, `session()->invalidate()`, `session()->regenerateToke

### `manuals/manuale-utente.md` — Manuale d'uso per attori — User


> Screenshot reale della pagina di login, verificato il 25 novembre 2026 (emoji titolo login rimossa).

![Screenshot reale](assets/auth-login.png)

# Manuale d'uso per attori — User

## Scopo e perimetro

Il modulo User gestisce identità, autenticazione web, profilo, ruoli, permessi,
team, tenant associati e accesso ai pannelli Filament. Questo manuale descrive
solo capacità verificabili nel codice installato. Un ruolo, un permesso e
l'accesso a un pannello sono controlli distinti: avere un nome di ruolo seedato
non implica automaticamente la possibilità di eseguire ogni operazione.

## Attori e capacità effettive

| Attore | Capacità verificabili |
|---|---|
| Ospite | Può raggiungere login, registrazione, recupero password e verifica email, secondo configurazione e stato delle rotte. Pu

### `registration.md` — Registrazione, consensi e cancellazione account


# Registrazione, consensi e cancellazione account

La registrazione ha **due widget** nel modulo User piu' una versione con consensi nel modulo Gdpr. Per login e sessione vedi
[authentication-login.md](authentication-login.md).

## `Auth\RegisterWidget` (registrazione base)

`Modules\User\Filament\Widgets\Auth\RegisterWidget` e' il widget del front office. Visibile solo agli ospiti
(`canView()` = `! Auth::check()`). Lo schema sta in `Auth\Schemas\UserForm::getRegisterFormSchema()` (unica fonte):

| Campo | Regole |
|---|---|
| `first_name`, `last_name` | obbligatori, 2-255 caratteri |
| `email` | obbligatoria, email valida, max 255, `unique(User, email)` |
| `password` | `revealable`, minimo 12 caratteri con maiuscola, minuscola, cifra e simbolo; `confirmed`; hash applicato dal campo stes

### `stories/backlog.md` — Backlog delle story aperte del modulo User


# Backlog delle story aperte del modulo User

Una voce per story ancora aperta (backlog, ready-for-dev, bloccata, da decidere). Le story in corso restano file in questa cartella e in `../bmad/stories/`; le chiuse sono in [done-log.md](done-log.md). Quando una voce parte, crea il file `NNNN-<slug>.story.md` e rimuovi la voce da qui.

- **3.1.rbac-evaluator-role** — RBAC: Evaluator role (create/edit own Scheda) [backlog]
  As an evaluator, I want to create and edit Scheda evaluation records via a permission I hold (not ad-hoc admin access), so that I can complete evaluations for my PA without needing pa_admin privileges, and without being able to approve, delete, or manage users
- **3.2.rbac-staff-role** — RBAC: Staff role (read-only own Scheda) [backlog]
  As a staff member, I want to view

### `stories/done-log.md` — Registro delle story chiuse del modulo User


# Registro delle story chiuse del modulo User

Una voce per story chiusa (stato done, complete, resolved, superseded, in revisione o senza stato dichiarato), con esito in una o due righe. Le story ancora aperte stanno in [backlog.md](backlog.md) o restano file in questa cartella. Nuove story chiuse: aggiungere una voce qui invece di conservare il file.

- **01.user-phpstan-fix** — BMAD Story - User PHPStan Fix [stato non dichiarato]
- **01.35.profile-migration-deleted** — Cancellazione migrazione errata per profiles (User) [done, 2026-10-05]
  Esito: ✅ Cancellata — il profilo non necessita di questa migrazione errata.
- **2.1.profile-contract-migration** — Story 2.1: User/Profile Contract Migration — User Module [stato non dichiarato]
- **3.11.admin-manual-email-verification** — Admin: ve

### `teams-and-membership.md` — Team, membership e tenant


# Team, membership e tenant

## Modelli e tabelle

| Concetto | Modello | Tabella | Note |
|---|---|---|---|
| Team | `Team` (estende `BaseTeam`, implementa `TeamContract`) | `teams` | `owner_id`/`user_id` del proprietario; `purge()`, `allUsers()`, `userHasPermission()` |
| Membership | `Membership` (pivot, `BasePivot`) / `TeamUser` | `team_user` | `id` intero auto-increment, `role`, `permissions` (JSON), `joined_at`, `team_id`, `user_id` |
| Invito | `TeamInvitation` | `team_invitations` | colonna `user_id` aggiunta dalla migrazione `2026_11_10_000000` |
| Permessi di team | `TeamPermission` | `team_permissions` | |
| Tenant | `Tenant` (`BaseTenant`) | `tenants` + pivot `tenant_user` | isolamento multi-tenant, vedi sotto |
| Profilo-team | `ProfileTeam` | `profile_team` | |

Spatie Permi

### `user-vs-profile.md` — User e Profile


# User e Profile

## Decisione

Il modulo separa **identita' di accesso** e **dati personali**:

| | `User` (`BaseUser`) | `Profile` (`BaseProfile`) |
|---|---|---|
| Responsabilita' | autenticazione e autorizzazione | dati di profilo e preferenze |
| Contenuto tipico | `email`, `password`, `remember_token`, `email_verified_at`, `type`, `state`, `is_active`, `lang`, `deleted_at`, colonne 2FA, `current_team_id` | `first_name`, `last_name`, `phone`, `address`, `birth_date`, `gender`, `email`, `bio`, `avatar`, `timezone`, `locale`, `preferences`, `status`, `is_active`, `extra` |
| Mai | dati anagrafici pubblici | credenziali e token |
| Relazione | `BaseUserRelations::profile()` = `hasOne(XotData::make()->getProfileClass())` | `user_id` verso l'utente; `$with = ['user']` |
| Connessione | `u

### `wiki/bmad-method.md` — bmad-method


See canonical documentation: ../../../../Themes/docs/shared-components/bmad-method.md

### `wiki/topics/get-login.md` — Topic get-login


# Topic get-login

Sintesi automatica di 3 documenti (chiave `get-login`).

## GetLoginHistoryAction

_Fonte: `contracts/get-login-history-action.md`_

# GetLoginHistoryAction

Serie storica degli accessi, bucket per giorno o per mese, letta da `authentication_logs`. Codice: `app/Actions/Login/GetLoginHistoryAction.php:23-113`.

## Input

- `?CarbonImmutable $since`: inizio della serie; se nullo parte dal giorno del primo log (righe 46-55).
- `string $granularity`: `day` o `month` (riga 36).

## Output


### `wiki/topics/get-provider.md` — Topic get-provider


# Topic get-provider

Sintesi automatica di 4 documenti (chiave `get-provider`).

## GetProviderButtonsAction

_Fonte: `contracts/get-provider-buttons-action.md`_

# GetProviderButtonsAction

Dovrebbe restituire i pulsanti di login per i provider. Oggi restituisce sempre una lista vuota. Codice: `app/Actions/Socialite/GetProviderButtonsAction.php`.

## Input

- Nessuno.

## Output

- `array<int, never>`: sempre `[]`.

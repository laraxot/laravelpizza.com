---
title: "Autenticazione e login del modulo User"
type: guide
module: User
tags: [auth, login, session, throttle, password, email-verification]
qmd: "user login autenticazione LoginWidget throttle redirect intended reset password verifica email pulse authentication log"
---

# Autenticazione e login

Questa pagina descrive come un ospite diventa utente autenticato nel modulo User, leggendo il codice installato.
Per il logout vedi [logout.md](logout.md), per la registrazione [registration.md](registration.md),
per i provider esterni [socialite-sso.md](socialite-sso.md) e [passport-oauth.md](passport-oauth.md).

## Rotte

| Rotta | Dove | Note |
|---|---|---|
| `/{lang}/login`, `/register`, `/forgot-password`, `/reset-password/{token}` | `routes/auth.php` (Volt, middleware `guest`) | nomi `login`, `register`, `password.request`, `password.reset` |
| `/{lang}/verify-email`, `/verify-email/{id}/{hash}`, `/confirm-password` | `routes/auth.php` (middleware `auth`) | il link firmato usa `signed` + `throttle:6,1` |
| `POST /logout` | `routes/web.php` | middleware `auth`, nome `logout` |
| `GET email/verify/{id}/{hash}` | `routes/web.php` | `EmailVerificationController`, `auth` + `signed` + `throttle:6,1` |
| `GET /{lang}/auth/login/{provider}` | `routes/socialite.php` | solo `google`, `microsoft`, `github`; nome `oauth.redirect` |
| `POST /user/login` | `routes/api.php` | middleware `throttle:user-login`, nome `api.login` |
| `GET /v2/user`, `GET /v2/logout` | `routes/api.php` | guard `auth:api` (token Passport) |

Le pagine del front office sono scritte con Volt/Folio nel tema o in `resources/views/pages`; il login web passa dal widget,
non da un controller. Controller esistono solo per API (`Http/Controllers/Api`), verifica email e redirect ai provider
social (regola di piattaforma: niente rotte/controller custom per il front office).

## Il LoginWidget

`Modules\User\Filament\Widgets\Auth\LoginWidget` (`Filament\Widgets\LoginWidget` e' solo un alias che lo estende) e' un widget
sottile che orchestra il submit; il "vestito" grafico sta nel template del tema.

- **Schema**: arriva da `UserForm::getLoginFormSchema()` (unica fonte). Nel widget niente `->label()`, `->placeholder()`,
  `->helperText()`: le etichette le risolve `LangServiceProvider` dal file `user::login_widget` (regola dei campi
  con chiavi stringa, vedi [translations.md](translations.md)).
- **Submit**: `$this->form->getState()` (nessun `validateForm()`), poi `Auth::attemptWhen(...)`. Il template del tema usa
  `wire:submit.prevent="save"`, quindi `save()` e' un alias di `login()`.
- **Freno ai tentativi** (conta solo i tentativi errati, prima di `Auth::attempt`, quindi anche la password giusta e'
  rifiutata durante il blocco): 5 tentativi per `email|IP` e 20 per solo IP in 60 secondi. La chiave per IP e' un hash
  SHA-256, nella cache non resta l'indirizzo. Il successo azzera solo la chiave `email|IP`. L'errore e' su `data.email` con
  `user::login.actions.login.throttle` (secondi da attendere).
- **Account cancellati**: `attemptWhen` rifiuta gli utenti con `deleted_at` valorizzato (la cancellazione GDPR non usa
  `SoftDeletes`, vedi sotto).
- **Dopo il login**: `session()->regenerate()`, notifica di successo, `redirectIntended(GetPostLoginUrlAction)`.

### Dove si atterra dopo il login

1. `url.intended`, se c'e': lo salva il middleware `auth` oppure `LoginWidget::mount()` tramite `RememberLoginReturnUrlAction`
   (parametro `?redirect=` che vince, oppure `Referer` dello stesso host; le pagine di auth sono ignorate).
2. `StoreIntendedUrlAction` accetta solo percorsi interni: devono iniziare per `/`, non per `//`, senza `\` e solo ASCII
   stampabile. Senza questo controllo `?redirect=` sarebbe un open redirect.
3. Altrimenti `GetPostLoginUrlAction`: pagina localizzata letta da `auth.post_login_path` (config del tenant, default
   `/area-personale`). Non si usa `route('dashboard')`: nel front office `/{lang}/dashboard` puo' dare 404 perche' la Folio
   page del tema e' montata prima del modulo. Il locale e' esplicito perche' Livewire invia a `/livewire-*`, dove il middleware
   della lingua puo' non girare.

La vecchia soluzione "redirect in base al ruolo `<modulo>::admin`" (`getRedirectUrl()`) non e' piu' nel widget: l'ingresso ai
pannelli lo decidono ruoli e policy, vedi [permissions-and-roles.md](permissions-and-roles.md).

## Account cancellati e accessi gia' concessi

- `BuildActiveUserProviderAction` registra in `UserServiceProvider` un provider Eloquent che esclude gli utenti con `deleted_at`.
  Un solo punto copre login web/Filament/Volt, `POST /api/user/login`, reset password, sessioni aperte (a ogni richiesta),
  token Passport e cookie "ricordami". Il confine e' il contratto `UserContract`, non la classe base.
- `RevokeUserAccessAction` revoca token Passport, refresh token e cookie "ricordami" alla cancellazione dell'account, cosi'
  restano inutilizzabili anche se `deleted_at` fosse azzerato.

## Limiti ai moduli anonimi e alle API

- Registrazione e recupero password: `ConsumeAuthSubmissionSlotAction` con `AuthThrottleScope` (`Register`, `ForgotPassword`):
  10 invii per IP e 5 (registrazione) / 3 (recupero) per email in una finestra di 600 secondi. Ogni invio conta, valido o no, e il
  controllo precede validazione e scrittura.
- API: `BuildApiLoginLimitAction` registra il limiter `user-login` con le stesse soglie del widget (5 richieste/60 s per
  `email|IP`, stesso messaggio). Differenza voluta: l'API conta ogni richiesta, il widget solo gli errori. Un test blocca la
  coerenza delle due soglie.

## Password dimenticata e verifica email

- Il link di reset usa la radice di `config('app.url')`, mai l'header `Host` (`BuildPasswordResetUrlAction`, difesa dal
  reset-poisoning). La mail passa da `SpatieEmail` con template `reset-password`, garantito in tutte le lingue da
  `EnsureResetPasswordMailTemplateAction` senza sovrascrivere i testi personalizzati.
- `ResendEmailVerificationAction` reinvia la mail di verifica senza verificare nulla (l'evento `Verified` lo lanciano solo i
  controller che controllano id e hash).
- `EnsureVerifiedIdentity` e `HasVerifiedIdentityAction`: come `verified`, ma accettano anche accessi SPID/CIE senza email.
- Scadenza password: trait `HasPasswordExpiry`, `PasswordExpiryMiddleware`, `PasswordExpiredWidget` e pagina `PasswordExpired`
  (trait del modulo condiviso: puo' non essere usato dal progetto che lo ospita).
- Email di sistema: i `toMailUsing` di `ResetPassword` e `VerifyEmail` sono in `UserServiceProvider::registerMailsNotification()`;
  il destinatario si risolve con `GetNotifiableEmailAction`.

## Registro accessi e Pulse

- `RecordAuthenticationLogAction` scrive una riga in `authentication_log` sulla connessione `user`; se la tabella manca salta
  senza errori (un audit non deve trasformare un login in un 500). Modello `AuthenticationLog`, risorsa `AuthenticationLogResource`.
- `RecordLoginPulseAction`, `GetLoginHistoryAction`, `GetLoginStatsAction` alimentano le card Pulse (`Widgets/Pulse`); il comando
  `user:pulse-backfill-logins` ricostruisce lo storico. L'accesso a Pulse e' consentito solo al `super-admin`.

## Middleware disponibili

`EnsureRegistrationEnabled` (config `auth.registration_enabled`, default `true`), `EnsureUserHasRole`, `EnsureUserHasType`,
`EnsureVerifiedIdentity`, `PasswordExpiryMiddleware`.

## Errori ricorrenti (e causa)

| Sintomo | Causa | Rimedio |
|---|---|---|
| Campi email/password "non popolati" nel widget | il form non e' inizializzato in `mount()` con `statePath('data')` | chiamare il metodo di inizializzazione di `XotBaseWidget` in `mount()` |
| `Route [filament.admin.pages.dashboard] not defined` dopo il login | `redirect()->intended()` verso una rotta inesistente | usare `GetPostLoginUrlAction` |
| Chiavi di traduzione mostrate in chiaro nel widget | file lingua mancanti o con struttura diversa | allineare `lang/<locale>/login_widget.php` e `login.php` |
| Dopo il login si finisce sul login | pagina di auth salvata come `url.intended` | `RememberLoginReturnUrlAction` ignora le pagine di auth |

## Verifica

- Test: `tests/Feature/UserAuthenticationTest.php`, `tests/Feature/AuthComponentsTest.php`, `tests/Feature/LoginPageTranslationsTest.php`,
  `tests/Feature/LoginTranslationParityTest.php`, `tests/Feature/Authentication/`, `tests/Feature/FoAuthPagesVerificationTest.php`.

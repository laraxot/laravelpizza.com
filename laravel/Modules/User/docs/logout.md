---
title: "Logout del modulo User"
type: guide
module: User
tags: [auth, logout, session, volt, livewire, filament]
qmd: "user logout POST LogoutAction sessione invalidate widget conferma Volt Folio pagina logout"
---

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
| Azione | `Http/Volt/LogoutAction.php` | `Auth::logout()`, `session()->invalidate()`, `session()->regenerateToken()`, redirect a `/{locale}` |
| Locale del redirect | `LogoutAction::localeFromReferer()` | `POST /logout` non ha prefisso lingua: la lingua si legge dal primo segmento del `Referer`, accettata solo se supportata (un Referer inventato non decide la destinazione); senza Referer si usa la lingua dell'app |
| Evento | `Illuminate\Auth\Events\Logout` | gestito da `Listeners\LogoutListener`; `OtherDeviceLogout` da `OtherDeviceLogoutListener` (registrati in `EventServiceProvider`) |
| API | `GET /v2/logout` (`auth:api`) | `Http\Controllers\Api\LogoutController` -> `Actions\Socialite\LogoutUserAction`: revoca (non cancella) access token e refresh token; risposta JSON con il solo `user_id` |

La home del front office e' `/{locale}`: non esiste una rotta chiamata `home`. Per questo `Http\Controllers\Auth\LogoutController`
(che reindirizza a `route('home')`) non e' instradato da nessuna rotta e non va usato come modello.

## Widget di conferma (pannelli Filament)

`Filament\Widgets\Auth\LogoutWidget` (estende `XotBaseSchemaWidget`, vista `user::filament.widgets.auth.logout`) mostra il
messaggio e due azioni: **Logout** (danger) e **Annulla** (torna a `/{locale}`). La sequenza di `logout()`:

1. `Event::dispatch('auth.logout.attempting', [$user])`
2. `Auth::logout()`, `Session::invalidate()`, `Session::regenerateToken()`
3. `Event::dispatch('auth.logout.successful')`
4. `Log::debug('User logged out', ...)` con id utente e timestamp
5. redirect localizzato con messaggio `user::auth.logout_success`

Senza utente autenticato registra un warning e non fa nulla. Esistono anche `Filament\Widgets\LogoutWidget` (variante per
pannelli admin, stessa sequenza) e `AuthLogoutWidget`.

## Regole che hanno evitato errori

- **Namespace delle viste**: i widget del modulo usano `user::...` (es. `user::filament.widgets.auth.logout`); `pub_theme::`
  e' solo per gli override del tema. Il tema puo' fornire la propria vista con lo stesso percorso.
- **Niente `->label()`** nei componenti Filament dei widget: traduzioni automatiche da `user::auth` e `user::login_widget`
  (vedi [translations.md](translations.md)).
- **`form()` appartiene alla base Xot** (`XotBaseWidget`/`XotBaseSchemaWidget` lo costruiscono da `formClass()`): si personalizza
  `getFormSchema()` o lo schema, non si riscrive `form()`.
- **Localizzazione**: link e redirect passano da `LaravelLocalization`; mai URL costruiti a mano con il prefisso lingua.
- **Rotte**: il front office non aggiunge controller o rotte custom in `web.php` per questo scopo; l'unica rotta di logout e'
  quella POST del modulo.

## Verifica

- Il form di logout del tema deve inviare `POST` con `@csrf` a `route('logout')`.
- Test collegati: `tests/Feature/Authentication/ApiLogoutControllerTest.php`, `tests/Unit/Listeners/LogoutListenerBehaviorTest.php`, `tests/Unit/Events/`.

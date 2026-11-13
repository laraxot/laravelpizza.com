---
title: "Account cancellati senza accesso e verifica email reale"
type: story
bmad: true
status: review
created: 2026-11-10
owner: module:User
module: User
related: [SEC-05, SEC-14, PRD-02, DEC-11, dcp-285]
tags: [security, gdpr, auth, passport, email-verification]
---

# Account cancellati senza accesso e verifica email reale

## Problema

- **SEC-05** (`Modules/Fixcity/docs/audit/SECURITY_AUDIT.md`). "Elimina il mio account" (`Modules/Gdpr/app/Actions/Account/DeleteAccountAction.php`) imposta solo `deleted_at`. `BaseUser` non usa `SoftDeletes` e non ha scope globali, quindi l'account restava utilizzabile:
  - con `POST /api/user/login` (`Auth::attempt` + token Passport);
  - con i token Passport gia' emessi (`auth:api`);
  - con le sessioni aperte su altri dispositivi e con il cookie "ricordami";
  - dai login che non avevano il controllo su `deleted_at` (Volt `LoginComponent`, pagina legacy, pannelli Filament).
  Il controllo c'era solo in `LoginWidget` e nel login Socialite.
- **PRD-02 / SEC-14** (`PRODUCT_UX_AUDIT.md`). `ValidateUserDataAction` metteva `email_verified_at = now()` alla registrazione. Nessuna mail di verifica partiva, e la rotta `verification.verify` non esisteva: `routes/auth.php` e `routes/web_tall.php` non vengono caricati. Chiunque poteva segnalare (e ricevere mail di ricevuta) con un indirizzo mai confermato.

Guard reali (`config/local/fixcity/auth.php`): `web` (sessione) e `api` (Passport), entrambe sul provider `users` con driver `eloquent`. Sanctum non e' usato.

## Modifiche

| File | Modifica |
|---|---|
| `Modules/User/app/Actions/Auth/BuildActiveUserProviderAction.php` (nuovo) | `EloquentUserProvider` con `withQuery`: per i modelli `BaseUser` aggiunge `whereNull(deleted_at)` quando la colonna è presente. Copre `retrieveByCredentials` (tutti i login, reset password), `retrieveById` (sessioni e token Passport) e `retrieveByToken` ("ricordami"). Il controllo di schema evita un 500 su installazioni legacy mentre la migrazione canonica completa `users`. |
| `Modules/User/app/Providers/UserServiceProvider.php` | `registerActiveUserProvider()`: `Auth::provider('eloquent', ...)` sostituisce il driver del framework, per ogni tenant e anche per la guard `api`, senza toccare i `config/<tenant>/auth.php`. |
| `Modules/User/app/Actions/Auth/RevokeUserAccessAction.php` (nuovo) | Revoca i token Passport dell'utente e i loro refresh token e azzera `remember_token`. Restituisce quanti token ha revocato. |
| `Modules/Gdpr/app/Actions/Account/DeleteAccountAction.php` | Chiama `RevokeUserAccessAction` nella stessa transazione, subito dopo `deleted_at`. |
| `Modules/User/app/Models/BaseUser.php` | `findForPassport()` esclude `deleted_at`: niente token neanche con il password grant. |
| `Modules/User/app/Http/Controllers/Api/LoginController.php` | Credenziali errate o account cancellato: 401 invece del 404 di `sendError`. |
| `Modules/Gdpr/app/Actions/Validation/ValidateUserDataAction.php` | `email_verified_at` resta `null` alla registrazione. |
| `Modules/Gdpr/app/Actions/Registration/HandleSuccessfulRegistrationAction.php` | Dopo il login invia la mail di verifica (`ResendEmailVerificationAction`). Un errore del server di posta viene segnalato con `report()` e non annulla la registrazione. |
| `Modules/Gdpr/lang/{it,en,de,es}/register.php` | `success_message` dice di aprire il link nella mail prima di segnalare. |
| `Modules/User/routes/web.php` | Rotta `verification.verify`: `GET email/verify/{id}/{hash}` con `auth`, `signed`, `throttle:6,1`. Senza prefisso `{lang}`. |
| `Modules/User/app/Http/Controllers/Auth/EmailVerificationController.php` | Legge `id` e `hash` per nome dalla rotta (il dispatcher passa i parametri scalari per posizione). Controlla utente, id e hash, poi `markEmailAsVerified()` ed evento `Verified` una sola volta. Rimanda a `intended`, altrimenti alla home. |
| `Modules/Fixcity/resources/views/pages/tickets/create.blade.php` | `middleware('verified')`: senza email verificata il wizard rimanda a `verification.notice` (Folio `Modules/User/resources/views/pages/auth/verify.blade.php`, `/{lang}/auth/verify`, con il pulsante "invia di nuovo"). Dopo il link si torna al wizard. |
| `Modules/Gdpr/tests/...` (4 file) | Le asserzioni "email verificata alla registrazione" diventano "email non verificata". |
| `Modules/User/tests/Feature/Auth/DeletedAccountAccessTest.php` (nuovo) | Test SEC-05. |
| `Modules/User/tests/Feature/Auth/EmailVerificationFlowTest.php` (nuovo) | Test PRD-02. |

Utenti esistenti: nessuna migrazione. Chi ha gia' `email_verified_at` resta verificato.

La compatibilità legacy non sostituisce la migrazione: `2026_11_12_120000_create_users_table.php` deve essere eseguita per aggiungere `deleted_at` e ripristinare il blocco degli account cancellati. Finché manca, il database non può rappresentare un account cancellato e il provider considera attivi gli utenti della tabella legacy.

Flusso del cittadino: registrazione → login automatico e mail con link → "Segnala" → se non verificato, pagina di verifica con reinvio → link → di nuovo al wizard.

## Test

- `DeletedAccountAccessTest`:
  - il provider `users` ha il filtro;
  - un account con `deleted_at` non si trova per id, credenziali o remember token;
  - il login web fallisce con la password giusta, mentre un account attivo entra;
  - `POST /api/user/login` risponde 401 e non crea token;
  - `findForPassport` restituisce null;
  - `RevokeUserAccessAction` revoca access e refresh token solo dell'utente e azzera il remember token.
- `EmailVerificationFlowTest`:
  - la rotta esiste con `auth` e `signed`;
  - la notifica `VerifyEmail` costruisce il link firmato;
  - un link valido verifica l'indirizzo e lancia `Verified` una volta;
  - hash errato, utente diverso e link non firmato danno 403;
  - il middleware `verified` rimanda l'utente non verificato e lascia passare quello verificato.

Non eseguiti in questo ambiente (niente `vendor/`, PHP 8.3). Su tutti i file toccati `php -l` non ha trovato errori.

## Verifica

```bash
cd laravel
vendor/bin/pest Modules/User/tests/Feature/Auth/DeletedAccountAccessTest.php Modules/User/tests/Feature/Auth/EmailVerificationFlowTest.php
vendor/bin/pest Modules/Gdpr/tests Modules/Fixcity/tests/Feature/Privacy Modules/Fixcity/tests/Feature/Api/UserApiLoginThrottleTest.php Modules/Cms/tests/Feature/Auth/EmailVerificationTest.pest.php
./vendor/bin/phpstan analyse Modules/User Modules/Gdpr
php artisan route:list --name=verification
```

Verifica manuale:

1. Registrarsi e controllare che arrivi la mail con il link.
2. Aprire `/it/tickets/create` prima del link: si deve finire su `/it/auth/verify`.
3. Aprire il link e controllare di tornare al wizard.
4. Eliminare l'account e chiamare `POST /api/user/login`: deve rispondere 401. Un vecchio bearer token su `/api/v2/user` deve rispondere 401.

## Aperto

- **Fixcity, difesa in profondita'.** Fatto dopo la chiusura della story dell'altro agente: `CreateTicketWizardWidget::save()` rimanda a `verification.notice` se l'email non è verificata (le richieste Livewire non ripassano dal middleware della pagina Folio). Le factory creano utenti verificati, i test esistenti del wizard non cambiano.
- **DEC-11** (`Modules/Fixcity/docs/stories/dcp-200-registro-unico-delle-decisioni-aperte.story.md`): il registro raccomandava "obbligatoria per ricevere notifiche, non per segnalare". Questa story applica la scelta della richiesta: obbligatoria per segnalare. Il registro va aggiornato da chi ne e' owner.
- **Login con Google/Microsoft**: gli utenti creati da Socialite hanno `email_verified_at` null, quindi devono confermare l'indirizzo anche loro. Si puo' segnare verificata l'email quando il provider lo garantisce (`email_verified` nei claim), insieme a SEC-07.
- **`is_active = false`**: nessun login lo controlla. L'ho lasciato fuori di proposito, perche' non so se ci sono dati con `false` o null che bloccherebbero utenti legittimi. Da decidere.
- **Sessioni nel database**: non le cancello. Cadono alla richiesta successiva, perche' il provider non trova piu' l'utente.
- **La pagina `auth/verify.blade.php` del modulo User** ha uno stile Tailwind generico e non usa il design Bootstrap Italia del tema. Va bene per ora; da allineare in una story UX.
- **Log di activity**: `DeleteAccountAction` fa ancora il soft-delete dei log dell'utente, che riduce l'audit (SEC-05, ultimo punto). Non l'ho toccato: serve una decisione sulla conservazione.
- **Test non coerente**: `Modules/Gdpr/tests/Feature/RegistrationTest.php` si aspetta `state = active` dal risultato di `ValidateUserDataAction`, ma l'action non lo restituisce. Il problema c'era gia' prima di questa story.

## Revisione indipendente del 2026-11-10

- **SPID/CIE (H1).** Il middleware `verified` avrebbe bloccato per sempre gli utenti SPID/CIE senza email (salvati come
  `spid.<CF>@noemail.local`, non verificati). Nuovi `HasVerifiedIdentityAction` e middleware `EnsureVerifiedIdentity`:
  email confermata **oppure** `auth_method` `spid`/`cie`. Usati dalla pagina `tickets/create` e da
  `CreateTicketWizardWidget::save()`. L'email resta non verificata: nessuna mail parte verso `@noemail.local`.
- **Colonna mancante.** `users.auth_method` non esiste in nessuna migrazione: i controller SPID/CIE del tema la scrivono nel
  vuoto. Va aggiunta prima di attivare SPID/CIE (`SIXTEEN_SPID_ENABLED`), altrimenti quegli utenti restano bloccati.
- **Guard gia' risolte (M5).** Il provider che esclude gli account cancellati si registra in `register()` con
  `afterResolving('auth')` e `forgetGuards()`: una guard risolta da un altro modulo durante il boot non tiene piu' il
  provider di serie.

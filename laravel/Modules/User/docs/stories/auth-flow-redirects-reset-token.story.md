---
title: "Flusso di accesso FO: redirect dopo login, reset password, ritorno alla pagina"
type: story
status: review
priority: P1
module: User
created: 2026-10-26
updated: 2026-10-26
related: ["register-logout-verify-email.story.md", "user-hash-password-solo-nelle-actions.story.md", "3.11.admin-manual-email-verification.story.md"]
tags: [bmad, auth, login, password-reset, redirect, folio]
qmd: "login redirect dashboard 404 area-personale reset password token folio double hash url.intended referer redirect email verification"
---

# Flusso di accesso FO: redirect dopo login, reset password, ritorno alla pagina

Fase BMAD: Quick Flow (verifica dei finding, test prima, fix, verifica).

## Problema (verificato con test HTTP sul DB scratch)

1. Login (`LoginWidget`) e registrazione (`Gdpr/HandleSuccessfulRegistrationAction`) mandavano a `route('dashboard')`.
   `GET /it/dashboard` da loggato risponde **404**: la pagina Folio `[container0]` del tema e' montata prima del modulo User.
   `GET /it/area-personale` risponde 302 verso `/it/area-personale/pratiche` (loggato) o `/it/auth/login` (ospite).
2. Reset password, peggio di quanto riportato dall'audit:
   - la pagina citata (`Themes/Sixteen/.../pages/[container0]/[slug0]/[container1]/[token].blade.php`) **non viene mai
     raggiunta**: la cartella letterale `pages/auth` del tema cattura `/it/auth/...` e Folio non torna su `[container0]`.
     `GET /it/auth/password/reset/{token}` risponde 404.
   - il link della mail (`route('password.reset')` = `/it/auth/password/{token}`) apre
     `Modules/User/resources/views/pages/auth/password/[token].blade.php`, una pagina Volt Genesis senza `$token`,
     `$email`, `$password`: il form non funzionava e `ResetPasswordWidget` non era montato.
   - `ResetPasswordWidget::mount()` leggeva `request()->route('token')`, null sotto Folio.
   - doppio hash: lo schema `getResetPasswordFormSchema()` hashava la password (`dehydrateStateUsing(Hash::make)`) e il
     callback di `Password::reset()` la hashava di nuovo. Il mutator `BaseUser::setPasswordAttribute` salva com'e' un valore
     di 60 caratteri, quindi nel DB finiva `Hash(Hash(chiaro))`: dopo il reset il login era impossibile. Stesso difetto in
     `getPasswordResetConfirmFormSchema()` + `PasswordResetConfirmWidget`.
3. I link "Accedi" su ticket, blog ed eventi sono link semplici a `/it/auth/login`: nessun `url.intended`, quindi dopo il
   login si finiva sulla pagina di default.
4. Verifica email: `ValidateUserDataAction` imposta `email_verified_at => now()`; `verification.verify` non e' registrata
   (`routes/web_tall.php` non e' caricato). **Rinviato**, vedi "Decisione aperta".

## Acceptance criteria

- [x] Login e registrazione senza URL intended vanno a `/{lang}/area-personale` (`GetPostLoginUrlAction`).
- [x] Con `url.intended` in sessione il login torna a quella pagina.
- [x] `GET /it/auth/password/{token}` monta `ResetPasswordWidget` con il token nello stato del form.
- [x] Dopo il reset `Hash::check(nuova, password salvata)` e' vero (un solo hash).
- [x] Il login ricorda `?redirect=` o il Referer dello stesso host (`RememberLoginReturnUrlAction`, da `LoginWidget::mount()`).
- [x] Rifiutati: altro host, `//host`, backslash, `javascript:`, pagine `/auth/`, stringa vuota. Il Referer non sostituisce
      un `url.intended` gia' salvato dal middleware `auth`; `?redirect=` esplicito si'.

## File

- `app/Actions/Auth/GetPostLoginUrlAction.php` (nuovo): URL localizzato `/area-personale`.
- `app/Actions/Auth/RememberLoginReturnUrlAction.php` (nuovo): salva `url.intended` da `?redirect=` o Referer, solo stesso host.
- `app/Filament/Widgets/Auth/LoginWidget.php`: `mount()` chiama l'Action; redirect di default via `GetPostLoginUrlAction`.
- `Modules/Gdpr/app/Actions/Registration/HandleSuccessfulRegistrationAction.php`: default via `GetPostLoginUrlAction`.
- `app/Filament/Widgets/Auth/ResetPasswordWidget.php`: `mount(?string $token = null)`.
- `app/Filament/Widgets/Auth/Schemas/UserForm.php`: tolto `dehydrateStateUsing(Hash::make)` dai due schemi di reset.
- `resources/views/pages/auth/password/[token].blade.php`: pagina di solo trasporto (layout del tema) che monta
  `ResetPasswordWidget` con `['token' => $token]`.
- `tests/Feature/Auth/AuthFlowRedirectsTest.php` (nuovo, 22 test).

## Note per chi possiede altri file

- Effetto del Referer: anche il bottone dell'header "Accedi all'area personale" (`personal-area-login-cta`,
  `personal-area-guest-cta`, link a `route('login')`) ora riporta alla pagina di partenza. Per mandarlo sempre all'area
  personale basta `route('login', ['redirect' => '/'.app()->getLocale().'/area-personale'])`.
- I link "Accedi" su ticket, blog ed eventi possono anche passare `?redirect=` in modo esplicito
  (`route('login', ['redirect' => url()->current()])`), cosi' non dipendono dal Referer.
- Codice morto (fuori dal mio scope): `Themes/Sixteen/.../[container0]/[slug0]/[container1]/[token].blade.php`, il ramo
  `auth-password-reset` di `[container1]/index.blade.php`, `components/pages/auth-password-token.blade.php`. Anche
  `/it/auth/password/reset` (form "password dimenticata") e' servito dalla pagina Genesis del modulo User, non dal tema.
- `route('dashboard')` resta usato altrove (pagina Genesis `pages/dashboard/index.blade.php`).

## Decisione aperta: verifica email (punto 4)

Non e' un fix piccolo, serve una decisione di prodotto:
- la registrazione Gdpr non lancia `Registered`, quindi togliendo `email_verified_at => now()` nessuna mail partirebbe;
- `verification.verify` manca e `/it/auth/verify` (`verification.notice`) e' la pagina Genesis del modulo;
- le pagine con middleware `verified` (dashboard, profile/edit, learn, pages/[slug]) bloccherebbero i nuovi cittadini;
- la consegna verso caselle esterne richiede un relay SMTP (story `register-logout-verify-email`).

Domande: la verifica blocca l'accesso (segnalazioni comprese) o e' solo informativa? Quali pagine richiedono `verified`?
Fino alla decisione il codice resta com'e'.

## Verifica

```
PEST_OUT=.../final.txt bash bashscripts/tools/pest-scratch-db.sh --test-directory=Modules/User/tests \
  Modules/User/tests/Feature/Auth/AuthFlowRedirectsTest.php \
  Modules/User/tests/Feature/Filament/Widgets/Auth/LoginWidgetStateTest.php \
  Modules/User/tests/Unit/Filament/Widgets/AuthLoginFeedbackTest.php \
  Modules/User/tests/Unit/Filament/Widgets/Auth/AuthWidgetsResolveConventionalViewTest.php
  Tests:    35 passed (91 assertions)
```

Prima del fix (RED): `Tests: 18 failed, 2 passed` (classi mancanti, redirect a `/it`, widget non montato, token vuoto).

`./vendor/bin/phpstan analyse` sui 7 file PHP toccati: `[OK] No errors`. `./vendor/bin/pint --format agent`: passed.

## Follow-up: cittadino gia' loggato su auth e cancellazione account (audit browser)

Fase BMAD: Quick Flow (verifica, test RED, fix, verifica).

### Finding verificati

1. `/it/account/delete` rispondeva 403 al proprietario. **La causa non erano i tipi** di `UserPolicy::delete`
   (`Post` era solo un alias di `UserContract`): la classe utente configurata, `Modules\Fixcity\Models\User`, non ha
   nessuna policy che il Gate sappia indovinare (`Gate::getPolicyFor()` restituisce `null`), quindi
   `Gate::authorize('delete', $user)` negava sempre. Con il modello base `Modules\User\Models\User` il test passava:
   per riprodurre serve la classe di `XotData::getUserClass()`. In piu' `UserPolicy::delete` rispondeva `true` per
   chiunque verso chiunque.
2. `/it/auth/login` da loggato mostrava il form (200). Pagina servita dal tema: `Themes/Sixteen/.../pages/auth/login.blade.php`.
3. `/{lang}/auth/register` da loggato: 403 nudo, perche' `RegisterWidget::canView()` e' `! Auth::check()`. Pagina del tema.

### Fix

- `UserPolicy::delete(UserContract $user, UserContract $model)`: solo il proprio account (`id` non null e uguale);
  il super-admin passa da `before()`. Alias `Post` tolto dal file.
- `DeleteAccountAction`: `Gate::allowIf(app(UserPolicy::class)->delete($user, $user))` al posto di `Gate::authorize`.
- Pagine tema `auth/login` e `auth/register`: `render()` Folio (come `auth/logout`) che manda il loggato a
  `GetPostLoginUrlAction`. Non `guest`: il suo default e' `route('dashboard')`, che in FO risponde 404.

### Fuori scope, da assegnare

- **POST** `/it/account/delete` va in 500: `RevokeGdprConsentsAction` filtra `consents.subject_type`, colonna che lo
  schema non ha (`Unknown column 'subject_type'`). La cancellazione account resta quindi rotta dopo la conferma.
- Registrare una policy per `Modules\Fixcity\Models\User` (provider Fixcity) renderebbe di nuovo usabile
  `Gate::authorize('delete', $user)`, ma cambierebbe anche l'autorizzazione Filament sugli utenti (story 11.1).
- `UserPolicy::delete` ora nega il ruolo `admin` (non super-admin) sul modello base: prima era `true` per tutti.

### Verifica

```
PEST_OUT=.../final.txt bash bashscripts/tools/pest-scratch-db.sh --test-directory=Modules/User/tests \
  Modules/User/tests/Feature/Auth/SignedInUserAuthPagesTest.php Modules/User/tests/Feature/Auth/AuthFlowRedirectsTest.php
  Tests:    31 passed (54 assertions)
```

RED prima del fix: 403 su account delete (classe configurata), 200 su login, 403 su register it/de/es, policy `true` verso altri.
PHPStan sui 3 file PHP: `[OK] No errors`. Pint: passed.

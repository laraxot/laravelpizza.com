---
id: dcp-290
title: "DCP-290: pagine di accesso e reset password a tema, in 4 lingue e accessibili"
type: story
epic: dc-parity-v2
status: in-progress
priority: P1
owner: module:User + theme:Sixteen
module: User
created: 2026-10-26
updated: 2026-10-26
qmd: "password dimenticata reset password token a tema Sixteen aria-invalid aria-describedby riepilogo errori focus primo campo non valido autofocus google-button non configurato validationAttributes registrazione login FO-5-02 FO-3-01 FO-5-10 FO-5-11 FO-5-26 FO-5-30"
related: [dcp-285, dcp-271, dcp-269, dcp-124, dcp-200, fo-3-wizard-e-autenticazione, fo-5-a11y-responsive]
tags: [auth, accessibilita, i18n, tema, password-reset, google, a11y]
---

# DCP-290: pagine di accesso e reset password

Nata dagli audit FO-3 (FO-3-01) e FO-5 (FO-5-02, FO-5-10, FO-5-11, FO-5-26, FO-5-30, FO-5-25 in parte). Ogni affermazione dell'audit e' stata riverificata sull'istanza di prova `http://127.0.0.1:8091` (DB usa-e-getta) prima di toccare. Etichette: **MISURATO** (eseguito da me, con l'output), **DEDOTTO** (letto nel codice, non eseguito).

## Fase BMAD

Build (dev-story). Analisi: audit FO-3/FO-5 + riverifica qui sotto. Poi test rossi, codice, test verdi, misura nel browser (3 larghezze, 4 lingue, axe prima e dopo). Il lavoro di DCP-285 (template mail del reset in 4 lingue, `verify.blade.php`) non e' toccato. Il ritorno dopo il login (`StoreIntendedUrlAction`, `LoginWidget::mount`) e' della sessione f5: non rifatto.

## Stato

In corso. Vedi Esito in fondo.

## Fatti misurati prima di toccare

Script e output in `scratchpad/fo-auth-290/` (`measure.mjs`, `interact.mjs`, `tokenpage.mjs`, `fullpath-before.mjs`; JSON in `out/`).

### FO-5-02 / FO-3-01 password dimenticata e nuova password

- MISURATO (`out/measure-before.json`, 4 lingue x 1280/375): `/{it,en,de,es}/auth/password/reset` risponde 200 ma senza `header`, senza `footer`, senza `main`, senza `h1`; `<title>` = "FixCity" uguale alla home; `<html lang>` corretto ma testo inglese fisso ("Reset password", "Email address", "Send password reset link", "Or return to login") in tutte e 4 le lingue; campo `email` con `autofocus`. axe: `landmark-one-main(1)`, `page-has-heading-one(1)`, `region(3)`. Login e registrazione nelle stesse lingue: 1 `h1`, 1 `main`, header e footer presenti, titolo proprio.
- MISURATO (`out/interact-before-1280.json`): invio con email sconosciuta -> testo visibile `passwords.user` (chiave grezza); con email nota (giulia) -> `passwords.sent` (chiave grezza, nessuna frase "controlla la posta"); focus su `BODY`; nessuna regione `role="status"` ne' `role="alert"`. Questo e' anche un'enumerazione degli account: la risposta cambia tra email nota e ignota. Email vuota o non valida: nessun messaggio nel DOM (il `form` non ha `novalidate`: decide la bolla nativa del browser, che non e' tradotta ne' annunciata dal nostro codice).
- MISURATO (`out/token-before.txt`, `tokenpage.mjs`): la pagina `/it/auth/password/{token}?email=...` e' la stessa pagina grezza: nessun header/footer/`h1`/`main`, 3 campi con etichette inglesi ("Email address", "Password", "Confirm Password"), campo email NON precompilato da `?email=`.
- MISURATO (`fullpath-before.mjs`): percorso completo con un token reale creato sul DB di prova (`Password::broker()->createToken`): compilato email e due volte la nuova password, il clic su "Reset password" fa rispondere Livewire `[200, 500]` e la pagina resta uguale. **Il percorso "imposta nuova password" oggi non funziona** (l'audit non lo aveva potuto provare: la mail va in `array`).
- DEDOTTO (lettura): `Modules/User/resources/views/pages/auth/password/reset.blade.php` e `[token].blade.php` sono Folio+Volt copiati da uno scaffold (layout `x-layouts.main`, componenti `x-ui.*`). `Themes/Sixteen/resources/views/livewire/auth/passwords/email.blade.php` e' un residuo Livewire (Tailwind indaco, `autofocus`, chiavi `user::auth.Reset password`): non e' collegato a nessuna pagina (`grep` su `email.blade.php`/`auth.passwords.email`). Esistono pero' i pezzi giusti, mai collegati: `Themes/Sixteen/resources/views/components/pages/auth-password-reset.blade.php` e `auth-password-token.blade.php` (card con classi Tailwind e testi `__('Reimposta la password')` senza chiave lang, quindi italiani in tutte le lingue), i widget `Modules/User/app/Filament/Widgets/Auth/ForgotPasswordWidget` e `ResetPasswordWidget` con le viste `filament/widgets/auth/forgot-password-widget.blade.php` e `reset-password-widget.blade.php`.
- DEDOTTO: `ResetPasswordWidget::resetPassword()` prende dallo schema `password` gia' hashato (`dehydrateStateUsing(Hash::make)` in `UserForm::getResetPasswordFormSchema`) e nel callback fa un secondo `Hash::make`: doppio hash. Da provare con un test (login con la nuova password) prima di dichiararlo. Lo stesso nel widget `PasswordResetConfirmWidget`, che nessuna pagina monta: non toccato.
- DEDOTTO: le chiavi `passwords.sent`, `passwords.user` usate dai widget non hanno namespace: nessun file `lang/it/passwords.php` globale (esistono `Modules/User/lang/{it,en,de}/passwords.php`, per giunta in italiano in tutte; manca `es`).

### FO-5-10 / FO-5-11 / FO-5-30 registrazione e login

- MISURATO (`out/interact-before-1280.json`): registrazione, invio a vuoto: 0 campi con `aria-invalid`, 0 con `aria-describedby`; un riepilogo `role="alert"` con titolo e lista, ma con i nomi tecnici ("first name e' richiesto.", "last name e' richiesto.", "email e' richiesto.", "password confirmation e' richiesto."); focus finale su `BODY`.
- MISURATO: login, invio a vuoto: 2 campi con `aria-invalid="true"` e `aria-describedby` (`form.email-error`, `form.password-error`): corretto, lo fa Filament. Ma l'avviso `role="alert"` contiene solo il primo errore ("Il campo indirizzo email e' obbligatorio.") e il focus finale e' su `BODY`.
- MISURATO (`measure-before.json`): `autofocus` presente su `form.email` (login) e su `email` (password dimenticata); assente sulla registrazione.
- DEDOTTO: `UserForm::getLoginFormSchema`, `getRegisterFormSchema`, `getForgotPasswordFormSchema` hanno `->autofocus()`; la registrazione (`RegisterWidget` + vista a mano) non usa lo schema.

### FO-5-26 Google e resa dei campi

- MISURATO: `GetMissingProviderSettingsAction::execute('google')` sull'istanza di prova = `["GOOGLE_CLIENT_ID","GOOGLE_CLIENT_SECRET","GOOGLE_REDIRECT_URI"]` (non configurato, `grep -c '^GOOGLE_' .env` = 0) e il pulsante "Accedi con Google" compare lo stesso in login e registrazione (`measure-before.json`, campo `googleBtn`). Dimensione: login 510x44 (1280) / 301x44 (375); registrazione 510x183 (1280, anche 190, 205, 226 nelle altre lingue) / 301x183 (375). Screenshot `shots/before-register-375.png`: nella registrazione e' una scatola alta con la "G" gigante.
- DEDOTTO: `google-button.blade.php` controlla solo `Route::has('oauth.redirect')`, sempre vero (stessa famiglia di errore di DCP-271: una guardia sull'esistenza). I suoi stili (bordo, altezza 2,75rem, flex) sono dentro `auth-login.blade.php` sotto `.auth-login-card`: il componente non porta con se' la resa, quindi nella registrazione (altra card) esce senza stile.
- DEDOTTO: la registrazione scrive a mano `<label><input>` con regole `!important` (bordo `#5b6f82`) e il login usa campi Filament con bordo `#c5d0db`: due rese diverse per lo stesso tipo di campo.

## Causa

- FO-5-02 / FO-3-01: la pagina del modulo e' uno scaffold mai adattato; i componenti del tema e i widget nati per sostituirla non sono mai stati collegati; i testi sono fissi in inglese o senza chiave lang.
- FO-5-10 / 11: la registrazione e' una vista Blade a mano senza `id`/`aria-*` sugli errori; nessuna pagina sposta il focus dopo un invio fallito; i nomi degli attributi arrivano dal nome tecnico del campo.
- FO-5-26: stile del pulsante legato alla card del login; nessuna guardia sulla configurazione del provider.

## Decisioni

1. **Pagine password a tema, senza file nuovi in `Themes/*/pages`.** Le due pagine restano nel modulo User (Folio, rotte `password.request` e `password.reset` invariate), non piu' Volt: usano `x-layouts.app` (header, footer, un `main`) e montano il componente del tema, come fa gia' `Modules/User/.../pages/auth/register.blade.php`. Il contenuto e' un widget Livewire con schema Filament (`ForgotPasswordWidget`, `ResetPasswordWidget`), non Volt: sparisce il problema della radice unica Volt.
2. **Risposta neutra al recupero.** Stessa frase per email nota, ignota, o troppo ravvicinata ("se l'indirizzo e' registrato, riceverai..."): niente enumerazione, niente chiave grezza. Messaggio in una regione `role="status"` sempre presente nel DOM. Chiavi `user::auth.password_reset.*` in it, en, de, es (nessun testo nuovo in `passwords.php`, che resta com'e').
3. **Un solo meccanismo di errori per le pagine di accesso.** Componente `x-auth.error-summary` (`role="alert"`, conteggio, tutti i messaggi) usato da login, registrazione, password dimenticata e nuova password; e un piccolo script condiviso che, dopo una chiamata Livewire che lascia campi con `aria-invalid="true"`, sposta il focus sul primo. Nessuna richiesta nuova al server, nessun `autofocus` in nessuna delle quattro pagine. Lo script e' inline (nessuna build del tema: `npm run build` e' del coordinatore) e si aggancia al hook `commit` di Livewire 4.4.8 (provato che `succeed` scatta dopo il rendering: vedi Esito).
4. **Registrazione**: `aria-invalid` e `aria-describedby` con un componente `x-auth.field` (etichetta, campo, aiuto, errore con `id`), nomi di attributo veri da `validationAttributes()` del widget, chiavi in `gdpr::register.*` (it, en, de, es). La logica di registrazione, i consensi e la prova (A-04) non sono toccati.
5. **Google**: il pulsante compare solo se `IsProviderConfiguredAction` dice che e' configurato (riuso, nessuna guardia nuova) e porta con se' il proprio stile (stessa resa in login e registrazione). DA DECIDERE: con `APP_DEBUG=true` DCP-271 mostrava la guida di configurazione al clic; senza pulsante la guida resta raggiungibile solo dall'URL `/{lang}/auth/login/google` e dalla pagina del back office. Proposta: tenere il pulsante nascosto anche in debug (qui eseguito cosi', come da incarico).
6. **Resa dei campi**: un solo stile per i campi a mano della registrazione, allineato a quello del login (bordo, altezza, fuoco), in un partial condiviso (`x-auth.assets`) estratto dal blocco `<style>` di `auth-login.blade.php` (il contratto del test `AuthLoginStyleContractTest` si sposta sul partial: stesse stringhe, nuovo file). Nomi di classe `.auth-login-*` e `.auth-register-*` invariati (usati dal CSS compilato).
7. **Fuori ambito, segnalati**: password policy di reset (`min 8` nello schema contro `Password::defaults()` della registrazione) e controllo `uncompromised` (D-11/D-33): DA DECIDERE, non cambiati; utente gia' loggato che apre login/registrazione/password (FO-3-13/14, middleware `guest`): non in elenco; `UserServiceProvider` e mail di reset: chiusi da DCP-285.

## Criteri di accettazione verificabili

- [ ] `/{it,en,de,es}/auth/password/reset` e `/{lang}/auth/password/{token}`: 200; un `h1`, un `main`, header e footer del sito; `<html lang>` = lingua; `<title>` proprio e diverso dalla home; nessun testo inglese fisso nelle altre lingue; nessuna chiave grezza (`passwords.*`, `ns::chiave`); nessun `autofocus`; axe senza `landmark-one-main`, `page-has-heading-one`.
- [ ] Recupero: stessa risposta per email nota e ignota, in `role="status"`; email vuota o non valida: errore tradotto sul campo con `aria-invalid` e `aria-describedby`, riepilogo `role="alert"` con conteggio, focus sul campo.
- [ ] Percorso completo (token reale): link -> pagina con email precompilata da `?email=` -> nuova password -> accesso con la nuova password riuscito (prova che il doppio hash non c'e') -> la pagina di login mostra l'esito in `role="status"`; token non valido: errore tradotto, nessun 500.
- [ ] Registrazione: ogni campo con errore ha `aria-invalid="true"` e `aria-describedby` che punta all'errore; nessun "first name"/"last name"/"email e'" tra i messaggi in it, en, de, es; riepilogo con conteggio; focus sul primo campo non valido (misurato nel browser, `document.activeElement`).
- [ ] Login: riepilogo con tutti gli errori e conteggio; focus sul primo campo non valido dopo un invio fallito; nessun `autofocus` su login e password dimenticata.
- [ ] Google: senza chiavi nessun pulsante in login e registrazione; con chiavi (test con `config()`) stesso markup e stessa altezza (44 px) nelle due pagine.
- [ ] Browser :8091, 375/768/1280: nessuno scroll orizzontale; axe prima e dopo sulle pagine toccate; screenshot letti.
- [ ] PHPStan a zero sui file PHP nuovi o toccati; Pint solo sui miei file.

## Test

Nel modulo Fixcity (runner di radice: i test di User/Gdpr che renderizzano le pagine del tema richiedono il TestCase di Fixcity, vedi memoria `login-register-redirect-intended-dcp124`) cartella `tests/Feature/Auth/`:

- `PasswordResetPagesTest.php` (nuovo): struttura delle pagine in 4 lingue, risposta neutra, percorso completo con token reale, token non valido.
- `AuthFormErrorsAccessibilityTest.php` (nuovo): `aria-invalid`/`aria-describedby`, riepilogo con conteggio, nomi di attributo, niente `autofocus`, in 4 lingue.
- `AuthGoogleButtonTest.php` (nuovo): nascosto senza chiavi, stesso markup con le chiavi.
- `Themes/Sixteen/tests/Unit/AuthLoginStyleContractTest.php` (esistente): aggiornato perche' lo stile vive in `components/auth/assets.blade.php`.

Esecuzione: `PEST_OUT=<file> bash bashscripts/tools/pest-scratch-db.sh <percorso>` dalla radice.

## Owned file scope

Modificati (esistenti, con lock `DCP-290` id `w3e`, sbloccati a fine lavoro):

- `laravel/Modules/User/resources/views/pages/auth/password/reset.blade.php`
- `laravel/Modules/User/resources/views/pages/auth/password/[token].blade.php`
- `laravel/Modules/User/app/Filament/Widgets/Auth/ForgotPasswordWidget.php`
- `laravel/Modules/User/app/Filament/Widgets/Auth/ResetPasswordWidget.php`
- `laravel/Modules/User/app/Filament/Widgets/Auth/LoginWidget.php` (solo se serve; riletto prima di ogni Edit, il ritorno dopo il login non si tocca)
- `laravel/Modules/User/app/Filament/Widgets/Auth/Schemas/UserForm.php` (`autofocus`, email precompilata)
- `laravel/Modules/User/lang/{it,en,de,es}/auth.php` (chiavi `password_reset.*`, `errors.*`), solo in aggiunta
- `laravel/Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php` (`validationAttributes()`)
- `laravel/Modules/Gdpr/lang/{it,en,de,es}/register.php` (solo in aggiunta)
- `laravel/Themes/Sixteen/resources/views/components/pages/auth-login.blade.php`, `auth-register.blade.php`, `auth-password-reset.blade.php`, `auth-password-token.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/utilities/google-button.blade.php`
- `laravel/Themes/Sixteen/resources/views/filament/widgets/auth/{login,register,forgot-password-widget,reset-password-widget}.blade.php`
- `laravel/Themes/Sixteen/tests/Unit/AuthLoginStyleContractTest.php`
- `laravel/Modules/User/docs/bmad/decision-log.md` (una riga in coda)

Nuovi: `Themes/Sixteen/resources/views/components/auth/{assets,shell,error-summary,field}.blade.php`; test sopra; questa story.

Non toccati: `Modules/Comment/**`, `UserServiceProvider.php`, `UserPolicy`, `routes/web.php`, `bootstrap/*`, `FixcityServiceProvider`, migrazioni, `Themes/*/resources/views/pages`, wizard, header, footer, consenso salvato (A-04), testi legali, `Modules/Notify`.

## Esito

(da compilare a fine lavoro)

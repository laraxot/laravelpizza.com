---
title: "Pagine di autenticazione: struttura, UX e regole"
type: guide
status: active
theme: Meetup
qmd: "authentication ui ux auth pages login register logout verify password reset confirm passworddata auth-card auth-field widget folio livewire volt seo localizzazione"
---

# Pagine di autenticazione

Questa pagina e' la fonte unica per le pagine `auth/*` del tema: dove stanno, chi contiene la logica, come devono comportarsi e quali errori sono gia' capitati. La pagina di registrazione ha una guida a parte: [register-page](register-page.md). I docblock `@see` delle pagine Blade `logout`, `password/reset` e `password/[token]` puntano qui.

## Principio architetturale

Le pagine del tema sono solo cornice (layout, titolo, logo, testi tradotti): **la logica dei form sta nei widget Filament dei moduli** ([ADR](adr/auth-forms-are-module-widgets.md)). Il test `Themes/Meetup/tests/Unit/PagesAndAuthFormsContractTest.php` verifica che `auth/login.blade.php` contenga `Modules\User\Filament\Widgets\Auth\LoginWidget` e `auth/register.blade.php` `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget`. Niente logica di business nelle Blade (Actions nei moduli).

## Pagine (`resources/views/pages/auth/`)

| File | Nome rotta | Middleware | Note |
|---|---|---|---|
| `login.blade.php` | `login` | `guest` | cornice con logo `meetup-logo`, titolo `pub_theme::auth.login.*`, widget `LoginWidget`, link alla registrazione |
| `register.blade.php` | `register` | `guest` | widget Gdpr `RegisterWidget` con i consensi; vedi [register-page](register-page.md) |
| `logout.blade.php` | `auth.logout` | - | GET `/{locale}/auth/logout`, vedi sotto |
| `verify.blade.php` | `verification.notice` | `auth`, `throttle:6,1` | avviso "verifica la tua email" con reinvio; frammento Volt `meetup.auth.verify` |
| `password/reset.blade.php` | `password.request` | `guest`, `throttle:6,1` | password dimenticata |
| `password/[token].blade.php` | `password.reset` | `guest` | nuova password dal link ricevuto |
| `password/confirm.blade.php` | `password.confirm` | `auth` | riconferma della password prima di un'area protetta |

`reset`, `[token]`, `confirm` e `verify` usano `<x-ui.auth-card :title :subtitle>` (scheda centrata con logo, `h1`, slot) e `<x-ui.auth-field>` per i campi; login e registrazione hanno un proprio layout con sfondo animato. URL sempre sotto il prefisso `/{locale}/auth/...`; gli alias `/{locale}/login` e `/{locale}/register` rimandano a `auth/login` e `auth/register` (`config/local/laravelpizza/seo.php`).

Le Blade di auth non eseguono codice con effetti nel blocco PHP iniziale: la lingua la imposta il middleware `SetFolioLocale` (modulo Cms), perche' Folio esegue quel blocco anche solo per leggere `name()`/`middleware()` (es. generando `route('login')` da CLI) e un `setLocale` li' cambiava la lingua dell'intero processo. Guardia: `Modules/Meetup/tests/Unit/Architecture/FolioPagesWithoutSideEffectsTest.php`.

## Logout (`auth.logout`)

`pages/auth/logout.blade.php` e' la pagina GET (link da email, bookmark). E' Folio + Volt con `@volt('auth.logout')` (senza la direttiva Volt risponde 500): mostra `pub_theme::auth.logout.in_progress` e con `wire:init="logout"` esegue `Modules\User\Http\Volt\LogoutAction` (la stessa della rotta POST) e reindirizza alla home della lingua corrente.

- Il nome `auth.logout` e' voluto: `logout` appartiene alla rotta POST di `Modules/User/routes/web.php` usata dai form di navigazione; due rotte con lo stesso nome renderebbero `route('logout')` dipendente dall'ordine di registrazione.
- Nessun `dd()`/debug: la GET deve rendere 200 anche da ospite. Il form di logout del menu mobile fa POST a `route('logout')`.
- Test di guardia: `Modules/Meetup/tests/Feature/Security/LogoutPageTest.php`.

## Password: dimenticata, nuova, conferma

- `password/reset` e `password/[token]` rispondono allo stesso modo se l'email esiste o no (nessuna enumerazione di utenti); dopo il reset l'utente entra e va in `xra.post_login_path` (`/events/my` in `config/local/laravelpizza/xra.php`).
- Il link dell'email di reset (`BuildPasswordResetUrlAction`) usa la lingua della richiesta e aggiunge `?email=`.
- Il broker usa la connessione `user` (tabella `password_resets` del modulo User).
- I testi stanno in `Themes/Meetup/lang/{it,en,de,es,fr,ru}/auth.php` sotto `login.*`, `logout.*`, `password.request.*`, `password.reset.*`, `password.confirm.*`, `verify.*`. Un sync con il tema generico li aveva sostituiti con pagine senza `h1` e senza queste chiavi: la regola e' che i valori del progetto vincono, le chiavi generiche si mantengono (guardia `FrontOfficePrivacyAndSeoTest`, caso "forgot password").
- Regole password (lunghezza, maiuscole/minuscole, lettere, numeri, simboli, non compromessa, test HaveIBeenPwned) sono centralizzate in `Modules\User\Datas\PasswordData` (default: `min 8`, `mixedCase`, `letters`, `numbers`, `symbols`, `uncompromised`; configurabili per tenant) e riusate dai widget con `PasswordData::make()->getPasswordFormComponents('password')`. Testi di aiuto e validazione vengono dai file di lingua del modulo User (`password.php`, `validation.php`), non dal tema. Cosi' ogni flusso di registrazione/cambio password ha le stesse regole.

## Regole UX e accessibilita'

- Mobile-first: form a larghezza piena su telefono, bersagli tattili minimi 44x44 px, `h1` unico e nome accessibile sui link-logo (`aria-label`), SVG come file (`<x-filament::icon icon="meetup-logo">`, mai inline: [svg-icons-no-hardcoded-blade](svg-icons-no-hardcoded-blade.md)).
- Etichette sopra i campi, errori sotto il campo, messaggi specifici e tradotti; toggle di visibilita' della password; ordine di tabulazione logico. Animazioni solo decorative e disattivabili con `prefers-reduced-motion` (niente lampeggi). Dettaglio: [accessibility](accessibility.md).
- Terminologia: "Registrati / Crea il tuo account" e "Accedi", mai "Sign Up" in un'interfaccia italiana; tutti i testi in chiavi di traduzione `pub_theme::auth.*` (mai stringhe fisse: [localization-standard](localization-standard.md)); link e action localizzati con `LaravelLocalization::localizeUrl('/auth/...')`.
- SEO: ogni pagina auth ha `title` e description propri (prop `:title`/`:description` di `<x-layouts.app>`, brand incluso, titolo <= 60 caratteri, descrizione <= 160); vedi [seo-structured-data](seo-structured-data.md).
- Privacy: nessuna richiesta a terzi (niente Gravatar: `xra.gravatar = false`, iniziali in locale; niente CDN o Google Fonts), consensi GDPR nella registrazione: [gdpr-compliance](gdpr-compliance.md).
- Gestione errori JS globale: `resources/js/app.js` registra `error` e `unhandledrejection` e mostra una notifica; i messaggi sono oggi stringhe italiane fisse (debito rispetto alla regola "niente testi fissi", vedi [roadmap](roadmap.md)).

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| `/it/auth/password/confirm` in 500 dopo un sync dei moduli | il modulo User porta pagine Folio con gli stessi nomi Volt del tema (`auth.password.confirm`, `auth.verify`): Volt registra i frammenti per nome e il tema mostrava quello del modulo | i `@volt()` del tema gia' usati da un modulo hanno prefisso `meetup.`; guardia `UniqueVoltFragmentNamesTest` |
| `/auth/logout` risponde 500 | manca `@volt('auth.logout')` | tenere la direttiva |
| Rimandare la verifica email faceva partire l'evento `Verified` | invio e verifica confusi | `resend()` invia solo la notifica; se l'email e' gia' verificata si va a `xra.post_login_path` |
| "Password dimenticata" in errore (connessione inesistente) | broker su `liveuser_general` | connessione `user` |
| Link dell'email di reset sempre in italiano | URL costruito senza locale | `BuildPasswordResetUrlAction` |

## Checklist

- [ ] Form validati, errori chiari e tradotti
- [ ] Layout corretto su telefono, navigazione da tastiera, screen reader (`npm run a11y`, [testing](testing.md))
- [ ] Un solo `h1`, `title` e description propri
- [ ] Testi in tutte le lingue con auth (it, en, de, es, fr, ru; `hi` e `zh` hanno solo `event.php`)
- [ ] Consensi e regole password uguali a quelle della registrazione

## Vedi anche

- [register-page](register-page.md), [gdpr-compliance](gdpr-compliance.md)
- [localization-standard](localization-standard.md), [language-switcher](language-switcher.md)
- [adr/auth-forms-are-module-widgets](adr/auth-forms-are-module-widgets.md)

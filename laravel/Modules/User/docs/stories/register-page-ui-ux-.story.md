# Registrazione FO /it/auth/register: traduzioni, struttura card, mobile

- Stato: done (2026-10-07). Parte posta: vedi `../auth-register-email.md`
- Fase BMAD: Quick Flow (analisi, fix, verifica nel browser)
- Owner: Modules/User (lang, widget), tema Sixteen (view e CSS)

## Problema

9 chiavi `user::...` grezze (titolo, sottotitolo, sidebar, pulsante, "hai gia' un account"), quattro riquadri annidati,
contenuto tagliato su mobile, campo password senza larghezza per colpa del pulsante "Mostra password",
CTA come contorno bianco mentre il login ha il CTA pieno.

## Cause radice

1. Chiavi mai definite in `lang/it` (`auth.register_page.*` e `registration.actions.register.*`, `registration.already_registered`).
2. `register.blade.php` del widget annidava `x-filament::section` e padding dentro la card della pagina.
3. La regola CSS `body:not([data-page='auth-login']) button[type=submit].fi-btn` colpiva anche `auth-register`.

## Modifiche

- `lang/it/auth.php`: `register_page` (kicker "Area personale" come il login). `lang/it/registration.php`: `actions.register.{label,error}`, `already_registered`.
- `Themes/Sixteen/.../pages/auth/register.blade.php`: padding nella pagina, card `-mx-4 sm:mx-0` su mobile.
- `Themes/Sixteen/.../filament/widgets/auth/register.blade.php`: un solo `div`, shell del form senza riquadro su mobile, link "Accedi".
- CSS (altra sessione, commit 2b37f9c): regola CTA estesa a `auth-*`.
- Test: 23 chiavi in `LoginPageTranslationsTest.php`, senza DB.

## Verifica

- Render https: 0 chiavi grezze, HTTP 200. Screenshot 1280 e 390 controllati. CTA computato: bg `rgb(0,122,82)`, testo bianco, come il login.
- Pest: 23 passed.

## Aperto

- Il login mantiene il riquadro interno del form su desktop, la registrazione no: allineare in una story separata.
- Su mobile il placeholder della password ("Inserisci una password sicura") viene troncato dal pulsante "Mostra password".
- Registrazione end-to-end (submit reale + email di verifica) non provata in questa sessione: crea un utente nel DB di sviluppo.
- Lingue en/de/es: `register_page` e `registration.*` mancano.

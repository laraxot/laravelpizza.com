# Registrazione, logout e verifica email (FO)

- Stato: done (2026-10-07)
- Fase BMAD: Quick Flow (investigate, fix, verifica nel browser reale)
- Owner: Modules/User; toccati Notify (mail), Themes/Sixteen (Folio, header)

## Problemi trovati

1. Logout: gli header POSTano a `route('logout')`, che e la pagina Folio `auth/logout` (solo GET): `405 Method Not Allowed`.
   `LogoutAction` esisteva ma non era collegata a nessuna route e rimandava a `route('home')`, inesistente.
2. Da `/en` il form di logout puntava a `/it/auth/logout` (la route Folio risolve sempre il locale di default).
3. Registrazione: utente creato ma risposta 500, nessuna mail: `verification.verify` non definita; poi layout mail rotto
   (`html_layout_path` NULL, sintassi Handlebars in un motore Mustache), poi template di verifica senza link e con `[verify-email]`.
4. `.env`: riga `MAIL_*` corrotta con `\n` letterali.
5. Lang: `login_page`, `register_page`, `password_reset_page`, `login.*`, `registration.*` mancanti in `en` (e reset password anche in `it`).

## Modifiche

- `routes/web.php` (app): `POST /{lang}/auth/logout` -> `LogoutAction` (`auth`, nome `logout.post`); redirect a `/{lang}`.
- Viste del tema: `route('logout')` -> `url('/'.app()->getLocale().'/auth/logout')` (15 file).
- Folio `pages/auth/verify/[id]/[hash].blade.php` (`verification.verify`).
- `SpatieEmail`: layout di default e template `verify-email` con link; `lang/{it,en}/verification_email.php`.
- Lang it/en: chiavi mancanti di login, registrazione, reset password, `login.email_verified`.
- `bootstrap/app.php`: `trustProxies(at: '127.0.0.1')` per il proxy HTTPS di sviluppo.

## Verifica (Chrome headless, posta vera su Postfix)

- Login + logout `/it` e `/en`: `POST ... -> 302` verso la home del locale, sessione chiusa.
- Registrazione: redirect, mail consegnata in `/var/mail/zorin` con link `https://192.168.1.40:8080/it/auth/verify/...`.
- Link da ospite: pagina di login; da loggato: `email_verified_at` valorizzato, redirect `/it/tickets`; firma manomessa: 403.

## Aperto

- Consegna a caselle esterne: serve un relay SMTP autenticato (vedi `Notify/docs/wiki/how-to/mail-postfix-locale.md`).
- 6 migrazioni ancora bloccate su `ticket_comments.user_id` bigint -> uuid (vedi story login-unknown-database).

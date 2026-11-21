---
title: "Posta in uscita: Postfix locale e verifica email"
type: how-to
tags: [notify, mail, postfix, smtp, verify-email, mustache]
created: 2026-10-07
updated: 2026-10-07
qmd: "postfix locale mail laravel verify-email spatie mail template mustache gmail spf dkim relay"
issues: []
discussions: []
---

# Posta in uscita: Postfix locale

## Stato sul server di sviluppo

- Installati `postfix` e `mailutils` (`apt`), configurato **solo loopback**: `inet_interfaces = loopback-only`,
  `myhostname/myorigin = fixcity.local`, `smtp_tls_security_level = may`. Alias `noreply: zorin` per leggere i bounce.
- `laravel/.env`: `MAIL_MAILER=sendmail` (`/usr/sbin/sendmail -bs -i`) o `smtp` su `127.0.0.1:25`, `MAIL_FROM_ADDRESS=noreply@fixcity.local`,
  `AUTH_MUST_VERIFY_EMAIL=true`. Nessuna credenziale nel repo.
- Verifica: `echo corpo | mail -s prova zorin@fixcity.local` e `tail /var/mail/zorin`; coda: `postqueue -p`;
  log: `journalctl -u postfix --since -5min | grep status=`.

## Limite: consegna a caselle esterne

Gmail rifiuta il messaggio (`550 5.7.26 sender is unauthenticated`): il mittente `fixcity.local` non puo passare SPF/DKIM
e l'IP pubblico e residenziale. Per recapitare fuori serve **un relay SMTP autenticato** (provider, Gmail app password,
SES, Brevo...) oppure un dominio vero con SPF, DKIM, DMARC e PTR. Con un relay: `relayhost = [smtp.provider:587]` e
`smtp_sasl_*` in `main.cf`, credenziali fuori dal repo.

## Mail di verifica (flusso completo)

1. `RegisterWidget` crea l'utente e chiama `sendEmailVerificationNotification()`.
2. `UserServiceProvider` costruisce `SpatieEmail($user, 'verify-email')` con `verification_url`.
3. Il template database `verify-email` (tabella `mail_templates`, traducibile) e creato da `SpatieEmail`; per `verify-email`
   `syncVerifyEmailTemplate()` usa i testi `user::verification_email.*` (it, en) con pulsante e link firmato, a meno che
   l'admin lo abbia personalizzato.
4. Il link `/{lang}/auth/verify/{id}/{hash}` e una pagina Folio del tema (`pages/auth/verify/[id]/[hash].blade.php`, nome
   `verification.verify`, middleware `auth`, `signed`, `throttle`): verifica, `Verified`, redirect a `/{lang}/tickets`.

## Errori incontrati (da non ripetere)

- `.env` con righe `MAIL_*` unite da `\n` letterali: `MAIL_MAILER` diventava una stringa senza senso.
- `route('verification.verify')` mancante: il modulo User non carica le sue route (Folio + Volt) e `routes/auth.php` e commentato.
- `bootstrap/cache/routes-v7.php` e `folio-routes.php` presenti: nascondono le pagine Folio nuove; in sviluppo `php artisan route:clear`.
- Layout `Themes/*/resources/mail-layouts/base.html` scritto in Handlebars/Liquid (`{{#if x}}`, `| default:`): Spatie usa **Mustache**,
  servono sezioni `{{#x}}...{{/x}}` e niente filtri.
- `SpatieEmail::getHtmlLayout()` andava in `Assert::string(null)` per template senza layout: ora usa `base.html`.
- Il default generico del template aggiungeva il marcatore `[slug]` al testo: rimosso.

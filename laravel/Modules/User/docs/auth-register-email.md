---
title: "Registrazione cittadino e posta di verifica"
type: bmad-implementation-note
status: implemented-runtime-pending
module: User
created: 2026-10-07
updated: 2026-10-07
tags: [bmad, registration, email, postfix, verification, ux]
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/572"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/573"
---

# Registrazione cittadino e posta di verifica

## Decisione

Il modulo User resta proprietario dell'identità e del flusso di registrazione.
La pagina pubblica resta di Sixteen; la consegna passa dal Postfix locale già
installato sul server. Laravel usa il transport `sendmail`, senza credenziali
SMTP nel repository.

## Configurazione effettiva

```dotenv
MAIL_MAILER=sendmail
MAIL_SENDMAIL_PATH="/usr/sbin/sendmail -bs -i"
MAIL_HOST=127.0.0.1
MAIL_PORT=25
MAIL_EHLO_DOMAIN=fixcity.local
MAIL_FROM_ADDRESS=noreply@fixcity.local
AUTH_MUST_VERIFY_EMAIL=true
```

`config/auth.php` espone `auth.must_verify_email`; il widget invia la notifica
di verifica solo quando questa opzione è attiva e l'utente implementa
`MustVerifyEmail`.

## Limite operativo

Postfix è configurato in loopback e non ha un relay esterno. Questo abilita il
test locale e la coda del server, ma non garantisce la consegna verso Gmail o
altri provider. Per produzione va impostato un relay SMTP autenticato con
credenziali fornite dal gestore della posta; non vanno inventate né versionate.

## Verifica

```bash
systemctl is-active postfix
postqueue -p
cd laravel && php artisan config:clear && php artisan view:clear
```

Il collaudo end-to-end richiede un destinatario di test autorizzato e un
database disponibile; nessuna mail reale viene inviata automaticamente durante
la verifica del codice.

## Verifica runtime 2026-10-07 19:32

- `MAIL_MAILER=sendmail`, Postfix in ascolto su `127.0.0.1:25`, `/usr/sbin/sendmail` presente.
- Invio reale da Laravel (`php artisan tinker`, `Mail::raw(...)`) verso `zorin@localhost`: messaggio consegnato in `/var/mail/zorin` con l'oggetto atteso, `postqueue -p` vuota.
- NON verificato: la consegna verso caselle esterne. Un server in LAN senza DNS pubblico, PTR e SPF viene spesso rifiutato o messo in spam, e molti provider bloccano la porta 25 in uscita. Per la produzione serve un relay SMTP autenticato (solo variabili `MAIL_*` nel `.env`, nessuna modifica al codice).
- Nessuna password o credenziale va scritta in questo file o nel repository.

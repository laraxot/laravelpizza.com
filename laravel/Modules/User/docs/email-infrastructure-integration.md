---
title: "Autenticazione e posta email"
type: guide
module: User
status: active
tags: [email, verification, smtp, imap]
---

# Autenticazione e posta email

La verifica email, il reset password e gli inviti dipendono dal modulo Notify e
dal mailer Laravel configurato nell’ambiente. Il server di sviluppo dispone di
Postfix locale, ma non di una casella IMAP pubblica: questo non è sufficiente per
ricevere posta dagli utenti.

## Contratto operativo

- il mittente applicativo deve appartenere a `fixcity.eu`;
- gli invii di verifica devono passare dal mailer Laravel configurato, senza
  credenziali nel codice;
- gli errori del provider devono essere visibili nei log e non trasformarsi in
  conferme false all’utente;
- la ricezione delle risposte è responsabilità dell’infrastruttura IMAP/MX, non
  dell’azione `ResendEmailVerificationAction`.

Il completamento della posta pubblica richiede l’attivazione documentata nel
runbook del modulo Notify:
`Modules/Notify/docs/email-infrastructure.md`.


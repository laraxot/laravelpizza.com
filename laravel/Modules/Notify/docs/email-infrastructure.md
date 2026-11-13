---
title: "Infrastruttura email del server FixCity"
type: runbook
module: Notify
status: active
tags: [email, smtp, imap, postfix, dovecot, dns, production]
---

# Infrastruttura email del server FixCity

## Audit eseguito

Audit eseguito il 2026-11-13 sul server `zorin`:

| Componente | Stato | Evidenza |
|---|---|---|
| Postfix | Installato e attivo | 3.10.6, systemd active |
| Mailutils | Installato | 3.20 |
| SMTP locale | Solo loopback | `inet_interfaces = loopback-only`, `127.0.0.1:25` |
| Dovecot IMAP/POP3 | Non installato | nessun binario o servizio rilevato |
| Rspamd/SpamAssassin | Non rilevati | nessun servizio rilevato |
| OpenDKIM | Non rilevato | nessun servizio rilevato |
| Mail queue | Vuota | `mailq` |
| MX `fixcity.eu` | Assente nell’audit | nessun record MX restituito |
| `mail.fixcity.eu` | Assente | nessun record A/AAAA restituito |
| Laravel Mailtrap SDK | Già installato | `railsware/mailtrap-php` 3.18 |

## Stato deliverability DNS

Il controllo DNS del 2026-11-13 ha trovato il dominio `fixcity.eu` con A e TXT
di verifica Google e un DMARC `p=none`, ma senza SPF e DKIM pubblicati e senza
MX. Questo è insufficiente per una reputazione affidabile: il provider deve
fornire il record DKIM esatto e il DNS deve pubblicare almeno:

```text
fixcity.eu.              TXT  "v=spf1 include:<provider-spf> -all"
<selector>._domainkey    TXT  "<provider-dkim-public-key>"
_dmarc.fixcity.eu.       TXT  "v=DMARC1; p=quarantine; rua=mailto:dmarc@fixcity.eu; adkim=s; aspf=s"
fixcity.eu.              MX   10 mail.fixcity.eu.
mail.fixcity.eu.         A    <public-server-ip>
```

I valori `<provider-spf>`, `<selector>` e `<provider-dkim-public-key>` non sono
inventabili: vanno copiati dalla console Mailtrap o dal relay scelto. Il record
DMARC va portato a `p=reject` solo dopo aver verificato che tutti gli invii
legittimi superino SPF e DKIM con allineamento del dominio From.

La reputazione non dipende solo dal DNS. Sono obbligatori anche: invio solo
transazionale e verso utenti consenzienti, rate limit, gestione dei bounce e
delle lamentele, soppressione degli indirizzi permanentemente falliti, contenuti
coerenti, link HTTPS, versione testuale e monitoraggio di Google Postmaster
Tools/Microsoft SNDS quando il volume lo permette.

Il Postfix presente è quindi un MTA locale per sviluppo/applicazioni, non un
server pubblico per invio e ricezione. La configurazione attuale usa anche il
nome locale `fixcity.local` e il certificato snakeoil: non va esposta a Internet
così com’è.

## Architettura da completare

Per inviare e ricevere direttamente dal server servono almeno:

1. Postfix configurato come MTA pubblico con submission autenticata su 587;
2. Dovecot IMAP su 993 (POP3 non necessario) per leggere le caselle;
3. TLS reale per `mail.fixcity.eu`;
4. utenti/caselle e autenticazione Dovecot;
5. Rspamd (o equivalente) per antispam e DKIM;
6. record DNS A, MX, SPF, DKIM e DMARC;
7. firewall per 25, 587 e 993 e reverse DNS coerente sull’IP pubblico;
8. backup e monitoraggio di queue, log e spazio disco.

La configurazione non può essere completata soltanto nel repository: richiede
root sul server, accesso al provider DNS Hetzner e conferma del criterio di
conservazione delle caselle.

## Laravel

Laravel deve usare un relay autenticato per la posta applicativa, preferibilmente
il bridge Mailtrap già presente durante il collaudo. Il mittente deve essere un
indirizzo del dominio verificato, per esempio `noreply@fixcity.eu`.

Valori non segreti attesi in produzione:

```dotenv
MAIL_MAILER=mailtrap-sdk
MAIL_FROM_ADDRESS=noreply@fixcity.eu
MAIL_FROM_NAME=FixCity
MAILTRAP_HOST=send.api.mailtrap.io
```

Le credenziali non devono essere salvate nei file versionati. Dopo ogni modifica
all’ambiente:

```bash
php artisan optimize:clear
php artisan config:cache
```

## Runbook di attivazione server

Eseguire come root, dopo aver definito hostname, caselle e DNS:

```bash
apt update
apt install postfix dovecot-core dovecot-imapd rspamd certbot opendkim opendkim-tools
```

Prima di aprire i servizi pubblici verificare:

```bash
postconf -n
doveconf -n
ss -ltnp | grep -E ':(25|587|993)\\b'
postqueue -p
```

Non eseguire questa procedura sul server corrente senza una finestra di
manutenzione e senza il controllo dei record DNS: una configurazione parziale
può interrompere l’invio applicativo o creare un relay aperto.



## Host di produzione (46.225.90.178) — 2026-11-12

L'audit sopra riguarda la workstation di sviluppo. Sull'host pubblico (record A di `fixcity.eu`) le 5 decisioni
sono state prese: server completo Postfix + Dovecot + OpenDKIM, hostname `fixcity.eu`, caselle virtuali, invio
diretto firmato DKIM. Story: [mail-server-send-receive](../stories/mail-server-send-receive.story.md);
script e record DNS: `bashscripts/docs/mail/mail-server.md`.

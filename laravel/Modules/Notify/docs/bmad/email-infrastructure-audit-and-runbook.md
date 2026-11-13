---
title: "Email infrastructure audit and runbook"
type: guide
module: Notify
status: active
tags: [email, smtp, imap, postfix, dovecot, mailtrap, bmad, ecc]
---

# Email infrastructure: audit and runbook

## Scope

This document separates the application email path from a full mailbox server.
The application must send transactional email (verification, password reset and
notifications). Receiving email requires a public MX, mailbox storage and an
IMAP service; it is not provided by Laravel or by the Mailtrap SDK.

## Audit evidence — 2026-11-12

### Application

- `railsware/mailtrap-php` `3.18.0` is installed.
- Laravel exposes the `mailtrap-sdk` mailer in `config/mail.php` and its service
  configuration in `config/services.php`.
- `SpatieEmail` and database-backed `MailTemplate` are the canonical content path.
- `SendMailCommand`, notifications and queued actions use Laravel's configured
  mailer; no second application mail stack should be introduced.
- The Filament `MailTemplateResource` and Notify test pages are the existing
  administrative/testing surface.
- Inbound webhook ingestion is implemented by
  `ProcessInboundMailAction` at `POST /api/inbound/{provider}/{token}`. It
  accepts Postmark, Mailgun and raw MIME payloads, authenticates with the
  secret `MAIL_INBOUND_TOKEN`, stores the raw payload on local disk and
  persists normalized messages in `inbound_emails` on the `notify` connection.
  The `provider` + `message_id` lookup makes deliveries with a message ID
  idempotent. This is webhook ingestion, not a mailbox/IMAP client.

### Host

- Postfix `3.10.6` and `mailutils` are installed and Postfix is enabled/running.
- Postfix is development-only: `inet_interfaces=loopback-only`, hostname
  `fixcity.local`, and no relayhost is configured.
- No Dovecot, Rspamd or OpenDKIM service is installed.
- Only local TCP port 25 is listening; ports 465, 587, 993 and 995 are not
  exposed by the current host.
- This checkout's host is `192.168.1.40` behind a private network. Its observed
  public egress address is different from the `fixcity.eu` A record. It is not
  proven to be the public FixCity production mail host.

### DNS

- `fixcity.eu` currently has no MX record.
- `mail.fixcity.eu`, `smtp.fixcity.eu` and `imap.fixcity.eu` currently have no
  A record.
- Therefore this host cannot safely receive `@fixcity.eu` mail today.

## Decisions required before system installation

1. Choose the public mail hostname, normally `mail.fixcity.eu`.
2. Confirm that the public server/NAT can forward TCP 25, 587 and 993 to the
   mail host; do not expose port 25 from this development workstation.
3. Choose mailbox storage and accounts (system users, virtual users or an
   external mailbox provider).
4. Choose the outbound path: an approved transactional provider (recommended)
   or direct Postfix delivery with stable rDNS, SPF, DKIM and DMARC.
5. Obtain root access and DNS-provider access. No credentials belong in Git.

## Safe target architecture

For production application mail, use `mailtrap-sdk`/a transactional provider
with `MAIL_FROM_ADDRESS=noreply@fixcity.eu`. For receiving application
messages, use the provider inbound webhook and protect it with a long random
`MAIL_INBOUND_TOKEN`. For human mailboxes, use a dedicated mail host with
Postfix + Dovecot IMAP + DKIM signing + SPF/DMARC and TLS.
Keep the Laravel application as the template/notification owner; do not make
the theme or a Filament page responsible for delivery.

## Installation order on the actual public mail host

Only after the decisions above and a backup:

1. Install Postfix, Dovecot IMAP, OpenDKIM and a spam filter.
2. Configure virtual domains/users and Maildir storage; never enable an open
   relay. Require authentication on submission (587) and TLS on IMAP (993).
3. Issue a certificate for `mail.fixcity.eu`.
4. Publish MX, A/AAAA, SPF, DKIM and DMARC records and set reverse DNS.
5. Test local delivery, authenticated submission, IMAP login, external delivery,
   SPF/DKIM/DMARC alignment and queue/bounce handling.
6. Configure Laravel production secrets and clear/cache Laravel config.

## Laravel production variables

```dotenv
MAIL_MAILER=mailtrap-sdk
MAILTRAP_HOST=send.api.mailtrap.io
MAILTRAP_API_KEY=provided-out-of-band
MAIL_FROM_ADDRESS=noreply@fixcity.eu
MAIL_FROM_NAME=FixCity
```

`MAILTRAP_API_KEY` and mailbox passwords must remain outside versioned files.
An unapproved Mailtrap account cannot deliver to arbitrary recipient domains;
complete provider approval before using it for public verification email.

## Verification checklist

```bash
php artisan optimize:clear
php artisan config:cache
php artisan tinker --execute="
dump(config('mail.default'));
dump(config('mail.from.address'));
dump(config('mail.mailers.mailtrap-sdk.transport'));
dump(config('services.mailtrap-sdk.host'));
dump((bool) config('services.mailtrap-sdk.apiKey'));
"
```

Never print API keys or mailbox passwords. A green Laravel configuration check
does not prove DNS delivery or inbound IMAP availability; those need external
DNS and network tests.

## Deliverability hardening checklist

There is no technical guarantee that a message will never reach spam: mailbox
providers also use engagement, complaints, reputation and content signals. The
following controls cover the parts FixCity can control:

- Send only from the verified `fixcity.eu` identity; never fall back to
  `example.com`, `localhost` or a development domain.
- Use one transactional stream/subdomain for verification and password mail;
  keep newsletters or promotional traffic on a separate stream and reputation.
- Publish exactly one SPF policy containing every authorized sender. Do not
  publish multiple SPF TXT records.
- Enable DKIM signing at the chosen provider and align its signing domain with
  the `From` domain (DMARC alignment).
- Publish DMARC first with `p=none` and a monitored `rua` mailbox, then tighten
  enforcement only after reports confirm alignment.
- Use valid forward and reverse DNS for any self-hosted sending IP, TLS for SMTP,
  and a stable hostname/EHLO identity.
- Keep bounce and complaint suppression enabled; never retry permanent failures
  or continue sending to repeated bounces.
- Send verification/password messages only to addresses requested by the user;
  rate-limit resends and keep transactional content plain, expected and
  non-promotional.
- For marketing/subscribed messages, implement RFC 8058 one-click unsubscribe
  (`List-Unsubscribe` and `List-Unsubscribe-Post`) and honor it promptly. This
  is not required for pure transactional verification messages.
- Register the sending domain in Google Postmaster Tools and monitor complaint
  rate. Gmail's current guidance uses 0.30% as the critical spam-rate threshold
  for bulk senders.

Authoritative references:

- [Gmail Email sender guidelines](https://support.google.com/mail/answer/81126)
- [Gmail sender guidelines FAQ](https://support.google.com/mail/answer/14229414)
- [Yahoo Sender Best Practices](https://senders.yahooinc.com/best-practices/)
- [Mailtrap Deliverability Guide](https://mailtrap.io/email-deliverability-guide/)


## Host di produzione (46.225.90.178) — 2026-11-12

L'audit sopra riguarda la workstation di sviluppo. Sull'host pubblico (record A di `fixcity.eu`) le 5 decisioni
sono state prese: server completo Postfix + Dovecot + OpenDKIM, hostname `fixcity.eu`, caselle virtuali, invio
diretto firmato DKIM. Story: [mail-server-send-receive](../stories/mail-server-send-receive.story.md);
script e record DNS: `bashscripts/docs/mail/mail-server.md`.

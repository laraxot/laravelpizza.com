---
title: "Inbound Email Pipeline (Notify)"
type: story
status: done
created: 2026-11-12
tags: [notify, mail, inbound, webhook, postmark, mailgun]
qmd: "inbound email webhook postmark mailgun mime parser inbound_emails"
issues: []
discussions: []
related:
  - ../mail-deliverability.md
  - mailtrap-sdk-bridge-study.story.md
---

# Story: pipeline inbound email

## Contesto

L'utente ha richiesto invio **e** ricezione email da fixcity.eu
(scelta "1+2": casella reale + ingestione applicativa; provider "1+3":
Mailtrap + alternativa). L'outbound esisteva già (mailtrap-sdk bridge,
SpatieEmail, `notify:test-mail`); l'inbound non esisteva affatto:
nessun MX, nessun webhook, nessun parser.

## Decisioni

- Owner modulo: **Notify** (coerente con `SendTestMail`, `notify:test-mailtrap`).
- Parser: `zbateson/mail-mime-parser ^4.0` (dichiarato in root `composer.json`
  e `Modules/Notify/composer.json`).
- Endpoint: `POST /api/inbound/{provider}/{token}` — token condiviso in URL
  (`config('notify.notify.inbound_token')` ← `MAIL_INBOUND_TOKEN`), `hash_equals`.
- Storage: tabella `inbound_emails` (UUID, `HasUuids`, dedup `provider+message_id`)
  + raw MIME in `storage/app/inbound/`.
- Action invocabile `ProcessInboundMailAction` in `app/Actions/Mail/`
  (no controller — regola architetturale; route via array callable perché
  `XotBaseRouteServiceProvider` prefissa `Http\Controllers\` ai route string).
- Payload: Postmark JSON, Mailgun form/`body-mime`, raw MIME.

## File

- `Modules/Notify/app/Actions/Mail/ProcessInboundMailAction.php`
- `Modules/Notify/app/Models/InboundEmail.php`
- `Modules/Notify/database/migrations/2026_11_13_000001_create_inbound_emails_table.php`
- `Modules/Notify/routes/api.php` (route `notify.inbound`)
- `Modules/Notify/config/notify.php` (`inbound_token`)
- `Modules/Notify/tests/Feature/InboundMailWebhookTest.php` (4 test verdi)
- `.env.production.example` (`MAIL_INBOUND_TOKEN`, `MAILTRAP_SANDBOX_ID`)
- `Modules/Notify/docs/mail-deliverability.md` (guida operativa completa)

## Fix collaterale

`config/services.php` conteneva **marker di merge non committati correttamente**
(`<<<<<<< .merge_file_*`): due aggiunte parallele dello stesso blocco
`mailtrap-sdk` in posizioni diverse + commit del file rotto. Risolto tenendo
UN solo blocco `mailtrap-sdk` (dopo `mailtrap`) e preservando `mailgun`,
`postmark`, `resend`, `ses`. Il file rotto faceva fallire il bootstrap PHPStan
e `artisan` senza config cache.

## Punti aperti

- Firma HMAC Mailgun non ancora implementata (consigliata se si adotta Mailgun).
- Allegati non estratti; nessun malware scan/retention policy.
- MX reale dipende dal provider di posta scelto (sezione 4 docs).
- Warm-up dominio e approvazione account Mailtrap: lato dashboard utente.

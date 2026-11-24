---
title: "Dipendenze mail Notify — perché esistono e contratti Action"
type: architecture
status: active
module: Notify
created: 2026-11-23
updated: 2026-11-23
tags:
  - notify
  - mail
  - mailjet
  - mailtrap
  - inbound
  - phpstan
qmd: "notify mail dependencies mailjet mailtrap zbateson inbound transport action contract phpstan"
related:
  - ./email/mailjet.md
  - ./mail-deliverability.md
  - ./composer-dependencies.md
  - ./stories/inbound-mail-pipeline.story.md
  - ./stories/mailtrap-sdk-bridge-study.story.md
  - ./bmad/stories/phpstan-mail-deps-remediation.story.md
  - ./00-index.md
---

# Dipendenze mail Notify — scopo e contratti

> **Gate note**: non supersede `composer-dependencies.md` né `email/mailjet.md`;
> li integra sul *perché* delle tre dipendenze mail e sui contratti Action.
> Link da: `00-index.md`, story `phpstan-mail-deps-remediation`,
> `composer-dependencies.md`.
> Istruzione utente: «Docs: aggiorna laravel/Modules/Notify/docs/ (kebab, frontmatter)
> spiegando perché le dipendenze mail esistono e il contratto Action.»

## Perché queste dipendenze

Notify è l'owner del canale email: outbound (trasporto + test deliverability) e inbound (webhook + parse MIME). Le librerie non sono “nice to have”: senza di esse le Action/command non possono tipizzare né eseguire il flusso reale.

| Package | Dichiarato in | Scopo business |
|---------|---------------|----------------|
| `symfony/mailjet-mailer` | `Modules/Notify/composer.json` (+ mirror root storico) | Trasporto Send API / SMTP Mailjet via `Mail::extend('mailjet')` |
| `zbateson/mail-mime-parser` | `Modules/Notify/composer.json` (merge-plugin) | Parse MIME raw su webhook inbound (Mailgun `body-mime`, RFC822) |
| `railsware/mailtrap-php` | `Modules/Notify/composer.json` (+ mirror root) | SDK invio + comandi `notify:test-mail` / `notify:test-mailtrap` per prove DNS/SPF/DKIM |

Regola generale: le dipendenze di dominio restano nel modulo (`composer-dependencies.md`); il merge-plugin le installa nel vendor root. I mirror root di Mailjet/Mailtrap esistono perché deliverability/tooling e bootstrap PHPStan hanno già fallito quando il package era solo “dichiarato” e non presente in vendor.

## Contratti Action / Command

### `CreateMailjetTransportAction`

- **Input**: API key/secret Mailjet, schema `api|smtp`, flag sandbox, HttpClient opzionale.
- **Output**: `Symfony\Component\Mailer\Transport\TransportInterface`.
- **Perché**: Laravel non ha driver Mailjet nativo; il bridge Symfony costruisce il DSN `mailjet+api` / `mailjet+smtp`.
- **Doc**: [email/mailjet.md](./email/mailjet.md).

### `ProcessInboundMailAction`

- **Input**: `Request` webhook + `provider` (postmark|mailgun|raw).
- **Output**: persistenza `InboundEmail` + JSON response; MIME → shape `InboundMailData`.
- **Perché**: unificare Postmark JSON, Mailgun form e MIME grezzo senza controller HTTP orfani.
- **Parser**: `MailMimeParser::parse(): IMessage`; header tipizzati con `IHeader`.
- **Doc**: [mail-deliverability.md](./mail-deliverability.md), story inbound.

### `SendTestMail` / `TestMailtrap`

- **Input**: `MAILTRAP_API_KEY` + recipient (argomento o `MAILTRAP_TEST_RECIPIENT`).
- **Output**: invio via `MailtrapClient::initSendingEmails(): EmailsSendApiInterface` + `MailtrapEmail`.
- **Perché**: prova operativa post-DNS; restano in Notify (non in `laravel/app/Console`).

## PHPStan: class.notFound vs stub

Se PHPStan segnala `MailjetTransportFactory` / `MailMimeParser` / `MailtrapEmail` “not found”, **non** aggiungere stub inventati:

1. Verificare `Modules/Notify/composer.json` `require`.
2. `composer show <package>` e `class_exists` via autoload.
3. Se manca in vendor: `composer update` / require (modulo + merge), non adapter fake.
4. I `mixed` sulle catene fluent (`->to()`, `->send()`) sono quasi sempre **cascata** del class.notFound, non tipi davvero mixed.

## Verifica mirata

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Notify
composer show symfony/mailjet-mailer zbateson/mail-mime-parser railsware/mailtrap-php
```

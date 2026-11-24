---
title: "Notify — remediation PHPStan dipendenze mail"
type: story
status: review
module: Notify
epic: quality
story_id: phpstan-mail-deps-remediation
created: 2026-11-23
updated: 2026-11-23
tags:
  - notify
  - phpstan
  - mailjet
  - mailtrap
  - inbound
qmd: "notify phpstan mailjet mailtrap zbateson mail-mime-parser class.notFound remediation"
related:
  - ./phpstan-conflict-markers-bootstrap.story.md
  - ./phpstan-modules-zero.story.md
  - ../../mail-provider-dependencies.md
  - ../../email/mailjet.md
  - ../../stories/inbound-mail-pipeline.story.md
---

# phpstan-mail-deps-remediation (Notify)

## Scopo / perché

Azzerare gli errori PHPStan su trasporto Mailjet, parse inbound MIME e comandi
Mailtrap. Lo scopo non è “far tacere PHPStan con stub”: è garantire che le
dipendenze mail reali siano installate e che le Action/command usino tipizzazione
stretta sul contratto di dominio (invio, ricezione, prova deliverability).

## Lock

`bashscripts/lock/lock.sh Notify phpstan-mail-deps-remediation`

## Diagnosi

Sorgente errori: report `/tmp/phpstan-modules.json` (path `base_trade_fila5`,
36 messaggi su 4 file). Pattern:

| File | Sintomo |
|------|---------|
| `CreateMailjetTransportAction` | `MailjetTransportFactory` class.notFound |
| `ProcessInboundMailAction` | `MailMimeParser` / `IMessage` class.notFound + mixed foreach/return |
| `SendTestMail` / `TestMailtrap` | `MailtrapEmail` / `MailtrapClient` class.notFound + mixed su `->to()`/`->send()` |

**Root cause**: cascata da simboli non risolti dall'analisi, non logica business
rotta. Su `base_ptvx_fila5` i package risultano già in `Modules/Notify/composer.json`,
presenti in vendor (`composer show` + `class_exists` OK). Full `Modules/Notify`
PHPStan: **0** errori prima del hardening tipografico.

**Non** si introducono stub locali: sarebbe debito che maschera un vendor incompleto.

## Azioni

1. Conferma dipendenze: `symfony/mailjet-mailer`, `zbateson/mail-mime-parser`,
   `railsware/mailtrap-php` (modulo + lock/vendor).
2. Hardening tipizzato:
   - Mailjet: factory → variabile + assert `TransportInterface`.
   - Inbound MIME: loop header con `IHeader` + `array<string, string>`.
   - Mailtrap commands: niente fluent chain su unknown class; variabili
     `$email` / `$client` tipizzate dal costruttore / return API.
3. Doc SSoT: `docs/mail-provider-dependencies.md` (perché esistono + contratti).
4. Verifica PHPStan mirata + Pest inbound/mail se disponibili.

## Acceptance criteria

1. [x] Diagnosi dep-missing-vs-stub documentata (dep reali, no stub).
2. [x] PHPStan sui 4 file + `Modules/Notify` a 0 errori.
3. [x] Docs kebab + frontmatter aggiornate.
4. [x] Story + `docs/sprint-status.yaml` key `Notify/phpstan-mail-deps-remediation`.
5. [x] Pest mirato: **skip documentato** — bootstrap rifiuta host
   `10.100.200.53` (`TestDatabaseGuard`); non toccare DB remoti da questa
   macchina (192.168.1.40). Rilanciare Pest su host CI/local allowlist.

## Esito verifica

- PHPStan 4 file + `Modules/Notify` full: **0 errori** (`[OK] No errors`).
- Package: `symfony/mailjet-mailer` v8.1.0, `zbateson/mail-mime-parser` 4.0.9,
  `railsware/mailtrap-php` 3.18.1 — `class_exists` OK.
- Nessuno stub locale introdotto.

## Debiti aperti

- Mirror root di Mailjet/Mailtrap vs regola “solo modulo” in
  `composer-dependencies.md` (incoerenza storica da riconciliare).
- Report `/tmp/phpstan-modules.json` cross-repo trade: rieseguire analisi
  fresca se altri agenti lavorano su trade.
- Pest Notify mail: sblocco solo con `DB_HOST` locale / `TEST_DB_ALLOWED_HOSTS`
  appropriato (non in questo ambiente).

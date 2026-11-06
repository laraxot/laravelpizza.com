---
title: "ponytail audit over engineering"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ponytail audit over engineering"
issues: []
discussions: []
status: stale
---

> Nota 2026-10-14 (docs-audit): Dichiara 8 Action SMS e 3 varianti Agiletelecom spostate in .php.bak; il 2026-10-14 app/ non ha alcun .bak tracciato e app/Actions/SMS/ contiene ancora quelle Action. Contenuto non riscritto, verificare prima di usarlo.

# Ponytail audit: Notify (over-engineering)

**Ultimo run:** 2026-07-02  
**Remediation run #5:** rimozione file inattivi e PHPStan pulito

| # | Azione | Stato |
|---|--------|-------|
| N5 | action SMS inattive, Data class, test, pagina Netfun rimossi | ✅ 2026-07-02 |
| N9 | `storage/app/ai/generate-notify-sms-tests.php` rimosso | ✅ 2026-07-02 |
| N10 | `app/Channels/SmsChannel/TelegramChannel/WhatsAppChannel`: rimossi `@var` inutili | ✅ 2026-07-02 |
|: | PHPStan `Modules/Notify` | ✅ 0 errori |
|: | Pest `Modules/Notify` | ❌ bloccato da DB MySQL (credenziali `.env.testing` non valide) |

**Ultimo run:** 2026-07-01  
**Remediation run #4:** consolidamento SMS su driver canonico `smsfactor`

| # | Azione | Stato |
|---|--------|-------|
| N1 | 8 action SMS inattive + test → `.php.bak` | ✅ |
| N2 | 3 varianti Agiletelecom → `.php.bak` | ✅ |
| N3 | `Contracts\SmsActionContract` root (duplicato) | ✅ eliminato |
| N4 | `SmsProviderContract` (0 impl) | ✅ eliminato |
| N6 | `Modules.bak/` | ✅ assente |
| N7 | `_bmad/`, `.planning/` sotto Notify | ✅ assenti |
| N8 | `scheduleNotification`: `SendScheduledPushNotification::dispatch()->delay()` | ✅ (no regressione) |

**Modulo:** notifiche multi-canale.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)  
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_quaeris_fila5/issues) · [Discussion #222](https://github.com/laraxot/base_quaeris_fila5/discussions) · [Discussion #228](https://github.com/laraxot/base_quaeris_fila5/discussions)

## Scopo business

Notify invia messaggi su canali configurati (email, SMS, push, …). Il driver attivo deve essere **uno per ambiente**; molti provider in codice senza uso in produzione è complessità senza valore.

## Driver SMS canonico

**`smsfactor`**: SSoT da `config/sms.php` (`default => smsfactor`).

Pattern attivo:

- `app/Contracts/SMS/SmsActionContract.php`
- `app/Factories/SmsActionFactory.php` → `SendSmsFactorSMSAction`
- `app/Actions/SMS/SendSmsFactorSMSAction.php`
- `app/Datas/SMS/SmsFactorData.php`
- `app/Enums/SmsDriverEnum` → solo case `SMSFACTOR`

Utility mantenute: `NormalizePhoneNumberAction`, `FormatSmsMessageAction`.

## File archiviati (`.php.bak`)

### Actions SMS inattive

- `SendTwilioSMSAction`, `SendNexmoSMSAction`, `SendPlivoSMSAction`, `SendGammuSMSAction`
- `SendNetfunSMSAction`, `SendAgiletelecomSMSAction`, `SendAgiletelecomSMSv1Action`, `SendAgiletelecomSMSv2Action`
- `NetfunSendAction` (duplicato logica netfun, sostituito da factory)

### Data class driver inattivi

- `TwilioData`, `NexmoData`, `PlivoData`, `GammuData`, `AgiletelecomData`

### Test correlati

- Tutti i `tests/Unit/Actions/SMS/Send{Driver}*Test.php` per driver rimossi
- `NetfunSendActionTest`, `TwilioDataTest`

### Filament test-only

- `SendNetfunSmsPage` (pagina dedicata netfun; `SendSmsPage` resta con enum a singolo driver)

## File eliminati

- `app/Contracts/SmsActionContract.php` (duplicato di `Contracts/SMS/SmsActionContract`)
- `app/Contracts/SmsProviderContract.php` (0 implementazioni)

## Refactor canali

- `app/Channels/NetfunChannel` → usa `SmsActionFactory` (non più `SendNetfunSMSAction`)
- `app/Notifications/Channels/NetfunChannel` → usa `SmsActionFactory` (non più `NetfunSendAction`)

## ⛔ Fuori perimetro (non tagliare)

| Area | Motivo |
|------|--------|
| `app/Models/Policies/*Policy.php` | Contratto Laravel/Filament per modello |

## Collegamenti

- [wiki/decisions/sms-actions-consolidation.md](./wiki/decisions/sms-actions-consolidation.md)
- [wiki/decisions/sms-actions-consolidation-consolidamento-contracts-ponytail-audit.md](./wiki/decisions/sms-actions-consolidation-consolidamento-contracts-ponytail-audit.md)
- [provider-actions-architecture.md](./provider-actions-architecture.md)
- [Xot Notify hub](../../Xot/docs/ponytail-audit-over-engineering.md)

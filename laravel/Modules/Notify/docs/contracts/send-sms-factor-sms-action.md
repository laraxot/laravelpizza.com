---
title: "SendSmsFactorSMSAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendSmsFactorSMSAction"
qmd: "SendSmsFactorSMSAction SMSFactor SMS token messages recipients invio"
---

# SendSmsFactorSMSAction

Invio SMS con l'API SMSFactor (`/messages`), header di autenticazione dal DTO.

## Input

- `SmsData $smsData`: `recipient`, `from`, `body`.
- Config `SmsFactorData`: `token` (obbligatorio), header di autenticazione, base URL, timeout.

## Output

- `array`: `status_code` e `status_txt`.

## Invarianti

- `NOTIFY-SMSFACTOR-INV-1`: senza token il costruttore lancia `Exception`. Test: `tests/Unit/Actions/SMS/SendSmsFactorSMSActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-SMSFACTOR-INV-2`: `00` diventa `+`; numero senza `+` riceve `+39`; tipo `sms`. Stesso test.

## Effetti collaterali

- POST HTTP sincrono.

## Errori

- `ClientException` riscritta come `Exception`.

## Non fa

- Non verifica l'esito nel corpo della risposta.

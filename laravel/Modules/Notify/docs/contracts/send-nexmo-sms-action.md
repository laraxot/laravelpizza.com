---
title: "SendNexmoSMSAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendNexmoSMSAction"
qmd: "SendNexmoSMSAction Nexmo Vonage SMS sms json api_key form unicode prefisso 39"
---

# SendNexmoSMSAction

Invio SMS con l'API Nexmo (`/sms/json`), chiavi in form.

## Input

- `SmsData $smsData`: `recipient`, `from`, `body`.
- Config `NexmoData`: `key`, `secret`, base URL, timeout.

## Output

- `array`: `status_code` e `status_txt` (corpo grezzo).

## Invarianti

- `NOTIFY-NEXMO-INV-1`: costruzione senza key o secret lancia `Exception`. Test: `tests/Unit/Actions/SMS/SendNexmoSMSActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-NEXMO-INV-2`: `00` diventa `+`; numero senza `+` riceve `+39`. Stesso test.
- `NOTIFY-NEXMO-INV-3`: il tipo di messaggio e' sempre `unicode`. Stesso test.

## Effetti collaterali

- POST HTTP sincrono con credenziali nel form.

## Errori

- `ClientException` riscritta come `Exception`.

## Non fa

- Non legge lo stato del messaggio nel corpo JSON (`messages[].status`): un HTTP 200 con SMS rifiutato risulta riuscito.

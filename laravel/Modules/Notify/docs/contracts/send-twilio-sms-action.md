---
title: "SendTwilioSMSAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendTwilioSMSAction"
qmd: "SendTwilioSMSAction Twilio SMS account_sid form invio prefisso 00 39"
---

# SendTwilioSMSAction

Invio SMS con l'API Twilio (`Messages.json`), form POST con basic auth.

## Input

- `SmsData $smsData`: `recipient`, `from`, `body`.
- Config `TwilioData`: `account_sid`, `auth_token`, base URL, timeout.

## Output

- `array`: `status_code` e `status_txt`.

## Invarianti

- `NOTIFY-TWILIOSMS-INV-1`: senza `account_sid` o `auth_token` il costruttore lancia `Exception`. Test: `tests/Unit/Actions/SMS/SendTwilioSMSActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-TWILIOSMS-INV-2`: numero senza `+` riceve `+39`. Stesso test.

## Effetti collaterali

- POST HTTP sincrono.

## Errori

- `ClientException` riscritta come `Exception`.

## Bug rilevato (da correggere, non corretto qui)

- Riga 65: un numero che inizia con `00` diventa `'+39' + resto`. Per `0044...` si ottiene `+3944...`, numero errato. Le altre Action SMS usano `'+' + resto` (vedi Nexmo, Plivo, SMSFactor).

## Non fa

- Non verifica l'esito nel corpo della risposta.

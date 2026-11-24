---
title: "SendPlivoSMSAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendPlivoSMSAction"
qmd: "SendPlivoSMSAction Plivo SMS auth_id Message JSON src dst invio"
---

# SendPlivoSMSAction

Invio SMS con l'API Plivo (`/v1/Account/<auth_id>/Message/`).

## Input

- `SmsData $smsData`: `recipient`, `from`, `body`.
- Config `PlivoData`: `auth_id`, `auth_token`, base URL, timeout.

## Output

- `array`: `status_code` e `status_txt`.

## Invarianti

- `NOTIFY-PLIVO-INV-1`: senza `auth_id` o `auth_token` il costruttore lancia `Exception`. Test: `tests/Unit/Actions/SMS/SendPlivoSMSActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-PLIVO-INV-2`: `00` diventa `+`; numero senza `+` riceve `+39`. Stesso test.
- `NOTIFY-PLIVO-INV-3`: mittente `from` oppure default `sms.from`. Stesso test.

## Effetti collaterali

- POST HTTP sincrono con basic auth.

## Errori

- `ClientException` riscritta come `Exception`.

## Non fa

- Non verifica lo stato del messaggio nella risposta.

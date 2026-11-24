---
title: "SendAgiletelecomSMSv1Action — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendAgiletelecomSMSv1Action"
qmd: "SendAgiletelecomSMSv1Action Agiletelecom SMS v1 securesend form timeout gateway"
---

# SendAgiletelecomSMSv1Action

Invio SMS Agiletelecom con l'API legacy `securesend_v1.aspx` (POST a form).

## Input

- `SmsData $data`: `recipient` (normalizzato), `body`.
- `AgiletelecomData`: `sender`, `username`, `password`.

## Output

- `array`: sempre `[]`.

## Invarianti

- `NOTIFY-AGILEV1-INV-1`: il numero passa da `SMS\NormalizePhoneNumberAction`. Test: `tests/Unit/Actions/SMS/SendAgiletelecomSMSv1ActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-AGILEV1-INV-2`: timeout della richiesta 2 secondi (riga 45); gateway `H` (qualita' alta). Stesso test.

## Effetti collaterali

- POST HTTP sincrono con credenziali nel form.

## Errori

- Le eccezioni Guzzle (incluse 4xx/5xx, perche' Guzzle lancia per default) propagano.

## Non fa

- Non legge la risposta: il successo dell'invio non e' verificato. Il valore di ritorno `[]` non dice nulla sull'esito.

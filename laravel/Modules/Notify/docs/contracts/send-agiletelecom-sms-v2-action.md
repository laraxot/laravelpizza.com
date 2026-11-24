---
title: "SendAgiletelecomSMSv2Action — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendAgiletelecomSMSv2Action"
qmd: "SendAgiletelecomSMSv2Action Agiletelecom SMS v2 REST Http facade auth headers messaggi"
---

# SendAgiletelecomSMSv2Action

Invio SMS Agiletelecom con l'API REST v2 (`services/sms/send`), via Http facade.

## Input

- `SmsData $data`: `recipient` (normalizzato), `body`.
- `AgiletelecomData`: `sender`, `getAuthHeaders()`, `timeout`.

## Output

- `array`: sempre `[]`.

## Invarianti

- `NOTIFY-AGILEV2-INV-1`: il payload ha un solo messaggio con `destinations`, `sender`, `body`. Test: `tests/Unit/Actions/SMS/SendAgiletelecomSMSv2ActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-AGILEV2-INV-2`: timeout dalla configurazione del DTO. Stesso test.

## Effetti collaterali

- POST HTTP sincrono.

## Errori

- Nessuno: l'Http facade non lancia su 4xx/5xx senza `->throw()`.

## Non fa

- Non controlla lo stato della risposta: un errore del provider viene ignorato e il chiamante riceve `[]` come in caso di successo.

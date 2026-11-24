---
title: "SendAgiletelecomSMSAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendAgiletelecomSMSAction"
qmd: "SendAgiletelecomSMSAction Agiletelecom SMS wrapper v2 invio"
---

# SendAgiletelecomSMSAction

Punto di ingresso per Agiletelecom: delega interamente a `SendAgiletelecomSMSv2Action`.

## Input

- `SmsData $data`.

## Output

- `array`: quello di `SendAgiletelecomSMSv2Action` (oggi sempre `[]`).

## Invarianti

- `NOTIFY-AGILE-INV-1`: ogni chiamata viene inoltrata a v2 con gli stessi dati. Test: `tests/Unit/Actions/SMS/SendAgiletelecomSMSActionTest.php` (dedicato, asserti non verificati).

## Effetti collaterali

- Quelli di v2 (vedi la sua scheda).

## Errori

- Quelli di v2.

## Non fa

- Non sceglie la versione: v1 non e' raggiungibile da qui.

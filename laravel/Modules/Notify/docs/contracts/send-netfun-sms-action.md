---
title: "SendNetfunSMSAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendNetfunSMSAction"
qmd: "SendNetfunSMSAction Netfun SMS sms-batch async token redatto log daily esito JSON error"
---

# SendNetfunSMSAction

Invio SMS via Netfun (`sms-batch.json`, modalita' asincrona), con controllo dell'esito nel corpo della risposta.

## Input

- `SmsData $smsData`: `recipient` (normalizzato), `from`, `body` (tag HTML rimossi).
- Config `sms.drivers.netfun` (token, endpoint), `sms.from`, `sms.timeout`.

## Output

- `array`: `status_code`, `status_txt`.

## Invarianti

- `NOTIFY-NETFUNSMS-INV-1`: senza token stringa il costruttore lancia `Exception`. Test: `tests/Unit/Actions/SMS/SendNetfunSMSActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-NETFUNSMS-INV-2`: l'invio e' asincrono (`async = true`) e usa `utf8_enabled`. Stesso test.
- `NOTIFY-NETFUNSMS-INV-3`: l'esito e' successo solo con HTTP 2xx, JSON array e campo `error` assente o zero. Altrimenti si logga un errore sul canale `daily` con il token redatto. Stesso test.
- `NOTIFY-NETFUNSMS-INV-4`: un errore non successo non lancia: il ritorno contiene lo stato e il chiamante deve leggerlo. Stesso test.

## Effetti collaterali

- POST HTTP sincrono.
- `Log::channel('daily')->error` solo in caso di esito non positivo.

## Errori

- `ClientException` (4xx) riscritta come `Exception`. Errori 5xx propagano come Guzzle.

## Non fa

- Non lancia su esito negativo: il chiamante non riceve un errore per un SMS rifiutato (vedi INV-4).

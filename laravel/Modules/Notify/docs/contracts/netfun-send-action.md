---
title: "NetfunSendAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\NetfunSendAction"
qmd: "NetfunSendAction netfun SMS sms-batch smsviainternet token legacy invio"
---

# NetfunSendAction

Variante legacy di invio SMS Netfun (endpoint `sms-batch.json`), sostituita da `SMS\SendNetfunSMSAction`.

## Input

- `SmsData $smsData`: `recipient`, `from`, `body`. Il `recipient` viene modificato in place.
- Config: `services.netfun.token` (obbligatorio, costruttore).

## Output

- `array`: `['status_code' => int, 'status_txt' => string]` (da `$this->vars`).

## Invarianti

- `NOTIFY-NETFUNLEGACY-INV-1`: il numero e' normalizzato: prefisso `00` diventa `+39`, numero senza `+` riceve `+39`. Test: `tests/Unit/Actions/NetfunSendActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-NETFUNLEGACY-INV-2`: il body inviato usa `api_token` dalla config e `sender = $smsData->from` (nessun fallback al mittente di default). Stesso test.
- `NOTIFY-NETFUNLEGACY-INV-3`: lo stato HTTP viene ritornato senza controllo di successo. Stesso test.

## Effetti collaterali

- Muta `$smsData->recipient` (effetto visibile al chiamante).
- POST HTTP sincrono (`Content-Type: application/json`), nessun log, nessuna scrittura locale.

## Errori

- Costruttore: `Exception` se il token non e' una stringa.
- `ClientException` di Guzzle riscritta come `Exception` con marker di riga e classe. Gli errori 5xx propagano come Guzzle.

## Non fa

- Non ha `async`, `utf8_enabled` ne' `destinations` attivi: il blocco e' commentato nel sorgente.
- Non valida l'esito del provider nel corpo della risposta (a differenza di `SMS\SendNetfunSMSAction`).
- Duplica `SMS\SendNetfunSMSAction`: candidata a rimozione dopo verifica dei chiamanti.

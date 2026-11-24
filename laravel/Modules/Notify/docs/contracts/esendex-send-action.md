---
title: "EsendexSendAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\EsendexSendAction"
qmd: "EsendexSendAction esendex SMS login user_key Session_key curl messaggissima invio sms"
---

# EsendexSendAction

Invia un SMS tramite le REST API Esendex (login, poi POST su `sms`) usando cURL diretto.

## Input

- `SmsData $smsData`: `recipient` (array con un numero), `body`.
- Config: `esendex.username`, `esendex.password`, `esendex.sender` (asserite stringhe in `login()`).

## Output

- `array`: il JSON decodificato della risposta quando HTTP 201; `[]` quando HTTP diverso da 201.

## Invarianti

- `NOTIFY-ESENDEX-INV-1`: senza login valido (HTTP diverso da 200) lancia `Exception`. Test: `tests/Unit/Actions/EsendexSendActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-ESENDEX-INV-2`: la risposta di invio e' accettata solo con HTTP 201; altrimenti ritorna `[]` senza eccezione. Stesso test.
- `NOTIFY-ESENDEX-INV-3`: la risposta 201 non decodificabile come array lancia `Exception`. Test: nessuno dedicato verificato.

## Effetti collaterali

- Due richieste HTTP sincrone: GET `login?username=...&password=...`, poi POST `sms` con header `user_key` e `Session_key`.
- Nessuna scrittura locale, nessun evento, nessuna coda.

## Errori

- `Exception` su login fallito o JSON non array.
- `JsonException` se la codifica/decodifica JSON fallisce (JSON_THROW_ON_ERROR).
- Errori di Assert su config mancante.

## Non fa

- Non verifica il `status` dei messaggi restituito da Esendex.
- Non usa retry.

## Rischi rilevati (da correggere, non corretti qui)

- SSL disattivato: `CURLOPT_SSL_VERIFYPEER = false` su login (riga 83) e invio (riga 47). Il traffico con credenziali non e' verificato.
- Credenziali nella query string del login (riga 88): finiscono in access log e in eventuali log di proxy.

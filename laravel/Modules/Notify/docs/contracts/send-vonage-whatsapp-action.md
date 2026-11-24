---
title: "SendVonageWhatsAppAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\WhatsApp\\SendVonageWhatsAppAction"
qmd: "SendVonageWhatsAppAction WhatsApp Vonage Nexmo messages JSON template media file api_key secret"
---

# SendVonageWhatsAppAction

Invio WhatsApp via Vonage Messages API (`/v1/messages`), JSON con basic auth key/secret.

## Input

- `WhatsAppData $whatsAppData`: `recipient`, `from` (opzionale), `body`, `type` (`text`, `template`, `media`), `template`, `media`.
- Config: `services.vonage.api_key` e `api_secret` (obbligatori), `whatsapp.from`, `whatsapp.timeout`.

## Output

- `['success' => 2xx, 'message_id' => message_uuid, 'response', 'vars']`; su 4xx `['success' => false, 'error' => title, 'status_code', 'vars']`.

## Invarianti

- `NOTIFY-VONAGEWA-INV-1`: il contenuto e' testo per default; con `media` il tipo e' `image`, `video`, `audio` o `file` dall'estensione; con `template` il contenuto e' il template. Test: `tests/Unit/Actions/WhatsApp/SendVonageWhatsAppActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-VONAGEWA-INV-2`: senza api key o secret stringa il costruttore lancia `Exception`. Stesso test.
- `NOTIFY-VONAGEWA-INV-3`: l'errore leggibile e' `title`, default `Errore sconosciuto`. Stesso test.

## Effetti collaterali

- POST HTTP sincrono; log `debug` / `warning`.

## Errori

- `Exception` su config mancante. 4xx come risultato; altro propaga.

## Non fa

- Il mittente non riceve il prefisso `whatsapp:`: l'Action assume che `from` sia gia' nel formato accettato da Vonage.
- Non controlla l'esito oltre allo stato HTTP 2xx.

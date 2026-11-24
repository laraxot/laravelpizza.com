---
title: "SendTwilioWhatsAppAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\WhatsApp\\SendTwilioWhatsAppAction"
qmd: "SendTwilioWhatsAppAction WhatsApp Twilio Messages.json whatsapp: MediaUrl form sid"
---

# SendTwilioWhatsAppAction

Invio WhatsApp via Twilio (`Messages.json`), form POST con basic auth; prefisso `whatsapp:` su mittente e destinatario.

## Input

- `WhatsAppData $whatsAppData`: `recipient`, `from` (opzionale), `body`, `media` (opzionale).
- Config: `services.twilio.account_sid` e `auth_token` (obbligatori), `whatsapp.from` (mittente di default), `whatsapp.timeout`.

## Output

- `['success' => 2xx, 'message_id' => sid, 'response', 'vars']`; su 4xx `['success' => false, 'error' => message, 'status_code', 'vars']`.

## Invarianti

- `NOTIFY-TWWA-INV-1`: `To` e `From` hanno prefisso `whatsapp:`; `From` usa `from` o il default. Test: `tests/Unit/Actions/WhatsApp/SendTwilioWhatsAppActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-TWWA-INV-2`: se c'e' un media, il primo va in `MediaUrl`. Stesso test.
- `NOTIFY-TWWA-INV-3`: senza account SID o auth token stringa il costruttore lancia `Exception`. Stesso test.

## Effetti collaterali

- POST HTTP sincrono; log `debug` / `warning`.

## Errori

- `Exception` su config mancante. 4xx come risultato; altro propaga.

## Non fa

- Non valida il formato del mittente: se `from` e il default sono entrambi nulli, invia `whatsapp:` vuoto.
- Non controlla il tipo del messaggio: `MediaUrl` e `Body` vengono inviati insieme se presenti.

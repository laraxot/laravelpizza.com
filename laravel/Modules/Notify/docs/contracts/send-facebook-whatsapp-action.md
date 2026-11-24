---
title: "SendFacebookWhatsAppAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\WhatsApp\\SendFacebookWhatsAppAction"
qmd: "SendFacebookWhatsAppAction WhatsApp Meta Graph API phone_number_id access token messages"
---

# SendFacebookWhatsAppAction

Invio WhatsApp via Graph API di Meta (`/<phone_number_id>/messages`, versione v17.0).

## Input

- `WhatsAppData $whatsAppData`: `recipient`, `type`, `body`, `template`, `media`.
- Config: `services.facebook.access_token` e `services.facebook.phone_number_id` (obbligatori), `whatsapp.timeout`, `whatsapp.debug`.

## Output

- `['success' => 2xx, 'message_id', 'response', 'vars']`; su 4xx `['success' => false, 'error', 'status_code', 'vars']`.

## Invarianti

- `NOTIFY-FBWA-INV-1`: `text` invia testo senza anteprima link; `template` invia il DTO; `media` invia sempre tipo `image`. Test: `tests/Unit/Actions/WhatsApp/SendFacebookWhatsAppActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-FBWA-INV-2`: senza access token o phone number id stringa il costruttore lancia `Exception`. Stesso test.
- `NOTIFY-FBWA-INV-3`: `error.message` e' l'errore leggibile, default `Errore sconosciuto`. Stesso test.

## Effetti collaterali

- POST HTTP sincrono con `Authorization: Bearer`; log `debug` / `warning`.

## Errori

- `Exception` su config mancante. 4xx come risultato; altro propaga.

## Differenze rispetto alle altre WhatsApp

- Il timeout non passa da `SafeIntCastAction`: usa `is_numeric` con default 30.
- Il tipo media e' sempre `image`, anche per PDF o video: il commento nel codice lo dichiara (`o video, document, audio`) ma non lo implementa.

## Non fa

- Non legge l'estensione del media.

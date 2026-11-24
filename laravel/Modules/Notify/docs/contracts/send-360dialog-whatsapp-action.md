---
title: "Send360dialogWhatsAppAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\WhatsApp\\Send360dialogWhatsAppAction"
qmd: "Send360dialogWhatsAppAction WhatsApp 360dialog D360-API-KEY messages template media text"
---

# Send360dialogWhatsAppAction

Invio WhatsApp via API 360dialog (`/v1/messages`), con header `D360-API-KEY`.

## Input

- `WhatsAppData $whatsAppData`: `recipient`, `type` (`text`, `template`, `media`), `body`, `template`, `media`.
- Config: `services.360dialog.api_key` (obbligatorio), `whatsapp.timeout`, `whatsapp.debug`.

## Output

- `['success' => 2xx, 'message_id', 'response', 'vars']` in successo; `['success' => false, 'error', 'status_code', 'vars']` su 4xx.

## Invarianti

- `NOTIFY-360D-INV-1`: `text` invia `text.body`; `template` invia il DTO template; `media` determina il tipo dall'estensione (`image`, `video`, `audio`, altrimenti `document`). Test: `tests/Unit/Actions/WhatsApp/Send360dialogWhatsAppActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-360D-INV-2`: senza api key stringa il costruttore lancia `Exception`. Stesso test.
- `NOTIFY-360D-INV-3`: `message_id` e' il primo `messages[0].id` stringa, altrimenti `null`. Stesso test.
- `NOTIFY-360D-INV-4`: l'errore leggibile e' `errors[0].message`, default `Errore sconosciuto`. Stesso test.

## Effetti collaterali

- POST HTTP sincrono; log `debug` / `warning`; `$this->vars` accumulato.

## Errori

- `Exception` su api key mancante. 4xx come risultato; 5xx e rete propagano.

## Non fa

- Se il tipo non corrisponde a un ramo (es. `template` vuoto), il payload resta senza `type`: la chiamata parte e il provider risponde con errore.
- Non invia `$whatsAppData->from`: il mittente e' quello del numero 360dialog.

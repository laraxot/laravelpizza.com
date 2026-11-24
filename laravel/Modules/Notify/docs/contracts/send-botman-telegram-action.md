---
title: "SendBotmanTelegramAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Telegram\\SendBotmanTelegramAction"
qmd: "SendBotmanTelegramAction Telegram BotMan Bot API sendMessage sendPhoto token messaggio"
---

# SendBotmanTelegramAction

Invio messaggio Telegram via Bot API (HTTP diretto con Guzzle), variante con la gestione del corpo non JSON piu' tollerante.

## Input

- `TelegramData $telegramData`: `type` (`text`, `photo`, `video`, `document`, `audio`, `animation`; altro = `sendMessage`), `chatId`, `text`, `media`, `parseMode`, `disableWebPagePreview`, `disableNotification`, `replyToMessageId`, `replyMarkup`.
- Config: `services.telegram.token` (obbligatorio nel costruttore), `services.telegram.api_url`, `telegram.parse_mode`, `telegram.timeout`.

## Output

- Successo HTTP: `['success' => ok === true, 'message_id', 'response', 'vars']`.
- Errore 4xx: `['success' => false, 'error', 'error_code', 'status_code', 'vars']`.

## Invarianti

- `NOTIFY-TGBOT-INV-1`: l'endpoint dipende dal tipo; `text` usa `sendMessage` con `text`, `parse_mode`, `disable_web_page_preview`. Test: `tests/Unit/Actions/Telegram/SendBotmanTelegramActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-TGBOT-INV-2`: per i tipi media con `media` non vuoto il payload ha `<tipo> = media[0]` e `caption = text`. Stesso test.
- `NOTIFY-TGBOT-INV-3`: senza token stringa il costruttore lancia `Exception`. Stesso test.
- `NOTIFY-TGBOT-INV-4`: solo gli errori 4xx (`ClientException`) diventano risultato; altri errori propagano. Stesso test.

## Effetti collaterali

- POST HTTP sincrono verso l'API Telegram; `Log::debug` in successo, `Log::warning` in 4xx.
- Stato interno: `$this->vars` si accumula tra chiamate sulla stessa istanza.

## Errori

- `Exception` su token mancante (costruttore).
- 4xx: risultato con `success = false`; 5xx e errori di rete propagano.

## Rischi rilevati

- `vars['error_message']` contiene `$e->getMessage()` di Guzzle, che include l'URL della richiesta con il token del bot (`/bot<TOKEN>/...`). Il valore esce nel risultato, nel campo `vars`. Da verificare sul messaggio reale e da ripulire prima di loggare o restituire.

## Non fa

- Non ritenta.
- Il campo `debug` e' letto ma non usato.

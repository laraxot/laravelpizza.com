---
title: "SendNutgramTelegramAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Telegram\\SendNutgramTelegramAction"
qmd: "SendNutgramTelegramAction Telegram Nutgram Bot API sendMessage token messaggio"
---

# SendNutgramTelegramAction

Invio messaggio Telegram via Bot API (HTTP diretto con Guzzle). Stesso flusso di `SendBotmanTelegramAction`, con qualche differenza nella gestione dei tipi di risposta.

## Input

- `TelegramData $telegramData`: come [send-botman-telegram-action](send-botman-telegram-action.md).
- Config: come [send-botman-telegram-action](send-botman-telegram-action.md).

## Output

- Successo HTTP: `['success' => ok === true, 'message_id', 'response', 'vars']`.
- Errore 4xx: `['success' => false, 'error', 'error_code', 'status_code', 'vars']`.

## Invarianti

- `NOTIFY-TGNUT-INV-1`: endpoint e payload come per Botman (`sendMessage` per testo, media con `media[0]` e `caption`). Test: `tests/Unit/Actions/Telegram/SendNutgramTelegramActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-TGNUT-INV-2`: senza token stringa il costruttore lancia `Exception`. Stesso test.
- `NOTIFY-TGNUT-INV-3`: solo `ClientException` diventa risultato; altri errori propagano. Stesso test.

## Effetti collaterali

- POST HTTP sincrono; `Log::debug` / `Log::warning`; `$this->vars` accumulato sull'istanza.

## Errori

- `Exception` su token mancante. 4xx come risultato, 5xx e rete propagano.

## Differenze rispetto a Botman

- `json_decode` senza fallback: un corpo non JSON rende `response = null`.
- Campi errore letti con `??` senza verifica di tipo: `error` e `error_code` possono essere valori non stringa.

## Rischi rilevati

- Stesso di Botman: `vars['error_message']` contiene l'URL con il token del bot.

## Non fa

- Non ritenta.

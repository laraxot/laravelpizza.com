---
title: "SendOfficialTelegramAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Telegram\\SendOfficialTelegramAction"
qmd: "SendOfficialTelegramAction Telegram Bot API ufficiale sendMessage token messaggio"
---

# SendOfficialTelegramAction

Invio messaggio Telegram via Bot API (HTTP diretto con Guzzle). Terza variante del flusso Telegram, con la stessa logica di `SendNutgramTelegramAction`.

## Input

- `TelegramData $telegramData`: come [send-botman-telegram-action](send-botman-telegram-action.md).
- Config: come [send-botman-telegram-action](send-botman-telegram-action.md).

## Output

- Successo HTTP: `['success' => ok === true, 'message_id', 'response', 'vars']`.
- Errore 4xx: `['success' => false, 'error', 'error_code', 'status_code', 'vars']`.

## Invarianti

- `NOTIFY-TGOFF-INV-1`: endpoint e payload come per Botman. Test: `tests/Unit/Actions/Telegram/SendOfficialTelegramActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-TGOFF-INV-2`: senza token stringa il costruttore lancia `Exception`. Stesso test.
- `NOTIFY-TGOFF-INV-3`: solo `ClientException` diventa risultato. Stesso test; anche `tests/Unit/Factories/ActionFactoriesTest.php` la istanzia.

## Effetti collaterali

- POST HTTP sincrono; log `debug` / `warning`; `$this->vars` accumulato sull'istanza.

## Errori

- Come Nutgram.

## Rischi rilevati

- Come Botman: `vars['error_message']` contiene l'URL con il token.

## Non fa

- Non ritenta. Non distingue il tipo di bot: il nome non dice quale libreria usa (nessuna dipendenza usata qui).

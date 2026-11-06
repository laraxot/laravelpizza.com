---
title: "Notify Module: Document"
type: docs/bmad
module: Notify
scope: documentation
bmad_version: 1.0
updated: 2026-10-06
tags: [docs, notify, wiki]
qmd: "telegram notify"
status: superseded
superseded_by: ../../-integration/telegram.md
---

# telegram

<!-- Contenuto migrato da _docs/telegram.txt -->

https://dev.to/millykhamroev/laravel-package-to-integrate-telegram-bot-api-3l6e

https://medium.com/modulr/send-telegram-notifications-with-laravel-9-342cc87b406


Add telegram service into config/service.php file.

# config/services.php

'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE')
],


--- TUTORIAL ---
https://abstractentropy.com/laravel-notifications-telegram-bot/

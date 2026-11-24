---
title: "telegram 1"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "telegram 1"
issues: []
discussions: []
---

https://dev.to/millykhamroev/laravel-package-to-integrate-telegram-bot-api-3l6e

https://medium.com/modulr/send-telegram-notifications-with-laravel-9-342cc87b406


Add telegram service into config/service.php file.

# config/services.php

'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE')
],


--- TUTORIAL ---
https://abstractentropy.com/laravel-notifications-telegram-bot/

---
qmd: "composer dependencies"
issues: []
discussions: []
title: "Composer Dependencies - Modulo Notify"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
---

# Composer Dependencies - Modulo Notify

## Regola

Le dipendenze specifiche per notifiche (Firebase, FCM, Telegram, ecc.) vanno in `Modules/Notify/composer.json`, **mai** nel root `laravel/composer.json`.

## Package Notify

| Package | Versione | Uso |
|---------|----------|-----|
| `kreait/firebase-php` | ^8.1 | SDK Firebase PHP |
| `kreait/laravel-firebase` | ^7.0 | Integrazione Laravel Firebase |
| `laravel-notification-channels/fcm` | ^6.0 | Canale FCM per notifiche push |
| `laravel-notification-channels/telegram` | * | Canale Telegram |
| `irazasyed/telegram-bot-sdk` | * | SDK Telegram |
| `spatie/laravel-database-mail-templates` | * | Template email DB |
| `aws/aws-sdk-php` | * | SES, SNS |
| `symfony/postmark-mailer` | * | Postmark |

## Motivazione

- **Encapsulation**: Ogni modulo dichiara le proprie dipendenze
- **Root pulito**: `laravel/composer.json` solo per core (nwidart/laravel-modules)
- **Merge plugin**: `wikimedia/composer-merge-plugin` unisce `Modules/*/composer.json`

## Riferimenti

- [Composer Module Dependency Management](../../Xot/docs/composer-module-dependency-management.md)
- [composer-merge-plugin](../../../../docs/composer-merge-plugin.md)

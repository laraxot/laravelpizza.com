# Telegram Bot Integration

## Resources
- [Laravel Package to Integrate Telegram Bot API](https://dev.to/millykhamroev/laravel-package-to-integrate-telegram-bot-api-3l6e)
- [Send Telegram Notifications with Laravel 9](https://medium.com/modulr/send-telegram-notifications-with-laravel-9-342cc87b406)

## Configuration

Add telegram service into config/service.php file.

```php
// config/services.php
'telegram-bot-api' => [
    'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE')
],
```

## Tutorial
- [Laravel Notifications Telegram Bot](https://abstractentropy.com/laravel-notifications-telegram-bot/)

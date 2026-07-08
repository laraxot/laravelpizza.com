<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;

// use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhook extends Command
{
    protected $signature = 'telegram:set-webhook';

    protected $description = 'Set Telegram webhook URL';

    public function handle(): void
    {
        // Telegram::setWebhook(['url' => 'https://2c0f-79-20-174-54.ngrok-free.app/api/telegram/webhook']);
    }
}

<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

/**
 * Class NotificationData - Gestisce la configurazione delle notifiche per il framework Laraxot.
 * Utilizzato esclusivamente nell'ambito dell'architettura Filament-first.
 *
 * @phpstan-consistent-constructor
 */
class NotificationData extends Data
{
    /**
     * @param array<mixed> $channels        Canali di notifica disponibili
     * @param string       $default_channel Canale predefinito
     * @param bool         $queue           Se accodare le notifiche
     * @param array<mixed> $mail            Configurazione email di notifica
     * @param array<mixed> $broadcast       Configurazione broadcast
     * @param array<mixed> $slack           Configurazione Slack
     * @param array<mixed> $telegram        Configurazione Telegram
     */
    public function __construct(
        public readonly array $channels = ['mail', 'database'],
        public readonly string $default_channel = 'mail',
        public readonly bool $queue = true,
        public readonly array $mail = [
            'template' => 'mail.notification',
            'from' => [
                'address' => 'noreply@example.com',
                'name' => 'Laraxot App',
            ],
        ],
        public readonly array $broadcast = [
            'driver' => 'pusher',
            'app_id' => '',
            'app_key' => '',
            'app_secret' => '',
            'options' => [
                'cluster' => 'eu',
                'encrypted' => true,
            ],
        ],
        public readonly array $slack = [
            'webhook_url' => '',
        ],
        public readonly array $telegram = [
            'bot_token' => '',
            'chat_id' => '',
        ],
    ) {
    }

    /**
     * Create a new instance of NotificationData with default values.
     */
    public static function make(): self
    {
        return new self();
    }
}

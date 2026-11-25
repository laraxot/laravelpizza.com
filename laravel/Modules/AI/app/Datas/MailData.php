<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

/**
 * Class MailData - Gestisce la configurazione delle email.
 * Utilizzato nel contesto dell'architettura Filament-first.
 *
 * @phpstan-consistent-constructor
 */
final class MailData extends Data
{
    /**
     * @param  array<string, int|string>  $smtpConfig
     * @param  array<string, string>  $fromConfig
     */
    public function __construct(
        public readonly string $driver = 'smtp',
        public readonly array $smtpConfig = [
            'host' => 'smtp.mailtrap.io',
            'port' => 2525,
            'encryption' => 'tls',
            'username' => '',
            'password' => '',
        ],
        public readonly array $fromConfig = [
            'address' => 'no-reply@example.com',
            'name' => 'Laraxot App',
        ],
        public readonly ?string $replyTo = null,
        public readonly bool $verifyPeer = true,
    ) {}

    /**
     * Create a new instance of MailData with default values.
     */
    public static function make(): self
    {
        return new self;
    }
}

<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

/**
 * Class MailData - Gestisce la configurazione delle email per il framework Laraxot.
 * Utilizzato nel contesto dell'architettura Filament-first senza controller tradizionali.
 */
class MailData extends Data
{
    /**
     * @param  string  $driver  Driver per l'invio delle email
     * @param  string  $host  Host SMTP
     * @param  int  $port  Porta SMTP
     * @param  string  $encryption  Tipo di encryption (tls, ssl)
     * @param  string  $username  Username SMTP
     * @param  string  $password  Password SMTP
     * @param  string  $from_address  Indirizzo mittente
     * @param  string  $from_name  Nome mittente
     * @param  string|null  $reply_to  Indirizzo per le risposte
     * @param  bool  $verify_peer  Verifica certificato peer SSL
     */
    public function __construct(
        public readonly string $driver = 'smtp',
        public readonly string $host = 'smtp.mailtrap.io',
        public readonly int $port = 2525,
        public readonly string $encryption = 'tls',
        public readonly string $username = '',
        public readonly string $password = '',
        public readonly string $from_address = 'no-reply@example.com',
        public readonly string $from_name = 'Laraxot App',
        public readonly ?string $reply_to = null,
        public readonly bool $verify_peer = true,
    ) {}

    /**
     * Create a new instance of MailData with default values.
     */
    public static function make(): static
    {
        return new static;
    }
}

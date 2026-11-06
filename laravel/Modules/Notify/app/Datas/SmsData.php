<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

/**
 * Dati di un messaggio SMS: mittente, destinatario e corpo.
 *
 * Istanziare con `SmsData::from([...])` (costruttore magico fornito da
 * `Spatie\LaravelData\Data`), passando le chiavi `from`, `recipient`, `body`.
 * Le chiavi assenti restano stringa vuota.
 */
final class SmsData extends Data
{
    public function __construct(
        public string $from = '',
        public string $recipient = '',
        public string $body = '',
    ) {}
}

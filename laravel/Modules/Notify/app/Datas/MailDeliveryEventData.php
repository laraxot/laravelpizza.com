<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Carbon\CarbonImmutable;

/**
 * Esito di un'email riferito da un provider (oggi Mailjet) via webhook, in forma indipendente dal provider.
 *
 * `type`: sent | delivered | open | click | bounce | blocked | spam | unsub (nomi Mailjet).
 * `permanent`: l'indirizzo non va piu' usato (hard bounce, bloccato, segnalato come spam, disiscritto).
 */
final readonly class MailDeliveryEventData
{
    /**
     * @param  array<string, mixed>  $raw  evento originale del provider
     */
    public function __construct(
        public string $provider,
        public string $type,
        public string $email,
        public CarbonImmutable $at,
        public ?string $messageId,
        public ?string $customId,
        public ?string $payload,
        public ?string $reason,
        public bool $permanent,
        public array $raw,
    ) {}

    public function isFailure(): bool
    {
        return \in_array($this->type, ['bounce', 'blocked', 'spam'], true);
    }
}

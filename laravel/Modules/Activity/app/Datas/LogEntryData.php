<?php

declare(strict_types=1);

namespace Modules\Activity\Datas;

use Spatie\LaravelData\Data;

/**
 * Una voce di un log nel formato Monolog di Laravel: intestazione `[data ora] ambiente.LIVELLO: messaggio`
 * piu' le righe successive (stack trace, contesto).
 *
 * Una voce "grezza" (righe iniziali non riconosciute, per esempio una voce tagliata) non ha data, ambiente ne' livello.
 */
final class LogEntryData extends Data
{
    public function __construct(
        public readonly ?string $timestamp,
        public readonly ?string $environment,
        public readonly ?string $level,
        public readonly string $message,
        public readonly string $body,
    ) {}
}

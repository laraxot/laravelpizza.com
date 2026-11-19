<?php

declare(strict_types=1);

namespace Modules\AI\Exceptions;

use RuntimeException;

/**
 * Richiesta al fornitore AI fallita (rete, HTTP, risposta vuota o non conforme allo schema).
 * Il codice e' lo stato HTTP quando c'e' (429 = troppe richieste: riprovare piu' tardi), altrimenti 0.
 */
final class AiRequestException extends RuntimeException
{
    public function isRateLimited(): bool
    {
        return $this->getCode() === 429;
    }
}

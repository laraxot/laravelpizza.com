<?php

declare(strict_types=1);

/**
 * @name PdndException
 *
 * @license MIT
 *
 * @file PdndException.php
 *
 * @brief Custom exception class per la gestione degli errori in the PDND client.
 *
 * @author Francesco Loreti
 *
 * @mailto francesco.loreti@isprambiente.it
 *
 * @first_release 2025-07-13
 */

namespace Modules\Pdnd\Services\Client;

use Exception;

class PdndException extends Exception
{
    private ?string $errorCode;

    public function __construct(string $message = '', ?string $errorCode = null)
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
    }

    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }
}

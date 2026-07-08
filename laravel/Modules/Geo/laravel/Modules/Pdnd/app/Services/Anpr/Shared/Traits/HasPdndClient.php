<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Shared\Traits;

use Exception;
use Modules\Pdnd\Services\PdndClientService;

trait HasPdndClient
{
    protected PdndClientService $pdndClient;

    /**
     * Ottieni il client PDND
     */
    protected function getPdndClient(): PdndClientService
    {
        return $this->pdndClient;
    }

    /**
     * Ottieni i log di debug del client
     */
    protected function getClientDebugLog(): string
    {
        return $this->pdndClient->getDebugLog();
    }

    /**
     * Verifica se il client è configurato correttamente
     */
    protected function isClientReady(): bool
    {
        try {
            // Il client è sempre non-null dopo l'init, verifica solo se è configurato
            $client = $this->pdndClient->getClient();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

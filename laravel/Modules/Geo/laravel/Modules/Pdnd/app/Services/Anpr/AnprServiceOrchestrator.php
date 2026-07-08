<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr;

use InvalidArgumentException;
use Modules\Pdnd\Services\Anpr\Services\C030\C030Service;
use Modules\Pdnd\Services\Anpr\Shared\Models\Enums\ServizioAnprEnum;
use Modules\Pdnd\Services\PdndClientService;

class AnprServiceOrchestrator
{
    /**
     * @var array<string, C030Service>
     */
    private array $services = [];

    public function __construct() {}

    // Factory methods per ogni servizio
    public function c030(): C030Service
    {
        if (! isset($this->services['C030'])) {
            $client = PdndClientService::forService(ServizioAnprEnum::C030);
            $this->services['C030'] = new C030Service($client);
        }

        return $this->services['C030'];
    }

    // Metodo generico per backward compatibility con la tua pagina esistente
    public function cercaPerCodiceFiscale(string $cf, ServizioAnprEnum $servizio = ServizioAnprEnum::C030): array
    {
        return match ($servizio) {
            ServizioAnprEnum::C030 => $this->c030()->cercaPerCodiceFiscale($cf),
            // ServizioAnprEnum::C001 => $this->c001()->cercaPerCodiceFiscale($cf),
            default => throw new InvalidArgumentException("Servizio non supportato: {$servizio->value}")
        };
    }
}

<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C007\Models\Request;

use function Safe\preg_match;

class TipoDatiRichiestaE002
{
    public function __construct(
        public readonly string $dataRiferimentoRichiesta,
        public readonly string $casoUso,
        public readonly string $motivoRichiesta
    ) {}

    public function toArray(): array
    {
        return [
            'dataRiferimentoRichiesta' => $this->dataRiferimentoRichiesta,
            'casoUso' => $this->casoUso,
            'motivoRichiesta' => $this->motivoRichiesta,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dataRiferimentoRichiesta: (string) ($data['dataRiferimentoRichiesta'] ?? ''),
            casoUso: (string) ($data['casoUso'] ?? ''),
            motivoRichiesta: (string) ($data['motivoRichiesta'] ?? '')
        );
    }

    /**
     * Factory method per il caso d'uso C003
     */
    // public static function perC003(
    //     string $motivoRichiesta,
    //     ?string $dataRiferimento = null
    // ): self {
    //     return new self(
    //         dataRiferimentoRichiesta: $dataRiferimento ?? now()->format('Y-m-d'),
    //         casoUso: 'C003',
    //         motivoRichiesta: $motivoRichiesta
    //     );
    // }

    /**
     * Valida il formato della data
     */
    public function isValidDataFormat(): bool
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->dataRiferimentoRichiesta) === 1;
    }

    /**
     * Verifica se è per il caso d'uso C003
     */
    public function isC007(): bool
    {
        return $this->casoUso === 'C007';
    }
}

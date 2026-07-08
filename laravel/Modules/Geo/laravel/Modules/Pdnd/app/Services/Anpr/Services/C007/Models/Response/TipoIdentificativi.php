<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C007\Models\Response;

use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoIdentificativi
{
    use HasArrayConversion;

    public function __construct(
        public readonly ?string $idANPR = null
    ) {}

    public function toArray(): array
    {
        return [
            'idANPR' => $this->idANPR,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            idANPR: isset($data['idANPR']) && is_string($data['idANPR']) ? $data['idANPR'] : null
        );
    }

    public function isValid(): bool
    {
        return ! empty($this->idANPR);
    }
}

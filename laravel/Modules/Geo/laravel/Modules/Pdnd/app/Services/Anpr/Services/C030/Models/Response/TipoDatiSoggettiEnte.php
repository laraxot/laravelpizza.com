<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C030\Models\Response;

use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoDatiSoggettiEnte
{
    use HasArrayConversion;

    public function __construct(
        public readonly ?TipoIdentificativi $identificativi = null
    ) {}

    public function toArray(): array
    {
        return [
            'identificativi' => $this->identificativi?->toArray(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            identificativi: (isset($data['identificativi']) && is_array($data['identificativi'])) ? TipoIdentificativi::fromArray($data['identificativi']) : null
        );
    }

    public function getIdAnpr(): ?string
    {
        return $this->identificativi?->idANPR;
    }

    public function hasIdAnpr(): bool
    {
        return ! empty($this->getIdAnpr());
    }
}

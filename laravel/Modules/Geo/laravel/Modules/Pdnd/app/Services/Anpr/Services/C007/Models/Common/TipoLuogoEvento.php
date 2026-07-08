<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C007\Models\Common;

class TipoLuogoEvento
{
    public function __construct(
        public readonly ?string $luogoEccezionale = null,
        public readonly ?TipoComune $comune = null,
        public readonly ?TipoLocalita $localita = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->luogoEccezionale !== null) {
            $data['luogoEccezionale'] = $this->luogoEccezionale;
        }

        if ($this->comune !== null) {
            $data['comune'] = $this->comune->toArray();
        }

        if ($this->localita !== null) {
            $data['localita'] = $this->localita->toArray();
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            luogoEccezionale: isset($data['luogoEccezionale']) && is_string($data['luogoEccezionale']) ? $data['luogoEccezionale'] : null,
            comune: (isset($data['comune']) && is_array($data['comune'])) ? TipoComune::fromArray($data['comune']) : null,
            localita: (isset($data['localita']) && is_array($data['localita'])) ? TipoLocalita::fromArray($data['localita']) : null
        );
    }
}

<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Common;

use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoLuogoNascita3000
{
    use HasArrayConversion;

    public function __construct(
        public readonly ?string $luogoEccezionale = null,
        public readonly ?TipoComune $comune = null,
        public readonly ?TipoLocalita $localita = null
    ) {}

    public function toArray(): array
    {
        $array = [];

        if ($this->luogoEccezionale) {
            $array['luogoEccezionale'] = $this->luogoEccezionale;
        }
        if ($this->comune) {
            $array['comune'] = $this->comune->toArray();
        }
        if ($this->localita) {
            $array['localita'] = $this->localita->toArray();
        }

        return $array;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            luogoEccezionale: isset($data['luogoEccezionale']) && is_string($data['luogoEccezionale']) ? $data['luogoEccezionale'] : null,
            comune: (isset($data['comune']) && is_array($data['comune'])) ? TipoComune::fromArray($data['comune']) : null,
            localita: (isset($data['localita']) && is_array($data['localita'])) ? TipoLocalita::fromArray($data['localita']) : null
        );
    }

    public static function perComune(TipoComune $comune): self
    {
        return new self(comune: $comune);
    }

    public static function perLocalita(TipoLocalita $localita): self
    {
        return new self(localita: $localita);
    }

    public static function perLuogoEccezionale(string $luogoEccezionale): self
    {
        return new self(luogoEccezionale: $luogoEccezionale);
    }
}

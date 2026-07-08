<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C030\Models\Response;

use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoErroriAnomalia;
use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class RispostaE002OK
{
    use HasArrayConversion;

    /**
     * @param  array|null  $listaAnomalie
     */
    public function __construct(
        public readonly ?string $idOperazioneANPR = null,
        public readonly ?TipoListaSoggetti $listaSoggetti = null,
        /** @var array<int, TipoErroriAnomalia>|null */
        public readonly ?array $listaAnomalie = null
    ) {}

    public function toArray(): array
    {
        $array = [];

        if ($this->idOperazioneANPR) {
            $array['idOperazioneANPR'] = $this->idOperazioneANPR;
        }
        if ($this->listaSoggetti) {
            $array['listaSoggetti'] = $this->listaSoggetti->toArray();
        }
        if ($this->listaAnomalie) {
            $array['listaAnomalie'] = array_map(
                static fn (TipoErroriAnomalia $anomalia) => $anomalia->toArray(),
                $this->listaAnomalie
            );
        }

        return $array;
    }

    public static function fromArray(array $data): self
    {
        $listaAnomalie = null;
        if (isset($data['listaAnomalie']) && is_array($data['listaAnomalie'])) {
            $listaAnomalie = array_map(
                static fn (mixed $item) => TipoErroriAnomalia::fromArray((array) $item),
                $data['listaAnomalie']
            );
        }

        /** @var array<int, TipoErroriAnomalia>|null $listaAnomalie */
        return new self(
            idOperazioneANPR: isset($data['idOperazioneANPR']) && is_string($data['idOperazioneANPR']) ? $data['idOperazioneANPR'] : null,
            listaSoggetti: (isset($data['listaSoggetti']) && is_array($data['listaSoggetti'])) ? TipoListaSoggetti::fromArray($data['listaSoggetti']) : null,
            listaAnomalie: $listaAnomalie
        );
    }

    public function hasSoggetti(): bool
    {
        return $this->listaSoggetti && $this->listaSoggetti->hasSoggetti();
    }

    public function getNumeroSoggetti(): int
    {
        return $this->listaSoggetti ? $this->listaSoggetti->count() : 0;
    }

    public function hasAnomalie(): bool
    {
        return $this->listaAnomalie && ! empty($this->listaAnomalie);
    }
}

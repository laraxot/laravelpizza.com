<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C030\Models\Response;

use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoErroriAnomalia;
use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class RispostaKO
{
    use HasArrayConversion;

    /**
     * @param  array|null  $listaErrori
     */
    public function __construct(
        public readonly ?string $idOperazioneANPR = null,
        /** @var array<int, TipoErroriAnomalia>|null */
        public readonly ?array $listaErrori = null
    ) {}

    public function toArray(): array
    {
        $array = [];

        if ($this->idOperazioneANPR) {
            $array['idOperazioneANPR'] = $this->idOperazioneANPR;
        }
        if ($this->listaErrori) {
            $array['listaErrori'] = array_map(
                static fn (TipoErroriAnomalia $errore) => $errore->toArray(),
                $this->listaErrori
            );
        }

        return $array;
    }

    public static function fromArray(array $data): self
    {
        $listaErrori = null;
        if (isset($data['listaErrori']) && is_array($data['listaErrori'])) {
            $listaErrori = array_map(
                static fn (mixed $item) => TipoErroriAnomalia::fromArray((array) $item),
                $data['listaErrori']
            );
        }

        /** @var array<int, TipoErroriAnomalia>|null $listaErrori */
        return new self(
            idOperazioneANPR: isset($data['idOperazioneANPR']) && is_string($data['idOperazioneANPR']) ? $data['idOperazioneANPR'] : null,
            listaErrori: $listaErrori
        );
    }

    public function hasErrori(): bool
    {
        return $this->listaErrori && ! empty($this->listaErrori);
    }

    public function getNumeroErrori(): int
    {
        return $this->listaErrori ? count($this->listaErrori) : 0;
    }

    public function getPrimoErrore(): ?TipoErroriAnomalia
    {
        return $this->listaErrori ? $this->listaErrori[0] : null;
    }
}

<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015\Models\Response;

use Modules\Pdnd\Services\Anpr\Services\C015\Models\Response\TipoListaSoggetti;
use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoErroriAnomalia;

class RispostaE002OK
{
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
        $data = [];

        if ($this->idOperazioneANPR !== null) {
            $data['idOperazioneANPR'] = $this->idOperazioneANPR;
        }

        if ($this->listaSoggetti !== null) {
            $data['listaSoggetti'] = $this->listaSoggetti->toArray();
        }

        if ($this->listaAnomalie !== null) {
            $data['listaAnomalie'] = array_map(
                static fn (TipoErroriAnomalia $anomalia) => $anomalia->toArray(),
                $this->listaAnomalie
            );
        }

        return $data;
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

    /**
     * Verifica se ha soggetti nella risposta
     */
    public function hasSoggetti(): bool
    {
        return $this->listaSoggetti !== null &&
               $this->listaSoggetti->hasElements();
    }

    /**
     * Ottieni il numero di soggetti trovati
     */
    public function getNumeroSoggetti(): int
    {
        return $this->listaSoggetti?->count() ?? 0;
    }

    /**
     * Verifica se ha anomalie
     */
    public function hasAnomalie(): bool
    {
        return $this->listaAnomalie !== null && ! empty($this->listaAnomalie);
    }

    /**
     * Ottieni il numero di anomalie
     */
    public function getNumeroAnomalie(): int
    {
        return count($this->listaAnomalie ?? []);
    }
}

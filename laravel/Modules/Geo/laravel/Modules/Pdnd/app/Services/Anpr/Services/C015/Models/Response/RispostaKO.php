<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015\Models\Response;

use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoErroriAnomalia;

class RispostaKO
{
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
        $data = [];

        if ($this->idOperazioneANPR !== null) {
            $data['idOperazioneANPR'] = $this->idOperazioneANPR;
        }

        if ($this->listaErrori !== null) {
            $data['listaErrori'] = array_map(
                static fn (TipoErroriAnomalia $errore) => $errore->toArray(),
                $this->listaErrori
            );
        }

        return $data;
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

    /**
     * Verifica se ha errori
     */
    public function hasErrori(): bool
    {
        return $this->listaErrori !== null && ! empty($this->listaErrori);
    }

    /**
     * Ottieni il numero di errori
     */
    public function getNumeroErrori(): int
    {
        return count($this->listaErrori ?? []);
    }

    /**
     * Ottieni il primo errore
     */
    public function getPrimoErrore(): ?TipoErroriAnomalia
    {
        if (! $this->hasErrori() || $this->listaErrori === null || ! isset($this->listaErrori[0])) {
            return null;
        }

        return $this->listaErrori[0];
    }

    /**
     * Ottieni tutti i codici errore
     *
     * @return array<int, string|null>
     */
    public function getCodiciErrore(): array
    {
        if (! $this->hasErrori() || $this->listaErrori === null) {
            return [];
        }

        return array_map(
            fn (TipoErroriAnomalia $errore) => $errore->codiceErroreAnomalia,
            $this->listaErrori
        );
    }
}

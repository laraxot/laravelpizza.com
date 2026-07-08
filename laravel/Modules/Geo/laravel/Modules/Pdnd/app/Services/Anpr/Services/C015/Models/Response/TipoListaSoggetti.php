<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015\Models\Response;

class TipoListaSoggetti
{
    /**
     * @param  array|null  $datiSoggetto
     */
    public function __construct(
        /** @var array<int, TipoDatiSoggettiEnte>|null */
        public readonly ?array $datiSoggetto = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->datiSoggetto !== null) {
            $data['datiSoggetto'] = array_map(
                static fn (TipoDatiSoggettiEnte $soggetto) => $soggetto->toArray(),
                $this->datiSoggetto
            );
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        $datiSoggetto = null;
        if (isset($data['datiSoggetto']) && is_array($data['datiSoggetto'])) {
            $datiSoggetto = array_map(
                static fn (mixed $item) => TipoDatiSoggettiEnte::fromArray((array) $item),
                $data['datiSoggetto']
            );
        }

        /** @var array<int, TipoDatiSoggettiEnte>|null $datiSoggetto */
        return new self(datiSoggetto: $datiSoggetto);
    }

    /**
     * Verifica se ha elementi
     */
    public function hasElements(): bool
    {
        return $this->datiSoggetto !== null && ! empty($this->datiSoggetto);
    }

    /**
     * Conta gli elementi
     */
    public function count(): int
    {
        return count($this->datiSoggetto ?? []);
    }

    /**
     * Ottieni il primo soggetto
     */
    public function getPrimoSoggetto(): ?TipoDatiSoggettiEnte
    {
        if (! $this->hasElements() || $this->datiSoggetto === null || ! isset($this->datiSoggetto[0])) {
            return null;
        }

        return $this->datiSoggetto[0];
    }

    /**
     * Ottieni tutti i soggetti come array
     *
     * @return array<int, TipoDatiSoggettiEnte>
     */
    public function getAllSoggetti(): array
    {
        if (! $this->hasElements() || $this->datiSoggetto === null) {
            return [];
        }

        return $this->datiSoggetto;
    }
}

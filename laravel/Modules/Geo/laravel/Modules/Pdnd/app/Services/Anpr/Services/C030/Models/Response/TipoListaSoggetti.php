<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C030\Models\Response;

use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoListaSoggetti
{
    use HasArrayConversion;

    /**
     * @param  array|null  $datiSoggetto
     */
    public function __construct(
        /** @var array<int, TipoDatiSoggettiEnte>|null */
        public readonly ?array $datiSoggetto = null
    ) {}

    public function toArray(): array
    {
        return [
            'datiSoggetto' => $this->datiSoggetto ? array_map(
                static fn (TipoDatiSoggettiEnte $soggetto) => $soggetto->toArray(),
                $this->datiSoggetto
            ) : null,
        ];
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

    public function hasSoggetti(): bool
    {
        return $this->datiSoggetto && ! empty($this->datiSoggetto);
    }

    public function count(): int
    {
        return $this->datiSoggetto ? count($this->datiSoggetto) : 0;
    }

    public function getPrimoSoggetto(): ?TipoDatiSoggettiEnte
    {
        return $this->datiSoggetto && isset($this->datiSoggetto[0]) ? $this->datiSoggetto[0] : null;
    }

    /**
     * @return array<int, TipoDatiSoggettiEnte>
     */
    public function getSoggettiConIdAnpr(): array
    {
        if (! $this->datiSoggetto) {
            return [];
        }

        return array_filter($this->datiSoggetto, static fn (TipoDatiSoggettiEnte $soggetto) => $soggetto->identificativi &&
                   $soggetto->identificativi->idANPR);
    }
}

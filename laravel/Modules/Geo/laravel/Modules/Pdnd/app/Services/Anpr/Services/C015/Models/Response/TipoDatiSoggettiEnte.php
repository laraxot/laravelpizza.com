<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015\Models\Response;

use Modules\Pdnd\Services\Anpr\Services\C015\Models\Common\TipoGeneralita;

class TipoDatiSoggettiEnte
{
    /**
     * @param  array|null  $infoSoggettoEnte
     */
    public function __construct(
        public readonly ?TipoGeneralita $generalita = null,
        public readonly ?TipoStatoCivile $statoCivile = null,
        public readonly ?TipoIdentificativi $identificativi = null,
        public readonly ?array $infoSoggettoEnte = null,
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->infoSoggettoEnte !== null) {
            $data['infoSoggettoEnte'] = array_map(
                static fn (TipoInfoSoggettoEnte $info): array => $info->toArray(),
                $this->infoSoggettoEnte
            );
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        $generalita = null;
        if (isset($data['generalita']) && is_array($data['generalita'])) {
            $generalita = TipoGeneralita::fromArray($data['generalita']);
        }

        $statoCivile = null;
        if (isset($data['statoCivile']) && is_array($data['statoCivile'])) {
            $statoCivile = TipoStatoCivile::fromArray($data['statoCivile']);
        }

        $identificativi = null;
        if (isset($data['identificativi']) && is_array($data['identificativi'])) {
            $identificativi = TipoIdentificativi::fromArray($data['identificativi']);
        }

        $infoSoggettoEnte = null;
        if (isset($data['infoSoggettoEnte']) && is_array($data['infoSoggettoEnte'])) {
            $mappedInfo = array_map(
                static fn (mixed $item): TipoInfoSoggettoEnte => TipoInfoSoggettoEnte::fromArray(is_array($item) ? $item : []),
                $data['infoSoggettoEnte']
            );
            /** @var array<int, TipoInfoSoggettoEnte> $infoSoggettoEnte */
            $infoSoggettoEnte = array_values($mappedInfo);
        }

        return new self(
            generalita: $generalita,
            statoCivile: $statoCivile,
            identificativi: $identificativi,
            infoSoggettoEnte: $infoSoggettoEnte,
        );
    }

    /**
     * Verifica se ha informazioni
     */
    public function hasInfo(): bool
    {
        return $this->infoSoggettoEnte !== null && ! empty($this->infoSoggettoEnte);
    }

    /**
     * Conta le informazioni
     */
    public function countInfo(): int
    {
        return count($this->infoSoggettoEnte ?? []);
    }

    /**
     * Ottieni un'informazione specifica per chiave
     */
    public function getInfoPerChiave(string $chiave): ?TipoInfoSoggettoEnte
    {
        if (! $this->hasInfo() || $this->infoSoggettoEnte === null) {
            return null;
        }

        foreach ($this->infoSoggettoEnte as $info) {
            if ($info->chiave === $chiave) {
                return $info;
            }
        }

        return null;
    }

    /**
     * Ottieni tutte le informazioni come oggetti
     *
     * @return array<int, TipoInfoSoggettoEnte>
     */
    public function getAllInfo(): array
    {
        if (! $this->hasInfo() || $this->infoSoggettoEnte === null) {
            return [];
        }

        /** @var array<int, TipoInfoSoggettoEnte> $infoSoggettoEnte */
        $infoSoggettoEnte = $this->infoSoggettoEnte;

        return $infoSoggettoEnte;
    }

    /**
     * Ottieni il valore di un'informazione per chiave
     */
    public function getValorePerChiave(string $chiave): mixed
    {
        $info = $this->getInfoPerChiave($chiave);

        if ($info === null) {
            return null;
        }

        // Restituisce il valore più appropriato
        if ($info->valore !== null) {
            return $info->valore;
        }

        if ($info->valoreTesto !== null) {
            return $info->valoreTesto;
        }

        if ($info->valoreData !== null) {
            return $info->valoreData;
        }

        return null;
    }
}

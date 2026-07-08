<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C003\Models\Response;

class TipoDatiSoggettiEnte
{
    /**
     * @param  array|null  $infoSoggettoEnte
     */
    public function __construct(
        /** @var array<int, TipoInfoSoggettoEnte>|null */
        public readonly ?array $infoSoggettoEnte = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->infoSoggettoEnte !== null) {
            $data['infoSoggettoEnte'] = array_map(
                static fn (TipoInfoSoggettoEnte $info) => $info->toArray(),
                $this->infoSoggettoEnte
            );
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        $infoSoggettoEnte = null;
        if (isset($data['infoSoggettoEnte']) && is_array($data['infoSoggettoEnte'])) {
            $infoSoggettoEnte = array_map(
                static fn (mixed $item) => TipoInfoSoggettoEnte::fromArray((array) $item),
                $data['infoSoggettoEnte']
            );
        }

        /** @var array<int, TipoInfoSoggettoEnte>|null $infoSoggettoEnte */
        return new self(infoSoggettoEnte: $infoSoggettoEnte);
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

        return $this->infoSoggettoEnte;
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

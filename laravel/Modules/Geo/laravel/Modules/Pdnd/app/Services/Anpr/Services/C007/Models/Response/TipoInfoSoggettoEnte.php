<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C007\Models\Response;

use function Safe\preg_match;

class TipoInfoSoggettoEnte
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $chiave = null,
        public readonly ?TipoInfoValore $valore = null,
        public readonly ?string $valoreTesto = null,
        public readonly ?string $valoreData = null,
        public readonly ?string $dettaglio = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->chiave !== null) {
            $data['chiave'] = $this->chiave;
        }

        if ($this->valore !== null) {
            $data['valore'] = $this->valore->value;
        }

        if ($this->valoreTesto !== null) {
            $data['valoreTesto'] = $this->valoreTesto;
        }

        if ($this->valoreData !== null) {
            $data['valoreData'] = $this->valoreData;
        }

        if ($this->dettaglio !== null) {
            $data['dettaglio'] = $this->dettaglio;
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) && is_string($data['id']) ? $data['id'] : null,
            chiave: isset($data['chiave']) && is_string($data['chiave']) ? $data['chiave'] : null,
            valore: (isset($data['valore']) && is_string($data['valore']))
                ? TipoInfoValore::from($data['valore'])
                : null,
            valoreTesto: isset($data['valoreTesto']) && is_string($data['valoreTesto']) ? $data['valoreTesto'] : null,
            valoreData: isset($data['valoreData']) && is_string($data['valoreData']) ? $data['valoreData'] : null,
            dettaglio: isset($data['dettaglio']) && is_string($data['dettaglio']) ? $data['dettaglio'] : null
        );
    }

    /**
     * Ottieni il valore più appropriato
     */
    public function getValoreEffettivo(): mixed
    {
        if ($this->valore !== null) {
            return $this->valore;
        }

        if ($this->valoreTesto !== null) {
            return $this->valoreTesto;
        }

        if ($this->valoreData !== null) {
            return $this->valoreData;
        }

        return null;
    }

    /**
     * Verifica se ha un valore
     */
    public function hasValore(): bool
    {
        return $this->valore !== null ||
               $this->valoreTesto !== null ||
               $this->valoreData !== null;
    }

    /**
     * Verifica se il valore data è valido
     */
    public function isValidDataFormat(): bool
    {
        if ($this->valoreData === null) {
            return true; // null è valido
        }

        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->valoreData) === 1;
    }
}

enum TipoInfoValore: string
{
    case A = 'A';
    case N = 'N';
    case S = 'S';
}

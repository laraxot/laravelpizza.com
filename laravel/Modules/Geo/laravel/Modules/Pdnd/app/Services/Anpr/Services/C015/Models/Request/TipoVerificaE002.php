<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015\Models\Request;

use Modules\Pdnd\Services\Anpr\Services\C007\Models\Common\TipoGeneralita;

class TipoVerificaE002
{
    public function __construct(
        public readonly ?TipoGeneralita $generalita = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->generalita !== null) {
            $data['generalita'] = $this->generalita->toArray();
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            generalita: (isset($data['generalita']) && is_array($data['generalita'])) ? TipoGeneralita::fromArray($data['generalita']) : null
        );
    }

    /**
     * Factory method per creare verifica con generalità
     */
    public static function conGeneralita(TipoGeneralita $generalita): self
    {
        return new self(generalita: $generalita);
    }

    /**
     * Verifica se ha dati di generalità
     */
    public function hasGeneralita(): bool
    {
        return $this->generalita !== null;
    }
}

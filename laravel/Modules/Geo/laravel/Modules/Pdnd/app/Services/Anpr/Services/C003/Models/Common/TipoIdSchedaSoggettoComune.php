<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C003\Models\Common;

class TipoIdSchedaSoggettoComune
{
    public function __construct(
        public readonly ?string $idSchedaSoggettoComuneIstat = null,
        public readonly ?string $idSchedaSoggetto = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->idSchedaSoggettoComuneIstat !== null) {
            $data['idSchedaSoggettoComuneIstat'] = $this->idSchedaSoggettoComuneIstat;
        }

        if ($this->idSchedaSoggetto !== null) {
            $data['idSchedaSoggetto'] = $this->idSchedaSoggetto;
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            idSchedaSoggettoComuneIstat: isset($data['idSchedaSoggettoComuneIstat']) && is_string($data['idSchedaSoggettoComuneIstat']) ? $data['idSchedaSoggettoComuneIstat'] : null,
            idSchedaSoggetto: isset($data['idSchedaSoggetto']) && is_string($data['idSchedaSoggetto']) ? $data['idSchedaSoggetto'] : null
        );
    }
}

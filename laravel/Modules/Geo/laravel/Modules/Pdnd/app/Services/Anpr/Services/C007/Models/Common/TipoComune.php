<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C007\Models\Common;

class TipoComune
{
    public function __construct(
        public readonly ?string $nomeComune = null,
        public readonly ?string $codiceIstat = null,
        public readonly ?string $siglaProvinciaIstat = null,
        public readonly ?string $descrizioneLocalita = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->nomeComune !== null) {
            $data['nomeComune'] = $this->nomeComune;
        }

        if ($this->codiceIstat !== null) {
            $data['codiceIstat'] = $this->codiceIstat;
        }

        if ($this->siglaProvinciaIstat !== null) {
            $data['siglaProvinciaIstat'] = $this->siglaProvinciaIstat;
        }

        if ($this->descrizioneLocalita !== null) {
            $data['descrizioneLocalita'] = $this->descrizioneLocalita;
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nomeComune: isset($data['nomeComune']) && is_string($data['nomeComune']) ? $data['nomeComune'] : null,
            codiceIstat: isset($data['codiceIstat']) && is_string($data['codiceIstat']) ? $data['codiceIstat'] : null,
            siglaProvinciaIstat: isset($data['siglaProvinciaIstat']) && is_string($data['siglaProvinciaIstat']) ? $data['siglaProvinciaIstat'] : null,
            descrizioneLocalita: isset($data['descrizioneLocalita']) && is_string($data['descrizioneLocalita']) ? $data['descrizioneLocalita'] : null
        );
    }
}

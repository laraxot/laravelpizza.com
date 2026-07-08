<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C003\Models\Common;

class TipoLocalita
{
    public function __construct(
        public readonly ?string $descrizioneLocalita = null,
        public readonly ?string $descrizioneStato = null,
        public readonly ?string $codiceStato = null,
        public readonly ?string $provinciaContea = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->descrizioneLocalita !== null) {
            $data['descrizioneLocalita'] = $this->descrizioneLocalita;
        }

        if ($this->descrizioneStato !== null) {
            $data['descrizioneStato'] = $this->descrizioneStato;
        }

        if ($this->codiceStato !== null) {
            $data['codiceStato'] = $this->codiceStato;
        }

        if ($this->provinciaContea !== null) {
            $data['provinciaContea'] = $this->provinciaContea;
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            descrizioneLocalita: isset($data['descrizioneLocalita']) && is_string($data['descrizioneLocalita']) ? $data['descrizioneLocalita'] : null,
            descrizioneStato: isset($data['descrizioneStato']) && is_string($data['descrizioneStato']) ? $data['descrizioneStato'] : null,
            codiceStato: isset($data['codiceStato']) && is_string($data['codiceStato']) ? $data['codiceStato'] : null,
            provinciaContea: isset($data['provinciaContea']) && is_string($data['provinciaContea']) ? $data['provinciaContea'] : null
        );
    }
}

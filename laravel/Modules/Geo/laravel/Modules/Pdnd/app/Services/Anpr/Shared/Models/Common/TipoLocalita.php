<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Common;

use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoLocalita
{
    use HasArrayConversion;

    public function __construct(
        public readonly ?string $descrizioneLocalita = null,
        public readonly ?string $descrizioneStato = null,
        public readonly ?string $codiceStato = null,
        public readonly ?string $provinciaContea = null
    ) {}

    public function toArray(): array
    {
        $array = [];

        if ($this->descrizioneLocalita) {
            $array['descrizioneLocalita'] = $this->descrizioneLocalita;
        }
        if ($this->descrizioneStato) {
            $array['descrizioneStato'] = $this->descrizioneStato;
        }
        if ($this->codiceStato) {
            $array['codiceStato'] = $this->codiceStato;
        }
        if ($this->provinciaContea) {
            $array['provinciaContea'] = $this->provinciaContea;
        }

        return $array;
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

    public static function perStato(string $descrizioneStato, ?string $codiceStato = null): self
    {
        return new self(
            descrizioneStato: $descrizioneStato,
            codiceStato: $codiceStato
        );
    }

    public static function estera(string $descrizioneLocalita, string $descrizioneStato): self
    {
        return new self(
            descrizioneLocalita: $descrizioneLocalita,
            descrizioneStato: $descrizioneStato
        );
    }
}

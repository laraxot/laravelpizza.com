<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015\Models\Common;

class TipoCodiceFiscale
{
    public function __construct(
        public readonly string $codFiscale,
        public readonly ?string $validitaCF = null,
        public readonly ?string $dataAttribuzioneValidita = null
    ) {}

    public function toArray(): array
    {
        $data = [
            'codFiscale' => $this->codFiscale,
        ];

        if ($this->validitaCF !== null) {
            $data['validitaCF'] = $this->validitaCF;
        }

        if ($this->dataAttribuzioneValidita !== null) {
            $data['dataAttribuzioneValidita'] = $this->dataAttribuzioneValidita;
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            codFiscale: isset($data['codFiscale']) && is_string($data['codFiscale']) ? $data['codFiscale'] : '',
            validitaCF: isset($data['validitaCF']) && is_string($data['validitaCF']) ? $data['validitaCF'] : null,
            dataAttribuzioneValidita: isset($data['dataAttribuzioneValidita']) && is_string($data['dataAttribuzioneValidita']) ? $data['dataAttribuzioneValidita'] : null
        );
    }
}

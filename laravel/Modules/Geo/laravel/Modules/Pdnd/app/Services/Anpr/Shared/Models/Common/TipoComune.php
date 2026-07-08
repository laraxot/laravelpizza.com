<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Common;

use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoComune
{
    use HasArrayConversion;

    public function __construct(
        public readonly ?string $nomeComune = null,
        public readonly ?string $codiceIstat = null,
        public readonly ?string $siglaProvinciaIstat = null,
        public readonly ?string $descrizioneLocalita = null
    ) {}

    public function toArray(): array
    {
        $array = [];

        if ($this->nomeComune) {
            $array['nomeComune'] = $this->nomeComune;
        }
        if ($this->codiceIstat) {
            $array['codiceIstat'] = $this->codiceIstat;
        }
        if ($this->siglaProvinciaIstat) {
            $array['siglaProvinciaIstat'] = $this->siglaProvinciaIstat;
        }
        if ($this->descrizioneLocalita) {
            $array['descrizioneLocalita'] = $this->descrizioneLocalita;
        }

        return $array;
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

    public static function perNome(string $nomeComune, ?string $siglaProvincia = null): self
    {
        return new self(
            nomeComune: $nomeComune,
            siglaProvinciaIstat: $siglaProvincia
        );
    }

    public static function perCodiceIstat(string $codiceIstat): self
    {
        return new self(codiceIstat: $codiceIstat);
    }
}

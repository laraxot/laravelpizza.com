<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Common;

use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoDatiNascitaE000
{
    use HasArrayConversion;

    public function __construct(
        public readonly ?string $dataEvento = null,
        public readonly ?string $senzaGiorno = null,
        public readonly ?string $senzaGiornoMese = null,
        public readonly ?TipoLuogoNascita3000 $luogoNascita = null
    ) {}

    public function toArray(): array
    {
        $array = [];

        if ($this->dataEvento) {
            $array['dataEvento'] = $this->dataEvento;
        }
        if ($this->senzaGiorno) {
            $array['senzaGiorno'] = $this->senzaGiorno;
        }
        if ($this->senzaGiornoMese) {
            $array['senzaGiornoMese'] = $this->senzaGiornoMese;
        }
        if ($this->luogoNascita) {
            $array['luogoNascita'] = $this->luogoNascita->toArray();
        }

        return $array;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            dataEvento: isset($data['dataEvento']) && is_string($data['dataEvento']) ? $data['dataEvento'] : null,
            senzaGiorno: isset($data['senzaGiorno']) && is_string($data['senzaGiorno']) ? $data['senzaGiorno'] : null,
            senzaGiornoMese: isset($data['senzaGiornoMese']) && is_string($data['senzaGiornoMese']) ? $data['senzaGiornoMese'] : null,
            luogoNascita: (isset($data['luogoNascita']) && is_array($data['luogoNascita']))
                ? TipoLuogoNascita3000::fromArray($data['luogoNascita'])
                : null
        );
    }

    public static function perDataCompleta(string $dataEvento, ?TipoLuogoNascita3000 $luogoNascita = null): self
    {
        return new self(
            dataEvento: $dataEvento,
            luogoNascita: $luogoNascita
        );
    }

    public static function perAnnoMese(string $annoMese, ?TipoLuogoNascita3000 $luogoNascita = null): self
    {
        return new self(
            senzaGiorno: $annoMese,
            luogoNascita: $luogoNascita
        );
    }

    public static function perAnno(string $anno, ?TipoLuogoNascita3000 $luogoNascita = null): self
    {
        return new self(
            senzaGiornoMese: $anno,
            luogoNascita: $luogoNascita
        );
    }
}

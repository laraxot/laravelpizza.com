<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Common;

use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoErroriAnomalia
{
    use HasArrayConversion;

    public function __construct(
        public readonly ?string $codiceErroreAnomalia = null,
        public readonly ?string $tipoErroreAnomalia = null,
        public readonly ?string $testoErroreAnomalia = null,
        public readonly ?string $oggettoErroreAnomalia = null,
        public readonly ?string $campoErroreAnomalia = null,
        public readonly ?string $valoreErroreAnomalia = null
    ) {}

    public function toArray(): array
    {
        $array = [];

        if ($this->codiceErroreAnomalia) {
            $array['codiceErroreAnomalia'] = $this->codiceErroreAnomalia;
        }
        if ($this->tipoErroreAnomalia) {
            $array['tipoErroreAnomalia'] = $this->tipoErroreAnomalia;
        }
        if ($this->testoErroreAnomalia) {
            $array['testoErroreAnomalia'] = $this->testoErroreAnomalia;
        }
        if ($this->oggettoErroreAnomalia) {
            $array['oggettoErroreAnomalia'] = $this->oggettoErroreAnomalia;
        }
        if ($this->campoErroreAnomalia) {
            $array['campoErroreAnomalia'] = $this->campoErroreAnomalia;
        }
        if ($this->valoreErroreAnomalia) {
            $array['valoreErroreAnomalia'] = $this->valoreErroreAnomalia;
        }

        return $array;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            codiceErroreAnomalia: isset($data['codiceErroreAnomalia']) && is_string($data['codiceErroreAnomalia']) ? $data['codiceErroreAnomalia'] : null,
            tipoErroreAnomalia: isset($data['tipoErroreAnomalia']) && is_string($data['tipoErroreAnomalia']) ? $data['tipoErroreAnomalia'] : null,
            testoErroreAnomalia: isset($data['testoErroreAnomalia']) && is_string($data['testoErroreAnomalia']) ? $data['testoErroreAnomalia'] : null,
            oggettoErroreAnomalia: isset($data['oggettoErroreAnomalia']) && is_string($data['oggettoErroreAnomalia']) ? $data['oggettoErroreAnomalia'] : null,
            campoErroreAnomalia: isset($data['campoErroreAnomalia']) && is_string($data['campoErroreAnomalia']) ? $data['campoErroreAnomalia'] : null,
            valoreErroreAnomalia: isset($data['valoreErroreAnomalia']) && is_string($data['valoreErroreAnomalia']) ? $data['valoreErroreAnomalia'] : null,
        );
    }

    public function isErrore(): bool
    {
        return $this->tipoErroreAnomalia === 'ERRORE';
    }

    public function isAnomalia(): bool
    {
        return $this->tipoErroreAnomalia === 'ANOMALIA';
    }

    public function isWarning(): bool
    {
        return $this->tipoErroreAnomalia === 'WARNING';
    }

    public function getMessaggio(): string
    {
        return $this->testoErroreAnomalia ?? 'Errore senza descrizione';
    }

    public function getDettaglio(): string
    {
        $parts = [];

        if ($this->codiceErroreAnomalia) {
            $parts[] = "Codice: {$this->codiceErroreAnomalia}";
        }
        if ($this->oggettoErroreAnomalia) {
            $parts[] = "Oggetto: {$this->oggettoErroreAnomalia}";
        }
        if ($this->campoErroreAnomalia) {
            $parts[] = "Campo: {$this->campoErroreAnomalia}";
        }
        if ($this->valoreErroreAnomalia) {
            $parts[] = "Valore: {$this->valoreErroreAnomalia}";
        }

        return implode(' | ', $parts);
    }
}

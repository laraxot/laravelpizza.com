<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C030\Models\Request;

use DateTime;
use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoDatiRichiestaE002
{
    use HasArrayConversion;

    public function __construct(
        public readonly string $dataRiferimentoRichiesta,
        public readonly string $casoUso,
        public readonly string $motivoRichiesta
    ) {}

    public function toArray(): array
    {
        return [
            'dataRiferimentoRichiesta' => $this->dataRiferimentoRichiesta,
            'casoUso' => $this->casoUso,
            'motivoRichiesta' => $this->motivoRichiesta,
        ];
    }

    public function validate(): bool
    {
        return ! empty($this->dataRiferimentoRichiesta) &&
               ! empty($this->casoUso) &&
               ! empty($this->motivoRichiesta) &&
               $this->isValidDate($this->dataRiferimentoRichiesta);
    }

    private function isValidDate(string $date): bool
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);

        return $d && $d->format('Y-m-d') === $date;
    }

    /**
     * Factory method standard per C030
     */
    public static function standard(string $motivoRichiesta, ?string $dataRiferimento = null): self
    {
        return new self(
            dataRiferimentoRichiesta: $dataRiferimento ?? now()->format('Y-m-d'),
            casoUso: 'C030',
            motivoRichiesta: $motivoRichiesta
        );
    }
}

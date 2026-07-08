<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C030\Models\Request;

use Modules\Pdnd\Services\Anpr\Contracts\AnprRequestInterface;
use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;
use Override;

/**
 * DTO di input per la richiesta E002
 * Questo è il modello principale che useremo per fare la chiamata
 */
class RichiestaE002 implements AnprRequestInterface
{
    use HasArrayConversion;

    public function __construct(
        public readonly string $idOperazioneClient,
        public readonly TipoCriteriRicercaE002 $criteriRicerca,
        public readonly TipoDatiRichiestaE002 $datiRichiesta
    ) {}

    #[Override]
    public function toArray(): array
    {
        return [
            'idOperazioneClient' => $this->idOperazioneClient,
            'criteriRicerca' => $this->criteriRicerca->toArray(),
            'datiRichiesta' => $this->datiRichiesta->toArray(),
        ];
    }

    #[Override]
    public function validate(): bool
    {
        return ! empty($this->idOperazioneClient) &&
               $this->criteriRicerca->validate() &&
               $this->datiRichiesta->validate();
    }

    #[Override]
    public function getIdOperazione(): string
    {
        return $this->idOperazioneClient;
    }

    /**
     * Factory method per ricerca per codice fiscale
     */
    public static function perCodiceFiscale(
        string $codiceFiscale,
        string $motivoRichiesta,
        string $dataRiferimento
    ): self {
        return new self(
            idOperazioneClient: 'C030_'.now()->format('YmdHis'),
            criteriRicerca: TipoCriteriRicercaE002::perCodiceFiscale($codiceFiscale),
            datiRichiesta: new TipoDatiRichiestaE002(
                dataRiferimentoRichiesta: $dataRiferimento,
                casoUso: 'C030',
                motivoRichiesta: $motivoRichiesta
            )
        );
    }

    /**
     * Factory method per ricerca completa
     */
    public static function perDatiCompleti(
        array $criteriRicerca,
        string $motivoRichiesta,
        ?string $dataRiferimento = null
    ): self {
        return new self(
            idOperazioneClient: 'C030_'.now()->format('YmdHis').'_'.uniqid(),
            criteriRicerca: TipoCriteriRicercaE002::fromArray($criteriRicerca),
            datiRichiesta: new TipoDatiRichiestaE002(
                dataRiferimentoRichiesta: $dataRiferimento ?? now()->format('Y-m-d'),
                casoUso: 'C030',
                motivoRichiesta: $motivoRichiesta
            )
        );
    }
}

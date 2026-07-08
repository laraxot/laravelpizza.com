<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C003\Models\Request;

use Modules\Pdnd\Services\Anpr\Services\C003\Models\Common\TipoGeneralita;

class RichiestaE002
{
    public function __construct(
        public readonly string $idOperazioneClient,
        public readonly TipoCriteriRicercaE002 $criteriRicerca,
        public readonly TipoDatiRichiestaE002 $datiRichiesta,
        public readonly ?TipoVerificaE002 $verifica = null
    ) {}

    public function toArray(): array
    {
        $data = [
            'idOperazioneClient' => $this->idOperazioneClient,
            'criteriRicerca' => $this->criteriRicerca->toArray(),
            'datiRichiesta' => $this->datiRichiesta->toArray(),
        ];

        if ($this->verifica !== null) {
            $data['verifica'] = $this->verifica->toArray();
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            idOperazioneClient: (string) ($data['idOperazioneClient'] ?? ''),
            criteriRicerca: (isset($data['criteriRicerca']) && is_array($data['criteriRicerca']))
                ? TipoCriteriRicercaE002::fromArray($data['criteriRicerca'])
                : new TipoCriteriRicercaE002,
            verifica: (isset($data['verifica']) && is_array($data['verifica']))
                ? TipoVerificaE002::fromArray($data['verifica'])
                : null,
            datiRichiesta: (isset($data['datiRichiesta']) && is_array($data['datiRichiesta']))
                ? TipoDatiRichiestaE002::fromArray($data['datiRichiesta'])
                : new TipoDatiRichiestaE002('', '', '')
        );
    }

    /**
     * Factory method per creare richiesta con codice fiscale
     */
    public static function perCodiceFiscale(
        string $codiceFiscale,
        ?TipoGeneralita $generalitaDaVerificare = null,
        ?string $motivoRichiesta = null,
        ?string $dataRiferimento = null
    ): self {
        $idOperazione = 'C003_'.now()->format('YmdHis').'_'.substr(uniqid(), -6);

        $criteriRicerca = new TipoCriteriRicercaE002(
            codiceFiscale: $codiceFiscale
        );

        $verifica = null;
        if ($generalitaDaVerificare !== null) {
            $verifica = new TipoVerificaE002(generalita: $generalitaDaVerificare);
        }

        $datiRichiesta = new TipoDatiRichiestaE002(
            dataRiferimentoRichiesta: $dataRiferimento ?? now()->format('Y-m-d'),
            casoUso: 'C003',
            motivoRichiesta: $motivoRichiesta ?? 'Verifica dichiarazione generalità'
        );

        return new self(
            idOperazioneClient: $idOperazione,
            criteriRicerca: $criteriRicerca,
            verifica: $verifica,
            datiRichiesta: $datiRichiesta
        );
    }

    /**
     * Factory method per creare richiesta con ID ANPR
     */
    public static function perIdAnpr(
        string $idAnpr,
        ?TipoGeneralita $generalitaDaVerificare = null,
        ?string $motivoRichiesta = null,
        ?string $dataRiferimento = null
    ): self {
        $idOperazione = 'C003_'.now()->format('YmdHis').'_'.substr(uniqid(), -6);

        $criteriRicerca = new TipoCriteriRicercaE002(
            idANPR: $idAnpr
        );

        $verifica = null;
        if ($generalitaDaVerificare !== null) {
            $verifica = new TipoVerificaE002(generalita: $generalitaDaVerificare);
        }

        $datiRichiesta = new TipoDatiRichiestaE002(
            dataRiferimentoRichiesta: $dataRiferimento ?? now()->format('Y-m-d'),
            casoUso: 'C003',
            motivoRichiesta: $motivoRichiesta ?? 'Verifica per ID ANPR'
        );

        return new self(
            idOperazioneClient: $idOperazione,
            criteriRicerca: $criteriRicerca,
            verifica: $verifica,
            datiRichiesta: $datiRichiesta
        );
    }

    /**
     * Verifica se la richiesta ha dati di verifica
     */
    public function hasVerifica(): bool
    {
        return $this->verifica !== null;
    }

    /**
     * Ottieni il tipo di criterio di ricerca principale
     */
    public function getTipoCriterio(): string
    {
        if ($this->criteriRicerca->codiceFiscale !== null) {
            return 'codice_fiscale';
        }

        if ($this->criteriRicerca->idANPR !== null) {
            return 'id_anpr';
        }

        if ($this->criteriRicerca->cognome !== null || $this->criteriRicerca->nome !== null) {
            return 'dati_anagrafici';
        }

        return 'altro';
    }
}

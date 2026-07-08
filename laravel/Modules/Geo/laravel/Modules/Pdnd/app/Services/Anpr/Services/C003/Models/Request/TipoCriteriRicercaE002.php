<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C003\Models\Request;

use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoDatiNascitaE000;

class TipoCriteriRicercaE002
{
    public function __construct(
        public readonly ?string $codiceFiscale = null,
        public readonly ?string $idANPR = null,
        public readonly ?string $cognome = null,
        public readonly ?string $senzaCognome = null,
        public readonly ?string $nome = null,
        public readonly ?string $senzaNome = null,
        public readonly ?string $sesso = null,
        public readonly ?TipoDatiNascitaE000 $datiNascita = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->codiceFiscale !== null) {
            $data['codiceFiscale'] = $this->codiceFiscale;
        }

        if ($this->idANPR !== null) {
            $data['idANPR'] = $this->idANPR;
        }

        if ($this->cognome !== null) {
            $data['cognome'] = $this->cognome;
        }

        if ($this->senzaCognome !== null) {
            $data['senzaCognome'] = $this->senzaCognome;
        }

        if ($this->nome !== null) {
            $data['nome'] = $this->nome;
        }

        if ($this->senzaNome !== null) {
            $data['senzaNome'] = $this->senzaNome;
        }

        if ($this->sesso !== null) {
            $data['sesso'] = $this->sesso;
        }

        if ($this->datiNascita !== null) {
            $data['datiNascita'] = $this->datiNascita->toArray();
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            codiceFiscale: isset($data['codiceFiscale']) && is_string($data['codiceFiscale']) ? $data['codiceFiscale'] : null,
            idANPR: isset($data['idANPR']) && is_string($data['idANPR']) ? $data['idANPR'] : null,
            cognome: isset($data['cognome']) && is_string($data['cognome']) ? $data['cognome'] : null,
            senzaCognome: isset($data['senzaCognome']) && is_string($data['senzaCognome']) ? $data['senzaCognome'] : null,
            nome: isset($data['nome']) && is_string($data['nome']) ? $data['nome'] : null,
            senzaNome: isset($data['senzaNome']) && is_string($data['senzaNome']) ? $data['senzaNome'] : null,
            sesso: isset($data['sesso']) && is_string($data['sesso']) ? $data['sesso'] : null,
            datiNascita: (isset($data['datiNascita']) && is_array($data['datiNascita'])) ? TipoDatiNascitaE000::fromArray($data['datiNascita']) : null,
        );
    }

    /**
     * Factory method per ricerca tramite codice fiscale
     */
    public static function perCodiceFiscale(string $codiceFiscale): self
    {
        return new self(codiceFiscale: $codiceFiscale);
    }

    /**
     * Factory method per ricerca tramite ID ANPR
     */
    public static function perIdAnpr(string $idAnpr): self
    {
        return new self(idANPR: $idAnpr);
    }

    /**
     * Factory method per ricerca tramite dati anagrafici base
     */
    public static function perDatiAnagrafici(
        string $cognome,
        string $nome,
        ?string $sesso = null,
        ?TipoDatiNascitaE000 $datiNascita = null
    ): self {
        return new self(
            cognome: $cognome,
            nome: $nome,
            sesso: $sesso,
            datiNascita: $datiNascita
        );
    }

    /**
     * Verifica se ha almeno un criterio valido per la ricerca
     */
    public function hasValidCriteria(): bool
    {
        return $this->codiceFiscale !== null ||
               $this->idANPR !== null ||
               ($this->cognome !== null && $this->nome !== null);
    }

    /**
     * Ottieni il tipo di ricerca principale
     */
    public function getTipoRicerca(): string
    {
        if ($this->codiceFiscale !== null) {
            return 'codice_fiscale';
        }

        if ($this->idANPR !== null) {
            return 'id_anpr';
        }

        if ($this->cognome !== null || $this->nome !== null) {
            return 'dati_anagrafici';
        }

        return 'nessuno';
    }
}

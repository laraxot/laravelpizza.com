<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C007\Models\Common;

class TipoGeneralita
{
    public function __construct(
        public readonly ?TipoCodiceFiscale $codiceFiscale = null,
        public readonly ?string $cognome = null,
        public readonly ?string $senzaCognome = null,
        public readonly ?string $nome = null,
        public readonly ?string $senzaNome = null,
        public readonly ?string $sesso = null,
        public readonly ?string $dataNascita = null,
        public readonly ?string $senzaGiorno = null,
        public readonly ?string $senzaGiornoMese = null,
        public readonly ?TipoLuogoEvento $luogoNascita = null,
        public readonly ?string $soggettoAIRE = null,
        public readonly ?string $annoEspatrio = null,
        public readonly ?TipoIdSchedaSoggettoComune $idSchedaSoggettoComune = null,
        public readonly ?string $idSchedaSoggettoANPR = null,
        public readonly ?string $note = null
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->codiceFiscale !== null) {
            $data['codiceFiscale'] = $this->codiceFiscale->toArray();
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

        if ($this->dataNascita !== null) {
            $data['dataNascita'] = $this->dataNascita;
        }

        if ($this->senzaGiorno !== null) {
            $data['senzaGiorno'] = $this->senzaGiorno;
        }

        if ($this->senzaGiornoMese !== null) {
            $data['senzaGiornoMese'] = $this->senzaGiornoMese;
        }

        if ($this->luogoNascita !== null) {
            $data['luogoNascita'] = $this->luogoNascita->toArray();
        }

        if ($this->soggettoAIRE !== null) {
            $data['soggettoAIRE'] = $this->soggettoAIRE;
        }

        if ($this->annoEspatrio !== null) {
            $data['annoEspatrio'] = $this->annoEspatrio;
        }

        if ($this->idSchedaSoggettoComune !== null) {
            $data['idSchedaSoggettoComune'] = $this->idSchedaSoggettoComune->toArray();
        }

        if ($this->idSchedaSoggettoANPR !== null) {
            $data['idSchedaSoggettoANPR'] = $this->idSchedaSoggettoANPR;
        }

        if ($this->note !== null) {
            $data['note'] = $this->note;
        }

        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            codiceFiscale: (isset($data['codiceFiscale']) && is_array($data['codiceFiscale'])) ? TipoCodiceFiscale::fromArray($data['codiceFiscale']) : null,
            cognome: isset($data['cognome']) && is_string($data['cognome']) ? $data['cognome'] : null,
            senzaCognome: isset($data['senzaCognome']) && is_string($data['senzaCognome']) ? $data['senzaCognome'] : null,
            nome: isset($data['nome']) && is_string($data['nome']) ? $data['nome'] : null,
            senzaNome: isset($data['senzaNome']) && is_string($data['senzaNome']) ? $data['senzaNome'] : null,
            sesso: isset($data['sesso']) && is_string($data['sesso']) ? $data['sesso'] : null,
            dataNascita: isset($data['dataNascita']) && is_string($data['dataNascita']) ? $data['dataNascita'] : null,
            senzaGiorno: isset($data['senzaGiorno']) && is_string($data['senzaGiorno']) ? $data['senzaGiorno'] : null,
            senzaGiornoMese: isset($data['senzaGiornoMese']) && is_string($data['senzaGiornoMese']) ? $data['senzaGiornoMese'] : null,
            luogoNascita: (isset($data['luogoNascita']) && is_array($data['luogoNascita'])) ? TipoLuogoEvento::fromArray($data['luogoNascita']) : null,
            soggettoAIRE: isset($data['soggettoAIRE']) && is_string($data['soggettoAIRE']) ? $data['soggettoAIRE'] : null,
            annoEspatrio: isset($data['annoEspatrio']) && is_string($data['annoEspatrio']) ? $data['annoEspatrio'] : null,
            idSchedaSoggettoComune: (isset($data['idSchedaSoggettoComune']) && is_array($data['idSchedaSoggettoComune'])) ? TipoIdSchedaSoggettoComune::fromArray($data['idSchedaSoggettoComune']) : null,
            idSchedaSoggettoANPR: isset($data['idSchedaSoggettoANPR']) && is_string($data['idSchedaSoggettoANPR']) ? $data['idSchedaSoggettoANPR'] : null,
            note: isset($data['note']) && is_string($data['note']) ? $data['note'] : null
        );
    }

    /**
     * Factory method per creare generalità con dati di base
     */
    public static function createFromBasicData(
        string $codiceFiscale,
        string $cognome,
        string $nome,
        string $sesso,
        string $dataNascita,
        array $luogoNascita = []
    ): self {
        $codiceFiscaleObj = new TipoCodiceFiscale(
            codFiscale: $codiceFiscale
        );

        $luogoNascitaObj = null;
        if (! empty($luogoNascita)) {
            $luogoNascitaObj = TipoLuogoEvento::fromArray($luogoNascita);
        }

        return new self(
            codiceFiscale: $codiceFiscaleObj,
            cognome: $cognome,
            senzaCognome: null,
            nome: $nome,
            senzaNome: null,
            sesso: $sesso,
            dataNascita: $dataNascita,
            senzaGiorno: null,
            senzaGiornoMese: null,
            luogoNascita: $luogoNascitaObj,
            soggettoAIRE: null,
            annoEspatrio: null,
            idSchedaSoggettoComune: null,
            idSchedaSoggettoANPR: null,
            note: null
        );
    }
}

<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C030\Models\Request;

use Modules\Pdnd\Services\Anpr\Shared\Models\Common\TipoDatiNascitaE000;
use Modules\Pdnd\Services\Anpr\Shared\Traits\HasArrayConversion;

class TipoCriteriRicercaE002
{
    use HasArrayConversion;

    public function __construct(
        public readonly ?string $codiceFiscale = null,
        public readonly ?string $cognome = null,
        public readonly ?string $senzaCognome = null,
        public readonly ?string $nome = null,
        public readonly ?string $senzaNome = null,
        public readonly ?string $sesso = null,
        public readonly ?TipoDatiNascitaE000 $datiNascita = null
    ) {}

    public function toArray(): array
    {
        $array = [];

        if ($this->codiceFiscale) {
            $array['codiceFiscale'] = $this->codiceFiscale;
        }
        if ($this->cognome) {
            $array['cognome'] = $this->cognome;
        }
        if ($this->senzaCognome) {
            $array['senzaCognome'] = $this->senzaCognome;
        }
        if ($this->nome) {
            $array['nome'] = $this->nome;
        }
        if ($this->senzaNome) {
            $array['senzaNome'] = $this->senzaNome;
        }
        if ($this->sesso) {
            $array['sesso'] = $this->sesso;
        }
        if ($this->datiNascita) {
            $array['datiNascita'] = $this->datiNascita->toArray();
        }

        return $array;
    }

    public function validate(): bool
    {
        // Almeno uno dei criteri deve essere presente
        return $this->codiceFiscale ||
               $this->cognome ||
               $this->nome ||
               $this->datiNascita;
    }

    /**
     * Factory method per ricerca per codice fiscale
     */
    public static function perCodiceFiscale(string $codiceFiscale): self
    {
        return new self(codiceFiscale: $codiceFiscale);
    }

    /**
     * Factory method per ricerca anagrafica completa
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
     * Factory method da array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            codiceFiscale: isset($data['codiceFiscale']) && is_string($data['codiceFiscale']) ? $data['codiceFiscale'] : null,
            cognome: isset($data['cognome']) && is_string($data['cognome']) ? $data['cognome'] : null,
            senzaCognome: isset($data['senzaCognome']) && is_string($data['senzaCognome']) ? $data['senzaCognome'] : null,
            nome: isset($data['nome']) && is_string($data['nome']) ? $data['nome'] : null,
            senzaNome: isset($data['senzaNome']) && is_string($data['senzaNome']) ? $data['senzaNome'] : null,
            sesso: isset($data['sesso']) && is_string($data['sesso']) ? $data['sesso'] : null,
            datiNascita: (isset($data['datiNascita']) && is_array($data['datiNascita'])) ? TipoDatiNascitaE000::fromArray($data['datiNascita']) : null
        );
    }
}

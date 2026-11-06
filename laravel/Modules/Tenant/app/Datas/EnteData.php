<?php

declare(strict_types=1);

namespace Modules\Tenant\Datas;

use Modules\Tenant\Actions\Ente\GetEnteDataAction;
use Spatie\LaravelData\Data;

use function Safe\preg_replace;

/**
 * Dati dell'ente titolare del tenant (DCP-289). Si ottiene SEMPRE da {@see GetEnteDataAction},
 * che li normalizza: stringhe tagliate, telefoni numerici, email e URL validi, social di una lista chiusa. Un campo vuoto vuol dire
 * "l'ente non l'ha fornito": chi lo mostra deve nascondere il blocco, mai inventare un valore.
 */
class EnteData extends Data
{
    /** Campi che diventano un link e il prefisso del link. */
    private const array LINK_SCHEMES = [
        'phone' => 'tel:',
        'toll_free' => 'tel:',
        'email' => 'mailto:',
        'pec' => 'mailto:',
        'dpo_email' => 'mailto:',
    ];

    /**
     * @param  list<array{network: string, label: string, url: string, icon: string}>  $social
     */
    public function __construct(
        public string $name = '',
        public string $region_name = '',
        public string $region_url = '',
        public string $address = '',
        public string $pec = '',
        public string $email = '',
        public string $phone = '',
        public string $toll_free = '',
        public string $tax_code = '',
        public string $vat = '',
        public string $dpo_name = '',
        public string $dpo_email = '',
        public string $hours = '',
        public array $social = [],
    ) {}

    /**
     * Almeno un recapito o un identificativo fiscale da mostrare nella colonna "Contatti" del footer. L'email del DPO conta: chi esercita i
     * diritti sui dati (`rightsContact()`) trova sempre quel recapito nel footer.
     */
    public function hasContacts(): bool
    {
        foreach (['address', 'pec', 'email', 'phone', 'toll_free', 'hours', 'tax_code', 'vat', 'dpo_email'] as $field) {
            if ($this->{$field} !== '') {
                return true;
            }
        }

        return false;
    }

    /**
     * Testo e href di un campo-link (`phone`, `toll_free`, `email`, `pec`, `dpo_email`), o null se manca o non e' un campo-link.
     *
     * @return array{label: string, href: string}|null
     */
    public function link(string $field): ?array
    {
        $scheme = self::LINK_SCHEMES[$field] ?? null;
        if ($scheme === null) {
            return null;
        }

        $value = match ($field) {
            'phone' => $this->phone,
            'toll_free' => $this->toll_free,
            'email' => $this->email,
            'pec' => $this->pec,
            'dpo_email' => $this->dpo_email,
            default => '',
        };
        if ($value === '') {
            return null;
        }

        $target = $scheme === 'tel:' ? preg_replace('/[^\d+]/', '', $value) : $value;

        return ['label' => $value, 'href' => $scheme.$target];
    }

    /**
     * A chi scrivere per esercitare i diritti sui dati (GDPR): l'email del DPO, altrimenti la PEC, altrimenti l'email dell'ente.
     *
     * @return array{label: string, href: string}|null
     */
    public function rightsContact(): ?array
    {
        foreach (['dpo_email', 'pec', 'email'] as $field) {
            $link = $this->link($field);
            if ($link !== null) {
                return $link;
            }
        }

        return null;
    }
}

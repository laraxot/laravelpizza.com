<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome paese',
            'placeholder' => 'Inserisci il nome del paese',
            'help' => 'Nome ufficiale del paese',
        ],
        'code' => [
            'label' => 'Codice',
            'placeholder' => 'Inserisci il codice ISO',
            'help' => 'Codice ISO del paese (es. IT, US, DE)',
        ],
        'phone_code' => [
            'label' => 'Prefisso telefonico',
            'placeholder' => 'Inserisci il prefisso telefonico',
            'help' => 'Prefisso telefonico internazionale',
        ],
        'currency' => [
            'label' => 'Valuta',
            'placeholder' => 'Seleziona la valuta',
            'help' => 'Valuta ufficiale del paese',
        ],
        'language' => [
            'label' => 'Lingua',
            'placeholder' => 'Seleziona la lingua',
            'help' => 'Lingua ufficiale del paese',
        ],
        'timezone' => [
            'label' => 'Fuso orario',
            'placeholder' => 'Seleziona il fuso orario',
            'help' => 'Fuso orario principale del paese',
        ],
        'capital' => [
            'label' => 'Capitale',
            'placeholder' => 'Inserisci la capitale',
            'help' => 'Capitale del paese',
        ],
        'population' => [
            'label' => 'Popolazione',
            'placeholder' => 'Inserisci il numero di abitanti',
            'help' => 'Numero di abitanti del paese',
        ],
        'area' => [
            'label' => 'Superficie',
            'placeholder' => 'Inserisci la superficie in km²',
            'help' => 'Superficie del paese in chilometri quadrati',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Indica se il paese è attivo nel sistema',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome del paese è obbligatorio',
        'code_required' => 'Il codice ISO è obbligatorio',
        'code_unique' => 'Il codice ISO deve essere unico',
        'phone_code_required' => 'Il prefisso telefonico è obbligatorio',
    ],
    'messages' => [
        'country_created' => 'Paese creato con successo',
        'country_updated' => 'Paese aggiornato con successo',
        'country_deleted' => 'Paese eliminato con successo',
        'country_activated' => 'Paese attivato con successo',
        'country_deactivated' => 'Paese disattivato con successo',
    ],
];

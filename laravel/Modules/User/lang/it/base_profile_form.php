<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'helper_text' => 'Nome visualizzato del profilo',
            'description' => 'Nome',
        ],
        'user' => [
            'name' => [
                'label' => 'Utente',
                'placeholder' => 'Seleziona l\'utente',
                'helper_text' => 'Utente collegato al profilo',
                'description' => 'Nome utente',
            ],
        ],
        'email' => [
            'label' => 'E-mail',
            'placeholder' => 'Inserisci l\'e-mail',
            'helper_text' => 'Indirizzo e-mail del profilo',
            'description' => 'E-mail',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'helper_text' => 'Nome di battesimo',
            'description' => 'Nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'helper_text' => 'Cognome',
            'description' => 'Cognome',
        ],
        'photo_profile' => [
            'label' => 'Foto profilo',
            'placeholder' => 'Carica una foto',
            'helper_text' => 'Immagine del profilo',
            'description' => 'Foto profilo',
        ],
    ],
    'sections' => [
        'empty' => [
            'label' => '',
            'heading' => '',
        ],
    ],
];

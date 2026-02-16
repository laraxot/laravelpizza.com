<?php

declare(strict_types=1);

return [
    'error' => 'Ops!',
    'greeting' => 'Ciao!',
    'regards' => 'Saluti,',
    'trouble_clicking_button' => 'Se hai problemi a cliccare il pulsante ":actionText", copia e incolla l\'URL qui sotto nel tuo browser:',
    'thank_you_for_using_app' => 'Grazie per aver utilizzato la nostra applicazione!',
    'password_reset_subject' => 'Il tuo link per il reset della password',
    'password_cause_of_email' => 'Hai ricevuto questa email perché abbiamo ricevuto una richiesta di reset della password per il tuo account.',
    'password_if_not_requested' => 'Se non hai richiesto un reset della password, non è necessaria alcuna azione.',
    'reset_password' => 'Clicca qui per reimpostare la tua password',
    'click_to_confirm' => 'Clicca qui per confermare il tuo account:',
    'password_reset_expiration' => 'Questo link per il reset della password scadrà tra :count minuti.',
    'navigation' => [
        'name' => 'Email',
        'plural' => 'Email',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Email',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Email',
    'plural_label' => 'Email (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Email',
        ],
        'edit' => [
            'label' => 'Modifica Email',
        ],
        'delete' => [
            'label' => 'Elimina Email',
        ],
    ],
];

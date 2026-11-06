<?php

declare(strict_types=1);

return [
    'fields' => [
        'current_password' => [
            'label' => 'Password attuale',
        ],
        'new_password' => [
            'label' => 'Nuova password',
        ],
        'confirm_new_password' => [
            'label' => 'Conferma nuova password',
        ],
        'first_name' => [
            'label' => 'Nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
        ],
    ],
    'sections' => [
        'profile_information' => [
            'title' => 'Informazioni del profilo',
            'description' => 'Aggiorna le informazioni del profilo e l\'indirizzo email del tuo account.',
        ],
        'update_password' => [
            'description' => 'Assicurati che il tuo account usi una password lunga e casuale per restare al sicuro.',
        ],
        'delete_account' => [
            'description' => 'Una volta eliminato l\'account, tutte le sue risorse e i suoi dati verranno eliminati definitivamente. Prima di eliminare l\'account, scarica i dati o le informazioni che desideri conservare.',
        ],
    ],
    'actions' => [
        'update_profile' => [
            'label' => 'Aggiorna profilo',
        ],
        'update_password' => [
            'label' => 'Aggiorna password',
        ],
        'delete_account' => [
            'label' => 'Elimina account',
        ],
    ],
    'modal' => [
        'delete_confirmation' => [
            'title' => 'Sei sicuro di voler eliminare il tuo account?',
            'message' => 'Una volta eliminato l\'account, tutte le sue risorse e i suoi dati verranno eliminati definitivamente. Inserisci la tua password per confermare di voler eliminare definitivamente il tuo account.',
            'placeholder' => 'Inserisci la tua password per confermare l\'eliminazione',
        ],
    ],
];

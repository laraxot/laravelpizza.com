<?php

declare(strict_types=1);

return [
    // NAVIGATION & STRUCTURE
    'navigation' => [
        'label' => 'Pulsanti',
        'plural_label' => 'Pulsanti',
        'group' => 'Sistema Xot',
        'icon' => 'heroicon-o-cursor-arrow-ripple',
        'sort' => 110,
        'badge' => 'Etichette pulsanti interfaccia',
    ],
    // MODEL INFORMATION
    'model' => [
        'label' => 'Pulsante',
        'plural' => 'Pulsanti',
        'description' => 'Etichette e testi per pulsanti e controlli dell\'interfaccia',
    ],
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    'actions' => [
        'create' => [
            'label' => 'Crea',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea nuovo elemento',
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica elemento selezionato',
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina elemento selezionato',
        ],
        'view' => [
            'label' => 'Visualizza',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza dettagli',
        ],
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'color' => 'success',
            'tooltip' => 'Salva modifiche',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'icon' => 'heroicon-o-x-mark',
            'color' => 'secondary',
            'tooltip' => 'Annulla operazione',
        ],
        'confirm' => [
            'label' => 'Conferma',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
            'tooltip' => 'Conferma operazione',
        ],
        'back' => [
            'label' => 'Indietro',
            'icon' => 'heroicon-o-arrow-left',
            'color' => 'secondary',
            'tooltip' => 'Torna indietro',
        ],
        'close' => [
            'label' => 'Chiudi',
            'icon' => 'heroicon-o-x-mark',
            'color' => 'secondary',
            'tooltip' => 'Chiudi finestra',
        ],
    ],
    // MESSAGES - FEEDBACK UTENTE
    'messages' => [
        'empty_state' => 'Nessun pulsante configurato',
        'loading' => 'Caricamento interfaccia...',
        'error_general' => 'Si è verificato un errore dell\'interfaccia',
        'success_operation' => 'Operazione dell\'interfaccia completata',
    ],
    // LEGACY SUPPORT - Compatibilità con codice esistente
    'backend' => [
        'access' => [
            'users' => [
                'activate' => 'Attiva',
                'change_password' => 'Cambia password',
                'deactivate' => 'Disattiva',
                'delete_permanently' => 'Elimina definitivamente',
                'login_as' => 'Login As :user',
                'resend_email' => 'Reinvia e-mail di conferma',
                'restore_user' => 'Ripristina utente',
            ],
        ],
    ],
    'emails' => [
        'auth' => [
            'confirm_account' => 'Confirm Account',
            'reset_password' => 'Reset Password',
        ],
    ],
    'general' => [
        'cancel' => 'Annulla',
        'crud' => [
            'create' => 'Crea',
            'delete' => 'Elimina',
            'edit' => 'Modifica',
            'update' => 'Aggiorna',
            'view' => 'View',
        ],
        'save' => 'Salva',
        'view' => 'Visualizza',
    ],
    'save' => 'Salva',
    'close' => 'Chiudi',
    'back' => 'Indietro',
    'confirm' => 'Conferma',
];

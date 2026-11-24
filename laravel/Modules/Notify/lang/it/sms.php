<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'SMS',
<<<<<<< HEAD
        'plural' => 'SMS',
    ],
=======
<<<<<<< HEAD
        'plural' => 'SMS',
    ],
=======
        'plural' => 'SMS'],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
    'navigation' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
        'group' => [
            'name' => 'Notifiche',
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
            'description' => 'Gestione delle notifiche SMS',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-device-phone-mobile',
        'sort' => 10,
    ],
<<<<<<< HEAD
=======
=======
            'description' => 'Gestione delle notifiche SMS'],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-device-phone-mobile',
        'sort' => 10],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
    'fields' => [
        'to' => [
            'label' => 'Numero di telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'helper_text' => 'Inserisci il numero di telefono con prefisso internazionale (es. +39]',
            'tooltip' => '',
<<<<<<< HEAD
            'description' => '',
        ],
=======
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Il messaggio non può superare i 160 caratteri',
            'tooltip' => '',
<<<<<<< HEAD
            'description' => '',
        ],
=======
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
        'driver' => [
            'label' => 'Provider SMS',
            'placeholder' => 'Seleziona il provider SMS',
            'helper_text' => 'Seleziona il provider SMS da utilizzare',
            'tooltip' => '',
<<<<<<< HEAD
            'description' => '',
        ],
    ],
=======
<<<<<<< HEAD
            'description' => '',
        ],
    ],
=======
            'description' => '']],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
    'drivers' => [
        'smsfactor' => 'SMSFactor',
        'twilio' => 'Twilio',
        'nexmo' => 'Nexmo',
        'plivo' => 'Plivo',
        'gammu' => 'Gammu',
        'netfun' => 'Netfun',
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
        'agiletelecom' => 'Agile Telecom',
    ],
    'actions' => [
        'send' => 'Invia SMS',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'SMS inviato con successo',
        'error' => 'Si è verificato un errore durante l\'invio dell\'SMS',
    ],
    'label' => 'Sms',
    'plural_label' => 'Sms (Plurale)',
    'form' => [
        'to' => [
            'label' => 'Destinatario',
            'helper' => 'Numero con prefisso internazionale, es. +39…',
        ],
        'from' => [
            'label' => 'Mittente',
            'helper' => 'Nome o numero mostrato al destinatario',
        ],
        'body' => [
            'label' => 'Testo',
            'helper' => 'Massimo 160 caratteri per SMS',
        ],
        'provider' => [
            'label' => 'Fornitore',
        ],
    ],
];
<<<<<<< HEAD
=======
=======
        'agiletelecom' => 'Agile Telecom'],
    'actions' => [
        'send' => 'Invia SMS',
        'cancel' => 'Annulla'],
    'messages' => [
        'success' => 'SMS inviato con successo',
        'error' => 'Si è verificato un errore durante l\'invio dell\'SMS'],
    'label' => 'Sms',
    'plural_label' => 'Sms (Plurale)'];
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

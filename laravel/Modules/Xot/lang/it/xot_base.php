<?php

declare(strict_types=1);

return [
    'fields' => [
        'view' => [
            'label' => 'Visualizza',
            'description' => 'Visualizza dettagli elemento',
            'placeholder' => 'Clicca per visualizzare',
            'help' => 'Visualizza i dettagli completi dell\'elemento selezionato',
        ],
        'delete' => [
            'label' => 'Elimina',
            'description' => 'Elimina elemento',
            'placeholder' => 'Clicca per eliminare',
            'help' => 'Elimina definitivamente l\'elemento selezionato',
        ],
        'edit' => [
            'label' => 'Modifica',
            'description' => 'Modifica elemento',
            'placeholder' => 'Clicca per modificare',
            'help' => 'Modifica i dati dell\'elemento selezionato',
        ],
        'detach' => [
            'label' => 'Scollega',
            'description' => 'Scollega elemento',
            'placeholder' => 'Clicca per scollegare',
            'help' => 'Rimuovi la connessione con l\'elemento selezionato',
        ],
        'attach' => [
            'label' => 'Collega',
            'description' => 'Collega elemento',
            'placeholder' => 'Clicca per collegare',
            'help' => 'Crea una connessione con l\'elemento selezionato',
        ],
        'pregnancy_certificate' => [
            'label' => 'Certificato di Gravidanza',
            'description' => 'Documento attestante lo stato di gravidanza',
            'placeholder' => 'Carica certificato di gravidanza',
            'help' => 'Carica il certificato medico che attesta lo stato di gravidanza',
        ],
        'health_card' => [
            'label' => 'Tessera Sanitaria',
            'description' => 'Tessera sanitaria del Sistema Sanitario Nazionale',
            'placeholder' => 'Carica tessera sanitaria',
            'help' => 'Carica la foto fronte/retro della tessera sanitaria',
        ],
        'identity_document' => [
            'label' => 'Documento di Identità',
            'description' => 'Documento di identità valido (CI, Patente, Passaporto)',
            'placeholder' => 'Carica documento di identità',
            'help' => 'Carica un documento di identità valido e non scaduto',
        ],
        'isee_certificate' => [
            'label' => 'Certificazione ISEE',
            'description' => 'Indicatore della Situazione Economica Equivalente',
            'placeholder' => 'Carica certificazione ISEE',
            'help' => 'Carica la certificazione ISEE per eventuali agevolazioni economiche',
        ],
        'certifications' => [
            'label' => 'Certificazioni',
            'description' => 'Certificazioni e documenti aggiuntivi',
            'placeholder' => 'Carica certificazioni',
            'help' => 'Carica eventuali certificazioni mediche o documenti aggiuntivi richiesti',
        ],
        'certification' => [
            'label' => 'Certificato',
            'description' => 'Certificato medico o documentazione sanitaria',
            'placeholder' => 'Carica certificato',
            'help' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
        ],
        'doctor_certificate' => [
            'label' => 'Certificato Medico',
            'description' => 'Certificato di abilitazione o iscrizione all\'Ordine',
            'placeholder' => 'Carica certificato medico',
            'help' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
        ],
    ],
    'validation' => [
        'required' => [
            'label' => 'Campo obbligatorio',
            'description' => 'Questo campo è obbligatorio e deve essere compilato',
        ],
        'email' => [
            'label' => 'Email non valida',
            'description' => 'Inserisci un indirizzo email valido',
        ],
        'numeric' => [
            'label' => 'Deve essere un numero',
            'description' => 'Questo campo deve contenere solo numeri',
        ],
        'date' => [
            'label' => 'Data non valida',
            'description' => 'Inserisci una data valida nel formato richiesto',
        ],
        'file' => [
            'label' => 'File non valido',
            'description' => 'Il file caricato non è valido o è troppo grande',
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'submit',
        ],
    ],
    'steps' => [
        'confirm_step' => [
            'label' => 'confirm_step',
        ],
        'date_step' => [
            'label' => 'date_step',
        ],
        'studio_step' => [
            'label' => 'studio_step',
        ],
        'search_step' => [
            'label' => 'search_step',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'attach' => [
            'label' => 'attach',
        ],
    ],
];

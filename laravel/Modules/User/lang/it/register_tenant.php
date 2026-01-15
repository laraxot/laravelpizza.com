<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Registrazione Studio',
        'group' => 'Gestione Tenant',
        'icon' => 'heroicon-o-building-office',
        'color' => 'primary',
        'sort' => 10,
    ],
    'model' => [
        'label' => 'Registrazione Studio',
        'plural' => 'Registrazioni Studio',
        'description' => 'Gestione registrazione nuovi studi medici',
    ],
    'page' => [
        'title' => 'Registrazione Nuovo Studio Medico',
        'subtitle' => 'Modulo di richiesta accreditamento',
        'description' => 'Compila tutti i campi per richiedere l\'accreditamento del tuo studio medico',
        'heading' => 'Benvenuto nella registrazione studio',
        'subheading' => 'Inserisci i dati del tuo studio per iniziare la procedura di accreditamento',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome Studio Medico',
            'placeholder' => 'Inserisci il nome completo dello studio (es. Studio Dentistico Rossi)',
            'help' => 'Nome ufficiale dello studio medico come registrato in camera di commercio',
            'validation' => [
                'required' => 'Il nome dello studio è obbligatorio',
                'min' => 'Il nome deve contenere almeno 3 caratteri',
                'max' => 'Il nome non può superare i 100 caratteri',
            ],
        ],
        'phone' => [
            'label' => 'Numero di Telefono Studio',
            'placeholder' => 'Inserisci numero telefonico principale (es. +39 06 1234567)',
            'help' => 'Numero di telefono principale dello studio per contatti diretti e urgenze',
            'validation' => [
                'required' => 'Il numero di telefono è obbligatorio',
                'regex' => 'Inserisci un numero di telefono italiano valido',
                'min' => 'Il numero deve contenere almeno 10 cifre',
            ],
        ],
        'email' => [
            'label' => 'Email Ufficiale Studio',
            'placeholder' => 'Inserisci email istituzionale (es. info@studiodentistico.it)',
            'help' => 'Indirizzo email ufficiale dello studio per comunicazioni istituzionali',
            'validation' => [
                'required' => 'L\'indirizzo email è obbligatorio',
                'email' => 'Inserisci un indirizzo email valido e funzionante',
                'unique' => 'Questo indirizzo email è già registrato per un altro studio',
                'max' => 'L\'indirizzo email non può superare i 255 caratteri',
            ],
        ],
        'address' => [
            'label' => 'Indirizzo Completo Studio',
            'placeholder' => 'Via/Piazza Nome Strada, Numero Civico, CAP Città (Provincia)',
            'help' => 'Indirizzo fisico completo dello studio medico comprensivo di CAP e provincia',
            'validation' => [
                'required' => 'L\'indirizzo dello studio è obbligatorio',
                'min' => 'L\'indirizzo deve contenere almeno 15 caratteri',
                'max' => 'L\'indirizzo non può superare i 300 caratteri',
            ],
        ],
        'director_name' => [
            'label' => 'Nome Direttore Sanitario',
            'placeholder' => 'Inserisci nome e cognome del direttore sanitario',
            'help' => 'Nome completo del medico responsabile e direttore sanitario dello studio',
            'validation' => [
                'required' => 'Il nome del direttore sanitario è obbligatorio',
                'min' => 'Il nome deve contenere almeno 5 caratteri',
                'max' => 'Il nome non può superare i 100 caratteri',
            ],
        ],
        'director_registration' => [
            'label' => 'Numero Iscrizione Albo Medico',
            'placeholder' => 'Inserisci numero iscrizione all\'ordine dei medici',
            'help' => 'Numero di iscrizione del direttore sanitario all\'albo professionale',
            'validation' => [
                'required' => 'Il numero di iscrizione all\'albo è obbligatorio',
                'numeric' => 'Il numero di iscrizione deve contenere solo cifre',
                'min' => 'Il numero di iscrizione deve contenere almeno 3 cifre',
            ],
        ],
        'vat_number' => [
            'label' => 'Partita IVA Studio',
            'placeholder' => 'Inserisci partita IVA (11 cifre)',
            'help' => 'Partita IVA dello studio medico registrata presso l\'Agenzia delle Entrate',
            'validation' => [
                'required' => 'La partita IVA è obbligatoria',
                'regex' => 'La partita IVA deve essere composta da esattamente 11 cifre',
                'unique' => 'Questa partita IVA è già registrata per un altro studio',
            ],
        ],
        'specialization' => [
            'label' => 'Specializzazioni Mediche',
            'placeholder' => 'Seleziona le specializzazioni offerte dal tuo studio',
            'help' => 'Elenco delle specializzazioni mediche e servizi offerti dallo studio',
            'options' => [
                'odontoiatria' => 'Odontoiatria Generale',
                'ortodonzia' => 'Ortodonzia',
                'chirurgia_orale' => 'Chirurgia Orale',
                'implantologia' => 'Implantologia',
                'parodontologia' => 'Parodontologia',
                'endodonzia' => 'Endodonzia',
                'protesi' => 'Protesi Dentaria',
                'odontoiatria_pediatrica' => 'Odontoiatria Pediatrica',
                'medicina_generale' => 'Medicina Generale',
                'cardiologia' => 'Cardiologia',
                'dermatologia' => 'Dermatologia',
                'ginecologia' => 'Ginecologia',
                'ortopedia' => 'Ortopedia',
                'altro' => 'Altra Specializzazione',
            ],
        ],
        'website' => [
            'label' => 'Sito Web Studio',
            'placeholder' => 'https://www.tuostudio.it (opzionale)',
            'help' => 'Sito web ufficiale dello studio medico (campo facoltativo)',
            'validation' => [
                'url' => 'Inserisci un URL valido che inizi con http:// o https://',
            ],
        ],
        'staff_count' => [
            'label' => 'Numero Operatori',
            'placeholder' => 'Indica il numero totale di medici e operatori',
            'help' => 'Numero totale di medici, odontoiatri e operatori sanitari che lavorano nello studio',
            'validation' => [
                'required' => 'Il numero di operatori è obbligatorio',
                'numeric' => 'Inserisci un numero valido',
                'min' => 'Lo studio deve avere almeno 1 operatore',
                'max' => 'Il numero massimo consentito è 100 operatori',
            ],
        ],
        'privacy_acceptance' => [
            'label' => 'Consenso Trattamento Dati',
            'placeholder' => 'Accetto il trattamento dei dati secondo GDPR',
            'help' => 'Consenso obbligatorio al trattamento dei dati personali secondo Regolamento UE 679/2016',
            'validation' => [
                'accepted' => 'È obbligatorio accettare l\'informativa sulla privacy per procedere',
            ],
        ],
        'terms_acceptance' => [
            'label' => 'Accettazione Termini di Servizio',
            'placeholder' => 'Accetto i termini e condizioni del servizio',
            'help' => 'Accettazione dei termini e condizioni per l\'utilizzo della piattaforma',
            'validation' => [
                'accepted' => 'È obbligatorio accettare i termini e condizioni per procedere',
            ],
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'Invia Richiesta Accreditamento',
            'modal_heading' => 'Conferma Invio Richiesta',
            'modal_description' => 'Sei sicuro di voler inviare la richiesta di accreditamento con i dati inseriti?',
            'success' => 'Richiesta di accreditamento inviata con successo',
            'error' => 'Errore durante l\'invio della richiesta di accreditamento',
            'confirmation' => 'Confermi l\'invio della richiesta con i dati inseriti?',
            'processing' => 'Invio richiesta in corso...',
        ],
        'save_draft' => [
            'label' => 'Salva Bozza',
            'modal_heading' => 'Salva Bozza Richiesta',
            'modal_description' => 'Salva i dati inseriti come bozza per completare successivamente',
            'success' => 'Bozza salvata con successo',
            'error' => 'Errore durante il salvataggio della bozza',
        ],
        'clear_form' => [
            'label' => 'Cancella Tutto',
            'modal_heading' => 'Conferma Cancellazione',
            'modal_description' => 'Sei sicuro di voler cancellare tutti i dati inseriti nel modulo?',
            'success' => 'Modulo cancellato',
            'error' => 'Errore durante la cancellazione del modulo',
            'confirmation' => 'Tutti i dati inseriti verranno persi definitivamente',
        ],
        'upload_documents' => [
            'label' => 'Carica Documenti',
            'modal_heading' => 'Caricamento Documentazione',
            'modal_description' => 'Carica i documenti richiesti per completare la richiesta di accreditamento',
            'success' => 'Documenti caricati con successo',
            'error' => 'Errore durante il caricamento dei documenti',
        ],
        'register' => [
            'label' => 'register',
            'tooltip' => 'register',
            'icon' => 'register',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
    ],
    'steps' => [
        'basic_info' => [
            'label' => 'Informazioni Base',
            'description' => 'Dati principali dello studio medico',
            'icon' => 'heroicon-o-building-office',
        ],
        'contact_info' => [
            'label' => 'Contatti e Ubicazione',
            'description' => 'Recapiti e indirizzo dello studio',
            'icon' => 'heroicon-o-map-pin',
        ],
        'professional_info' => [
            'label' => 'Informazioni Professionali',
            'description' => 'Dati del direttore sanitario e specializzazioni',
            'icon' => 'heroicon-o-academic-cap',
        ],
        'legal_info' => [
            'label' => 'Dati Legali',
            'description' => 'Partita IVA e documentazione ufficiale',
            'icon' => 'heroicon-o-document-text',
        ],
        'privacy_consent' => [
            'label' => 'Privacy e Consensi',
            'description' => 'Accettazione termini e trattamento dati',
            'icon' => 'heroicon-o-shield-check',
        ],
    ],
    'messages' => [
        'welcome' => 'Benvenuto nella procedura di registrazione studio medico',
        'form_instructions' => 'Compila tutti i campi obbligatori per procedere con la richiesta di accreditamento',
        'validation_errors' => 'Controlla i campi evidenziati e correggi gli errori segnalati',
        'draft_saved' => 'Bozza salvata automaticamente',
        'upload_requirements' => 'Documenti richiesti: Certificato Camera di Commercio, Iscrizione Albo, Partita IVA',
        'processing_time' => 'I tempi di valutazione della richiesta sono di 5-10 giorni lavorativi',
        'contact_support' => 'Per assistenza contatta il supporto tecnico',
        'data_security' => 'Tutti i dati sono trattati in modo sicuro secondo normative GDPR',
    ],
    'notifications' => [
        'request_received' => 'Richiesta di accreditamento ricevuta e presa in carico',
        'under_review' => 'La tua richiesta è in fase di valutazione',
        'approved' => 'Richiesta approvata! Puoi ora accedere alla piattaforma',
        'rejected' => 'Richiesta respinta. Controlla la documentazione e riprova',
        'integration_needed' => 'Richiesta integrazione documenti per completare l\'accreditamento',
        'expiring_soon' => 'La tua richiesta scadrà tra :days giorni. Completa la registrazione',
    ],
    'help' => [
        'general' => 'Questa procedura ti permetterà di richiedere l\'accreditamento del tuo studio medico',
        'required_documents' => 'Assicurati di avere pronti tutti i documenti richiesti prima di iniziare',
        'processing_time' => 'La valutazione delle richieste richiede normalmente 5-10 giorni lavorativi',
        'contact_info' => 'I dati di contatto inseriti verranno utilizzati per tutte le comunicazioni ufficiali',
        'data_protection' => 'Tutti i dati sono protetti secondo le normative europee GDPR',
    ],
    'label' => '',
    'plural_label' => '',
];

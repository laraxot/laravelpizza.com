<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Registrazione Studio',
        'group' => 'Gestione Tenant',
        'icon' => 'heroicon-o-building-office',
        'color' => 'primary',
        'sort' => '10',
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
                'required' => 'Der Praxisname ist erforderlich',
                'min' => 'Der Name muss mindestens 3 Zeichen enthalten',
                'max' => 'Der Name darf 100 Zeichen nicht überschreiten',
            ],
        ],
        'phone' => [
            'label' => 'Numero di Telefono Studio',
            'placeholder' => 'Inserisci numero telefonico principale (es. +39 06 1234567)',
            'help' => 'Numero di telefono principale dello studio per contatti diretti e urgenze',
            'validation' => [
                'required' => 'Die Telefonnummer ist erforderlich',
                'regex' => 'Bitte geben Sie eine gültige italienische Telefonnummer ein',
                'min' => 'Die Nummer muss mindestens 10 Ziffern enthalten',
            ],
        ],
        'email' => [
            'label' => 'Email Ufficiale Studio',
            'placeholder' => 'Inserisci email istituzionale (es. info@studiodentistico.it)',
            'help' => 'Indirizzo email ufficiale dello studio per comunicazioni istituzionali',
            'validation' => [
                'required' => 'Die E-Mail-Adresse ist erforderlich',
                'email' => 'Bitte geben Sie eine gültige und funktionierende E-Mail-Adresse ein',
                'unique' => 'Diese E-Mail-Adresse ist bereits für eine andere Praxis registriert',
                'max' => 'Die E-Mail-Adresse darf 255 Zeichen nicht überschreiten',
            ],
        ],
        'address' => [
            'label' => 'Vollständige Praxisadresse',
            'placeholder' => 'Straße/Platz Straßenname, Hausnummer, PLZ Stadt (Provinz)',
            'tooltip' => 'Vollständige Adresse der medizinischen Praxis',
            'helper_text' => 'Geben Sie die vollständige physische Adresse der medizinischen Praxis einschließlich Postleitzahl und Provinz ein',
            'description' => 'Vollständige Adresse der medizinischen Praxis für die Registrierung des Mandanten',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
            'validation' => [
                'required' => 'Die Praxisadresse ist erforderlich',
                'min' => 'Die Adresse muss mindestens 15 Zeichen enthalten',
                'max' => 'Die Adresse darf nicht mehr als 300 Zeichen haben',
            ],
        ],
        'director_name' => [
            'label' => 'Nome Direttore Sanitario',
            'placeholder' => 'Inserisci nome e cognome del direttore sanitario',
            'help' => 'Nome completo del medico responsabile e direttore sanitario dello studio',
            'validation' => [
                'required' => 'Der Name des ärztlichen Leiters ist erforderlich',
                'min' => 'Der Name muss mindestens 5 Zeichen enthalten',
                'max' => 'Der Name darf 100 Zeichen nicht überschreiten',
            ],
        ],
        'director_registration' => [
            'label' => 'Numero Iscrizione Albo Medico',
            'placeholder' => 'Inserisci numero iscrizione all\'ordine dei medici',
            'help' => 'Numero di iscrizione del direttore sanitario all\'albo professionale',
            'validation' => [
                'required' => 'Die Registrierungsnummer ist erforderlich',
                'numeric' => 'Die Registrierungsnummer darf nur Ziffern enthalten',
                'min' => 'Die Registrierungsnummer muss mindestens 3 Ziffern enthalten',
            ],
        ],
        'vat_number' => [
            'label' => 'Partita IVA Studio',
            'placeholder' => 'Inserisci partita IVA (11 cifre)',
            'help' => 'Partita IVA dello studio medico registrata presso l\'Agenzia delle Entrate',
            'validation' => [
                'required' => 'Die Umsatzsteuer-Identifikationsnummer ist erforderlich',
                'regex' => 'Die Umsatzsteuer-Identifikationsnummer muss genau aus 11 Ziffern bestehen',
                'unique' => 'Diese Umsatzsteuer-Identifikationsnummer ist bereits für eine andere Praxis registriert',
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
                'required' => 'Die Anzahl der Mitarbeiter ist erforderlich',
                'numeric' => 'Bitte geben Sie eine gültige Zahl ein',
                'min' => 'Die Praxis muss mindestens 1 Mitarbeiter haben',
                'max' => 'Die maximale Anzahl beträgt 100 Mitarbeiter',
            ],
        ],
        'privacy_acceptance' => [
            'label' => 'Consenso Trattamento Dati',
            'placeholder' => 'Accetto il trattamento dei dati secondo GDPR',
            'help' => 'Consenso obbligatorio al trattamento dei dati personali secondo Regolamento UE 679/2016',
            'validation' => [
                'accepted' => 'Sie müssen die Datenschutzerklärung akzeptieren, um fortzufahren',
            ],
        ],
        'terms_acceptance' => [
            'label' => 'Accettazione Termini di Servizio',
            'placeholder' => 'Accetto i termini e condizioni del servizio',
            'help' => 'Accettazione dei termini e condizioni per l\'utilizzo della piattaforma',
            'validation' => [
                'accepted' => 'Sie müssen die Nutzungsbedingungen akzeptieren, um fortzufahren',
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
];

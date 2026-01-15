<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Registrazione',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 50,
    ],
    'pages' => [
        'registration' => [
            'title' => 'Registrazione Utente',
            'subtitle' => 'Completa la registrazione seguendo tutti i passaggi',
            'description' => 'Inserisci tutte le informazioni richieste per completare la tua registrazione',
        ],
        'wizard' => [
            'title' => 'Wizard di Registrazione',
            'subtitle' => 'Procedura guidata per la registrazione',
            'description' => 'Segui la procedura guidata per completare la registrazione',
        ],
    ],
    'steps' => [
        'personal_info' => [
            'label' => 'Dati Personali',
            'description' => 'Inserisci i tuoi dati anagrafici personali',
            'icon' => 'heroicon-o-user',
            'help' => 'Compila tutti i campi obbligatori con i tuoi dati personali',
        ],
        'contacts' => [
            'label' => 'Contatti',
            'description' => 'Inserisci i tuoi dati di contatto',
            'icon' => 'heroicon-o-phone',
            'help' => 'Fornisci i tuoi recapiti per essere contattato',
        ],
        'credentials' => [
            'label' => 'Credenziali',
            'description' => 'Imposta email e password per l\'accesso',
            'icon' => 'heroicon-o-key',
            'help' => 'Scegli una password sicura per proteggere il tuo account',
        ],
        'privacy_step' => [
            'label' => 'Privacy e Consensi',
            'description' => 'Accetta i termini e le condizioni',
            'icon' => 'heroicon-o-shield-check',
            'help' => 'Leggi attentamente e accetta i consensi richiesti',
        ],
        'documents_step' => [
            'label' => 'Documenti',
            'description' => 'Carica i documenti richiesti',
            'icon' => 'heroicon-o-document',
            'help' => 'Carica i documenti necessari per la verifica dell\'identità',
        ],
        'professional' => [
            'label' => 'Informazioni Professionali',
            'description' => 'Inserisci le tue informazioni professionali',
            'icon' => 'heroicon-o-briefcase',
            'help' => 'Completa il tuo profilo professionale con esperienze e competenze',
        ],
        'availability' => [
            'label' => 'Disponibilità',
            'description' => 'Definisci i tuoi orari di disponibilità',
            'icon' => 'heroicon-o-calendar',
            'help' => 'Imposta quando sei disponibile per appuntamenti o contatti',
        ],
        'moderation' => [
            'label' => 'Moderazione',
            'description' => 'Stato di moderazione del profilo',
            'icon' => 'heroicon-o-check-badge',
            'help' => 'Il tuo profilo sarà verificato dal nostro team',
        ],
        'personal_data_step' => [
            'label' => 'Informazioni Aggiuntive',
            'description' => 'Completa con altre informazioni personali',
            'icon' => 'heroicon-o-identification',
            'help' => 'Fornisci informazioni aggiuntive per completare il profilo',
        ],
        'pre_visit_step' => [
            'label' => 'Pre-Visita',
            'description' => 'Informazioni preliminari per la visita',
            'icon' => 'heroicon-o-clipboard-document-list',
            'help' => 'Compila le informazioni necessarie per la pre-visita',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome',
            'help' => 'Il tuo nome di battesimo',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il tuo cognome',
            'help' => 'Il tuo cognome di famiglia',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci il tuo indirizzo email',
            'help' => 'Indirizzo email valido che utilizzerai per accedere',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci una password sicura',
            'help' => 'Minimo 8 caratteri con lettere, numeri e simboli',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Ripeti la password',
            'help' => 'Inserisci nuovamente la password per confermarla',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Numero di telefono per essere contattato',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci il tuo indirizzo completo',
            'help' => 'Via/Piazza e numero civico di residenza',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città',
            'help' => 'Città di residenza o domicilio',
        ],
        'state' => [
            'label' => 'Provincia/Stato',
            'placeholder' => 'Inserisci la provincia o stato',
            'help' => 'Provincia italiana o stato se estero',
        ],
        'zip' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il CAP',
            'help' => 'Codice di avviamento postale',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Seleziona il paese',
            'help' => 'Paese di residenza',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il codice fiscale',
            'help' => 'Codice fiscale italiano (16 caratteri)',
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'Seleziona la data di nascita',
            'help' => 'La tua data di nascita nel formato gg/mm/aaaa',
        ],
        'birth_place' => [
            'label' => 'Luogo di Nascita',
            'placeholder' => 'Inserisci il luogo di nascita',
            'help' => 'Città e provincia di nascita',
        ],
        'gender' => [
            'label' => 'Genere',
            'placeholder' => 'Seleziona il genere',
            'help' => 'Genere anagrafico',
        ],
        'nationality' => [
            'label' => 'Nazionalità',
            'placeholder' => 'Inserisci la nazionalità',
            'help' => 'Nazionalità secondo il documento d\'identità',
        ],
        'document_type' => [
            'label' => 'Tipo Documento',
            'placeholder' => 'Seleziona il tipo di documento',
            'help' => 'Carta d\'identità, patente, passaporto',
        ],
        'document_number' => [
            'label' => 'Numero Documento',
            'placeholder' => 'Inserisci il numero del documento',
            'help' => 'Numero identificativo del documento',
        ],
        'document_issue_date' => [
            'label' => 'Data Rilascio',
            'placeholder' => 'Seleziona la data di rilascio',
            'help' => 'Data in cui il documento è stato rilasciato',
        ],
        'document_expiry_date' => [
            'label' => 'Data Scadenza',
            'placeholder' => 'Seleziona la data di scadenza',
            'help' => 'Data di scadenza del documento',
        ],
        'document_issuing_authority' => [
            'label' => 'Autorità Rilascio',
            'placeholder' => 'Inserisci l\'autorità che ha rilasciato il documento',
            'help' => 'Comune, questura o altro ente che ha rilasciato il documento',
        ],
        'document_file' => [
            'label' => 'File Documento',
            'placeholder' => 'Carica una scansione del documento',
            'help' => 'Scansione fronte/retro del documento in formato PDF o JPG',
        ],
        'photo' => [
            'label' => 'Foto Profilo',
            'placeholder' => 'Carica una foto profilo',
            'help' => 'Foto recente per il profilo, formato quadrato consigliato',
        ],
        'cv' => [
            'label' => 'Curriculum Vitae',
            'placeholder' => 'Carica il tuo CV',
            'help' => 'Curriculum vitae aggiornato in formato PDF',
        ],
        'bio' => [
            'label' => 'Biografia',
            'placeholder' => 'Scrivi una breve biografia',
            'help' => 'Descrizione di te stesso e delle tue competenze',
        ],
        'professional_title' => [
            'label' => 'Titolo Professionale',
            'placeholder' => 'Inserisci il tuo titolo professionale',
            'help' => 'La tua qualifica o posizione professionale principale',
        ],
        'terms' => [
            'label' => 'Termini e Condizioni',
            'placeholder' => 'Accetta i termini e condizioni',
            'help' => 'Devi accettare i termini e condizioni per procedere',
        ],
        'privacy' => [
            'label' => 'Informativa Privacy',
            'placeholder' => 'Accetta l\'informativa sulla privacy',
            'help' => 'Consenso obbligatorio al trattamento dei dati personali',
        ],
        'marketing' => [
            'label' => 'Comunicazioni Marketing',
            'placeholder' => 'Accetta di ricevere comunicazioni promozionali',
            'help' => 'Consenso facoltativo per ricevere newsletter e promozioni',
        ],
        'moderation_status' => [
            'label' => 'Stato Moderazione',
            'placeholder' => 'Stato attuale della moderazione',
            'help' => 'Lo stato di verifica del profilo da parte degli amministratori',
        ],
        'moderation_notes' => [
            'label' => 'Note Moderazione',
            'placeholder' => 'Note del moderatore',
            'help' => 'Eventuali annotazioni del team di moderazione',
        ],
    ],
    'actions' => [
        'register' => [
            'label' => 'Registrati',
            'tooltip' => 'Completa la registrazione',
            'modal_heading' => 'Conferma Registrazione',
            'modal_description' => 'Confermi di voler completare la registrazione con i dati inseriti?',
            'success' => 'Registrazione completata con successo',
            'error' => 'Si è verificato un errore durante la registrazione',
        ],
        'previous' => [
            'label' => 'Precedente',
            'tooltip' => 'Torna al passaggio precedente',
        ],
        'next' => [
            'label' => 'Successivo',
            'tooltip' => 'Procedi al passaggio successivo',
        ],
        'save_draft' => [
            'label' => 'Salva Bozza',
            'tooltip' => 'Salva i dati inseriti come bozza',
            'success' => 'Bozza salvata con successo',
            'error' => 'Errore durante il salvataggio della bozza',
        ],
    ],
    'messages' => [
        'welcome' => 'Benvenuto nella procedura di registrazione',
        'step_completed' => 'Passaggio completato con successo',
        'all_steps_completed' => 'Tutti i passaggi sono stati completati',
        'validation_errors' => 'Controlla i campi evidenziati e correggi gli errori',
        'required_fields' => 'I campi contrassegnati con * sono obbligatori',
        'save_progress' => 'I tuoi progressi sono stati salvati automaticamente',
        'errors' => [
            'general' => 'Si è verificato un errore durante la registrazione',
            'email_exists' => 'Questo indirizzo email è già registrato',
            'validation' => 'Alcuni campi contengono errori, controllali e riprova',
        ],
        'success' => [
            'registration' => 'Registrazione completata con successo! Riceverai una email di conferma',
            'step' => 'Passaggio completato correttamente',
        ],
    ],
    'label' => '',
    'plural_label' => '',
];

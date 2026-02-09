<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Informazioni Personali',
        'user_info_description' => 'Inserisci i tuoi dati personali per creare l\'account',
        'required_consents' => 'Consenso Obbligatorio',
        'required_consents_description' => 'Per procedere con la registrazione, devi accettare le seguenti condizioni per il trattamento dei tuoi dati personali',
        'optional_consents' => 'Consenso Facoltativo',
        'optional_consents_description' => 'Questi consensi sono opzionali e non influenzano la tua registrazione. Potrai modificarli in qualsiasi momento dalla tua dashboard privacy.',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'email' => 'Indirizzo Email',
        'password' => 'Password',
        'password_confirmation' => 'Conferma Password',
    ],

    // === CONSENTS ===
    'consents' => [
        'privacy_policy_label' => 'Ho letto e compreso l\'Informativa Privacy e accetto il trattamento dei miei dati personali come descritto nella policy.',
        'privacy_policy_hint' => 'Informativa completa ai sensi degli Art. 13 e 14 del Regolamento (UE) 2016/679 (GDPR)',
        'privacy_policy_required' => 'Devi accettare l\'informativa privacy per procedere con la registrazione.',
        
        'terms_label' => 'Ho letto e accetto i Termini e Condizioni d\'uso',
        'terms_hint' => 'Contratto di servizio ai sensi dell\'Art. 6(1)(b) del Regolamento (UE) 2016/679 (GDPR)',
        'terms_required' => 'Devi accettare i termini e condizioni per procedere con la registrazione.',
        
        'data_processing_label' => 'Acconsento al trattamento dei miei dati personali per la creazione e gestione del mio account utente',
        'data_processing_hint' => 'Base giuridica: Esecuzione del contratto (Art. 6(1)(b) GDPR)',
        'data_processing_required' => 'Devi accettare il trattamento dei dati personali per procedere con la registrazione.',
        
        'marketing_label' => 'Acconsento a ricevere comunicazioni marketing e promozionali relative ad eventi meetup e nuove funzionalità',
        'marketing_hint' => 'Il consenso è facoltativo e puoi revocarlo in qualsiasi momento senza conseguenze.',
        
        'profiling_label' => 'Acconsento all\'analisi delle mie preferenze per personalizzare l\'esperienza utente',
        'profiling_hint' => 'Analisi basata su dati di navigazione e interazioni per migliorare i nostri servizi.',
        
        'analytics_label' => 'Acconsento all\'analisi statistica anonima dei dati di navigazione per migliorare le prestazioni del sito',
        'analytics_hint' => 'Dati raccolti in forma anonima e aggregata per scopi statistici.',
        
        'third_party_label' => 'Acconsento alla condivisione dei miei dati con partner selezionati per servizi integrati',
        'third_party_hint' => 'Solo partner conformi a GDPR e per finalità specifiche e limitate.',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'La password deve contenere almeno 12 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale.',
    ],

    // === MESSAGES ===
    'required_consent_missing' => 'Devi accettare tutti i consensi obbligatori per procedere con la registrazione.',
    
    'success' => 'Registrazione completata con successo! Il tuo account è stato creato in conformità con il GDPR.',
    'success_message' => 'Benvenuto in LaravelPizza Meetups! La tua registrazione è stata completata e tutti i tuoi consensi sono stati registrati correttamente.',
    
    'error' => 'Errore durante la registrazione',
    'error_message' => 'Si è verificato un errore durante la registrazione. Riprova più tardi. Se il problema persiste, contatta il nostro supporto.',
];
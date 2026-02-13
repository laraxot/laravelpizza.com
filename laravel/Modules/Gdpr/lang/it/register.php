<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'register' => [
        'title' => 'Unisciti alla Pizza Revolution 🍕',
        'subtitle' => 'Entra nella community di 5.000+ developer e appassionati. Meetup esclusivi, tutorial e networking ti aspettano.',
        'submit' => 'Crea il mio account gratis',
        'submitting' => 'Stiamo preparando il tuo account...',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Mario',
            'helper_text' => 'Inserisci il tuo nome per completare il profilo',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Rossi',
            'helper_text' => 'Inserisci il tuo cognome per completare il profilo',
        ],
        'email' => [
            'label' => 'La tua migliore Email',
            'placeholder' => 'mario.rossi@esempio.com',
            'helper_text' => 'Ti invieremo un\'email di conferma all\'indirizzo indicato',
        ],
        'password' => [
            'label' => 'Password sicura',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Deve contenere almeno 12 caratteri, maiuscola, minuscola, numero e simbolo',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Ripeti la password per confermare',
        ],
    ],

    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Informazioni Personali',
        'user_info_description' => 'Inserisci i tuoi dati personali per creare il tuo account',
        'required_consents' => 'Consensi Obbligatori',
        'required_consents_description' => 'Per procedere con la registrazione, devi accettare le seguenti condizioni per il trattamento dei tuoi dati personali',
        'optional_consents' => 'Consensi Facoltativi',
        'optional_consents_description' => 'Questi consensi sono facoltativi e non influenzano la tua registrazione. Puoi modificarli in qualsiasi momento dal tuo profilo.',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Consensi Privacy',
        'privacy_policy_label' => 'Ho letto e compreso l\'Informativa Privacy e accetto il trattamento dei miei dati personali come descritto nell\'informativa',
        'privacy_policy_hint' => 'Informativa completa ai sensi degli articoli 13 e 14 del Regolamento (UE) 2016/679 (GDPR)',
        'privacy_policy_required' => 'Devi accettare l\'informativa privacy per procedere.',
        'privacy_checkbox_html' => 'Ho letto l\'<a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Informativa Privacy</a>',
        'terms_label' => 'Ho letto e accetto i Termini e Condizioni',
        'terms_hint' => 'Contratto di servizio ai sensi dell\'articolo 6(1)(b) del Regolamento (UE) 2016/679 (GDPR)',
        'terms_required' => 'Devi accettare i termini e condizioni per procedere.',
        'terms_checkbox_html' => 'Accetto i <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Termini e Condizioni</a>',
        'marketing_label' => 'Voglio ricevere consigli sulla pizza e inviti ai meetup (facoltativo)',
        'marketing_hint' => 'Il consenso è facoltativo e puoi revocarlo in qualsiasi momento senza conseguenze.',
    ],

    // === ACTIONS ===
    'actions' => [
        'read_privacy_policy' => 'Leggi informativa privacy',
        'read_terms' => 'Leggi termini e condizioni',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'La password deve contenere almeno 12 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale.',
    ],

    // === MESSAGES ===
    'already_registered' => 'Hai già un account?',
    'login' => 'Accedi subito',
    'success' => 'Benvenuto nella famiglia! 🎉',
    'success_message' => 'Il tuo account è pronto. Ora puoi esplorare tutti i meetup!',
    'error' => 'Ops! Qualcosa è andato storto.',
    'error_message' => 'Riprova tra un istante, stiamo sistemando il problema.',
];

<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'title' => 'Unisciti alla Pizza Revolution 🍕',
    'subtitle' => 'Entra nella nostra community di sviluppatori e appassionati. Meetup esclusivi, tutorial e networking ti aspettano.',
    'submit' => 'Crea il mio account gratis',
    'submitting' => 'Stiamo preparando il tuo account...',

    // Alias per accessi legacy (gdpr::register.register.submit)
    'register' => [
        'submit' => 'Crea il mio account gratis',
        'submitting' => 'Stiamo preparando il tuo account...',
    ],

    // === STATS ===
    'stats' => [
        'active_developers' => 'Community in Crescita',
        'monthly_meetups' => 'Prossimi Eventi',
        'community_support' => 'Supporto 24/7',
    ],

    // === FORM ===
    'form' => [
        'cta_title' => 'Crea il tuo account gratuito',
        'cta_subtitle' => 'Nessuna carta di credito richiesta',
        'terms_notice' => 'Registrandoti accetti i nostri Termini e Privacy Policy',
    ],

    // === BENEFITS ===
    'benefits' => [
        'community' => [
            'title' => 'Entra nella Community',
            'description' => 'Connettiti con professionisti e appassionati Laravel',
            'cta' => 'Accesso gratuito immediato',
        ],
        'tutorials' => [
            'title' => 'Tutorial & Workshop Esclusivi',
            'description' => 'Accesso prioritario a contenuti premium e formazione',
            'cta' => 'Ottieni accesso esclusivo', // Changed from 'Valore €997/anno - Gratis per membri'
        ],
        'networking' => [
            'title' => 'Networking & Carriera',
            'description' => 'Opportunità di collaborazione e crescita professionale',
            'cta' => 'Fatti assumere dalle migliori aziende',
        ],
    ],

    // === SOCIAL PROOF ===
    'social_proof' => 'Unisciti alla community LaravelPizza',

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
            'helper_text' => 'Ti invieremo un\'email di conferma',
        ],
        'password' => [
            'label' => 'Password sicura',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Minimo 12 caratteri, maiuscola, minuscola, numero e simbolo',
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
        'user_info_description' => 'Inserisci i tuoi dati personali',
        'required_consents' => 'Consensi Obbligatori',
        'required_consents_description' => 'Devi accettare le seguenti condizioni',
        'optional_consents' => 'Consensi Facoltativi',
        'optional_consents_description' => 'Puoi modificarli in qualsiasi momento',
        'trust_badges' => 'Badge di fiducia',
        'registration_form' => 'Form di registrazione',
        'benefits' => 'Vantaggi',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Consensi Privacy',
        'privacy_policy_label' => 'Ho letto e accetto l\'Informativa Privacy',
        'privacy_policy_hint' => 'Ai sensi degli artt. 13 e 14 GDPR',
        'privacy_policy_required' => 'Devi accettare la privacy policy',
        'terms_label' => 'Ho letto e accetto i Termini e Condizioni',
        'terms_hint' => 'Ai sensi dell\'art. 6(1)(b) GDPR',
        'terms_required' => 'Devi accettare i termini e condizioni',
        'marketing_label' => 'Voglio ricevere aggiornamenti e inviti (facoltativo)',
        'marketing_hint' => 'Puoi revocarlo in qualsiasi momento',
    ],

    // === ACTIONS ===
    'actions' => [
        'read_privacy_policy' => 'Leggi privacy policy',
        'read_terms' => 'Leggi termini e condizioni',
    ],

    // === MESSAGES ===
    'already_registered' => 'Hai già un account?',
    'login' => 'Accedi subito',
    'success' => 'Benvenuto! 🎉',
    'success_message' => 'Il tuo account è pronto',
    'error' => 'Errore di registrazione',
    'error_message' => 'Riprova più tardi',
];

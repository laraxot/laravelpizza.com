<?php

declare(strict_types=1);

return [
    'register' => [
        'title' => 'Crea il tuo account',
        'subtitle' => 'Unisciti alla community di sviluppatori Laravel più golosa d\'Italia!',
        'submit' => 'Crea il mio account gratis',
        'submitting' => 'Creazione in corso...',
        'already_have_account' => 'Hai già un account?',
        'already_registered' => 'Hai già un account?',
        'login' => 'Accedi subito',
        'sections' => [
            'user_info' => 'Informazioni Personali',
            'user_info_description' => 'Inserisci i tuoi dati per creare l\'account',
            'required_consents' => 'Consensi Obbligatori',
            'required_consents_description' => 'Per procedere con la registrazione, devi accettare le seguenti condizioni per il trattamento dei tuoi dati personali',
            'optional_consents' => 'Consensi Facoltativi',
            'optional_consents_description' => 'Questi consensi sono facoltativi e non influenzano la tua registrazione. Puoi modificarli in qualsiasi momento dal tuo profilo.',
        ],
        'fields' => [
            'first_name' => [
                'label' => 'Nome',
                'placeholder' => 'Inserisci il tuo nome',
            ],
            'last_name' => [
                'label' => 'Cognome',
                'placeholder' => 'Inserisci il tuo cognome',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Inserisci la tua email',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Crea una password sicura',
            ],
            'password_confirmation' => [
                'label' => 'Conferma Password',
                'placeholder' => 'Ripeti la password',
            ],
        ],
        'consents' => [
            'title' => 'Consensi',
            'privacy_policy_label' => 'Informativa Privacy',
            'privacy_policy_hint' => 'Ho letto e compreso l\'Informativa Privacy e accetto il trattamento dei miei dati personali come descritto nell\'informativa',
            'terms_label' => 'Termini e Condizioni',
            'terms_hint' => 'Ho letto e accetto i Termini e Condizioni',
            'marketing_label' => 'Consenso Marketing',
            'marketing_hint' => 'Voglio ricevere consigli sulla pizza e inviti ai meetup',
            'privacy_complete' => 'Informativa completa ai sensi degli articoli 13 e 14 del Regolamento (UE) 2016/679 (GDPR)',
            'terms_complete' => 'Contratto di servizio ai sensi dell\'articolo 6(1)(b) del Regolamento (UE) 2016/679 (GDPR)',
        ],
        'actions' => [
            'read_privacy_policy' => 'Leggi informativa privacy',
            'read_terms' => 'Leggi termini e condizioni',
        ],
        'links' => [
            'and' => 'e',
        ],
    ],
    'navigation' => [
        'name' => 'GDPR',
        'plural' => 'GDPR',
        'group' => [
            'name' => 'Privacy',
            'description' => 'Gestione della privacy e protezione dei dati',
        ],
        'label' => 'Dashboard GDPR',
        'sort' => 79,
        'icon' => 'gdpr-dashboard-animated',
    ],
    'sections' => [
        'dashboard' => [
            'title' => 'Dashboard GDPR',
            'description' => 'Panoramica della conformità GDPR',
            'sort' => 80,
            'icon' => 'gdpr-dashboard-animated',
        ],
        'consent' => [
            'title' => 'Consensi',
            'description' => 'Gestione dei consensi degli utenti',
            'sort' => 81,
            'icon' => 'gdpr-consent-animated',
        ],
        'treatment' => [
            'title' => 'Trattamenti',
            'description' => 'Registro dei trattamenti dati',
            'sort' => 82,
            'icon' => 'gdpr-treatment-animated',
        ],
        'profile' => [
            'title' => 'Profili',
            'description' => 'Gestione dei profili di privacy',
            'sort' => 83,
            'icon' => 'gdpr-profile-animated',
        ],
        'event' => [
            'title' => 'Eventi',
            'description' => 'Registro degli eventi privacy',
            'sort' => 84,
            'icon' => 'gdpr-event-animated',
        ],
    ],
    'widgets' => [
        'consent_summary' => 'Riepilogo Consensi',
        'treatment_status' => 'Stato Trattamenti',
        'recent_events' => 'Eventi Recenti',
        'compliance_score' => 'Indice di Conformità',
    ],
    'metrics' => [
        'active_consents' => 'Consensi Attivi',
        'pending_requests' => 'Richieste in Sospeso',
        'data_breaches' => 'Violazioni Dati',
        'compliance_level' => 'Livello Conformità',
    ],
    'status' => [
        'compliant' => 'Conforme',
        'partially_compliant' => 'Parzialmente Conforme',
        'non_compliant' => 'Non Conforme',
        'needs_review' => 'Necessita Revisione',
    ],
    'actions' => [
        'export_data' => 'Esporta Dati',
        'generate_report' => 'Genera Report',
        'review_compliance' => 'Verifica Conformità',
        'update_policies' => 'Aggiorna Policies',
    ],
    'reports' => [
        'compliance' => 'Report Conformità',
        'consent' => 'Report Consensi',
        'treatment' => 'Report Trattamenti',
        'event' => 'Report Eventi',
    ],
    'notifications' => [
        'consent_expired' => 'Consenso Scaduto',
        'review_needed' => 'Revisione Necessaria',
        'breach_detected' => 'Violazione Rilevata',
        'policy_updated' => 'Policy Aggiornata',
    ],
];

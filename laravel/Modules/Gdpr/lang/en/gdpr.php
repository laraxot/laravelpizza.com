<?php

declare(strict_types=1);

return [
    'register' => [
        'title' => 'Create your account',
        'subtitle' => 'Fill in the form to create your personal account.',
        'submit' => 'Create account',
        'submitting' => 'Creating account...',
        'already_have_account' => 'Already have an account?',
        'already_registered' => 'Already have an account?',
        'login' => 'Login now',
        'sections' => [
            'user_info' => 'Personal Information',
            'user_info_description' => 'Enter your details to create your account',
            'required_consents' => 'Required Consents',
            'required_consents_description' => 'To proceed with registration, you must accept the following conditions for processing your personal data',
            'optional_consents' => 'Optional Consents',
            'optional_consents_description' => 'These consents are optional and do not affect your registration. You can modify them at any time from your profile.',
        ],
        'fields' => [
            'first_name' => [
                'label' => 'First Name',
                'placeholder' => 'Enter your first name',
            ],
            'last_name' => [
                'label' => 'Last Name',
                'placeholder' => 'Enter your last name',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter your email',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Create a secure password',
            ],
            'password_confirmation' => [
                'label' => 'Confirm Password',
                'placeholder' => 'Repeat your password',
            ],
        ],
        'consents' => [
            'title' => 'Consents',
            'privacy_policy_label' => 'Privacy Policy',
            'privacy_policy_hint' => 'I have read and understood the Privacy Policy and accept the processing of my personal data as described',
            'terms_label' => 'Terms and Conditions',
            'terms_hint' => 'I have read and accept the Terms and Conditions',
            'marketing_label' => 'Marketing Consent',
            'marketing_hint' => 'I want to receive news and updates',
            'privacy_complete' => 'Full information pursuant to Articles 13 and 14 of Regulation (EU) 2016/679 (GDPR)',
            'terms_complete' => 'Service contract pursuant to Article 6(1)(b) of Regulation (EU) 2016/679 (GDPR)',
        ],
        'actions' => [
            'read_privacy_policy' => 'Read privacy policy',
            'read_terms' => 'Read terms and conditions',
        ],
        'links' => [
            'and' => 'and',
        ],
    ],
    'navigation' => [
        'name' => 'GDPR',
        'plural' => 'GDPR',
        'group' => [
            'name' => 'Privacy',
            'description' => 'Privacy and data protection management',
        ],
        'label' => 'Dashboard GDPR',
        'sort' => '79',
        'icon' => 'gdpr-dashboard-animated',
    ],
    'sections' => [
        'dashboard' => [
            'title' => 'Dashboard GDPR',
            'description' => 'GDPR compliance overview',
            'sort' => '80',
            'icon' => 'gdpr-dashboard-animated',
        ],
        'consent' => [
            'title' => 'Consents',
            'description' => 'Manage user consents',
            'sort' => '81',
            'icon' => 'gdpr-consent-animated',
        ],
        'treatment' => [
            'title' => 'Processing Activities',
            'description' => 'Data processing register',
            'sort' => '82',
            'icon' => 'gdpr-treatment-animated',
        ],
        'profile' => [
            'title' => 'Profili',
            'description' => 'Manage privacy profiles',
            'sort' => '83',
            'icon' => 'gdpr-profile-animated',
        ],
        'event' => [
            'title' => 'Eventi',
            'description' => 'Privacy events register',
            'sort' => '84',
            'icon' => 'gdpr-event-animated',
        ],
    ],
    'widgets' => [
        'consent_summary' => 'Consent Summary',
        'treatment_status' => 'Processing Status',
        'recent_events' => 'Eventi Recenti',
        'compliance_score' => 'Compliance Score',
    ],
    'metrics' => [
        'active_consents' => 'Active Consents',
        'pending_requests' => 'Richieste in Sospeso',
        'data_breaches' => 'Data Breaches',
        'compliance_level' => 'Compliance Level',
    ],
    'status' => [
        'compliant' => 'Conforme',
        'partially_compliant' => 'Parzialmente Conforme',
        'non_compliant' => 'Non-compliant',
        'needs_review' => 'Necessita Revisione',
    ],
    'actions' => [
        'export_data' => 'Export Data',
        'generate_report' => 'Genera Report',
        'review_compliance' => 'Review Compliance',
        'update_policies' => 'Aggiorna Policies',
    ],
    'reports' => [
        'compliance' => 'Compliance Report',
        'consent' => 'Consent Report',
        'treatment' => 'Processing Report',
        'event' => 'Report Eventi',
    ],
    'notifications' => [
        'consent_expired' => 'Consent Expired',
        'review_needed' => 'Revisione Necessaria',
        'breach_detected' => 'Violazione Rilevata',
        'policy_updated' => 'Policy Aggiornata',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];

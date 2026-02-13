<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'title' => 'Beginnen Sie Ihre Pizza-Reise 🍕', // Moved from nested 'register' array
    'subtitle' => 'Schließen Sie sich unserer wachsenden Community von Pizza-Liebhabern und Entwicklern an. Exklusiver Zugang zu Meetups und Tutorials.', // Moved from nested 'register' array
    'submit' => 'Community jetzt beitreten', // Moved from nested 'register' array
    'submitting' => 'Wir bereiten Ihren Ofen vor...', // Moved from nested 'register' array

    // === STATS ===
    'stats' => [
        'active_developers' => 'Wachsende Community',
        'monthly_meetups' => 'Kommende Events',
        'community_support' => '24/7 Support',
    ],

    // === FORM ===
    'form' => [
        'cta_title' => 'Erstelle dein KOSTENLOSES Konto',
        'cta_subtitle' => 'Keine Kreditkarte erforderlich - 100% KOSTENLOS!',
        'terms_notice' => 'Mit der Registrierung akzeptierst du unsere AGB und Datenschutzerklärung',
    ],

    // === BENEFITS CTA ===
    'benefits' => [
        'community' => [
            'title' => 'Entdecke die Entwickler-Community',
            'description' => 'Verbinden Sie sich mit Laravel-Professionals und -Enthusiasten weltweit',
            'cta' => 'KOSTENLOSER Zugang sofort nach Anmeldung',
        ],
        'tutorials' => [
            'title' => 'Exklusive Tutorials & Workshops',
            'description' => 'Priorisierter Zugang zu Premium-Inhalten und Schulungen',
            'cta' => 'Exklusiven Zugang erhalten', // Changed from 'Wert €997/Jahr - KOSTENLOS für Mitglieder'
        ],
        'networking' => [
            'title' => 'Networking & Karriere',
            'description' => 'Kollaborationsmöglichkeiten und professionelles Wachstum',
            'cta' => 'Werde von Top-Laravel-Unternehmen eingestellt',
        ],
    ],

    // === SOCIAL PROOF ===
    'social_proof' => 'Werden Sie Teil der LaravelPizza Community',

    // === FIELDS ===
    'fields' => [
        'first_name' => [
            'label' => 'Vorname',
            'placeholder' => 'Mario',
            'helper_text' => 'Geben Sie Ihren Vornamen ein, um Ihr Profil zu vervollständigen',
        ],
        'last_name' => [
            'label' => 'Nachname',
            'placeholder' => 'Rossi',
            'helper_text' => 'Geben Sie Ihren Nachnamen ein, um Ihr Profil zu vervollständigen',
        ],
        'email' => [
            'label' => 'Ihre beste E-Mail',
            'placeholder' => 'mario.rossi@beispiel.de',
            'helper_text' => 'Wir senden eine Bestätigungs-E-Mail an diese Adresse',
        ],
        'password' => [
            'label' => 'Sicheres Passwort',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Muss mindestens 12 Zeichen, Großbuchstaben, Kleinbuchstaben, Zahl und Symbol enthalten',
        ],
        'password_confirmation' => [
            'label' => 'Passwort bestätigen',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Wiederholen Sie das Passwort zur Bestätigung',
        ],
    ],

    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Persönliche Informationen',
        'user_info_description' => 'Geben Sie Ihre persönlichen Daten ein, um Ihr Konto zu erstellen',
        'required_consents' => 'Erforderliche Zustimmung',
        'required_consents_description' => 'Um mit der Registrierung fortzufahren, müssen Sie die folgenden Bedingungen für die Verarbeitung Ihrer persönlichen Daten akzeptieren',
        'optional_consents' => 'Optionale Zustimmung',
        'optional_consents_description' => 'Diese Zustimmungen sind optional und beeinflussen Ihre Registrierung nicht. Sie können diese jederzeit in Ihrem Profil ändern.',
        'trust_badges' => 'Vertrauenssiegel',
        'registration_form' => 'Registrierungsformular',
        'benefits' => 'Vorteile',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Datenschutz-Zustimmungen',
        'privacy_policy_label' => 'Ich habe die Datenschutzerklärung gelesen und verstanden und stimme der Verarbeitung meiner persönlichen Daten zu, wie in der Richtlinie beschrieben.',
        'privacy_policy_hint' => 'Vollständige Information gemäß Art. 13 und 14 der Verordnung (EU) 2016/679 (DSGVO)',
        'privacy_policy_required' => 'Sie müssen die Datenschutzerklärung akzeptieren, um mit der Registrierung fortzufahren.',
        'privacy_checkbox_html' => 'Ich habe die <a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Datenschutzerklärung</a> gelesen',
        'terms_label' => 'Ich habe die Nutzungsbedingungen gelesen und akzeptiert',
        'terms_hint' => 'Dienstleistungsvertrag gemäß Art. 6(1)(b) der Verordnung (EU) 2016/679 (DSGVO)',
        'terms_required' => 'Sie müssen die Nutzungsbedingungen akzeptieren, um mit der Registrierung fortzufahren.',
        'terms_checkbox_html' => 'Ich akzeptiere die <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Nutzungsbedingungen</a>',
        'marketing_label' => 'Ich möchte Pizza-Tipps und Meetup-Einladungen erhalten (optional)',
        'marketing_hint' => 'Die Zustimmung ist freiwillig und kann jederzeit ohne Folgen widerrufen werden.',
        'required_consent_missing' => 'Sie müssen alle erforderlichen Zustimmungen akzeptieren, um mit der Registrierung fortzufahren.',
    ],

    // === ACTIONS ===
    'actions' => [
        'read_privacy_policy' => 'Datenschutzerklärung lesen',
        'read_terms' => 'Nutzungsbedingungen lesen',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'Das Passwort muss mindestens 12 Zeichen, einen Großbuchstaben, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen enthalten.',
    ],

    // === MESSAGES ===
    'already_registered' => 'Haben Sie bereits ein Konto?',
    'login' => 'Anmelden',
    'required_consent_missing' => 'Sie müssen alle erforderlichen Zustimmungen akzeptieren, um mit der Registrierung fortzufahren.',
    'success' => 'Registrierung erfolgreich abgeschlossen! Ihr Konto wurde DSGVO-konform erstellt.',
    'success_message' => 'Willkommen bei LaravelPizza Meetups! Ihre Registrierung ist abgeschlossen und alle Ihre Zustimmungen wurden korrekt erfasst.',
    'error' => 'Fehler bei der Registrierung',
    'error_message' => 'Bei der Registrierung ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut. Wenn das Problem besteht, kontaktieren Sie unseren Support.',

    // === CLICKBAIT & MARKETING ===
    'clickbait' => [
        'active_developers' => 'Aktive Entwickler',
        'monthly_meetups' => 'Monatliche Meetups',
        'community_support' => 'Community-Support',
        'free_access' => 'KOSTENLOSER Zugriff sofort nach der Registrierung',
        'worth_free' => 'Exklusiven Zugang erhalten', // Changed from 'Wert €997/Jahr - KOSTENLOS für Mitglieder'
        'get_hired' => 'Wirst du von den besten Laravel-Unternehmen eingestellt',
        'join_now' => 'JETZT beitreten, bevor die Registrierung schließt!',
        'create_account' => 'Erstelle dein KOSTENLOSES Konto',
        'no_card_required' => 'Keine Kreditkarte erforderlich - 100% KOSTENLOS für immer!',
        'by_registering' => 'Durch die Registrierung stimmen Sie unseren Geschäftsbedingungen und der Datenschutzerklärung zu',
    ],

    // === SEO KEYWORDS ===
    'seo' => [
        'description' => 'Werden Sie Teil der LaravelPizza Community für exklusive Meetups, Premium-Tutorials und Networking. Kostenloser Zugang zu Workshops und Community-Events.',
        'laravel_meetup' => 'Laravel-Meetup',
        'laravel_community' => 'Laravel-Community',
        'php_developer_community' => 'PHP-Entwickler-Community',
        'laravel_tutorials' => 'Laravel-Tutorials',
        'laravel_workshops' => 'Laravel-Workshops',
        'laravel_networking' => 'Laravel-Networking',
        'laravelpizza' => 'LaravelPizza',
    ],
];

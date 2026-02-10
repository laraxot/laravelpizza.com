<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'register' => [
        'title' => 'Beginnen Sie Ihre Pizza-Reise 🍕',
        'subtitle' => 'Schließen Sie sich 5.000+ Pizza-Liebhabern und Entwicklern an. Exklusiver Zugang zu Meetups und Tutorials.',
        'submit' => 'Community jetzt beitreten',
        'submitting' => 'Wir bereiten Ihren Ofen vor...',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => [
            'label' => 'Vorname',
            'placeholder' => 'Hans',
            'helper_text' => 'Ihr Vorname für die Community',
        ],
        'last_name' => [
            'label' => 'Nachname',
            'placeholder' => 'Müller',
            'helper_text' => 'Ihr Nachname für die Community',
        ],
        'email' => [
            'label' => 'Ihre beste E-Mail',
            'placeholder' => 'hans@beispiel.de',
            'helper_text' => 'Kein Spam, nur Laravel-Inhalte 🚀',
        ],
        'password' => [
            'label' => 'Sicheres Passwort',
            'placeholder' => 'Etwas Super-Geheimes...',
            'helper_text' => 'Mindestens 8 Zeichen',
        ],
        'password_confirmation' => [
            'label' => 'Passwort bestätigen',
            'placeholder' => 'Passwort wiederholen',
            'helper_text' => 'Stellen Sie sicher, dass es übereinstimmt',
        ],
    ],

    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Persönliche Informationen',
        'user_info_description' => 'Geben Sie Ihre persönlichen Daten ein, um Ihr Konto zu erstellen',
        'required_consents' => 'Erforderliche Zustimmung',
        'required_consents_description' => 'Um mit der Registrierung fortzufahren, müssen Sie die folgenden Bedingungen für die Verarbeitung Ihrer persönlichen Daten akzeptieren',
        'optional_consents' => 'Optionale Zustimmung',
        'optional_consents_description' => 'Diese Zustimmungen sind optional und beeinflussen Ihre Registrierung nicht. Sie können diese jederzeit in Ihrem Datenschutz-Dashboard ändern.',
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
];
<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'register' => [
        'title' => 'Beginnen Sie Ihre Pizza-Reise 🍕',
        'subtitle' => 'Schließen Sie sich 5.000+ Pizza-Liebhabern und Entwicklern an. Exklusiver Zugang zu Meetups und Tutorials.',
        'submit' => 'Treten Sie der Community bei',
        'submitting' => 'Wir heizen den Ofen vor...',
        'already_have_account' => 'Bereits Mitglied?',
    ],

    'sections' => [
        'user_info' => 'Persönliche Informationen',
        'user_info_description' => 'Geben Sie Ihre persönlichen Daten ein, um Ihr Konto zu erstellen',
        'required_consents' => 'Erforderliche Zustimmung',
        'required_consents_description' => 'Um mit der Registrierung fortzufahren, müssen Sie die folgenden Bedingungen für die Verarbeitung Ihrer persönlichen Daten akzeptieren',
        'optional_consents' => 'Optionale Zustimmung',
        'optional_consents_description' => 'Diese Zustimmungen sind optional und beeinflussen Ihre Registrierung nicht. Sie können diese jederzeit in Ihrem Datenschutz-Dashboard ändern.',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'Vorname',
        'last_name' => 'Nachname',
        'email' => 'E-Mail-Adresse',
        'password' => 'Passwort',
        'password_confirmation' => 'Passwort bestätigen',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Erforderliche Zustimmung',
        'privacy_policy_label' => 'Ich habe die Datenschutzerklärung gelesen und verstanden und stimme der Verarbeitung meiner persönlichen Daten zu, wie in der Richtlinie beschrieben.',
        'privacy_policy_hint' => 'Vollständige Information gemäß Art. 13 und 14 der Verordnung (EU) 2016/679 (DSGVO)',
        'privacy_policy_required' => 'Sie müssen die Datenschutzerklärung akzeptieren, um mit der Registrierung fortzufahren.',
        
        'terms_label' => 'Ich habe die Nutzungsbedingungen gelesen und akzeptiert',
        'terms_hint' => 'Dienstleistungsvertrag gemäß Art. 6(1)(b) der Verordnung (EU) 2016/679 (DSGVO)',
        'terms_required' => 'Sie müssen die Nutzungsbedingungen akzeptieren, um mit der Registrierung fortzufahren.',
        
        'data_processing_label' => 'Ich stimme der Verarbeitung meiner persönlichen Daten für die Erstellung und Verwaltung meines Benutzerkontos zu',
        'data_processing_hint' => 'Rechtsgrundlage: Vertragsdurchführung (Art. 6(1)(b) DSGVO)',
        'data_processing_required' => 'Sie müssen der Datenverarbeitung zustimmen, um mit der Registrierung fortzufahren.',
        
        'marketing_label' => 'Ich stimme dem Erhalt von Marketing- und Werbekommunikationen bezüglich Meetup-Veranstaltungen und neuen Funktionen zu',
        'marketing_hint' => 'Die Zustimmung ist freiwillig und kann jederzeit ohne Folgen widerrufen werden.',
        
        'profiling_label' => 'Ich stimme der Analyse meiner Vorlieben zu, um das Benutzererlebnis zu personalisieren',
        'profiling_hint' => 'Analyse basierend auf Navigationsdaten und Interaktionen zur Verbesserung unserer Dienstleistungen.',
        
        'analytics_label' => 'Ich stimme der anonymen statistischen Analyse von Navigationsdaten zu, um die Website-Leistung zu verbessern',
        'analytics_hint' => 'Daten werden anonym und aggregiert für statistische Zwecke erhoben.',
        
        'third_party_label' => 'Ich stimme der Weitergabe meiner Daten an ausgewählte Partner für integrierte Dienstleistungen zu',
        'third_party_hint' => 'Nur DSGVO-konforme Partner für spezifische und begrenzte Zwecke.',
        
        'privacy_checkbox_html' => 'Ich habe die <a href=":privacy_url" target="_blank" class="underline font-bold">Datenschutzerklärung</a> gelesen',
        'terms_checkbox_html' => 'Ich akzeptiere die <a href=":terms_url" target="_blank" class="underline font-bold">Nutzungsbedingungen</a>',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'Das Passwort muss mindestens 12 Zeichen, einen Großbuchstaben, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen enthalten.',
    ],

    // === MESSAGES ===
    'required_consent_missing' => 'Sie müssen alle erforderlichen Zustimmungen akzeptieren, um mit der Registrierung fortzufahren.',
    
    'success' => 'Registrierung erfolgreich abgeschlossen! Ihr Konto wurde DSGVO-konform erstellt.',
    'success_message' => 'Willkommen bei LaravelPizza Meetups! Ihre Registrierung ist abgeschlossen und alle Ihre Zustimmungen wurden korrekt erfasst.',
    
    'error' => 'Fehler bei der Registrierung',
    'error_message' => 'Bei der Registrierung ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut. Wenn das Problem besteht, kontaktieren Sie unseren Support.',

    'login' => 'Anmelden',
    'already_registered' => 'Haben Sie bereits ein Konto?',
];
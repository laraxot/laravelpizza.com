<?php

declare(strict_types=1);

return [
    'fields' => [
        'invoice' => [
            'label' => 'Rechnung',
            'placeholder' => 'Rechnung hochladen',
            'helper_text' => 'Laden Sie Ihre Rechnung im PDF- oder Bildformat hoch',
            'description' => 'Rechnungsdokument',
            'validation' => [
                'required' => 'Das Hochladen der Rechnung ist erforderlich',
                'mimes' => 'Die Datei muss ein PDF-Dokument oder ein Bild sein',
                'max' => 'Die maximale Dateigröße beträgt 10MB',
            ],
        ],
        'prescription' => [
            'label' => 'Ärztliches Rezept',
            'placeholder' => 'Rezept hochladen',
            'helper_text' => 'Laden Sie Ihr ärztliches Rezept hoch',
            'description' => 'Ärztliche Verschreibung für Medikamente oder Untersuchungen',
            'validation' => [
                'required' => 'Das ärztliche Rezept ist erforderlich',
                'mimes' => 'Unterstützte Formate: PDF, JPG, PNG',
                'max' => 'Maximale Größe: 10MB',
            ],
        ],
        'medical_report' => [
            'label' => 'Medizinischer Bericht',
            'placeholder' => 'Medizinischen Bericht hochladen',
            'helper_text' => 'Laden Sie Ihre Testergebnisse oder den medizinischen Bericht hoch',
            'description' => 'Medizinisches Dokument mit Diagnose und Verschreibungen',
            'validation' => [
                'mimes' => 'Unterstützte Formate: PDF, JPG, PNG',
                'max' => 'Maximale Größe: 10MB',
            ],
        ],
        'certificate' => [
            'label' => 'Zertifikat',
            'placeholder' => 'Zertifikat hochladen',
            'helper_text' => 'Unterstützte Formate: PDF, JPG, PNG',
            'description' => 'Medizinisches Zertifikat oder Gesundheitsdokumentation',
            'validation' => [
                'mimes' => 'Unterstützte Formate: PDF, JPG, PNG',
                'max' => 'Maximale Größe: 10MB',
            ],
        ],
        'consent_form' => [
            'label' => 'Einverständniserklärung',
            'placeholder' => 'Einverständniserklärung hochladen',
            'helper_text' => 'Unterschriebene Einverständniserklärung',
            'description' => 'Informierte Einverständniserklärung vom Patienten unterschrieben',
            'validation' => [
                'mimes' => 'Unterstützte Formate: PDF, DOC, DOCX',
                'max' => 'Maximale Größe: 10MB',
            ],
        ],
        'xray_image' => [
            'label' => 'Röntgenbild',
            'placeholder' => 'Röntgenbild hochladen',
            'helper_text' => 'Diagnostische Bilder und Röntgenaufnahmen',
            'description' => 'Röntgen- oder diagnostisches Bild',
            'validation' => [
                'mimes' => 'Unterstützte Formate: JPG, PNG, DICOM',
                'max' => 'Maximale Größe: 20MB',
            ],
        ],
        'treatment_plan' => [
            'label' => 'Behandlungsplan',
            'placeholder' => 'Behandlungsplan hochladen',
            'helper_text' => 'Personalisierter Behandlungsplan',
            'description' => 'Personalisierter Behandlungsplan für den Patienten',
            'validation' => [
                'mimes' => 'Unterstützte Formate: PDF, DOC, DOCX',
                'max' => 'Maximale Größe: 10MB',
            ],
        ],
        'medical_history' => [
            'label' => 'Krankengeschichte',
            'placeholder' => 'Krankengeschichte hochladen',
            'helper_text' => 'Gesundheitsdokumentation des Patienten',
            'description' => 'Dokumentation der Krankengeschichte des Patienten',
            'validation' => [
                'mimes' => 'Unterstützte Formate: PDF, DOC, DOCX',
                'max' => 'Maximale Größe: 10MB',
            ],
        ],
    ],
    'validation' => [
        'file_required' => 'Datei ist erforderlich',
        'file_type_invalid' => 'Nicht unterstützter Dateityp',
        'file_size_exceeded' => 'Dateigröße zu groß',
        'file_corrupted' => 'Datei scheint beschädigt zu sein',
    ],
    'messages' => [
        'upload_success' => 'Datei erfolgreich hochgeladen',
        'upload_error' => 'Fehler beim Hochladen der Datei',
        'delete_success' => 'Datei erfolgreich gelöscht',
        'delete_error' => 'Fehler beim Löschen der Datei',
    ],
];

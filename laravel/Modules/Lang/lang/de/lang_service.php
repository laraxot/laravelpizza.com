<?php

declare(strict_types=1);

return [
    'fields' => [
        'language' => [
            'label' => 'Sprache',
            'placeholder' => 'Sprache auswählen',
            'helper_text' => 'Aktuell ausgewählte Benutzersprache',
        ],
        'available_languages' => [
            'label' => 'Verfügbare Sprachen',
            'placeholder' => 'Liste verfügbarer Sprachen',
            'helper_text' => 'Für die Benutzeroberfläche verfügbare Sprachen',
        ],
        'value' => [
            'label' => 'Wert',
            'placeholder' => 'Wert eingeben',
            'helper_text' => 'Übersetzungswert',
        ],
        'key' => [
            'label' => 'Schlüssel',
            'placeholder' => 'Übersetzungsschlüssel eingeben',
            'helper_text' => 'Eindeutige Kennung für die Übersetzung',
        ],
        'locale' => [
            'label' => 'Gebietsschema',
            'placeholder' => 'Gebietsschema auswählen',
            'helper_text' => 'Sprachgebietsschema-Code (z.B. it, en, de)',
        ],
    ],
    'actions' => [
        'change_language' => [
            'label' => 'Sprache ändern',
            'tooltip' => 'Benutzersprache ändern',
            'success' => 'Sprache erfolgreich geändert',
            'error' => 'Fehler beim Ändern der Sprache',
            'confirmation' => 'Sind Sie sicher, dass Sie die Sprache ändern möchten?',
        ],
        'cancel' => [
            'label' => 'Abbrechen',
            'tooltip' => 'Aktuelle Operation abbrechen',
        ],
        'save' => [
            'label' => 'Speichern',
            'tooltip' => 'Änderungen speichern',
            'success' => 'Änderungen erfolgreich gespeichert',
            'error' => 'Fehler beim Speichern',
        ],
        'create' => [
            'label' => 'Übersetzung erstellen',
            'tooltip' => 'Neue Übersetzung erstellen',
            'success' => 'Übersetzung erfolgreich erstellt',
            'error' => 'Fehler beim Erstellen der Übersetzung',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'tooltip' => 'Ausgewählte Übersetzung bearbeiten',
            'success' => 'Übersetzung erfolgreich aktualisiert',
            'error' => 'Fehler beim Aktualisieren der Übersetzung',
        ],
        'delete' => [
            'label' => 'Löschen',
            'tooltip' => 'Ausgewählte Übersetzung löschen',
            'success' => 'Übersetzung erfolgreich gelöscht',
            'error' => 'Fehler beim Löschen der Übersetzung',
            'confirmation' => 'Sind Sie sicher, dass Sie diese Übersetzung löschen möchten?',
        ],
    ],
    'messages' => [
        'language_changed' => 'Sprache erfolgreich geändert',
        'error' => 'Ein Fehler ist beim Ändern der Sprache aufgetreten',
        'no_translations' => 'Keine Übersetzungen gefunden',
        'loading' => 'Übersetzungen werden geladen...',
        'empty_state' => 'Keine Übersetzungen verfügbar',
        'search_placeholder' => 'Übersetzungen suchen...',
    ],
    'validation' => [
        'language_required' => 'Sprache ist erforderlich',
        'language_valid' => 'Die ausgewählte Sprache ist nicht gültig',
        'key_required' => 'Übersetzungsschlüssel ist erforderlich',
        'key_unique' => 'Dieser Übersetzungsschlüssel existiert bereits',
        'value_required' => 'Übersetzungswert ist erforderlich',
        'locale_required' => 'Gebietsschema ist erforderlich',
        'locale_valid' => 'Gebietsschema-Format ist nicht gültig',
    ],
    'navigation' => [
        'label' => 'Sprachdienst',
        'group' => 'Lokalisierung',
        'icon' => 'heroicon-o-language',
    ],
    'page' => [
        'title' => 'Übersetzungsverwaltung',
        'heading' => 'Sprachdienst',
        'description' => 'Verwalten Sie Übersetzungen und verfügbare Sprachen im System',
    ],
];

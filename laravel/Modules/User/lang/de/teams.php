<?php

declare(strict_types=1);

return [
    'name' => 'Teams',
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Teamnamen eingeben',
            'helper_text' => 'Team-Identifikationsname',
            'description' => 'Der Name, der dieses Team identifiziert',
        ],
        'personal_team' => [
            'label' => 'Persönliches Team',
            'helper_text' => 'Gibt an, ob es sich um ein persönliches Team handelt',
            'description' => 'Ein persönliches Team ist einem einzelnen Benutzer zugeordnet',
        ],
        'owner' => [
            'label' => 'Besitzer',
            'helper_text' => 'Team-Besitzer-Benutzer',
            'description' => 'Der Benutzer, der dieses Team erstellt und verwaltet',
        ],
        'created_at' => [
            'label' => 'Erstellungsdatum',
            'helper_text' => 'Team-Erstellungsdatum',
            'description' => 'Datum und Uhrzeit der Team-Erstellung',
        ],
        'updated_at' => [
            'label' => 'Zuletzt geändert',
            'helper_text' => 'Datum der letzten Änderung',
            'description' => 'Datum und Uhrzeit der letzten Team-Änderung',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Neues Team',
            'tooltip' => 'Ein neues Team erstellen',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'tooltip' => 'Team-Daten bearbeiten',
        ],
        'delete' => [
            'label' => 'Löschen',
            'tooltip' => 'Das Team löschen',
        ],
        'view' => [
            'label' => 'Anzeigen',
            'tooltip' => 'Team-Details anzeigen',
        ],
    ],
    'messages' => [
        'success' => [
            'created' => 'Team erfolgreich erstellt',
            'updated' => 'Team erfolgreich aktualisiert',
            'deleted' => 'Team erfolgreich gelöscht',
        ],
        'error' => [
            'create' => 'Fehler beim Erstellen des Teams',
            'update' => 'Fehler beim Aktualisieren des Teams',
            'delete' => 'Fehler beim Löschen des Teams',
        ],
        'confirm' => [
            'delete' => 'Sind Sie sicher, dass Sie dieses Team löschen möchten?',
        ],
    ],
    'relationships' => [
        'members' => [
            'label' => 'Mitglieder',
            'description' => 'Benutzer, die Teil dieses Teams sind',
        ],
        'owner' => [
            'label' => 'Besitzer',
            'description' => 'Benutzer, der dieses Team erstellt hat',
        ],
    ],
];

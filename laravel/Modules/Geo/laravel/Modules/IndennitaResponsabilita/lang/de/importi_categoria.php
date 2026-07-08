<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Kategoriebeträge',
        'group' => 'Zulage',
        'icon' => 'heroicon-o-currency-euro',
        'sort' => 100,
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Eindeutige Kennung',
        ],
        'ente' => [
            'label' => 'Einheit',
            'placeholder' => 'Einheitscode',
            'help' => 'Identifikationscode der Einheit',
        ],
        'categoria' => [
            'label' => 'Kategorie',
            'placeholder' => 'Kategoriecode',
            'help' => 'Wirtschaftskategorie Referenz',
        ],
        'lista_propro' => [
            'label' => 'Berufsprofilliste',
            'placeholder' => 'Profilliste (z.B: 1,2,3)',
            'help' => 'Durch Komma getrennte Berufsprofilcodes',
        ],
        'anno' => [
            'label' => 'Jahr',
            'placeholder' => 'Referenzjahr',
            'help' => 'Gültigkeitsjahr für Beträge',
        ],
        'min' => [
            'label' => 'Mindestbetrag',
            'placeholder' => '0.00',
            'help' => 'Mindestbetrag für die Kategorie',
        ],
        'max' => [
            'label' => 'Maximalbetrag',
            'placeholder' => '0.00',
            'help' => 'Maximalbetrag für die Kategorie',
        ],
        'created_at' => [
            'label' => 'Erstellt am',
            'help' => 'Erstellungsdatum des Datensatzes',
        ],
        'updated_at' => [
            'label' => 'Aktualisiert am',
            'help' => 'Datum der letzten Änderung',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Neuer Kategoriebetrag',
            'success' => 'Kategoriebetrag erfolgreich erstellt',
            'error' => 'Fehler beim Erstellen des Kategoriebetrags',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'success' => 'Kategoriebetrag erfolgreich aktualisiert',
            'error' => 'Fehler beim Aktualisieren',
        ],
        'delete' => [
            'label' => 'Löschen',
            'confirmation' => 'Diese Aktion ist unwiderruflich. Löschen bestätigen?',
            'success' => 'Kategoriebetrag erfolgreich gelöscht',
            'error' => 'Fehler beim Löschen',
        ],
        'view' => [
            'label' => 'Ansehen',
        ],
    ],

    'messages' => [
        'empty_state' => 'Keine Kategoriebeträge gefunden',
        'validation_error' => 'Validierungsfehler erkannt',
        'saved' => 'Kategoriebetrag erfolgreich gespeichert',
    ],
];

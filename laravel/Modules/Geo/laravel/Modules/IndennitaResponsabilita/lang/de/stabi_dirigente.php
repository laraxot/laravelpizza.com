<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Betriebsstättenleiter',
        'plural' => 'Betriebsstättenleiter',
        'group' => [
            'name' => 'Admin',
            'description' => 'Verwaltung von Betriebsstätten und Leitern',
        ],
        'label' => 'Betriebsstättenleiter',
        'sort' => 43,
        'icon' => 'heroicon-o-building-office',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Eindeutige Kennung',
            'tooltip' => 'Datensatz-ID',
            'helper_text' => '',
        ],
        'valutatore_id' => [
            'label' => 'Bewerter',
            'placeholder' => 'Bewerter wählen',
            'help' => 'Benutzer, der die Bewertung durchführt',
            'tooltip' => 'Bewerter-ID',
            'helper_text' => '',
        ],
        'stabi' => [
            'label' => 'Betriebsstätte',
            'placeholder' => 'Betriebsstätte wählen',
            'help' => 'Betriebsstättencode',
            'tooltip' => 'Code',
            'helper_text' => '',
        ],
        'repar' => [
            'label' => 'Abteilung',
            'placeholder' => 'Abteilung wählen',
            'help' => 'Abteilungscode',
            'tooltip' => 'Abteilungscode',
            'helper_text' => '',
        ],
        'anno' => [
            'label' => 'Jahr',
            'placeholder' => 'Jahr eingeben',
            'help' => 'Referenzjahr',
            'tooltip' => 'Geschäftsjahr',
            'helper_text' => '',
        ],
        'matr' => [
            'label' => 'Personalnummer',
            'placeholder' => 'Personalnummer eingeben',
            'help' => 'Personalnummer des Leiters',
            'tooltip' => 'Mitarbeiter-ID',
            'helper_text' => '',
        ],
        'cognome' => [
            'label' => 'Nachname',
            'placeholder' => 'Nachname eingeben',
            'help' => 'Nachname des Leiters',
            'tooltip' => 'Familienname',
            'helper_text' => '',
        ],
        'nome' => [
            'label' => 'Vorname',
            'placeholder' => 'Vorname eingeben',
            'help' => 'Vorname des Leiters',
            'tooltip' => 'Name',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Neu erstellen',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Neuen Datensatz erstellen',
            'success' => 'Datensatz erfolgreich erstellt',
            'error' => 'Fehler beim Erstellen',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'icon' => 'heroicon-o-pencil',
            'tooltip' => 'Datensatz bearbeiten',
            'success' => 'Datensatz erfolgreich aktualisiert',
            'error' => 'Fehler beim Aktualisieren',
        ],
        'delete' => [
            'label' => 'Löschen',
            'icon' => 'heroicon-o-trash',
            'tooltip' => 'Datensatz löschen',
            'confirmation' => 'Möchten Sie diesen Datensatz wirklich löschen?',
            'success' => 'Datensatz erfolgreich gelöscht',
            'error' => 'Fehler beim Löschen',
        ],
    ],
    'model' => [
        'label' => 'Betriebsstättenleiter',
        'plural' => 'Betriebsstättenleiter',
        'description' => 'Verwaltung von Betriebsstätten und Leitern',
    ],
];

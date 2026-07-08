<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Verantwortungszulage',
        'plural' => 'Verantwortungszulagen',
        'group' => [
            'name' => 'Zulagen',
            'description' => 'Verwaltung der Verantwortungszulagen',
        ],
        'label' => 'Verantwortungszulage',
        'sort' => 91,
        'icon' => 'heroicon-o-briefcase',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Eindeutige Kennung der Zulage',
            'tooltip' => 'Datensatz-ID',
            'helper_text' => '',
        ],
        'anno' => [
            'label' => 'Jahr',
            'placeholder' => 'Jahr eingeben',
            'help' => 'Referenzjahr der Zulage',
            'tooltip' => 'Geschäftsjahr',
            'helper_text' => '',
        ],
        'matr' => [
            'label' => 'Personalnummer',
            'placeholder' => 'Personalnummer eingeben',
            'help' => 'Mitarbeiter-Identifikationsnummer',
            'tooltip' => 'Mitarbeiter-ID',
            'helper_text' => '',
        ],
        'cognome' => [
            'label' => 'Nachname',
            'placeholder' => 'Nachname eingeben',
            'help' => 'Nachname des Mitarbeiters',
            'tooltip' => 'Familienname',
            'helper_text' => '',
        ],
        'nome' => [
            'label' => 'Vorname',
            'placeholder' => 'Vorname eingeben',
            'help' => 'Vorname des Mitarbeiters',
            'tooltip' => 'Name',
            'helper_text' => '',
        ],
        'data_nascita' => [
            'label' => 'Geburtsdatum',
            'placeholder' => 'Datum auswählen',
            'help' => 'Geburtsdatum des Mitarbeiters',
            'tooltip' => 'Format: TT.MM.JJJJ',
            'helper_text' => '',
        ],
        'stabi' => [
            'label' => 'Betriebsstätte',
            'placeholder' => 'Betriebsstätte wählen',
            'help' => 'Zuordnung zur Betriebsstätte',
            'tooltip' => 'Betriebsstättencode',
            'helper_text' => '',
        ],
        'repar' => [
            'label' => 'Abteilung',
            'placeholder' => 'Abteilung wählen',
            'help' => 'Arbeitsabteilung',
            'tooltip' => 'Abteilungscode',
            'helper_text' => '',
        ],
        'valutatore_id' => [
            'label' => 'Bewerter',
            'placeholder' => 'Bewerter wählen',
            'help' => 'Benutzer, der die Bewertung durchführt',
            'tooltip' => 'Bewerter-ID',
            'helper_text' => '',
        ],
        'is_compiled' => [
            'label' => 'Abgeschlossen',
            'help' => 'Zeigt an, ob die Zulage abgeschlossen wurde',
            'tooltip' => 'Abschlussstatus',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Neue Zulage erstellen',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Neue Verantwortungszulage erstellen',
            'success' => 'Zulage erfolgreich erstellt',
            'error' => 'Fehler beim Erstellen der Zulage',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'icon' => 'heroicon-o-pencil',
            'tooltip' => 'Zulage bearbeiten',
            'success' => 'Zulage erfolgreich aktualisiert',
            'error' => 'Fehler beim Aktualisieren',
        ],
        'delete' => [
            'label' => 'Löschen',
            'icon' => 'heroicon-o-trash',
            'tooltip' => 'Zulage löschen',
            'confirmation' => 'Möchten Sie diese Zulage wirklich löschen?',
            'success' => 'Zulage erfolgreich gelöscht',
            'error' => 'Fehler beim Löschen',
        ],
        'compila' => [
            'label' => 'Ausfüllen',
            'icon' => 'heroicon-o-document-text',
            'tooltip' => 'Zulage ausfüllen',
            'success' => 'Zulage erfolgreich ausgefüllt',
            'error' => 'Fehler beim Ausfüllen',
        ],
        'record_pdf' => [
            'label' => 'PDF generieren',
            'icon' => 'heroicon-o-document-arrow-down',
            'tooltip' => 'PDF-Dokument generieren',
            'success' => 'PDF erfolgreich generiert',
            'error' => 'Fehler beim Generieren des PDFs',
        ],
    ],
    'messages' => [
        'created' => 'Zulage erfolgreich erstellt',
        'updated' => 'Zulage erfolgreich aktualisiert',
        'deleted' => 'Zulage erfolgreich gelöscht',
        'compiled' => 'Zulage erfolgreich ausgefüllt',
        'error' => 'Ein Fehler ist aufgetreten',
        'validation_error' => 'Datenvalidierungsfehler',
        'not_found' => 'Zulage nicht gefunden',
    ],
    'model' => [
        'label' => 'Verantwortungszulage',
        'plural' => 'Verantwortungszulagen',
        'description' => 'Verwaltung der Verantwortungszulagen des Personals',
    ],
];

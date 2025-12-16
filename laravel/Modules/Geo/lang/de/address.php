<?php

declare(strict_types=1);

return [
    'singular' => 'Adresse',
    'plural' => 'Adressen',
    'navigation' => [
        'sort' => 96,
        'icon' => 'heroicon-o-map-pin',
        'group' => 'Geo',
        'label' => 'Adresse',
    ],
    'actions' => [
        'create' => 'Adresse erstellen',
        'edit' => 'Adresse bearbeiten',
        'view' => 'Adresse ansehen',
        'delete' => 'Adresse löschen',
        'set_primary' => 'Als primär festlegen',
        'verify' => 'Adresse überprüfen',
        'geocode' => 'Geocodierung',
    ],
    'fields' => [
        'model_type' => [
            'label' => 'Modelltyp',
            'placeholder' => 'Modelltyp auswählen',
            'help' => 'Mit der Adresse verknüpfter Modelltyp',
            'description' => 'Typ des Modells, das diese Adresse besitzt',
            'helper_text' => '',
        ],
        'model_id' => [
            'label' => 'Modell-ID',
            'placeholder' => 'Modell-ID eingeben',
            'help' => 'Kennung des verknüpften Modells',
            'description' => 'ID des Modells, das diese Adresse besitzt',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Namen für die Adresse eingeben',
            'help' => 'Ein identifizierender Name für diese Adresse, z.B. "Zuhause" oder "Büro"',
            'helper_text' => '',
            'description' => 'Identifizierender Adressname',
        ],
        'description' => [
            'label' => 'Beschreibung',
            'placeholder' => 'Beschreibung eingeben',
            'help' => 'Zusätzliche Hinweise zur Adresse',
            'description' => 'Zusätzliche Adressbeschreibung',
            'helper_text' => '',
        ],
        'street' => [
            'label' => 'Straße',
            'placeholder' => 'Straßenadresse eingeben',
            'help' => 'Straßenadresse mit Hausnummer',
            'description' => 'Straßenadresse',
            'helper_text' => '',
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Stadt eingeben',
            'help' => 'Stadtname',
            'description' => 'Stadtname',
            'helper_text' => '',
        ],
        'state' => [
            'label' => 'Bundesland/Provinz',
            'placeholder' => 'Bundesland oder Provinz eingeben',
            'help' => 'Bundesland oder Provinz',
            'description' => 'Bundesland oder Provinz',
            'helper_text' => '',
        ],
        'postal_code' => [
            'label' => 'Postleitzahl',
            'placeholder' => 'Postleitzahl eingeben',
            'help' => 'PLZ oder Postleitzahl',
            'description' => 'Postleitzahl',
            'helper_text' => '',
        ],
        'country' => [
            'label' => 'Land',
            'placeholder' => 'Land eingeben',
            'help' => 'Ländername',
            'description' => 'Ländername',
            'helper_text' => '',
        ],
        'latitude' => [
            'label' => 'Breitengrad',
            'placeholder' => 'Breitengrad eingeben',
            'help' => 'Geografische Breitengrad-Koordinate',
            'description' => 'Breitengrad-Koordinate',
            'helper_text' => '',
        ],
        'longitude' => [
            'label' => 'Längengrad',
            'placeholder' => 'Längengrad eingeben',
            'help' => 'Geografische Längengrad-Koordinate',
            'description' => 'Längengrad-Koordinate',
            'helper_text' => '',
        ],
        'is_primary' => [
            'label' => 'Primäre Adresse',
            'help' => 'Als primäre Adresse markieren',
            'description' => 'Ob dies die primäre Adresse ist',
            'helper_text' => '',
        ],
        'is_verified' => [
            'label' => 'Verifizierte Adresse',
            'help' => 'Adresse wurde überprüft',
            'description' => 'Ob diese Adresse überprüft wurde',
            'helper_text' => '',
        ],
    ],
];

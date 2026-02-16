<?php

declare(strict_types=1);

return array (
  'singular' => 'Adresse',
  'plural' => 'Adressen',
  'navigation' => 
  array (
    'sort' => 96,
    'icon' => 'heroicon-o-map-pin',
    'group' => 'Geo',
    'label' => 'Adresse',
  ),
  'actions' => 
  array (
    'create' => 'Adresse erstellen',
    'edit' => 'Adresse bearbeiten',
    'view' => 'Adresse ansehen',
    'delete' => 'Adresse löschen',
    'set_primary' => 'Als primär festlegen',
    'verify' => 'Adresse überprüfen',
    'geocode' => 'Geocodierung',
  ),
  'fields' => 
  array (
    'model_type' => 
    array (
      'label' => 'Modelltyp',
      'placeholder' => 'Modelltyp auswählen',
      'help' => 'Mit der Adresse verknüpfter Modelltyp',
      'description' => 'Typ des Modells, das diese Adresse besitzt',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'model_id' => 
    array (
      'label' => 'Modell-ID',
      'placeholder' => 'Modell-ID eingeben',
      'help' => 'Kennung des verknüpften Modells',
      'description' => 'ID des Modells, das diese Adresse besitzt',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'name' => 
    array (
      'label' => 'Name',
      'placeholder' => 'Namen für die Adresse eingeben',
      'help' => 'Ein identifizierender Name für diese Adresse, z.B. "Zuhause" oder "Büro"',
      'helper_text' => '',
      'description' => 'Identifizierender Adressname',
      'tooltip' => '',
    ),
    'description' => 
    array (
      'label' => 'Beschreibung',
      'placeholder' => 'Beschreibung eingeben',
      'help' => 'Zusätzliche Hinweise zur Adresse',
      'description' => 'Zusätzliche Adressbeschreibung',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'street' => 
    array (
      'label' => 'Straße',
      'placeholder' => 'Straßenadresse eingeben',
      'help' => 'Straßenadresse mit Hausnummer',
      'description' => 'Straßenadresse',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'city' => 
    array (
      'label' => 'Stadt',
      'placeholder' => 'Stadt eingeben',
      'help' => 'Stadtname',
      'description' => 'Stadtname',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'state' => 
    array (
      'label' => 'Bundesland/Provinz',
      'placeholder' => 'Bundesland oder Provinz eingeben',
      'help' => 'Bundesland oder Provinz',
      'description' => 'Bundesland oder Provinz',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'Postleitzahl',
      'placeholder' => 'Postleitzahl eingeben',
      'help' => 'PLZ oder Postleitzahl',
      'description' => 'Postleitzahl',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'country' => 
    array (
      'label' => 'Land',
      'placeholder' => 'Land eingeben',
      'help' => 'Ländername',
      'description' => 'Ländername',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'latitude' => 
    array (
      'label' => 'Breitengrad',
      'placeholder' => 'Breitengrad eingeben',
      'help' => 'Geografische Breitengrad-Koordinate',
      'description' => 'Breitengrad-Koordinate',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'longitude' => 
    array (
      'label' => 'Längengrad',
      'placeholder' => 'Längengrad eingeben',
      'help' => 'Geografische Längengrad-Koordinate',
      'description' => 'Längengrad-Koordinate',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'is_primary' => 
    array (
      'label' => 'Primäre Adresse',
      'help' => 'Als primäre Adresse markieren',
      'description' => 'Ob dies die primäre Adresse ist',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'is_verified' => 
    array (
      'label' => 'Verifizierte Adresse',
      'help' => 'Adresse wurde überprüft',
      'description' => 'Ob diese Adresse überprüft wurde',
      'helper_text' => '',
      'tooltip' => '',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

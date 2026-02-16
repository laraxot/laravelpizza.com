<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Orte',
    'plural' => 'Orte',
    'group' => 
    array (
      'name' => 'Geo',
      'description' => 'Verwaltung von Standorten und geografischen Positionen',
    ),
    'label' => 'Standorte',
    'sort' => 94,
    'icon' => 'ui-geo-location',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Name',
      'tooltip' => 'Geben Sie den Standortnamen ein',
      'helper_text' => 'Geben Sie einen beschreibenden Namen für diesen Standort an',
      'description' => 'Der Anzeigename für diesen geografischen Standort',
      'icon' => 'heroicon-o-tag',
      'color' => 'primary',
      'placeholder' => 'z.B. Hauptbüro, Heimadresse',
    ),
    'address' => 
    array (
      'label' => 'Adresse',
      'tooltip' => 'Geben Sie die Straßenadresse ein',
      'helper_text' => 'Vollständige Straßenadresse einschließlich Hausnummer und Straßenname',
      'description' => 'Vollständige Straßenadresse für präzise Standortidentifikation',
      'icon' => 'heroicon-o-home',
      'color' => 'primary',
      'placeholder' => 'z.B. Musterstraße 123',
    ),
    'city' => 
    array (
      'label' => 'Stadt',
      'tooltip' => 'Geben Sie den Stadtnamen ein',
      'helper_text' => 'Wählen Sie den Namen Ihrer Wohnstadt aus oder geben Sie ihn ein',
      'description' => 'Pflichtfeld zur Identifizierung des Wohn- oder Bürostandorts',
      'icon' => 'heroicon-o-building-office-2',
      'color' => 'primary',
      'placeholder' => 'z.B. Berlin, München, Hamburg',
      'validation' => 
      array (
        'required' => 'Stadt ist erforderlich',
        'invalid' => 'Ungültiger Stadtname',
      ),
    ),
    'province' => 
    array (
      'label' => 'Bundesland',
      'tooltip' => 'Wählen Sie das Bundesland oder den Staat aus',
      'helper_text' => 'Verwaltungseinheit, in der sich die Stadt befindet',
      'description' => 'Bundesland, Staat oder Verwaltungsregion',
      'icon' => 'heroicon-o-map',
      'color' => 'secondary',
      'placeholder' => 'z.B. Bayern, Nordrhein-Westfalen, Berlin',
    ),
    'postal_code' => 
    array (
      'label' => 'Postleitzahl',
      'tooltip' => 'Geben Sie die Postleitzahl ein',
      'helper_text' => 'Postleitzahl für die Postzustellung',
      'description' => 'Postleitzahl für genaue Standortidentifikation',
      'icon' => 'heroicon-o-hashtag',
      'color' => 'secondary',
      'placeholder' => 'z.B. 10115, 80331, 20095',
    ),
    'country' => 
    array (
      'label' => 'Land',
      'tooltip' => 'Wählen Sie das Land aus',
      'helper_text' => 'Land, in dem sich dieser Standort befindet',
      'description' => 'Nationales Territorium, das diesen Standort enthält',
      'icon' => 'heroicon-o-globe-europe-africa',
      'color' => 'info',
      'placeholder' => 'z.B. Deutschland, Österreich, Schweiz',
    ),
    'latitude' => 
    array (
      'label' => 'Breitengrad',
      'tooltip' => 'Geografische Breitengradkoordinate',
      'helper_text' => 'Nord-Süd-Position in Dezimalgrad',
      'description' => 'Breitengradkoordinate für präzise geografische Positionierung',
      'icon' => 'heroicon-o-cursor-arrow-rays',
      'color' => 'info',
      'placeholder' => 'z.B. 52.5200',
    ),
    'longitude' => 
    array (
      'label' => 'Längengrad',
      'tooltip' => 'Geografische Längengradkoordinate',
      'helper_text' => 'Ost-West-Position in Dezimalgrad',
      'description' => 'Längengradkoordinate für präzise geografische Positionierung',
      'icon' => 'heroicon-o-cursor-arrow-rays',
      'color' => 'info',
      'placeholder' => 'z.B. 13.4050',
    ),
    'type' => 
    array (
      'label' => 'Typ',
      'tooltip' => 'Wählen Sie den Standorttyp aus',
      'helper_text' => 'Kategorie, die diesen Standort am besten beschreibt',
      'description' => 'Klassifizierung des Standorts basierend auf seiner primären Nutzung',
      'icon' => 'heroicon-o-squares-2x2',
      'color' => 'warning',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => 'Aktueller Standortstatus',
      'helper_text' => 'Aktiver Status zeigt an, dass der Standort derzeit genutzt wird',
      'description' => 'Betriebsstatus dieses Standorts',
      'icon' => 'heroicon-o-signal',
      'color' => 'success',
    ),
  ),
  'types' => 
  array (
    'business' => 'Geschäft',
    'residence' => 'Wohnsitz',
    'point_of_interest' => 'Sehenswürdigkeit',
    'landmark' => 'Wahrzeichen',
  ),
  'actions' => 
  array (
    'view_map' => 'Karte anzeigen',
    'get_directions' => 'Wegbeschreibung',
    'copy_coordinates' => 'Koordinaten kopieren',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

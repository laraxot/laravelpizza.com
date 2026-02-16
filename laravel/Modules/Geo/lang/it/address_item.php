<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'help' => 'Numero di telefono associato all\'indirizzo',
      'helper_text' => '',
      'description' => 'Numero di telefono fisso o principale collegato a questo indirizzo.',
      'tooltip' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome indirizzo',
      'placeholder' => 'Es. Sede legale, Studio medico',
      'help' => 'Etichetta descrittiva per riconoscere rapidamente l\'indirizzo.',
      'helper_text' => '',
      'description' => 'Nome o titolo con cui identifichi questo indirizzo (es. Sede operativa, Magazzino].',
      'tooltip' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Aggiungi una descrizione dell\'indirizzo',
      'help' => 'Dettagli aggiuntivi utili (scala, interno, citofono, note logistiche].',
      'helper_text' => '',
      'description' => 'Descrizione libera dell\'indirizzo, visibile solo agli operatori.',
      'tooltip' => '',
    ),
    'route' => 
    array (
      'label' => 'Via/Piazza',
      'placeholder' => 'Via/Piazza e nome della via (es. Via Roma]',
      'help' => 'Nome della via, piazza o corso.',
      'helper_text' => '',
      'description' => 'Campo testuale per indicare la via o la piazza (es. Via Roma, Piazza Duomo].',
      'tooltip' => '',
    ),
    'street_number' => 
    array (
      'label' => 'Civico',
      'placeholder' => 'Numero civico (es. 10, 10/A]',
      'help' => 'Numero civico associato alla via indicata.',
      'helper_text' => '',
      'description' => 'Numero civico dell\'indirizzo, comprensivo di eventuali interni o scale.',
      'tooltip' => '',
    ),
    'locality' => 
    array (
      'label' => 'Città/Comune',
      'placeholder' => 'Inserisci la località o frazione',
      'help' => 'Località, frazione o quartiere dell\'indirizzo.',
      'helper_text' => '',
      'description' => 'Città o Comune (es. Milano, Firenze].',
      'tooltip' => '',
    ),
    'administrative_area_level_3' => 
    array (
      'label' => 'Comune',
      'placeholder' => 'Inserisci il comune',
      'help' => 'Comune in cui si trova l\'indirizzo.',
      'helper_text' => '',
      'description' => 'Comune di appartenenza (es. Milano, Firenze].',
      'icon' => 'heroicon-o-building-office',
      'color' => 'primary',
      'tooltip' => '',
    ),
    'administrative_area_level_2' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'Inserisci la provincia',
      'help' => 'Provincia di appartenenza (sigla o nome].',
      'helper_text' => '',
      'description' => 'Provincia di appartenenza (es. MI, FI].',
      'icon' => 'heroicon-o-map-pin',
      'color' => 'danger',
      'tooltip' => '',
    ),
    'administrative_area_level_1' => 
    array (
      'label' => 'Regione',
      'placeholder' => 'Inserisci la regione',
      'help' => 'Regione amministrativa.',
      'helper_text' => '',
      'description' => 'Regione di appartenenza (es. Lombardia, Toscana].',
      'icon' => 'heroicon-o-globe-alt',
      'color' => 'purple',
      'tooltip' => '',
    ),
    'country' => 
    array (
      'label' => 'Codice Nazione',
      'placeholder' => 'Inserisci il codice ISO della nazione (es. IT]',
      'help' => 'Codice ISO della nazione (es. IT, US].',
      'helper_text' => '',
      'description' => 'Codice ISO alpha-2 della nazione (es. IT per Italia].',
      'tooltip' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'help' => 'Codice di avviamento postale dell\'indirizzo.',
      'helper_text' => '',
      'description' => 'Codice di avviamento postale (es. 00100].',
      'tooltip' => '',
    ),
    'formatted_address' => 
    array (
      'label' => 'Indirizzo completo',
      'placeholder' => 'Indirizzo formattato completo',
      'help' => 'Rappresentazione completa dell\'indirizzo.',
      'helper_text' => '',
      'description' => 'Indirizzo completo così come restituito dal servizio di geocoding.',
      'tooltip' => '',
    ),
    'place_id' => 
    array (
      'label' => 'Place ID',
      'placeholder' => 'Identificativo univoco del luogo',
      'help' => 'Identificativo univoco del luogo nel servizio di geocoding (es. Google Places].',
      'helper_text' => '',
      'description' => 'Codice tecnico che identifica in modo univoco questo indirizzo in sistemi esterni.',
      'tooltip' => '',
    ),
    'latitude' => 
    array (
      'label' => 'Latitudine',
      'placeholder' => 'Inserisci la latitudine',
      'help' => 'Coordinata geografica di latitudine (es. 41.9028].',
      'helper_text' => '',
      'description' => 'Valore numerico della latitudine in formato decimale.',
      'tooltip' => '',
    ),
    'longitude' => 
    array (
      'label' => 'Longitudine',
      'placeholder' => 'Inserisci la longitudine',
      'help' => 'Coordinata geografica di longitudine (es. 12.4964].',
      'helper_text' => '',
      'description' => 'Valore numerico della longitudine in formato decimale.',
      'tooltip' => '',
    ),
    'fax' => 
    array (
      'label' => 'Fax',
      'placeholder' => 'Inserisci il numero di fax',
      'help' => 'Numero di fax associato all\'indirizzo.',
      'helper_text' => '',
      'description' => 'Numero di fax del recapito, usato per comunicazioni tradizionali.',
      'tooltip' => '',
    ),
    'mobile' => 
    array (
      'label' => 'Cellulare',
      'placeholder' => 'Inserisci il numero di cellulare',
      'help' => 'Numero di telefono cellulare associato all\'indirizzo.',
      'helper_text' => '',
      'description' => 'Numero di telefono mobile per contatti rapidi.',
      'tooltip' => '',
    ),
    'pec' => 
    array (
      'label' => 'PEC',
      'placeholder' => 'Inserisci l\'indirizzo PEC',
      'help' => 'Indirizzo di Posta Elettronica Certificata.',
      'helper_text' => '',
      'description' => 'Indirizzo PEC utilizzato per comunicazioni ufficiali.',
      'tooltip' => '',
    ),
    'whatsapp' => 
    array (
      'label' => 'WhatsApp',
      'placeholder' => 'Inserisci il numero WhatsApp',
      'help' => 'Numero di telefono utilizzato per WhatsApp.',
      'helper_text' => '',
      'description' => 'Recapito WhatsApp per comunicazioni via chat.',
      'tooltip' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'indirizzo email',
      'help' => 'Indirizzo email associato all\'indirizzo.',
      'helper_text' => '',
      'description' => 'Indirizzo email di contatto per questo recapito.',
      'tooltip' => '',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Aggiungi eventuali note',
      'help' => 'Note aggiuntive sull\'indirizzo o sulle modalità di consegna.',
      'helper_text' => '',
      'description' => 'Spazio libero per annotazioni operative o contestuali sull\'indirizzo.',
      'tooltip' => '',
    ),
  ),
  'label' => 'Address Item',
  'plural_label' => 'Address Item (Plurale)',
  'navigation' => 
  array (
    'name' => 'Address Item',
    'plural' => 'Address Item',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Address Item',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Address Item',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Address Item',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Address Item',
    ),
  ),
);

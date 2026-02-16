<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Geo',
    'plural' => 'Geo',
    'group' => 
    array (
      'name' => 'Geo',
      'description' => 'Gestione delle informazioni geografiche',
    ),
    'label' => 'Geografia',
    'sort' => 30,
    'icon' => 'heroicon-o-map',
  ),
  'sections' => 
  array (
    'locations' => 
    array (
      'name' => 'Località',
      'description' => 'Gestione delle località geografiche',
      'icon' => 'heroicon-o-map-pin',
    ),
    'administrative' => 
    array (
      'name' => 'Amministrativo',
      'description' => 'Divisioni amministrative',
      'icon' => 'heroicon-o-building-office',
    ),
    'services' => 
    array (
      'name' => 'Servizi',
      'description' => 'Servizi geografici e utilità',
      'icon' => 'heroicon-o-cog',
    ),
    'tools' => 
    array (
      'name' => 'Strumenti',
      'description' => 'Strumenti e utilità geografiche',
      'icon' => 'heroicon-o-wrench-screwdriver',
    ),
    'analytics' => 
    array (
      'name' => 'Analisi',
      'description' => 'Analisi e statistiche geografiche',
      'icon' => 'heroicon-o-chart-bar',
    ),
  ),
  'resources' => 
  array (
    'addresses' => 
    array (
      'name' => 'Indirizzi',
      'plural' => 'Indirizzi',
      'description' => 'Gestione degli indirizzi',
      'icon' => 'heroicon-o-home',
    ),
    'cities' => 
    array (
      'name' => 'Città',
      'plural' => 'Città',
      'description' => 'Gestione delle città',
      'icon' => 'heroicon-o-building-library',
    ),
    'provinces' => 
    array (
      'name' => 'Province',
      'plural' => 'Province',
      'description' => 'Gestione delle province',
      'icon' => 'heroicon-o-building-office-2',
    ),
    'regions' => 
    array (
      'name' => 'Regioni',
      'plural' => 'Regioni',
      'description' => 'Gestione delle regioni',
      'icon' => 'heroicon-o-flag',
    ),
    'countries' => 
    array (
      'name' => 'Paesi',
      'plural' => 'Paesi',
      'description' => 'Gestione dei paesi',
      'icon' => 'heroicon-o-globe-alt',
    ),
    'municipalities' => 
    array (
      'name' => 'Comuni',
      'plural' => 'Comuni',
      'description' => 'Gestione dei comuni',
      'icon' => 'heroicon-o-building',
    ),
    'postal_codes' => 
    array (
      'name' => 'CAP',
      'plural' => 'CAP',
      'description' => 'Gestione dei codici postali',
      'icon' => 'heroicon-o-envelope',
    ),
    'boundaries' => 
    array (
      'name' => 'Confini',
      'plural' => 'Confini',
      'description' => 'Gestione dei confini amministrativi',
      'icon' => 'heroicon-o-square-3-stack-3d',
    ),
    'areas' => 
    array (
      'name' => 'Aree',
      'plural' => 'Aree',
      'description' => 'Gestione delle aree geografiche',
      'icon' => 'heroicon-o-squares-2x2',
    ),
    'markers' => 
    array (
      'name' => 'Marcatori',
      'plural' => 'Marcatori',
      'description' => 'Gestione dei marcatori geografici',
      'icon' => 'heroicon-o-map-pin',
    ),
    'routes' => 
    array (
      'name' => 'Percorsi',
      'plural' => 'Percorsi',
      'description' => 'Gestione dei percorsi',
      'icon' => 'heroicon-o-arrow-path',
    ),
    'maps' => 
    array (
      'name' => 'Mappe',
      'plural' => 'Mappe',
      'description' => 'Gestione delle mappe',
      'icon' => 'heroicon-o-map',
    ),
  ),
  'services' => 
  array (
    'geocoding' => 
    array (
      'name' => 'Geocoding',
      'description' => 'Servizio di geocoding',
      'icon' => 'heroicon-o-magnifying-glass',
    ),
    'geolocation' => 
    array (
      'name' => 'Geolocalizzazione',
      'description' => 'Servizio di geolocalizzazione',
      'icon' => 'heroicon-o-device-phone-mobile',
    ),
    'distance' => 
    array (
      'name' => 'Distanze',
      'description' => 'Calcolo delle distanze',
      'icon' => 'heroicon-o-arrows-pointing-out',
    ),
    'import' => 
    array (
      'name' => 'Importazione',
      'description' => 'Importazione dati geografici',
      'icon' => 'heroicon-o-arrow-down-tray',
    ),
    'export' => 
    array (
      'name' => 'Esportazione',
      'description' => 'Esportazione dati geografici',
      'icon' => 'heroicon-o-arrow-up-tray',
    ),
    'search' => 
    array (
      'name' => 'Ricerca',
      'description' => 'Ricerca geografica',
      'icon' => 'heroicon-o-magnifying-glass-plus',
    ),
    'validation' => 
    array (
      'name' => 'Validazione',
      'description' => 'Validazione dati geografici',
      'icon' => 'heroicon-o-check-circle',
    ),
    'cache' => 
    array (
      'name' => 'Cache',
      'description' => 'Gestione cache geografica',
      'icon' => 'heroicon-o-archive-box',
    ),
    'log' => 
    array (
      'name' => 'Log',
      'description' => 'Log dei servizi geografici',
      'icon' => 'heroicon-o-document-text',
    ),
    'notification' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Notifiche geografiche',
      'icon' => 'heroicon-o-bell',
    ),
    'config' => 
    array (
      'name' => 'Configurazione',
      'description' => 'Configurazione servizi geografici',
      'icon' => 'heroicon-o-cog-6-tooth',
    ),
    'utilities' => 
    array (
      'name' => 'Utilità',
      'description' => 'Utilità geografiche',
      'icon' => 'heroicon-o-wrench-screwdriver',
    ),
    'api' => 
    array (
      'name' => 'API',
      'description' => 'API geografiche',
      'icon' => 'heroicon-o-code-bracket',
    ),
    'webhook' => 
    array (
      'name' => 'Webhook',
      'description' => 'Webhook geografici',
      'icon' => 'heroicon-o-link',
    ),
    'filters' => 
    array (
      'name' => 'Filtri',
      'description' => 'Filtri geografici',
      'icon' => 'heroicon-o-funnel',
    ),
    'sorting' => 
    array (
      'name' => 'Ordinamento',
      'description' => 'Ordinamento dati geografici',
      'icon' => 'heroicon-o-arrows-up-down',
    ),
    'pagination' => 
    array (
      'name' => 'Paginazione',
      'description' => 'Paginazione risultati geografici',
      'icon' => 'heroicon-o-rectangle-stack',
    ),
    'statistics' => 
    array (
      'name' => 'Statistiche',
      'description' => 'Statistiche geografiche',
      'icon' => 'heroicon-o-chart-pie',
    ),
    'dashboard' => 
    array (
      'name' => 'Dashboard',
      'description' => 'Dashboard geografica',
      'icon' => 'heroicon-o-presentation-chart-line',
    ),
  ),
  'actions' => 
  array (
    'create' => 'Crea',
    'edit' => 'Modifica',
    'delete' => 'Elimina',
    'view' => 'Visualizza',
    'list' => 'Lista',
    'search' => 'Cerca',
    'filter' => 'Filtra',
    'sort' => 'Ordina',
    'export' => 'Esporta',
    'import' => 'Importa',
    'refresh' => 'Aggiorna',
    'reset' => 'Resetta',
    'back' => 'Indietro',
    'save' => 'Salva',
    'cancel' => 'Annulla',
    'confirm' => 'Conferma',
    'close' => 'Chiudi',
    'next' => 'Avanti',
    'previous' => 'Precedente',
    'first' => 'Prima',
    'last' => 'Ultima',
  ),
  'status' => 
  array (
    'active' => 'Attivo',
    'inactive' => 'Inattivo',
    'pending' => 'In attesa',
    'approved' => 'Approvato',
    'rejected' => 'Rifiutato',
    'draft' => 'Bozza',
    'published' => 'Pubblicato',
    'archived' => 'Archiviato',
    'deleted' => 'Eliminato',
    'enabled' => 'Abilitato',
    'disabled' => 'Disabilitato',
    'visible' => 'Visibile',
    'hidden' => 'Nascosto',
    'public' => 'Pubblico',
    'private' => 'Privato',
  ),
  'label' => 'Navigation',
  'plural_label' => 'Navigation (Plurale)',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
);

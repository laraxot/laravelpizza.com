<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Dispositivi',
    'plural_label' => 'Dispositivi',
    'group' => 
    array (
      'name' => 'Sicurezza',
      'description' => 'Gestione dispositivi e sicurezza',
    ),
    'sort' => 50,
    'icon' => 'heroicon-o-device-phone-mobile',
    'badge' => 'Gestione dispositivi utente',
  ),
  'model' => 
  array (
    'label' => 'Dispositivo',
    'plural' => 'Dispositivi',
    'description' => 'Gestione e monitoraggio dei dispositivi degli utenti',
  ),
  'fields' => 
  array (
    'uuid' => 
    array (
      'label' => 'UUID',
      'placeholder' => 'Inserisci l\'UUID del dispositivo',
      'tooltip' => 'Identificativo univoco universale',
      'helper_text' => 'Codice alfanumerico che identifica in modo univoco il dispositivo nel sistema',
      'help' => 'Identificativo univoco del dispositivo',
      'description' => '',
    ),
    'mobile_id' => 
    array (
      'label' => 'Mobile ID',
      'placeholder' => 'Inserisci l\'ID mobile',
      'tooltip' => 'Identificativo specifico per dispositivi mobili',
      'helper_text' => 'Codice utilizzato per identificare il dispositivo nelle applicazioni mobile',
      'help' => 'Identificativo mobile del dispositivo',
      'description' => '',
    ),
    'languages' => 
    array (
      'label' => 'Lingue',
      'placeholder' => 'Aggiungi una lingua',
      'tooltip' => 'Lingue supportate dal dispositivo',
      'helper_text' => 'Elenco delle lingue configurate o supportate dal dispositivo (formato: it, en, es]',
      'help' => 'Seleziona o digita i codici delle lingue (es. it, en, es]',
      'description' => '',
    ),
    'device' => 
    array (
      'label' => 'Nome Dispositivo',
      'placeholder' => 'Inserisci il nome del dispositivo',
      'tooltip' => 'Nome identificativo del dispositivo',
      'helper_text' => 'Nome descrittivo o modello del dispositivo utilizzato dall\'utente',
      'help' => 'Nome del dispositivo',
      'description' => '',
    ),
    'platform' => 
    array (
      'label' => 'Piattaforma',
      'placeholder' => 'Inserisci la piattaforma',
      'tooltip' => 'Sistema operativo del dispositivo',
      'helper_text' => 'Sistema operativo o piattaforma su cui funziona il dispositivo',
      'help' => 'Piattaforma del dispositivo (iOS, Android, Windows, Linux, macOS]',
      'description' => '',
    ),
    'browser' => 
    array (
      'label' => 'Browser',
      'placeholder' => 'Inserisci il browser',
      'tooltip' => 'Browser web utilizzato',
      'helper_text' => 'Applicazione browser utilizzata per navigare su internet',
      'help' => 'Browser utilizzato (Chrome, Firefox, Safari, Edge]',
      'description' => '',
    ),
    'version' => 
    array (
      'label' => 'Versione',
      'placeholder' => 'Inserisci la versione',
      'tooltip' => 'Versione del software',
      'helper_text' => 'Numero di versione del browser o del sistema operativo',
      'help' => 'Versione del browser o sistema operativo',
      'description' => '',
    ),
    'is_robot' => 
    array (
      'label' => 'È Robot',
      'placeholder' => 'Seleziona se è un robot',
      'tooltip' => 'Indica se è un bot automatizzato',
      'helper_text' => 'Specifica se il dispositivo è utilizzato da un robot o sistema automatizzato',
      'help' => 'Indica se il dispositivo è un robot o bot automatizzato',
      'description' => '',
    ),
    'robot' => 
    array (
      'label' => 'Robot',
      'placeholder' => 'Inserisci il tipo di robot',
      'tooltip' => 'Tipo specifico di robot',
      'helper_text' => 'Nome o tipo del robot/crawler se il dispositivo è automatizzato',
      'help' => 'Tipo di robot se applicabile (Googlebot, Bingbot, etc.]',
      'description' => '',
    ),
    'is_desktop' => 
    array (
      'label' => 'È Desktop',
      'placeholder' => 'Seleziona se è desktop',
      'tooltip' => 'Dispositivo desktop o computer fisso',
      'helper_text' => 'Indica se si tratta di un computer desktop o workstation fissa',
      'help' => 'Indica se è un dispositivo desktop o computer fisso',
      'description' => '',
    ),
    'is_mobile' => 
    array (
      'label' => 'È Mobile',
      'placeholder' => 'Seleziona se è mobile',
      'tooltip' => 'Dispositivo mobile portatile',
      'helper_text' => 'Specifica se il dispositivo è mobile (smartphone, tablet o dispositivo portatile]',
      'help' => 'Indica se è un dispositivo mobile (smartphone o tablet]',
      'description' => '',
    ),
    'is_tablet' => 
    array (
      'label' => 'È Tablet',
      'placeholder' => 'Seleziona se è tablet',
      'tooltip' => 'Dispositivo tablet con schermo touch',
      'helper_text' => 'Indica se si tratta di un tablet o dispositivo con schermo di medie dimensioni',
      'help' => 'Indica se è un tablet o dispositivo con schermo di medie dimensioni',
      'description' => '',
    ),
    'is_phone' => 
    array (
      'label' => 'È Telefono',
      'placeholder' => 'Seleziona se è telefono',
      'tooltip' => 'Smartphone o telefono cellulare',
      'helper_text' => 'Specifica se il dispositivo è uno smartphone o telefono cellulare',
      'help' => 'Indica se è uno smartphone o telefono cellulare',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Dispositivo',
      'icon' => 'heroicon-o-plus',
      'color' => 'primary',
      'tooltip' => 'Aggiungi un nuovo dispositivo al sistema',
      'modal' => 
      array (
        'heading' => 'Crea Nuovo Dispositivo',
        'description' => 'Inserisci i dettagli del nuovo dispositivo da aggiungere',
        'confirm' => 'Crea',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Dispositivo creato con successo',
        'error' => 'Si è verificato un errore durante la creazione del dispositivo',
      ),
    ),
    'edit' => 
    array (
      'label' => 'Modifica Dispositivo',
      'icon' => 'heroicon-o-pencil',
      'color' => 'warning',
      'tooltip' => 'Modifica i dettagli del dispositivo selezionato',
      'modal' => 
      array (
        'heading' => 'Modifica Dispositivo',
        'description' => 'Aggiorna le informazioni del dispositivo',
        'confirm' => 'Salva modifiche',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Dispositivo modificato con successo',
        'error' => 'Si è verificato un errore durante la modifica del dispositivo',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Elimina Dispositivo',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'tooltip' => 'Elimina definitivamente il dispositivo dal sistema',
      'modal' => 
      array (
        'heading' => 'Elimina Dispositivo',
        'description' => 'Sei sicuro di voler eliminare questo dispositivo? Questa azione è irreversibile.',
        'confirm' => 'Elimina',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Dispositivo eliminato con successo',
        'error' => 'Si è verificato un errore durante l\'eliminazione del dispositivo',
      ),
    ),
    'view' => 
    array (
      'label' => 'Visualizza Dispositivo',
      'icon' => 'heroicon-o-eye',
      'color' => 'secondary',
      'tooltip' => 'Visualizza i dettagli del dispositivo',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Elimina Selezionati',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'tooltip' => 'Elimina tutti i dispositivi selezionati',
      'modal' => 
      array (
        'heading' => 'Elimina Dispositivi Selezionati',
        'description' => 'Sei sicuro di voler eliminare tutti i dispositivi selezionati? Questa azione è irreversibile.',
        'confirm' => 'Elimina tutti',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Dispositivi eliminati con successo',
        'error' => 'Si è verificato un errore durante l\'eliminazione dei dispositivi',
      ),
    ),
  ),
  'sections' => 
  array (
    'device_info' => 
    array (
      'label' => 'Informazioni Dispositivo',
      'description' => 'Dettagli tecnici del dispositivo',
    ),
    'device_type' => 
    array (
      'label' => 'Tipo Dispositivo',
      'description' => 'Categoria e classificazione del dispositivo',
    ),
    'browser_info' => 
    array (
      'label' => 'Informazioni Browser',
      'description' => 'Dettagli del browser utilizzato',
    ),
  ),
  'filters' => 
  array (
    'platform' => 
    array (
      'label' => 'Piattaforma',
      'options' => 
      array (
        'ios' => 'iOS',
        'android' => 'Android',
        'windows' => 'Windows',
        'linux' => 'Linux',
        'macos' => 'macOS',
      ),
    ),
    'device_type' => 
    array (
      'label' => 'Tipo Dispositivo',
      'options' => 
      array (
        'desktop' => 'Desktop',
        'mobile' => 'Mobile',
        'tablet' => 'Tablet',
        'phone' => 'Telefono',
      ),
    ),
    'is_robot' => 
    array (
      'label' => 'Robot',
      'options' => 
      array (
        'yes' => 'Sì',
        'no' => 'No',
      ),
    ),
  ),
  'messages' => 
  array (
    'empty_state' => 'Nessun dispositivo trovato',
    'search_placeholder' => 'Cerca dispositivi...',
    'loading' => 'Caricamento dispositivi in corso...',
    'validation' => 
    array (
      'uuid_required' => 'L\'UUID è obbligatorio',
      'uuid_unique' => 'Questo UUID è già in uso',
      'platform_required' => 'La piattaforma è obbligatoria',
      'device_required' => 'Il nome del dispositivo è obbligatorio',
      'languages_array' => 'Le lingue devono essere un array',
    ),
    'options' => 
    array (
      'platforms' => 
      array (
        'ios' => 'iOS',
        'android' => 'Android',
        'windows' => 'Windows',
        'linux' => 'Linux',
        'macos' => 'macOS',
      ),
      'device_types' => 
      array (
        'desktop' => 'Desktop',
        'mobile' => 'Mobile',
        'tablet' => 'Tablet',
        'phone' => 'Telefono',
      ),
      'boolean_options' => 
      array (
        'yes' => 'Sì',
        'no' => 'No',
      ),
    ),
    'total_devices' => 'Totale dispositivi: :count',
  ),
  'label' => 'Device',
  'plural_label' => 'Device (Plurale)',
);

<?php

declare(strict_types=1);

return array (
  'pages' => 'Seiten',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Job',
    'plural' => 'Jobs',
    'group' => 
    array (
      'name' => 'Jobs',
      'description' => 'Hintergrundprozessverwaltung',
    ),
    'label' => 'jobs',
    'sort' => 30,
    'icon' => 'heroicon-o-cog',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Eindeutige Job-Kennung',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Warteschlange',
      'tooltip' => 'Die Warteschlange, zu der dieser Job gehört',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'tooltip' => 'Mit dem Job verknüpfte Daten',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Versuche',
      'tooltip' => 'Anzahl der Versuche, den Job auszuführen',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Reserviert am',
      'tooltip' => 'Datum und Uhrzeit, zu der der Job reserviert wurde',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Verfügbar am',
      'tooltip' => 'Datum und Uhrzeit, zu der der Job verfügbar wurde',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Erstellt am',
      'tooltip' => 'Job-Erstellungsdatum',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => 'Aktueller Job-Status',
      'helper_text' => '',
      'description' => '',
    ),
    'progress' => 
    array (
      'label' => 'Fortschritt',
      'tooltip' => 'Job-Abschlussprozentsatz',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Typ',
      'tooltip' => 'Job-Typ (z.B. Import, Export)',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Name',
      'tooltip' => 'Job-Name',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Beschreibung',
      'tooltip' => 'Job-Beschreibung',
      'placeholder' => 'Geben Sie eine Beschreibung ein',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Job-Wächter',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Berechtigungen',
      'tooltip' => 'Mit dem Job verknüpfte Berechtigungen',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aktualisiert am',
      'tooltip' => 'Datum der letzten Job-Aktualisierung',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Vorname',
      'tooltip' => 'Vorname der verantwortlichen Person',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Nachname',
      'tooltip' => 'Nachname der verantwortlichen Person',
      'helper_text' => '',
      'description' => '',
    ),
    'select_all' => 
    array (
      'label' => 'Alle auswählen',
      'tooltip' => 'Alle verfügbaren Elemente auswählen',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'value' => 
    array (
      'label' => 'value',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'label' => 'Importieren',
      'tooltip' => 'Daten aus einer Datei importieren',
      'icon' => 'import-icon',
      'color' => 'blue',
      'fields' => 
      array (
        'import_file' => 
        array (
          'label' => 'Wählen Sie eine XLS- oder CSV-Datei zum Hochladen aus',
          'placeholder' => 'Wählen Sie die zu hochladende Datei aus',
        ),
      ),
    ),
    'export' => 
    array (
      'label' => 'Exportieren',
      'tooltip' => 'Daten in eine Datei exportieren',
      'icon' => 'export-icon',
      'color' => 'green',
      'filename_prefix' => 'Bereiche zum',
      'columns' => 
      array (
        'name' => 
        array (
          'label' => 'Bereichsname',
          'tooltip' => 'Name des zu exportierenden Bereichs',
        ),
        'parent_name' => 
        array (
          'label' => 'Übergeordneter Bereichsname',
          'tooltip' => 'Name des übergeordneten Bereichs',
        ),
      ),
    ),
    'run' => 
    array (
      'label' => 'Ausführen',
      'icon' => 'play',
      'color' => 'green',
      'modal' => 
      array (
        'heading' => 'Job ausführen',
        'description' => 'Möchten Sie diesen Job ausführen?',
      ),
      'messages' => 
      array (
        'success' => 'Job erfolgreich gestartet',
      ),
    ),
    'stop' => 
    array (
      'label' => 'Stoppen',
      'icon' => 'pause',
      'color' => 'red',
      'modal' => 
      array (
        'heading' => 'Job stoppen',
        'description' => 'Möchten Sie diesen Job stoppen?',
      ),
      'messages' => 
      array (
        'success' => 'Job erfolgreich gestoppt',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Löschen',
      'icon' => 'trash',
      'color' => 'red',
      'modal' => 
      array (
        'heading' => 'Job löschen',
        'description' => 'Sind Sie sicher, dass Sie diesen Job löschen möchten?',
      ),
      'messages' => 
      array (
        'success' => 'Job erfolgreich gelöscht',
      ),
    ),
  ),
  'messages' => 
  array (
    'no_jobs' => 'Keine Jobs vorhanden',
    'job_started' => 'Job gestartet',
    'job_stopped' => 'Job gestoppt',
    'job_completed' => 'Job abgeschlossen',
    'job_failed' => 'Job fehlgeschlagen',
  ),
  'statuses' => 
  array (
    'pending' => 'Ausstehend',
    'processing' => 'In Bearbeitung',
    'completed' => 'Abgeschlossen',
    'failed' => 'Fehlgeschlagen',
    'stopped' => 'Gestoppt',
  ),
  'types' => 
  array (
    'import' => 'Import',
    'export' => 'Export',
    'process' => 'Verarbeitung',
    'notification' => 'Benachrichtigung',
    'cleanup' => 'Bereinigung',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

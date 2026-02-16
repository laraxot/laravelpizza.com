<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Aktivität',
    'plural' => 'Aktivitäten',
    'group' => 
    array (
      'name' => 'Überwachung',
      'description' => 'Systemaktivitätsüberwachung',
    ),
    'label' => 'Aktivität',
    'sort' => '60',
    'icon' => 'heroicon-o-activity',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => 'Benutzer',
      'placeholder' => 'Benutzer auswählen',
      'help' => 'Der Benutzer, der die Aktion ausgeführt hat',
      'name' => 
      array (
        'label' => 'Name',
        'placeholder' => 'Name eingeben',
        'help' => 'Vollständiger Name des Benutzers',
        'validation' => 'required|string|max:255',
      ),
      'email' => 
      array (
        'label' => 'E-Mail',
        'placeholder' => 'E-Mail eingeben',
        'help' => 'E-Mail-Adresse des Benutzers',
        'validation' => 'required|email|max:255',
      ),
      'role' => 
      array (
        'label' => 'Rolle',
        'placeholder' => 'Rolle auswählen',
        'help' => 'Benutzerrolle im System',
        'validation' => 'required|string',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'action' => 
    array (
      'label' => 'Aktion',
      'placeholder' => 'Aktion auswählen',
      'help' => 'Art der ausgeführten Aktion',
      'validation' => 'required|string',
      'options' => 
      array (
        'created' => 
        array (
          'label' => 'Erstellt',
          'icon' => 'heroicon-o-plus-circle',
          'color' => 'success',
        ),
        'updated' => 
        array (
          'label' => 'Aktualisiert',
          'icon' => 'heroicon-o-pencil',
          'color' => 'warning',
        ),
        'deleted' => 
        array (
          'label' => 'Gelöscht',
          'icon' => 'heroicon-o-trash',
          'color' => 'danger',
        ),
        'viewed' => 
        array (
          'label' => 'Angezeigt',
          'icon' => 'heroicon-o-eye',
          'color' => 'info',
        ),
        'downloaded' => 
        array (
          'label' => 'Heruntergeladen',
          'icon' => 'heroicon-o-arrow-down-tray',
          'color' => 'primary',
        ),
        'uploaded' => 
        array (
          'label' => 'Hochgeladen',
          'icon' => 'heroicon-o-arrow-up-tray',
          'color' => 'primary',
        ),
        'logged_in' => 
        array (
          'label' => 'Angemeldet',
          'icon' => 'heroicon-o-arrow-right-on-rectangle',
          'color' => 'success',
        ),
        'logged_out' => 
        array (
          'label' => 'Abgemeldet',
          'icon' => 'heroicon-o-arrow-left-on-rectangle',
          'color' => 'gray',
        ),
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => 'Objekt',
      'placeholder' => 'Objekt auswählen',
      'help' => 'Das von der Aktion betroffene Objekt',
      'type' => 
      array (
        'label' => 'Typ',
        'placeholder' => 'Objekttyp',
        'help' => 'Klasse oder Typ des Objekts',
        'validation' => 'nullable|string|max:255',
      ),
      'id' => 
      array (
        'label' => 'ID',
        'placeholder' => 'Objekt-ID',
        'help' => 'Eindeutiger Bezeichner des Objekts',
        'validation' => 'nullable|integer|min:1',
      ),
      'name' => 
      array (
        'label' => 'Name',
        'placeholder' => 'Name des Objekts',
        'help' => 'Beschreibender Name des Objekts',
        'validation' => 'nullable|string|max:255',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Beschreibung',
      'placeholder' => 'Beschreibung eingeben',
      'help' => 'Detaillierte Beschreibung der Aktivität',
      'validation' => 'nullable|string|max:1000',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'IP-Adresse',
      'placeholder' => 'Z.B. 192.168.1.1',
      'help' => 'IP-Adresse, von der die Aktion ausgeführt wurde',
      'validation' => 'nullable|ip',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => 'User Agent',
      'placeholder' => 'Browser und Betriebssystem',
      'help' => 'Informationen über den Browser und das System des Benutzers',
      'validation' => 'nullable|string|max:500',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Datum',
      'placeholder' => 'Datum und Uhrzeit auswählen',
      'help' => 'Datum und Uhrzeit, zu der die Aktivität erstellt wurde',
      'validation' => 'required|date',
      'format' => 'd/m/Y H:i:s',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'properties' => 
    array (
      'label' => 'Eigenschaften',
      'placeholder' => 'Zusätzliche Eigenschaften',
      'help' => 'Zusätzliche Daten der Aktivität',
      'old' => 
      array (
        'label' => 'Alter Wert',
        'placeholder' => 'Vorheriger Wert',
        'help' => 'Wert vor der Änderung',
      ),
      'new' => 
      array (
        'label' => 'Neuer Wert',
        'placeholder' => 'Aktueller Wert',
        'help' => 'Wert nach der Änderung',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Spalten ein-/ausblenden',
      'help' => 'Spaltensichtbarkeit konfigurieren',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Datensätze neu anordnen',
      'help' => 'Datensätze in der Tabelle neu anordnen',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'Filter zurücksetzen',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'Filter anwenden',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'user' => 
    array (
      'label' => 'Benutzer',
      'placeholder' => 'Nach Benutzer filtern',
      'help' => 'Aktivitäten nach Benutzer filtern',
      'type' => 'select',
      'searchable' => '1',
    ),
    'action' => 
    array (
      'label' => 'Aktion',
      'placeholder' => 'Nach Aktion filtern',
      'help' => 'Aktivitäten nach Aktionstyp filtern',
      'type' => 'select',
      'multiple' => '1',
    ),
    'subject_type' => 
    array (
      'label' => 'Objekttyp',
      'placeholder' => 'Nach Objekttyp filtern',
      'help' => 'Aktivitäten nach Objekttyp filtern',
      'type' => 'select',
      'searchable' => '1',
    ),
    'date_range' => 
    array (
      'label' => 'Datumsbereich',
      'placeholder' => 'Datumsbereich auswählen',
      'help' => 'Aktivitäten nach Zeitraum filtern',
      'type' => 'date_range',
      'presets' => 
      array (
        'today' => 'Heute',
        'yesterday' => 'Gestern',
        'last_7_days' => 'Letzte 7 Tage',
        'last_30_days' => 'Letzte 30 Tage',
        'this_month' => 'Dieser Monat',
        'last_month' => 'Letzter Monat',
      ),
    ),
    'ip_address' => 
    array (
      'label' => 'IP-Adresse',
      'placeholder' => 'Nach IP-Adresse filtern',
      'help' => 'Aktivitäten nach IP-Adresse filtern',
      'type' => 'text',
    ),
  ),
  'actions' => 
  array (
    'view_details' => 
    array (
      'label' => 'Details anzeigen',
      'icon' => 'heroicon-o-eye',
      'color' => 'primary',
      'success' => 'Details erfolgreich geladen',
      'error' => 'Fehler beim Laden der Details',
      'confirmation' => 'Möchten Sie die Details dieser Aktivität anzeigen?',
    ),
    'export' => 
    array (
      'label' => 'Exportieren',
      'icon' => 'heroicon-o-arrow-down-tray',
      'color' => 'success',
      'success' => 'Export erfolgreich',
      'error' => 'Fehler beim Export',
      'confirmation' => 'Möchten Sie die ausgewählten Aktivitäten exportieren?',
    ),
    'clear_old' => 
    array (
      'label' => 'Alte Aktivitäten löschen',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'Alte Aktivitäten erfolgreich gelöscht',
      'error' => 'Fehler beim Löschen alter Aktivitäten',
      'confirmation' => 'Sind Sie sicher, dass Sie die alten Aktivitäten löschen möchten? Dieser Vorgang kann nicht rückgängig gemacht werden.',
      'days_threshold' => '90',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Ausgewählte Aktivitäten löschen',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'Ausgewählte Aktivitäten erfolgreich gelöscht',
      'error' => 'Fehler beim Löschen der ausgewählten Aktivitäten',
      'confirmation' => 'Sind Sie sicher, dass Sie die ausgewählten Aktivitäten löschen möchten?',
    ),
  ),
  'messages' => 
  array (
    'no_activities' => 'Keine Aktivitäten für die ausgewählten Filter gefunden',
    'cleared' => 'Alte Aktivitäten erfolgreich gelöscht',
    'exported' => 'Aktivitäten erfolgreich exportiert',
    'loading' => 'Aktivitäten werden geladen...',
    'error_loading' => 'Fehler beim Laden der Aktivitäten',
    'empty_state' => 
    array (
      'title' => 'Keine Aktivitäten aufgezeichnet',
      'description' => 'Es sind noch keine Aktivitäten vorhanden. Aktivitäten werden hier angezeigt, wenn Benutzer mit dem System interagieren.',
    ),
  ),
  'export' => 
  array (
    'formats' => 
    array (
      'csv' => 
      array (
        'label' => 'CSV',
        'mime_type' => 'text/csv',
        'extension' => 'csv',
        'icon' => 'heroicon-o-document-text',
      ),
      'excel' => 
      array (
        'label' => 'Excel',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'extension' => 'xlsx',
        'icon' => 'heroicon-o-table-cells',
      ),
      'pdf' => 
      array (
        'label' => 'PDF',
        'mime_type' => 'application/pdf',
        'extension' => 'pdf',
        'icon' => 'heroicon-o-document',
      ),
    ),
    'columns' => 
    array (
      'date' => 
      array (
        'label' => 'Datum',
        'format' => 'd/m/Y H:i:s',
        'sortable' => '1',
      ),
      'user' => 
      array (
        'label' => 'Benutzer',
        'sortable' => '1',
      ),
      'action' => 
      array (
        'label' => 'Aktion',
        'sortable' => '1',
      ),
      'subject' => 
      array (
        'label' => 'Objekt',
        'sortable' => '',
      ),
      'ip' => 
      array (
        'label' => 'IP-Adresse',
        'sortable' => '1',
      ),
      'description' => 
      array (
        'label' => 'Beschreibung',
        'sortable' => '',
      ),
    ),
    'filename_pattern' => 'aktivitaet_{date}_{time}',
    'max_records' => '10000',
  ),
  'permissions' => 
  array (
    'view' => 'activities.view',
    'create' => 'activities.create',
    'update' => 'activities.update',
    'delete' => 'activities.delete',
    'export' => 'activities.export',
    'clear_old' => 'activities.clear_old',
  ),
  'pagination' => 
  array (
    'per_page' => '25',
    'options' => 
    array (
      0 => '10',
      1 => '25',
      2 => '50',
      3 => '100',
    ),
  ),
  'cache' => 
  array (
    'ttl' => '300',
    'tags' => 
    array (
      0 => 'activities',
      1 => 'monitoring',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Aktivität',
        'plural' => 'Aktivitäten',
        'group' => [
            'name' => 'Überwachung',
            'description' => 'Systemaktivitätsüberwachung',
        ],
        'label' => 'Aktivität',
        'sort' => '60',
        'icon' => 'heroicon-o-activity',
    ],
    'fields' => [
        'user' => [
            'label' => 'Benutzer',
            'placeholder' => 'Benutzer auswählen',
            'help' => 'Der Benutzer, der die Aktion ausgeführt hat',
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Name eingeben',
                'help' => 'Vollständiger Name des Benutzers',
                'validation' => 'required|string|max:255',
            ],
            'email' => [
                'label' => 'E-Mail',
                'placeholder' => 'E-Mail eingeben',
                'help' => 'E-Mail-Adresse des Benutzers',
                'validation' => 'required|email|max:255',
            ],
            'role' => [
                'label' => 'Rolle',
                'placeholder' => 'Rolle auswählen',
                'help' => 'Benutzerrolle im System',
                'validation' => 'required|string',
            ],
        ],
        'action' => [
            'label' => 'Aktion',
            'placeholder' => 'Aktion auswählen',
            'help' => 'Art der ausgeführten Aktion',
            'validation' => 'required|string',
            'options' => [
                'created' => [
                    'label' => 'Erstellt',
                    'icon' => 'heroicon-o-plus-circle',
                    'color' => 'success',
                ],
                'updated' => [
                    'label' => 'Aktualisiert',
                    'icon' => 'heroicon-o-pencil',
                    'color' => 'warning',
                ],
                'deleted' => [
                    'label' => 'Gelöscht',
                    'icon' => 'heroicon-o-trash',
                    'color' => 'danger',
                ],
                'viewed' => [
                    'label' => 'Angezeigt',
                    'icon' => 'heroicon-o-eye',
                    'color' => 'info',
                ],
                'downloaded' => [
                    'label' => 'Heruntergeladen',
                    'icon' => 'heroicon-o-arrow-down-tray',
                    'color' => 'primary',
                ],
                'uploaded' => [
                    'label' => 'Hochgeladen',
                    'icon' => 'heroicon-o-arrow-up-tray',
                    'color' => 'primary',
                ],
                'logged_in' => [
                    'label' => 'Angemeldet',
                    'icon' => 'heroicon-o-arrow-right-on-rectangle',
                    'color' => 'success',
                ],
                'logged_out' => [
                    'label' => 'Abgemeldet',
                    'icon' => 'heroicon-o-arrow-left-on-rectangle',
                    'color' => 'gray',
                ],
            ],
        ],
        'subject' => [
            'label' => 'Objekt',
            'placeholder' => 'Objekt auswählen',
            'help' => 'Das von der Aktion betroffene Objekt',
            'type' => [
                'label' => 'Typ',
                'placeholder' => 'Objekttyp',
                'help' => 'Klasse oder Typ des Objekts',
                'validation' => 'nullable|string|max:255',
            ],
            'id' => [
                'label' => 'ID',
                'placeholder' => 'Objekt-ID',
                'help' => 'Eindeutiger Bezeichner des Objekts',
                'validation' => 'nullable|integer|min:1',
            ],
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Name des Objekts',
                'help' => 'Beschreibender Name des Objekts',
                'validation' => 'nullable|string|max:255',
            ],
        ],
        'description' => [
            'label' => 'Beschreibung',
            'placeholder' => 'Beschreibung eingeben',
            'help' => 'Detaillierte Beschreibung der Aktivität',
            'validation' => 'nullable|string|max:1000',
        ],
        'ip_address' => [
            'label' => 'IP-Adresse',
            'placeholder' => 'Z.B. 192.168.1.1',
            'help' => 'IP-Adresse, von der die Aktion ausgeführt wurde',
            'validation' => 'nullable|ip',
        ],
        'user_agent' => [
            'label' => 'User Agent',
            'placeholder' => 'Browser und Betriebssystem',
            'help' => 'Informationen über den Browser und das System des Benutzers',
            'validation' => 'nullable|string|max:500',
        ],
        'created_at' => [
            'label' => 'Datum',
            'placeholder' => 'Datum und Uhrzeit auswählen',
            'help' => 'Datum und Uhrzeit, zu der die Aktivität erstellt wurde',
            'validation' => 'required|date',
            'format' => 'd/m/Y H:i:s',
        ],
        'properties' => [
            'label' => 'Eigenschaften',
            'placeholder' => 'Zusätzliche Eigenschaften',
            'help' => 'Zusätzliche Daten der Aktivität',
            'old' => [
                'label' => 'Alter Wert',
                'placeholder' => 'Vorheriger Wert',
                'help' => 'Wert vor der Änderung',
            ],
            'new' => [
                'label' => 'Neuer Wert',
                'placeholder' => 'Aktueller Wert',
                'help' => 'Wert nach der Änderung',
            ],
        ],
        'toggleColumns' => [
            'label' => 'Spalten ein-/ausblenden',
            'help' => 'Spaltensichtbarkeit konfigurieren',
        ],
        'reorderRecords' => [
            'label' => 'Datensätze neu anordnen',
            'help' => 'Datensätze in der Tabelle neu anordnen',
        ],
        'resetFilters' => [
            'label' => 'Filter zurücksetzen',
        ],
        'applyFilters' => [
            'label' => 'Filter anwenden',
        ],
    ],
    'filters' => [
        'user' => [
            'label' => 'Benutzer',
            'placeholder' => 'Nach Benutzer filtern',
            'help' => 'Aktivitäten nach Benutzer filtern',
            'type' => 'select',
            'searchable' => '1',
        ],
        'action' => [
            'label' => 'Aktion',
            'placeholder' => 'Nach Aktion filtern',
            'help' => 'Aktivitäten nach Aktionstyp filtern',
            'type' => 'select',
            'multiple' => '1',
        ],
        'subject_type' => [
            'label' => 'Objekttyp',
            'placeholder' => 'Nach Objekttyp filtern',
            'help' => 'Aktivitäten nach Objekttyp filtern',
            'type' => 'select',
            'searchable' => '1',
        ],
        'date_range' => [
            'label' => 'Datumsbereich',
            'placeholder' => 'Datumsbereich auswählen',
            'help' => 'Aktivitäten nach Zeitraum filtern',
            'type' => 'date_range',
            'presets' => [
                'today' => 'Heute',
                'yesterday' => 'Gestern',
                'last_7_days' => 'Letzte 7 Tage',
                'last_30_days' => 'Letzte 30 Tage',
                'this_month' => 'Dieser Monat',
                'last_month' => 'Letzter Monat',
            ],
        ],
        'ip_address' => [
            'label' => 'IP-Adresse',
            'placeholder' => 'Nach IP-Adresse filtern',
            'help' => 'Aktivitäten nach IP-Adresse filtern',
            'type' => 'text',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Details anzeigen',
            'icon' => 'heroicon-o-eye',
            'color' => 'primary',
            'success' => 'Details erfolgreich geladen',
            'error' => 'Fehler beim Laden der Details',
            'confirmation' => 'Möchten Sie die Details dieser Aktivität anzeigen?',
        ],
        'export' => [
            'label' => 'Exportieren',
            'icon' => 'heroicon-o-arrow-down-tray',
            'color' => 'success',
            'success' => 'Export erfolgreich',
            'error' => 'Fehler beim Export',
            'confirmation' => 'Möchten Sie die ausgewählten Aktivitäten exportieren?',
        ],
        'clear_old' => [
            'label' => 'Alte Aktivitäten löschen',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'success' => 'Alte Aktivitäten erfolgreich gelöscht',
            'error' => 'Fehler beim Löschen alter Aktivitäten',
            'confirmation' => 'Sind Sie sicher, dass Sie die alten Aktivitäten löschen möchten? Dieser Vorgang kann nicht rückgängig gemacht werden.',
            'days_threshold' => '90',
        ],
        'bulk_delete' => [
            'label' => 'Ausgewählte Aktivitäten löschen',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'success' => 'Ausgewählte Aktivitäten erfolgreich gelöscht',
            'error' => 'Fehler beim Löschen der ausgewählten Aktivitäten',
            'confirmation' => 'Sind Sie sicher, dass Sie die ausgewählten Aktivitäten löschen möchten?',
        ],
    ],
    'messages' => [
        'no_activities' => 'Keine Aktivitäten für die ausgewählten Filter gefunden',
        'cleared' => 'Alte Aktivitäten erfolgreich gelöscht',
        'exported' => 'Aktivitäten erfolgreich exportiert',
        'loading' => 'Aktivitäten werden geladen...',
        'error_loading' => 'Fehler beim Laden der Aktivitäten',
        'empty_state' => [
            'title' => 'Keine Aktivitäten aufgezeichnet',
            'description' => 'Es sind noch keine Aktivitäten vorhanden. Aktivitäten werden hier angezeigt, wenn Benutzer mit dem System interagieren.',
        ],
    ],
    'export' => [
        'formats' => [
            'csv' => [
                'label' => 'CSV',
                'mime_type' => 'text/csv',
                'extension' => 'csv',
                'icon' => 'heroicon-o-document-text',
            ],
            'excel' => [
                'label' => 'Excel',
                'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'extension' => 'xlsx',
                'icon' => 'heroicon-o-table-cells',
            ],
            'pdf' => [
                'label' => 'PDF',
                'mime_type' => 'application/pdf',
                'extension' => 'pdf',
                'icon' => 'heroicon-o-document',
            ],
        ],
        'columns' => [
            'date' => [
                'label' => 'Datum',
                'format' => 'd/m/Y H:i:s',
                'sortable' => '1',
            ],
            'user' => [
                'label' => 'Benutzer',
                'sortable' => '1',
            ],
            'action' => [
                'label' => 'Aktion',
                'sortable' => '1',
            ],
            'subject' => [
                'label' => 'Objekt',
                'sortable' => '',
            ],
            'ip' => [
                'label' => 'IP-Adresse',
                'sortable' => '1',
            ],
            'description' => [
                'label' => 'Beschreibung',
                'sortable' => '',
            ],
        ],
        'filename_pattern' => 'aktivitaet_{date}_{time}',
        'max_records' => '10000',
    ],
    'permissions' => [
        'view' => 'activities.view',
        'create' => 'activities.create',
        'update' => 'activities.update',
        'delete' => 'activities.delete',
        'export' => 'activities.export',
        'clear_old' => 'activities.clear_old',
    ],
    'pagination' => [
        'per_page' => '25',
        'options' => [
            '0' => '10',
            '1' => '25',
            '2' => '50',
            '3' => '100',
        ],
    ],
    'cache' => [
        'ttl' => '300',
        'tags' => [
            '0' => 'activities',
            '1' => 'monitoring',
        ],
    ],
];

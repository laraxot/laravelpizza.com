<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Tenant',
        'group' => 'System',
        'sort' => 25,
        'icon' => 'tenant-main-animated',
        'badge' => [
            'color' => 'success',
            'label' => 'Multi-tenant',
        ],
    ],
    'sections' => [
        'building' => [
            'navigation' => [
                'name' => 'Gebäude',
                'group' => 'Tenant',
                'sort' => 10,
                'icon' => 'tenant-building-animated',
                'badge' => [
                    'color' => 'info',
                    'label' => 'Verwaltung',
                ],
            ],
            'fields' => [
                'name' => 'Name',
                'address' => 'Adresse',
                'units' => 'Einheiten',
                'manager' => 'Verwalter',
                'status' => 'Status',
                'notes' => 'Notizen',
            ],
        ],
        'unit' => [
            'navigation' => [
                'name' => 'Wohneinheiten',
                'group' => 'Tenant',
                'sort' => 20,
                'icon' => 'tenant-unit-icon',
                'badge' => [
                    'color' => 'warning',
                    'label' => 'Belegung',
                ],
            ],
            'fields' => [
                'number' => 'Nummer',
                'floor' => 'Etage',
                'type' => 'Typ',
                'size' => 'Größe',
                'tenant' => 'Mieter',
                'rent' => 'Miete',
                'status' => 'Status',
            ],
            'types' => [
                'apartment' => 'Wohnung',
                'office' => 'Büro',
                'store' => 'Geschäft',
                'warehouse' => 'Lager',
            ],
        ],
        'tenant' => [
            'navigation' => [
                'name' => 'Mieter',
                'group' => 'Tenant',
                'sort' => 30,
                'icon' => 'tenant-person-icon',
                'badge' => [
                    'color' => 'primary',
                    'label' => 'Verträge',
                ],
            ],
            'fields' => [
                'name' => 'Name',
                'last_name' => 'Nachname',
                'tax_code' => 'Steuernummer',
                'email' => 'E-Mail',
                'phone' => 'Telefon',
                'contract_start' => 'Vertragsbeginn',
                'contract_end' => 'Vertragsende',
                'deposit' => 'Kaution',
            ],
        ],
    ],
    'common' => [
        'status' => [
            'active' => 'Aktiv',
            'inactive' => 'Inaktiv',
            'maintenance' => 'In Wartung',
            'reserved' => 'Reserviert',
        ],
        'actions' => [
            'create' => 'Erstellen',
            'edit' => 'Bearbeiten',
            'delete' => 'Löschen',
            'view' => 'Anzeigen',
            'assign' => 'Zuweisen',
            'unassign' => 'Zuweisung entfernen',
            'renew' => 'Erneuern',
            'terminate' => 'Beenden',
        ],
        'messages' => [
            'success' => [
                'created' => 'Erfolgreich erstellt',
                'updated' => 'Erfolgreich aktualisiert',
                'deleted' => 'Erfolgreich gelöscht',
                'assigned' => 'Erfolgreich zugewiesen',
                'unassigned' => 'Zuweisung erfolgreich entfernt',
            ],
            'error' => [
                'create' => 'Fehler beim Erstellen',
                'update' => 'Fehler beim Aktualisieren',
                'delete' => 'Fehler beim Löschen',
                'assign' => 'Fehler beim Zuweisen',
                'unassign' => 'Fehler beim Entfernen der Zuweisung',
            ],
            'confirm' => [
                'delete' => 'Sind Sie sicher, dass Sie dieses Element löschen möchten?',
                'terminate' => 'Sind Sie sicher, dass Sie diesen Vertrag beenden möchten?',
            ],
        ],
        'filters' => [
            'status' => 'Status',
            'type' => 'Typ',
            'floor' => 'Etage',
            'date_range' => 'Zeitraum',
            'occupation' => 'Belegung',
        ],
    ],
];

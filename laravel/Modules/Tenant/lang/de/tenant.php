<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Tenant',
    'group' => 'System',
    'sort' => 25,
    'icon' => 'tenant-main-animated',
    'badge' => 
    array (
      'color' => 'success',
      'label' => 'Multi-tenant',
    ),
  ),
  'sections' => 
  array (
    'building' => 
    array (
      'navigation' => 
      array (
        'name' => 'Gebäude',
        'group' => 'Tenant',
        'sort' => 10,
        'icon' => 'tenant-building-animated',
        'badge' => 
        array (
          'color' => 'info',
          'label' => 'Verwaltung',
        ),
      ),
      'fields' => 
      array (
        'name' => 'Name',
        'address' => 'Adresse',
        'units' => 'Einheiten',
        'manager' => 'Verwalter',
        'status' => 'Status',
        'notes' => 'Notizen',
      ),
    ),
    'unit' => 
    array (
      'navigation' => 
      array (
        'name' => 'Wohneinheiten',
        'group' => 'Tenant',
        'sort' => 20,
        'icon' => 'tenant-unit-icon',
        'badge' => 
        array (
          'color' => 'warning',
          'label' => 'Belegung',
        ),
      ),
      'fields' => 
      array (
        'number' => 'Nummer',
        'floor' => 'Etage',
        'type' => 'Typ',
        'size' => 'Größe',
        'tenant' => 'Mieter',
        'rent' => 'Miete',
        'status' => 'Status',
      ),
      'types' => 
      array (
        'apartment' => 'Wohnung',
        'office' => 'Büro',
        'store' => 'Geschäft',
        'warehouse' => 'Lager',
      ),
    ),
    'tenant' => 
    array (
      'navigation' => 
      array (
        'name' => 'Mieter',
        'group' => 'Tenant',
        'sort' => 30,
        'icon' => 'tenant-person-icon',
        'badge' => 
        array (
          'color' => 'primary',
          'label' => 'Verträge',
        ),
      ),
      'fields' => 
      array (
        'name' => 'Name',
        'last_name' => 'Nachname',
        'tax_code' => 'Steuernummer',
        'email' => 'E-Mail',
        'phone' => 'Telefon',
        'contract_start' => 'Vertragsbeginn',
        'contract_end' => 'Vertragsende',
        'deposit' => 'Kaution',
      ),
    ),
  ),
  'common' => 
  array (
    'status' => 
    array (
      'active' => 'Aktiv',
      'inactive' => 'Inaktiv',
      'maintenance' => 'In Wartung',
      'reserved' => 'Reserviert',
    ),
    'actions' => 
    array (
      'create' => 'Erstellen',
      'edit' => 'Bearbeiten',
      'delete' => 'Löschen',
      'view' => 'Anzeigen',
      'assign' => 'Zuweisen',
      'unassign' => 'Zuweisung entfernen',
      'renew' => 'Erneuern',
      'terminate' => 'Beenden',
    ),
    'messages' => 
    array (
      'success' => 
      array (
        'created' => 'Erfolgreich erstellt',
        'updated' => 'Erfolgreich aktualisiert',
        'deleted' => 'Erfolgreich gelöscht',
        'assigned' => 'Erfolgreich zugewiesen',
        'unassigned' => 'Zuweisung erfolgreich entfernt',
      ),
      'error' => 
      array (
        'create' => 'Fehler beim Erstellen',
        'update' => 'Fehler beim Aktualisieren',
        'delete' => 'Fehler beim Löschen',
        'assign' => 'Fehler beim Zuweisen',
        'unassign' => 'Fehler beim Entfernen der Zuweisung',
      ),
      'confirm' => 
      array (
        'delete' => 'Sind Sie sicher, dass Sie dieses Element löschen möchten?',
        'terminate' => 'Sind Sie sicher, dass Sie diesen Vertrag beenden möchten?',
      ),
    ),
    'filters' => 
    array (
      'status' => 'Status',
      'type' => 'Typ',
      'floor' => 'Etage',
      'date_range' => 'Zeitraum',
      'occupation' => 'Belegung',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
  'actions' => 
  array (
  ),
);

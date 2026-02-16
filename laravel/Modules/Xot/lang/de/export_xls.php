<?php

declare(strict_types=1);

return array (
  'actions' => 
  array (
    'export_xls' => 
    array (
      'label' => 'Excel exportieren',
      'icon' => 'heroicon-o-arrow-down-tray',
      'tooltip' => 'Daten im Excel-Format (.xlsx) exportieren',
      'placeholder' => 'Nach Excel exportieren',
      'help' => 'Aktuelle Daten im Excel-Format für Offline-Analyse herunterladen',
      'description' => 'Aktion zum Exportieren von Daten im Excel-Format',
      'success' => 'Excel-Export erfolgreich abgeschlossen',
      'error' => 'Beim Excel-Export ist ein Fehler aufgetreten',
      'modal' => 
      array (
        'heading' => 'Nach Excel exportieren',
        'description' => 'Exportoptionen für die Excel-Datei auswählen',
        'confirm' => 'Exportieren',
        'cancel' => 'Abbrechen',
      ),
      'options' => 
      array (
        'include_headers' => 'Spaltenüberschriften einschließen',
        'format_dates' => 'Daten formatieren',
        'include_totals' => 'Summen einschließen',
      ),
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
);

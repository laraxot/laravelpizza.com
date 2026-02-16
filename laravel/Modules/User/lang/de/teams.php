<?php

declare(strict_types=1);

return array (
  'name' => 'Teams',
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Name',
      'placeholder' => 'Teamnamen eingeben',
      'helper_text' => 'Team-Identifikationsname',
      'description' => 'Der Name, der dieses Team identifiziert',
      'tooltip' => '',
    ),
    'personal_team' => 
    array (
      'label' => 'Persönliches Team',
      'helper_text' => 'Gibt an, ob es sich um ein persönliches Team handelt',
      'description' => 'Ein persönliches Team ist einem einzelnen Benutzer zugeordnet',
      'tooltip' => '',
    ),
    'owner' => 
    array (
      'label' => 'Besitzer',
      'helper_text' => 'Team-Besitzer-Benutzer',
      'description' => 'Der Benutzer, der dieses Team erstellt und verwaltet',
      'tooltip' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Erstellungsdatum',
      'helper_text' => 'Team-Erstellungsdatum',
      'description' => 'Datum und Uhrzeit der Team-Erstellung',
      'tooltip' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Zuletzt geändert',
      'helper_text' => 'Datum der letzten Änderung',
      'description' => 'Datum und Uhrzeit der letzten Team-Änderung',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Neues Team',
      'tooltip' => 'Ein neues Team erstellen',
    ),
    'edit' => 
    array (
      'label' => 'Bearbeiten',
      'tooltip' => 'Team-Daten bearbeiten',
    ),
    'delete' => 
    array (
      'label' => 'Löschen',
      'tooltip' => 'Das Team löschen',
    ),
    'view' => 
    array (
      'label' => 'Anzeigen',
      'tooltip' => 'Team-Details anzeigen',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Team erfolgreich erstellt',
      'updated' => 'Team erfolgreich aktualisiert',
      'deleted' => 'Team erfolgreich gelöscht',
    ),
    'error' => 
    array (
      'create' => 'Fehler beim Erstellen des Teams',
      'update' => 'Fehler beim Aktualisieren des Teams',
      'delete' => 'Fehler beim Löschen des Teams',
    ),
    'confirm' => 
    array (
      'delete' => 'Sind Sie sicher, dass Sie dieses Team löschen möchten?',
    ),
  ),
  'relationships' => 
  array (
    'members' => 
    array (
      'label' => 'Mitglieder',
      'description' => 'Benutzer, die Teil dieses Teams sind',
    ),
    'owner' => 
    array (
      'label' => 'Besitzer',
      'description' => 'Benutzer, der dieses Team erstellt hat',
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
);

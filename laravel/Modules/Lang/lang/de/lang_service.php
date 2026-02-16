<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'language' => 
    array (
      'label' => 'Sprache',
      'placeholder' => 'Sprache auswählen',
      'helper_text' => 'Aktuell ausgewählte Benutzersprache',
      'tooltip' => '',
      'description' => '',
    ),
    'available_languages' => 
    array (
      'label' => 'Verfügbare Sprachen',
      'placeholder' => 'Liste verfügbarer Sprachen',
      'helper_text' => 'Für die Benutzeroberfläche verfügbare Sprachen',
      'tooltip' => '',
      'description' => '',
    ),
    'value' => 
    array (
      'label' => 'Wert',
      'placeholder' => 'Wert eingeben',
      'helper_text' => 'Übersetzungswert',
      'tooltip' => '',
      'description' => '',
    ),
    'key' => 
    array (
      'label' => 'Schlüssel',
      'placeholder' => 'Übersetzungsschlüssel eingeben',
      'helper_text' => 'Eindeutige Kennung für die Übersetzung',
      'tooltip' => '',
      'description' => '',
    ),
    'locale' => 
    array (
      'label' => 'Gebietsschema',
      'placeholder' => 'Gebietsschema auswählen',
      'helper_text' => 'Sprachgebietsschema-Code (z.B. it, en, de)',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'change_language' => 
    array (
      'label' => 'Sprache ändern',
      'tooltip' => 'Benutzersprache ändern',
      'success' => 'Sprache erfolgreich geändert',
      'error' => 'Fehler beim Ändern der Sprache',
      'confirmation' => 'Sind Sie sicher, dass Sie die Sprache ändern möchten?',
    ),
    'cancel' => 
    array (
      'label' => 'Abbrechen',
      'tooltip' => 'Aktuelle Operation abbrechen',
    ),
    'save' => 
    array (
      'label' => 'Speichern',
      'tooltip' => 'Änderungen speichern',
      'success' => 'Änderungen erfolgreich gespeichert',
      'error' => 'Fehler beim Speichern',
    ),
    'create' => 
    array (
      'label' => 'Übersetzung erstellen',
      'tooltip' => 'Neue Übersetzung erstellen',
      'success' => 'Übersetzung erfolgreich erstellt',
      'error' => 'Fehler beim Erstellen der Übersetzung',
    ),
    'edit' => 
    array (
      'label' => 'Bearbeiten',
      'tooltip' => 'Ausgewählte Übersetzung bearbeiten',
      'success' => 'Übersetzung erfolgreich aktualisiert',
      'error' => 'Fehler beim Aktualisieren der Übersetzung',
    ),
    'delete' => 
    array (
      'label' => 'Löschen',
      'tooltip' => 'Ausgewählte Übersetzung löschen',
      'success' => 'Übersetzung erfolgreich gelöscht',
      'error' => 'Fehler beim Löschen der Übersetzung',
      'confirmation' => 'Sind Sie sicher, dass Sie diese Übersetzung löschen möchten?',
    ),
  ),
  'messages' => 
  array (
    'language_changed' => 'Sprache erfolgreich geändert',
    'error' => 'Ein Fehler ist beim Ändern der Sprache aufgetreten',
    'no_translations' => 'Keine Übersetzungen gefunden',
    'loading' => 'Übersetzungen werden geladen...',
    'empty_state' => 'Keine Übersetzungen verfügbar',
    'search_placeholder' => 'Übersetzungen suchen...',
  ),
  'validation' => 
  array (
    'language_required' => 'Sprache ist erforderlich',
    'language_valid' => 'Die ausgewählte Sprache ist nicht gültig',
    'key_required' => 'Übersetzungsschlüssel ist erforderlich',
    'key_unique' => 'Dieser Übersetzungsschlüssel existiert bereits',
    'value_required' => 'Übersetzungswert ist erforderlich',
    'locale_required' => 'Gebietsschema ist erforderlich',
    'locale_valid' => 'Gebietsschema-Format ist nicht gültig',
  ),
  'navigation' => 
  array (
    'label' => 'Sprachdienst',
    'group' => 'Lokalisierung',
    'icon' => 'heroicon-o-language',
  ),
  'page' => 
  array (
    'title' => 'Übersetzungsverwaltung',
    'heading' => 'Sprachdienst',
    'description' => 'Verwalten Sie Übersetzungen und verfügbare Sprachen im System',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

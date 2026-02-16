<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Permesso Team',
    'plural' => 'Permessi Team',
    'label' => 'Permessi Team',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione permessi specifici per team',
    ),
    'sort' => 15,
    'icon' => 'heroicon-o-shield-check',
  ),
  'fields' => 
  array (
    'team_id' => 
    array (
      'label' => 'Team',
      'placeholder' => 'Seleziona un team',
      'help' => 'Il team a cui appartiene questo permesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_id' => 
    array (
      'label' => 'Utente',
      'placeholder' => 'Seleziona un utente',
      'help' => 'L\'utente a cui è assegnato questo permesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'permission' => 
    array (
      'label' => 'Permesso',
      'placeholder' => 'Inserisci il nome del permesso',
      'help' => 'Il nome del permesso (es. view-reports, edit-documents]',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'id' => 
    array (
      'label' => 'ID',
      'help' => 'Identificativo univoco del permesso team',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'help' => 'Data e ora di creazione del permesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Data Aggiornamento',
      'help' => 'Data e ora dell\'ultimo aggiornamento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Permesso Team',
      'success' => 'Permesso team creato con successo',
      'error' => 'Errore durante la creazione del permesso team',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Permesso Team',
      'success' => 'Permesso team aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento del permesso team',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Permesso Team',
      'success' => 'Permesso team eliminato con successo',
      'error' => 'Errore durante l\'eliminazione del permesso team',
      'confirmation' => 'Sei sicuro di voler eliminare questo permesso team?',
    ),
  ),
  'label' => 'Team Permission',
  'plural_label' => 'Team Permission (Plurale)',
);

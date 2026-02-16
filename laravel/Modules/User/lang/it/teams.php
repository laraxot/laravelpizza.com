<?php

declare(strict_types=1);

return array (
  'name' => 'Teams',
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome del team',
      'helper_text' => 'Nome identificativo del team',
      'description' => 'Il nome che identifica questo team',
      'tooltip' => '',
    ),
    'personal_team' => 
    array (
      'label' => 'Team Personale',
      'helper_text' => 'Indica se questo è un team personale',
      'description' => 'Un team personale è associato a un singolo utente',
      'tooltip' => '',
    ),
    'owner' => 
    array (
      'label' => 'Proprietario',
      'helper_text' => 'Utente proprietario del team',
      'description' => 'L\'utente che ha creato e gestisce questo team',
      'tooltip' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'helper_text' => 'Data di creazione del team',
      'description' => 'Data e ora in cui è stato creato il team',
      'tooltip' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'helper_text' => 'Data dell\'ultima modifica',
      'description' => 'Data e ora dell\'ultima modifica al team',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Team',
      'tooltip' => 'Crea un nuovo team',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica i dati del team',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina il team',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli del team',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Team creato con successo',
      'updated' => 'Team aggiornato con successo',
      'deleted' => 'Team eliminato con successo',
    ),
    'error' => 
    array (
      'create' => 'Errore durante la creazione del team',
      'update' => 'Errore durante l\'aggiornamento del team',
      'delete' => 'Errore durante l\'eliminazione del team',
    ),
    'confirm' => 
    array (
      'delete' => 'Sei sicuro di voler eliminare questo team?',
    ),
  ),
  'relationships' => 
  array (
    'members' => 
    array (
      'label' => 'Membri',
      'description' => 'Utenti che fanno parte di questo team',
    ),
    'owner' => 
    array (
      'label' => 'Proprietario',
      'description' => 'Utente che ha creato questo team',
    ),
  ),
  'navigation' => 
  array (
    'name' => 'Teams',
    'plural' => 'Teams',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Teams',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'label' => 'Teams',
  'plural_label' => 'Teams (Plurale)',
);

<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Contatti',
    'group' => 'Gestione Contenuti',
    'icon' => 'heroicon-o-phone',
    'color' => 'primary',
    'sort' => '10',
  ),
  'model' => 
  array (
    'label' => 'Contatto',
    'plural' => 'Contatti',
    'description' => 'Gestione informazioni di contatto dello studio',
  ),
  'fields' => 
  array (
    'title' => 
    array (
      'label' => 'Titolo Contatto',
      'placeholder' => 'Inserisci il titolo (es. Studio Dentistico)',
      'help' => 'Nome o titolo principale per identificare il contatto',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Descrivi brevemente l\'attività dello studio',
      'help' => 'Breve descrizione delle attività e servizi offerti',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email di Contatto',
      'placeholder' => 'inserisci@email.it',
      'help' => 'Indirizzo email principale per le comunicazioni',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'phone' => 
    array (
      'label' => 'Numero di Telefono',
      'placeholder' => '+39 06 1234567',
      'help' => 'Numero di telefono principale dello studio',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo Completo',
      'placeholder' => 'Via Roma, 123 - 00100 Roma',
      'help' => 'Indirizzo fisico completo dello studio',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'map_url' => 
    array (
      'label' => 'Link Mappa',
      'placeholder' => 'https://maps.google.com/...',
      'help' => 'URL per aprire la posizione su Google Maps o servizi simili',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Contatto',
      'modal_heading' => 'Aggiungi nuovo contatto',
      'modal_description' => 'Inserisci le informazioni di contatto',
      'success' => 'Contatto creato con successo',
      'error' => 'Errore durante la creazione del contatto',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'modal_heading' => 'Modifica contatto',
      'modal_description' => 'Aggiorna le informazioni di contatto',
      'success' => 'Contatto aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'modal_heading' => 'Elimina contatto',
      'modal_description' => 'Sei sicuro di voler eliminare questo contatto?',
      'success' => 'Contatto eliminato con successo',
      'error' => 'Errore durante l\'eliminazione',
      'confirmation' => 'Questa azione è irreversibile',
    ),
  ),
  'messages' => 
  array (
    'empty_state' => 'Nessun contatto configurato',
    'loading' => 'Caricamento contatti in corso...',
    'saved' => 'Modifiche salvate correttamente',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

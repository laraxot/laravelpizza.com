<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Client OAuth',
    'plural_label' => 'Client OAuth',
    'group' => 'OAuth',
    'icon' => 'heroicon-o-key',
    'sort' => 89,
  ),
  'label' => 'Client OAuth',
  'plural_label' => 'Client OAuth',
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del client',
      'placeholder' => 'Inserisci il nome',
      'helper_text' => 'Nome identificativo del client',
      'description' => 'Nome del client OAuth',
    ),
    'redirect' => 
    array (
      'label' => 'Redirect URI',
      'tooltip' => 'URI di redirect',
      'placeholder' => 'https://esempio.it/callback',
      'helper_text' => 'URI dove sarà reindirizzato dopo l\'autenticazione',
      'description' => 'URI di redirect per OAuth',
    ),
    'secret' => 
    array (
      'label' => 'Secret',
      'tooltip' => 'Secret del client',
      'placeholder' => 'Inserisci il secret',
      'helper_text' => 'Secret per l\'autenticazione',
      'description' => 'Secret del client',
    ),
    'password_client' => 
    array (
      'label' => 'Client Password',
      'tooltip' => 'Tipo client password',
      'helper_text' => 'Indica se è un client di tipo password',
      'description' => 'Flag per client di tipo password',
    ),
    'redirect_callback' => 
    array (
      'label' => 'Redirect Callback',
      'tooltip' => 'URI di callback',
      'placeholder' => 'https://esempio.it/callback',
      'helper_text' => 'URI per il callback',
      'description' => 'URI di callback',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Client',
      'tooltip' => 'Crea un nuovo client',
      'helper_text' => 'Crea un nuovo client OAuth',
      'description' => 'Azione per creare',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Client',
      'tooltip' => 'Modifica il client',
      'helper_text' => 'Modifica il client esistente',
      'description' => 'Azione per modificare',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Client',
      'tooltip' => 'Elimina il client',
      'helper_text' => 'Elimina il client',
      'description' => 'Azione per eliminare',
    ),
    'logout' => 
    array (
      'label' => 'Logout',
      'tooltip' => 'Disconnettiti',
      'helper_text' => 'Esci dall\'account',
      'description' => 'Azione di logout',
      'icon' => 'heroicon-o-arrow-right-on-rectangle',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Client creato con successo',
    'updated' => 'Client aggiornato con successo',
    'deleted' => 'Client eliminato con successo',
  ),
);

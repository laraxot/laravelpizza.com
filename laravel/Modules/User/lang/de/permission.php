<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Permessi',
    'plural' => 'Permessi',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione dei permessi di sistema',
    ),
    'label' => 'Permessi',
    'sort' => '44',
    'icon' => 'user-permission-animated',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome Permesso',
      'tooltip' => 'Inserisci il nome del permesso, ad esempio \\"Accesso Admin\\".',
      'placeholder' => 'Nome del permesso',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Specifica la guardia associata al permesso.',
      'placeholder' => 'Nome della guardia, es. \\"web\\"',
      'helper_text' => '',
      'description' => '',
    ),
    'roles' => 
    array (
      'label' => 'Ruoli',
      'tooltip' => 'Seleziona i ruoli a cui assegnare il permesso.',
      'placeholder' => 'Seleziona uno o più ruoli',
      'helper_text' => '',
      'description' => '',
    ),
    'users' => 
    array (
      'label' => 'Utenti',
      'tooltip' => 'Seleziona gli utenti a cui assegnare il permesso.',
      'placeholder' => 'Seleziona uno o più utenti',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => 'La data in cui il permesso è stato creato.',
      'placeholder' => 'Data di creazione',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => 'La data dell\'ultima modifica al permesso.',
      'placeholder' => 'Ultima modifica',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Fornisci una breve descrizione del permesso.',
      'placeholder' => 'Descrizione del permesso',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Permesso',
      'tooltip' => 'Clicca per creare un nuovo permesso nel sistema.',
      'icon' => 'fa fa-plus',
      'color' => 'success',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Permesso',
      'tooltip' => 'Clicca per modificare un permesso esistente.',
      'icon' => 'fa fa-edit',
      'color' => 'primary',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Permesso',
      'tooltip' => 'Clicca per eliminare un permesso esistente.',
      'icon' => 'fa fa-trash',
      'color' => 'danger',
    ),
    'assign_to_role' => 
    array (
      'label' => 'Assegna a Ruolo',
      'tooltip' => 'Clicca per assegnare questo permesso a un ruolo.',
      'icon' => 'fa fa-users',
      'color' => 'info',
    ),
    'remove_from_role' => 
    array (
      'label' => 'Rimuovi da Ruolo',
      'tooltip' => 'Clicca per rimuovere questo permesso da un ruolo.',
      'icon' => 'fa fa-user-times',
      'color' => 'warning',
    ),
    'assign_to_user' => 
    array (
      'label' => 'Assegna a Utente',
      'tooltip' => 'Clicca per assegnare questo permesso a un utente.',
      'icon' => 'fa fa-user-plus',
      'color' => 'info',
    ),
    'remove_from_user' => 
    array (
      'label' => 'Rimuovi da Utente',
      'tooltip' => 'Clicca per rimuovere questo permesso da un utente.',
      'icon' => 'fa fa-user-minus',
      'color' => 'warning',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Permesso creato con successo',
    'updated' => 'Permesso aggiornato con successo',
    'deleted' => 'Permesso eliminato con successo',
    'assigned_to_role' => 'Permesso assegnato al ruolo con successo',
    'removed_from_role' => 'Permesso rimosso dal ruolo con successo',
    'assigned_to_user' => 'Permesso assegnato all\'utente con successo',
    'removed_from_user' => 'Permesso rimosso dall\'utente con successo',
    'in_use' => 'Non puoi eliminare un permesso in uso',
  ),
  'groups' => 
  array (
    'user_management' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Permessi relativi alla gestione degli utenti',
    ),
    'role_management' => 
    array (
      'name' => 'Gestione Ruoli',
      'description' => 'Permessi relativi alla gestione dei ruoli',
    ),
    'content_management' => 
    array (
      'name' => 'Gestione Contenuti',
      'description' => 'Permessi relativi alla gestione dei contenuti',
    ),
    'system_settings' => 
    array (
      'name' => 'Impostazioni Sistema',
      'description' => 'Permessi relativi alle impostazioni di sistema',
    ),
  ),
  'levels' => 
  array (
    'view' => 'Visualizza',
    'create' => 'Crea',
    'edit' => 'Modifica',
    'delete' => 'Elimina',
    'manage' => 'Gestisci',
    'full' => 'Accesso Completo',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

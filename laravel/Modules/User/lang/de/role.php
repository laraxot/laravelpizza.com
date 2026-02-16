<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Ruoli',
    'plural' => 'Ruoli',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione dei ruoli e dei permessi associati',
    ),
    'label' => 'Ruoli',
    'sort' => '26',
    'icon' => 'user-role-animated',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome Ruolo',
      'tooltip' => 'Il nome identificativo del ruolo, es. \\"Admin\\".',
      'placeholder' => 'Nome del ruolo',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Il nome della guardia per questo ruolo, es. \\"web\\".',
      'placeholder' => 'Nome della guardia',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => 'Seleziona i permessi associati a questo ruolo.',
      'placeholder' => 'Seleziona permessi',
      'helper_text' => '',
      'description' => '',
    ),
    'users_count' => 
    array (
      'label' => 'Numero Utenti',
      'tooltip' => 'Il numero di utenti assegnati a questo ruolo.',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => 'La data in cui il ruolo è stato creato.',
      'placeholder' => 'Data di creazione',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => 'La data dell\'ultima modifica del ruolo.',
      'placeholder' => 'Ultima modifica',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Una descrizione del ruolo e delle sue funzioni.',
      'placeholder' => 'Descrizione del ruolo',
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
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'team_id' => 
    array (
      'description' => 'team_id',
      'helper_text' => 'team_id',
      'placeholder' => 'team_id',
      'label' => 'team_id',
      'tooltip' => '',
    ),
    'detach' => 
    array (
      'label' => 'detach',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'edit' => 
    array (
      'label' => 'edit',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'attach' => 
    array (
      'label' => 'attach',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'recordId' => 
    array (
      'description' => 'recordId',
      'helper_text' => 'recordId',
      'placeholder' => 'recordId',
      'label' => 'recordId',
      'tooltip' => '',
    ),
    'id' => 
    array (
      'label' => 'id',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'roles' => 
  array (
    'super_admin' => 'Super Amministratore',
    'admin' => 'Amministratore',
    'manager' => 'Manager',
    'editor' => 'Editor',
    'user' => 'Utente',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Ruolo',
      'tooltip' => 'Clicca per creare un nuovo ruolo nel sistema.',
      'icon' => 'fa fa-plus',
      'color' => 'success',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Ruolo',
      'tooltip' => 'Clicca per modificare il ruolo selezionato.',
      'icon' => 'fa fa-edit',
      'color' => 'primary',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Ruolo',
      'tooltip' => 'Clicca per eliminare questo ruolo.',
      'icon' => 'fa fa-trash',
      'color' => 'danger',
    ),
    'assign_permissions' => 
    array (
      'label' => 'Assegna Permessi',
      'tooltip' => 'Clicca per assegnare permessi al ruolo.',
      'icon' => 'fa fa-check',
      'color' => 'info',
    ),
    'sync_permissions' => 
    array (
      'label' => 'Sincronizza Permessi',
      'tooltip' => 'Clicca per sincronizzare i permessi con quelli di un altro sistema.',
      'icon' => 'fa fa-sync',
      'color' => 'warning',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Ruolo creato con successo',
    'updated' => 'Ruolo aggiornato con successo',
    'deleted' => 'Ruolo eliminato con successo',
    'permissions_updated' => 'Permessi aggiornati con successo',
    'cannot_delete_super_admin' => 'Non puoi eliminare il ruolo di Super Amministratore',
    'role_in_use' => 'Non puoi eliminare un ruolo assegnato a degli utenti',
  ),
  'descriptions' => 
  array (
    'super_admin' => 'Accesso completo a tutte le funzionalità del sistema.',
    'admin' => 'Accesso alla maggior parte delle funzionalità amministrative.',
    'manager' => 'Gestione di utenti e contenuti specifici.',
    'editor' => 'Modifica e gestione dei contenuti.',
    'user' => 'Accesso base alle funzionalità del sistema.',
  ),
  'permissions_groups' => 
  array (
    'users' => 'Gestione Utenti',
    'roles' => 'Gestione Ruoli',
    'content' => 'Gestione Contenuti',
    'settings' => 'Impostazioni',
    'reports' => 'Report',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

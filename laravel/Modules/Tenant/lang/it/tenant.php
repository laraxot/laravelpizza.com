<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Tenant',
    'group' => 'Sistema',
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
        'name' => 'Edifici',
        'group' => 'Tenant',
        'sort' => 10,
        'icon' => 'tenant-building-animated',
        'badge' => 
        array (
          'color' => 'info',
          'label' => 'Gestione',
        ),
      ),
      'fields' => 
      array (
        'name' => 'Nome',
        'address' => 'Indirizzo',
        'units' => 'Unità',
        'manager' => 'Amministratore',
        'status' => 'Stato',
        'notes' => 'Note',
      ),
    ),
    'unit' => 
    array (
      'navigation' => 
      array (
        'name' => 'Unità Immobiliari',
        'group' => 'Tenant',
        'sort' => 20,
        'icon' => 'tenant-unit-icon',
        'badge' => 
        array (
          'color' => 'warning',
          'label' => 'Occupazione',
        ),
      ),
      'fields' => 
      array (
        'number' => 'Numero',
        'floor' => 'Piano',
        'type' => 'Tipologia',
        'size' => 'Metratura',
        'tenant' => 'Inquilino',
        'rent' => 'Canone',
        'status' => 'Stato',
      ),
      'types' => 
      array (
        'apartment' => 'Appartamento',
        'office' => 'Ufficio',
        'store' => 'Negozio',
        'warehouse' => 'Magazzino',
      ),
    ),
    'tenant' => 
    array (
      'navigation' => 
      array (
        'name' => 'Inquilini',
        'group' => 'Tenant',
        'sort' => 30,
        'icon' => 'tenant-person-icon',
        'badge' => 
        array (
          'color' => 'primary',
          'label' => 'Contratti',
        ),
      ),
      'fields' => 
      array (
        'name' => 'Nome',
        'last_name' => 'Cognome',
        'tax_code' => 'Codice Fiscale',
        'email' => 'Email',
        'phone' => 'Telefono',
        'contract_start' => 'Inizio Contratto',
        'contract_end' => 'Fine Contratto',
        'deposit' => 'Deposito Cauzionale',
      ),
    ),
  ),
  'common' => 
  array (
    'status' => 
    array (
      'active' => 'Attivo',
      'inactive' => 'Inattivo',
      'maintenance' => 'In Manutenzione',
      'reserved' => 'Riservato',
    ),
    'actions' => 
    array (
      'create' => 'Crea',
      'edit' => 'Modifica',
      'delete' => 'Elimina',
      'view' => 'Visualizza',
      'assign' => 'Assegna',
      'unassign' => 'Rimuovi Assegnazione',
      'renew' => 'Rinnova',
      'terminate' => 'Termina',
    ),
    'messages' => 
    array (
      'success' => 
      array (
        'created' => 'Creato con successo',
        'updated' => 'Aggiornato con successo',
        'deleted' => 'Eliminato con successo',
        'assigned' => 'Assegnato con successo',
        'unassigned' => 'Assegnazione rimossa con successo',
      ),
      'error' => 
      array (
        'create' => 'Errore durante la creazione',
        'update' => 'Errore durante l\'aggiornamento',
        'delete' => 'Errore durante l\'eliminazione',
        'assign' => 'Errore durante l\'assegnazione',
        'unassign' => 'Errore durante la rimozione dell\'assegnazione',
      ),
      'confirm' => 
      array (
        'delete' => 'Sei sicuro di voler eliminare questo elemento?',
        'terminate' => 'Sei sicuro di voler terminare questo contratto?',
      ),
    ),
    'filters' => 
    array (
      'status' => 'Stato',
      'type' => 'Tipo',
      'floor' => 'Piano',
      'date_range' => 'Periodo',
      'occupation' => 'Occupazione',
    ),
  ),
  'label' => 'Tenant',
  'plural_label' => 'Tenant (Plurale)',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Tenant',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Tenant',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Tenant',
    ),
  ),
);

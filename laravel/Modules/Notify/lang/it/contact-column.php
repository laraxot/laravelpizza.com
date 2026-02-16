<?php

declare(strict_types=1);

return array (
  'label' => 'Contatti',
  'no_contacts' => 'Nessun contatto disponibile',
  'tooltip' => 
  array (
    'phone' => 'Clicca per chiamare',
    'mobile' => 'Clicca per chiamare',
    'email' => 'Clicca per inviare email',
    'pec' => 'Clicca per inviare PEC',
    'whatsapp' => 'Clicca per aprire WhatsApp',
    'fax' => 'Numero fax',
  ),
  'aria_labels' => 
  array (
    'contact_list' => 'Lista contatti',
    'contact_link' => 'Collegamento contatto',
    'no_contacts' => 'Nessun contatto disponibile',
  ),
  'plural_label' => 'Contact Column (Plurale)',
  'navigation' => 
  array (
    'name' => 'Contact Column',
    'plural' => 'Contact Column',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Contact Column',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
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
      'label' => 'Crea Contact Column',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Contact Column',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Contact Column',
    ),
  ),
);

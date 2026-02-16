<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome del template',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'code' => 
    array (
      'label' => 'Codice',
      'placeholder' => 'Inserisci il codice univoco del template',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci una descrizione del template',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => 'Oggetto',
      'placeholder' => 'Inserisci l\'oggetto dell\'email',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'body_html' => 
    array (
      'label' => 'Corpo HTML',
      'placeholder' => 'Inserisci il contenuto HTML dell\'email',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'body_text' => 
    array (
      'label' => 'Corpo Testo',
      'placeholder' => 'Inserisci il contenuto testuale dell\'email',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'channels' => 
    array (
      'label' => 'Canali',
      'placeholder' => 'Seleziona i canali di invio',
      'options' => 
      array (
        'email' => 
        array (
          'label' => 'Email',
          'tooltip' => 'Invia notifica via email',
        ),
        'sms' => 
        array (
          'label' => 'SMS',
          'tooltip' => 'Invia notifica via SMS',
        ),
        'push' => 
        array (
          'label' => 'Push',
          'tooltip' => 'Invia notifica push',
        ),
        'whatsapp' => 
        array (
          'label' => 'WhatsApp',
          'tooltip' => 'Invia notifica via WhatsApp',
        ),
        'telegram' => 
        array (
          'label' => 'Telegram',
          'tooltip' => 'Invia notifica via Telegram',
        ),
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'variables' => 
    array (
      'label' => 'Variabili',
      'placeholder' => 'Definisci le variabili disponibili nel template',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'conditions' => 
    array (
      'label' => 'Condizioni',
      'placeholder' => 'Definisci le condizioni di invio',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'preview_data' => 
    array (
      'label' => 'Dati Anteprima',
      'placeholder' => 'Inserisci i dati per l\'anteprima',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'metadata' => 
    array (
      'label' => 'Metadati',
      'placeholder' => 'Inserisci metadati aggiuntivi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'category' => 
    array (
      'label' => 'Categoria',
      'placeholder' => 'Seleziona la categoria del template',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'tooltip' => 'Indica se il template è attivo',
      'helper_text' => '',
      'description' => '',
    ),
    'version' => 
    array (
      'label' => 'Versione',
      'tooltip' => 'Versione corrente del template',
      'helper_text' => '',
      'description' => '',
    ),
    'tenant_id' => 
    array (
      'label' => 'Tenant',
      'tooltip' => 'Tenant associato al template',
      'helper_text' => '',
      'description' => '',
    ),
    'grapesjs_data' => 
    array (
      'label' => 'Dati GrapesJS',
      'tooltip' => 'Dati dell\'editor GrapesJS',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Template',
      'icon' => 'heroicon-o-plus',
      'color' => 'primary',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Template',
      'icon' => 'heroicon-o-pencil',
      'color' => 'warning',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Template',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
    ),
    'preview' => 
    array (
      'label' => 'Anteprima',
      'icon' => 'heroicon-o-eye',
      'color' => 'info',
    ),
    'duplicate' => 
    array (
      'label' => 'Duplica',
      'icon' => 'heroicon-o-document-duplicate',
      'color' => 'success',
    ),
    'version' => 
    array (
      'label' => 'Nuova Versione',
      'icon' => 'heroicon-o-document-text',
      'color' => 'primary',
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

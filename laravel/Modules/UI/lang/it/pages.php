<?php

declare(strict_types=1);

return array (
  's3test' => 
  array (
    'heading' => 'Test',
    'description' => 'Pagina di test ',
    'info' => 
    array (
      'title' => 'Informazioni Test',
      'description' => 'Questa pagina permette di testare l\'invio di email tramite il sistema S3. Inserisci i dati richiesti e clicca su "Invia Email" per procedere con il test.',
    ),
    'fields' => 
    array (
      'to' => 
      array (
        'label' => 'Destinatario',
        'placeholder' => 'Inserisci l\'indirizzo email del destinatario',
        'helper_text' => 'L\'email verrà inviata a questo indirizzo',
        'description' => 'Indirizzo email del destinatario',
      ),
      'subject' => 
      array (
        'label' => 'Oggetto',
        'placeholder' => 'Inserisci l\'oggetto dell\'email',
        'helper_text' => 'L\'oggetto apparirà nella casella di posta del destinatario',
        'description' => 'Oggetto dell\'email',
      ),
      'body_html' => 
      array (
        'label' => 'Contenuto',
        'placeholder' => 'Inserisci il contenuto dell\'email',
        'helper_text' => 'Il contenuto può includere formattazione HTML',
        'description' => 'Contenuto dell\'email',
      ),
    ),
    'actions' => 
    array (
      'send_email' => 
      array (
        'label' => 'Invia Email',
        'success' => 'Email inviata con successo',
        'error' => 'Errore durante l\'invio dell\'email',
      ),
      'sendEmail' => 
      array (
        'label' => 'Invia Email',
        'success' => 'Email inviata con successo',
        'error' => 'Errore durante l\'invio dell\'email',
      ),
    ),
    'notifications' => 
    array (
      'check_email_client' => 'Controlla il tuo client email',
      'email_sent_success' => 'Email inviata con successo',
      'email_sent_error' => 'Errore durante l\'invio dell\'email',
    ),
  ),
  'label' => 'Pages',
  'plural_label' => 'Pages (Plurale)',
  'navigation' => 
  array (
    'name' => 'Pages',
    'plural' => 'Pages',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Pages',
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
      'label' => 'Crea Pages',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Pages',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Pages',
    ),
  ),
);

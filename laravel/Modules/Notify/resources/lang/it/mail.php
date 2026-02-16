<?php

declare(strict_types=1);

return array (
  'template' => 
  array (
    'navigation' => 
    array (
      'label' => 'Template Email',
      'plural' => 'Template Email',
      'singular' => 'Template Email',
      'group' => 'Notifiche',
      'icon' => 'heroicon-o-envelope',
    ),
    'fields' => 
    array (
      'name' => 
      array (
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome del template',
        'tooltip' => 'Nome identificativo del template',
      ),
      'code' => 
      array (
        'label' => 'Codice',
        'placeholder' => 'Inserisci il codice del template',
        'tooltip' => 'Codice univoco del template',
      ),
      'description' => 
      array (
        'label' => 'Descrizione',
        'placeholder' => 'Inserisci una descrizione',
        'tooltip' => 'Descrizione dettagliata del template',
      ),
      'subject' => 
      array (
        'label' => 'Oggetto',
        'placeholder' => 'Inserisci l\'oggetto dell\'email',
        'tooltip' => 'Oggetto dell\'email',
      ),
      'body_html' => 
      array (
        'label' => 'Corpo HTML',
        'placeholder' => 'Inserisci il contenuto HTML',
        'tooltip' => 'Contenuto HTML dell\'email',
      ),
      'body_text' => 
      array (
        'label' => 'Corpo Testo',
        'placeholder' => 'Inserisci il contenuto testuale',
        'tooltip' => 'Contenuto testuale dell\'email',
      ),
      'channels' => 
      array (
        'label' => 'Canali',
        'placeholder' => 'Seleziona i canali',
        'tooltip' => 'Canali di invio disponibili',
        'options' => 
        array (
          'email' => 
          array (
            'label' => 'Email',
          ),
          'sms' => 
          array (
            'label' => 'SMS',
          ),
          'push' => 
          array (
            'label' => 'Push Notification',
          ),
          'whatsapp' => 
          array (
            'label' => 'WhatsApp',
          ),
          'telegram' => 
          array (
            'label' => 'Telegram',
          ),
        ),
      ),
      'variables' => 
      array (
        'label' => 'Variabili',
        'placeholder' => 'Aggiungi variabili',
        'tooltip' => 'Variabili disponibili nel template',
      ),
      'conditions' => 
      array (
        'label' => 'Condizioni',
        'placeholder' => 'Aggiungi condizioni',
        'tooltip' => 'Condizioni di invio',
      ),
      'preview_data' => 
      array (
        'label' => 'Dati Anteprima',
        'placeholder' => 'Aggiungi dati per l\'anteprima',
        'tooltip' => 'Dati per testare il template',
      ),
      'category' => 
      array (
        'label' => 'Categoria',
        'placeholder' => 'Inserisci la categoria',
        'tooltip' => 'Categoria del template',
      ),
      'is_active' => 
      array (
        'label' => 'Attivo',
        'tooltip' => 'Stato di attivazione del template',
      ),
    ),
    'filters' => 
    array (
      'category' => 
      array (
        'label' => 'Categoria',
        'options' => 
        array (
          'welcome' => 
          array (
            'label' => 'Benvenuto',
          ),
          'reminder' => 
          array (
            'label' => 'Promemoria',
          ),
          'notification' => 
          array (
            'label' => 'Notifica',
          ),
        ),
      ),
      'is_active' => 
      array (
        'label' => 'Stato',
        'options' => 
        array (
          'active' => 
          array (
            'label' => 'Attivo',
          ),
          'inactive' => 
          array (
            'label' => 'Inattivo',
          ),
        ),
      ),
    ),
    'actions' => 
    array (
      'edit' => 
      array (
        'label' => 'Modifica',
        'icon' => 'heroicon-o-pencil',
        'color' => 'primary',
      ),
      'delete' => 
      array (
        'label' => 'Elimina',
        'icon' => 'heroicon-o-trash',
        'color' => 'danger',
      ),
      'preview' => 
      array (
        'label' => 'Anteprima',
        'icon' => 'heroicon-o-eye',
        'color' => 'success',
      ),
    ),
    'preview' => 
    array (
      'title' => 'Anteprima Template',
      'subject' => 'Oggetto',
      'body_html' => 'Contenuto HTML',
      'body_text' => 'Contenuto Testuale',
      'variables' => 'Variabili',
      'actions' => 
      array (
        'back' => 
        array (
          'label' => 'Torna indietro',
          'icon' => 'heroicon-o-arrow-left',
          'color' => 'secondary',
        ),
      ),
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
  'fields' => 
  array (
  ),
  'actions' => 
  array (
  ),
);

<?php

declare(strict_types=1);

return array (
  'template' => 
  array (
    'navigation' => 
    array (
      'group' => 'Notifiche',
      'label' => 'Template Email',
      'plural' => 'Template Email',
      'singular' => 'Template Email',
      'icon' => 'heroicon-o-envelope',
      'sort' => '1',
    ),
    'sections' => 
    array (
      'main' => 'Informazioni Principali',
    ),
    'fields' => 
    array (
      'name' => 
      array (
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome del template',
        'tooltip' => 'Il nome identificativo del template email',
      ),
      'layout' => 
      array (
        'label' => 'Layout',
        'placeholder' => 'Seleziona il layout del template',
        'tooltip' => 'Il layout grafico che verrà utilizzato per l\'email',
      ),
      'mailable' => 
      array (
        'label' => 'Classe Mailable',
        'placeholder' => 'Inserisci il nome della classe Mailable',
        'tooltip' => 'La classe PHP che gestisce l\'invio dell\'email',
      ),
      'subject' => 
      array (
        'label' => 'Oggetto',
        'placeholder' => 'Inserisci l\'oggetto dell\'email',
        'tooltip' => 'L\'oggetto che apparirà nell\'email',
      ),
      'body_html' => 
      array (
        'label' => 'Contenuto HTML',
        'placeholder' => 'Inserisci il contenuto HTML dell\'email',
        'tooltip' => 'Il contenuto dell\'email in formato HTML',
      ),
      'body_text' => 
      array (
        'label' => 'Contenuto Testo',
        'placeholder' => 'Inserisci il contenuto testuale dell\'email',
        'tooltip' => 'Versione testuale dell\'email per client che non supportano HTML',
      ),
    ),
    'actions' => 
    array (
      'preview' => 
      array (
        'label' => 'Anteprima',
        'tooltip' => 'Visualizza un\'anteprima del template',
      ),
    ),
    'messages' => 
    array (
      'created' => 'Template email creato con successo',
      'updated' => 'Template email aggiornato con successo',
      'deleted' => 'Template email eliminato con successo',
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

<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'recipient' => 
    array (
      'label' => 'Destinatario',
      'helper_text' => 'Inserisci il numero di telefono nel formato internazionale (es. +393401234567).',
      'tooltip' => '',
      'description' => '',
    ),
    'to' => 
    array (
      'label' => 'Destinatario',
      'helper_text' => 'Inserisci il numero di telefono nel formato internazionale (es. +393401234567).',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'helper_text' => 'Inserisci il contenuto del messaggio (max 160 caratteri per un singolo SMS).',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Driver SMS',
      'helper_text' => 'Seleziona il provider per l\'invio dell\'SMS.',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 'Invia SMS',
  ),
  'notifications' => 
  array (
    'sent' => 
    array (
      'title' => 'SMS Inviato',
      'body' => 'Il messaggio è stato preso in carico dal provider.',
    ),
    'error' => 
    array (
      'title' => 'Errore Invio',
      'body' => 'Si è verificato un errore durante l\'invio dell\'SMS.',
    ),
  ),
  'form' => 
  array (
    'to' => 
    array (
      'label' => 'Destinatario',
      'helper' => 'Numero di telefono con prefisso internazionale.',
    ),
    'from' => 
    array (
      'label' => 'Mittente',
      'helper' => 'Nome o numero del mittente (max 11 caratteri).',
    ),
    'body' => 
    array (
      'label' => 'Testo del Messaggio',
      'helper' => 'Contenuto dell\'SMS da inviare.',
    ),
    'provider' => 
    array (
      'label' => 'Provider',
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

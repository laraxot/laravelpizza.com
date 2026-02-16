<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Invio WhatsApp',
    'plural' => 'Invio WhatsApp',
  ),
  'navigation' => 
  array (
    'name' => 'Invio WhatsApp',
    'plural' => 'Invio WhatsApp',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione dell\'invio di notifiche WhatsApp',
    ),
    'label' => 'Invio WhatsApp',
    'icon' => 'heroicon-o-paper-airplane',
    'sort' => '20',
  ),
  'fields' => 
  array (
    'to' => 
    array (
      'label' => 'Destinatario',
      'placeholder' => 'Inserisci il numero',
      'helper_text' => 'Numero di telefono del destinatario',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Scrivi il messaggio',
      'helper_text' => 'Contenuto del messaggio WhatsApp',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'Invia',
      'tooltip' => 'Invia un messaggio WhatsApp al destinatario',
      'success_message' => 'Messaggio WhatsApp inviato con successo',
      'error_message' => 'Errore nell\'invio del messaggio WhatsApp',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Messaggio WhatsApp inviato con successo',
    'error' => 'Si è verificato un errore durante l\'invio del messaggio WhatsApp',
    'confirmation' => 'Sei sicuro di voler inviare questo messaggio WhatsApp?',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

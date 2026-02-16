<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'SMS senden',
    'group' => 'Test',
  ),
  'fields' => 
  array (
    'to' => 
    array (
      'label' => 'Empfänger',
      'placeholder' => 'Telefonnummer eingeben',
      'helper_text' => 'Telefonnummer mit internationaler Vorwahl eingeben (z.B. +49)',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Nachricht',
      'placeholder' => 'Nachrichtentext eingeben',
      'helper_text' => 'Nachricht darf 160 Zeichen nicht überschreiten',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Anbieter',
      'placeholder' => 'SMS-Anbieter auswählen',
      'helper_text' => 'Wählen Sie den Anbieter für den Versand',
      'options' => 
      array (
        'smsfactor' => 'SMSFactor',
        'twilio' => 'Twilio',
        'nexmo' => 'Nexmo',
        'plivo' => 'Plivo',
        'gammu' => 'Gammu',
        'netfun' => 'Netfun',
      ),
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'SMS senden',
      'tooltip' => 'SMS-Nachricht an den Empfänger senden',
    ),
  ),
  'messages' => 
  array (
    'success' => 'SMS erfolgreich gesendet',
    'error' => 'Fehler beim Senden der SMS: :error',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

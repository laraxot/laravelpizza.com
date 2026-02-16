<?php

declare(strict_types=1);

return array (
  'smsfactor' => 
  array (
    'label' => 'SMSFactor',
    'color' => 'primary',
    'icon' => 'heroicon-o-device-phone-mobile',
    'description' => 'Provider SMS francese con API REST e supporto per messaggi bulk',
  ),
  'twilio' => 
  array (
    'label' => 'Twilio',
    'color' => 'success',
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'description' => 'Piattaforma cloud per comunicazioni con API robuste e documentazione completa',
  ),
  'nexmo' => 
  array (
    'label' => 'Nexmo (Vonage]',
    'color' => 'warning',
    'icon' => 'heroicon-o-globe-alt',
    'description' => 'Provider globale per SMS e comunicazioni con copertura internazionale',
  ),
  'plivo' => 
  array (
    'label' => 'Plivo',
    'color' => 'info',
    'icon' => 'heroicon-o-phone',
    'description' => 'Piattaforma per comunicazioni vocali e SMS con API semplici',
  ),
  'gammu' => 
  array (
    'label' => 'Gammu',
    'color' => 'secondary',
    'icon' => 'heroicon-o-cpu-chip',
    'description' => 'Libreria open source per gestione modem GSM e invio SMS',
  ),
  'netfun' => 
  array (
    'label' => 'Netfun',
    'color' => 'danger',
    'icon' => 'heroicon-o-bolt',
    'description' => 'Provider italiano per SMS con supporto per messaggi promozionali e transazionali',
  ),
  'agiletelecom' => 
  array (
    'label' => 'Agile Telecom',
    'color' => 'gray',
    'icon' => 'heroicon-o-truck',
    'description' => 'Provider italiano per servizi di telecomunicazioni e SMS',
  ),
  'label' => 'Sms Driver Enum',
  'plural_label' => 'Sms Driver Enum (Plurale)',
  'navigation' => 
  array (
    'name' => 'Sms Driver Enum',
    'plural' => 'Sms Driver Enum',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Sms Driver Enum',
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
      'label' => 'Crea Sms Driver Enum',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Sms Driver Enum',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Sms Driver Enum',
    ),
  ),
);

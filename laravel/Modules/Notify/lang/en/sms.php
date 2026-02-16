<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'SMS',
    'plural' => 'SMS',
  ),
  'navigation' => 
  array (
    'name' => 'Send SMS',
    'plural' => 'Send SMS',
    'group' => 
    array (
      'name' => 'Notifications',
      'description' => 'SMS notification management',
    ),
    'label' => 'Send SMS',
    'icon' => 'heroicon-o-device-phone-mobile',
    'sort' => '10',
  ),
  'fields' => 
  array (
    'to' => 
    array (
      'label' => 'Phone Number',
      'placeholder' => 'Enter phone number',
      'helper_text' => 'Enter phone number with international prefix (e.g. +1)',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Message',
      'placeholder' => 'Enter message',
      'helper_text' => 'Message cannot exceed 160 characters',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'SMS Provider',
      'placeholder' => 'Select SMS provider',
      'helper_text' => 'Select the SMS provider to use',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'drivers' => 
  array (
    'smsfactor' => 'SMSFactor',
    'twilio' => 'Twilio',
    'nexmo' => 'Nexmo',
    'plivo' => 'Plivo',
    'gammu' => 'Gammu',
    'netfun' => 'Netfun',
  ),
  'actions' => 
  array (
    'send' => 'Send SMS',
    'cancel' => 'Cancel',
  ),
  'messages' => 
  array (
    'success' => 'SMS sent successfully',
    'error' => 'An error occurred while sending the SMS',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

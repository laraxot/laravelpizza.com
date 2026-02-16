<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Send SMS',
    'group' => 'Test',
  ),
  'fields' => 
  array (
    'to' => 
    array (
      'label' => 'Recipient',
      'placeholder' => 'Enter phone number',
      'helper_text' => 'Enter phone number with international prefix (e.g. +1)',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Message',
      'placeholder' => 'Enter message text',
      'helper_text' => 'Message cannot exceed 160 characters',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Provider',
      'placeholder' => 'Select SMS provider',
      'helper_text' => 'Select the provider to use for sending',
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
      'label' => 'Send SMS',
      'tooltip' => 'Send an SMS message to the recipient',
    ),
  ),
  'messages' => 
  array (
    'success' => 'SMS sent successfully',
    'error' => 'Error sending SMS: :error',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

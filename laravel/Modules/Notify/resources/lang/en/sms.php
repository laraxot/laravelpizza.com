<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'recipient' => 
    array (
      'label' => 'Recipient',
      'helper_text' => 'Enter the phone number in international format (e.g. +393401234567).',
      'tooltip' => '',
      'description' => '',
    ),
    'to' => 
    array (
      'label' => 'Recipient',
      'helper_text' => 'Enter the phone number in international format (e.g. +393401234567).',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Message',
      'helper_text' => 'Enter the message content (max 160 characters for a single SMS).',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'SMS Driver',
      'helper_text' => 'Select the provider for sending the SMS.',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 'Send SMS',
  ),
  'notifications' => 
  array (
    'sent' => 
    array (
      'title' => 'SMS Sent',
      'body' => 'The message has been accepted by the provider.',
    ),
    'error' => 
    array (
      'title' => 'Sending Error',
      'body' => 'An error occurred while sending the SMS.',
    ),
  ),
  'form' => 
  array (
    'to' => 
    array (
      'label' => 'Recipient',
      'helper' => 'Phone number with international prefix.',
    ),
    'from' => 
    array (
      'label' => 'Sender',
      'helper' => 'Sender name or number (max 11 characters).',
    ),
    'body' => 
    array (
      'label' => 'Message Text',
      'helper' => 'Content of the SMS to send.',
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

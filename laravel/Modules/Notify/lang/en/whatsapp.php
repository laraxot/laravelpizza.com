<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'WhatsApp',
    'plural' => 'WhatsApp',
  ),
  'navigation' => 
  array (
    'name' => 'Send WhatsApp',
    'plural' => 'Send WhatsApp',
    'group' => 
    array (
      'name' => 'Notifications',
      'description' => 'WhatsApp notification management',
    ),
    'label' => 'Send WhatsApp',
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'sort' => '20',
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
      'helper_text' => 'Message cannot exceed 4096 characters',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'WhatsApp Provider',
      'placeholder' => 'Select WhatsApp provider',
      'helper_text' => 'Select the WhatsApp provider to use',
      'tooltip' => '',
      'description' => '',
    ),
    'template' => 
    array (
      'label' => 'Template',
      'placeholder' => 'Enter template name',
      'helper_text' => 'Template name (optional)',
      'tooltip' => '',
      'description' => '',
    ),
    'parameters' => 
    array (
      'label' => 'Parameters',
      'placeholder' => 'Enter parameters',
      'helper_text' => 'Parameters for the template (optional)',
      'tooltip' => '',
      'description' => '',
    ),
    'media_url' => 
    array (
      'label' => 'Media URL',
      'placeholder' => 'Enter media URL',
      'helper_text' => 'Media URL (optional)',
      'tooltip' => '',
      'description' => '',
    ),
    'media_type' => 
    array (
      'label' => 'Media Type',
      'placeholder' => 'Select media type',
      'helper_text' => 'Select the media type',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'drivers' => 
  array (
    'twilio' => 'Twilio',
    'messagebird' => 'MessageBird',
    'vonage' => 'Vonage',
    'infobip' => 'Infobip',
  ),
  'media_types' => 
  array (
    'image' => 'Image',
    'video' => 'Video',
    'document' => 'Document',
    'audio' => 'Audio',
  ),
  'actions' => 
  array (
    'send' => 'Send WhatsApp',
    'cancel' => 'Cancel',
  ),
  'messages' => 
  array (
    'success' => 'WhatsApp sent successfully',
    'error' => 'An error occurred while sending the WhatsApp',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

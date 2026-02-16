<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'icon' => 'heroicon-o-document-text',
    'label' => 'Notification Templates',
    'group' => 'System',
    'sort' => '52',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Name',
      'helper' => 'Unique template name',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => 'Subject',
      'helper' => 'Notification subject',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Type',
      'helper' => 'Notification type',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'body_text' => 
    array (
      'label' => 'Plain Text',
      'helper' => 'Plain text version of the notification',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'body_html' => 
    array (
      'label' => 'HTML',
      'helper' => 'HTML version of the notification',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'preview_data' => 
    array (
      'label' => 'Preview Data',
      'helper' => 'JSON data for preview',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'columns' => 
  array (
    'name' => 'Name',
    'subject' => 'Subject',
    'type' => 'Type',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
  ),
  'actions' => 
  array (
    'preview' => 'Preview',
  ),
  'enums' => 
  array (
    'notification_type' => 
    array (
      'email' => 'Email',
      'sms' => 'SMS',
      'push' => 'Push Notification',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

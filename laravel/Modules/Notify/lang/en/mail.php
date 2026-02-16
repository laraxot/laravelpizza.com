<?php

declare(strict_types=1);

return array (
  'template' => 
  array (
    'navigation' => 
    array (
      'group' => 'Notifications',
      'label' => 'Email Templates',
      'plural' => 'Email Templates',
      'singular' => 'Email Template',
      'icon' => 'heroicon-o-envelope',
      'sort' => '1',
    ),
    'sections' => 
    array (
      'main' => 'Main Information',
    ),
    'fields' => 
    array (
      'name' => 
      array (
        'label' => 'Name',
        'placeholder' => 'Enter template name',
        'tooltip' => 'The identifying name of the email template',
      ),
      'layout' => 
      array (
        'label' => 'Layout',
        'placeholder' => 'Select template layout',
        'tooltip' => 'The graphical layout that will be used for the email',
      ),
      'mailable' => 
      array (
        'label' => 'Mailable Class',
        'placeholder' => 'Enter the Mailable class name',
        'tooltip' => 'The PHP class that handles email sending',
      ),
      'subject' => 
      array (
        'label' => 'Subject',
        'placeholder' => 'Enter the email subject',
        'tooltip' => 'The subject that will appear in the email',
      ),
      'body_html' => 
      array (
        'label' => 'HTML Content',
        'placeholder' => 'Enter the email HTML content',
        'tooltip' => 'The email content in HTML format',
      ),
      'body_text' => 
      array (
        'label' => 'Text Content',
        'placeholder' => 'Enter the email text content',
        'tooltip' => 'Text version of the email for clients that don\'t support HTML',
      ),
    ),
    'actions' => 
    array (
      'preview' => 
      array (
        'label' => 'Preview',
        'tooltip' => 'View a preview of the template',
      ),
    ),
    'messages' => 
    array (
      'created' => 'Email template created successfully',
      'updated' => 'Email template updated successfully',
      'deleted' => 'Email template deleted successfully',
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

<?php

declare(strict_types=1);

return array (
  's3test' => 
  array (
    'heading' => 'S3 Email Test',
    'description' => 'Test page for sending emails via S3',
    'info' => 
    array (
      'title' => 'Test Information',
      'description' => 'This page allows you to test email sending via the S3 system. Enter the required data and click "Send Email" to proceed with the test.',
    ),
    'fields' => 
    array (
      'to' => 
      array (
        'label' => 'Recipient',
        'placeholder' => 'Enter the recipient\'s email address',
        'helper_text' => 'The email will be sent to this address',
        'description' => 'Recipient\'s email address',
      ),
      'subject' => 
      array (
        'label' => 'Subject',
        'placeholder' => 'Enter the email subject',
        'helper_text' => 'The subject will appear in the recipient\'s inbox',
        'description' => 'Email subject',
      ),
      'body_html' => 
      array (
        'label' => 'Content',
        'placeholder' => 'Enter the email content',
        'helper_text' => 'The content can include HTML formatting',
        'description' => 'Email content',
      ),
    ),
    'actions' => 
    array (
      'send_email' => 
      array (
        'label' => 'Send Email',
        'success' => 'Email sent successfully',
        'error' => 'Error sending email',
      ),
      'email_form_actions' => 
      array (
        'label' => 'Send Test Email',
      ),
    ),
    'notifications' => 
    array (
      'check_email_client' => 'Check your email client',
      'email_sent_success' => 'Email sent successfully',
      'email_sent_error' => 'Error sending email',
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

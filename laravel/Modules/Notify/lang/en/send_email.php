<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Send Email',
    'group' => 
    array (
      'label' => 'System',
      'description' => 'Functionality for sending emails through the notification system',
    ),
    'icon' => 'heroicon-o-envelope',
    'sort' => '49',
  ),
  'fields' => 
  array (
    'subject' => 
    array (
      'label' => 'Subject',
      'placeholder' => 'Enter email subject',
      'help' => 'Subject that will appear in the email header',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'template_id' => 
    array (
      'label' => 'Email Template',
      'placeholder' => 'Select the email template to use',
      'help' => 'Default template for the email (optional)',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'to' => 
    array (
      'label' => 'Recipient',
      'placeholder' => 'recipient@domain.com',
      'help' => 'Email address of the recipient',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'cc' => 
    array (
      'label' => 'Carbon Copy (CC)',
      'placeholder' => 'cc@domain.com (optional)',
      'help' => 'Email addresses in carbon copy, separated by commas',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'bcc' => 
    array (
      'label' => 'Blind Carbon Copy (BCC)',
      'placeholder' => 'bcc@domain.com (optional)',
      'help' => 'Email addresses in blind carbon copy, separated by commas',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'content' => 
    array (
      'label' => 'Text Content',
      'placeholder' => 'Enter the text content of the email',
      'help' => 'Text content of the email (plain text version)',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'body_html' => 
    array (
      'label' => 'HTML Content',
      'placeholder' => '<h1>Title</h1><p>Email content in HTML format</p>',
      'help' => 'HTML content of the email to send (optional)',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'parameters' => 
    array (
      'label' => 'Template Parameters',
      'placeholder' => '{\\"name\\": \\"John\\", \\"surname\\": \\"Doe\\"}',
      'help' => 'JSON parameters to customize the selected template',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'attachments' => 
    array (
      'label' => 'Attachments',
      'placeholder' => 'Select files to attach',
      'help' => 'Files to attach to the email (optional)',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'priority' => 
    array (
      'label' => 'Priority',
      'placeholder' => 'Select email priority',
      'help' => 'Email priority (normal, high, urgent)',
      'options' => 
      array (
        'normal' => 'Normal',
        'high' => 'High',
        'urgent' => 'Urgent',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'Send Email',
      'success' => 'Email sent successfully to the recipient',
      'error' => 'Error sending email. Check the configuration.',
      'confirmation' => 'Are you sure you want to send this email?',
      'tooltip' => 'Send the email to the specified recipient',
    ),
    'preview' => 
    array (
      'label' => 'Preview',
      'success' => 'Email preview generated correctly',
      'error' => 'Error generating preview',
      'tooltip' => 'View email preview before sending',
    ),
    'save_draft' => 
    array (
      'label' => 'Save Draft',
      'success' => 'Draft saved correctly',
      'error' => 'Error saving draft',
      'tooltip' => 'Save email as draft to send later',
    ),
    'schedule' => 
    array (
      'label' => 'Schedule Send',
      'success' => 'Email scheduled for sending',
      'error' => 'Error scheduling send',
      'tooltip' => 'Schedule email sending for a specific date and time',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Email sent successfully! Check the recipient\'s email inbox.',
    'error' => 'An error occurred while sending the email. Check the SMTP configuration.',
    'draft_saved' => 'Draft saved correctly. You can retrieve it from the Drafts section.',
    'scheduled' => 'Email scheduled for sending. You will receive a notification when it is sent.',
    'preview_generated' => 'Preview generated correctly. Check the email appearance.',
    'invalid_template' => 'Invalid or not found email template.',
    'invalid_parameters' => 'Invalid template parameters. Check the JSON format.',
    'no_recipients' => 'No recipient specified. Enter at least one email address.',
    'smtp_error' => 'SMTP configuration error. Check server settings.',
  ),
  'validation' => 
  array (
    'subject_required' => 'Email subject is required',
    'to_required' => 'Recipient is required',
    'to_valid' => 'Recipient must be a valid email address',
    'cc_valid' => 'CC addresses must be valid emails',
    'bcc_valid' => 'BCC addresses must be valid emails',
    'content_required' => 'Email content is required',
    'template_exists' => 'Selected template does not exist',
    'parameters_json' => 'Parameters must be in valid JSON format',
    'priority_valid' => 'Priority must be one of the available options',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

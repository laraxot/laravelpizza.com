<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Send Email',
        'group' => [
            'label' => 'System',
            'description' => 'Functionality for sending emails through the notification system',
        ],
        'icon' => 'heroicon-o-envelope',
        'sort' => '49',
    ],
    'fields' => [
        'subject' => [
            'label' => 'Subject',
            'placeholder' => 'Enter email subject',
            'help' => 'Subject that will appear in the email header',
        ],
        'template_id' => [
            'label' => 'Email Template',
            'placeholder' => 'Select the email template to use',
            'help' => 'Default template for the email (optional)',
        ],
        'to' => [
            'label' => 'Recipient',
            'placeholder' => 'recipient@domain.com',
            'help' => 'Email address of the recipient',
        ],
        'cc' => [
            'label' => 'Carbon Copy (CC)',
            'placeholder' => 'cc@domain.com (optional)',
            'help' => 'Email addresses in carbon copy, separated by commas',
        ],
        'bcc' => [
            'label' => 'Blind Carbon Copy (BCC)',
            'placeholder' => 'bcc@domain.com (optional)',
            'help' => 'Email addresses in blind carbon copy, separated by commas',
        ],
        'content' => [
            'label' => 'Text Content',
            'placeholder' => 'Enter the text content of the email',
            'help' => 'Text content of the email (plain text version)',
        ],
        'body_html' => [
            'label' => 'HTML Content',
            'placeholder' => '<h1>Title</h1><p>Email content in HTML format</p>',
            'help' => 'HTML content of the email to send (optional)',
        ],
        'parameters' => [
            'label' => 'Template Parameters',
            'placeholder' => '{\"name\": \"John\", \"surname\": \"Doe\"}',
            'help' => 'JSON parameters to customize the selected template',
        ],
        'attachments' => [
            'label' => 'Attachments',
            'placeholder' => 'Select files to attach',
            'help' => 'Files to attach to the email (optional)',
        ],
        'priority' => [
            'label' => 'Priority',
            'placeholder' => 'Select email priority',
            'help' => 'Email priority (normal, high, urgent)',
            'options' => [
                'normal' => 'Normal',
                'high' => 'High',
                'urgent' => 'Urgent',
            ],
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Send Email',
            'success' => 'Email sent successfully to the recipient',
            'error' => 'Error sending email. Check the configuration.',
            'confirmation' => 'Are you sure you want to send this email?',
            'tooltip' => 'Send the email to the specified recipient',
        ],
        'preview' => [
            'label' => 'Preview',
            'success' => 'Email preview generated correctly',
            'error' => 'Error generating preview',
            'tooltip' => 'View email preview before sending',
        ],
        'save_draft' => [
            'label' => 'Save Draft',
            'success' => 'Draft saved correctly',
            'error' => 'Error saving draft',
            'tooltip' => 'Save email as draft to send later',
        ],
        'schedule' => [
            'label' => 'Schedule Send',
            'success' => 'Email scheduled for sending',
            'error' => 'Error scheduling send',
            'tooltip' => 'Schedule email sending for a specific date and time',
        ],
    ],
    'messages' => [
        'success' => 'Email sent successfully! Check the recipient\'s email inbox.',
        'error' => 'An error occurred while sending the email. Check the SMTP configuration.',
        'draft_saved' => 'Draft saved correctly. You can retrieve it from the Drafts section.',
        'scheduled' => 'Email scheduled for sending. You will receive a notification when it is sent.',
        'preview_generated' => 'Preview generated correctly. Check the email appearance.',
        'invalid_template' => 'Invalid or not found email template.',
        'invalid_parameters' => 'Invalid template parameters. Check the JSON format.',
        'no_recipients' => 'No recipient specified. Enter at least one email address.',
        'smtp_error' => 'SMTP configuration error. Check server settings.',
    ],
    'validation' => [
        'subject_required' => 'Email subject is required',
        'to_required' => 'Recipient is required',
        'to_valid' => 'Recipient must be a valid email address',
        'cc_valid' => 'CC addresses must be valid emails',
        'bcc_valid' => 'BCC addresses must be valid emails',
        'content_required' => 'Email content is required',
        'template_exists' => 'Selected template does not exist',
        'parameters_json' => 'Parameters must be in valid JSON format',
        'priority_valid' => 'Priority must be one of the available options',
    ],
];

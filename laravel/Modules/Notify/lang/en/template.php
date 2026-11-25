<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Notification Templates',
        'plural' => 'Notification Templates',
    ],
    'navigation' => [
        'name' => 'Notification Templates',
        'plural' => 'Notification Templates',
        'group' => [
            'name' => 'System',
            'description' => 'Manage notification templates',
        ],
        'label' => 'Notification Templates',
        'icon' => 'notify-template-animated',
        'sort' => 48,
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Identifying name of the template',
            'placeholder' => 'e.g. Expiry Notification',
            'helper_text' => 'Enter a descriptive name for the template',
            'help' => 'Enter a descriptive name for the template',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'tooltip' => 'Template description',
            'placeholder' => 'e.g. Template for expiry notifications',
            'helper_text' => 'Short description of the template purpose',
            'description' => '',
        ],
        'type' => [
            'label' => 'Type',
            'tooltip' => 'Notification type',
            'placeholder' => 'Select the notification type',
            'helper_text' => 'The type determines the send channel',
            'options' => [
                'email' => 'Email',
                'sms' => 'SMS',
                'push' => 'Push Notification',
                'telegram' => 'Telegram',
                'whatsapp' => 'WhatsApp',
            ],
            'description' => '',
        ],
        'subject' => [
            'label' => 'Subject',
            'tooltip' => 'Notification subject',
            'placeholder' => 'e.g. Appointment reminder',
            'helper_text' => 'Subject shown in the notification (e.g. email subject)',
            'description' => '',
        ],
        'body_text' => [
            'label' => 'Text',
            'placeholder' => 'Enter notification text',
            'help' => 'The text content of the notification',
            'tooltip' => 'This field is required',
            'helper_text' => '',
            'description' => '',
        ],
        'body_html' => [
            'label' => 'HTML',
            'placeholder' => 'Enter notification HTML content',
            'help' => 'The HTML content of the notification',
            'tooltip' => 'This field is required',
            'helper_text' => '',
            'description' => '',
        ],
        'preview_data' => [
            'label' => 'Preview Data',
            'placeholder' => 'Enter preview data',
            'help' => 'The data used to display the preview',
            'tooltip' => 'JSON format',
            'helper_text' => '',
            'description' => '',
        ],
        'content' => [
            'label' => 'Content',
            'tooltip' => 'Message body',
            'placeholder' => 'Enter the message text',
            'helper_text' => 'Main notification content',
            'description' => '',
        ],
        'variables' => [
            'label' => 'Variables',
            'tooltip' => 'Available variables',
            'placeholder' => '{{name}}, {{email}}, etc.',
            'helper_text' => 'Variables that can be used in the template',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Active',
            'tooltip' => 'Template status',
            'helper_text' => 'If active, the template can be used to send notifications',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created at',
            'tooltip' => 'Template creation date',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Last updated',
            'tooltip' => 'Template last modified date',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'preview' => [
            'label' => 'Preview',
            'tooltip' => 'Preview the template',
            'icon' => 'heroicon-o-eye',
            'success_message' => 'Preview generated successfully',
            'error_message' => 'Error generating the preview',
        ],
        'duplicate' => [
            'label' => 'Duplicate',
            'tooltip' => 'Create a copy of the template',
            'icon' => 'heroicon-o-document-duplicate',
            'success_message' => 'Template duplicated successfully',
            'error_message' => 'Error duplicating the template',
        ],
        'test' => [
            'label' => 'Test',
            'tooltip' => 'Send a test notification',
            'icon' => 'heroicon-o-paper-airplane',
            'success_message' => 'Test notification sent successfully',
            'error_message' => 'Error sending the test notification',
        ],
    ],
    'messages' => [
        'success' => 'Operation completed successfully',
        'error' => 'An error occurred during the operation',
        'confirmation' => 'Are you sure you want to proceed with this operation?',
        'template_created' => 'The template was created successfully',
        'template_updated' => 'The template was updated successfully',
        'template_deleted' => 'The template was deleted successfully',
        'errors' => [
            'not_found' => 'Template not found',
            'unauthorized' => 'Unauthorized',
        ],
    ],
    'label' => 'Template',
    'plural_label' => 'Templates',
    'form' => [
        'name' => [
            'helper' => 'Internal template name, for lookup',
        ],
        'subject' => [
            'helper' => 'Message subject; you can use double-brace variables',
        ],
        'type' => [
            'helper' => 'Message channel',
        ],
        'body_text' => [
            'helper' => 'Plain-text version',
        ],
        'body_html' => [
            'helper' => 'HTML version',
        ],
        'preview_data' => [
            'helper' => 'Sample JSON data for preview',
        ],
        'attachments' => [
            'helper' => 'Files attached to the message',
        ],
    ],
    'preview' => [
        'title' => 'Template preview',
        'subheading' => 'Rendered with sample preview data',
    ],
];

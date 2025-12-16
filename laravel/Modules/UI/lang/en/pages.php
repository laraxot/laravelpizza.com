<?php

declare(strict_types=1);

return [
    's3test' => [
        'heading' => 'S3 Email Test',
        'description' => 'Test page for sending emails via S3',
        'info' => [
            'title' => 'Test Information',
            'description' => 'This page allows you to test email sending via the S3 system. Enter the required data and click "Send Email" to proceed with the test.',
        ],
        'fields' => [
            'to' => [
                'label' => 'Recipient',
                'placeholder' => 'Enter the recipient\'s email address',
                'helper_text' => 'The email will be sent to this address',
                'description' => 'Recipient\'s email address',
            ],
            'subject' => [
                'label' => 'Subject',
                'placeholder' => 'Enter the email subject',
                'helper_text' => 'The subject will appear in the recipient\'s inbox',
                'description' => 'Email subject',
            ],
            'body_html' => [
                'label' => 'Content',
                'placeholder' => 'Enter the email content',
                'helper_text' => 'The content can include HTML formatting',
                'description' => 'Email content',
            ],
        ],
        'actions' => [
            'send_email' => [
                'label' => 'Send Email',
                'success' => 'Email sent successfully',
                'error' => 'Error sending email',
            ],
            'email_form_actions' => [
                'label' => 'Send Test Email',
            ],
        ],
        'notifications' => [
            'check_email_client' => 'Check your email client',
            'email_sent_success' => 'Email sent successfully',
            'email_sent_error' => 'Error sending email',
        ],
    ],
];

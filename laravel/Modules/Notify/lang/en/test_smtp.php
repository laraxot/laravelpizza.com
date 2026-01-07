<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'SMTP Test',
        'group' => [
            'label' => 'Send',
        ],
        'icon' => 'heroicon-o-envelope',
        'sort' => '50',
    ],
    'fields' => [
        'host' => [
            'label' => 'SMTP Host',
            'placeholder' => 'Enter SMTP host (e.g. smtp.gmail.com)',
            'help' => 'SMTP server address for sending emails',
        ],
        'port' => [
            'label' => 'Port',
            'placeholder' => 'Enter port (e.g. 587 for TLS, 465 for SSL)',
            'help' => 'SMTP server port (587 for TLS, 465 for SSL, 25 for unencrypted)',
        ],
        'username' => [
            'label' => 'Username',
            'placeholder' => 'Enter username for authentication',
            'help' => 'Username for SMTP authentication (often the email address)',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => '••••••••',
            'help' => 'Password for SMTP authentication (can be an app-specific password)',
        ],
        'encryption' => [
            'label' => 'Encryption',
            'placeholder' => 'Select encryption type',
            'help' => 'Encryption type for SMTP connection (TLS, SSL, or none)',
            'options' => [
                'tls' => 'TLS (Transport Layer Security)',
                'ssl' => 'SSL (Secure Sockets Layer)',
                'none' => 'No encryption',
            ],
        ],
        'from_email' => [
            'label' => 'Sender Email',
            'placeholder' => 'sender@domain.com',
            'help' => 'Email address that will appear as the sender of the test email',
        ],
        'from_name' => [
            'label' => 'Sender Name',
            'placeholder' => 'Sender name',
            'help' => 'Name that will appear as the sender of the test email',
        ],
        'to' => [
            'label' => 'Recipient',
            'placeholder' => 'recipient@domain.com',
            'help' => 'Email address of the recipient for the SMTP test',
        ],
        'subject' => [
            'label' => 'Subject',
            'placeholder' => 'SMTP Configuration Test - {{app_name}}',
            'help' => 'Subject of the test email to verify the configuration',
        ],
        'body_html' => [
            'label' => 'HTML Content',
            'placeholder' => '<h1>SMTP Test</h1><p>This is a test email to verify the SMTP configuration.</p>',
            'help' => 'HTML content of the test email (optional)',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Send SMTP Test',
            'success' => 'SMTP test sent successfully! The configuration is correct.',
            'error' => 'Error sending SMTP test. Check the configuration.',
            'confirmation' => 'Are you sure you want to send a test email?',
            'tooltip' => 'Send a test email to verify the SMTP configuration',
        ],
        'test_connection' => [
            'label' => 'Test Connection',
            'success' => 'SMTP connection established successfully',
            'error' => 'Unable to establish SMTP connection',
            'tooltip' => 'Test only the connection without sending email',
        ],
    ],
    'messages' => [
        'success' => 'SMTP test sent successfully! Check the recipient\'s email inbox.',
        'error' => 'An error occurred while sending the SMTP test. Check the configuration parameters.',
        'connection_success' => 'SMTP connection established correctly',
        'connection_error' => 'SMTP connection error. Check host, port and credentials.',
        'invalid_configuration' => 'Invalid SMTP configuration. Check all parameters.',
        'email_sent' => 'Test email sent correctly to the recipient',
        'email_failed' => 'Unable to send test email. Check the configuration.',
    ],
    'validation' => [
        'host_required' => 'SMTP host is required',
        'port_required' => 'SMTP port is required',
        'port_numeric' => 'Port must be a number',
        'username_required' => 'SMTP username is required',
        'password_required' => 'SMTP password is required',
        'from_email_required' => 'Sender email is required',
        'from_email_valid' => 'Sender email must be a valid address',
        'to_required' => 'Recipient email is required',
        'to_valid' => 'Recipient email must be a valid address',
        'subject_required' => 'Email subject is required',
    ],
];

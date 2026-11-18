<?php

declare(strict_types=1);

return [
    'form' => [
        'to' => [
            'label' => 'Recipient',
            'helper' => 'Email address for the test',
        ],
        'subject' => [
            'label' => 'Subject',
        ],
        'body_html' => [
            'label' => 'Body',
            'helper' => 'Message content (HTML allowed)',
        ],
        'template' => [
            'label' => 'Template',
            'helper' => 'Optional: use a saved template',
        ],
        'add_attachments' => [
            'label' => 'Attachments',
            'helper' => 'Optional',
        ],
    ],
    'actions' => [
        'send' => 'Send',
    ],
];

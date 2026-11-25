<?php

declare(strict_types=1);
// Xot translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Xot/docs/wiki — domain i18n only.
// File: lang/en/labels/backend/takeaway/smsTransaction.php
// Split from labels/backend/takeaway.php

return [
    'tabs' => [
        'titles' => [
            'overview' => 'Overview',
            'history' => 'History',
        ],
        'content' => [
            'overview' => [
                'merchant_id' => 'Restaurant Name',
                'credits' => 'Credits',
                'status' => 'Status',
                'created_at' => 'Created At',
                'desc' => 'Description',
                'last_updated' => 'Last Updated',
            ],
        ],
    ],
    'table' => [
        'id' => 'Id',
        'merchant_id' => 'Restaurant Name',
        'sms_package_id' => 'Package Name',
        'credits' => 'Credits',
        'status' => 'Status',
        'paid_by' => 'Paid By',
        'created_at' => 'Created At',
    ],
    'management' => 'Sms Transaction Management',
    'active' => 'Active Sms Transaction',
    'create' => 'Create Sms Transaction',
    'edit' => 'Edit Sms Transaction',
    'view' => 'View Sms Transaction',
];

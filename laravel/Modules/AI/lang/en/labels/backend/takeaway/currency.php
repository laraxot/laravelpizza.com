<?php

declare(strict_types=1);
// Xot translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Xot/docs/wiki — domain i18n only.
// File: lang/en/labels/backend/takeaway/currency.php
// Split from labels/backend/takeaway.php

return [
    'create' => 'Create currency',
    'currency_code' => 'Currency Code',
    'currency_symbol' => 'Currency Symbol',
    'convertion_rate' => 'Convertion Rate',
    'management' => 'Currency Management',
    'edit' => 'Edit',
    'view' => 'View',
    'currency_desc' => 'Currency Description',
    'active' => 'Active',
    'table' => [
        'id' => 'Id',
        'currency_code' => 'Currency Code',
        'currency_symbol' => 'Currency Symbol',
        'convertion_rate' => 'Convertion Rate',
        'created_at' => 'Created At',
        'view' => 'View',
    ],
    'tabs' => [
        'titles' => [
            'overview' => 'Overview',
            'history' => 'History',
        ],
        'content' => [
            'overview' => [
                'code' => 'Code',
                'symbol' => 'Symbol',
                'rate' => 'Rate',
                'created_at' => 'Created At',
                'last_updated' => 'Last Updated',
                'deleted_at' => 'Deleted At',
            ],
        ],
    ],
];

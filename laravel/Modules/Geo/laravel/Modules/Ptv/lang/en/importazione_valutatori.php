<?php

declare(strict_types=1);

return [
    'actions' => [
        'import_valutatori' => [
            'label' => 'Import XLS',
            'success' => 'Import completed successfully',
            'error' => 'An error occurred during import',
        ],
    ],
    'fields' => [
        'file' => [
            'label' => 'XLS File',
            'help' => 'Select the XLS/XLSX file to import',
        ],
        'header_row' => [
            'label' => 'Header row',
            'help' => 'Enter the row number containing column headers',
        ],
        'anno' => [
            'label' => 'Year',
            'help' => 'Enter the reference year',
        ],
        'quadrimestre' => [
            'label' => 'Quarter',
            'help' => 'Enter the reference quarter (e.g. 1, 2, 3, 4)',
        ],
    ],
    'notifications' => [
        'user_not_found' => 'No user found with email [:email]',
        'import_success' => 'Import completed successfully',
    ],
];

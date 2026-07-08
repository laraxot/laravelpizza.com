<?php

declare(strict_types=1);

return [
    'actions' => [
        'import_valutatori_' => [
            'label' => 'Import Evaluators',
        ],
        'cancel' => [
            'icon' => 'cancel',
            'label' => 'Cancel',
            'tooltip' => 'Cancel',
        ],
        'submit' => [
            'icon' => 'submit',
            'label' => 'Submit',
            'tooltip' => 'Submit',
        ],
    ],
    'fields' => [
        'file' => [
            'label' => 'File',
            'description' => 'Select import file',
            'helper_text' => 'XLS or CSV format',
            'placeholder' => 'Select file',
        ],
        'header_row' => [
            'label' => 'Header Row',
            'description' => 'Row containing column headers',
            'helper_text' => 'Usually row 1',
            'placeholder' => '1',
        ],
        'anno' => [
            'label' => 'Year',
            'description' => 'Reference year',
            'helper_text' => 'Year for import',
            'placeholder' => '2024',
        ],
    ],
];

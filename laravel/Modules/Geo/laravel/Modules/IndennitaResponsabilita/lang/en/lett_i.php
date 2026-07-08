<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Letter I',
        'group' => 'Allowance',
        'icon' => 'heroicon-o-document-check',
        'sort' => 64,
    ],

    'fields' => [
        'matr' => [
            'label' => 'Badge Number',
            'placeholder' => 'Employee badge number',
            'help' => 'Employee badge code',
        ],
        'archivista_informatico' => [
            'label' => 'IT Archivist',
            'help' => 'Indicates if employee has IT archivist allowance',
        ],
        'relazioni_pubblico' => [
            'label' => 'Public Relations',
            'help' => 'Indicates if employee has public relations allowance',
        ],
        'protezione_civile' => [
            'label' => 'Civil Protection',
            'help' => 'Indicates if employee has civil protection allowance',
        ],
        'formatore_professionale' => [
            'label' => 'Professional Trainer',
            'help' => 'Indicates if employee has professional trainer allowance',
        ],
        'dali' => [
            'label' => 'From (Allowance)',
            'placeholder' => 'Allowance start date',
            'help' => 'Allowance period start date',
        ],
        'ali' => [
            'label' => 'To (Allowance)',
            'placeholder' => 'Allowance end date',
            'help' => 'Allowance period end date',
        ],
        'dali__ali' => [
            'label' => 'Allowance Period',
            'help' => 'Complete allowance period range (format: dd/mm/yyyy - dd/mm/yyyy)',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'New Letter I',
            'success' => 'Letter I allowance created successfully',
            'error' => 'Error creating allowance',
        ],
        'edit' => [
            'label' => 'Edit',
            'success' => 'Allowance updated successfully',
            'error' => 'Error updating allowance',
        ],
        'delete' => [
            'label' => 'Delete',
            'confirmation' => 'This action is irreversible. Confirm deletion?',
            'success' => 'Allowance deleted successfully',
            'error' => 'Error deleting allowance',
        ],
    ],

    'sections' => [
        'anagrafica' => [
            'label' => 'Personal Data',
            'description' => 'Employee personal information',
        ],
        'periodo' => [
            'label' => 'Validity Periods',
            'description' => 'Timeframes (general, salary, allowance)',
        ],
        'indennita' => [
            'label' => 'Special Allowances',
            'description' => 'Types of special allowances applicable',
        ],
    ],

    'messages' => [
        'empty_state' => 'No Letter I allowances found',
        'periodo_info' => 'Different periods can be specified for validity, salary and allowance',
    ],

    'indennita_types' => [
        'archivista_informatico' => 'IT Archivist',
        'relazioni_pubblico' => 'Public Relations',
        'protezione_civile' => 'Civil Protection',
        'formatore_professionale' => 'Professional Trainer',
    ],
];

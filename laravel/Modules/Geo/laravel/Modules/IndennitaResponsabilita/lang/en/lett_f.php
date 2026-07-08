<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Letter F',
        'group' => 'Allowance',
        'icon' => 'heroicon-o-document-text',
        'sort' => 86,
    ],

    'fields' => [
        'matr' => [
            'label' => 'Badge Number',
            'placeholder' => 'Employee badge number',
            'help' => 'Employee badge code',
        ],
        'cognome' => [
            'label' => 'Surname',
            'placeholder' => 'Employee surname',
            'help' => 'Employee surname',
        ],
        'nome' => [
            'label' => 'Name',
            'placeholder' => 'Employee name',
            'help' => 'Employee name',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'email@address.com',
            'help' => 'Employee email address',
        ],
        'posizione_lavoro' => [
            'label' => 'Job Position',
            'placeholder' => 'Describe the job position',
            'help' => 'Detailed description of position and responsibilities',
        ],
        'complessita' => [
            'label' => 'Complexity',
            'placeholder' => '0-40',
            'help' => 'Role complexity assessment (0-40 points)',
        ],
        'coordinamento' => [
            'label' => 'Coordination',
            'placeholder' => '0-30',
            'help' => 'Coordination activities assessment (0-30 points)',
        ],
        'responsabilita' => [
            'label' => 'Responsibility',
            'placeholder' => '0-30',
            'help' => 'Responsibility level assessment (0-30 points)',
        ],
        'tot' => [
            'label' => 'Total',
            'help' => 'Total score (automatically calculated)',
        ],
        'valore_economico_calcolato' => [
            'label' => 'Calculated Economic Value',
            'help' => 'Value calculated based on score',
        ],
        'valore_economico_attribuito' => [
            'label' => 'Assigned Economic Value',
            'help' => 'Final value assigned to employee',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'New Letter F',
            'success' => 'Letter F assessment created successfully',
            'error' => 'Error creating assessment',
        ],
        'edit' => [
            'label' => 'Edit',
            'success' => 'Assessment updated successfully',
            'error' => 'Error updating assessment',
        ],
        'delete' => [
            'label' => 'Delete',
            'confirmation' => 'This action is irreversible. Confirm deletion?',
            'success' => 'Assessment deleted successfully',
            'error' => 'Error deleting assessment',
        ],
    ],

    'sections' => [
        'anagrafica' => [
            'label' => 'Personal Data',
            'description' => 'Employee personal information',
        ],
        'periodo' => [
            'label' => 'Validity Period',
            'description' => 'Assessment timeframe',
        ],
        'valutazione' => [
            'label' => 'Assessment Criteria',
            'description' => 'Scores for complexity, coordination and responsibility',
        ],
        'importi' => [
            'label' => 'Economic Values',
            'description' => 'Calculated and assigned amounts',
        ],
    ],

    'messages' => [
        'empty_state' => 'No Letter F assessments found',
        'auto_calculated' => 'Values automatically calculated based on scores',
    ],
];

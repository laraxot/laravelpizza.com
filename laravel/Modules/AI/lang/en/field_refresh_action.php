<?php

declare(strict_types=1);

return [
    'tooltip' => [
        'label' => 'Recalculate value',
        'placeholder' => '',
        'help' => 'Re-runs the record getter and updates the form field.',
    ],
    'notifications' => [
        'invalid_record' => [
            'title' => 'Error',
            'body' => 'Invalid record.',
        ],
        'method_missing' => [
            'title' => 'Recalculation unavailable',
            'body' => 'The model does not expose the required method for this field. Ensure the record uses the correct base model (e.g. BaseIndividualeModel with EnteMatrDateRangeMutator) and deployment matches the codebase.',
        ],
        'success' => [
            'title' => 'Value :name recalculated',
            'body' => 'The field value was recalculated successfully. New value: :value',
        ],
    ],
];

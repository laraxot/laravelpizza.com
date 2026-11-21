<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Lock Cache',
        'plural' => 'Lock Cache',
        'group' => [
            'name' => 'Sistema',
            'description' => 'System and resource management',
        ],
        'label' => 'locks',
        'sort' => '11',
        'icon' => 'xot-lock',
    ],
    'fields' => [
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Enter the lock key',
            'help' => 'Unique lock identifier key',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'owner' => [
            'label' => 'Proprietario',
            'placeholder' => 'Enter the lock owner',
            'help' => 'Process or user that owns the lock',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expiration' => [
            'label' => 'Scadenza',
            'placeholder' => 'Select the expiration date and time',
            'help' => 'When the lock will expire automatically',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'help' => 'Current status of the lock in the system',
            'options' => [
                'locked' => 'Bloccato',
                'unlocked' => 'Sbloccato',
                'expired' => 'Scaduto',
                'pending' => 'In Attesa',
                'error' => 'Error',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Date and time the lock was created',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Last Updated',
            'help' => 'Date and time the lock was last modified',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Enter a description',
            'help' => 'Optional lock description',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo Lock',
            'placeholder' => 'Select the type',
            'help' => 'Lock type',
            'options' => [
                'file' => 'File',
                'process' => 'Processo',
                'resource' => 'Risorsa',
                'custom' => 'Personalizzato',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'create' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'view' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'delete' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'lock' => [
            'label' => 'Blocca',
            'success' => 'Lock created successfully',
            'error' => 'Error while creating the lock',
        ],
        'unlock' => [
            'label' => 'Sblocca',
            'success' => 'Lock removed successfully',
            'error' => 'Error while removing the lock',
        ],
        'refresh' => [
            'label' => 'Refresh',
            'success' => 'Lock updated successfully',
            'error' => 'Error while updating the lock',
        ],
        'force_unlock' => [
            'label' => 'Forza Sblocco',
            'success' => 'Lock forzatamente rimosso',
            'error' => 'Unable to force-remove the lock',
        ],
        'extend' => [
            'label' => 'Estendi',
            'success' => 'Lock expiration extended successfully',
            'error' => 'Unable to extend the lock expiration',
        ],
    ],
    'messages' => [
        'validation' => [
            'key' => [
                'required' => 'The key is required',
                'unique' => 'This key is already in use',
                'regex' => 'The key may only contain letters, numbers and dashes',
            ],
            'owner' => [
                'required' => 'The owner is required',
                'exists' => 'The specified owner does not exist',
            ],
            'expiration' => [
                'required' => 'The expiration is required',
                'date' => 'The expiration date is not valid',
                'after' => 'The expiration date must be in the future',
                'before' => 'The expiration date cannot exceed 24 hours',
            ],
            'type' => [
                'required' => 'The lock type is required',
                'in' => 'The selected type is not valid',
            ],
        ],
        'errors' => [
            'already_locked' => 'This resource is already locked',
            'not_locked' => 'This resource is not locked',
            'not_owner' => 'You are not the owner of this lock',
            'expired' => 'The lock has expired',
            'system_error' => 'System error during the operation',
        ],
        'info' => [
            'auto_unlock' => 'The lock will be removed automatically when it expires',
            'force_required' => 'You may need to force the unlock',
            'extend_available' => 'You can extend the lock duration',
        ],
    ],
    'model' => [
        'label' => 'cache lock.model',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];

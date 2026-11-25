<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Cache Lock',
        'plural' => 'Cache Locks',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Cache lock management',
        ],
        'label' => 'Cache lock',
        'sort' => '20',
        'icon' => 'xot-lock',
    ],
    'fields' => [
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Enter the lock key',
            'help' => 'Identificativo univoco del lock in cache',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'owner' => [
            'label' => 'Proprietario',
            'placeholder' => 'Owner identifier',
            'help' => 'Identifier of the process holding the lock',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expiration' => [
            'label' => 'Scadenza',
            'placeholder' => 'Expiration timestamp',
            'help' => 'When the lock will expire automatically',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'View',
            'success' => 'Lock visualizzato',
            'error' => 'Unable to view the lock',
        ],
        'delete' => [
            'label' => 'Delete',
            'success' => 'Lock deleted successfully',
            'error' => 'Unable to delete the lock',
            'confirm' => 'Are you sure you want to delete this lock?',
        ],
        'release' => [
            'label' => 'Rilascia',
            'success' => 'Lock released successfully',
            'error' => 'Unable to release the lock',
        ],
        'refresh' => [
            'label' => 'Refresh',
            'success' => 'Lock updated',
            'error' => 'Unable to update the lock',
        ],
    ],
    'messages' => [
        'status' => [
            'active' => 'Active lock',
            'expired' => 'Lock scaduto',
            'released' => 'Lock rilasciato',
        ],
        'errors' => [
            'not_found' => 'Lock not found',
            'already_acquired' => 'Lock already acquired',
            'expired' => 'Lock scaduto',
            'permission' => 'Permessi insufficienti',
        ],
        'warnings' => [
            'expiring_soon' => 'The lock will expire soon',
            'stale_lock' => 'Lock potenzialmente bloccato',
        ],
        'info' => [
            'auto_release' => 'The lock will be released automatically when it expires',
            'lock_extended' => 'Lock duration extended',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];

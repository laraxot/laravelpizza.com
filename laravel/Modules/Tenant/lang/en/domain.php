<?php

declare(strict_types=1);

return [
    'navigation' => [
        'plural' => 'Domains',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'domain',
        'sort' => 6,
        'icon' => 'tenant-domain-animated',
    ],
    'fields' => [
        'domain' => [
            'label' => 'Domain',
        ],
        'domains' => [
            'label' => 'Domains',
        ],
        'list' => [
            'label' => 'Domain List',
        ],
        'create' => [
            'label' => 'Create Domain',
        ],
        'edit' => [
            'label' => 'Edit Domain',
        ],
        'destroy' => [
            'label' => 'Delete Domain',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'rating' => [
            'label' => 'rating',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'actions' => [
        'domain_created' => 'Domain created successfully',
        'domain_updated' => 'Domain updated successfully',
        'domain_deleted' => 'Domain deleted successfully',
        'confirm_delete' => 'Are you sure you want to delete this domain?',
        'no_records' => 'No domains found',
        'invalid_domain' => 'Invalid domain',
        'domain_exists' => 'This domain already exists',
        'primary_domain' => 'Primary Domain',
        'set_primary' => 'Set as Primary',
        'domain_set_primary' => 'Domain set as primary successfully',
    ],
    'model' => [
        'label' => 'domain.model',
    ],
    'plural' => [
        'model' => [
            'label' => 'domain.plural.model',
        ],
    ],
];

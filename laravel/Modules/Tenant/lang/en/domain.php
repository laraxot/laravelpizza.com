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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'domains' => [
            'label' => 'Domains',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'list' => [
            'label' => 'Domain List',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'create' => [
            'label' => 'Create Domain',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'label' => 'Edit Domain',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'destroy' => [
            'label' => 'Delete Domain',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'rating' => [
            'label' => 'rating',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];

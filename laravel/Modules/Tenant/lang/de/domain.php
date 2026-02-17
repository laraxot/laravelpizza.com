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
            'label' => 'Domain-Liste',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'create' => [
            'label' => 'Domain erstellen',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'label' => 'Domain bearbeiten',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'destroy' => [
            'label' => 'Domain löschen',
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
        'domain_created' => 'Domain erfolgreich erstellt',
        'domain_updated' => 'Domain erfolgreich aktualisiert',
        'domain_deleted' => 'Domain erfolgreich gelöscht',
        'confirm_delete' => 'Sind Sie sicher, dass Sie diese Domain löschen möchten?',
        'no_records' => 'Keine Domains gefunden',
        'invalid_domain' => 'Ungültige Domain',
        'domain_exists' => 'Diese Domain existiert bereits',
        'primary_domain' => 'Primäre Domain',
        'set_primary' => 'Als primär setzen',
        'domain_set_primary' => 'Domain erfolgreich als primär gesetzt',
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

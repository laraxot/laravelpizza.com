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
            'label' => 'Domain-Liste',
        ],
        'create' => [
            'label' => 'Domain erstellen',
        ],
        'edit' => [
            'label' => 'Domain bearbeiten',
        ],
        'destroy' => [
            'label' => 'Domain löschen',
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
];

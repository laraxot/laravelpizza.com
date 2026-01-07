<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'placeholder' => 'name',
            'description' => 'name',
        ],
        'client_name' => [
            'description' => 'client_name',
        ],
        'client_id' => [
            'description' => 'client_id',
            'label' => 'client_id',
            'placeholder' => 'client_id',
            'helper_text' => 'client_id',
        ],
        'plain_secret' => [
            'label' => 'plain_secret',
        ],
        'secret' => [
            'label' => 'secret',
        ],
        'id' => [
            'label' => 'id',
        ],
        'recordId' => [
            'description' => 'recordId',
            'placeholder' => 'recordId',
            'helper_text' => 'recordId',
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => 'submit',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'associateExistingClient' => [
            'label' => 'associateExistingClient',
            'icon' => 'associateExistingClient',
            'tooltip' => 'associateExistingClient',
        ],
        'attachAnother' => [
            'icon' => 'attachAnother',
            'label' => 'attachAnother',
        ],
        'detachClient' => [
            'tooltip' => 'detachClient',
            'label' => 'detachClient',
            'icon' => 'detachClient',
        ],
        'associateAnother' => [
            'tooltip' => 'associateAnother',
        ],
    ],
];

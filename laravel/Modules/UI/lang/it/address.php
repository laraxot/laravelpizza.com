<?php

declare(strict_types=1);

return [
    'fields' => [
        'address' => [
            'label' => 'Indirizzo',
            'country' => ['label' => 'address.country'],
            'street' => ['label' => 'address.street'],
            'city' => ['label' => 'address.city'],
            'state' => ['label' => 'address.state'],
            'zip' => ['label' => 'address.zip'],
        ],
        'billing_address' => [
            'label' => 'billing_address',
            'country' => ['label' => 'billing_address.country'],
            'street' => ['label' => 'billing_address.street'],
            'city' => ['label' => 'billing_address.city'],
            'state' => ['label' => 'billing_address.state'],
            'zip' => ['label' => 'billing_address.zip'],
        ],
    ],
];

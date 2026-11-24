<?php

declare(strict_types=1);

return [
    'sections' => [
        'header' => [
            'title' => 'Order confirmed',
        ],
        'details' => [
            'title' => 'Order details',
        ],
        'items' => [
            'title' => 'Items',
        ],
        'shipping_address' => [
            'title' => 'Shipping address',
        ],
    ],
    'messages' => [
        'confirmation' => [
            'message' => 'Thank you for your purchase! We have received your order no. :order_id.',
        ],
        'questions' => [
            'message' => 'Questions about your order?',
        ],
    ],
    'fields' => [
        'order_number' => [
            'label' => 'Order number',
        ],
        'date' => [
            'label' => 'Date',
        ],
        'total' => [
            'label' => 'Total',
        ],
        'quantity' => [
            'label' => 'Quantity',
        ],
    ],
    'actions' => [
        'track_order' => [
            'label' => 'Track your order',
        ],
        'contact_support' => [
            'label' => 'Contact support',
        ],
    ],
];

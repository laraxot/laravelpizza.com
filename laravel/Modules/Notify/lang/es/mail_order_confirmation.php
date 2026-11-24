<?php

declare(strict_types=1);

return [
    'sections' => [
        'header' => [
            'title' => 'Pedido confirmado',
        ],
        'details' => [
            'title' => 'Detalles del pedido',
        ],
        'items' => [
            'title' => 'Artículos',
        ],
        'shipping_address' => [
            'title' => 'Dirección de envío',
        ],
    ],
    'messages' => [
        'confirmation' => [
            'message' => 'Gracias por tu compra. Hemos recibido tu pedido n.º :order_id.',
        ],
        'questions' => [
            'message' => '¿Tienes preguntas sobre tu pedido?',
        ],
    ],
    'fields' => [
        'order_number' => [
            'label' => 'Número de pedido',
        ],
        'date' => [
            'label' => 'Fecha',
        ],
        'total' => [
            'label' => 'Total',
        ],
        'quantity' => [
            'label' => 'Cantidad',
        ],
    ],
    'actions' => [
        'track_order' => [
            'label' => 'Seguir tu pedido',
        ],
        'contact_support' => [
            'label' => 'Contactar con soporte',
        ],
    ],
];

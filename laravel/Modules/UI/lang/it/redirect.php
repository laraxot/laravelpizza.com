<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => [
            'icon' => 'save',
            'label' => 'save',
            'tooltip' => 'save',
        ],
    ],
    'widget' => [
        'redirecting' => [
            'message' => 'Reindirizzamento in corso...',
        ],
        'fallback' => [
            'label' => 'Se non vieni reindirizzato automaticamente, :link.',
        ],
        'link' => [
            'label' => 'clicca qui',
        ],
        'destination' => [
            'label' => 'Destinazione: :url',
        ],
    ],
];

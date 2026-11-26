<?php

declare(strict_types=1);

return [
    'sections' => [
        'main' => [
            'title' => 'Sitemap',
        ],
    ],
    'actions' => [
        'generate' => [
            'label' => 'Genera/rigenera sitemap',
        ],
    ],
    'messages' => [
        'description' => [
            'message' => 'Genera o rigenera il file :file nella cartella pubblica.',
        ],
        'success' => [
            'title' => 'Sitemap generata',
            'body' => 'Sitemap scritta in :path',
        ],
    ],
];

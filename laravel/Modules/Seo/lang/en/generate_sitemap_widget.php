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
            'label' => 'Generate/regenerate sitemap',
        ],
    ],
    'messages' => [
        'description' => [
            'message' => 'Generates or regenerates the :file file in the public folder.',
        ],
        'success' => [
            'title' => 'Sitemap generated',
            'body' => 'Sitemap written to :path',
        ],
    ],
];

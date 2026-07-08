<?php

declare(strict_types=1);

return [
    'baseUrl' => 'https://jigsaw-docs-template.tighten.co',
    'production' => true,

    // DocSearch credentials
    'docsearchApiKey' => env('DOCSEARCH_KEY'),
    'docsearchIndexName' => env('DOCSEARCH_INDEX'),
];

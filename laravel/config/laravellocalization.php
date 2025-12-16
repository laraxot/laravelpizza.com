<?php

return [
    'supportedLocales' => [
        'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    ],

    'useAcceptLanguageHeader' => true,

    'hideDefaultLocaleInURL' => false,

    'localesOrder' => ['it', 'en'],

    'localesMapping' => [],

    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.UTF-8'),

    'urlsIgnored' => ['/skipped'],

    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];



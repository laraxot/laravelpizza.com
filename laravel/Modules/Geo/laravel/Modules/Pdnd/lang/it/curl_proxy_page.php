<?php

declare(strict_types=1);

return [
    'fields' => [
        'target_url' => [
            'label' => 'target_url',
            'placeholder' => 'target_url',
            'helper_text' => 'target_url',
            'description' => 'target_url',
        ],
        'method' => [
            'label' => 'method',
            'placeholder' => 'method',
            'helper_text' => 'method',
            'description' => 'method',
        ],
        'request_body' => [
            'label' => 'request_body',
            'placeholder' => 'request_body',
            'helper_text' => 'request_body',
            'description' => 'request_body',
        ],
        'proxy_host' => [
            'label' => 'proxy_host',
            'placeholder' => 'proxy_host',
            'helper_text' => 'proxy_host',
            'description' => 'proxy_host',
        ],
        'proxy_port' => [
            'label' => 'proxy_port',
            'placeholder' => 'proxy_port',
            'helper_text' => 'proxy_port',
            'description' => 'proxy_port',
        ],
        'proxy_username' => [
            'label' => 'proxy_username',
            'placeholder' => 'proxy_username',
            'helper_text' => 'proxy_username',
            'description' => 'proxy_username',
        ],
        'proxy_password' => [
            'label' => 'proxy_password',
            'placeholder' => 'proxy_password',
            'helper_text' => 'proxy_password',
            'description' => 'proxy_password',
        ],
        'proxy_type' => [
            'label' => 'proxy_type',
            'placeholder' => 'proxy_type',
            'helper_text' => 'proxy_type',
            'description' => 'proxy_type',
        ],
        'timeout' => [
            'label' => 'timeout',
            'placeholder' => 'timeout',
            'helper_text' => 'timeout',
            'description' => 'timeout',
        ],
        'verify_ssl' => [
            'label' => 'verify_ssl',
            'placeholder' => 'verify_ssl',
            'helper_text' => 'verify_ssl',
            'description' => 'verify_ssl',
        ],
        'headers' => [
            'label' => 'headers',
            'placeholder' => 'headers',
            'helper_text' => 'headers',
            'description' => 'headers',
        ],
    ],
    'actions' => [
        'testConnection' => [
            'label' => 'testConnection',
        ],
        'clearResults' => [
            'label' => 'clearResults',
        ],
    ],
    'navigation' => [
        'name' => 'Proxy cURL (pagina)',
        'label' => 'Proxy cURL',
        'group' => 'Strumenti PDND',
        'icon' => 'heroicon-o-command-line',
        'sort' => 92,
    ],
];

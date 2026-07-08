<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenSecurityIssues;

return [
    'preset' => 'laravel',
    'ide' => null,
    'exclude' => [
        'vendor',
        'node_modules',
        'storage',
        'bootstrap/cache',
        'tests',
        'database',
    ],
    'add' => [],
    'remove' => [
        ForbiddenSecurityIssues::class,
    ],
    'config' => [],
    'requirements' => [
        'min-quality' => 80,
        'min-complexity' => 80,
        'min-architecture' => 80,
        'min-style' => 80,
    ],
    'threads' => null,
];

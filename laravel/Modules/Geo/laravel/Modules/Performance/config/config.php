<?php

declare(strict_types=1);

use Modules\Performance\Providers\Html2PdfServiceProvider;

return [
    'name' => 'Performance',
    'icon' => 'heroicon-o-presentation-chart-line',
    'providers' => [
        Html2PdfServiceProvider::class,
    ],
];

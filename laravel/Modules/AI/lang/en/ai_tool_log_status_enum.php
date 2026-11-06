<?php

declare(strict_types=1);

/*
 * Keys read by Modules\Xot\Traits\EnumTrait through TransTrait::transClass():
 * `<module>::<snake(ClassName)>.values.<value>.<attribute>`.
 */

return [
    'values' => [
        'ok' => [
            'label' => 'Succeeded',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'description' => 'Tool call completed without errors',
        ],
        'error' => [
            'label' => 'Error',
            'color' => 'danger',
            'icon' => 'heroicon-o-exclamation-triangle',
            'description' => 'Tool call ended with an error',
        ],
    ],
];

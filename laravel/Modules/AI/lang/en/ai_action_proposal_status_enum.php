<?php

declare(strict_types=1);

/*
 * Chiavi lette da Modules\Xot\Traits\EnumTrait tramite TransTrait::transClass():
 * `<modulo>::<snake(NomeClasse)>.values.<valore>.<attributo>`.
 */

return [
    'values' => [
        'pending' => [
            'label' => 'Pending',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'description' => 'Proposal awaiting human confirmation',
        ],
        'cancelled' => [
            'label' => 'Cancelled',
            'color' => 'gray',
            'icon' => 'heroicon-o-x-circle',
            'description' => 'Proposal cancelled by a user',
        ],
        'confirmed' => [
            'label' => 'Confirmed',
            'color' => 'info',
            'icon' => 'heroicon-o-check',
            'description' => 'Proposal confirmed, being executed',
        ],
        'executed' => [
            'label' => 'Executed',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'description' => 'Action executed successfully',
        ],
        'failed' => [
            'label' => 'Failed',
            'color' => 'danger',
            'icon' => 'heroicon-o-exclamation-triangle',
            'description' => 'Execution failed or no handler registered',
        ],
    ],
];

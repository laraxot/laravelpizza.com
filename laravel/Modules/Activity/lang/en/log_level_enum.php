<?php

declare(strict_types=1);

/*
 * Chiavi lette da Modules\Xot\Traits\EnumTrait tramite TransTrait::transClass():
 * `activity::log_level_enum.values.<valore>.<attributo>`.
 * L'etichetta resta il nome del livello come scritto nei file di log (termine tecnico, lo si cerca cosi' nel testo).
 */

return [
    'values' => [
        'EMERGENCY' => [
            'label' => 'EMERGENCY',
            'color' => 'danger',
            'label' => 'Emergency',
        ],
        'ALERT' => [
            'label' => 'ALERT',
            'color' => 'danger',
            'label' => 'Alert',
        ],
        'CRITICAL' => [
            'label' => 'CRITICAL',
            'color' => 'danger',
            'label' => 'Critical',
        ],
        'ERROR' => [
            'label' => 'ERROR',
            'color' => 'danger',
            'label' => 'Error',
        ],
        'WARNING' => [
            'label' => 'WARNING',
            'color' => 'warning',
            'label' => 'Warning',
        ],
        'NOTICE' => [
            'label' => 'NOTICE',
            'color' => 'info',
            'label' => 'Notice',
        ],
        'INFO' => [
            'label' => 'INFO',
            'color' => 'info',
            'label' => 'Info',
        ],
        'DEBUG' => [
            'label' => 'DEBUG',
            'color' => 'gray',
            'label' => 'Debug',
        ],
    ],
];

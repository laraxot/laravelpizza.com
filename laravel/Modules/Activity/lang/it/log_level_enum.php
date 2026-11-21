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
            'label' => 'Emergenza',
        ],
        'ALERT' => [
            'label' => 'ALERT',
            'color' => 'danger',
            'label' => 'Allerta',
        ],
        'CRITICAL' => [
            'label' => 'CRITICAL',
            'color' => 'danger',
            'label' => 'Critico',
        ],
        'ERROR' => [
            'label' => 'ERROR',
            'color' => 'danger',
            'label' => 'Errore',
        ],
        'WARNING' => [
            'label' => 'WARNING',
            'color' => 'warning',
            'label' => 'Avviso',
        ],
        'NOTICE' => [
            'label' => 'NOTICE',
            'color' => 'info',
            'label' => 'Nota',
        ],
        'INFO' => [
            'label' => 'INFO',
            'color' => 'info',
            'label' => 'Informazione',
        ],
        'DEBUG' => [
            'label' => 'DEBUG',
            'color' => 'gray',
            'label' => 'Debug',
        ],
    ],
];

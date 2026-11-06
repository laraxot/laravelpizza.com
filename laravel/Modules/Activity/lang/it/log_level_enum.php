<?php

declare(strict_types=1);
/*
 * Chiavi lette da Modules\Xot\Traits\EnumTrait tramite TransTrait::transClass():
 * `activity::log_level_enum.values.<valore>.<attributo>`.
 * L'etichetta resta il nome del livello come scritto nei file di log (termine tecnico, lo si cerca cosi' nel testo).
 */

return [
    'values' => [
        'EMERGENCY' => ['label' => 'EMERGENCY', 'color' => 'danger'],
        'ALERT' => ['label' => 'ALERT', 'color' => 'danger'],
        'CRITICAL' => ['label' => 'CRITICAL', 'color' => 'danger'],
        'ERROR' => ['label' => 'ERROR', 'color' => 'danger'],
        'WARNING' => ['label' => 'WARNING', 'color' => 'warning'],
        'NOTICE' => ['label' => 'NOTICE', 'color' => 'info'],
        'INFO' => ['label' => 'INFO', 'color' => 'info'],
        'DEBUG' => ['label' => 'DEBUG', 'color' => 'gray'],
    ],
];

<?php

declare(strict_types=1);

/*
 * Chiavi lette da Modules\Xot\Traits\EnumTrait tramite TransTrait::transClass():
 * `<modulo>::<snake(NomeClasse)>.values.<valore>.<attributo>`.
 */

return [
    'values' => [
        'ok' => [
            'label' => 'Riuscita',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'description' => 'Chiamata al tool completata senza errori',
        ],
        'error' => [
            'label' => 'Errore',
            'color' => 'danger',
            'icon' => 'heroicon-o-exclamation-triangle',
            'description' => 'Chiamata al tool terminata con un errore',
        ],
    ],
];

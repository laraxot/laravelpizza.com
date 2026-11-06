<?php

declare(strict_types=1);
/*
 * Chiavi lette da Modules\Xot\Traits\EnumTrait tramite TransTrait::transClass():
 * la chiave e' `<modulo>::<snake(NomeClasse)>.values.<valore>.<attributo>`.
 * Il suffisso `Enum` NON viene rimosso dal nome del file: vedi
 * TransTrait::getKeyTransClass(). Senza queste voci getLabel()/getColor()/getIcon()
 * restituiscono la stringa 'fix:<chiave>', che finisce a video.
 */

return [
    'values' => [
        'top-left' => [
            'label' => 'In alto a sinistra',
            'color' => 'gray',
            'icon' => 'heroicon-o-arrow-up-left',
            'description' => 'Angolo superiore sinistro',
        ],
        'top-right' => [
            'label' => 'In alto a destra',
            'color' => 'gray',
            'icon' => 'heroicon-o-arrow-up-right',
            'description' => 'Angolo superiore destro',
        ],
        'bottom-left' => [
            'label' => 'In basso a sinistra',
            'color' => 'gray',
            'icon' => 'heroicon-o-arrow-down-left',
            'description' => 'Angolo inferiore sinistro',
        ],
        'bottom-right' => [
            'label' => 'In basso a destra',
            'color' => 'gray',
            'icon' => 'heroicon-o-arrow-down-right',
            'description' => 'Angolo inferiore destro',
        ],
    ],
];

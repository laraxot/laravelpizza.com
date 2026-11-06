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
        'text' => [
            'label' => 'Testo',
            'color' => 'gray',
            'icon' => 'heroicon-o-bars-3-bottom-left',
            'description' => 'Campo di testo su una riga',
        ],
        'email' => [
            'label' => 'Email',
            'color' => 'info',
            'icon' => 'heroicon-o-envelope',
            'description' => 'Indirizzo di posta elettronica',
        ],
        'textarea' => [
            'label' => 'Testo lungo',
            'color' => 'gray',
            'icon' => 'heroicon-o-bars-4',
            'description' => 'Campo di testo su piu righe',
        ],
        'select' => [
            'label' => 'Elenco',
            'color' => 'info',
            'icon' => 'heroicon-o-chevron-up-down',
            'description' => 'Selezione da un elenco',
        ],
        'radio' => [
            'label' => 'Scelta singola',
            'color' => 'info',
            'icon' => 'heroicon-o-radio',
            'description' => 'Una sola opzione fra piu alternative',
        ],
        'checkbox' => [
            'label' => 'Casella',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'description' => 'Casella di spunta',
        ],
        'date' => [
            'label' => 'Data',
            'color' => 'warning',
            'icon' => 'heroicon-o-calendar-days',
            'description' => 'Selezione di una data',
        ],
        'time' => [
            'label' => 'Ora',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'description' => 'Selezione di un orario',
        ],
        'datetime' => [
            'label' => 'Data e ora',
            'color' => 'warning',
            'icon' => 'heroicon-o-calendar',
            'description' => 'Selezione di data e ora',
        ],
    ],
];

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
        'telegram' => [
            'label' => 'Telegram',
            'color' => 'info',
            'icon' => 'heroicon-o-paper-airplane',
            'description' => 'Driver Telegram predefinito',
        ],
        'botapi' => [
            'label' => 'Bot API',
            'color' => 'gray',
            'icon' => 'heroicon-o-cpu-chip',
            'description' => 'Bot API di Telegram',
        ],
        'laravel-telegram' => [
            'label' => 'Laravel Telegram',
            'color' => 'success',
            'icon' => 'heroicon-o-cube',
            'description' => 'Pacchetto laravel-telegram',
        ],
    ],
];

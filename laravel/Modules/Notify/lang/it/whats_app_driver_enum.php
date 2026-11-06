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
        'twilio' => [
            'label' => 'Twilio',
            'color' => 'danger',
            'icon' => 'heroicon-o-phone',
            'description' => 'Gateway Twilio',
        ],
        'messagebird' => [
            'label' => 'MessageBird',
            'color' => 'info',
            'icon' => 'heroicon-o-paper-airplane',
            'description' => 'Gateway MessageBird',
        ],
        'vonage' => [
            'label' => 'Vonage',
            'color' => 'warning',
            'icon' => 'heroicon-o-signal',
            'description' => 'Gateway Vonage',
        ],
        'infobip' => [
            'label' => 'Infobip',
            'color' => 'success',
            'icon' => 'heroicon-o-globe-alt',
            'description' => 'Gateway Infobip',
        ],
    ],
];

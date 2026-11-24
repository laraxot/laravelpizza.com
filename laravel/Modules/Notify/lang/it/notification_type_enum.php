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
        'email' => [
            'label' => 'Email',
            'color' => 'info',
            'icon' => 'heroicon-o-envelope',
            'description' => 'Notifica via posta elettronica',
        ],
        'sms' => [
            'label' => 'SMS',
            'color' => 'warning',
            'icon' => 'heroicon-o-device-phone-mobile',
            'description' => 'Notifica via messaggio breve',
        ],
        'push' => [
            'label' => 'Push',
            'color' => 'success',
            'icon' => 'heroicon-o-bell-alert',
            'description' => 'Notifica push su dispositivo',
        ],
    ],
];

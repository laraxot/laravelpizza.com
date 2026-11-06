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
        'google' => [
            'label' => 'Google',
            'color' => 'danger',
            'icon' => 'heroicon-o-globe-alt',
            'description' => 'Accesso con account Google',
        ],
        'auth0' => [
            'label' => 'Auth0',
            'color' => 'warning',
            'icon' => 'heroicon-o-key',
            'description' => 'Accesso tramite Auth0',
        ],
    ],
];

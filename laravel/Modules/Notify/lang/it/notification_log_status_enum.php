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
        'pending' => [
            'label' => 'In attesa',
            'color' => 'gray',
            'icon' => 'heroicon-o-clock',
            'description' => 'Presa in carico, non ancora inviata',
        ],
        'processing' => [
            'label' => 'In elaborazione',
            'color' => 'warning',
            'icon' => 'heroicon-o-arrow-path',
            'description' => 'Invio in corso presso il provider',
        ],
        'sent' => [
            'label' => 'Inviata',
            'color' => 'info',
            'icon' => 'heroicon-o-paper-airplane',
            'description' => 'Consegnata al provider',
        ],
        'delivered' => [
            'label' => 'Consegnata',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'description' => 'Il provider conferma la consegna',
        ],
        'failed' => [
            'label' => 'Fallita',
            'color' => 'danger',
            'icon' => 'heroicon-o-exclamation-triangle',
            'description' => 'Invio non riuscito',
        ],
        'opened' => [
            'label' => 'Aperta',
            'color' => 'success',
            'icon' => 'heroicon-o-envelope-open',
            'description' => 'Il destinatario ha aperto il messaggio',
        ],
        'clicked' => [
            'label' => 'Cliccata',
            'color' => 'success',
            'icon' => 'heroicon-o-cursor-arrow-rays',
            'description' => 'Il destinatario ha cliccato un link',
        ],
    ],
];

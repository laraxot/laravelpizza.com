<?php

declare(strict_types=1);

/*
 * Chiavi lette da Modules\Xot\Traits\EnumTrait tramite TransTrait::transClass():
 * `<modulo>::<snake(NomeClasse)>.values.<valore>.<attributo>`.
 */

return [
    'values' => [
        'pending' => [
            'label' => 'In attesa',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'description' => 'Proposta in attesa di conferma umana',
        ],
        'cancelled' => [
            'label' => 'Annullata',
            'color' => 'gray',
            'icon' => 'heroicon-o-x-circle',
            'description' => 'Proposta annullata da un utente',
        ],
        'confirmed' => [
            'label' => 'Confermata',
            'color' => 'info',
            'icon' => 'heroicon-o-check',
            'description' => 'Proposta confermata, in esecuzione',
        ],
        'executed' => [
            'label' => 'Eseguita',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'description' => 'Azione eseguita con successo',
        ],
        'failed' => [
            'label' => 'Fallita',
            'color' => 'danger',
            'icon' => 'heroicon-o-exclamation-triangle',
            'description' => 'Esecuzione non riuscita o handler assente',
        ],
    ],
];

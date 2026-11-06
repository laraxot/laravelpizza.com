<?php

declare(strict_types=1);

/*
 * Chiavi lette da Modules\Xot\Traits\EnumTrait tramite TransTrait::transClass():
 * `<modulo>::<snake(NomeClasse)>.values.<valore>.<attributo>`.
 */

return [
    'values' => [
        'user' => [
            'label' => 'Utente',
            'color' => 'primary',
            'icon' => 'heroicon-o-user',
            'description' => 'Messaggio scritto dall\'utente',
        ],
        'assistant' => [
            'label' => 'Assistente',
            'color' => 'info',
            'icon' => 'heroicon-o-sparkles',
            'description' => 'Risposta generata dall\'assistente AI',
        ],
        'tool' => [
            'label' => 'Tool',
            'color' => 'warning',
            'icon' => 'heroicon-o-wrench-screwdriver',
            'description' => 'Risultato di una chiamata a tool',
        ],
        'system' => [
            'label' => 'Sistema',
            'color' => 'gray',
            'icon' => 'heroicon-o-cog-6-tooth',
            'description' => 'Istruzioni di sistema per il modello',
        ],
    ],
];

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
        'image' => [
            'label' => 'Immagine',
            'color' => 'info',
            'icon' => 'heroicon-o-photo',
            'description' => 'File immagine allegato',
        ],
        'video' => [
            'label' => 'Video',
            'color' => 'warning',
            'icon' => 'heroicon-o-video-camera',
            'description' => 'File video allegato',
        ],
        'document' => [
            'label' => 'Documento',
            'color' => 'gray',
            'icon' => 'heroicon-o-document-text',
            'description' => 'Documento allegato',
        ],
        'manual' => [
            'label' => 'Manuale',
            'color' => 'success',
            'icon' => 'heroicon-o-book-open',
            'description' => 'Manuale o guida allegata',
        ],
    ],
];

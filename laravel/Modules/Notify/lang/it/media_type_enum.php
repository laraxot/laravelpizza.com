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
            'description' => 'Contenuto immagine',
        ],
        'video' => [
            'label' => 'Video',
            'color' => 'warning',
            'icon' => 'heroicon-o-video-camera',
            'description' => 'Contenuto video',
        ],
        'document' => [
            'label' => 'Documento',
            'color' => 'gray',
            'icon' => 'heroicon-o-document-text',
            'description' => 'Contenuto documentale',
        ],
        'audio' => [
            'label' => 'Audio',
            'color' => 'success',
            'icon' => 'heroicon-o-musical-note',
            'description' => 'Contenuto audio',
        ],
    ],
];

<?php

declare(strict_types=1);
/*
 * Chiavi lette da Modules\Xot\Traits\EnumTrait tramite TransTrait::transClass():
 * la chiave e' `cms::attachment_disk_enum.values.<valore>.<attributo>`.
 * Senza queste voci getLabel()/getColor()/getIcon()/getDescription() di
 * Modules\Cms\Enums\AttachmentDiskEnum restituiscono 'fix:<chiave>', che finisce a video
 * nella select `disk` di AttachmentForm.
 */

return [
    'values' => [
        'public_html' => [
            'label' => 'Sito pubblico',
            'color' => 'success',
            'icon' => 'heroicon-o-globe-alt',
            'description' => 'Radice pubblica del sito: i file sono raggiungibili via web',
        ],
        'videos' => [
            'label' => 'Video',
            'color' => 'info',
            'icon' => 'heroicon-o-video-camera',
            'description' => 'Cartella pubblica dei video',
        ],
        'local' => [
            'label' => 'Locale privato',
            'color' => 'gray',
            'icon' => 'heroicon-o-lock-closed',
            'description' => 'Storage locale privato: i file non sono raggiungibili via web',
        ],
    ],
];

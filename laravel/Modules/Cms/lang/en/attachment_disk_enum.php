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
            'label' => 'Public site',
            'color' => 'success',
            'icon' => 'heroicon-o-globe-alt',
            'description' => 'Public web root: files are reachable from the web',
        ],
        'videos' => [
            'label' => 'Videos',
            'color' => 'info',
            'icon' => 'heroicon-o-video-camera',
            'description' => 'Public videos folder',
        ],
        'local' => [
            'label' => 'Private local',
            'color' => 'gray',
            'icon' => 'heroicon-o-lock-closed',
            'description' => 'Private local storage: files are not reachable from the web',
        ],
    ],
];

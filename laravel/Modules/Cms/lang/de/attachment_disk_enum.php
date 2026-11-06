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
            'label' => 'Öffentliche Website',
            'color' => 'success',
            'icon' => 'heroicon-o-globe-alt',
            'description' => 'Öffentliches Web-Stammverzeichnis: Dateien sind per Web erreichbar',
        ],
        'videos' => [
            'label' => 'Videos',
            'color' => 'info',
            'icon' => 'heroicon-o-video-camera',
            'description' => 'Öffentlicher Videoordner',
        ],
        'local' => [
            'label' => 'Privat lokal',
            'color' => 'gray',
            'icon' => 'heroicon-o-lock-closed',
            'description' => 'Privater lokaler Speicher: Dateien sind nicht per Web erreichbar',
        ],
    ],
];

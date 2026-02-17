<?php

declare(strict_types=1);

return [
    'breadcrumb' => 'Geçmiş',
    'title' => ':record Geçmişi',
    'default_datetime_format' => 'd.m.Y, H:i:s',
    'table' => [
        'field' => 'Alan',
        'old' => 'Eski Değer',
        'new' => 'Yeni Değer',
        'restore' => 'Geri Yükle',
    ],
    'events' => [
        'updated' => 'Güncellendi',
        'created' => 'Oluşturuldu',
        'deleted' => 'Silindi',
        'restored' => 'Geri Yüklendi',
        'restore_successful' => 'Başarıyla Geri Yüklendi',
        'restore_failed' => 'Geri Yükleme Başarısız',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
];

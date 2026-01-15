<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'تبديل تخطيط الجدول',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'تبديل التخطيط',
                'tooltip' => 'التبديل بين عرض القائمة وعرض الشبكة',
                'helper_text' => 'تغيير نوع العرض',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'التخطيط',
            'placeholder' => 'اختر نوع التخطيط',
            'tooltip' => 'اختر بين عرض القائمة وعرض الشبكة',
            'help' => 'اختر نوع التخطيط المناسب لعرض البيانات',
        ],
    ],
];

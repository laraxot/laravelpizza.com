<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'title' => 'إدارة المستخدمين',
            'roles' => [
                'all' => 'جميع الأدوار',
                'create' => 'إنشاء دور جديد',
                'edit' => 'تعديل دور',
                'management' => 'إدارة الأدوار',
                'main' => 'أدوار المتسخدمين',
            ],
            'users' => [
                'all' => 'جميع المستخدمين',
                'change-password' => 'تغيير كلمة السر',
                'create' => 'إنشاء مستخدم جديد',
                'deactivated' => 'المستخدمون المعطلون',
                'deleted' => 'المستخدمون المحذفون',
                'edit' => 'تعديل مستخدم',
                'main' => 'المستخدمين',
                'view' => 'View User',
            ],
        ],
        'log-viewer' => [
            'main' => 'عارض السجلات',
            'dashboard' => 'اللوحة الرئيسية',
            'logs' => 'السجلات',
        ],
        'sidebar' => [
            'dashboard' => 'اللوحة الرئيسية',
            'general' => 'عام',
            'system' => 'System',
        ],
    ],
    'language-picker' => [
        'language' => 'اللغة',
        'langs' => [
            'ar' => 'العربية (Arabic)',
            'da' => 'الدنماركية (Danish)',
            'de' => 'الألمانية (German)',
            'el' => '(Greek)',
            'en' => 'الإنجليزية (English)',
            'es' => 'الأسبانية (Spanish)',
            'fr' => 'الفرنسية (French)',
            'it' => 'الإيطالية (Italian)',
            'nl' => 'هولندي (Dutch)',
            'pt_BR' => 'البرازيلية البرتغالية (Brazilian Portuguese)',
            'sv' => 'السويسرية (Swedish)',
            'th' => 'Thai',
        ],
    ],
];

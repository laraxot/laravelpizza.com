<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'title' => 'การจัดการผู้ใช้และสิทธิ์',
            'roles' => [
                'all' => 'บทบาททั้งหมด',
                'create' => 'สร้างบทบาท',
                'edit' => 'แก้ไขบทบาท',
                'management' => 'การจัดการบทบาท',
                'main' => 'บทบาท',
            ],
            'users' => [
                'all' => 'ผู้ใช้ทั้งหมด',
                'change-password' => 'เปลี่ยนรหัสผ่าน',
                'create' => 'สร้างผู้ใช้',
                'deactivated' => 'ผู้ใช้ที่ถูกพักการใช้งาน',
                'deleted' => 'ผู้ใช้ที่ถูกลบ',
                'edit' => 'แก้ไขผู้ใช้',
                'main' => 'ผู้ใช้',
                'view' => 'แสดงผู้ใช้',
            ],
        ],
        'log-viewer' => [
            'main' => 'แสดงข้อมูล Log',
            'dashboard' => 'แผงควบคุม',
            'logs' => 'รายการล็อก',
        ],
        'sidebar' => [
            'dashboard' => 'แผงควบคุม',
            'general' => 'ทั่วไป',
            'system' => 'ระบบ',
        ],
    ],
    'language-picker' => [
        'language' => 'ภาษา',
        'langs' => [
            'ar' => 'อารบิก (Arabic)',
            'da' => 'เดนมา์ก (Danish)',
            'de' => 'เยอรมัน (German)',
            'el' => '(Greek)',
            'en' => 'อังกฤษ (English)',
            'es' => 'สเปน (Spanish)',
            'fr' => 'ฝรั่งเศส (French)',
            'it' => 'อิตาลี (Italian)',
            'nl' => 'ดัตช์ (Dutch)',
            'pt_BR' => 'โปรตุเกสแบบบราซิล (Brazilian Portuguese)',
            'sv' => 'สวีเดน (Swedish)',
            'th' => 'ไทย (Thai)',
        ],
    ],
];

<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'users' => [
                'activate' => 'เปิดใช้งาน',
                'change_password' => 'เปลี่ยนรหัสผ่าน',
                'deactivate' => 'พักการใช้งาน',
                'delete_permanently' => 'ลบอย่างถาวร',
                'login_as' => 'เข้าสู่ระบบเสมือนเป็น :user',
                'resend_email' => 'ส่งอีเมลยืนยันตัวตนอีกครั้ง',
                'restore_user' => 'กู้คืนผู้ใช้',
            ],
        ],
    ],
    'emails' => [
        'auth' => [
            'confirm_account' => 'ยืนยันบัญชี',
            'reset_password' => 'ตั้งรหัสผ่านใหม่',
        ],
    ],
    'general' => [
        'cancel' => 'ยกเลิก',
        'crud' => [
            'create' => 'สร้าง',
            'delete' => 'ลบ',
            'edit' => 'แก้ไข',
            'update' => 'ปรับปรุง',
            'view' => 'แสดง',
        ],
        'save' => 'บันทึก',
        'view' => 'แสดง',
    ],
];

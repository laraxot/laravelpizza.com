<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'users' => [
                'activate' => 'تفعيل',
                'change_password' => 'تغيير كلمة المرور',
                'deactivate' => 'تعطيل',
                'delete_permanently' => 'حذف نهائي',
                'login_as' => 'تسجيل الدخول كـ :user',
                'resend_email' => 'إعادة إرسالة بريد التفعيل',
                'restore_user' => 'إستعادة المستخدم',
            ],
        ],
    ],
    'emails' => [
        'auth' => [
            'confirm_account' => 'Confirm Account',
            'reset_password' => 'Reset Password',
        ],
    ],
    'general' => [
        'cancel' => 'إلغاء',
        'crud' => [
            'create' => 'إنشاء',
            'delete' => 'حذف',
            'edit' => 'تعديل',
            'update' => 'تحديث',
            'view' => 'View',
        ],
        'save' => 'حفظ',
        'view' => 'عرض',
    ],
];

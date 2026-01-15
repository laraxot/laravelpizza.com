<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'الاسم',
            'placeholder' => 'أدخل الاسم',
            'help' => 'اسم تعريف العنصر',
            'description' => 'اسم الكائن',
            'helper_text' => '',
        ],
        'edit-name' => [
            'label' => 'تعديل الاسم',
            'placeholder' => 'اسم جديد',
            'help' => 'تعديل الاسم الموجود',
            'description' => 'إجراء لتعديل الاسم',
            'helper_text' => '',
        ],
        'change-state' => [
            'label' => 'تغيير الحالة',
            'placeholder' => 'اختر حالة جديدة',
            'help' => 'تعديل الحالة الحالية',
            'description' => 'إجراء لتغيير الحالة',
            'helper_text' => '',
        ],
        'state' => [
            'label' => 'الحالة',
            'placeholder' => 'اختر حالة',
            'help' => 'الحالة الحالية للعنصر',
            'description' => 'حالة النظام الحالية',
            'helper_text' => '',
        ],
        'message' => [
            'label' => 'الرسالة',
            'placeholder' => 'أدخل رسالة',
            'help' => 'رسالة إعلامية',
            'description' => 'نص الرسالة',
            'helper_text' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'مثيل حالة غير صالح',
        'record_not_found' => 'السجل غير موجود',
        'transition_completed' => [
            'title' => 'اكتمل الانتقال',
            'body' => 'تم إكمال انتقال الحالة بنجاح',
        ],
        'transition_error' => [
            'title' => 'خطأ في الانتقال',
        ],
    ],
];

<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'تأكيد كلمة المرور',
    'description' => 'الرجاء تأكيد كلمة المرور الخاصة بك لإكمال هذا الإجراء.',
    'current_password' => 'كلمة المرور الحالية',
  ),
  'two_factor' => 
  array (
    'heading' => 'المصادقة الثنائية',
    'description' => '\'الرجاء تأكيد الدخول إلى حسابك عبر إدخال رمز المصادقة الموضح في تطبيق التوثيق الخاص بك.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'المصادقة الثنائية',
      'description' => 'الرجاء تأكيد الدخول إلى حسابك عبر إدخال أحد رموز الاستعادة  الخاصة بالحالات الطارئة.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'فقدت جهازك؟',
    'recovery_code_link' => 'استخدم رمز الاستعادة',
    'back_to_login_link' => 'العودة إلى شاشة الدخول',
  ),
  'profile' => 
  array (
    'account' => 'الحساب',
    'profile' => 'الملف الشخصي',
    'my_profile' => 'ملفي الشخصي',
    'subheading' => 'إدارة ملف التعريف الخاص بك',
    'personal_info' => 
    array (
      'heading' => 'البيانات الشخصية',
      'subheading' => 'قم بإدارة بياناتك الشخصية.',
      'submit' => 
      array (
        'label' => 'تحديث',
      ),
      'notify' => 'تم تحديث بياناتك الشخصية بنجاح!',
    ),
    'password' => 
    array (
      'heading' => 'كلمة المرور',
      'subheading' => 'يجب أن تتألف كلمة المرور من 8 خانات على الأقل.',
      'submit' => 
      array (
        'label' => 'تحديث',
      ),
      'notify' => 'تم تحديث كلمة المرور بنجاح!',
    ),
    '2fa' => 
    array (
      'title' => 'المصادقة الثنائية',
      'description' => 'إدارة المصادقة الثنائية (موصى به).',
      'actions' => 
      array (
        'enable' => 'تفعيل',
        'regenerate_codes' => 'إعادة إنشاء الرموز',
        'disable' => 'إلغاء التفعيل',
        'confirm_finish' => 'تأكيد وإنهاء',
        'cancel_setup' => 'إلغاء الإعداد',
      ),
      'setup_key' => 'مفتاح الإعداد',
      'must_enable' => 'يجب عليك تفعيل المصادقة الثنائية لإستخدام هذا التطبيق.',
      'not_enabled' => 
      array (
        'title' => 'لم تقم بتفعيل المصادقة الثنائية.',
        'description' => 'عند تفعيل المصادقة الثنائية، ستتم مطالبتك برمز آمن عشوائي أثناء المصادقة. يمكنك الحصول على هذا الرمز من خلال تطبيق Google Authenticator على هاتفك.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'إنهاء تفعيل المصادقة الثنائية.',
        'description' => 'لإنهاء تفعيل المصادقة الثنائية، قم بمسح رمز QR التالي مستخدماً تطبيق المصادقة على هاتفك أو بإدخال مفتاح الإعداد ومن ثم كتابة رمز OTP الذي تم إنشاؤه.',
      ),
      'enabled' => 
      array (
        'notify' => 'تم تفعيل المصادقة الثنائية.',
        'title' => 'لقد قمت بتفعيل المصادقة الثنائية!',
        'description' => 'المصادقة الثنائية مفعّلة حالياً. هذا الأمر سيساعدك على حماية حسابك.',
        'store_codes' => 'هذه الأكواد سيتم استخدامها لاستعادة حسابك إذا فقدت جهازك. تحذير! سيتم عرض هذه الأكواد مرة واحدة فقط.',
      ),
      'disabling' => 
      array (
        'notify' => 'تم إلغاء تفعيل المصادقة الثنائية.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'تم إنشاء رموز استعادة جديدة.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'تم التحقق من الرمز. تم تفعيل المصادقة الثنائية.',
        'invalid_code' => 'الرمز الذي أدخلته غير صحيح.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'رموز API',
      'description' => 'إدارة رموز API التي تسمح للخدمات الطرفية بالوصول إلى هذا التطبيق نيابة عنك.',
      'create' => 
      array (
        'notify' => 'تم إنشاء رمز API بنجاح!',
        'message' => 'يتم عرض رمز API الخاص بك مرة واحدة فقط. إذا فقدت رمزك، ستحتاج إلى إنشاء رمز جديد.',
        'submit' => 
        array (
          'label' => 'إنشاء',
        ),
      ),
      'update' => 
      array (
        'notify' => 'تم تحديث رمز API بنجاح!',
      ),
      'copied' => 
      array (
        'label' => 'قمت بنسخ الرمز الخاص بي',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'نسخ إلى الحافظة',
    'tooltip' => 'تم النسخ!',
  ),
  'fields' => 
  array (
    'avatar' => 
    array (
      'label' => 'الصورة الرمزية',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'البريد الإليكتروني',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'تسجيل الدخول',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'الإسم',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'كلمة المرور',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'تأكيد كلمة المرور',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'كلمة مرور جديدة',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'تأكيد كلمة المرور',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'اسم الرمز',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'انتهاء صلاحية الرمز',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'الصلاحيات',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'الرمز',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'رمز الاستعادة',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'تاريخ الإنشاء',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'تاريخ الإنتهاء',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'أو',
  'cancel' => 'إلغاء',
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'actions' => 
  array (
  ),
);

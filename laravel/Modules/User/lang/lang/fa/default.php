<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'تأیید رمز عبور',
    'description' => 'لطفاً رمز عبور خود را برای تکمیل این عملیات تأیید کنید.',
    'current_password' => 'رمز عبور فعلی',
  ),
  'two_factor' => 
  array (
    'heading' => 'چالش دو مرحله‌ای',
    'description' => 'لطفاً با وارد کردن کد احراز هویت ارائه شده توسط برنامه تأیید کننده، دسترسی خود به حساب کاربری را تأیید کنید.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'چالش دو مرحله‌ای',
      'description' => 'لطفاً با وارد کردن یکی از کدهای اضطراری بازیابی، دسترسی خود به حساب کاربری را تأیید کنید.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'دستگاهتان گم شده؟',
    'recovery_code_link' => 'استفاده از کد بازیابی',
    'back_to_login_link' => 'بازگشت به صفحه ورود',
  ),
  'profile' => 
  array (
    'account' => 'حساب کاربری',
    'profile' => 'پروفایل',
    'my_profile' => 'پروفایل من',
    'subheading' => 'پروفایل کاربری خود را در اینجا مدیریت کنید.',
    'personal_info' => 
    array (
      'heading' => 'اطلاعات شخصی',
      'subheading' => 'اطلاعات شخصی خود را مدیریت کنید.',
      'submit' => 
      array (
        'label' => 'به‌روزرسانی',
      ),
      'notify' => 'پروفایل با موفقیت به‌روزرسانی شد!',
    ),
    'password' => 
    array (
      'heading' => 'رمز عبور',
      'subheading' => 'باید حداقل ۸ کاراکتر باشد.',
      'submit' => 
      array (
        'label' => 'به‌روزرسانی',
      ),
      'notify' => 'رمز عبور با موفقیت به‌روزرسانی شد!',
    ),
    '2fa' => 
    array (
      'title' => 'احراز هویت دو مرحله‌ای',
      'description' => 'مدیریت احراز هویت دو مرحله‌ای برای حساب کاربری خود (توصیه می‌شود).',
      'actions' => 
      array (
        'enable' => 'فعال سازی',
        'regenerate_codes' => 'تجدید کدها',
        'disable' => 'غیرفعال سازی',
        'confirm_finish' => 'تأیید و پایان',
        'cancel_setup' => 'لغو راه‌اندازی',
      ),
      'setup_key' => 'کلید راه‌اندازی',
      'must_enable' => 'برای استفاده از این برنامه باید احراز هویت دو مرحله‌ای را فعال کنید.',
      'not_enabled' => 
      array (
        'title' => 'شما احراز هویت دو مرحله‌ای را فعال نکرده‌اید.',
        'description' => 'هنگام فعال کردن احراز هویت دو مرحله‌ای، هنگام ورود به سیستم به شما درخواست یک توکن امن و تصادفی می‌شود. این توکن را می‌توانید از برنامه احراز هویت گوگل در تلفن همراه خود دریافت کنید.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'پایان دادن به فعال‌سازی احراز هویت دو مرحله‌ای.',
        'description' => 'برای پایان دادن به فعال‌سازی احراز هویت دو مرحله‌ای، کد QR زیر را با استفاده از برنامه احراز هویت تلفن همراه خود اسکن کنید یا کلید راه‌اندازی را وارد کرده و کد OTP تولید شده را وارد کنید.',
      ),
      'enabled' => 
      array (
        'notify' => 'احراز هویت دو مرحله‌ای فعال شد.',
        'title' => 'شما احراز هویت دو مرحله‌ای را فعال کرده‌اید!',
        'description' => 'احراز هویت دو مرحله‌ای هم‌اکنون فعال است. این کمک می‌کند تا حساب کاربری شما ایمن‌تر شود.',
        'store_codes' => 'این کدها می توانند برای بازیابی دسترسی به حساب شما در صورت گم شدن دستگاه استفاده شوند. هشدار! این کدها فقط یک بار نمایش داده می شوند.',
      ),
      'disabling' => 
      array (
        'notify' => 'احراز هویت دو مرحله‌ای غیرفعال شده است.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'کدهای بازیابی جدید ایجاد شده است.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'کد تأیید شد. احراز هویت دو مرحله‌ای فعال شد.',
        'invalid_code' => 'کد وارد شده نامعتبر است.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'توکن‌های API',
      'description' => 'توکن‌های API را مدیریت کنید که به سرویس‌های شخص ثالث اجازه می‌دهند از طرف شما به این برنامه دسترسی داشته باشند.',
      'create' => 
      array (
        'notify' => 'توکن با موفقیت ایجاد شد!',
        'message' => 'توکن شما تنها یک بار پس از ایجاد نشان داده می شود. اگر توکن خود را گم کردید، باید آن را حذف کرده و یک توکن جدید ایجاد کنید.',
        'submit' => 
        array (
          'label' => 'ايجاد',
        ),
      ),
      'update' => 
      array (
        'notify' => 'توکن با موفقیت به روز شد!',
      ),
      'copied' => 
      array (
        'label' => 'من توکنم رو کپی کردم',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'کپی به کلیپ‌بورد',
    'tooltip' => 'کپی شد!',
  ),
  'fields' => 
  array (
    'avatar' => 
    array (
      'label' => 'آواتار',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'ایمیل',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'ورود',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'نام',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'رمز عبور',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'تایید رمز عبور',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'رمز عبور جدید',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'تایید رمز عبور جدید',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'نام توکن',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'انقضاء توکن',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'توانایی ها',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'کد',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'کد بازیابی',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'ایجاد شده',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'انقضاء',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'یا',
  'cancel' => 'لغو',
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

<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Ім\'я користувача або електронна пошта',
    'forgot_password_link' => 'Забули пароль?',
    'create_an_account' => 'Створити акаунт',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Підтвердити пароль',
    'description' => 'Будь ласка, підтвердіть свій пароль для завершення цієї дії.',
    'current_password' => 'Поточний пароль',
  ),
  'two_factor' => 
  array (
    'heading' => 'Двофакторна аутентифікація',
    'description' => 'Будь ласка, підтвердіть доступ, ввівши пароль із додатка',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Двофакторна аутентифікація',
      'description' => 'Будь ласка, підтвердьте доступ до вашого облікового запису, ввівши один із ваших аварійних кодів відновлення.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Втратили пристрій?',
    'recovery_code_link' => 'Використати код відновлення',
    'back_to_login_link' => 'Повернутися до входу',
  ),
  'profile' => 
  array (
    'account' => 'Обліковий запис',
    'profile' => 'Профіль',
    'my_profile' => 'Мій профіль',
    'subheading' => 'Керуйте своїм профілем користувача тут.',
    'personal_info' => 
    array (
      'heading' => 'Особиста інформація',
      'subheading' => 'Керуйте своєю особистою інформацією.',
      'submit' => 
      array (
        'label' => 'Оновити',
      ),
      'notify' => 'Профіль успішно оновлено!',
    ),
    'password' => 
    array (
      'heading' => 'Пароль',
      'subheading' => 'Мінімум 8 символів.',
      'submit' => 
      array (
        'label' => 'Оновити',
      ),
      'notify' => 'Пароль успішно оновлено!',
    ),
    '2fa' => 
    array (
      'title' => 'Двофакторна аутентифікація',
      'description' => 'Керуйте двофакторною аутентифікацією для вашого облікового запису (рекомендується).',
      'actions' => 
      array (
        'enable' => 'Увімкнути',
        'regenerate_codes' => 'Згенерувати коди відновлення',
        'disable' => 'Вимкнути',
        'confirm_finish' => 'Підтвердити і завершити',
        'cancel_setup' => 'Скасувати налаштування',
      ),
      'setup_key' => 'Ключ налаштування',
      'must_enable' => 'Ви повинні увімкнути двофакторну аутентифікацію, щоб використовувати цю програму.',
      'not_enabled' => 
      array (
        'title' => 'Ви не увімкнули двофакторну аутентифікацію.',
        'description' => 'Коли двофакторна аутентифікація увімкнена, вам буде запропоновано ввести безпечний, випадковий токен під час аутентифікації. Ви можете отримати цей токен з програми Google Authenticator на вашому телефоні.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Завершити увімкнення двофакторної аутентифікації.',
        'description' => 'Щоб завершити увімкнення двофакторної аутентифікації, скануйте наступний QR-код за допомогою програми-аутентифікатора на вашому телефоні або введіть ключ налаштування та надайте згенерований OTP код.',
      ),
      'enabled' => 
      array (
        'notify' => 'Двофакторна аутентифікація увімкнена.',
        'title' => 'Ви увімкнули двофакторну аутентифікацію!',
        'description' => 'Двофакторна аутентифікація тепер увімкнена. Це допоможе зробити ваш обліковий запис більш захищеним.',
        'store_codes' => 'Ці коди можна використовувати для відновлення доступу до вашого облікового запису, якщо ваш пристрій буде втрачено. Увага! Ці коди будуть показані лише один раз.',
      ),
      'disabling' => 
      array (
        'notify' => 'Двофакторну аутентифікацію вимкнено.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'Нові коди відновлення згенеровані.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Код підтверджено. Двофакторна аутентифікація увімкнена.',
        'invalid_code' => 'Введений вами код недійсний.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API Токени',
      'description' => 'Керуйте токенами API, які дозволяють стороннім службам отримувати доступ до цього додатка від вашого імені.',
      'create' => 
      array (
        'notify' => 'Токен успішно створено!',
        'message' => 'Ваш токен відображається лише один раз при створенні. Якщо ви втратите свій токен, вам потрібно буде видалити його і створити новий.',
        'submit' => 
        array (
          'label' => 'Створити',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Токен успішно оновлено!',
      ),
      'copied' => 
      array (
        'label' => 'Я скопіював свій токен',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Копіювати в буфер обміну',
    'tooltip' => 'Скопійовано!',
  ),
  'fields' => 
  array (
    'avatar' => 
    array (
      'label' => 'Аватар',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'E-mail',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Логін',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Ім\'я',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Пароль',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Підтвердження пароля',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Новий пароль',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Підтвердження пароля',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Назва токена',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'Термін дії токена',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Доступ',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Код',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Код відновлення',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Створено',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Закінчується',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Або',
  'cancel' => 'Скасувати',
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

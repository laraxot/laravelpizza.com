<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Имя пользователя или электронная почта',
    'forgot_password_link' => 'Забыли пароль?',
    'create_an_account' => 'Создать аккаунт',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Подтвердите пароль',
    'description' => 'Для завершения этого действия подтвердите свой пароль.',
    'current_password' => 'Текущий пароль',
  ),
  'two_factor' => 
  array (
    'heading' => 'Двухфакторная аутентификация',
    'description' => 'Пожалуйста, подтвердите доступ, введя пароль из приложения',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Двухфакторная аутентификация',
      'description' => 'Пожалуйста, подтвердите доступ к вашей учетной записи, введя один из ваших кодов восстановления в экстренных случаях.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Утеряно устройство?',
    'recovery_code_link' => 'Использовать код восстановления',
    'back_to_login_link' => 'Вернуться на страницу входа',
  ),
  'registration' => 
  array (
    'title' => 'Регистрация',
    'heading' => 'Создать учетную запись',
    'submit' => 
    array (
      'label' => 'Отправить',
    ),
    'notification_unique' => 'Учетная запись с таким адресом уже существует. Пожалуйста, войдите',
  ),
  'reset_password' => 
  array (
    'title' => 'Забыли пароль',
    'heading' => 'Сбросить пароль',
    'submit' => 
    array (
      'label' => 'Подтвердить',
    ),
    'notification_error' => 'Ошибка: повторите попытку позже.',
    'notification_error_link_text' => 'Попробуйте еще раз',
    'notification_success' => 'Проверьте свой почтовый ящик для получения инструкций!',
  ),
  'verification' => 
  array (
    'title' => 'Проверить электронную почту',
    'heading' => 'Требуется подтверждение электронной почты',
    'submit' => 
    array (
      'label' => 'Выйти',
    ),
    'notification_success' => 'Проверьте почтовый ящик для получения инструкций',
    'notification_resend' => 'Письмо с подтверждением отправлено повторно.',
    'before_proceeding' => 'Прежде чем продолжить, проверьте электронную почту на наличие ссылки для подтверждения.',
    'not_receive' => 'Если вы не получили электронное письмо,',
    'request_another' => 'Нажмите здесь, чтобы запросить повторно.',
  ),
  'profile' => 
  array (
    'account' => 'Аккаунт',
    'profile' => 'Профиль',
    'my_profile' => 'Мой Профиль',
    'personal_info' => 
    array (
      'heading' => 'Личная информация',
      'subheading' => 'Управление вашей личной информацией',
      'submit' => 
      array (
        'label' => 'Обновить',
      ),
      'notify' => 'Обновление профиля успешно',
    ),
    'password' => 
    array (
      'heading' => 'Пароль',
      'subheading' => 'Должно быть минимум 8 символов.',
      'submit' => 
      array (
        'label' => 'Обновить',
      ),
      'notify' => 'Пароль успешно обновлен',
    ),
    '2fa' => 
    array (
      'title' => 'Двухфакторная аутентификация',
      'description' => 'Управление двухфакторной аутентификацией для вашей учетной записи (рекомендуется)',
      'actions' => 
      array (
        'enable' => 'Включить',
        'regenerate_codes' => 'Регенерировать коды',
        'disable' => 'Отключить',
        'confirm_finish' => 'Подтвердить и завершить',
        'cancel_setup' => 'Отменить',
      ),
      'setup_key' => 'Ключ настройки',
      'not_enabled' => 
      array (
        'title' => 'Вы не включили двухфакторную аутентификацию',
        'description' => 'Если включена двухфакторная аутентификация, вам будет предложено ввести безопасный токен во время аутентификации. Вы можете получить этот токен из Google Authenticator',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Завершить активацию двухфакторной аутентификации.',
        'description' => 'Чтобы завершить активацию двухфакторной аутентификации, отсканируйте QR-код через приложение для аутентификации или введите ключ настройки OTP-код',
      ),
      'enabled' => 
      array (
        'title' => 'Вы включили двухфакторную аутентификацию',
        'description' => 'Двухфакторная аутентификация теперь включена. Отсканируйте следующий QR-код с помощью приложения для аутентификации на телефоне или введите ключ настройки',
        'store_codes' => 'Сохраните эти коды восстановления в безопасном менеджере паролей. Их можно использовать для восстановления доступа к вашей учетной записи, если ваше устройство двухфакторной аутентификации потеряно.',
        'show_codes' => 'Показать коды восстановления',
        'hide_codes' => 'Скрыть коды восстановления',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Код подтвержден. Двухфакторная аутентификация включена.',
        'invalid_code' => 'Код, который вы ввели, недействителен.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API Токены',
      'description' => 'Управление токенами API, которые позволяют сторонним службам получать доступ к этому приложению от вашего имени. ПРИМЕЧАНИЕ. Ваш токен отображается один раз при создании. Если вы потеряете свой токен, вам нужно будет удалить его и создать новый',
      'create' => 
      array (
        'notify' => 'Токен успешно создан',
        'submit' => 
        array (
          'label' => 'Создать',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Токен успешно обновлен',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Скопировать в буфер обмена',
    'tooltip' => 'Скопировано!',
  ),
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'E-mail',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Имя пользователя',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Имя',
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
      'label' => 'Подтверждение пароля',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Новый пароль',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Подтверждение пароля',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Имя токена',
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
      'label' => 'Код восстановления',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Создано',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Истекает',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'или',
  'cancel' => 'Отмена',
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

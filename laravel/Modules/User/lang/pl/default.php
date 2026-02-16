<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Nazwa użytkownik lub email',
    'forgot_password_link' => 'Nie pamiętasz hasła?',
    'create_an_account' => 'załóż konto',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Potwierdź hasło',
    'description' => 'Proszę potwierdzić swoje hasło, aby ukończyć tę akcję.',
    'current_password' => 'Aktualne hasło',
  ),
  'two_factor' => 
  array (
    'heading' => 'Dwuetapowa weryfikacja',
    'description' => 'Proszę potwierdzić dostęp do swojego konta, wpisując kod uwierzytelniający dostarczony przez aplikację uwierzytelniającą.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Dwuetapowa weryfikacja',
      'description' => 'Proszę potwierdzić dostęp do swojego konta, wpisując jeden z kodów awaryjnych.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Utracono urządzenie?',
    'recovery_code_link' => 'Użyj kodu awaryjnego',
    'back_to_login_link' => 'Powrót do logowania',
  ),
  'registration' => 
  array (
    'title' => 'Rejestracja',
    'heading' => 'Utwórz nowe konto',
    'submit' => 
    array (
      'label' => 'Zarejestruj się',
    ),
    'notification_unique' => 'Konto z tym adresem email już istnieje. Proszę się zalogować.',
  ),
  'reset_password' => 
  array (
    'title' => 'Nie pamietasz hasła?',
    'heading' => 'Resetuj hasło',
    'submit' => 
    array (
      'label' => 'Odzyskaj hasło',
    ),
    'notification_error' => 'Wystąpił błąd podczas resetowania hasła. Spróbuj ponownie.',
    'notification_error_link_text' => 'Spróbuj ponownie',
    'notification_success' => 'Sprawdź swoją skrzynkę pocztową, aby uzyskać instrukcje dotyczące resetowania hasła.',
  ),
  'verification' => 
  array (
    'title' => 'Zweryfikuj adres email',
    'heading' => 'Weryfikacja adresu email wymagana',
    'submit' => 
    array (
      'label' => 'Wyloguj się',
    ),
    'notification_success' => 'Sprawdź swoją skrzynkę pocztową, aby uzyskać instrukcje dotyczące weryfikacji adresu email.',
    'notification_resend' => 'Nowy link weryfikacyjny został wysłany na Twój adres email.',
    'before_proceeding' => 'Zanim przejdziesz dalej, sprawdź swoją skrzynkę pocztową, aby uzyskać link weryfikacyjny.',
    'not_receive' => 'Jeśli nie otrzymałeś wiadomości email',
    'request_another' => 'kliknij tutaj, aby poprosić o kolejny',
  ),
  'profile' => 
  array (
    'account' => 'Konto',
    'profile' => 'Profil',
    'my_profile' => 'Mój profil',
    'personal_info' => 
    array (
      'heading' => 'Twoje dane osobowe.',
      'subheading' => 'Edytuj swoje dane osobowe.',
      'submit' => 
      array (
        'label' => 'Zapisz',
      ),
      'notify' => 'Dane osobowe zaktualizowane pomyślnie!',
    ),
    'password' => 
    array (
      'heading' => 'Twoje hasło.',
      'subheading' => 'Hasło powinno składać się przynajmniej 8 znaków.',
      'submit' => 
      array (
        'label' => 'Zapisz',
      ),
      'notify' => 'Hasło zostało zaktualizowane pomyślnie!',
    ),
    '2fa' => 
    array (
      'title' => 'Weryfikacja dwuetapowa',
      'description' => 'Zarządzaj weryfikacją dwuetapową swojego konta. (rekomendowane)',
      'actions' => 
      array (
        'enable' => 'Włącz',
        'regenerate_codes' => 'Wygeneruj nowe kody',
        'disable' => 'Wyłącz',
        'confirm_finish' => 'Potwierdź i zapisz',
        'cancel_setup' => 'Anuluj',
      ),
      'setup_key' => 'Klucz konfiguracji',
      'not_enabled' => 
      array (
        'title' => 'Weryfikacja dwuetapowa nie jest włączona.',
        'description' => 'Weryfikacja dwuetapowa dodaje dodatkową warstwę bezpieczeństwa do Twojego konta. Po włączeniu tej funkcji, podczas logowania będziesz musiał podać kod weryfikacyjny, który jest generowany przez aplikację na Twoim urządzeniu.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Potwierdź weryfikację dwuetapową',
        'description' => 'Aby zakończyć włączanie weryfikacji dwuetapowej, musisz zeskanować poniższy kod QR za pomocą aplikacji uwierzytelniającej na swoim urządzeniu. Jeśli nie możesz zeskanować kodu QR, możesz wprowadzić klucz konfiguracji ręcznie.',
      ),
      'enabled' => 
      array (
        'title' => 'Weryfikacja dwuetapowa jest włączona',
        'description' => 'Weryfikacja dwuetapowa dodaje dodatkową warstwę bezpieczeństwa do Twojego konta.',
        'store_codes' => 'Zapisz te kody w bezpiecznym miejscu. Możesz je użyć, aby uzyskać dostęp do konta, jeśli utracisz dostęp do urządzenia uwierzytelniającego.',
        'show_codes' => 'Pokaż kody odzyskiwania',
        'hide_codes' => 'Ukryj kody odzyskiwania',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Kod zweryfikowany pomyślnie! Weryfikacja dwuetapowa została włączona.',
        'invalid_code' => 'Wprowadzony kod jest nieprawidłowy.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'Tokeny API',
      'description' => 'Zarządzaj tokenami API, które pozwalają aplikacjom na dostęp do Twojego konta innym aplikacjom. (Jeżeli stracisz swój token, musisz najpierw go usunąć aby wygenerować nowy.)',
      'create' => 
      array (
        'notify' => 'Token stworzony pomyślnie!',
        'submit' => 
        array (
          'label' => 'Stwórz token',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token zaktualizowany pomyślnie!',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Skopiuj do schowka',
    'tooltip' => 'Skopiowano!',
  ),
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'Email',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Login',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nazwa użytkownika',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Hasło',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Potwierdź hasło',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Nowe hasło',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Potwierdź nowe hasło',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Nazwa tokenu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Możliwości',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Kod weryfikacji dwuetapowej',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Kod odzyskiwania weryfikacji dwuetapowej',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Utworzono',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Wygasa',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Lub',
  'cancel' => 'Anuluj',
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

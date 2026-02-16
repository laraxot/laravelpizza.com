<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'Potvrdit heslo',
    'description' => 'Pro dokončení vyplňte potvrďte heslo.',
    'current_password' => 'Aktuální heslo',
  ),
  'two_factor' => 
  array (
    'heading' => 'Dvoufaktorové ověření',
    'description' => 'Prosím potvrďte přístup k vašemu účtu zadáním kódu z vaší autentizační aplikace.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Dvoufaktorové ověření',
      'description' => 'Prosím potvrďte přístup k vašemu účtu zadáním jednoho z vašich záložních kódů.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Ztracené zařízení?',
    'recovery_code_link' => 'Použít záložní kód',
    'back_to_login_link' => 'Zpět na přihlášení',
  ),
  'profile' => 
  array (
    'account' => 'Účet',
    'profile' => 'Profil',
    'my_profile' => 'Můj profil',
    'subheading' => 'Zde můžete spravovat svůj profil.',
    'personal_info' => 
    array (
      'heading' => 'Osobní informace',
      'subheading' => 'Správa osobních informací',
      'submit' => 
      array (
        'label' => 'Aktualizovat',
      ),
      'notify' => 'Profil aktualizován úspěšně!',
    ),
    'password' => 
    array (
      'heading' => 'Heslo',
      'subheading' => 'Musí být nejméně 8 znaků dlouhé.',
      'submit' => 
      array (
        'label' => 'Aktualizovat',
      ),
      'notify' => 'Heslo aktualizováno úspěšně!',
    ),
    '2fa' => 
    array (
      'title' => 'Dvoufaktorové ověření',
      'description' => 'Zvýšete bezpečnost svého účtu pomocí dvoufaktorového ověření (doporučeno).',
      'actions' => 
      array (
        'enable' => 'Povolit',
        'regenerate_codes' => 'Obnovit záložní kódy',
        'disable' => 'Zakázat',
        'confirm_finish' => 'Potvrdit a dokončit',
        'cancel_setup' => 'Zrušit nastavení',
      ),
      'setup_key' => 'Nastavení klíče',
      'must_enable' => 'V této aplikaci je vyžadováno dvoufaktorové ověření.',
      'not_enabled' => 
      array (
        'title' => 'Nemáte povoleno dvoufaktorové ověření.',
        'description' => 'Když je povoleno dvoufaktorové ověření, budete při přihlášení vyzváni k zadání bezpečného náhodného tokenu. Tento token můžete získat z autentizační aplikace vašeho telefonu.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Dokončete povolení dvoufaktorového ověření',
        'description' => 'K dokončení povolení dvoufaktorového ověření naskenujte následující QR kód pomocí autentizační aplikace vašeho telefonu nebo zadejte nastavení klíče a zadejte vygenerovaný kód OTP.',
      ),
      'enabled' => 
      array (
        'notify' => 'Dvoufaktorové ověření povoleno.',
        'title' => 'Úspěšně jste povolili dvoufaktorové ověření!',
        'description' => 'Dvoufaktorové ověření bylo úspěšně povoleno. Váš účet je nyní bezpečnější.',
        'store_codes' => 'Tyto kódy mohou být použity k obnovení přístupu k vašemu účtu, pokud ztratíte zařízení. Varování! Tyto kódy se zobrazí pouze jednou.',
      ),
      'disabling' => 
      array (
        'notify' => 'Dvoufaktorové ověření zakázáno.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'Nové záložní kódy byly vygenerovány.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Kód potvrzen, dvoufaktorové ověření povoleno.',
        'invalid_code' => 'Zadaný kód je neplatný.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API tokeny',
      'description' => 'Spravujte API tokeny, které umožňují třetím stranám přístup k této aplikaci.',
      'create' => 
      array (
        'notify' => 'Token vytvořen úspěšně!',
        'message' => 'Váš token se zobrazí pouze jednou. Pokud token ztratíte, budete muset jej odstranit a vytvořit nový.',
        'submit' => 
        array (
          'label' => 'Vytvořit',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token úspěšně aktualizován!',
      ),
      'copied' => 
      array (
        'label' => 'Token mám zkopírován',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Kopírovat do schránky',
    'tooltip' => 'Zkopírováno!',
  ),
  'fields' => 
  array (
    'avatar' => 
    array (
      'label' => 'Avatar',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Přihlášení',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Jméno',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Heslo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Potvrzení hesla',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Nové heslo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Potvrďte heslo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Název tokenu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'Platnost tokenu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Vlastnosti',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Kód',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Záložní kód',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Vytvořeno',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Expirace',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'nebo',
  'cancel' => 'Zrušit',
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

<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Felhasználónév vagy e-mail cím',
    'forgot_password_link' => 'Elfelejtett jelszó?',
    'create_an_account' => 'fiók létrehozása',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Jelszó megerősítése',
    'description' => 'Kérem adja meg a jelszavát, hogy vérehajthassa ezt a műveletet.',
    'current_password' => 'Jelenlegi jelszó',
  ),
  'two_factor' => 
  array (
    'heading' => 'Kétfaktoros hitelesítés',
    'description' => 'Kérjük, erősítse meg fiókjához való hozzáférést a hitelesítő alkalmazás által biztosított hitelesítési kód megadásával.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Kétfaktoros hitelesítés visszaállítása',
      'description' => 'Kérjük, erősítse meg a fiókjához való hozzáférést a vészhelyzeti helyreállítási kódok egyikének megadásával.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Elveszett készülék?',
    'recovery_code_link' => 'Használjon helyreállítási kódot',
    'back_to_login_link' => 'Vissza a bejelentkezéshez',
  ),
  'registration' => 
  array (
    'title' => 'Regisztráció',
    'heading' => 'Fiók létrehozása',
    'submit' => 
    array (
      'label' => 'Regisztráció',
    ),
    'notification_unique' => 'Már létezik fiók ezzel az e-mail-címmel. Kérjük jelentkezzen be.',
  ),
  'reset_password' => 
  array (
    'title' => 'Elfelejtett jelszó',
    'heading' => 'Jelszó visszaállítása',
    'submit' => 
    array (
      'label' => 'Küldés',
    ),
    'notification_error' => 'Hiba: próbálja újra később.',
    'notification_error_link_text' => 'Try Again',
    'notification_success' => 'Tekintse meg beérkezett üzeneteit az utasításokért!',
  ),
  'verification' => 
  array (
    'title' => 'E-mail megerősítés',
    'heading' => 'E-mail ellenőrzés szükséges',
    'submit' => 
    array (
      'label' => 'Kijelentkezés',
    ),
    'notification_success' => 'Tekintse meg beérkezett üzeneteit az utasításokért!',
    'notification_resend' => 'Az ellenőrző e-mailt újra elküldtük.',
    'before_proceeding' => 'Mielőtt folytatná, kérjük, ellenőrizze e-mailjében az ellenőrző linket.',
    'not_receive' => 'Ha nem kapta meg az e-mailt,',
    'request_another' => 'kattintson ide egy másik kéréséhez',
  ),
  'profile' => 
  array (
    'account' => 'Fiók',
    'profile' => 'Profil',
    'my_profile' => 'Saját profil',
    'personal_info' => 
    array (
      'heading' => 'Személyes információk',
      'subheading' => 'Kérjük, adja meg a személyes adatait',
      'submit' => 
      array (
        'label' => 'Frissítés',
      ),
      'notify' => 'A profil sikeresen frissítve!',
    ),
    'password' => 
    array (
      'heading' => 'Jelszó',
      'subheading' => 'Legalább 8 karakterből kell állnia.',
      'submit' => 
      array (
        'label' => 'Frissítés',
      ),
      'notify' => 'A jelszó sikeresen frissítve!',
    ),
    '2fa' => 
    array (
      'title' => 'Kétfaktoros hitelesítés',
      'description' => 'Kétfaktoros hitelesítés kezelése fiókjához (ajánlott).',
      'actions' => 
      array (
        'enable' => 'Engedélyezés',
        'regenerate_codes' => 'Új kódok generálása',
        'disable' => 'Tiltás',
        'confirm_finish' => 'Megerősítés és befejezés',
        'cancel_setup' => 'A beállítás megszakítása',
      ),
      'setup_key' => 'Beállítási kulcs',
      'not_enabled' => 
      array (
        'title' => 'Nem engedélyezte a kéttényezős hitelesítést.',
        'description' => 'Ha a kéttényezős hitelesítés engedélyezve van, a rendszer a hitelesítés során egy biztonságos, véletlenszerű tokent kér. Ezt a tokent telefonja Google Authenticator alkalmazásából kérheti le.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Kétfaktoros hitelesítés engedélyezésének befejezése.',
        'description' => 'A kétfaktoros hitelesítés engedélyezésének befejezéséhez olvassa be a következő QR-kódot telefonja hitelesítő alkalmazásával, vagy adja meg a beállítási kulcsot, és adja meg a generált egyszeri kódot.',
      ),
      'enabled' => 
      array (
        'title' => 'Engedélyezte a kéttényezős hitelesítést!',
        'description' => 'A kétfaktoros hitelesítés most engedélyezve van. Olvassa be a következő QR-kódot telefonja hitelesítő alkalmazásával, vagy írja be a beállítási kulcsot.',
        'store_codes' => 'Tárolja ezeket a helyreállítási kódokat egy biztonságos jelszókezelőben. Ezek felhasználhatók fiókjához való hozzáférés helyreállítására, ha a kétfaktoros hitelesítési eszköz elveszne.',
        'show_codes' => 'Helyreállítási kódok megjelenítése',
        'hide_codes' => 'Helyreállítási kódok elrejtése',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'A kód ellenőrizve. Kétfaktoros hitelesítés engedélyezve.',
        'invalid_code' => 'A megadott kód érvénytelen.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API Tokenek',
      'description' => 'Kezelje azokat az API-tokeneket, amelyek lehetővé teszik, hogy harmadik fél szolgáltatásai hozzáférjenek ehhez az alkalmazáshoz az Ön nevében. MEGJEGYZÉS: a token csak egyszer megjelenik a létrehozáskor. Ha elveszíti a tokent, törölnie kell, és újat kell létrehoznia.',
      'create' => 
      array (
        'notify' => 'Az API token létrehozva.',
        'submit' => 
        array (
          'label' => 'Létrehozás',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Az API token frissítve.',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Link másolása',
    'tooltip' => 'Másolás sikerült!',
  ),
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'E-mail cím',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Bejelentkezés',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Név',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Jelszó',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Jelszó megerősítése',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Új jelszó',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Új jelszó megerősítése',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Token neve',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Képességek',
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
      'label' => 'Helyreállítási kód',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Létrehozva',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Lejár',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Vagy',
  'cancel' => 'Mégsem',
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

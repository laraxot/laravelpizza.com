<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Nama pengguna atau e-mel',
    'forgot_password_link' => 'Lupa kata laluan?',
    'create_an_account' => 'buat akaun',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Sahkan kata laluan',
    'description' => 'Sila sahkan kata laluan anda untuk melengkapkan tindakan ini.',
    'current_password' => 'Kata laluan semasa',
  ),
  'two_factor' => 
  array (
    'heading' => 'Cabaran Dua Faktor',
    'description' => 'Sila sahkan akses kepada akaun anda dengan memasukkan kod pengesahan yang disediakan oleh aplikasi pengesah anda.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Cabaran Dua Faktor',
      'description' => 'Sila sahkan akses kepada akaun anda dengan memasukkan salah satu kod pemulihan kecemasan anda.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Peranti hilang?',
    'recovery_code_link' => 'Gunakan kod pemulihan',
    'back_to_login_link' => 'Kembali ke log masuk',
  ),
  'registration' => 
  array (
    'title' => 'Daftar',
    'heading' => 'Buat akaun baharu',
    'submit' => 
    array (
      'label' => 'Daftar',
    ),
    'notification_unique' => 'Akaun dengan e-mel ini sudah wujud. Sila daftar masuk.',
  ),
  'reset_password' => 
  array (
    'title' => 'Lupa kata laluan',
    'heading' => 'Menetapkan semula kata laluan anda',
    'submit' => 
    array (
      'label' => 'Hantar',
    ),
    'notification_error' => 'Ralat semasa menetapkan semula kata laluan. Sila minta tetapan semula kata laluan baharu.',
    'notification_error_link_text' => 'Cuba lagi',
    'notification_success' => 'Semak peti masuk anda untuk mendapatkan arahan!',
  ),
  'verification' => 
  array (
    'title' => 'Mengesahkan E-mel',
    'heading' => 'Pengesahan e-mel diperlukan',
    'submit' => 
    array (
      'label' => 'Log keluar',
    ),
    'notification_success' => 'Semak peti masuk anda untuk mendapatkan arahan!',
    'notification_resend' => 'E-mel pengesahan telah dihantar semula.',
    'before_proceeding' => 'Sebelum meneruskan, sila semak e-mel anda untuk mendapatkan pautan pengesahan.',
    'not_receive' => 'Jika anda tidak menerima e-mel tersebut,',
    'request_another' => 'klik di sini untuk meminta yang lain',
  ),
  'profile' => 
  array (
    'account' => 'Akaun',
    'profile' => 'Profil',
    'my_profile' => 'Profil Saya',
    'personal_info' => 
    array (
      'heading' => 'Maklumat Peribadi',
      'subheading' => 'Urus maklumat peribadi anda.',
      'submit' => 
      array (
        'label' => 'Kemas kini',
      ),
      'notify' => 'Profil berjaya dikemas kini!',
    ),
    'password' => 
    array (
      'heading' => 'Kata laluan',
      'subheading' => 'Mestilah 8 aksara.',
      'submit' => 
      array (
        'label' => 'Kemas kini',
      ),
      'notify' => 'Kata laluan berjaya dikemas kini!',
    ),
    '2fa' => 
    array (
      'title' => 'Pengesahan Dua Faktor',
      'description' => 'Urus pengesahan 2 faktor untuk akaun anda (disyorkan).',
      'actions' => 
      array (
        'enable' => 'Dayakan',
        'regenerate_codes' => 'Menjana semula kod',
        'disable' => 'Lumpuhkan',
        'confirm_finish' => 'Sahkan dan selesaikan',
        'cancel_setup' => 'Batalkan persediaan',
      ),
      'setup_key' => 'Kunci persediaan',
      'not_enabled' => 
      array (
        'title' => 'Anda belum mendayakan pengesahan dua faktor.',
        'description' => 'Apabila pengesahan dua faktor didayakan, anda akan digesa untuk mendapatkan token rawak yang selamat semasa pengesahan. Anda boleh mendapatkan semula token ini daripada aplikasi Google Authenticator telefon anda.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Selesai mendayakan pengesahan dua faktor.',
        'description' => 'Untuk menyelesaikan mendayakan pengesahan dua faktor, imbas kod QR berikut menggunakan aplikasi pengesah telefon anda atau masukkan kekunci persediaan dan berikan kod OTP yang dijana.',
      ),
      'enabled' => 
      array (
        'title' => 'Anda telah mendayakan pengesahan dua faktor!',
        'description' => 'Pengesahan dua faktor kini didayakan. Ini membantu menjadikan akaun anda lebih selamat.',
        'store_codes' => 'Simpan kod pemulihan ini dalam pengurus kata laluan selamat. Ia boleh digunakan untuk memulihkan akses kepada akaun anda jika peranti pengesahan dua faktor anda hilang.',
        'show_codes' => 'Tunjukkan Kod Pemulihan',
        'hide_codes' => 'Sembunyikan Kod Pemulihan',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Kod disahkan. Pengesahan dua faktor didayakan.',
        'invalid_code' => 'Kod yang anda masukkan tidak sah.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'Token API',
      'description' => 'Uruskan token API yang membenarkan perkhidmatan pihak ketiga mengakses aplikasi ini bagi pihak anda. NOTA: token anda ditunjukkan sekali selepas dibuat. Jika anda kehilangan token anda, anda perlu memadamkannya dan mencipta yang baharu.',
      'create' => 
      array (
        'notify' => 'Token berjaya dibuat!',
        'submit' => 
        array (
          'label' => 'Cipta',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token berjaya dikemas kini!',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Salin ke papan keratan',
    'tooltip' => 'Disalin!',
  ),
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'E-mel',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Log masuk',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nama',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Kata laluan',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Pengesahan kata laluan',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Kata laluan baharu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Sahkan kata laluan',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Nama token',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Kebolehan',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Kod',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Kod Pemulihan',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Dicipta',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Tamat tempoh',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Atau',
  'cancel' => 'Batal',
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

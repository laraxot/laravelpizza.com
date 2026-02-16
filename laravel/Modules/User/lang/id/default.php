<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'Konfirmasi kata sandi',
    'description' => 'Harap konfirmasi kata sandi Anda untuk melanjutkan.',
    'current_password' => 'Kata sandi saat ini',
  ),
  'two_factor' => 
  array (
    'heading' => 'Two Factor Challenge',
    'description' => 'Harap konfirmasi akses ke akun Anda dengan memasukkan kode autentikasi yang telah diberikan oleh aplikasi autentikator Anda.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Two Factor Challenge',
      'description' => 'Harap konfirmasi akses ke akun Anda dengan memasukkan salah satu dari kode pemulihan darurat Anda.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Perangkat hilang?',
    'recovery_code_link' => 'Gunakan kode pemulihan',
    'back_to_login_link' => 'Kembali ke login',
  ),
  'profile' => 
  array (
    'account' => 'Akun',
    'profile' => 'Profil',
    'my_profile' => 'Profil saya',
    'subheading' => 'Kelola profil pengguna Anda di sini.',
    'personal_info' => 
    array (
      'heading' => 'Informasi Pribadi',
      'subheading' => 'Kelola informasi pribadi Anda.',
      'submit' => 
      array (
        'label' => 'Perbarui',
      ),
      'notify' => 'Profil berhasil diperbarui!',
    ),
    'password' => 
    array (
      'heading' => 'Kata sandi',
      'subheading' => 'Harus 8 karakter atau lebih.',
      'submit' => 
      array (
        'label' => 'Perbarui',
      ),
      'notify' => 'Kata sandi berhasil diperbarui!',
    ),
    '2fa' => 
    array (
      'title' => 'Two Factor Authentication',
      'description' => 'Atur 2 factor authentication untuk akun Anda (disarankan).',
      'actions' => 
      array (
        'enable' => 'Aktifkan',
        'regenerate_codes' => 'Buat Ulang Kode Pemulihan',
        'disable' => 'Nonaktifkan',
        'confirm_finish' => 'Konfirmasi & selesai',
        'cancel_setup' => 'Batalkan pengaturan',
      ),
      'setup_key' => 'Kunci pengaturan',
      'must_enable' => 'Anda harus mengaktifkan Two Factor Authentication untuk menggunakan aplikasi ini.',
      'not_enabled' => 
      array (
        'title' => 'Anda belum mengaktifkan two factor authentication.',
        'description' => 'Ketika two factor authentication aktif, Anda akan diminta token acak yang aman saat autentikasi. Anda dapat menerima token ini dari aplikasi Google Authenticator di ponsel Anda.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Selesaikan pengaktifan two factor authentication.',
        'description' => 'Untuk menyelesaikan pengaktifan two factor authentication, scan QR code berikut menggunakan aplikasi authenticator dari ponsel Anda atau masukkan kunci pengaturan dan masukkan kode OTP yang dihasilkan.',
      ),
      'enabled' => 
      array (
        'notify' => 'Two factor authentication diaktifkan.',
        'title' => 'Anda telah mengaktifkan two factor authentication!',
        'description' => 'Two factor authentication sudah diaktifkan. Scan QR code berikut menggunakan aplikasi authenticator ponsel Anda atau gunakan kunci pengaturan lalu masukkan OTP yang dihasilkan.',
        'store_codes' => 'Simpan kode pemulihan ini di tempat yang aman. Kode ini dapat digunakan untuk memulihkan akses ke akun Anda jika perangkat two factor authentication Anda tidak dapat digunakan. Penting! Kode ini hanya ditampilkan satu kali.',
      ),
      'disabling' => 
      array (
        'notify' => 'Two factor authentication telah dinonaktifkan.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'Kode pemulihan baru telah dibuat.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Kode terverifikasi. Two factor authentication diaktifkan.',
        'invalid_code' => 'Kode yang Anda masukkan tidak valid.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'Token API',
      'description' => 'Kelola token API yang memungkinkan layanan pihak ketiga mengakses aplikasi ini atas nama Anda.',
      'create' => 
      array (
        'notify' => 'Token berhasil dibuat!',
        'message' => 'Token hanya ditampilkan sekali setelah dibuat. Jika Anda kehilangan token, Anda harus menghapusnya dan membuat yang baru.',
        'submit' => 
        array (
          'label' => 'Buat',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token berhasil diperbarui!',
      ),
      'copied' => 
      array (
        'label' => 'Saya telah menyalin token saya',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Salin ke clipboard',
    'tooltip' => 'Disalin!',
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
      'label' => 'Login',
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
      'label' => 'Kata Sandi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Konfirmasi kata sandi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Kata sandi baru',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Konfirmasi kata sandi baru',
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
    'token_expiry' => 
    array (
      'label' => 'Kedaluwarsa token',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Hak akses',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Kode',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Kode Pemulihan',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Dibuat',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Kedaluwarsa',
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

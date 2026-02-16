<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'Parolayı doğrula',
    'description' => 'Bu işlemi tamamlamak için lütfen şifrenizi onaylayın.',
    'current_password' => 'Mevcut parola',
  ),
  'two_factor' => 
  array (
    'heading' => 'İki Adımlı Doğrulama',
    'description' => 'Lütfen kimlik doğrulayıcı uygulamanız tarafından sağlanan kimlik doğrulama kodunu girerek hesabınıza erişimi onaylayın.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'İki Adımlı Doğrulama',
      'description' => 'Lütfen acil durum kurtarma kodlarınızdan birini girerek hesabınıza erişimi onaylayın.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Kayıp cihaz?',
    'recovery_code_link' => 'Bir kurtarma kodu kullanın',
    'back_to_login_link' => 'Girişe geri dön',
  ),
  'profile' => 
  array (
    'account' => 'Hesap',
    'profile' => 'Profil',
    'my_profile' => 'Profilim',
    'subheading' => 'Kullanıcı profilinizi buradan yönetin.',
    'personal_info' => 
    array (
      'heading' => 'Kişisel Bilgiler',
      'subheading' => 'Kişisel bilgilerinizi yönetin.',
      'submit' => 
      array (
        'label' => 'Güncelle',
      ),
      'notify' => 'Profil başarıyla güncellendi!',
    ),
    'password' => 
    array (
      'heading' => 'Şifre',
      'subheading' => '8 karakter olmalıdır.',
      'submit' => 
      array (
        'label' => 'Güncelle',
      ),
      'notify' => 'Şifre başarıyla güncellendi!',
    ),
    '2fa' => 
    array (
      'title' => 'İki Adımlı Doğrulama',
      'description' => 'Hesabınız için iki adımlı kimlik doğrulamayı yönetin (önerilir).',
      'actions' => 
      array (
        'enable' => 'Etkinleştir',
        'regenerate_codes' => 'Kodları Yeniden Oluştur',
        'disable' => 'Devredışı bırak',
        'confirm_finish' => 'Onayla & bitir',
        'cancel_setup' => 'Kurulumu iptal et',
      ),
      'setup_key' => 'Kurulum anahtarı',
      'must_enable' => 'Bu uygulamayı kullanmak için iki faktörlü kimlik doğrulamayı etkinleştirmeniz gerekir.',
      'not_enabled' => 
      array (
        'title' => 'İki adımlı kimlik doğrulamayı etkinleştirmediniz.',
        'description' => 'İki adımlı kimlik doğrulaması etkinleştirildiğinde, kimlik doğrulaması sırasında güvenli, rasgele bir belirteç istenir. Bu belirteci telefonunuzun Google Authenticator uygulamasından alabilirsiniz.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'İki adımlı kimlik doğrulamayı etkinleştirmeyi bitirin.',
        'description' => 'İki adımlı kimlik doğrulamayı etkinleştirmeyi bitirmek için telefonunuzun kimlik doğrulayıcı uygulamasını kullanarak aşağıdaki QR kodunu tarayın veya kurulum anahtarını girin ve oluşturulan OTP kodunu girin.',
      ),
      'enabled' => 
      array (
        'notify' => 'İki faktörlü kimlik doğrulama etkin.',
        'title' => 'İki adımlı kimlik doğrulamayı etkinleştirdiniz!',
        'description' => 'İki adımlı kimlik doğrulama artık etkin. Telefonunuzun kimlik doğrulayıcı uygulamasını kullanarak aşağıdaki QR kodunu tarayın veya kurulum anahtarını girin.',
        'store_codes' => 'Bu kurtarma kodlarını güvenli bir parola yöneticisinde saklayın. İki adımlı kimlik doğrulama cihazınız kaybolursa hesabınıza erişimi kurtarmak için kullanılabilirler.',
      ),
      'disabling' => 
      array (
        'notify' => 'İki faktörlü kimlik doğrulama devre dışı bırakıldı.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'Yeni kurtarma kodları oluşturuldu.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Kod doğrulandı. İki adımlı kimlik doğrulaması etkin.',
        'invalid_code' => 'Girdiğiniz kod geçersiz.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API Belirteçleri',
      'description' => 'Üçüncü taraf hizmetlerinin sizin adınıza bu uygulamaya erişmesine izin veren API belirteçlerini yönetin. NOT: jetonunuz oluşturulduktan sonra bir kez gösterilir. Jetonunuzu kaybederseniz, onu silmeniz ve yeni bir tane oluşturmanız gerekir.',
      'create' => 
      array (
        'notify' => 'Belirteç başarıyla oluşturuldu!',
        'message' => 'Belirteciniz oluşturulduktan sonra yalnızca bir kez gösterilir. Belirtecinizi kaybederseniz, onu silmeniz ve yeni bir tane oluşturmanız gerekecektir.',
        'submit' => 
        array (
          'label' => 'Oluştur',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Belirteç başarıyla güncellendi!',
      ),
      'copied' => 
      array (
        'label' => 'Belirtecimi kopyaladım',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Panoya kopyala',
    'tooltip' => 'Kopyalandı!',
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
      'label' => 'E-posta',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Giriş',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'İsim',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Parola',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Parola doğrulama',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Yeni parola',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Parola doğrulama',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Belirteç adı',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'Belirteç sona erişi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Yetenekler',
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
      'label' => 'Kurtarma Kodu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Oluşturuldu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Sona eriyor',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Veya',
  'cancel' => 'Vazgeç',
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

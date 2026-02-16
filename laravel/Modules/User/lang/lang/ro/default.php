<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Nume de utilizator sau email',
    'forgot_password_link' => 'Am uitat parola',
    'create_an_account' => 'creaţi un cont',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Confirmaţi parola',
    'description' => 'Vă rugăm să vă confirmați parola pentru a finaliza această operație.',
    'current_password' => 'Parola curentă',
  ),
  'two_factor' => 
  array (
    'heading' => 'Verificare in doi pași',
    'description' => 'Vă rugăm să confirmați accesul la contul dvs. introducând codul de autentificare furnizat de aplicația dvs. de autentificare.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Verificare in doi pași',
      'description' => 'Vă rugăm să confirmați accesul la contul dvs. introducând unul dintre codurile dvs. de recuperare de urgență.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Aparatul pierdut?',
    'recovery_code_link' => 'Utilizați un cod de recuperare',
    'back_to_login_link' => 'Înapoi la autentificare',
  ),
  'registration' => 
  array (
    'title' => 'Inregistrare',
    'heading' => 'Creați un cont nou',
    'submit' => 
    array (
      'label' => 'Inregistrare',
    ),
    'notification_unique' => 'Un cont cu acest email există deja. Vă rugăm să vă conectați.',
  ),
  'reset_password' => 
  array (
    'title' => 'Aţi uitat parola?',
    'heading' => 'Resetare parola',
    'submit' => 
    array (
      'label' => 'Trimite',
    ),
    'notification_error' => 'Eroare: vă rugăm să încercați din nou mai târziu.',
    'notification_error_link_text' => 'Try Again',
    'notification_success' => 'Verificați-vă căsuța de e-mail pentru instrucțiuni!',
  ),
  'verification' => 
  array (
    'title' => 'Verificare prin email',
    'heading' => 'Este necesară verificarea e-mailului',
    'submit' => 
    array (
      'label' => 'Deconectare',
    ),
    'notification_success' => 'Verificați-vă căsuța de e-mail pentru instrucțiuni!',
    'notification_resend' => 'E-mailul de verificare a fost retrimis.',
    'before_proceeding' => 'Înainte de a continua, vă rugăm să vă verificați e-mailul pentru un link de verificare.',
    'not_receive' => 'Dacă nu ați primit e-mailul,',
    'request_another' => 'click aici pentru a solicita altul',
  ),
  'profile' => 
  array (
    'account' => 'Cont',
    'profile' => 'Profil',
    'my_profile' => 'Profilul meu',
    'personal_info' => 
    array (
      'heading' => 'Informații personale',
      'subheading' => 'Completează informațiile personale',
      'submit' => 
      array (
        'label' => 'Salvare',
      ),
      'notify' => 'Profil actualizat cu succes!',
    ),
    'password' => 
    array (
      'heading' => 'Parola',
      'subheading' => 'Trebuie să aibă cel puțin 8 caractere.',
      'submit' => 
      array (
        'label' => 'Salvare',
      ),
      'notify' => 'Parola actualizată cu succes!',
    ),
    '2fa' => 
    array (
      'title' => 'Verificare in doi pași',
      'description' => 'Folosiți autentificarea în doi factori pentru contul dvs. (recomandat).',
      'actions' => 
      array (
        'enable' => 'Activare',
        'regenerate_codes' => 'Regenerare coduri',
        'disable' => 'Dezactivare',
        'confirm_finish' => 'Confirmare și finalizare',
        'cancel_setup' => 'Anulare setare',
      ),
      'setup_key' => 'Setare cheie',
      'not_enabled' => 
      array (
        'title' => 'Nu ați activat autentificarea in doi pași.',
        'description' => 'Când autentificarea in doi pași este activată, vi se va solicita un token securizat, aleatoriu în timpul autentificării. Puteți prelua acest simbol din aplicația Google Authenticator a telefonului dvs.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Finalizați activarea autentificării in doi pași.',
        'description' => 'Pentru a finaliza activarea autentificării in doi pași, scanați următorul cod QR folosind aplicația de autentificare a telefonului sau introduceți cheia de configurare și furnizați codul OTP generat.',
      ),
      'enabled' => 
      array (
        'title' => 'Ați activat autentificarea in doi pași!',
        'description' => 'Autentificarea in doi pași este acum activată. Scanați următorul cod QR folosind aplicația de autentificare a telefonului sau introduceți cheia de configurare.',
        'store_codes' => 'Păstrați aceste coduri de recuperare într-un manager de parole securizat. Acestea pot fi folosite pentru a recupera accesul la contul dvs. dacă dispozitivul de autentificare in doi pașii este pierdut.',
        'show_codes' => 'Afișare coduri de recuperare',
        'hide_codes' => 'Ascunde codurile de recuperare',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Cod verificat. Autentificarea in doi pași este activată.',
        'invalid_code' => 'Codul pe care l-ați introdus este nevalid.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API Tokens',
      'description' => 'Gestionați token-urile API care permit serviciilor terțe să acceseze această aplicație în numele dvs. NOTĂ: token-ul dvs. este afișat o dată după creare. Dacă vă pierdeți token-ul, va trebui să îl ștergeți și să creați unul nou.',
      'create' => 
      array (
        'notify' => 'Token creat cu succes!',
        'submit' => 
        array (
          'label' => 'Creare token',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Tokenul a fost actualizat cu succes!',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Copiere în clipboard',
    'tooltip' => 'Copiat!',
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
      'label' => 'Nume',
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
      'label' => 'Confirmare parola',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Parola nouă',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Confirmare parola nouă',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Nume token',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Abilități',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Cod',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Cod de recuperare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Creat',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Expiră',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Sau',
  'cancel' => 'Anulare',
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

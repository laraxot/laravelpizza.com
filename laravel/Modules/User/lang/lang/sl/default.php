<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'Potrditev gesla',
    'description' => 'Za dokončanje tega dejanja potrdite svoje geslo.',
    'current_password' => 'Trenutno geslo',
  ),
  'two_factor' => 
  array (
    'heading' => 'Dvostopenjsko preverjanje',
    'description' => 'Prosimo, potrdite dostop do svojega računa z vnosom kode, ki jo je prejela vaša aplikacija za preverjanje pristnosti.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Dvofaktorska preverba',
      'description' => 'Potrdite dostop do svojega računa z vnosom ene izmed za obnovitvenih kod.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Izgubljena naprava?',
    'recovery_code_link' => 'Uporabite obnovitveno kodo',
    'back_to_login_link' => 'Nazaj na prijavo',
  ),
  'profile' => 
  array (
    'account' => 'Račun',
    'profile' => 'Profil',
    'my_profile' => 'Moj profil',
    'subheading' => 'Tukaj upravljajte svoj uporabniški profil.',
    'personal_info' => 
    array (
      'heading' => 'Osebni podatki',
      'subheading' => 'Upravljajte svoje osebne podatke.',
      'submit' => 
      array (
        'label' => 'Posodobi',
      ),
      'notify' => 'Profil je bil uspešno posodobljen!',
    ),
    'password' => 
    array (
      'heading' => 'Geslo',
      'subheading' => 'Geslo mora biti dolgo najmanj 8 znakov.',
      'submit' => 
      array (
        'label' => 'Posodobi',
      ),
      'notify' => 'Geslo je bilo uspešno posodobljeno!',
    ),
    '2fa' => 
    array (
      'title' => 'Dvostopenjska avtentikacija',
      'description' => 'Upravljajte dvostopenjsko preverjanje za svoj račun (priporočeno).',
      'actions' => 
      array (
        'enable' => 'Omogoči',
        'regenerate_codes' => 'Ustvari nove obnovitvene kode',
        'disable' => 'Onemogoči',
        'confirm_finish' => 'Potrdi in dokončaj',
        'cancel_setup' => 'Prekliči nastavitev',
      ),
      'setup_key' => 'Nastavitveni ključ',
      'must_enable' => 'Za uporabo te aplikacije morate omogočiti dvostopenjsko avtentikacijo.',
      'not_enabled' => 
      array (
        'title' => 'Niste omogočili dvostopenjske avtentikacije.',
        'description' => 'Ko je omogočeno dvofaktorsko preverjanje pristnosti, boste med preverjanjem pristnosti pozvani k vnosu varnega, naključnega žetona. Ta žeton lahko pridobite v aplikaciji Google Authenticator na telefonu.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Dokončajte nastavitev dvostopenjske avtentikacije.',
        'description' => 'Če želite dokončati nastavitev dvostopenjske avtentikacije, skenirajte naslednjo kodo QR z aplikacijo za preverjanje pristnosti v telefonu ali vnesite nastavitveni ključ in vnesite ustvarjeno kodo OTP.',
      ),
      'enabled' => 
      array (
        'notify' => 'Dvostopenjska avtentikacija omogočena.',
        'title' => 'Omogočili ste dvostopenjsko avtentikacijo!',
        'description' => 'Dvostopenjska avtentikacija je zdaj omogočena. S tem je vaš račun bolj varen.',
        'store_codes' => 'Te kode lahko uporabite za obnovitev dostopa do vašega računa, če izgubite napravo. Opozorilo! Te kode bodo prikazane samo enkrat.',
      ),
      'disabling' => 
      array (
        'notify' => 'Dvostopenjska avtentikacija je bila onemogočena.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'Ustvarjene so bile nove kode za obnovitev.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Koda preverjena. Dvostopenjska avtentikacija omogočena.',
        'invalid_code' => 'Kodo, ki ste jo vnesli, ni veljavna.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API žetoni',
      'description' => 'Upravljajte žetone API, ki omogočajo storitvam tretjih oseb dostop do te aplikacije v vašem imenu.',
      'create' => 
      array (
        'notify' => 'Žeton uspešno ustvarjen!',
        'message' => 'Vaš žeton bo prikazan samo enkrat. Če izgubite žeton, ga boste morali izbrisati in ustvariti novega.',
        'submit' => 
        array (
          'label' => 'Ustvari',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Žeton uspešno posodobljen!',
      ),
      'copied' => 
      array (
        'label' => 'Kopiral/a sem svoj žeton',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Kopiraj v odložišče',
    'tooltip' => 'Kopirano!',
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
      'label' => 'E-pošta',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Prijava',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Ime',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Geslo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Potrditev gesla',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Novo geslo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Potrditev novega gesla',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Ime žetona',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'Veljavnost žetona',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Sposobnosti',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Koda',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Koda za obnovitev',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Ustvarjeno',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Poteče',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Ali',
  'cancel' => 'Prekliči',
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

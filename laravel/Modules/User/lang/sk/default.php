<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'Potvrdiť heslo',
    'description' => 'Pre dokončenie vyplňte potvrdiť heslo.',
    'current_password' => 'Aktuálne heslo',
  ),
  'two_factor' => 
  array (
    'heading' => 'Dvojfaktorové overenie',
    'description' => 'Prosím potvrďte prístup k vášmu účtu zadaním kódu z vašej autentifikačnej aplikácie.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Dvojfaktorové overenie',
      'description' => 'Prosím potvrďte prístup k vášmu účtu zadaním jedného z vašich záložných kódov.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Stratené zariadenie?',
    'recovery_code_link' => 'Použiť záložný kód',
    'back_to_login_link' => 'Späť na prihlásenie',
  ),
  'profile' => 
  array (
    'account' => 'Účet',
    'profile' => 'Profil',
    'my_profile' => 'Môj profil',
    'subheading' => 'Tu môžete spravovať svoj profil.',
    'personal_info' => 
    array (
      'heading' => 'Osobné informácie',
      'subheading' => 'Správa osobných informácií',
      'submit' => 
      array (
        'label' => 'Aktualizovať',
      ),
      'notify' => 'Profil úspešne aktualizovaný!',
    ),
    'password' => 
    array (
      'heading' => 'Heslo',
      'subheading' => 'Musí byť najmenej 8 znakov dlhé.',
      'submit' => 
      array (
        'label' => 'Aktualizovať',
      ),
      'notify' => 'Heslo úspešne aktualizované!',
    ),
    '2fa' => 
    array (
      'title' => 'Dvojfaktorové overenie',
      'description' => 'Zvýšte bezpečnosť svojho účtu pomocou dvojfaktorového overenia (odporúčané).',
      'actions' => 
      array (
        'enable' => 'Povoliť',
        'regenerate_codes' => 'Obnoviť záložné kódy',
        'disable' => 'Zakázať',
        'confirm_finish' => 'Potvrdiť a dokončiť',
        'cancel_setup' => 'Zrušiť nastavenie',
      ),
      'setup_key' => 'Nastavenie kľúča',
      'must_enable' => 'V tejto aplikácii je vyžadované dvojfaktorové overenie.',
      'not_enabled' => 
      array (
        'title' => 'Nemáte povolené dvojfaktorové overenie.',
        'description' => 'Keď je povolené dvojfaktorové overenie, budete pri prihlásení vyzvaní k zadaniu bezpečného náhodného tokenu. Tento token môžete získať z autentifikačnej aplikácie vášho telefónu.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Dokončite povolenie dvojfaktorového overenia',
        'description' => 'Na dokončenie povolenia dvojfaktorového overenia naskenujte nasledujúci QR kód pomocou autentifikačnej aplikácie vášho telefónu alebo zadajte nastavenie kľúča a zadajte vygenerovaný kód OTP.',
      ),
      'enabled' => 
      array (
        'notify' => 'Dvojfaktorové overenie povolené.',
        'title' => 'Úspešne ste povolili dvojfaktorové overenie!',
        'description' => 'Dvojfaktorové overenie bolo úspešne povolené. Váš účet je teraz bezpečnejší.',
        'store_codes' => 'Tieto kódy môžu byť použité na obnovenie prístupu k vášmu účtu, ak stratíte zariadenie. Varovanie! Tieto kódy sa zobrazia iba raz.',
      ),
      'disabling' => 
      array (
        'notify' => 'Dvojfaktorové overenie zakázané.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'Nové záložné kódy boli vygenerované.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Kód potvrdený, dvojfaktorové overenie povolené.',
        'invalid_code' => 'Zadaný kód je neplatný.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API tokeny',
      'description' => 'Spravujte API tokeny, ktoré umožňujú tretím stranám prístup k tejto aplikácii.',
      'create' => 
      array (
        'notify' => 'Token úspešne vytvorený!',
        'message' => 'Váš token sa zobrazí iba raz. Ak token stratíte, budete ho musieť odstrániť a vytvoriť nový.',
        'submit' => 
        array (
          'label' => 'Vytvoriť',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token úspešne aktualizovaný!',
      ),
      'copied' => 
      array (
        'label' => 'Token mám skopírovaný',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Kopírovať do schránky',
    'tooltip' => 'Skopírované!',
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
      'label' => 'Prihlásenie',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Meno',
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
      'label' => 'Potvrdenie hesla',
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
      'label' => 'Názov tokenu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'Platnosť tokenu',
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
      'label' => 'Záložný kód',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Vytvorené',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Expirácia',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'alebo',
  'cancel' => 'Zrušiť',
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

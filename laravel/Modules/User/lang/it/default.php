<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Username o Email',
    'forgot_password_link' => 'Password dimenticata?',
    'create_an_account' => 'crea un account',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Conferma password',
    'description' => 'Conferma la tua password per completare questa azione.',
    'current_password' => 'Password attuale',
  ),
  'two_factor' => 
  array (
    'heading' => 'Autenticazione a due fattori',
    'description' => 'Conferma l\'accesso al tuo account inserendo il codice che trovi sulla tua app di autenticazione.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Autenticazione a due fattori',
      'description' => 'Conferma l\'accesso al tuo account inserendo uno dei tuoi codice di emergenza.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Dispositivo smarrito?',
    'recovery_code_link' => 'Usa un codice di ripristino',
    'back_to_login_link' => 'Torna al login',
  ),
  'registration' => 
  array (
    'title' => 'Registrazione',
    'heading' => 'Crea un nuovo account',
    'submit' => 
    array (
      'label' => 'Registrazione',
    ),
    'notification_unique' => 'Un account con questa email è già esistente. Prova ad accedere.',
  ),
  'reset_password' => 
  array (
    'title' => 'Password dimenticata',
    'heading' => 'Ripristina la tua password',
    'submit' => 
    array (
      'label' => 'Procedi',
    ),
    'notification_error' => 'Errore nel ripristino della password. Effettua di nuovo il ripristino.',
    'notification_error_link_text' => 'Prova di nuovo',
    'notification_success' => 'Controlla la tua casella di posta per ulteriori istruzioni!',
  ),
  'verification' => 
  array (
    'title' => 'Verifica email',
    'heading' => 'Necessaria verifica dell\'indirizzo Email',
    'submit' => 
    array (
      'label' => 'Log out',
    ),
    'notification_success' => 'Controlla la tua casella di posta per ulteriori istruzioni!',
    'notification_resend' => 'È stata inviata una email di verifica.',
    'before_proceeding' => 'Prima di procedere, controlla la tua casella di posta per verificare la tua email.',
    'not_receive' => 'Se non hai ricevuto l\'email di verifica,',
    'request_another' => 'clicca qui per richiederla di nuovo',
  ),
  'profile' => 
  array (
    'account' => 'Account',
    'profile' => 'Profilo',
    'my_profile' => 'Il mio profilo',
    'subheading' => 'Gestisci il tuo profilo.',
    'personal_info' => 
    array (
      'heading' => 'Informazioni personali',
      'subheading' => 'Gestisci le tue informazioni personali.',
      'submit' => 
      array (
        'label' => 'Aggiorna',
      ),
      'notify' => 'Profilo aggiornato correttamente!',
    ),
    'password' => 
    array (
      'heading' => 'Password',
      'subheading' => 'Sono necessari almeno 8 caratteri.',
      'submit' => 
      array (
        'label' => 'Aggiorna',
      ),
      'notify' => 'Password aggiornata correttamente!',
    ),
    '2fa' => 
    array (
      'title' => 'Autenticazione a due Fattori',
      'description' => 'Gestisci l\'autenticazione a due fattori per il tuo account (raccomandato].',
      'actions' => 
      array (
        'enable' => 'Abilita',
        'regenerate_codes' => 'Rigenera Codici',
        'disable' => 'Disabilita',
        'confirm_finish' => 'Conferma & procedi',
        'cancel_setup' => 'Annulla il setup',
      ),
      'setup_key' => 'Chiave di Setup',
      'must_enable' => 'Per utilizzare questa applicazione devi abilitare la 2FA.',
      'not_enabled' => 
      array (
        'title' => 'Non hai abilitato l\'autenticazione a due fattori.',
        'description' => 'Quando l\'autenticazione a due fattori è attivata, durante l\'autenticazione, ti verrà richiesto un token casuale. Potrai recuperare questo toke tramite l\'app mobile di Google Authenticator',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Finisci di abilitare l\'autenticazione a due fattori.',
        'description' => 'Per completare l\'abilitazione del login con autenticazione a due fattori, scansiona il seguente QR code utilizzando una applicazione di autenticazione o inserisci la chiave insieme al codice OTP generato.',
      ),
      'enabled' => 
      array (
        'notify' => 'Autenticazione a due fattori attivata.',
        'title' => 'Hai abilitato l\'autenticazione a due fattori!',
        'description' => 'L\'autenticazione a due fattori adesso è abilitata. Questo permette di rendere più sicuro il tuo account.',
        'store_codes' => 'Salva questi codice di ripristino in un luogo sicuro. Possono essere utilizzati per ripristinare l\'accesso al tuo account se il dispositivo che utilizzi viene smarrito',
      ),
      'disabling' => 
      array (
        'notify' => 'L\'autenticazione a due fattori è stata disabilitata.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'I nuovi codici di recupero sono stati generati.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Codice verificato. Autenticazione a due fattori abilitata.',
        'invalid_code' => 'Il codice inserito non è valido.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'Token API ',
      'description' => 'Gestisci i token API che permettono l\'accesso a questa applicazione a servizi di terze parti. NOTA: il tuo token viene mostrato dopo la creazione. Se perdi il token, dovrai cancellarlo e crearlo nuovamente.',
      'create' => 
      array (
        'notify' => 'Token creato correttamente!',
        'message' => 'Il tuo token viene mostrato solo una volta. Se perdi il token, dovrai cancellarlo e crearne uno nuovo.',
        'submit' => 
        array (
          'label' => 'Crea',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token aggiornato correttamente!',
      ),
      'copied' => 
      array (
        'label' => 'Ho copiato il mio token',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Copia negli appunti',
    'tooltip' => 'Copiato!',
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
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Conferma password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Nuova password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Conferma nuova password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Nome del Token',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'Scadenza del Token',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Abilità',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Codice',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Codice di Ripristino',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Creato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Scade',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'O',
  'cancel' => 'Annulla',
  'navigation' => 
  array (
    'name' => 'Default',
    'plural' => 'Default',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Default',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'label' => 'Default',
  'plural_label' => 'Default (Plurale)',
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Default',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Default',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Default',
    ),
  ),
);

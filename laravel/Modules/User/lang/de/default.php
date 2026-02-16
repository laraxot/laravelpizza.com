<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Benutzername oder E-Mail',
    'forgot_password_link' => 'Haben Sie Ihr Passwort vergessen?',
    'create_an_account' => 'Konto erstellen',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Passwort bestätigen',
    'description' => 'Bestätigen Sie bitte Ihr Passwort, um diese Aktion abzuschließen.',
    'current_password' => 'Aktuelles Passwort',
  ),
  'two_factor' => 
  array (
    'heading' => 'Zwei-Faktor-Authentifizierung',
    'description' => 'Bitte bestätigen Sie den Zugriff auf Ihr Konto, indem Sie den von Ihrer Authentifizierungs-App bereitgestellten Authentifizierungscode eingeben.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Zwei-Faktor-Authentifizierung',
      'description' => 'Bitte bestätigen Sie den Zugang zu Ihrem Konto, indem Sie einen Ihrer Notfallcodes eingeben.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Haben Sie Ihr Gerät verloren?',
    'recovery_code_link' => 'Verwenden Sie einen Wiederherstellungscode',
    'back_to_login_link' => 'Zurück zum Einloggen',
  ),
  'registration' => 
  array (
    'title' => 'Registrieren',
    'heading' => 'Ein neues Konto erstellen',
    'submit' => 
    array (
      'label' => 'Registrieren',
    ),
    'notification_unique' => 'Es existiert bereits ein Konto mit dieser E-Mail-Adresse. Bitte melden Sie sich an.',
  ),
  'reset_password' => 
  array (
    'title' => 'Passwort vergessen',
    'heading' => 'Setzen Sie Ihr Passwort zurück',
    'submit' => 
    array (
      'label' => 'Zurücksetzen',
    ),
    'notification_error' => 'Fehler beim Zurücksetzen des Passworts. Bitte fordern Sie ein neues Passwort an.',
    'notification_error_link_text' => 'Erneut versuchen',
    'notification_success' => 'Prüfen Sie Ihren E-Mail auf Anweisungen!',
  ),
  'verification' => 
  array (
    'title' => 'E-Mail verifizieren',
    'heading' => 'E-Mail-Verifizierung erforderlich',
    'submit' => 
    array (
      'label' => 'Abmelden',
    ),
    'notification_success' => 'Prüfen Sie Ihren Posteingang auf Anweisungen!',
    'notification_resend' => 'Die Verifizierungs-E-Mail wurde erneut gesendet.',
    'before_proceeding' => 'Bevor Sie fortfahren, überprüfen Sie bitte Ihre E-Mail auf einen Verifizierungslink.',
    'not_receive' => 'Wenn Sie die E-Mail nicht erhalten haben,',
    'request_another' => 'Klicken Sie hier, um eine weitere E-Mail anzufordern',
  ),
  'profile' => 
  array (
    'account' => 'Konto',
    'profile' => 'Profil',
    'my_profile' => 'Mein Profil',
    'subheading' => 'Verwalten Sie hier ihr Profil.',
    'personal_info' => 
    array (
      'heading' => 'Persönliche Informationen',
      'subheading' => 'Verwalten Sie Ihre persönlichen Daten.',
      'submit' => 
      array (
        'label' => 'Aktualisieren',
      ),
      'notify' => 'Profil erfolgreich aktualisiert!',
    ),
    'password' => 
    array (
      'heading' => 'Passwort',
      'subheading' => 'Muss 8 Zeichen lang sein',
      'submit' => 
      array (
        'label' => 'Aktualisieren',
      ),
      'notify' => 'Passwort erfolgreich aktualisiert!',
    ),
    '2fa' => 
    array (
      'title' => 'Zwei-Faktor-Authentifizierung',
      'description' => 'Verwalten Sie die 2-Faktor-Authentifizierung für Ihr Konto (empfohlen).',
      'actions' => 
      array (
        'enable' => 'Aktivieren',
        'regenerate_codes' => 'Codes neu generieren',
        'disable' => 'Deaktivieren',
        'confirm_finish' => 'Bestätigen & beenden',
        'cancel_setup' => 'Einstellung abbrechen',
      ),
      'setup_key' => 'Einstellungsschlüssel',
      'not_enabled' => 
      array (
        'title' => 'Sie haben die Zwei-Faktor-Authentifizierung nicht aktiviert.',
        'description' => 'Wenn die Zwei-Faktor-Authentifizierung aktiviert ist, werden Sie während der Authentifizierung zur Eingabe eines sicheren, zufälligen Tokens aufgefordert. Sie können dieses Token über die Google Authenticator-App auf Ihrem Handy abrufen.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Beenden Sie die Aktivierung der Zwei-Faktor-Authentifizierung.',
        'description' => 'Um die Aktivierung der Zwei-Faktor-Authentifizierung abzuschließen, scannen Sie den folgenden QR-Code mit der Authenticator-Applikation Ihres Handys oder geben Sie den Installationsschlüssel und den generierten OTP-Code ein.',
      ),
      'enabled' => 
      array (
        'title' => 'Sie haben die Zwei-Faktor-Authentifizierung aktiviert!',
        'notify' => 'Zwei-Faktor-Authentifizierung wurde aktiviert.',
        'description' => 'Die Zwei-Faktor-Authentifizierung ist jetzt aktiviert. Dadurch wird Ihr Konto noch sicherer.',
        'store_codes' => 'Speichern Sie diese Wiederherstellungscodes in einem sicheren Passwort-Manager. Sie können verwendet werden, um den Zugang zu Ihrem Konto wiederherzustellen, wenn Ihr Zwei-Faktor-Authentifizierungsgerät verloren geht.',
        'show_codes' => 'Wiederherstellungscodes anzeigen',
        'hide_codes' => 'Wiederherstellungscodes ausblenden',
      ),
      'disabling' => 
      array (
        'notify' => 'Zwei-Faktor-Authentifizierung wurde deaktiviert.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'Neue Wiederherstellungscodes wurden generiert.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Code verifiziert. Zwei-Faktor-Authentifizierung aktiviert.',
        'invalid_code' => 'Der von Ihnen eingegebene Code ist ungültig.',
      ),
      'must_enable' => 'Per utilizzare questa applicazione devi abilitare la 2FA.',
    ),
    'sanctum' => 
    array (
      'title' => 'API Tokens',
      'description' => 'Verwalten Sie API-Tokens, mit denen Dienste von Drittanbietern in Ihrem Namen auf diese Anwendung zugreifen können. HINWEIS: Ihr Token wird bei der Erstellung einmalig angezeigt. Wenn Sie Ihr Token verlieren, müssen Sie es löschen und ein neues erstellen.',
      'create' => 
      array (
        'notify' => 'Token erfolgreich erstellt!',
        'submit' => 
        array (
          'label' => 'Erstellen',
        ),
        'message' => 'Il tuo token viene mostrato solo una volta. Se perdi il token, dovrai cancellarlo e crearne uno nuovo.',
      ),
      'update' => 
      array (
        'notify' => 'Token erfolgreich aktualisiert!',
      ),
      'copied' => 
      array (
        'label' => 'Ho copiato il mio token',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'In die Zwischenablage kopieren',
    'tooltip' => 'Kopiert!',
  ),
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'E-Mail',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Einloggen',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Benutzername',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Passwort',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Passwort bestätigen',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Neues Passwort',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Bestätigen Sie das Passwort',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Token-Name',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Möglichkeiten',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Code',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Wiederherstellungscode',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Erstellt',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expired' => 
    array (
      'label' => 'Abgelaufen',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'avatar' => 
    array (
      'label' => 'Avatar',
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
    'expires' => 
    array (
      'label' => 'Scade',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Oder',
  'cancel' => 'Abbrechen',
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

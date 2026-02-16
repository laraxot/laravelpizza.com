<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Όνομα χρήστη ή Email',
    'forgot_password_link' => 'Ξεχάσατε τον κωδικό πρόσβασης;',
    'create_an_account' => 'δημιουργία λογαριασμού',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Επιβεβαίωση κωδικού',
    'description' => 'Επιβεβαιώστε τον κωδικό πρόσβασης σας για να ολοκληρώσετε αυτήν την πράξη.',
    'current_password' => 'Τρέχων κωδικός πρόσβασης',
  ),
  'two_factor' => 
  array (
    'heading' => 'Two Factor Challenge',
    'description' => 'Επιβεβαιώστε την πρόσβαση στον λογαριασμό σας εισάγοντας τον κωδικό ελέγχου που παρέχεται από την εφαρμογή ελέγχου ταυτότητας.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Two Factor Challenge',
      'description' => 'Επιβεβαιώστε την πρόσβαση στον λογαριασμό σας εισάγοντας έναν από τους κωδικούς ανάκτησης έκτακτης ανάγκης.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Χάθηκε η συσκευή;',
    'recovery_code_link' => 'Χρησιμοποιήστε έναν κωδικό ανάκτησης',
    'back_to_login_link' => 'Επιστροφή στην σελίδα εισόδου',
  ),
  'registration' => 
  array (
    'title' => 'Εγγραφή',
    'heading' => 'Δημιουργία νέου λογαριασμού',
    'submit' => 
    array (
      'label' => 'Εγγραφή',
    ),
    'notification_unique' => 'Υπάρχει ήδη λογαριασμός με αυτό το email. Παρακαλώ Συνδεθείτε.',
  ),
  'reset_password' => 
  array (
    'title' => 'Επαναφορά κωδικού πρόσβασης',
    'heading' => 'Επαναφορά κωδικού πρόσβασης',
    'submit' => 
    array (
      'label' => 'Επαναφορά',
    ),
    'notification_error' => 'Σφάλμα κατά την επαναφορά του κωδικού πρόσβασης. Προσπαθήστε ξανά.',
    'notification_error_link_text' => 'Προσπαθήστε ξανά',
    'notification_success' => 'Ελέγξτε το email σας για οδηγίες!',
  ),
  'verification' => 
  array (
    'title' => 'Επαλήθευση email',
    'heading' => 'Απαιτείται επαλήθευση μέσω email',
    'submit' => 
    array (
      'label' => 'Αποσύνδεση',
    ),
    'notification_success' => 'Check your inbox for instructions!',
    'notification_resend' => 'Verification email has been resent.',
    'before_proceeding' => 'Πριν συνεχίσετε, ελέγξτε το email σας για έναν σύνδεσμο επαλήθευσης.',
    'not_receive' => 'Εάν δεν λάβατε το email,',
    'request_another' => 'κάντε κλικ εδώ για να ζητήσετε άλλο ένα',
  ),
  'profile' => 
  array (
    'account' => 'Λογαριασμός',
    'profile' => 'Προφίλ',
    'my_profile' => 'Το Προφίλ μου',
    'personal_info' => 
    array (
      'heading' => 'Προσωπικές πληροφορίες',
      'subheading' => 'Επεξεργαστείτε τα προσωπικά σας στοιχεία.',
      'submit' => 
      array (
        'label' => 'Αποθήκευση',
      ),
      'notify' => 'Το προφίλ ενημερώθηκε με επιτυχία!',
    ),
    'password' => 
    array (
      'heading' => 'Κωδικός',
      'subheading' => 'Πρέπει να είναι τουλάχιστον 8 χαρακτήρες.',
      'submit' => 
      array (
        'label' => 'Αποθήκευση',
      ),
      'notify' => 'Ο κωδικός πρόσβασης ενημερώθηκε με επιτυχία!',
    ),
    '2fa' => 
    array (
      'title' => 'Two Factor Authentication',
      'description' => 'Manage 2 factor authentication for your account (recommended).',
      'actions' => 
      array (
        'enable' => 'Enable',
        'regenerate_codes' => 'Regenerate Codes',
        'disable' => 'Disable',
        'confirm_finish' => 'Confirm & finish',
        'cancel_setup' => 'Cancel setup',
      ),
      'setup_key' => 'Setup key',
      'not_enabled' => 
      array (
        'title' => 'You have not enabled two factor authentication.',
        'description' => 'When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Finish enabling two factor authentication.',
        'description' => 'To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.',
      ),
      'enabled' => 
      array (
        'title' => 'You have enabled two factor authentication!',
        'description' => 'Two factor authentication is now enabled. This helps make your account more secure.',
        'store_codes' => 'Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.',
        'show_codes' => 'Show Recovery Codes',
        'hide_codes' => 'Hide Recovery Codes',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Code verified. Two factor authentication enabled.',
        'invalid_code' => 'The code you have entered is invalid.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API Tokens',
      'description' => 'Manage API tokens that allow third-party services to access this application on your behalf. NOTE: your token is shown once upon creation. If you lose your token, you will need to delete it and create a new one.',
      'create' => 
      array (
        'notify' => 'Token created successfully!',
        'submit' => 
        array (
          'label' => 'Create',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token updated successfully!',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Αντιγραφή στο πρόχειρο',
    'tooltip' => 'Αντιγράφηκε!',
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
      'label' => 'Συνδεθείτε',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Όνομα',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Κωδικός',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Κωδικός επιβεβαίωσης',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Νέος κωδικός',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Επιβεβαίωση κωδικού',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Token name',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Ικανότητες',
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
      'label' => 'Recovery Code',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Created',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    0 => 
    array (
      'label' => 'expires => "Expires',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'ή',
  'cancel' => 'Ακύρωση',
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

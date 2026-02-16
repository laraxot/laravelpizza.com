<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'Confirm password',
    'description' => 'Please confirm your password to complete this action.',
    'current_password' => 'Current password',
  ),
  'two_factor' => 
  array (
    'heading' => 'Two Factor Challenge',
    'description' => 'Please confirm access to your account by entering the code provided by your authenticator application.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Two Factor Challenge',
      'description' => 'Please confirm access to your account by entering one of your emergency recovery codes.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Lost device?',
    'recovery_code_link' => 'Use a recovery code',
    'back_to_login_link' => 'Back to login',
  ),
  'profile' => 
  array (
    'account' => 'Account',
    'profile' => 'Profile',
    'my_profile' => 'My Profile',
    'subheading' => 'Manage your user profile here.',
    'personal_info' => 
    array (
      'heading' => 'Personal Information',
      'subheading' => 'Manage your personal information.',
      'submit' => 
      array (
        'label' => 'Update',
      ),
      'notify' => 'Profile updated successfully!',
    ),
    'password' => 
    array (
      'heading' => 'Password',
      'subheading' => 'Must be at least  characters long.',
      'submit' => 
      array (
        'label' => 'Update',
      ),
      'notify' => 'Password updated successfully!',
    ),
    '2fa' => 
    array (
      'title' => 'Two Factor Authentication',
      'description' => 'Manage 2 factor authentication for your account (recommended).',
      'actions' => 
      array (
        'enable' => 'Enable',
        'regenerate_codes' => 'Regenerate Recovery Codes',
        'disable' => 'Disable',
        'confirm_finish' => 'Confirm & finish',
        'cancel_setup' => 'Cancel setup',
      ),
      'setup_key' => 'Setup key',
      'must_enable' => 'You must enable Two Factor Authentication to use this application.',
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
        'notify' => 'Two factor authentication enabled.',
        'title' => 'You have enabled two factor authentication!',
        'description' => 'Two factor authentication is now enabled. This helps make your account more secure.',
        'store_codes' => 'These codes can be used to recover access to your account if your device is lost. Warning! These codes will only be shown once.',
      ),
      'disabling' => 
      array (
        'notify' => 'Two factor authentication has been disabled.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'New recovery codes have been generated.',
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
      'description' => 'Manage API tokens that allow third-party services to access this application on your behalf.',
      'create' => 
      array (
        'notify' => 'Token created successfully!',
        'message' => 'Your token is only shown once upon creation. If you lose your token, you will need to delete it and create a new one.',
        'submit' => 
        array (
          'label' => 'Create',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token updated successfully!',
      ),
      'copied' => 
      array (
        'label' => 'I have copied my token',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Copy to clipboard',
    'tooltip' => 'Copied!',
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
      'label' => 'Name',
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
      'label' => 'Password confirm',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'New password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Confirm password',
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
    'token_expiry' => 
    array (
      'label' => 'Token expiry',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Abilities',
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
    'expires' => 
    array (
      'label' => 'Expires',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Or',
  'cancel' => 'Cancel',
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

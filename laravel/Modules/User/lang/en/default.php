<?php

declare(strict_types=1);

return [
    'password_confirm' => [
        'heading' => 'Confirm password',
        'description' => 'Please confirm your password to complete this action.',
        'current_password' => 'Current password',
    ],
    'two_factor' => [
        'heading' => 'Two Factor Challenge',
        'description' => 'Please confirm access to your account by entering the code provided by your authenticator application.',
        'code_placeholder' => 'XXX-XXX',
        'recovery' => [
            'heading' => 'Two Factor Challenge',
            'description' => 'Please confirm access to your account by entering one of your emergency recovery codes.',
        ],
        'recovery_code_placeholder' => 'abcdef-98765',
        'recovery_code_text' => 'Lost device?',
        'recovery_code_link' => 'Use a recovery code',
        'back_to_login_link' => 'Back to login',
    ],
    'profile' => [
        'account' => 'Account',
        'profile' => 'Profile',
        'my_profile' => 'My Profile',
        'subheading' => 'Manage your user profile here.',
        'personal_info' => [
            'heading' => 'Personal Information',
            'subheading' => 'Manage your personal information.',
            'submit' => [
                'label' => 'Update',
            ],
            'notify' => 'Profile updated successfully!',
        ],
        'password' => [
            'heading' => 'Password',
            'subheading' => 'Must be at least  characters long.',
            'submit' => [
                'label' => 'Update',
            ],
            'notify' => 'Password updated successfully!',
        ],
        '2fa' => [
            'title' => 'Two Factor Authentication',
            'description' => 'Manage 2 factor authentication for your account (recommended).',
            'actions' => [
                'enable' => 'Enable',
                'regenerate_codes' => 'Regenerate Recovery Codes',
                'disable' => 'Disable',
                'confirm_finish' => 'Confirm & finish',
                'cancel_setup' => 'Cancel setup',
            ],
            'setup_key' => 'Setup key',
            'must_enable' => 'You must enable Two Factor Authentication to use this application.',
            'not_enabled' => [
                'title' => 'You have not enabled two factor authentication.',
                'description' => 'When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.',
            ],
            'finish_enabling' => [
                'title' => 'Finish enabling two factor authentication.',
                'description' => 'To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.',
            ],
            'enabled' => [
                'notify' => 'Two factor authentication enabled.',
                'title' => 'You have enabled two factor authentication!',
                'description' => 'Two factor authentication is now enabled. This helps make your account more secure.',
                'store_codes' => 'These codes can be used to recover access to your account if your device is lost. Warning! These codes will only be shown once.',
            ],
            'disabling' => [
                'notify' => 'Two factor authentication has been disabled.',
            ],
            'regenerate_codes' => [
                'notify' => 'New recovery codes have been generated.',
            ],
            'confirmation' => [
                'success_notification' => 'Code verified. Two factor authentication enabled.',
                'invalid_code' => 'The code you have entered is invalid.',
            ],
        ],
        'sanctum' => [
            'title' => 'API Tokens',
            'description' => 'Manage API tokens that allow third-party services to access this application on your behalf.',
            'create' => [
                'notify' => 'Token created successfully!',
                'message' => 'Your token is only shown once upon creation. If you lose your token, you will need to delete it and create a new one.',
                'submit' => [
                    'label' => 'Create',
                ],
            ],
            'update' => [
                'notify' => 'Token updated successfully!',
            ],
            'copied' => [
                'label' => 'I have copied my token',
            ],
        ],
    ],
    'clipboard' => [
        'link' => 'Copy to clipboard',
        'tooltip' => 'Copied!',
    ],
    'or' => 'Or',
    'cancel' => 'Cancel',
    'login' => [
        'username_or_email' => 'Username or email',
        'forgot_password_link' => 'Forgot password?',
        'create_an_account' => 'create an account',
    ],
    'registration' => [
        'title' => 'Registration',
        'heading' => 'Create a new account',
        'submit' => [
            'label' => 'Registration',
        ],
        'notification_unique' => 'An account with this email already exists. Try logging in.',
    ],
    'reset_password' => [
        'title' => 'Forgot password',
        'heading' => 'Reset your password',
        'submit' => [
            'label' => 'Continue',
        ],
        'notification_error' => 'Error resetting the password. Please try again.',
        'notification_error_link_text' => 'Try again',
        'notification_success' => 'Check your inbox for further instructions!',
    ],
    'verification' => [
        'title' => 'Verify email',
        'heading' => 'Email address verification required',
        'submit' => [
            'label' => 'Log out',
        ],
        'notification_success' => 'Check your inbox for further instructions!',
        'notification_resend' => 'A verification email has been sent.',
        'before_proceeding' => 'Before continuing, check your inbox to verify your email.',
        'not_receive' => 'If you did not receive the verification email,',
        'request_another' => 'click here to request another',
    ],
];

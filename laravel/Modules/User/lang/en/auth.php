<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'help' => 'Your email address for authentication',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'help' => 'Your account password',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Sign in',
            'success' => 'Login successful',
            'error' => 'Invalid credentials',
        ],
        'logout' => [
            'label' => 'Logout',
            'success' => 'Logout successful',
            'error' => 'Logout failed',
        ],
    ],
    'messages' => [
        'failed' => 'These credentials do not match our records.',
        'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        'unauthorized' => 'You are not authorized to access this resource.',
    ],
    // Registration Widget - specific translations
    'register' => [
        'title' => 'Create a new account',
        'subtitle' => 'Enter your details to register',
        'name' => 'Full name',
        'name_placeholder' => 'Mario Rossi',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'password_confirmation' => 'Confirm password',
        'password_confirmation_placeholder' => '••••••••',
        'submit' => 'Register',
        'success' => 'Registration completed successfully.',
        'failed' => 'Unable to complete registration.',
        'already_have_account' => 'Already have an account?',
        'error_occurred' => 'An error occurred during registration. Please try again.',
        'name_structured' => [
            'label' => 'Name',
            'placeholder' => 'Enter your full name',
        ],
        'email_structured' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
        ],
        'password_structured' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
        ],
        'password_confirmation_structured' => [
            'label' => 'Confirm Password',
            'placeholder' => 'Confirm your password',
        ],
        'fields' => [
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email address',
            'password' => 'Password',
            'password_confirmation' => 'Confirm password',
        ],
        'help' => [
            'email' => 'Enter a valid email address',
            'password' => 'Password must be at least 12 characters, include uppercase, lowercase, number and special character',
        ],
        'validation' => [
            'password' => [
                'complexity' => 'Password must be at least 12 characters, include uppercase, lowercase, number and special character',
            ],
        ],
    ],
    'gdpr' => [
        'privacy_policy' => [
            'required' => 'You must accept the privacy policy to continue.',
        ],
        'terms' => [
            'required' => 'You must accept the terms and conditions to continue.',
        ],
        'links' => [
            'privacy' => 'the privacy policy',
            'terms' => 'the terms and conditions',
            'and' => 'and',
            'period' => '.',
        ],
        'privacy_policy_label' => 'I have read and understood the LaravelPizza.com Privacy Policy and I accept the processing of my personal data as described in the policy.',
        'privacy_policy_required' => 'You must accept the privacy policy to proceed with registration.',
        'privacy_policy_hint' => 'Full notice pursuant to Articles 13 and 14 of Regulation (EU) 2016/679 (GDPR)',
        'terms_label' => 'I have read and accept the LaravelPizza.com Terms and Conditions.',
        'terms_required' => 'You must accept the terms and conditions to proceed with registration.',
        'terms_hint' => 'Service contract pursuant to Article 6(1)(b) of Regulation (EU) 2016/679 (GDPR)',
        'data_processing_label' => 'I consent to the processing of my personal data (first name, last name, email) for the purpose of creating and managing my user account on LaravelPizza.com, necessary for the provision of requested services.',
        'data_processing_required' => 'You must accept the data processing to proceed with registration.',
        'data_processing_hint' => 'Legal basis: Contract performance (Art. 6(1)(b) GDPR)',
        'marketing_label' => 'I consent to receiving marketing and promotional communications from LaravelPizza.com via email, regarding meetup events, new features and special offers.',
        'marketing_hint' => 'This consent is optional and you can withdraw it at any time without consequences.',
        'cookie_policy_label' => 'I consent to the use of technical, analytical and marketing cookies to improve user experience.',
        'cookie_policy_hint' => 'For more information, please read our Cookie Policy.',
        'withdrawal_notice' => 'You can withdraw your consent at any time from your privacy dashboard.',
        'data_minimization' => 'We only collect data strictly necessary to provide you with the requested services.',
        'retention_period' => 'Personal data will be retained for the period necessary for the processing purposes.',
        'rights_notice' => 'In accordance with GDPR, you have the right to access, rectify, delete your data and object to processing.',
        'complaint_right' => 'You have the right to lodge a complaint with the Data Protection Authority.',
        'international_transfers' => 'Personal data are not transferred to third countries outside the EU.',
        'automated_decisions' => 'Your data is not subject to automated decision-making without human intervention.',
    ],
    // Password Reset Widget - specific translations
    'password_reset' => [
        'email_placeholder' => 'Enter your email address',
        'send_button' => 'Send reset link',
        'back_to_login' => 'Back to login',
        'send_another' => 'Send another link',
        'email_sent' => [
            'title' => 'Email sent!',
            'message' => 'We have sent you a password reset link. Check your email inbox and follow the instructions.',
        ],
        'email_failed' => [
            'title' => 'Sending error',
            'generic' => 'An error occurred while sending the email. Please try again later.',
        ],
        'password_requirements' => 'Password must be at least 8 characters',
        'processing' => 'Processing...',
        'instructions' => [
            'title' => 'Reset instructions',
            'description' => 'Enter your email and new password to complete the reset.',
        ],
        'confirm_button' => 'Confirm new password',
        'request_new_link' => 'Request a new link',
        'security' => [
            'title' => 'Security',
            'note' => 'The reset link is valid for 60 minutes and can only be used once.',
        ],
        'success' => [
            'title' => 'Password reset successfully!',
            'message' => 'Your password has been updated. You can now log in with your new password.',
            'redirect_notice' => 'Automatic redirect in progress...',
            'go_to_dashboard' => 'Go to dashboard',
            'go_to_login' => 'Go to login',
        ],
        'errors' => [
            'title' => 'Password reset error',
            'invalid_token' => 'The reset link is no longer valid or has expired.',
            'invalid_user' => 'Unable to find a user with this email address.',
            'generic' => 'An error occurred while resetting the password. Please try again later.',
            'possible_causes' => 'Possible causes:',
            'causes' => [
                'expired_token' => 'The reset link has expired (valid for 60 minutes)',
                'invalid_email' => 'The email address does not match any account',
                'already_used' => 'The reset link has already been used',
            ],
            'try_again' => 'Try again',
        ],
    ],
];

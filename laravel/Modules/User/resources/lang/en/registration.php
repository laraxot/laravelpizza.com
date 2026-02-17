<?php

declare(strict_types=1);

return [
    'fields' => [
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter your first name',
            'tooltip' => 'Enter your first name',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter your last name',
            'tooltip' => 'Enter your last name',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'tooltip' => 'Enter a valid email address',
            'helper_text' => '',
            'description' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter your phone number',
            'tooltip' => 'Enter a valid phone number',
            'helper_text' => '',
            'description' => '',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter your address',
            'tooltip' => 'Enter your residential address',
            'helper_text' => '',
            'description' => '',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter your city',
            'tooltip' => 'Enter your city of residence',
            'helper_text' => '',
            'description' => '',
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'placeholder' => 'Enter postal code',
            'tooltip' => 'Enter your postal code',
            'helper_text' => '',
            'description' => '',
        ],
        'province' => [
            'label' => 'Province',
            'placeholder' => 'Enter province',
            'tooltip' => 'Enter your province of residence',
            'helper_text' => '',
            'description' => '',
        ],
        'country' => [
            'label' => 'Country',
            'placeholder' => 'Enter country',
            'tooltip' => 'Enter your country of residence',
            'default' => 'Italy',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'tooltip' => 'Password must be at least 8 characters long',
            'helper_text' => '',
            'description' => '',
        ],
        'password_confirmation' => [
            'label' => 'Confirm Password',
            'placeholder' => 'Confirm your password',
            'tooltip' => 'Re-enter your password for confirmation',
            'helper_text' => '',
            'description' => '',
        ],
        'terms' => [
            'label' => 'I accept the terms and conditions',
            'tooltip' => 'You must accept the terms and conditions to proceed',
            'helper_text' => '',
            'description' => '',
        ],
        'newsletter' => [
            'label' => 'Subscribe to newsletter',
            'tooltip' => 'Receive updates and news via email',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'buttons' => [
        'register' => 'Register',
        'next' => 'Next',
        'back' => 'Back',
        'complete' => 'Complete Registration',
    ],
    'messages' => [
        'success' => 'Registration completed successfully!',
        'error' => 'An error occurred during registration.',
        'validation_error' => 'Please fill in all required fields to proceed.',
    ],
    'steps' => [
        'personal_data' => [
            'title' => 'Personal Data',
            'description' => 'Enter your personal information',
        ],
        'contacts' => [
            'title' => 'Contacts and Address',
            'description' => 'Enter your contact information and address',
        ],
        'isee' => [
            'title' => 'ISEE Data',
            'description' => 'Enter ISEE data (optional)',
        ],
        'confirmation' => [
            'title' => 'Confirm Data',
            'description' => 'Verify your information before completing registration',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];

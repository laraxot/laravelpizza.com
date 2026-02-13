<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'register' => [
        'title' => 'Start Your Pizza Journey 🍕',
        'subtitle' => 'Join 5,000+ pizza lovers and developers. Get exclusive access to meetups and tutorials.',
        'submit' => 'Join the Community Now',
        'submitting' => 'Setting up your oven...',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Your Best Email',
        'password' => 'Secure Password',
        'password_confirmation' => 'Confirm Password',
    ],

    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Personal Information',
        'user_info_description' => 'Enter your personal information to create your account',
        'required_consents' => 'Required Consent',
        'required_consents_description' => 'To proceed with registration, you must accept the following conditions for processing your personal data',
        'optional_consents' => 'Optional Consent',
        'optional_consents_description' => 'These consents are optional and do not affect your registration. You can modify them at any time from your profile.',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Privacy Consents',
        'privacy_policy_label' => 'I have read and understood the Privacy Policy and accept the processing of my personal data as described in the policy.',
        'privacy_policy_hint' => 'Full privacy notice pursuant to Articles 13 and 14 of Regulation (EU) 2016/679 (GDPR)',
        'privacy_policy_required' => 'Please accept the privacy policy.',
        'privacy_checkbox_html' => 'I have read the <a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Privacy Policy</a>',
        'terms_label' => 'I have read and accept the Terms and Conditions',
        'terms_hint' => 'Service contract pursuant to Article 6(1)(b) of Regulation (EU) 2016/679 (GDPR)',
        'terms_required' => 'Please accept the terms and conditions.',
        'terms_checkbox_html' => 'I accept the <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Terms & Conditions</a>',
        'marketing_label' => 'Send me pizza tips and meetup invites (Optional)',
        'marketing_hint' => 'The consent is optional and you can withdraw it at any time without consequences.',
        'required_consent_missing' => 'You must accept all required consents to proceed.',
    ],

    // === ACTIONS ===
    'actions' => [
        'read_privacy_policy' => 'Read privacy policy',
        'read_terms' => 'Read terms and conditions',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'Password must contain at least 12 characters, one uppercase letter, one lowercase letter, one number, and one special character.',
    ],

    // === MESSAGES ===
    'already_registered' => 'Already have an account?',
    'login' => 'Sign in',
    'success' => 'Registration completed successfully! Your account has been created in compliance with GDPR.',
    'success_message' => 'Welcome to LaravelPizza Meetups! Your registration is complete and all your consents have been properly recorded.',
    'error' => 'Registration error',
    'error_message' => 'An error occurred during registration. Please try again later. If the problem persists, contact our support.',
];

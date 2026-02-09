<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'register' => [
        'title' => 'Start Your Pizza Journey 🍕',
        'subtitle' => 'Join 5,000+ pizza lovers and developers. Get exclusive access to meetups and tutorials.',
        'submit' => 'Join the Community Now',
        'submitting' => 'Setting up your oven...',
        'already_have_account' => 'Already a member?',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Your Best Email',
        'password' => 'Secure Password',
        'password_confirmation' => 'Confirm Password',
    ],

    // === CONSENTS ===
    'consents' => [
        'privacy_policy_label' => 'I have read and understood the Privacy Policy and accept the processing of my personal data as described in the policy.',
        'privacy_policy_hint' => 'Full privacy notice pursuant to Articles 13 and 14 of Regulation (EU) 2016/679 (GDPR)',
        'privacy_policy_required' => 'Please accept the privacy policy.',
        'terms_required' => 'Please accept the terms and conditions.',
        'marketing_label' => 'Send me pizza tips and meetup invites (Optional)',
        
        'privacy_checkbox_html' => 'I have read the <a href=":privacy_url" target="_blank" class="underline font-bold">Privacy Policy</a>',
        'terms_checkbox_html' => 'I accept the <a href=":terms_url" target="_blank" class="underline font-bold">Terms & Conditions</a>',

        'required_consent_missing' => 'You must accept all required consents to proceed.',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'Password must contain at least 12 characters, one uppercase letter, one lowercase letter, one number, and one special character.',
    ],

    // === MESSAGES ===
    'success' => 'Registration completed successfully! Your account has been created in compliance with GDPR.',
    'success_message' => 'Welcome to LaravelPizza Meetups! Your registration is complete and all your consents have been properly recorded.',
    
    'error' => 'Registration error',
    'error_message' => 'An error occurred during registration. Please try again later. If the problem persists, contact our support.',
];

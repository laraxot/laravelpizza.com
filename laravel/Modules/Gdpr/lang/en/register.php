<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'register' => [
        'title' => 'Unlock Your Pizza Passion: Register Now! 🚀',
        'subtitle' => 'Join 5,000+ developers and food lovers. Get instant access to exclusive meetups, cutting-edge tutorials, and unparalleled networking. Your next big idea (or slice) awaits!',
        'submit' => 'Claim Your Free Account Now!',
        'submitting' => 'Igniting your pizza journey...',
        'already_have_account' => 'Already a member?',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'First Name',
        'first_name.placeholder' => 'Enter your first name',
        'first_name.helper_text' => 'We\'ll use this to personalize your experience.',
        'last_name' => 'Last Name',
        'last_name.placeholder' => 'Enter your last name',
        'last_name.helper_text' => 'So we know what to call you.',
        'email' => 'Your best Email',
        'email.placeholder' => 'your.email@example.com',
        'email.helper_text' => 'We\'ll send you exclusive updates and offers.',
        'password' => 'Secure Password',
        'password.placeholder' => '••••••••••••',
        'password.helper_text' => 'Must be at least 12 characters, including numbers and symbols for ultimate security.',
        'password_confirmation' => 'Confirm Password',
        'password_confirmation.placeholder' => '••••••••••••',
        'password_confirmation.helper_text' => 'Just to make sure you typed it correctly!',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Privacy Consents',
        'privacy_checkbox_html' => 'I have read and accept the <a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Privacy Policy</a>',
        'privacy_policy_required' => 'You must accept the privacy policy to proceed.',
        'terms_checkbox_html' => 'I have read and accept the <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Terms and Conditions</a>',
        'terms_required' => 'You must accept the terms and conditions to proceed.',
        'marketing_label' => 'I want to receive pizza tips and meetup invites (optional)',
        'required_consent_missing' => 'You must accept all required consents to proceed.',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'Password must contain at least 12 characters, one uppercase letter, one lowercase letter, one number, and one special character.',
    ],

    // === MESSAGES ===
    'success' => 'Welcome to the family! 🎉',
    'success_message' => 'Your account is ready. Start exploring all the meetups!',
    'error' => 'Oops! Something went wrong.',
    'error_message' => 'Please try again in a moment, we\'re fixing the issue.',
    'login' => 'Sign in now',
    'already_registered' => 'Already have an account?',
];

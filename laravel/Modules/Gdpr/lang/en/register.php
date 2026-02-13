<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'title' => 'Start Your Pizza Journey 🍕',
    'subtitle' => 'Join our growing community of pizza lovers and developers. Get exclusive access to meetups and tutorials.',
    'submit' => 'Join the Community Now',
    'submitting' => 'Setting up your oven...',

    // Alias for legacy nested access (gdpr::register.register.submit)
    'register' => [
        'submit' => 'Join the Community Now',
        'submitting' => 'Setting up your oven...',
    ],

    // === STATS ===
    'stats' => [
        'active_developers' => 'Growing Community',
        'monthly_meetups' => 'Upcoming Events',
        'community_support' => '24/7 Support',
    ],

    // === FORM ===
    'form' => [
        'cta_title' => 'Create Your FREE Account',
        'cta_subtitle' => 'No credit card required - 100% FREE forever!',
        'terms_notice' => 'By registering you agree to our Terms and Privacy Policy',
    ],

    // === BENEFITS CTA ===
    'benefits' => [
        'community' => [
            'title' => 'Join Our Developer Community',
            'description' => 'Connect with Laravel professionals and enthusiasts worldwide',
            'cta' => 'FREE access immediately after signup',
        ],
        'tutorials' => [
            'title' => 'Exclusive Tutorials & Workshops',
            'description' => 'Priority access to premium content and training',
            'cta' => 'Get exclusive access', // Changed from 'Worth €997/year - FREE for members'
        ],
        'networking' => [
            'title' => 'Networking & Career',
            'description' => 'Collaboration opportunities and professional growth',
            'cta' => 'Get hired by top Laravel companies',
        ],
    ],

    // === SOCIAL PROOF ===
    'social_proof' => 'Join the LaravelPizza community',

    // === FIELDS ===
    'fields' => [
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Mario',
            'helper_text' => 'Enter your first name to complete your profile',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Rossi',
            'helper_text' => 'Enter your last name to complete your profile',
        ],
        'email' => [
            'label' => 'Your Best Email',
            'placeholder' => 'mario.rossi@example.com',
            'helper_text' => 'We\'ll send a confirmation email to this address',
        ],
        'password' => [
            'label' => 'Secure Password',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Must contain at least 12 characters, uppercase, lowercase, number and symbol',
        ],
        'password_confirmation' => [
            'label' => 'Confirm Password',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Repeat the password to confirm',
        ],
    ],

    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Personal Information',
        'user_info_description' => 'Enter your personal information to create your account',
        'required_consents' => 'Required Consent',
        'required_consents_description' => 'To proceed with registration, you must accept the following conditions for processing your personal data',
        'optional_consents' => 'Optional Consent',
        'optional_consents_description' => 'These consents are optional and do not affect your registration. You can modify them at any time from your profile.',
        'trust_badges' => 'Trust badges',
        'registration_form' => 'Registration Form',
        'benefits' => 'Benefits',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Privacy Consents',
        'privacy_policy_label' => 'I have read and understood the Privacy Policy and accept the processing of my personal data as described in the policy.',
        'privacy_policy_hint' => 'Full privacy notice pursuant to Articles 13 and 14 of Regulation (EU) 2016/679 (GDPR)',
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
    'required_consent_missing' => 'You must accept all required consents to proceed.',
    'success' => 'Registration completed successfully! Your account has been created GDPR compliant.',
    'success_message' => 'Welcome to LaravelPizza Meetups! Your registration is complete and all your consents have been correctly recorded.',
    'error' => 'Registration error',
    'error_message' => 'An error occurred during registration. Please try again later. If the problem persists, contact our support.',

    // === CLICKBAIT & MARKETING ===
    'clickbait' => [
        'active_developers' => 'Active Developers',
        'monthly_meetups' => 'Monthly Meetups',
        'community_support' => 'Community Support',
        'free_access' => 'FREE access immediately after signup',
        'worth_free' => 'Get exclusive access', // Changed from 'Worth €997/year - FREE for members'
        'get_hired' => 'Get hired by top Laravel companies',
        'join_now' => 'Join NOW before registration closes!',
        'create_account' => 'Create Your FREE Account',
        'no_card_required' => 'No credit card required - 100% FREE forever!',
        'by_registering' => 'By registering you agree to our Terms and Privacy Policy',
    ],

    // === SEO KEYWORDS ===
    'seo' => [
        'description' => 'Join LaravelPizza community for exclusive meetups, premium tutorials, and networking. Free access to workshops and community events.',
        'laravel_meetup' => 'Laravel meetup',
        'laravel_community' => 'Laravel community',
        'php_developer_community' => 'PHP developer community',
        'laravel_tutorials' => 'Laravel tutorials',
        'laravel_workshops' => 'Laravel workshops',
        'laravel_networking' => 'Laravel networking',
        'laravelpizza' => 'LaravelPizza',
    ],
];

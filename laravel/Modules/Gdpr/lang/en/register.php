<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Personal Information',
        'user_info_description' => 'Enter your personal details to create your account',
        'required_consents' => 'Required Consents',
        'required_consents_description' => 'To proceed with registration, you must accept the following conditions for the processing of your personal data',
        'optional_consents' => 'Optional Consents',
        'optional_consents_description' => 'These consents are optional and do not affect your registration. You can change them at any time from your privacy dashboard.',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email Address',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
    ],

    // === CONSENTS ===
    'consents' => [
        'privacy_policy_label' => 'I have read and understood the Privacy Policy and accept the processing of my personal data as described in the policy.',
        'privacy_policy_hint' => 'Full privacy notice pursuant to Articles 13 and 14 of Regulation (EU) 2016/679 (GDPR)',
        'privacy_policy_required' => 'You must accept the privacy policy to proceed with registration.',
        
        'terms_label' => 'I have read and accept the Terms and Conditions of use',
        'terms_hint' => 'Service agreement pursuant to Article 6(1)(b) of Regulation (EU) 2016/679 (GDPR)',
        'terms_required' => 'You must accept the terms and conditions to proceed with registration.',
        
        'data_processing_label' => 'I consent to the processing of my personal data for the creation and management of my user account',
        'data_processing_hint' => 'Legal basis: Contract execution (Art. 6(1)(b) GDPR)',
        'data_processing_required' => 'You must accept personal data processing to proceed with registration.',
        
        'marketing_label' => 'I consent to receive marketing and promotional communications regarding meetup events and new features',
        'marketing_hint' => 'Consent is optional and you can withdraw it at any time without consequences.',
        
        'profiling_label' => 'I consent to the analysis of my preferences to personalize the user experience',
        'profiling_hint' => 'Analysis based on browsing data and interactions to improve our services.',
        
        'analytics_label' => 'I consent to anonymous statistical analysis of browsing data to improve site performance',
        'analytics_hint' => 'Data collected in anonymous and aggregated form for statistical purposes.',
        
        'third_party_label' => 'I consent to sharing my data with selected partners for integrated services',
        'third_party_hint' => 'Only GDPR-compliant partners and for specific, limited purposes.',

        'required_consent_missing' => 'You must accept all required consents to proceed with registration.',
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

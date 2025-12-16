<?php

declare(strict_types=1);

return [
    'fields' => [
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter your first name',
            'tooltip' => 'Enter your first name',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter your last name',
            'tooltip' => 'Enter your last name',
            'help' => 'Your family name',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'tooltip' => 'Enter a valid email address',
            'help' => 'Valid email address you will use to sign in',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter your phone number',
            'tooltip' => 'Enter a valid phone number',
            'help' => 'Phone number to be contacted',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter your address',
            'tooltip' => 'Enter your residential address',
            'help' => 'Street and house number of residence',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter your city',
            'tooltip' => 'City of residence or location',
            'helper_text' => 'Enter the name of the city where you reside or are located',
            'description' => 'Field to specify the user\'s city of residence for registration',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'placeholder' => 'Enter postal code',
            'tooltip' => 'Enter your postal code',
        ],
        'province' => [
            'label' => 'Province',
            'placeholder' => 'Enter province',
            'tooltip' => 'Province of residence or state',
            'helper_text' => 'Enter the name of your province or state of residence',
            'description' => 'Field to specify the user\'s province or state for registration and location purposes',
            'icon' => 'heroicon-o-map',
            'color' => 'secondary',
        ],
        'country' => [
            'label' => 'Country',
            'placeholder' => 'Enter country',
            'tooltip' => 'Enter your country of residence',
            'default' => 'Italy',
            'help' => 'Country of residence',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'tooltip' => 'Password must be at least 8 characters long',
            'help' => 'At least 8 characters with letters, numbers, and symbols',
        ],
        'password_confirmation' => [
            'label' => 'Confirm Password',
            'placeholder' => 'Confirm your password',
            'tooltip' => 'Re-enter your password for confirmation',
            'help' => 'Re-enter the password to confirm it',
        ],
        'terms' => [
            'label' => 'I accept the terms and conditions',
            'tooltip' => 'You must accept the terms and conditions to proceed',
            'placeholder' => 'Accept the terms and conditions',
            'help' => 'You must accept the terms and conditions to continue',
        ],
        'newsletter' => [
            'label' => 'Subscribe to newsletter',
            'tooltip' => 'Receive updates and news via email',
        ],
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter your name',
            'help' => 'Your given name',
        ],
        'state' => [
            'label' => 'Province/State',
            'placeholder' => 'Enter province or state',
            'tooltip' => 'Italian province or foreign state',
            'help' => 'Italian province or state if abroad',
            'description' => 'Province for Italian addresses, state for foreign ones',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
        'zip' => [
            'label' => 'ZIP Code',
            'placeholder' => 'Enter ZIP code',
            'help' => 'Postal code',
        ],
        'fiscal_code' => [
            'label' => 'Tax Code',
            'placeholder' => 'Enter tax code',
            'help' => 'Italian tax code (16 characters)',
        ],
        'birth_date' => [
            'label' => 'Date of Birth',
            'placeholder' => 'Select your date of birth',
            'help' => 'Your date of birth in dd/mm/yyyy format',
        ],
        'birth_place' => [
            'label' => 'Place of Birth',
            'placeholder' => 'Enter place of birth',
            'tooltip' => 'City and province/state of birth',
            'help' => 'City and province/state of birth',
            'description' => 'Place of birth for demographic documentation',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
        'gender' => [
            'label' => 'Gender',
            'placeholder' => 'Select gender',
            'help' => 'Demographic gender',
        ],
        'nationality' => [
            'label' => 'Nationality',
            'placeholder' => 'Enter nationality',
            'help' => 'Nationality as per your identity document',
        ],
        'document_type' => [
            'label' => 'Document Type',
            'placeholder' => 'Select document type',
            'help' => 'Identity card, driver\'s license, passport',
        ],
        'document_number' => [
            'label' => 'Document Number',
            'placeholder' => 'Enter document number',
            'help' => 'Document unique identifier',
        ],
        'document_issue_date' => [
            'label' => 'Issue Date',
            'placeholder' => 'Select issue date',
            'help' => 'Date when the document was issued',
        ],
        'document_expiry_date' => [
            'label' => 'Expiry Date',
            'placeholder' => 'Select expiry date',
            'help' => 'Document expiration date',
        ],
        'document_issuing_authority' => [
            'label' => 'Issuing Authority',
            'placeholder' => 'Enter the issuing authority',
            'help' => 'Municipality, police headquarters, or other issuing body',
        ],
        'document_file' => [
            'label' => 'Document File',
            'placeholder' => 'Upload a scan of the document',
            'help' => 'Front/back scan in PDF or JPG format',
        ],
        'photo' => [
            'label' => 'Profile Photo',
            'placeholder' => 'Upload a profile photo',
            'help' => 'Recent photo; square format recommended',
        ],
        'cv' => [
            'label' => 'Curriculum Vitae',
            'placeholder' => 'Upload your CV',
            'help' => 'Updated CV in PDF format',
        ],
        'bio' => [
            'label' => 'Biography',
            'placeholder' => 'Write a short biography',
            'help' => 'Describe yourself and your skills',
        ],
        'professional_title' => [
            'label' => 'Professional Title',
            'placeholder' => 'Enter your professional title',
            'help' => 'Your main qualification or position',
        ],
        'privacy' => [
            'label' => 'Privacy Policy',
            'placeholder' => 'Accept the privacy policy',
            'help' => 'Required consent for personal data processing',
        ],
        'marketing' => [
            'label' => 'Marketing Communications',
            'placeholder' => 'Agree to receive promotional communications',
            'help' => 'Optional consent to receive newsletters and promotions',
        ],
        'moderation_status' => [
            'label' => 'Moderation Status',
            'placeholder' => 'Current moderation status',
            'help' => 'Profile verification status by administrators',
        ],
        'moderation_notes' => [
            'label' => 'Moderation Notes',
            'placeholder' => 'Moderator notes',
            'help' => 'Any notes by the moderation team',
        ],
    ],
    'buttons' => [
        'register' => 'Register',
        'next' => 'Next',
        'back' => 'Back',
        'complete' => 'Complete Registration',
    ],
    'messages' => [
        'success' => [
            'registration' => 'Registration completed successfully! You will receive a confirmation email.',
            'step' => 'Step completed successfully',
        ],
        'error' => 'An error occurred during registration.',
        'validation_error' => 'Please fill in all required fields to proceed.',
        'welcome' => 'Welcome to the registration process',
        'step_completed' => 'Step completed successfully',
        'all_steps_completed' => 'All steps have been completed',
        'validation_errors' => 'Please check the highlighted fields and correct the errors',
        'required_fields' => 'Fields marked with * are required',
        'save_progress' => 'Your progress has been saved automatically',
        'errors' => [
            'general' => 'An error occurred during registration',
            'email_exists' => 'This email address is already registered',
            'validation' => 'Some fields contain errors; please review and try again',
        ],
    ],
    'steps' => [
        'personal_data' => [
            'title' => 'Personal Data',
            'description' => 'Enter your personal information',
        ],
        'contacts' => [
            'title' => 'Contacts and Address',
            'description' => 'Enter your contact information and address',
            'label' => 'Contatti',
            'icon' => 'heroicon-o-phone',
            'help' => 'Fornisci i tuoi recapiti per essere contattato',
        ],
        'isee' => [
            'title' => 'ISEE Data',
            'description' => 'Enter ISEE data (optional)',
        ],
        'confirmation' => [
            'title' => 'Confirm Data',
            'description' => 'Verify your information before completing registration',
        ],
        'personal_info' => [
            'label' => 'Dati Personali',
            'description' => 'Inserisci i tuoi dati anagrafici personali',
            'icon' => 'heroicon-o-user',
            'help' => 'Compila tutti i campi obbligatori con i tuoi dati personali',
        ],
        'credentials' => [
            'label' => 'Credenziali',
            'description' => 'Imposta email e password per l\'accesso',
            'icon' => 'heroicon-o-key',
            'help' => 'Scegli una password sicura per proteggere il tuo account',
        ],
        'privacy_step' => [
            'label' => 'Privacy e Consensi',
            'description' => 'Accetta i termini e le condizioni',
            'icon' => 'heroicon-o-shield-check',
            'help' => 'Leggi attentamente e accetta i consensi richiesti',
        ],
        'documents_step' => [
            'label' => 'Documenti',
            'description' => 'Carica i documenti richiesti',
            'icon' => 'heroicon-o-document',
            'help' => 'Carica i documenti necessari per la verifica dell\'identità',
        ],
        'professional' => [
            'label' => 'Informazioni Professionali',
            'description' => 'Inserisci le tue informazioni professionali',
            'icon' => 'heroicon-o-briefcase',
            'help' => 'Completa il tuo profilo professionale con esperienze e competenze',
        ],
        'availability' => [
            'label' => 'Disponibilità',
            'description' => 'Definisci i tuoi orari di disponibilità',
            'icon' => 'heroicon-o-calendar',
            'help' => 'Imposta quando sei disponibile per appuntamenti o contatti',
        ],
        'moderation' => [
            'label' => 'Moderazione',
            'description' => 'Stato di moderazione del profilo',
            'icon' => 'heroicon-o-check-badge',
            'help' => 'Il tuo profilo sarà verificato dal nostro team',
        ],
        'personal_data_step' => [
            'label' => 'Informazioni Aggiuntive',
            'description' => 'Completa con altre informazioni personali',
            'icon' => 'heroicon-o-identification',
            'help' => 'Fornisci informazioni aggiuntive per completare il profilo',
        ],
        'pre_visit_step' => [
            'label' => 'Pre-Visita',
            'description' => 'Informazioni preliminari per la visita',
            'icon' => 'heroicon-o-clipboard-document-list',
            'help' => 'Compila le informazioni necessarie per la pre-visita',
        ],
    ],
    'navigation' => [
        'label' => 'Registration',
        'group' => 'User Management',
        'icon' => 'heroicon-o-user-plus',
        'sort' => '50',
    ],
    'pages' => [
        'registration' => [
            'title' => 'User Registration',
            'subtitle' => 'Complete the registration by following all steps',
            'description' => 'Enter all required information to complete your registration',
        ],
        'wizard' => [
            'title' => 'Registration Wizard',
            'subtitle' => 'Guided procedure for registration',
            'description' => 'Follow the guided procedure to complete registration',
        ],
    ],
    'actions' => [
        'register' => [
            'label' => 'Register',
            'tooltip' => 'Complete the registration',
            'modal_heading' => 'Confirm Registration',
            'modal_description' => 'Do you confirm you want to complete the registration with the entered data?',
            'success' => 'Registration completed successfully',
            'error' => 'An error occurred during registration',
        ],
        'previous' => [
            'label' => 'Previous',
            'tooltip' => 'Go back to the previous step',
        ],
        'next' => [
            'label' => 'Next',
            'tooltip' => 'Proceed to the next step',
        ],
        'save_draft' => [
            'label' => 'Save Draft',
            'tooltip' => 'Save the entered data as a draft',
            'success' => 'Draft saved successfully',
            'error' => 'Error while saving the draft',
        ],
    ],
];

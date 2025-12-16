<?php

declare(strict_types=1);

return [
    'edit_user' => [
        'title' => 'Edit User Profile',
        'description' => 'Update user profile information',
        'sections' => [
            'personal_info' => [
                'title' => 'Personal Information',
                'description' => 'Personal data and contacts',
            ],
            'preferences' => [
                'title' => 'Preferences',
                'description' => 'Personal settings and language',
            ],
            'security' => [
                'title' => 'Security',
                'description' => 'Password and security settings',
            ],
            'admin_settings' => [
                'title' => 'Administrator Settings',
                'description' => 'Configurations reserved for administrators',
            ],
        ],
        'fields' => [
            'profile_photo_path' => [
                'label' => 'Profile Photo',
                'placeholder' => 'Upload a profile photo',
                'help' => 'Supported formats: JPEG, PNG, WebP. Maximum size: 2MB',
            ],
            'first_name' => [
                'label' => 'First Name',
                'placeholder' => 'Enter your first name',
                'help' => 'Your given name',
            ],
            'last_name' => [
                'label' => 'Last Name',
                'placeholder' => 'Enter your last name',
                'help' => 'Your family name',
            ],
            'name' => [
                'label' => 'Full Name',
                'placeholder' => 'Enter your full name',
                'help' => 'First and last name as they should appear in the system',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter your email address',
                'help' => 'Email address for login and communications',
            ],
            'lang' => [
                'label' => 'Language',
                'placeholder' => 'Select language',
                'help' => 'User interface language',
                'options' => [
                    'it' => 'Italiano',
                    'en' => 'English',
                    'es' => 'Español',
                    'fr' => 'Français',
                    'de' => 'Deutsch',
                ],
            ],
            'password' => [
                'label' => 'New Password',
                'placeholder' => 'Enter a new password',
                'help' => 'Leave empty to keep current password',
            ],
            'password_confirmation' => [
                'label' => 'Confirm Password',
                'placeholder' => 'Confirm your new password',
                'help' => 'Repeat the new password for confirmation',
            ],
            'is_otp' => [
                'label' => 'Two-Factor Authentication (OTP)',
                'help' => 'Enable two-factor authentication for enhanced security',
            ],
            'password_expires_at' => [
                'label' => 'Password Expiration',
                'placeholder' => 'Select expiration date and time',
                'help' => 'Date and time when the password will expire',
            ],
            'is_active' => [
                'label' => 'Active Account',
                'help' => 'Determines if the account is active and can access the system',
            ],
        ],
        'actions' => [
            'save' => [
                'label' => 'Save Changes',
                'tooltip' => 'Save changes made to the profile',
            ],
            'cancel' => [
                'label' => 'Cancel',
                'tooltip' => 'Cancel changes and restore original values',
            ],
        ],
        'messages' => [
            'saved' => 'Profile updated successfully',
            'cancelled' => 'Changes cancelled',
            'error' => 'An error occurred while saving',
            'unauthorized' => 'You are not authorized to edit this profile',
        ],
        'validation' => [
            'email_unique' => 'This email address is already in use',
            'password_confirmation' => 'Password confirmation does not match',
            'required' => 'This field is required',
        ],
    ],
    'registration' => [
        'title' => 'User Registration',
        'description' => 'Create a new user account',
        'fields' => [
            'type' => [
                'label' => 'User Type',
                'placeholder' => 'Select user type',
                'help' => 'The type of account you are creating',
            ],
        ],
        'messages' => [
            'success' => 'Registration completed successfully',
            'error' => 'An error occurred during registration',
        ],
    ],
    'login' => [
        'title' => 'Login',
        'description' => 'Sign in to your account',
        'fields' => [
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter your email',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Enter your password',
            ],
            'remember' => [
                'label' => 'Remember me',
            ],
        ],
        'actions' => [
            'login' => [
                'label' => 'Sign In',
            ],
            'forgot_password' => [
                'label' => 'Forgot password?',
            ],
        ],
        'messages' => [
            'success' => 'Login successful',
            'error' => 'Invalid credentials',
        ],
    ],
    'logout' => [
        'title' => 'Logout',
        'description' => 'Sign out of your account',
        'actions' => [
            'logout' => [
                'label' => 'Sign Out',
            ],
            'confirm' => [
                'label' => 'Confirm',
            ],
            'cancel' => [
                'label' => 'Cancel',
            ],
        ],
        'messages' => [
            'success' => 'Logout successful',
            'confirm' => 'Are you sure you want to sign out?',
        ],
    ],
];

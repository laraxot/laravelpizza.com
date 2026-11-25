<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Profiles',
        'plural' => 'Profiles',
        'group' => [
            'label' => 'User management',
            'description' => 'Manage user profiles',
        ],
        'icon' => 'user-profile-animated',
        'sort' => '73',
    ],
    'fields' => [
        'first_name' => [
            'label' => 'First name',
            'placeholder' => 'Enter the first name',
            'help' => 'The user\'s first name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Last name',
            'placeholder' => 'Enter the last name',
            'help' => 'The user\'s last name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter the email',
            'help' => 'The user\'s email address',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter the phone number',
            'help' => 'The user\'s phone number',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'birth_date' => [
            'label' => 'Date of Birth',
            'placeholder' => 'Select the date of birth',
            'help' => 'The user\'s date of birth',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'gender' => [
            'label' => 'Gender',
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Active',
            'help' => 'Whether the profile is active',
        ],
    ],
    'actions' => [
        'edit' => [
            'label' => 'Edit',
            'success' => 'Profile updated successfully!',
            'error' => 'Error updating the profile',
        ],
        'delete' => [
            'label' => 'Delete',
            'success' => 'Profile deleted successfully!',
            'error' => 'Error deleting the profile',
        ],
    ],
    'messages' => [
        'update_success' => 'Profile updated successfully!',
        'no_permission' => 'You do not have permission to edit this profile.',
    ],
    'privacy_policy' => [
        'title' => 'Privacy policy',
        'description' => 'How we handle your personal data.',
    ],
    'label' => 'Profile',
    'plural_label' => 'Profiles',
    'delete_account' => [
        'title' => 'Delete Account',
        'description' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before proceeding, please download any data you wish to retain.',
        'password_confirmation' => 'Confirm your password',
        'button' => 'Delete Account',
        'delete' => 'Delete Account',
    ],
    'my_profile' => 'My Profile',
    'subheading' => 'Manage your personal details and security',
];

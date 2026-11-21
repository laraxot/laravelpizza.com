<?php

declare(strict_types=1);

return [
    'navigation' => [
<<<<<<< .merge_file_HKsP5h
        'label' => 'Profiles',
        'plural' => 'Profili',
        'group' => [
            'label' => 'User management',
            'description' => 'Gestione dei profili utente',
=======
        'label' => 'Profile',
        'plural' => 'Profiles',
        'group' => [
            'label' => 'User management',
            'description' => 'Manage user profiles',
>>>>>>> .merge_file_mvKnit
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
<<<<<<< .merge_file_HKsP5h
            'label' => 'Modifica',
            'success' => 'Profile updated.',
            'error' => 'Errore durante l\'aggiornamento del profilo',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Profile deleted.',
            'error' => 'Errore durante l\'eliminazione del profilo',
        ],
    ],
    'messages' => [
        'update_success' => 'Profile updated.',
        'no_permission' => 'Non hai i permessi per modificare questo profilo.',
=======
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
>>>>>>> .merge_file_mvKnit
    ],
    'privacy_policy' => [
        'title' => 'Privacy policy',
        'description' => 'How we handle your personal data.',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'delete_account' => [
        'title' => 'Delete Account',
        'description' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before proceeding, please download any data you wish to retain.',
        'password_confirmation' => 'Confirm your password',
        'button' => 'Delete Account',
        'delete' => 'Delete Account',
    ],
<<<<<<< .merge_file_HKsP5h
    'my_profile' => 'My profile',
    'subheading' => 'Your personal details and password',
=======
    'my_profile' => 'My Profile',
    'subheading' => 'Manage your personal details and security',
>>>>>>> .merge_file_mvKnit
];

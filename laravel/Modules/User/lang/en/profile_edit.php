<?php

declare(strict_types=1);

return [
    'fields' => [
        'current_password' => [
            'label' => 'Current Password',
        ],
        'new_password' => [
            'label' => 'New Password',
        ],
        'confirm_new_password' => [
            'label' => 'Confirm New Password',
        ],
        'first_name' => [
            'label' => '__(\'First Name\')',
        ],
        'last_name' => [
            'label' => '__(\'Last Name\')',
        ],
    ],
    'sections' => [
        'profile_information' => [
            'title' => '__(\'Profile Information\')',
            'description' => 'Update your account\'s profile information and email address.',
        ],
        'update_password' => [
            'description' => 'Ensure your account is using a long, random password to stay secure.',
        ],
        'delete_account' => [
            'description' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
        ],
    ],
    'actions' => [
        'update_profile' => [
            'label' => '__(\'Update Profile\')',
        ],
        'update_password' => [
            'label' => '__(\'Update Password\')',
        ],
        'delete_account' => [
            'label' => '__(\'Delete Account\')',
        ],
    ],
    'modal' => [
        'delete_confirmation' => [
            'title' => '__(\'Are you sure you want to delete your account?\')',
            'message' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
            'placeholder' => '__(\'Enter your password to confirm deletion\')',
        ],
    ],
];

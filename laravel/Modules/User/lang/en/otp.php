<?php

declare(strict_types=1);

return [
    'otp_code' => 'OTP Code',
    'title' => 'Password Expired, Reset Password',
    'heading' => 'Create a New Password',
    'sub_heading' => 'Your password has expired, please create a new one',
    'form' => [
        'current_password' => [
            'label' => 'Current Password',
            'validation_attribute' => 'current password',
        ],
        'password' => [
            'label' => 'New Password',
            'validation_attribute' => 'password',
        ],
        'password_confirmation' => [
            'label' => 'Confirm Password',
        ],
    ],
    'fields' => [
        'current_password' => [
            'label' => 'Current Password',
            'validation_attribute' => 'current password',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'New Password',
            'validation_attribute' => 'password',
        ],
    ],
    'reset_password' => 'Reset Password',
    'password_reset' => 'Password Reset',
    'mail' => [
        'subject' => 'OTP Code',
        'greeting' => 'Ciao!',
        'line1' => 'Your OTP code is: :code',
        'line2' => 'This code will be valid for :minutes minutes.',
        'line3' => 'If you did not request a code, ignore this email.',
        'salutation' => 'Kind regards, :app_name',
    ],
    'view' => [
        'time_left' => 'seconds left',
        'resend_code' => 'Resend code',
        'verify' => 'Verify',
        'go_back' => 'Go Back',
    ],
    'notifications' => [
        'title' => 'OTP Code Sent',
        'body' => 'The verification code has been sent to your email address. It will be valid for :seconds seconds.',
        'wrong_password' => [
            'title' => 'Wrong Password',
            'body' => 'The current password you entered is incorrect.',
        ],
        'column_not_found' => [
            'title' => 'Column Not Found',
            'body' => 'The column \\":column_name\\" or the password column \\":password_column_name\\" was not found in the table :table_name.',
        ],
        'password_reset' => [
            'success' => 'Password Reset Successfully',
        ],
        'same_password' => [
            'title' => 'Same Password',
            'body' => 'The new password must be different from the current password.',
        ],
        'otp_expired' => [
            'title' => 'OTP Expired',
            'body' => 'The OTP code used is no longer valid. Contact support to get a new OTP code',
        ],
    ],
    'exceptions' => [
        'column_not_found' => 'The column \\":column_name\\" or the password column \\":password_column_name\\" was not found in the table \\":table_name\\". Publish and run the migrations; if the error persists, publish the config file and update the values of table_name, column_name and password_column_name.',
    ],
    'validation' => [
        'invalid_code' => 'The code entered is not valid.',
        'expired_code' => 'The code entered has expired.',
    ],
    'actions' => [
        'send_otp' => 'Send OTP Code',
        'yes_send_otp' => 'Yes, Send OTP Code',
        'confirm_otp' => 'Are you sure you want to send a temporary password to this user? They will be required to change it at first login.',
        'send_otp_success' => 'Temporary password sent successfully.',
    ],
    'navigation' => [
        'name' => 'OTP',
        'plural' => 'OTPs',
        'group' => [
            'name' => 'User management',
            'description' => 'Manage one-time passwords',
        ],
        'label' => 'OTP',
        'sort' => '31',
        'icon' => 'user-user-otp',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];

<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Authentication Language Lines
     * |--------------------------------------------------------------------------
     * |
     * | The following language lines are used during authentication for various
     * | messages that we need to display to the user. You are free to modify
     * | these language lines according to your application's requirements.
     * |
     */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'login' => [
        'title' => 'Sign in to your account',
        'email' => 'Email',
        'password' => 'Password',
        'remember_me' => 'Remember me',
        'forgot_password' => 'Forgot your password?',
        'submit' => 'Sign in',
        'or' => 'or',
        'create_account' => 'create a new account',
        'link' => 'Sign in',
    ],
    'register' => [
        'title' => 'Create a new account',
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'submit' => 'Register',
        'already_registered' => 'Already have an account?',
        'link' => 'Register',
    ],
    'verify' => [
        'title' => 'Verify your email address',
        'success' => 'A new verification link has been sent to your email address.',
        'notice' => 'Before proceeding, please check your email for a verification link. If you did not receive the email,',
        'another_request' => 'click here to request another',
    ],
    'forgot_password' => [
        'title' => 'Forgot password',
        'email' => 'Email',
        'submit' => 'Send reset link',
    ],
    'reset_password' => [
        'title' => 'Reset password',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'submit' => 'Reset Password',
    ],
    'confirm_password' => [
        'title' => 'Confirm password',
        'password' => 'Password',
        'submit' => 'Confirm',
    ],
    'logout' => [
        'submit' => 'Logout',
        'title' => 'Logout',
        'success_title' => 'Logout successful',
        'success_message' => 'You have been successfully logged out.',
        'error_title' => 'Error during logout',
        'error_message' => 'An error occurred during logout. Please try again.',
        'confirm_message' => 'Are you sure you want to logout?',
        'confirm_button' => 'Confirm logout',
        'cancel_button' => 'Cancel',
        'back_to_home' => 'Back to home',
        'try_again' => 'Try again',
        'processing' => 'Logging out...',
    ],
    'user_dropdown' => [
        'manage_account' => 'Manage Account',
        'profile' => 'Profile',
        'settings' => 'Settings',
        'logout' => 'Logout',
    ],
];

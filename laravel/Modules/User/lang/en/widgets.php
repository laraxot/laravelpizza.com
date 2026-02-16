<?php

declare(strict_types=1);

return array (
  'edit_user' => 
  array (
    'title' => 'Edit User Profile',
    'description' => 'Update user profile information',
    'sections' => 
    array (
      'personal_info' => 
      array (
        'title' => 'Personal Information',
        'description' => 'Personal data and contacts',
      ),
      'preferences' => 
      array (
        'title' => 'Preferences',
        'description' => 'Personal settings and language',
      ),
      'security' => 
      array (
        'title' => 'Security',
        'description' => 'Password and security settings',
      ),
      'admin_settings' => 
      array (
        'title' => 'Administrator Settings',
        'description' => 'Configurations reserved for administrators',
      ),
    ),
    'fields' => 
    array (
      'profile_photo_path' => 
      array (
        'label' => 'Profile Photo',
        'placeholder' => 'Upload a profile photo',
        'help' => 'Supported formats: JPEG, PNG, WebP. Maximum size: 2MB',
      ),
      'first_name' => 
      array (
        'label' => 'First Name',
        'placeholder' => 'Enter your first name',
        'help' => 'Your given name',
      ),
      'last_name' => 
      array (
        'label' => 'Last Name',
        'placeholder' => 'Enter your last name',
        'help' => 'Your family name',
      ),
      'name' => 
      array (
        'label' => 'Full Name',
        'placeholder' => 'Enter your full name',
        'help' => 'First and last name as they should appear in the system',
      ),
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Enter your email address',
        'help' => 'Email address for login and communications',
      ),
      'lang' => 
      array (
        'label' => 'Language',
        'placeholder' => 'Select language',
        'help' => 'User interface language',
        'options' => 
        array (
          'it' => 'Italiano',
          'en' => 'English',
          'es' => 'Español',
          'fr' => 'Français',
          'de' => 'Deutsch',
        ),
      ),
      'password' => 
      array (
        'label' => 'New Password',
        'placeholder' => 'Enter a new password',
        'help' => 'Leave empty to keep current password',
      ),
      'password_confirmation' => 
      array (
        'label' => 'Confirm Password',
        'placeholder' => 'Confirm your new password',
        'help' => 'Repeat the new password for confirmation',
      ),
      'is_otp' => 
      array (
        'label' => 'Two-Factor Authentication (OTP)',
        'help' => 'Enable two-factor authentication for enhanced security',
      ),
      'password_expires_at' => 
      array (
        'label' => 'Password Expiration',
        'placeholder' => 'Select expiration date and time',
        'help' => 'Date and time when the password will expire',
      ),
      'is_active' => 
      array (
        'label' => 'Active Account',
        'help' => 'Determines if the account is active and can access the system',
      ),
    ),
    'actions' => 
    array (
      'save' => 
      array (
        'label' => 'Save Changes',
        'tooltip' => 'Save changes made to the profile',
      ),
      'cancel' => 
      array (
        'label' => 'Cancel',
        'tooltip' => 'Cancel changes and restore original values',
      ),
    ),
    'messages' => 
    array (
      'saved' => 'Profile updated successfully',
      'cancelled' => 'Changes cancelled',
      'error' => 'An error occurred while saving',
      'unauthorized' => 'You are not authorized to edit this profile',
    ),
    'validation' => 
    array (
      'email_unique' => 'This email address is already in use',
      'password_confirmation' => 'Password confirmation does not match',
      'required' => 'This field is required',
    ),
  ),
  'registration' => 
  array (
    'title' => 'User Registration',
    'description' => 'Create a new user account',
    'fields' => 
    array (
      'type' => 
      array (
        'label' => 'User Type',
        'placeholder' => 'Select user type',
        'help' => 'The type of account you are creating',
      ),
    ),
    'messages' => 
    array (
      'success' => 'Registration completed successfully',
      'error' => 'An error occurred during registration',
    ),
  ),
  'login' => 
  array (
    'title' => 'Login',
    'description' => 'Sign in to your account',
    'fields' => 
    array (
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Enter your email',
      ),
      'password' => 
      array (
        'label' => 'Password',
        'placeholder' => 'Enter your password',
      ),
      'remember' => 
      array (
        'label' => 'Remember me',
      ),
    ),
    'actions' => 
    array (
      'login' => 
      array (
        'label' => 'Sign In',
      ),
      'forgot_password' => 
      array (
        'label' => 'Forgot password?',
      ),
    ),
    'messages' => 
    array (
      'success' => 'Login successful',
      'error' => 'Invalid credentials',
    ),
  ),
  'logout' => 
  array (
    'title' => 'Logout',
    'description' => 'Sign out of your account',
    'actions' => 
    array (
      'logout' => 
      array (
        'label' => 'Sign Out',
      ),
      'confirm' => 
      array (
        'label' => 'Confirm',
      ),
      'cancel' => 
      array (
        'label' => 'Cancel',
      ),
    ),
    'messages' => 
    array (
      'success' => 'Logout successful',
      'confirm' => 'Are you sure you want to sign out?',
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
  'actions' => 
  array (
  ),
);

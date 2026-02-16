<?php

declare(strict_types=1);

return array (
  'passwords' => 
  array (
    'user' => 
    array (
      'label' => 'We can\'t find a user with that email address.',
      'title' => 'User not found',
      'description' => 'Please verify that the email address is correct and try again.',
    ),
    'token' => 
    array (
      'label' => 'This password reset token is invalid or has expired.',
      'title' => 'Invalid token',
      'description' => 'The reset link may have expired. Please request a new link.',
    ),
    'sent' => 
    array (
      'label' => 'We have sent you a password reset link!',
      'title' => 'Link sent',
      'description' => 'Please check your email inbox.',
    ),
    'reset' => 
    array (
      'label' => 'Your password has been reset successfully!',
      'title' => 'Password reset',
      'description' => 'You can now log in with your new password.',
    ),
    'throttled' => 
    array (
      'label' => 'Too many password reset attempts. Please wait before retrying.',
      'title' => 'Too many attempts',
      'description' => 'Please wait a few minutes before requesting a new link.',
    ),
  ),
  'auth' => 
  array (
    'failed' => 
    array (
      'label' => 'These credentials do not match our records.',
      'title' => 'Access denied',
      'description' => 'The email or password is incorrect.',
    ),
    'throttle' => 
    array (
      'label' => 'Too many login attempts. Please try again in :seconds seconds.',
      'title' => 'Account temporarily locked',
      'description' => 'For security reasons, please wait before trying again.',
    ),
    'unauthorized' => 
    array (
      'label' => 'You do not have the necessary permissions for this operation.',
      'title' => 'Unauthorized access',
      'description' => 'Contact the administrator if you think this is an error.',
    ),
  ),
  'validation' => 
  array (
    'required' => 
    array (
      'label' => 'The :attribute field is required.',
      'title' => 'Required field',
      'description' => 'Please fill in all required fields to continue.',
    ),
    'email' => 
    array (
      'label' => 'The :attribute field must be a valid email address.',
      'title' => 'Invalid email',
      'description' => 'Please enter an email address in the correct format.',
    ),
    'min' => 
    array (
      'label' => 'The :attribute field must be at least :min characters.',
      'title' => 'Insufficient length',
      'description' => 'The entered value is too short.',
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

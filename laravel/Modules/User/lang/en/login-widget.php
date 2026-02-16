<?php

declare(strict_types=1);

return array (
  'name' => 'Login',
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Enter your email',
      'helper_text' => 'Email address to login',
      'tooltip' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Enter your password',
      'helper_text' => 'Login password',
      'tooltip' => '',
      'description' => '',
    ),
    'remember' => 
    array (
      'label' => 'Remember me',
      'helper_text' => 'Keep session active',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'login' => 
    array (
      'label' => 'Login',
      'tooltip' => 'Sign in to your account',
    ),
    'forgot_password' => 
    array (
      'label' => 'Forgot Password?',
      'tooltip' => 'Reset your password',
    ),
    'register' => 
    array (
      'label' => 'Register',
      'tooltip' => 'Create a new account',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'login' => 'Successfully logged in',
    ),
    'error' => 
    array (
      'invalid_credentials' => 'Invalid credentials',
      'account_locked' => 'Account locked',
      'too_many_attempts' => 'Too many attempts, please try again later',
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
);

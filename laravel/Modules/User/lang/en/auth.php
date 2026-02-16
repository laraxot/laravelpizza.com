<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Enter your email',
      'help' => 'Your email address for authentication',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Enter your password',
      'help' => 'Your account password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'login' => 
    array (
      'label' => 'Sign in',
      'success' => 'Login successful',
      'error' => 'Invalid credentials',
    ),
    'logout' => 
    array (
      'label' => 'Logout',
      'success' => 'Logout successful',
      'error' => 'Logout failed',
    ),
  ),
  'messages' => 
  array (
    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'unauthorized' => 'You are not authorized to access this resource.',
  ),
  'password_reset' => 
  array (
    'email_placeholder' => 'Enter your email address',
    'send_button' => 'Send reset link',
    'back_to_login' => 'Back to login',
    'send_another' => 'Send another link',
    'email_sent' => 
    array (
      'title' => 'Email sent!',
      'message' => 'We have sent you a password reset link. Check your email inbox and follow the instructions.',
    ),
    'email_failed' => 
    array (
      'title' => 'Sending error',
      'generic' => 'An error occurred while sending the email. Please try again later.',
    ),
    'password_requirements' => 'Password must be at least 8 characters',
    'processing' => 'Processing...',
    'instructions' => 
    array (
      'title' => 'Reset instructions',
      'description' => 'Enter your email and new password to complete the reset.',
    ),
    'confirm_button' => 'Confirm new password',
    'request_new_link' => 'Request a new link',
    'security' => 
    array (
      'title' => 'Security',
      'note' => 'The reset link is valid for 60 minutes and can only be used once.',
    ),
    'success' => 
    array (
      'title' => 'Password reset successfully!',
      'message' => 'Your password has been updated. You can now log in with your new password.',
      'redirect_notice' => 'Automatic redirect in progress...',
      'go_to_dashboard' => 'Go to dashboard',
      'go_to_login' => 'Go to login',
    ),
    'errors' => 
    array (
      'title' => 'Password reset error',
      'invalid_token' => 'The reset link is no longer valid or has expired.',
      'invalid_user' => 'Unable to find a user with this email address.',
      'generic' => 'An error occurred while resetting the password. Please try again later.',
      'possible_causes' => 'Possible causes:',
      'causes' => 
      array (
        'expired_token' => 'The reset link has expired (valid for 60 minutes)',
        'invalid_email' => 'The email address does not match any account',
        'already_used' => 'The reset link has already been used',
      ),
      'try_again' => 'Try again',
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

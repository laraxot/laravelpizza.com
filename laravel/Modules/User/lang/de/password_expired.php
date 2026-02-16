<?php

declare(strict_types=1);

return array (
  'title' => 'Password Scaduta, Reimposta Password',
  'heading' => 'Crea una Nuova Password',
  'sub_heading' => 'La tua password è scaduta, per favore crea una nuova password',
  'fields' => 
  array (
    'current_password' => 
    array (
      'label' => 'Current Password',
      'validation_attribute' => 'current_password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'validation_attribute' => 'password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Confirm Password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'form' => 
  array (
    'current_password' => 
    array (
      'label' => 'Current Password',
      'validation_attribute' => 'current_password',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'validation_attribute' => 'password',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Confirm Password',
    ),
  ),
  'actions' => 
  array (
    'reset_password' => 
    array (
      'label' => 'Reset Password',
    ),
    'cancel' => 
    array (
      'label' => 'Cancel',
    ),
  ),
  'reset_password' => 'Reset Password',
  'password_reset' => 'Password Reset',
  'notifications' => 
  array (
    'wrong_password' => 
    array (
      'title' => 'Wrong Password',
      'body' => 'The current password you entered is incorrect.',
    ),
    'column_not_found' => 
    array (
      'title' => 'Column Not Found',
      'body' => 'Either the column \\":column_name\\" or the password column \\":password_column_name\\" was not found in the :table_name table.',
    ),
    'password_reset' => 
    array (
      'success' => 'Password Reset Successful',
    ),
    'same_password' => 
    array (
      'title' => 'Same Password',
      'body' => 'The new password must be different from the current password.',
    ),
  ),
  'exceptions' => 
  array (
    'column_not_found' => 'Either the column \\":column_name\\" or the password column \\":password_column_name\\" was not found in the \\":table_name\\" table. Please publish migrations and run them, if the error still persists, publish the config file and update the table_name, column_name, and password_column_name values.',
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

<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'language' => 
    array (
      'label' => 'Language',
      'placeholder' => 'Select language',
      'helper_text' => 'Currently selected interface language',
      'tooltip' => '',
      'description' => '',
    ),
    'available_languages' => 
    array (
      'label' => 'Available Languages',
      'placeholder' => 'Available languages list',
      'helper_text' => 'Languages available for interface selection',
      'tooltip' => '',
      'description' => '',
    ),
    'value' => 
    array (
      'label' => 'Value',
      'placeholder' => 'Enter value',
      'helper_text' => 'Translation value',
      'tooltip' => '',
      'description' => '',
    ),
    'key' => 
    array (
      'label' => 'Key',
      'placeholder' => 'Enter translation key',
      'helper_text' => 'Unique identifier for the translation',
      'tooltip' => '',
      'description' => '',
    ),
    'locale' => 
    array (
      'label' => 'Locale',
      'placeholder' => 'Select locale',
      'helper_text' => 'Language locale code (e.g. it, en, de)',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'change_language' => 
    array (
      'label' => 'Change Language',
      'tooltip' => 'Change interface language',
      'success' => 'Language changed successfully',
      'error' => 'Error changing language',
      'confirmation' => 'Are you sure you want to change the language?',
    ),
    'cancel' => 
    array (
      'label' => 'Cancel',
      'tooltip' => 'Cancel current operation',
    ),
    'save' => 
    array (
      'label' => 'Save',
      'tooltip' => 'Save changes',
      'success' => 'Changes saved successfully',
      'error' => 'Error saving changes',
    ),
    'create' => 
    array (
      'label' => 'Create Translation',
      'tooltip' => 'Create a new translation',
      'success' => 'Translation created successfully',
      'error' => 'Error creating translation',
    ),
    'edit' => 
    array (
      'label' => 'Edit',
      'tooltip' => 'Edit selected translation',
      'success' => 'Translation updated successfully',
      'error' => 'Error updating translation',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'tooltip' => 'Delete selected translation',
      'success' => 'Translation deleted successfully',
      'error' => 'Error deleting translation',
      'confirmation' => 'Are you sure you want to delete this translation?',
    ),
  ),
  'messages' => 
  array (
    'language_changed' => 'Language changed successfully',
    'error' => 'An error occurred while changing language',
    'no_translations' => 'No translations found',
    'loading' => 'Loading translations...',
    'empty_state' => 'No translations available',
    'search_placeholder' => 'Search translations...',
  ),
  'validation' => 
  array (
    'language_required' => 'Language is required',
    'language_valid' => 'Selected language is not valid',
    'key_required' => 'Translation key is required',
    'key_unique' => 'This translation key already exists',
    'value_required' => 'Translation value is required',
    'locale_required' => 'Locale is required',
    'locale_valid' => 'Locale format is not valid',
  ),
  'navigation' => 
  array (
    'label' => 'Language Service',
    'group' => 'Localization',
    'icon' => 'heroicon-o-language',
  ),
  'page' => 
  array (
    'title' => 'Translation Management',
    'heading' => 'Language Service',
    'description' => 'Manage translations and available languages in the system',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

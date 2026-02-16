# Widget Translation Guidelines

## Overview
This document outlines the translation structure and guidelines for widgets in the User module, specifically focusing on the EditUserWidget implementation.
## Translation File Structure
### Location
```text
Modules/User/lang/{locale}/widgets.php
```
### Supported Locales
- `it` (Italian) - Primary language
- `en` (English) - Secondary language
## Translation Key Structure
### Widget Structure
```php
return [
    'widget_name' => [
        'title' => 'Widget Title',
        'description' => 'Widget Description',
        'sections' => [
            'section_name' => [
                'title' => 'Section Title',
                'description' => 'Section Description',
            ],
        ],
        'fields' => [
            'field_name' => [
                'label' => 'Field Label',
                'placeholder' => 'Field Placeholder',
                'help' => 'Field Help Text',
                'options' => [
                    'option_key' => 'Option Label',
                ],
        'actions' => [
            'action_name' => [
                'label' => 'Action Label',
                'tooltip' => 'Action Tooltip',
        'messages' => [
            'message_key' => 'Message Text',
        'validation' => [
            'rule_name' => 'Validation Message',
    ],
];
## EditUserWidget Translation Structure
### Complete Structure Example
'edit_user' => [
    'title' => 'Edit User Profile',
    'description' => 'Update user profile information',
    'sections' => [
        'personal_info' => [
            'title' => 'Personal Information',
            'description' => 'Personal data and contacts',
        'preferences' => [
            'title' => 'Preferences',
            'description' => 'Personal settings and language',
        'security' => [
            'title' => 'Security',
            'description' => 'Password and security settings',
        'admin_settings' => [
            'title' => 'Administrator Settings',
            'description' => 'Configurations reserved for administrators',
    'fields' => [
        'profile_photo_path' => [
            'label' => 'Profile Photo',
            'placeholder' => 'Upload a profile photo',
            'help' => 'Supported formats: JPEG, PNG, WebP. Maximum size: 2MB',
        'lang' => [
            'label' => 'Language',
            'placeholder' => 'Select language',
            'help' => 'User interface language',
            'options' => [
                'it' => 'Italiano',
                'en' => 'English',
                'es' => 'Español',
                'fr' => 'Français',
                'de' => 'Deutsch',
    'actions' => [
        'save' => [
            'label' => 'Save Changes',
            'tooltip' => 'Save changes made to the profile',
        'cancel' => [
            'label' => 'Cancel',
            'tooltip' => 'Cancel changes and restore original values',
    'messages' => [
        'saved' => 'Profile updated successfully',
        'cancelled' => 'Changes cancelled',
        'error' => 'An error occurred while saving',
        'unauthorized' => 'You are not authorized to edit this profile',
    'validation' => [
        'email_unique' => 'This email address is already in use',
        'password_confirmation' => 'Password confirmation does not match',
        'required' => 'This field is required',
],
## Widget Implementation Rules
### Never Use Direct Labels
// ❌ WRONG - Never use ->label() in widgets
TextInput::make('name')->label('Name')
// ✅ CORRECT - Let LangServiceProvider handle translations
TextInput::make('name')
### Translation Key Usage
// ✅ CORRECT - Use translation keys for options
Select::make('lang')
    ->options([
        'it' => __('user::widgets.edit_user.fields.lang.options.it'),
        'en' => __('user::widgets.edit_user.fields.lang.options.en'),
    ])
### View Translation Usage
```blade
{{-- ✅ CORRECT - Use translation keys in views --}}
<h2>{{ __('user::widgets.edit_user.title') }}</h2>
<p>{{ __('user::widgets.edit_user.description') }}</p>
{{-- ❌ WRONG - Never hardcode strings --}}
<h2>Edit User Profile</h2>
## Best Practices
### Key Naming Conventions
1. Use snake_case for all keys
2. Use descriptive names that reflect the field's purpose
3. Group related fields under common prefixes
4. Maintain consistency across all widgets
### Translation Content Guidelines
1. Keep labels concise but descriptive
2. Provide helpful placeholder text
3. Include comprehensive help text for complex fields
4. Use consistent terminology across the application
5. Ensure translations are grammatically correct
### Validation Messages
1. Provide clear, actionable error messages
2. Use consistent language for similar validation rules
3. Include context when helpful (e.g., field requirements)
## Integration with LangServiceProvider
The User module's LangServiceProvider automatically loads and manages widget translations. The system follows these conventions:
1. **Automatic Loading**: Translation files are loaded automatically from `lang/{locale}/widgets.php`
2. **Key Resolution**: Field names automatically map to translation keys
3. **Fallback Handling**: Falls back to English if translation is missing
4. **Caching**: Translations are cached for performance
## Maintenance Guidelines
### Adding New Translations
1. Add keys to both Italian and English files
2. Follow the established structure
3. Test translations in both languages
4. Update this documentation if new patterns are introduced
### Updating Existing Translations
1. Maintain backward compatibility
2. Update all language files simultaneously
3. Test changes across all supported locales
4. Document any breaking changes
## Related Documentation
- [User Module Widget Structure](../widgets_structure.md)
- [Filament Widget Conventions](../../Xot/docs/filament-widgets.md)
- [Translation System Overview](../../Xot/docs/translations.md)
- [Filament Widget Conventions](../../Xot/project_docs/filament-widgets.md)
- [Translation System Overview](../../Xot/project_docs/translations.md)
- [EditUserWidget Documentation](./edit-user-widget.md)

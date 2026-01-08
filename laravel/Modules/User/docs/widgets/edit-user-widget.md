# EditUserWidget Documentation

## Overview
The `EditUserWidget` is a comprehensive Filament widget designed for editing user profile information within the User module. This widget provides a structured interface for modifying user data including personal information, preferences, security settings, and administrative configurations.
## Purpose
The widget serves as a reusable component for user profile editing across different parts of the application, maintaining consistency in user experience and following the project's architectural patterns.
## Analysis of Related Files
### Registration Widget Pattern
Based on the analysis of `RegistrationWidget` in the same module, the following patterns were identified:
* Extension of `XotBaseWidget` as the base class
* Implementation of `HasForms` interface with `InteractsWithForms` trait
* Use of `mount()` method for initialization
* Form schema definition following Filament conventions
* Proper namespace structure: `Modules\User\Filament\Widgets`
### User Model Fields
Analysis of the User model revealed the following key fields for editing:
* Personal information: `name`, `first_name`, `last_name`, `email`
* Preferences: `lang` (language preference)
* Security: `password`, `is_otp`, `password_expires_at`
* Administrative: `is_active`, `profile_photo_path`
## Implementation Structure
### Widget Class Location
```php
Modules/User/app/Filament/Widgets/EditUserWidget.php
```
### Key Features
* **Modular Design**: Organized into logical sections (personal info, preferences, security, admin)
* **Permission-Based**: Sections are conditionally visible based on user permissions
* **Form Validation**: Comprehensive validation rules for all fields
* **Security Handling**: Proper password hashing and confirmation
* **Responsive Layout**: Grid-based layout for optimal display across devices
## Form Schema Structure
### Personal Information Section
* Profile photo upload with image editor
* First name and last name fields in a grid layout
* Full name field for display purposes
* Email field with uniqueness validation
### Preferences Section
* Language selection dropdown with supported locales
### Security Section (Conditional)
* Password and password confirmation fields
* Two-factor authentication toggle
* Password expiration date/time picker
### Admin Settings Section (Conditional)
* Account active/inactive toggle
* Other administrative controls as needed
## View Structure
### Blade View Location
```blade
Modules/User/resources/views/filament/widgets/edit-user.blade.php
### View Conventions
* Uses Tailwind CSS for styling consistency
* Implements dark mode support
* Follows responsive design principles
* Uses SVG icons for visual elements
* Conditional rendering based on permissions
## Integration and Usage
### Widget Registration
The widget should be registered in the appropriate Filament panel or page where user editing functionality is required.
### Permission Checks
The widget implements the following permission methods:
* `canEditSecurity()`: Controls visibility of security section
* `canEditAdminSettings()`: Controls visibility of admin settings section
### Form Actions
* **Save**: Validates and saves user data with proper password hashing
* **Cancel**: Resets form to original values
## Authorization and Security
### Permission Requirements
* Basic profile editing: Available to the user themselves
* Security settings: Requires appropriate security permissions
* Admin settings: Requires administrative privileges
### Security Considerations
* Password fields are properly hashed using Laravel's Hash facade
* Email uniqueness is validated excluding the current record
* Sensitive sections are hidden based on user permissions
* Form data is validated before processing
## UX/UI Design Considerations
### Responsive Design
* Grid layouts adapt to different screen sizes
* Form sections are clearly separated and labeled
* Consistent spacing and typography
### User Experience
* Clear section titles and descriptions
* Helpful placeholder text and validation messages
* Intuitive form flow and navigation
* Proper feedback for save/cancel actions
## Translation Implementation
### Translation Files
The widget uses comprehensive translation files located at:
* `Modules/User/lang/it/widgets.php` (Italian)
* `Modules/User/lang/en/widgets.php` (English)
### Translation Structure
All widget text follows the expanded translation structure:
'edit_user' => [
    'title' => 'Edit User Profile',
    'fields' => [
        'field_name' => [
            'label' => 'Field Label',
            'placeholder' => 'Field Placeholder',
            'help' => 'Field Help Text',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Save Changes',
            'tooltip' => 'Save changes made to the profile',
    'messages' => [
        'saved' => 'Profile updated successfully',
],
### Translation Rules
* Never use `->label()` in form components
* All text comes from translation files
* Language options are defined in translation structure
* LangServiceProvider handles automatic translation loading
## Next Steps
1. **Testing**: Implement unit and integration tests for widget functionality
2. **Integration**: Add widget to relevant Filament pages or panels
3. **Documentation Updates**: Update related theme and module documentation
4. **Accessibility**: Ensure proper ARIA labels and keyboard navigation
5. **Performance**: Optimize form rendering and validation performance
## Dependencies
* Filament Forms package
* XotBaseWidget from Xot module
* User model and related permissions
* Translation system integration
* File upload and image processing capabilities
## Related Documentation
* [User Module Widget Structure](../widgets_structure.md)
* [Widget Translation Guidelines](./translation-guidelines.md)
* [Filament Widget Conventions](../../Xot/docs/filament-widgets.md)
* [Translation System Overview](../../Xot/docs/translations.md)
* [Filament Widget Conventions](../../Xot/project_docs/filament-widgets.md)
* [Translation System Overview](../../Xot/project_docs/translations.md)

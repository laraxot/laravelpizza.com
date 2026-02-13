# Multi-Language Translation Guidelines for Laravel Pizza

## Overview
Complete guide for implementing and maintaining multi-language translations in the Laravel Pizza project following Laraxot patterns.

## Philosophy
- **No Hardcoded Strings:** All text must use translation keys
- **Consistent Structure:** Follow Laraxot translation key patterns
- **6 Languages:** Italian (it), English (en), German (de), French (fr), Spanish (es), Russian (ru)
- **Target Language Content:** Translation files must contain content in the target language, NOT English

## Translation Key Pattern

### Standard Format
```
{module}::{widget}.fields.{field}.{type}
```

### Examples
```php
// Register Widget
gdpr::register.fields.email.label
gdpr::register.fields.email.placeholder
gdpr::register.fields.email.helper_text

// Benefits Section
gdpr::register.benefits.community.title
gdpr::register.benefits.community.description

// Clickbait Marketing
gdpr::register.clickbait.active_developers
gdpr::register.clickbait.free_access

// SEO Keywords
gdpr::register.seo.laravel_meetup
gdpr::register.seo.laravel_community
```

## File Structure

### Translation Files Location
```
Modules/{ModuleName}/lang/{locale}/{widget}.php
```

### Example
```
Modules/Gdpr/
├── lang/
│   ├── it/
│   │   ├── register.php
│   │   ├── login.php
│   │   └── consent.php
│   ├── en/
│   │   ├── register.php
│   │   ├── login.php
│   │   └── consent.php
│   └── de/
│       ├── register.php
│       ├── login.php
│       └── consent.php
```

## Best Practices

### 1. Group Related Translations
```php
// ✅ CORRECT - Structured
return [
    'register' => [
        'title' => '...',
        'subtitle' => '...',
        'fields' => [
            'email' => [
                'label' => '...',
                'placeholder' => '...',
                'helper_text' => '...',
            ],
        ],
    ],
];

// ❌ WRONG - Flat structure
return [
    'register_title' => '...',
    'register_subtitle' => '...',
    'email_label' => '...',
];
```

### 2. Use Descriptive Keys
```php
// ✅ CORRECT
gdpr::register.clickbait.free_access
gdpr::register.benefits.community.title

// ❌ WRONG
gdpr::register.btn1
gdpr::register.text1
```

### 3. Support HTML in Translations
```php
// With placeholders
'terms_checkbox_html' => 'Accetto i <a href=":terms_url" class="...">Termini</a>',

// Usage in Blade
{{ __('gdpr::register.terms_checkbox_html', ['terms_url' => route('terms')]) }}
```

### 4. Keep Consistent Across All Languages
```php
// Italian
'clickbait' => [
    'active_developers' => 'Sviluppatori Attivi',
    'free_access' => 'Accesso GRATUITO immediato',
    // ...
],

// English
'clickbait' => [
    'active_developers' => 'Active Developers',
    'free_access' => 'FREE access immediately',
    // ...
],

// German
'clickbait' => [
    'active_developers' => 'Aktive Entwickler',
    'free_access' => 'KOSTENLOSER Zugriff sofort',
    // ...
],
```

## Supported Languages

### 1. Italian (it) - Primary Language
- Used for development and reference
- Primary content language
- Cultural: Pizza, community, informal but professional

### 2. English (en) - Secondary Language
- International standard
- Used for technical documentation
- Cultural: Professional, direct, action-oriented

### 3. German (de)
- Target audience: DACH region (Germany, Austria, Switzerland)
- Cultural: Formal, precise, structured
- Notes: Use "Sie" form for formal address

### 4. French (fr)
- Target audience: France, Belgium, Switzerland
- Cultural: Elegant, sophisticated
- Notes: Accents are critical (é, è, à, ê)

### 5. Spanish (es)
- Target audience: Spain, Latin America
- Cultural: Warm, inviting, passionate
- Notes: Use neutral Spanish for broad appeal

### 6. Russian (ru)
- Target audience: Russia, CIS countries
- Cultural: Serious, trustworthy
- Notes: Cyrillic alphabet support required

## Common Translation Categories

### 1. Form Fields
```php
'fields' => [
    'field_name' => [
        'label' => 'Display Label',
        'placeholder' => 'Placeholder text',
        'helper_text' => 'Helper description',
    ],
],
```

### 2. Buttons and Actions
```php
'actions' => [
    'submit' => 'Submit',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
],
```

### 3. Messages and Alerts
```php
'messages' => [
    'success' => 'Success message',
    'error' => 'Error message',
    'warning' => 'Warning message',
],
```

### 4. Navigation
```php
'navigation' => [
    'home' => 'Home',
    'about' => 'About',
    'contact' => 'Contact',
],
```

### 5. Marketing/Clickbait
```php
'clickbait' => [
    'active_developers' => '5,000+ Active Developers',
    'free_access' => 'FREE access immediately',
    'join_now' => 'Join NOW',
],
```

### 6. SEO
```php
'seo' => [
    'laravel_meetup' => 'meetup Laravel',
    'laravel_community' => 'comunità Laravel',
    'php_developer_community' => 'comunità sviluppatori PHP',
],
```

## Integration with Blade Templates

### Basic Usage
```php
{{ __('gdpr::register.register.title') }}
```

### With Parameters
```php
{{ __('gdpr::register.welcome', ['name' => $user->name]) }}
```

### With HTML
```php
{!! __('gdpr::register.terms_html', ['terms_url' => $termsUrl]) !!}
```

### With Pluralization
```php
{{ trans_choice('gdpr::register.users_count', $count, ['count' => $count]) }}
```

## Automatic Translation System

### LangServiceProvider
The Laraxot framework automatically handles translations via:
- `LangServiceProvider` - Configures all Filament components
- `AutoLabelAction` - Generates translation keys automatically

### Filament Form Components
```php
// ✅ CORRECT - No manual label()
TextInput::make('email')->required()

// ❌ WRONG - Manual label
TextInput::make('email')->label('Email')->placeholder('Enter email')
```

### Translation Key Generation
The system automatically generates keys based on class names:
- Class: `Modules\Gdpr\Filament\Widgets\Auth\Register`
- Key: `gdpr::register.fields.email.label`

## Validation and Quality Assurance

### 1. Check for Hardcoded Strings
```bash
# Search for hardcoded strings in Blade files
grep -r "['\"]Italian\|English\|German" laravel/Themes/Meetup/resources/views/
```

### 2. Verify All Languages Have Keys
```php
// Check if key exists in all languages
foreach (['it', 'en', 'de', 'fr', 'es', 'ru'] as $locale) {
    $translation = __("gdpr::register.clickbait.free_access", [], $locale);
    if ($translation === "gdpr::register.clickbait.free_access") {
        echo "Missing key for $locale\n";
    }
}
```

### 3. Run Translation Tests
```bash
# Test all translation files
php artisan test --filter TranslationTest
```

## Common Mistakes

### 1. Hardcoded Strings
```php
// ❌ WRONG
<h1>Welcome to LaravelPizza</h1>

// ✅ CORRECT
<h1>{{ __('gdpr::register.welcome') }}</h1>
```

### 2. English Content in Language Files
```php
// ❌ WRONG - German file with English content
// Modules/Gdpr/lang/de/register.php
'title' => 'Welcome to LaravelPizza',

// ✅ CORRECT - German file with German content
'title' => 'Willkommen bei LaravelPizza',
```

### 3. Inconsistent Key Names
```php
// ❌ WRONG
it: 'register_title'
en: 'registration_title'
de: 'titel_registrierung'

// ✅ CORRECT
it: 'register.title'
en: 'register.title'
de: 'register.title'
```

### 4. Missing Translations
```php
// ❌ WRONG - Only 4 languages
- it/register.php
- en/register.php
- de/register.php
- fr/register.php

// ✅ CORRECT - All 6 languages
- it/register.php
- en/register.php
- de/register.php
- fr/register.php
- es/register.php
- ru/register.php
```

## Translation Management Workflow

### Adding New Translations
1. **Add to all 6 language files** simultaneously
2. **Use consistent key structure**
3. **Write content in target language** (not English)
4. **Test in all locales**
5. **Update documentation**

### Updating Existing Translations
1. **Review context and usage**
2. **Update all 6 language files**
3. **Verify no hardcoded strings remain**
4. **Test functionality**
5. **Commit changes together**

### Removing Translations
1. **Check for dependencies**
2. **Remove from all 6 language files**
3. **Search for usage in codebase**
4. **Update tests**
5. **Document the removal**

## Tools and Resources

### Laravel Translation Commands
```bash
# Create translation files
php artisan lang:publish

# Clear translation cache
php artisan cache:clear
php artisan config:clear

# Find missing translations
php artisan trans:missing
```

### External Tools
- **Laravel Translation Manager:** https://github.com/barryvdh/laravel-translation-manager
- **Laravel Language Files:** https://github.com/caouecs/Laravel-lang
- **POEditor:** https://poeditor.com/ (collaborative translation)

## Related Documentation
- [Laraxot Auto-Label System](/laravel/Modules/Xot/docs/)
- [Register Page Improvements](/laravel/Themes/Meetup/docs/register-page-improvements.md)
- [Laravel Localization](https://laravel.com/docs/localization)
- [LaravelLocalization Package](https://github.com/mcamara/laravel-localization)

## Credits
- Translation System: Laraxot Framework
- Supported Languages: 6 (it, en, de, fr, es, ru)
- Translation Philosophy: No hardcoded strings, consistent structure
- Quality Assurance: Automated checks and manual review
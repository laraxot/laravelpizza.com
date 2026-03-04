# Auth Pages - UI/UX Guidelines

## Overview

This document describes the design patterns and best practices for authentication pages (login, register, password reset) in the Meetup theme.

## URL Structure

All auth pages must be under `/auth/` prefix:

- Login: `/it/auth/login` or `/en/auth/login`
- Register: `/it/auth/register` or `/en/auth/register`
- Password Reset: `/it/auth/password/reset` or `/en/auth/password/reset`

## UI/UX Best Practices

### Visual Design

1. **Split Layout**: Image/branding on one side, form on the other
2. **Clear Typography**: Large headings, readable body text
3. **Brand Colors**: Use theme red (#EF4444) for primary actions
4. **Whitespace**: Generous padding and margins
5. **Input Design**: Floating labels, clear focus states
6. **Error States**: Red borders, helpful error messages
7. **Loading States**: Spinners or loading text on submit

### Animations

1. **Page Load**: Fade-in for form container
2. **Input Focus**: Smooth border color transition
3. **Button Hover**: Subtle color shift
4. **Error Shake**: Subtle shake animation on validation error

### Components

```blade
{{-- Login Form Structure --}}
<div class="auth-container">
    <div class="auth-brand">
        <!-- Logo and tagline -->
    </div>
    <div class="auth-form">
        <!-- Form with floating labels -->
    </div>
</div>
```

### Form Fields

- Use floating labels (CSS transition)
- Show/hide password toggle
- Clear validation error messages
- Remember me checkbox
- Forgot password link

### Register Button Text

**CORRECT**: Use action-oriented text in the primary language
- Italian: "Crea il tuo account" or "Registrati"
- English: "Create Account" or "Sign Up"

**WRONG**: Using English "Sign Up" in Italian interface

## Localization

All text must be localized using translation keys:

```php
// ✅ CORRECT
__('auth.login.title')
__('auth.login.submit')
__('auth.register.create_account')

// ❌ WRONG
'Sign Up'  // Hardcoded English
```

## Implementation

### File Locations

```
Themes/Meetup/resources/views/pages/
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── password/
│       ├── reset.blade.php
│       └── [token].blade.php
```

### Links in Header

Always use localized URLs:

```blade
{{-- ✅ CORRECT --}}
<a href="{{ LaravelLocalization::localizeUrl('/auth/login') }}">{{ __('Accedi') }}</a>
<a href="{{ LaravelLocalization::localizeUrl('/auth/register') }}">{{ __('Registrati') }}</a>

{{-- ❌ WRONG --}}
<a href="/login">
<a href="{{ route('register') }}">
```

## Testing

Test the following scenarios:
- [ ] Login form displays correctly
- [ ] Register form displays correctly
- [ ] Validation errors show properly
- [ ] Language switcher works
- [ ] Links are properly localized
- [ ] Mobile responsive design works

## References

- [Authgear Login UX Guide](https://www.authgear.com/post/login-signup-ux-guide)
- [UI Design Best Practices](https://descope.com/blog/post/login-ui-design)

# CSRF Token Handling in Xot

## Table of Contents
- [Introduction](#introduction)
- [Livewire Integration](#livewire-integration)
- [Widget Implementation](#widget-implementation)
- [Troubleshooting](#troubleshooting)
- [Best Practices](#best-practices)

## Introduction
Cross-Site Request Forgery (CSRF) protection is a critical security feature in Laravel. This document outlines how to properly handle CSRF tokens in the Xot module and its extensions.

## Livewire Integration

### Automatic CSRF Handling
Livewire automatically includes the CSRF token in all AJAX requests. However, in some cases, you might need to handle it manually.

### Manual CSRF Token Handling

#### In Blade Views:
```blade
{{-- Include CSRF token in Livewire components --}}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
```

#### In Livewire Components:
```php
public $token;

public function mount()
{
    $this->token = csrf_token();
}
```

## Widget Implementation

### XotBaseWidget CSRF Handling
All widgets extending `XotBaseWidget` automatically include CSRF token handling. The base widget provides:

1. Automatic token injection in the `mount` method
2. Token availability in the view as `$_token`

### Required Implementation
```php
// In your widget class
public function mount(): void
{
    parent::mount(); // This handles CSRF token initialization
    // Your custom mount logic
}
```

## Troubleshooting

### Common Issues

#### 1. 419 Page Expired
- **Cause**: Missing or invalid CSRF token
- **Solution**:
  - Ensure `@csrf` is present in forms
  - Verify session configuration
  - Check for mixed content issues (HTTP/HTTPS)

#### 2. Token Mismatch
- **Cause**: Session/cookie domain misconfiguration
- **Solution**:
  - Verify `SESSION_DOMAIN` in `.env`
  - Check `config/session.php` settings

## Best Practices

1. **Always use `@csrf` in forms**
   ```blade
   <form method="POST">
       @csrf
       <!-- form fields -->
   </form>
   ```

2. **For AJAX requests**, include the token in headers:
   ```javascript
   headers: {
       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
   }
   ```

3. **In Livewire components**, use the built-in form handling when possible

4. **Verify session configuration** in `config/session.php`:
   ```php
   'secure' => env('SESSION_SECURE_COOKIE', true),
   'same_site' => 'lax',
   ```

## Related Documentation
- [Laravel CSRF Protection](https://laravel.com/docs/csrf)
- [Livewire Forms](https://laravel-livewire.com/docs/2.x/input)
- [Xot Widget Development](xot-widgets.md)

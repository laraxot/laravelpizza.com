# GDPR Consent Implementation Guide

## Overview
This guide outlines the implementation of GDPR consent management in the application, following the project's architectural patterns and requirements.

## Prerequisites

- Laravel 10.x
- PHP 8.2+
- MySQL 8.0+ or PostgreSQL 13+

## Installation

### 1. Install the Package

```bash
composer require maize-tech/laravel-legal-consent
```

### 2. Publish Assets

```bash
php artisan vendor:publish --provider="Maize\LegalConsent\LegalConsentServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Maize\LegalConsent\LegalConsentServiceProvider" --tag="config"
php artisan vendor:publish --provider="Maize\LegalConsent\LegalConsentServiceProvider" --tag="views"
```

### 3. Run Migrations

```bash
php artisan migrate
```

## Configuration

### 1. Update `config/legal-consent.php`

```php
return [
    'models' => [
        'user' => \Modules\User\Models\User::class,
    ],
    'tables' => [
        'users' => 'users',
    ],
];
```

### 2. Update User Model

```php
use Maize\LegalConsent\CanConsent;

class User extends Authenticatable
{
    use CanConsent;
    // ...
}
```

## Usage

### 1. Middleware

Add the middleware to web routes:

```php
Route::middleware(['web', 'legal.consent'])->group(function () {
    // Protected routes
});
```

### 2. Blade Components

Use the provided Blade components:

```blade
<x-legal-consent-banner />
```

## Customization

### 1. Translations

Publish and modify language files:

```bash
php artisan vendor:publish --tag=lang --force
```

### 2. Views

Customize views in `resources/views/vendor/legal-consent/`

## Testing

Run the test suite:

```bash
composer test
```

## Documentation

For more details, refer to the [official documentation](https://github.com/maize-tech/laravel-legal-consent).

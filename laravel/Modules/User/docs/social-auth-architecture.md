# Social Authentication Architecture

## Overview
This document describes the implementation of social login (Google, Microsoft, GitHub) in the Fixcity User module using Laravel Socialite and Filament, without adding provider‑specific columns to the `users` table.

## Models
- **SocialProvider**: Stores provider configuration (client_id, client_secret, scopes, parameters, active flag). One row per provider.
- **SocialiteUser**: Stores the social login record linking a user account to a social provider. Contains `user_id`, `provider`, `provider_id`, `token`, `name`, `email`, `avatar`.

## Flow
1. User clicks a social button in the login widget.
2. The button routes to `socialite.oauth.redirect` which redirects to the provider's OAuth endpoint.
3. After provider authentication, Socialite returns user details.
4. The application creates/updates a `SocialiteUser` record and links it to a `User` via `user_id`.
5. The user is logged in and redirected.

## Configuration
- Provider credentials are read from `config/services.php` (e.g., `google.client_id`).
- The `services.php` file is autoloaded by Laravel; no DB columns are required.
- Admin UI: Filament resources (`SocialProviderResource`, `SocialiteUserResource`) allow editing of provider settings and viewing social user links.

## Translation Rule
- UI strings must be stored in `Modules/User/lang/{locale}/login_widget.php` with exactly five elements per translation key.
- Full sentences are not allowed in theme files; they must be moved to the User module language files.

## Implementation Details
- The login form (`LoginWidget.php`) uses Filament components (`TextInput`, `Checkbox`).
- Social buttons are rendered conditionally based on `config('services.google.client_id')` etc.
- The button markup includes custom SVG backgrounds, no underlines, and hover scaling per the button‑background consistency rule.
- Validation: Unit and feature tests ensure no provider columns are added to the users table.

## Files to Review
- `laravel/Modules/User/app/Models/SocialProvider.php`
- `laravel/Modules/User/app/Models/SocialiteUser.php`
- `laravel/Modules/User/config/services.php`
- `laravel/Modules/User/resources/views/filament/widgets/auth/login.blade.php`
- `laravel/Modules/User/app/Filament/Widgets/Auth/LoginWidget.php`
- `laravel/Modules/User/docs/social-auth-architecture.md` (this file)

## Next Steps
- Ensure all translation strings are moved to the User module language files.
- Update the LLM‑wiki and memories with the “no social columns in users” rule.
- Add memory entries documenting the SSO architecture.
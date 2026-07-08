# Socialite Authentication Architecture

## Core Rule
- Never add provider IDs to `users` table
- Use `SocialiteUser` model (socialite_users table)

## Architecture
```php
users.id → foreign key in socialite_users
provider_id → unique provider identifier
token, name, email, avatar
```

## Why
- Zero DB bloat from multiple provider columns
- Supports unlimited providers
- Standardized OAuth handling

## Forms Action
```php
// Example action
app(CreateSocialiteUserAction::class)->execute($provider, $oauthUser, $user);
```

## References
- `laravel/Modules/User/docs/wiki/concepts/socialite-architecture.md`
- 8-27 story fix
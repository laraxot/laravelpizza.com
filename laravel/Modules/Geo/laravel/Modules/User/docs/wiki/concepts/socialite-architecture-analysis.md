---
title: "Socialite Architecture Analysis - OAuth Integration without User Table Pollution"
type: concept
confidence: high
created: 2026-04-20
updated: 2026-04-20
tags: [socialite, oauth, google, github, authentication, architecture, social-login]
sources:
  - https://developers.google.com/identity/protocols/oauth2/web-server
  - https://filamentphp.com/plugins/chrisreedio-socialment
  - https://filamentphp.com/plugins/dododedodonl-socialite
  - laravel/Modules/User/app/Models/SocialiteUser.php
  - laravel/Modules/User/app/Models/SocialProvider.php
  - laravel/Modules/User/config/socialite.php
related:
  - ./socialite-admin-configuration.md
  - ../../../../docs/wiki/concepts/oauth-security.md
---

# Socialite Architecture Analysis

## The Golden Rule

**NO social columns (google_id, facebook_id, etc.) in users table. EVER.**

Instead: Use separate `SocialiteUser` model with `user_id` foreign key.

---

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     USER MODULE                               │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌─────────────────────┐      ┌─────────────────────────┐│
│  │   users TABLE       │      │  socialite_users TABLE   ││
│  │   (core identity)   │      │  (social connections)    ││
│  ├─────────────────────┤      ├─────────────────────────┤│
│  │ id (PK)             │◄─────│ user_id (FK)           ││
│  │ email               │      │ provider (google, etc) ││
│  │ password            │      │ provider_id (google ID)││
│  │ name                │      │ token                  ││
│  │ ...                 │      │ name                   ││
│  │                     │      │ email                  ││
│  │ NO google_id!       │      │ avatar                 ││
│  │ NO facebook_id!   │      └─────────────────────────┘│
│  └─────────────────────┘                                    │
│                                                              │
│  ┌───────────────────────────────────────────────────────┐ │
│  │  SocialProvider (SUSHI ARRAY - NO DB TABLE)          │ │
│  │  ├─ name: "Google"                                   │ │
│  │  ├─ client_id: [from admin]                         │ │
│  │  ├─ client_secret: [from admin]                      │ │
│  │  ├─ scopes: ["openid", "email", "profile"]           │ │
│  │  ├─ active: true/false                              │ │
│  │  └─ svg: <icon>                                     │ │
│  └───────────────────────────────────────────────────────┘ │
│                                                              │
│  ┌───────────────────────────────────────────────────────┐ │
│  │  Actions (QueueableAction pattern)                    │ │
│  │  ├─ CreateSocialiteUserAction                        │ │
│  │  ├─ RegisterSocialiteUserAction                      │ │
│  │  ├─ RetrieveSocialiteUserAction                      │ │
│  │  ├─ SetDefaultRolesBySocialiteUserAction            │ │
│  │  └─ GetUserModelAttributesFromSocialiteAction       │ │
│  └───────────────────────────────────────────────────────┘ │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

---

## Models Deep Dive

### 1. SocialiteUser (Database Model)

**File**: `laravel/Modules/User/app/Models/SocialiteUser.php`

**Purpose**: Links local user to external OAuth accounts.

**Schema**:
```php
protected $fillable = [
    'user_id',      // FK to users table
    'provider',     // 'google', 'github', 'facebook'
    'provider_id',  // The OAuth provider's user ID
    'token',        // Access token (encrypted)
    'name',         // Display name from provider
    'email',        // Email from provider
    'avatar',       // Avatar URL
];
```

**Relationship**:
```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

**Migration**: `2023_01_01_000003_create_socialite_user_table.php`

---

### 2. SocialProvider (Sushi Array Model)

**File**: `laravel/Modules/User/app/Models/SocialProvider.php`

**Purpose**: Configuration for each OAuth provider (NO database table - stored as PHP array).

**Why Sushi?** 
- Few providers (Google, GitHub, Facebook, etc.)
- Configuration rarely changes
- Can be managed via admin panel and persisted to config/cache

**Schema**:
```php
protected $fillable = [
    'name',           // "Google"
    'scopes',         // ["openid", "email", "profile"]
    'parameters',     // Extra OAuth params
    'stateless',      // true/false
    'active',         // Enable/disable
    'socialite',      // Use Socialite driver
    'svg',            // Icon SVG
    'client_id',      // From admin/config
    'client_secret',  // From admin/config
];
```

**Key Insight**: Client credentials can be set via:
1. Environment variables (fallback)
2. Admin panel (stored in config/cache)
3. Database-backed config (future enhancement)

---

## Flow: User Logs in with Google

```
┌─────────────┐     ┌────────────────────────────┐     ┌──────────────────┐
│   USER      │────▶│  /auth/google/redirect     │────▶│  Google OAuth    │
│             │     │  (SocialiteController)     │     │  Consent Screen  │
└─────────────┘     └────────────────────────────┘     └──────────────────┘
                                                              │
                                                              ▼
┌─────────────┐     ┌────────────────────────────┐     ┌──────────────────┐
│  DASHBOARD  │◀────│  /auth/google/callback      │◀────│  Google Callback │
│             │     │  (SocialiteController)     │     │  with code       │
└─────────────┘     └────────────────────────────┘     └──────────────────┘
                              │
                              ▼
                    ┌─────────────────────────┐
                    │  RetrieveSocialiteUser   │
                    │  - Check if provider_id │
                    │    exists               │
                    └─────────────────────────┘
                              │
                    ┌─────────┴─────────┐
                    ▼                   ▼
            ┌──────────────┐     ┌──────────────┐
            │  EXISTS      │     │  NEW USER    │
            │              │     │              │
            │ Login user   │     │ Register     │
            │ Redirect     │     │ Create link  │
            └──────────────┘     └──────────────┘
```

---

## Actions Reference

### CreateSocialiteUserAction
```php
public function execute(
    string $provider,           // 'google'
    SocialiteUserContract $oauthUser,  // Laravel Socialite user
    UserContract $user          // Local user model
): SocialiteUser
```
Creates the database link between local user and OAuth account.

### RegisterSocialiteUserAction
```php
public function execute(
    string $provider,
    SocialiteUserContract $oauthUser
): UserContract
```
Creates new local user from OAuth data, then calls CreateSocialiteUserAction.

### RetrieveSocialiteUserAction
```php
public function execute(
    string $provider,
    SocialiteUserContract $oauthUser
): ?SocialiteUser
```
Finds existing socialite connection by provider + provider_id.

---

## Configuration

### File: `config/socialite.php`

```php
return [
    // Allow registration via social login
    'registration' => true,
    
    // Visible providers (matches SocialProvider model)
    'providers' => [
        'google' => [
            'label' => 'Google',
            'icon' => 'ui-google',
        ],
        'github' => [
            'label' => 'GitHub',
            'icon' => 'fab-github',
        ],
    ],
    
    // Redirect after login
    'login_redirect_route' => 'filament.pages.dashboard',
    
    // Route for socialite login page
    'login_page_route' => 'filament.auth.login',
];
```

---

## Admin Configuration Strategy

### Goal
Allow admins to configure `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` via backoffice UI.

### Approach 1: Config File Generation (Recommended)

```php
// Admin saves credentials → generates config file
class SocialProviderSettingsPage extends Page
{
    public function save(): void
    {
        $config = [
            'google' => [
                'client_id' => $this->google_client_id,
                'client_secret' => $this->google_client_secret,
                'redirect' => route('socialite.callback', 'google'),
            ],
        ];
        
        // Write to config/services.php or custom file
        ConfigWriter::write('services.google', $config['google']);
        
        // Clear config cache
        Artisan::call('config:clear');
    }
}
```

### Approach 2: Database-Backed Config (Future)

```php
// Store in settings table, override in SocialiteServiceProvider
class SocialiteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Override Socialite config from database
        $googleSettings = Setting::get('socialite.google');
        
        Config::set('services.google.client_id', $googleSettings['client_id']);
        Config::set('services.google.client_secret', $googleSettings['client_secret']);
    }
}
```

---

## Security Considerations

### 1. Token Storage
- Store OAuth tokens encrypted (database column should be TEXT)
- Never expose tokens in logs or API responses

### 2. Client Secret
- NEVER commit client secrets to git
- Use environment variables as fallback
- Admin panel should mask secrets (show only last 4 chars)

### 3. State Parameter
- Always use `state` parameter in OAuth flow (CSRF protection)
- Socialite handles this automatically when `stateless => false`

### 4. Email Verification
- Google/email providers: email is pre-verified
- Other providers: may need additional verification step

---

## Comparison: Our Architecture vs Others

| Approach | User Table Columns | Flexibility | Multi-Account |
|----------|-------------------|-------------|---------------|
| **Laraxot (Ours)** | Clean (no social cols) | ⭐⭐⭐ High | ✅ Yes - one user, many socials |
| Default Socialite | google_id, github_id... | ⭐⭐ Medium | ❌ One social per user |
| Laravel Jetstream | provider, provider_id | ⭐⭐⭐ High | ✅ Yes |
| Custom Columns | facebook_id, twitter_id... | ⭐ Low | ❌ Limited |

---

## Filament Resources

### SocialiteUserResource
- List all social connections
- View details
- Delete connection (unlink)

### SocialProviderResource (Admin Config)
- Enable/disable providers
- Set client_id/client_secret
- Configure scopes
- Upload custom SVG icons

---

## References

- **Laravel Socialite**: https://laravel.com/docs/socialite
- **Google OAuth**: https://developers.google.com/identity/protocols/oauth2/web-server
- **FilamentSocialite**: https://filamentphp.com/plugins/chrisreedio-socialment
- **DutchCodingCompany**: https://github.com/DutchCodingCompany/filament-socialite

---

**Last Updated**: 2026-04-20  
**Rule Owner**: User Module Architecture Team

---
name: socialite-integration-guide
description: **Guide**: Implementing social authentication without cluttering User table
**Applies to**: laravel/Modules/User
**Enforced by**: Modular architecture and DRY principles

**Key Decisions**:
- No google_id/facebook_id columns in User table
- SocialiteUser model handles provider-specific IDs
- SocialProvider model maps providers to user
- Filament admin handles credential storage

**Implementation Steps**:
1. Use SocialiteUser.php to store:
   - provider_id
   - auth_token
   - refresh_token
   - expires_in
   - uid
2. SocialProvider.php maintains:
   - provider name
   - client_id
   - client_secret
3. Admin configuration in BackOffice for:
   - Setting GOOGLE_CLIENT_ID/GOOGLE_CLIENT_SECRET
   - Managing active social providers

**Why This Pattern**:
- Scales to multiple providers
- Avoids One True Fluke pattern
- Follows Filament's service-container approach

**References**:
- Google OAuth docs: https://developers.google.com/identity/protocols/oauth2/web-server
- Filament Socialite docs: https://docs.filamentflow.io/docs/features/socialite
- Socialment plugin: https://github.com/chrisreedio/socialment

**Security Considerations**:
- Store secrets in BackOffice config
- Rotate credentials periodically
- Use environment variables in production

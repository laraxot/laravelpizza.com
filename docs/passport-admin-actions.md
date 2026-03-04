# Passport Administrative Actions in UI

This document describes the administrative actions for Laravel Passport available directly within the Filament admin panel, reducing the need for terminal access.

## Passport Dashboard

The Passport Dashboard (`/admin/user/passport/passport-dashboard`) provides high-level administrative tasks:

- **Generate Keys**: Executes `php artisan passport:keys`. Generates the encryption keys required to issue access tokens.
- **Purge Tokens**: Executes `php artisan passport:purge`. Removes expired and revoked tokens from the database.
- **Hash Secrets**: Executes `php artisan passport:hash`. Hashes all existing client secrets. **Warning: This is a one-way operation.**
- **Install Passport**: Executes `php artisan passport:install --uuids`. Performs the initial setup, generating keys and creating default clients.

### Key Status Icons
The dashboard displays the status of the OAuth keys:
- ✅ **Private Key Found**: `storage/oauth-private.key` exists.
- ✅ **Public Key Found**: `storage/oauth-public.key` exists.
- ❌ **Key Missing**: Indicates that keys need to be generated.

## OAuth Clients Management

The OAuth Clients resource (`/admin/user/passport/oauth-clients`) supports creating specific types of clients via header actions:

- **Create Personal Access Client**: For issuing personal access tokens.
- **Create Password Grant Client**: For the OAuth2 password grant flow.
- **Create Client Credentials Client**: For machine-to-machine authentication.

### Individual Client Actions
Within the list or view pages of a client, you can:
- **Revoke**: Revokes the client and all its associated tokens.
- **Regenerate Secret**: Generates a new secret for the client.

## Token Management

- **Revoke All for User**: Available in `OauthAccessTokenResource`. Allows an administrator to revoke all active tokens for a specific user, effectively forcing a logout across all devices.

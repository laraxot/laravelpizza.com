# OAuth Documentation Index

> **Module**: User  
> **Topic**: OAuth 2.0 / Laravel Passport  
> **Last Updated**: 2026-03-18

---

## 📚 Documentation Files

| File | Description |
|------|-------------|
| **[oauth-architecture.md](./oauth-architecture.md)** | ✅ **START HERE** - Complete OAuth architecture, models, and usage |
| [github.md](./github.md) | GitHub OAuth integration (if applicable) |

---

## 🎯 Quick Reference

### Models

- `OauthClient` - OAuth 2.0 Client (PRIMARY model)
- `OauthToken` - Access Token
- `OauthAuthCode` - Authorization Code
- `OauthRefreshToken` - Refresh Token
- `OauthDeviceCode` - Device Code
- `OauthPersonalAccessClient` - Personal Access Client

### Key Features

- ✅ **Authorizable** - Laravel authorization integration
- ✅ **HasRoles** - Spatie Permission for client roles
- ✅ **Multi-tenant** - Dedicated `user` database connection
- ✅ **Factory Pattern** - Testing support

---

## 🚀 Getting Started

1. **Read**: [oauth-architecture.md](./oauth-architecture.md)
2. **Understand**: Model structure and relationships
3. **Implement**: Use `OauthClient` (NOT `Passport\Client` directly)
4. **Test**: Use `OauthClientFactory` for test data

---

## ⚠️ Important Rules

- ❌ **NEVER** use `Laravel\Passport\Client` directly
- ✅ **ALWAYS** use `Modules\User\Models\OauthClient`
- ❌ **NEVER** create duplicate wrapper models (DRY + KISS)
- ✅ **ALWAYS** use `app()` for Actions, not direct instantiation

---

## 📝 Recent Changes

### 2026-03-18 - DRY Cleanup

- Removed duplicate `Passport/Client.php` model
- Consolidated all OAuth client functionality in `OauthClient.php`
- Updated test files to use single model

See: [oauth-architecture.md](./oauth-architecture.md#2026-03-18---dry-cleanup)

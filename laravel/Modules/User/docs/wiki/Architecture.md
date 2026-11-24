---
module: User
concept: Architecture
last_updated: 2026-04-15
---

# User Module Architecture

The **User** module manages authentication, authorization, and profile data. It is a critical component that interacts with almost every other module in the system.

## 1. Core Responsibilities
- **Authentication**: Handling login, logout, and registration.
- **Authorization**: Managing roles and permissions (integrates with Spatie).
- **Security**: Multi-factor authentication (2FA) and SSO.
- **Profile Management**: Separating core auth data from user-specific details.

## 2. The Sacred Inheritance Chain
Following the [[BaseModel]] pattern, the user models follow this structure:

```text
User Model → BaseUser → XotBaseModel → Laravel Authenticatable
```

- **BaseUser**: Located in `Modules/User/Models/BaseUser.php`. It adds auth-specific traits and common user logic.

## 3. Directory Structure
The module follows the standard Laraxot structure:
- `app/Actions`: Core business logic (e.g., `CreateUserAction`, `Enable2FAAction`).
- `app/Filament`: Resources for managing Users, Roles, Permissions, and Tenants.
- `app/Contracts`: Interfaces like `UserContract` and `ProfileContract` for cross-module type safety.

## 4. Key Dependencies
- `laravel/passport`: OAuth2 server implementation.
- `spatie/laravel-permission`: Role-based access control.
- `pragmarx/google2fa-laravel`: TOTP implementation for 2FA.
- `socialiteproviders/auth0`: SSO integration.

---
**Related Pages:**
- [[User vs Profile]]
- [[Two-Factor Authentication]]
- [[Roles and Permissions]]

---
title: "User Module Architecture (BMAD)"
type: note
status: draft
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "user module architecture (bmad) user"
---
# User Module Architecture (BMAD)

**Status**: ✅ Finalized
**Last Update**: 2026-09-21
**Scope**: Module User architecture documentation for perfection

## 🏗️ System Overview

The User module is the **identity foundation** for the entire PTVX ecosystem. It provides authentication, authorization, user management, teams, and multi-tenancy through a well-layered architecture.

## 📐 Architectural Layers

### Layer 1: Models (Data Foundation)
**Location**: `app/Models/`

**Core Models**:
- `BaseUser` → `User`: STI-based user with authentication and authorization
- `Profile`: Extended user profile with schemaless attributes
- `Team`: Team collaboration with hierarchical permissions
- `Tenant`: Multi-tenancy isolation
- `Role`/`Permission`: RBAC via Spatie Permission
- `AuthenticationLog`: Security audit trail
- `Device`: User device tracking
- `SocialProvider`: OAuth/Social login integration
- `SsoProvider`: SSO integration

**Pattern**: Eloquent models with global scopes for tenant/team isolation, UUID primary keys, timestamp auditing.

### Layer 2: Actions (Business Logic)
**Location**: `app/Actions/`

**Action Categories**:
```
app/Actions/
├── Authentication/     # Login, logout, two-factor
├── Authorization/      # Role/permission assignment
├── UserManagement/     # Create, update, delete, activate
├── TeamManagement/     # Team membership, invitations
├── Socialite/          # OAuth flows
├── Passport/           # OAuth2 client management
├── Otp/               # One-time password logic
└── Shield/            # Filament Shield configuration
```

**Pattern**: All business logic implemented as Queueable Actions with `->execute()` method, following Xot conventions.

### Layer 3: Traits (Reusable Behaviors)
**Location**: `app/Models/Traits/`

**Trait Hierarchy**:
```
HasAuthenticationLogTrait → Authentication event tracking
HasDevices → Device management
HasSocialite → OAuth integration
HasSpatiePermission → Role/permission handling
HasTeams → Team management
HasTenants → Multi-tenancy
HasPasswordExpiry → Password lifecycle
HasModules → Module access control
```

**Pattern**: Traits compose complex behaviors without inheritance coupling.

### Layer 4: Filament Resources (Admin UI)
**Location**: `app/Filament/Resources/`

**Resource Structure**:
```
app/Filament/Resources/
├── UserResource         # Main user CRUD
├── TeamResource         # Team management
├── RoleResource         # Role configuration
├── PermissionResource   # Permission setup
├── TenantResource       # Tenant management
├── AuthenticationLogResource  # Security audit
├── DeviceResource       # Device management
└── ...                  # Supporting resources
```

**Pattern**: Each resource extends `XotBaseResource` with consistent patterns for listing, creating, editing, and viewing records.

### Layer 5: Widgets & Pages (UI Components)
**Location**: `app/Filament/Widgets/` and `app/Filament/Pages/`

**Widget Types**:
- **Auth Widgets**: Login, Register, ForgotPassword, PasswordReset
- **Profile Widgets**: EditUser, Profile, SuperAdmin
- **Dashboard Widgets**: UsersChart, SecurityAlerts, LoginWidget
- **Team Widgets**: TeamChange

**Page Types**:
- **Auth Pages**: Login, Register, PasswordExpired, EditProfile
- **Admin Pages**: Dashboard, SocialiteProviderSettings
- **Tenancy Pages**: RegisterTeam, RegisterTenant, EditTeamProfile, EditTenantProfile

**Pattern**: Widgets extend `XotBaseWidget` with consistent form handling and event listening.

## 🔗 Dependency Graph

```
User Module
├── Depends On:
│   ├── Xot (BaseModel, BaseResource, traits)
│   ├── Spatie Permission (RBAC)
│   ├── Laravel Passport (OAuth2)
│   ├── Filament v5 (Admin UI)
│   └── Socialiteproviders (OAuth providers)
│
├── Consumed By:
│   ├── Activity (User activity tracking)
│   ├── Notify (Notifications)
│   ├── Tenant (Enhanced tenancy)
│   ├── Lang (Translations)
│   ├── Performance (User metrics)
│   └── UI (Interface components)
│
└── Used By: 16+ modules (Activity, Notify, Tenant, Lang, etc.)
```

## 📊 Data Flow Architecture

### User Lifecycle
```
Registration → Validation → User Creation → Profile Creation
                                              → Default Role Assignment
                                              → Welcome Email
                                              → Activity Log
```

### Authentication Flow
```
Login Request → Validation → Credential Check → 2FA Challenge (if enabled)
                                              → Session Creation
                                              → Authentication Log
                                              → Token Generation
```

### Team/Hierarchy Flow
```
Team Creation → Owner Assignment → Member Invitation
                                    → Role Assignment
                                    → Permission Inheritance
                                    → Activity Tracking
```

## 🔒 Security Architecture

### Authentication Layers
1. **Primary**: Username/password with bcrypt
2. **Secondary**: OAuth/Social login (Google, Facebook, GitHub, Microsoft)
3. **Tertiary**: SSO integration via SAML/OAuth
4. **Quaternary**: 2FA (TOTP) for enhanced security

### Authorization Matrix
```
Role-Based Access Control (RBAC)
├── Super Admin → Full system access
├── Admin → Module administration
├── HR Manager → User management within scope
└── User → Basic profile access

Team-Based Permissions
├── Team Owner → Full team control
├── Team Admin → Team member management
└── Team Member → Limited team access

Tenant Isolation
├── Tenant Admin → Full tenant management
├── Tenant User → Limited tenant access
└── Cross-Tenant → Controlled by super-admin policies
```

### Security Features
- **Rate Limiting**: Login attempt throttling
- **Account Lockout**: After repeated failed attempts
- **Session Management**: Secure session handling with device tracking
- **Token Expiration**: Automatic token revocation
- **Audit Logging**: Complete authentication trail
- **Password Policies**: Configurable expiration and complexity

## ⚙️ Configuration Architecture

### Core Configuration Files
- `config/user.php`: Module-level settings
- `config/passport.php`: OAuth2 configuration
- `config/socialite.php`: OAuth provider settings
- `config/social-providers.php`: Provider-specific settings
- `config/password.php`: Password reset settings

### Environment Variables
- `USER_AUTH_TIMEOUT`: Authentication timeout
- `USER_2FA_ENABLED`: Two-factor authentication toggle
- `USER_TEAM_LIMIT`: Maximum teams per user
- `USER_TENANT_MODE`: Isolation level (none/soft/hard)

## 🎨 UI/UX Architecture

### Filament Panel Integration
- **Main Panel**: `Modules\User\Providers\Filament\AdminPanelProvider`
- **Navigation**: Automatic discovery of resources, pages, widgets
- **Theming**: Consistent branding and layout
- **Responsive**: Mobile-first design patterns

### Widget Architecture
```php
class FirmaValutatoreWidget extends XotBaseWidget
{
    public ?string $valutatore_id = '';
    public ?string $anno = '';
    public ?array $filters = null;

    // Visibility controlled by filters
    public function visible(): bool
    {
        return $this->filters['valutatore_id'] !== null;
    }
}
```

## 🔄 Integration Patterns

### API Integration
- **Sanctum Tokens**: For external API authentication
- **Passport Clients**: For OAuth2 server-side integration
- **Socialite**: For social login flows
- **SSO Providers**: For enterprise SSO

### Event-Driven Architecture
```php
// Domain Events
UserCreated, UserLoggedIn, UserLoggedOut,
RoleAssigned, PermissionRevoked, TeamCreated,
TenantAssigned, DeviceRegistered, PasswordChanged

// Event Listeners
ActivityLogger, NotificationSender, AuditLogger,
TokenRevoker, SessionCleaner
```

## 📈 Scalability Patterns

### Database Scaling
- **Connection Isolation**: Separate 'user' connection
- **Read Replicas**: Distributed read queries
- **Sharding**: Future multi-database support
- **Caching**: Redis-based caching layers

### Performance Optimization
- **Lazy Loading**: Deferred relationship loading
- **Eager Loading**: Strategic preloading for lists
- **Query Optimization**: Composite indexes and selective columns
- **Pagination**: Efficient large dataset handling

## 🎯 Architectural Principles

1. **Separation of Concerns**: Clear boundaries between layers
2. **Composition over Inheritance**: Trait-based behavior composition
3. **Convention over Configuration**: Consistent patterns across module
4. **Security by Default**: Secure defaults and explicit overrides
5. **Performance by Design**: Optimized from the start
6. **Extensibility First**: Designed for growth and modification
7. **Testability**: Architecture supports comprehensive testing
8. **Documentation-driven**: Self-documenting code and clear patterns

---

*Architecture documentation based on BMAD methodology*  
*Last verified: 2026-09-21*

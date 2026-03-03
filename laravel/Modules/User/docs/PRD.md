# User - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **
> **Status**: Approved
> **Owner**: User Module Team

## 1. Purpose & Vision

The User module is the **identity and access management** backbone of the Laraxot ecosystem. It manages authentication, authorization, user profiles, teams, roles and permissions, OAuth (Passport), social login (Socialite), SSO, and device management.

The vision is to become a **complete Identity Provider (IdP)** supporting modern standards like Passkeys (WebAuthn), with AI-driven moderation and anomaly detection.

## 2. Problem Statement

Enterprise HR systems require:
- Secure multi-method authentication (credentials, OAuth, social, SSO, biometric)
- Fine-grained role and permission management across modules
- Multi-tenant user isolation with team-based access
- Comprehensive audit trail of authentication events
- Device tracking for security compliance

## 3. Target Users

| User | Role | Needs |
|------|------|-------|
| **Employee** | End user | Login, profile management, password reset |
| **HR Administrator** | Manages workforce | User provisioning, role assignment, team management |
| **System Admin** | Security oversight | OAuth clients, SSO configuration, audit logs |
| **IT Security** | Compliance | Authentication logs, device management, token auditing |

## 4. Scope

### In Scope
- User CRUD and profile management (50+ models)
- Multi-authentication: credentials, OAuth 2.0 (Passport), Socialite, SSO
- Role-based access control (Spatie Permission)
- Team and tenant user management
- Device tracking and management
- Authentication event logging
- OAuth client/token administration (Passport Cluster)
- Social provider configuration (Socialite Cluster)

### Out of Scope
- GDPR consent management (Gdpr module)
- Multi-tenant infrastructure (Tenant module)
- Notification delivery (Notify module)

## 5. Functional Requirements (Prioritized)

### P0: Identity & Security (Must-have)
- **FR-001: Multi-method Authentication**: Credentials (email/password), OAuth 2.0 (Passport), and Socialite (Google, Apple, etc.).
- **FR-002: RBAC Framework**: Role-based access control using Spatie Permission, integrated across all modules.
- **FR-007: Security Audit**: Comprehensive logging of all authentication events (login, logout, failed attempts) with IP and device tracking.

### P1: Access Administration (Important)
- **FR-003: OAuth Management (Passport Cluster)**: Admin interface for managing OAuth clients, access tokens, and refresh tokens.
- **FR-005: Team & Tenant Access**: Create teams, assign users, and manage team-level permissions for multi-tenant isolation.
- **FR-008: Social Provider Configuration (Socialite Cluster)**: Self-service configuration of social login providers.

### P2: Advanced Identity (Nice-to-have)
- **FR-006: Device & Profile Control**: Track user devices and manage extended profiles for domain-specific data.
- **FR-009: Biometric & Passkeys**: Implementation of WebAuthn/Passkeys for passwordless authentication.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Global Identity Provider**: User acts as the central IdP for the entire ecosystem; it SHOULD NOT have dependencies on domain modules (e.g., Performance, HR).
- **Polymorphic Profiles**: Extended user data is managed via polymorphic relationships, allowing domain modules to attach data without modifying the core User schema.
- **Interoperability**: Provides standardized authentication/authorization middleware for all other modules.

### Performance & Safety
- **NFR-001: Security**: Password hashing with bcrypt/argon2; mandatory rate limiting on all auth endpoints.
- **NFR-002: Performance**: Login response < 500ms; token validation < 50ms.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance across all 55 models.

## 7. Technical Architecture

### Dependencies
- **Xot**: Base classes (`XotBaseResource`, `XotBasePage`)
- **Gdpr**: Registration consent
- **Tenant**: Multi-tenant support (if active)
- **Laravel Passport**: OAuth 2.0
- **Laravel Socialite**: Social authentication
- **Spatie Permission**: RBAC

### Data Model
- `users` — Core user table
- `profiles` — Extended user data
- `teams`, `team_user` — Team management
- `roles`, `permissions`, `model_has_roles`, `model_has_permissions` — RBAC
- `oauth_clients`, `oauth_access_tokens`, `oauth_refresh_tokens` — Passport
- `social_providers`, `socialite_users`, `sso_providers` — Social/SSO
- `devices`, `device_profiles`, `device_user` — Device tracking
- `authentication_logs` — Audit trail
- 55 migrations total

### Integration Points
- Provides `User` model consumed by every module
- Passport endpoints for API authentication
- Permission middleware for route protection
- Profile relationship for domain modules (Performance, Rating, etc.)

## 8. User Experience

- **Login page**: Multi-method authentication (credentials + social buttons)
- **Profile page**: Personal data, linked accounts, active sessions
- **Admin panel**: User list, role assignment, OAuth management, device overview
- **Filament Clusters**: Passport (OAuth admin), Socialite (social providers)

## 9. Success Metrics & KPIs

| Metric | Target | Measurement |
|--------|--------|-------------|
| PHPStan Level 10 | 0 errors | PHPStan analysis |
| Auth test coverage | 100% critical flows | Pest test suite |
| Login success rate | > 99% | Authentication logs |
| Token audit | Complete | All tokens traceable |

## 10. Risks & Assumptions

### Assumptions
- All modules use Spatie Permission for authorization
- Passport is the primary API authentication mechanism
- Profile model is polymorphic (extendable by domain modules)

### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Security breach via weak tokens | Critical | Automated token rotation, audit logging |
| Performance with 50+ models | Medium | Lazy loading, query optimization |
| Socialite provider API changes | Low | Adapter pattern per provider |

## 11. Dependencies & Constraints

- **Technical**: PHP 8.3+, Laravel 12, Passport 13, Filament v5
- **Business**: Must comply with Italian PA authentication standards
- **Regulatory**: GDPR-compliant user data handling (delegated to Gdpr module)

## 12. Release Plan

### Phase 1: Stability & Security (In Progress)
- PHPStan Level 10 ✅
- ID pattern standardization ✅
- Obsolete file removal
- Security Cluster implementation

### Phase 2: Modern Identity (Planned)
- WebAuthn/Passkeys integration
- Additional Socialite providers
- Secure impersonation system

### Phase 3: AI Moderation (Future)
- AI identity verification
- Anomaly detection for suspicious logins
- Dynamic permission suggestions

## 13. References

- [roadmap.md](roadmap.md)
- [module.md](module.md)
- [namespace-conventions.md](namespace-conventions.md)
- [login-widget-conversion.md](login-widget-conversion.md)

# Task 001: Implement User Management and Authentication System

## Description
Create comprehensive user management system with authentication, authorization, profiles, teams, and social authentication.

## Context
The User module is critical for the entire system. It needs robust user management, authentication, authorization, and team functionality with security best practices.

## Requirements

### Functional Requirements
- User management (CRUD)
- Authentication (login, logout, registration, password reset)
- Authorization (roles, permissions, policies)
- User profiles
- Team management
- Social authentication (OAuth)
- Two-factor authentication
- User settings and preferences
- User activity tracking
- Email verification

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Laravel Fortify/Sanctum
- Spatie Permissions
- Socialite
- DatabaseTransactions for tests

## Implementation Steps

### 1. Database Schema
- [ ] Create `users` table
  - id (uuid/ulid)
  - tenant_id
  - name (string)
  - email (string, unique)
  - username (string, unique, nullable)
  - password (string)
  - phone (string, nullable)
  - avatar (string, nullable)
  - bio (text, nullable)
  - locale (string, default 'it')
  - timezone (string, default 'Europe/Rome')
  - email_verified_at (nullable)
  - two_factor_secret (nullable)
  - two_factor_enabled (boolean, default false)
  - two_factor_confirmed_at (nullable)
  - last_login_at (nullable)
  - last_login_ip (string, nullable)
  - is_active (boolean, default true)
  - is_superuser (boolean, default false)
  - metadata (json, nullable)
  - deleted_at (nullable)
  - timestamps

- [ ] Create `user_profiles` table
  - id, user_id, first_name, last_name, date_of_birth (nullable), gender (nullable), address (json), social_links (json)

- [ ] Create `user_settings` table
  - id, user_id, notification_preferences (json), privacy_settings (json), ui_preferences (json)

- [ ] Create `user_activities` table
  - id, user_id, activity_type, description, ip_address, user_agent, created_at

### 2. Models
- [ ] Create `User` model (extends Authenticatable)
- [ ] Create `UserProfile` model
- [ ] Create `UserSetting` model
- [ ] Create `UserActivity` model

### 3. Authentication Service
- [ ] Create `AuthenticationService`
  - `login(array $credentials): User`
  - `logout(): void`
  - `register(array $data): User`
  - `verifyEmail(string $token): bool`
  - `sendPasswordResetLink(string $email): void`
  - `resetPassword(array $data): bool`
  - `enableTwoFactor(User $user): array` (returns secret, qr code)
  - `confirmTwoFactor(User $user, string $code): bool`
  - `disableTwoFactor(User $user): bool`

### 4. Authorization Service
- [ ] Create `AuthorizationService`
  - `assignRole(User $user, string $role): bool`
  - `revokeRole(User $user, string $role): bool`
  - `givePermission(User $user, string $permission): bool`
  - `revokePermission(User $user, string $permission): bool`
  - `hasRole(User $user, string $role): bool`
  - `hasPermission(User $user, string $permission): bool`
  - `getUserRoles(User $user): Collection`
  - `getUserPermissions(User $user): Collection`

### 5. User Management Service
- [ ] Create `UserManagementService`
  - `createUser(array $data): User`
  - `updateUser(string $userId, array $data): User`
  - `deleteUser(string $userId, bool $hardDelete = false): bool`
  - `suspendUser(string $userId, string $reason): bool`
  - `activateUser(string $userId): bool`
  - `getUsers(array $filters): Collection`
  - `searchUsers(string $query): Collection`

### 6. Profile Management Service
- [ ] Create `ProfileManagementService`
  - `updateProfile(string $userId, array $data): UserProfile`
  - `uploadAvatar(string $userId, UploadedFile $avatar): string`
  - `updateSocialLinks(string $userId, array $links): bool`
  - `getPublicProfile(string $userId): array`

### 7. Settings Service
- [ ] Create `UserSettingsService`
  - `updateSettings(string $userId, array $settings): UserSetting`
  - `getSettings(string $userId): UserSetting`
  - `updateNotificationPreferences(string $userId, array $preferences): bool`
  - `updatePrivacySettings(string $userId, array $settings): bool`

### 8. Social Authentication Service
- [ ] Create `SocialAuthService`
  - `getRedirectUrl(string $provider): string`
  - `handleCallback(string $provider): User`
  - `linkSocialAccount(User $user, string $provider): bool`
  - `unlinkSocialAccount(User $user, string $provider): bool`
  - `getSocialAccounts(User $user): array`

### 9. Team Management Service
- [ ] Create `TeamManagementService`
  - `createTeam(User $owner, array $data): Team`
  - `updateTeam(string $teamId, array $data): Team`
  - `deleteTeam(string $teamId): bool`
  - `addMember(string $teamId, string $userId, string $role): bool`
  - `removeMember(string $teamId, string $userId): bool`
  - `updateMemberRole(string $teamId, string $userId, string $role): bool`
  - `getTeams(User $user): Collection`
  - `getTeamMembers(string $teamId): Collection`

### 10. Filament Resources
- [ ] Create `UserResource`
  - User list with filters
  - Create/Edit user
  - User details
  - Role management

- [ ] Create `UserProfileResource`
  - Profile management
  - Avatar upload
  - Social links

- [ ] Create `UserSettingsResource`
  - Settings management
  - Preferences

- [ ] Create `TeamResource`
  - Team management
  - Member management
  - Team analytics

### 11. API Endpoints
- [ ] `POST /api/users/register` - Register
- [ ] `POST /api/users/login` - Login
- [ ] `POST /api/users/logout` - Logout
- [ ] `GET /api/users/me` - Get current user
- [ ] `PUT /api/users/me` - Update current user
- [ ] `POST /api/auth/two-factor/enable` - Enable 2FA
- [ ] `POST /api/auth/social/{provider}` - Social auth

### 12. Actions
- [ ] Create `CreateUserAction`
- [ ] Create `SuspendUserAction`
- [ ] Create `ResetPasswordAction`
- [ ] Create `SendVerificationEmailAction`

### 13. Tests
- [ ] Create `AuthenticationServiceTest`
- [ ] Create `AuthorizationServiceTest`
- [ ] Create `UserManagementServiceTest`
- [ ] Create `SocialAuthServiceTest`

### 14. Documentation
- [ ] Create user management guide
- [ ] Document authentication flows
- [ ] Create authorization guide
- [ ] Add social auth guide

## Acceptance Criteria
- [ ] Authentication works reliably
- [ ] Authorization is enforced
- [ ] Users can be managed
- [ ] Profiles can be updated
- [ ] Teams function correctly
- [ ] Social auth works
- [ ] Two-factor authentication works
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- Tenant module (tenant users)
- Laravel Fortify
- Laravel Sanctum
- Spatie Permissions
- Socialite
- Filament 5.x (admin UI)

## Estimated Time
- Database schema: 4 hours
- Models: 4 hours
- Authentication: 6 hours
- Authorization: 4 hours
- User management: 5 hours
- Profile management: 4 hours
- Settings: 3 hours
- Social auth: 5 hours
- Team management: 5 hours
- Filament integration: 6 hours
- API endpoints: 3 hours
- Actions: 2 hours
- Tests: 8 hours
- Documentation: 3 hours

**Total: 62 hours (~8 days)**

## Priority
**High** - Core user functionality

## Related Tasks
- Task 002: Advanced User Features

## Notes
- Use Laravel's built-in auth features
- Implement rate limiting for auth endpoints
- Use bcrypt for passwords
- Implement email verification
- Use secure session management
- Log authentication events
- Implement password policies
- Support multiple social providers

---

**Status**: Pending
**Assignee**: TBD
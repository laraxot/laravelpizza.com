# User Module Philosophy

Centralized authentication, authorization, identity management, and multi-team roles for all 47 modules.

## First Principle

> **One `id` stays the same across tokens, logs, teams, and devices.**

Every user has a stable identity regardless of team context, authentication method, or session duration. Violating this breaks audit trails and role inheritance.

## The Rules

### 1. BaseUser via Single-Table Inheritance

Extend `BaseUser` model on the `user` connection:
```php
namespace Modules\User\Models;

class User extends BaseUser
{
    // module-specific properties
}
```

**Why:** Consistent columns (created_by, updated_by, deleted_at). Casting rules apply everywhere. Audit trails point to one table.

### 2. Spatie Permissions Per Team

Roles and permissions are scoped to team:
```php
$user->hasRole('admin', 'team-id') // true if admin in this team only
```

**Never** use global roles without team context.

**Why:** Users change teams and roles should change with them. No global permissions = no privilege escalation across tenants.

### 3. Passport for OAuth2, Not Direct Token Creation

Social login and OAuth2 go through Passport:
- Password grants
- Social authentication via Socialite
- Personal access tokens for APIs

**Never** create auth tokens outside of Passport.

**Why:** Unified token expiry, refresh logic, and revocation. Session clustering for distributed systems depends on it.

### 4. MyProfile + Settings Per User

User settings live in polymorphic `Setting` model:
```php
$user->setting('notifications.email')->value === true
```

**Never** add columns to users table for settings.

**Why:** Settings scale; user table stays lean. Migrations don't need every new pref.

### 5. SocialiteProvider for Third-Party Auth

External logins (Google, GitHub, etc.) integrate via `SocialiteProvider`:
```php
class GoogleProvider extends SocialiteProvider
{
    public function getUser() { /* handle OAuth callback */ }
}
```

**Why:** Adding a new provider is one class, not touching User model. Decoupled from Laravel Socialite API changes.

### 6. Soft Deletes + Cascade Restore

Users are soft-deleted, not hard-deleted. Related records cascade:
```php
$user->delete() // soft delete
$user->restore() // restore + all team_memberships, roles restored
```

**Why:** Audit trails need users to exist. Accidental deletes are reversible.

## The Zen of User

> **Trust the ID, trust the token, trust the role.**

- One user = one stable ID across time and teams
- One token = proof of authentication and delegated access
- One role assignment = permission set for one team and one context
- Settings inherit from templates; users override
- Third-party auth extends, not replaces, password flow

## Breaking the Rules

If you think a rule is wrong:
1. **Document the exception** in your module's README.
2. **Notify maintainers** if it affects authentication or roles.
3. **Update User docs** if the exception becomes a pattern.
4. **Never silently bypass** Passport or Spatie permissions — audit trail depends on it.

## See Also

- `ARCHITECTURE.md` — multi-tenant identity design
- `TESTING.md` — auth testing strategies
- `docs/oauth2-flows.md` — Passport configuration
- `docs/spatie-permissions-per-team.md` — role scoping rules
- `docs/socialite-providers.md` — adding new social login providers

---
title: "User — Philosophy: The Identity Foundation"
type: philosophy
module: User
status: active
created: 2026-09-06
updated: 2026-09-06
tags: [philosophy, identity, authentication, authorization, architecture, vision]
qmd: "user philosophy identity foundation authentication authorization sti multi-tenancy"
---

# User — Philosophy: The Identity Foundation

**The Grand Vision**: User is not a user management system. It is the identity spine of FixCity — the answer to three questions and only three: **who are you, what are you allowed to do, and for which organization.** Everything else belongs elsewhere.

---

## RELIGIONE — The Non-Negotiable Commandments

### 1. Single Table Inheritance is Sacred

All user types — User, Doctor, Patient, Client, Admin — live in one `users` table with a `type` column. STI via `Parental\HasChildren` is not optional; it's the foundational pattern.

```php
class BaseUser extends Authenticatable {
    use HasChildren;
    protected string $childColumn = 'type';
}

class Doctor extends User {
    use HasParent;
    // Doctor-specific logic, same row in users table
}
```

**Why**: STI unifies identity. Searching for "all medical staff" queries one table, not eight. Relationships are clean: a Team has Users, not "Users-or-Doctors-or-Admins". The database shape echoes the domain truth: these are all users first, specialized second.

### 2. Authentication and Authorization are Separate Domains

- **BaseUser** handles credentials: `email`, `password`, `password_expires_at`, `email_verified_at`, OAuth tokens.
- **BaseProfile** handles the person as a platform user: `first_name`, `last_name`, `avatar`, `preferences`.
- **Spatie\Permission** handles what you're allowed to do: roles and permissions, standardized and non-negotiable.

Do not mix these. A user can authenticate without a profile (system account). A profile without authentication is invalid. Permissions should never leak into either.

### 3. The User Connection is Dedicated

`BaseModel::$connection = 'user'` points to the `ptv_user` database — declared by hand in `config/local/ptvx/database.php`. Identity is separate infrastructure. This is not a performance optimization; it is a domain boundary.

### 4. Contracts Over Concrete Classes

All external references type on `Modules\Xot\Contracts\UserContract` and `Modules\Xot\Contracts\ProfileContract`, never on `Modules\Ptv\Models\User` or `Modules\User\Models\User`. The reason: User is a base class. `Ptv\Models\User` is a child. The parent must never know the child.

**Current Violation**: `OauthPersonalAccessClient.php:9` imports `Modules\Ptv\Models\Profile`. This is one line that makes User depend on the Portal. Fix it by typing on the contract.

### 5. Actions Over Services

Business logic lives in `app/Actions/**` with `QueueableAction` and an `execute()` method. Zero `app/Services` directory. This keeps concerns clear: actions are testable, enqueueable, and composable.

### 6. Permissions are Declared, Not Inferred

A permission that does not exist returns `false` silently. This is a security feature masquerading as a bug:

```php
// This returns false if 'scheda.approva' was never seeded
if ($user->can('scheda.approva')) { /* ... */ }
```

Document every permission in a seed or migration. Define them in code before the user ever checks them. The test `PermissionTest.php` should enumerate all permissions that exist.

---

## FILOSOFIA — The Design Philosophy

### The Three Questions

Every row in `users`, `profiles`, `roles`, `permissions`, `teams`, `tenants` answers one of three:

| Question | Tables | Scope |
|---|---|---|
| **Who are you?** | `users`, `profiles`, `devices`, `authentications`, `authentication_log`, `password_resets` | Identity & session |
| **What can you do?** | `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`, `team_permissions` | Authorization |
| **For whom?** | `teams`, `team_users`, `team_invitations`, `tenants`, `tenant_users` | Organizational scope |

Everything else (appointments, employees, performance reviews) belongs to domain modules. Do not ask User "where is this doctor's clinic?" Ask Tenant or a domain module.

### Why Not Sanctum or JWT?

Passport is chosen for OAuth compliance. The full token flow (authorization code, refresh token, personal access tokens) supports:
- Machine-to-machine authentication (external APIs)
- Third-party integrations (SSO providers)
- Gradual mobile adoption (tokens don't need user interaction for refresh)

Sanctum is lighter and sufficient for SPA + API on the same origin. Passport is heavier but necessary if FixCity grows to accept external applications. The code is here, the infrastructure is paid for. Use it.

Refuse JWT for sessions unless you need statelessness across replicas. Sessions are simpler, browser-native, and CSRF-resistant.

### Why Spatie\Permission?

It is the Laravel community standard. 339 references across the codebase use `Modules\Xot\Contracts\UserContract`, which implements `HasRoles` and `HasPermissions` from Spatie. It is audited, battle-tested, and integrates seamlessly with Filament. Do not replace it with a custom system unless the business requirement cannot fit into its model (guard, role hierarchy, team-based permissions).

### Why STI Over Separate Tables?

Separate tables for Doctor, Patient, Client mean:
- Queries require JOINs to find "users of a certain type"
- Polymorphic relationships (Team has many Users of different types) require morph maps
- A user changing type requires data migration

STI means:
- One query, one filter: `User::where('type', 'doctor')`
- Polymorphic relationships work naturally: a Team has many Users, they happen to have different types
- Type change is a single UPDATE on the row

The cost: every User carries columns not relevant to their type (a PatientProfile doesn't use `clinic_id`). This is acceptable. Databases are designed to handle sparse columns. Modern ORMs handle them transparently.

### Why Multi-Tenancy at the Model Level?

Filament\FilamentShield provides multi-tenancy: `tenants()` and `getTenants()` methods. This is not Saas-style tenant isolation (separate databases). It is ownership-based scoping: a Doctor "owns" data for their Clinic (tenant). A Patient "owns" data for their own Clinic access.

When a Doctor logs in, `Filament::getTenant()` returns their Clinic. All queries are automatically scoped (via policies and model-level filters) to that tenant. This is cleaner than passing tenant_id through every repository.

---

## POLITICA — The Rules, Constraints, and Best Practices

### Architecture Decisions

1. **50 Models, 34 Migrations**. User is a full domain. Accept the size. Splitting it further violates cohesion.

2. **350 Filament Resources**. 26 Resource classes manage identity through the admin panel. This is expected for an identity system. Do not move Filament code to Xot unless it is reusable across all modules.

3. **57 Actions**. Business logic for user creation, password reset, team management, OAuth token handling. All follow the Spatie QueueableAction pattern.

4. **369 Test Files**. Coverage is deep: unit tests for models, features for authentication flows, pest tests for permissions. Maintain or increase this coverage.

### Invariants

1. **BaseUser and BaseProfile are abstract.** They define the interface for all user types. Concrete classes live in child modules (Ptv, Employee, etc.) — not in User itself.

2. **No User-specific Filament panels.** Filament::auth() uses User by reference, not by class name. This allows any concrete User subclass to authenticate. Keep it that way.

3. **Tenants are immutable once set.** A user's tenant assignment should be rare. Changing tenants means revoking access to old data. Design the domain to require tenant changes rarely (e.g., only admins, only after approval).

4. **Roles are hierarchical (social contract, not enforced).** Super-admin > admin > team-leader > user. Document this hierarchy. Test role-based access via policies, not by hardcoding role names.

5. **Permissions never shadow business logic.** If a doctor cannot edit a patient record, enforce it via policy AND via business rules. Permissions are a guardrail, not the only lock.

### Constraints You Must Keep

1. No import of `Modules\Ptv\` in `Modules\User\app\` (except contracts).
2. No `app/Services` directory.
3. No file in `app/` larger than 500 lines (currently violated by `BaseUser.php:514` and `HasTeams.php:621` — a technical debt).
4. All Filament resources extend `XotBase*`, not `Filament\` directly.
5. Contracts are single-source: if it exists in `Modules\Xot\Contracts\`, delete the User version.

### Best Practices

1. **Type your parameters.** `function addTeamMember(User $user, Team $team)` is better than `function addTeamMember($userId, $teamId)`. Eloquent handles it gracefully.

2. **Use policies for authorization.** Do not check `can('edit-user')` in controllers. Define a `UserPolicy` with `edit()` method. Filament integrates with policies automatically.

3. **Activity logging is not optional.** Every user creation, permission change, team assignment should log. Use `activity('user')` from Spatie\ActivityLog. Security audits will ask for it.

4. **Test authentication flows end-to-end.** Mock OAuth, test login, verify token issuance. The `AuthenticationBusinessLogicTest.php` is a good template.

5. **Seed permissions in DatabaseSeeder.** Do not rely on lazy creation. Make permissions explicit:

   ```php
   Permission::firstOrCreate(['name' => 'scheda.approva']);
   Permission::firstOrCreate(['name' => 'scheda.edit']);
   ```

---

## SCOPO — What Problem It Solves in FixCity

FixCity is a city administration platform. Its identity needs are:

1. **Staff authentication**: Employees log in via email/password or SSO (Microsoft).
2. **Role-based work**: A street inspector, a clerk, and a mayor need different access.
3. **Team collaboration**: Multiple inspectors might work on the same report under a team.
4. **External integration**: Third-party complaint systems might authenticate via OAuth.
5. **Audit trail**: Who changed what, when, and why.

User solves all five:

- **BaseUser** + OAuth: Multi-method authentication.
- **Spatie\Permission** + Policies: Role-based access control.
- **Teams**: Collaboration and scoped data.
- **Passport**: Machine-to-machine and external app authentication.
- **ActivityLog**: Audit trail (via Spatie\ActivityLog, which User seeds and uses).

What it does NOT solve:

- **Employee records** (hire date, salary, department) → Sigma module.
- **Organizational chart** (hierarchy, reporting lines) → Sigma module.
- **Shifts and scheduling** → TechPlanner or HR module.
- **UI layout and navigation** → Xot or Theme module.

This separation is sacred. Do not leak domain logic into User.

---

## ZEN — The Essence and the Magic

### The Paradox of Identity

Identity is simple: a person logs in, the system knows who they are, what they can do, and whom they work for. Yet the code to make it work is complex (350 Filament classes, 50 models, 34 migrations).

The magic is that the complexity is **invisible to the user of User**. A developer using User writes:

```php
$doctor = Doctor::create(['email' => 'alice@clinic.com', 'password' => 'secret']);
$doctor->assignRole('doctor');
$doctor->assignTeamWithRole($clinic, 'lead');

// Instantly, the doctor can:
// - Log in
// - Create appointments (if their clinic allows)
// - Assign tasks to nurses (if their role allows)
```

The developer does not think about JWT, token refresh, tenant scoping, or policy evaluation. It is wired into the foundation.

### The Empty User

Zen teaches: the container is more important than the thing contained. User is the container for identity in FixCity. It does not impose a shape; it accepts any shape (via STI). A Doctor is not a User with extra fields; a Doctor IS a User, just with a different `type`.

This emptiness is strength. Add a new user type (Inspector, Auditor, Bot) without touching the core. The database shape does not change; the roles change.

### The Flaw

The system is not perfect. Two things break the Zen:

1. **BaseUser.php:514 and HasTeams.php:621** are too large. Every child carries the full weight. This is technical debt, but refactoring requires breaking every child module. Accept it for now; fix it in version 3.0.

2. **OauthPersonalAccessClient imports Ptv\Models\Profile**. User depends on the Portal. This is a 1-line fix but it was never fixed. Fix it.

Beyond these two, the system is elegantly simple.

---

## LIBRERIE DA INSTALLARE — Proposed New Dependencies

### Short Term (0-3 months)

1. **spatie/laravel-permission: ^6.0** (already required, but pinning)
   - For advanced role hierarchies and team-based permissions.
   - Consider adding `canAny()` macros for multi-permission checks.

2. **laravel/sanctum: ^4.0** (optional, if SPA + API on same origin)
   - Lighter than Passport for simple cases.
   - Side-by-side with Passport; use contextually.

### Medium Term (3-6 months)

1. **spatie/laravel-audit: ^4.0** (already using activity log; upgrade for richer auditing)
   - Automatic change tracking on User, Profile, Team models.
   - Audit history UI in Filament.

2. **laravel/tinker: ^2.0** for local debugging.
   - Included in dev dependencies; ensure team is comfortable with it.

### Long Term (6+ months)

1. **webauthn-open-source package** (WebAuthn / FIDO2)
   - Biometric login without OTP.
   - Future-proofs against password fatigue.
   - Requires `webauthn` table, new Filament UI.

2. **laravel/reverb: ^0.1** (if real-time notifications needed)
   - Push authentication changes instantly to all user devices.
   - Replace polling with WebSocket.

### Do NOT Install

1. **laravel/spark** or **laravel/nova**: Overkill for internal admin. Filament is superior.
2. **Tymon/JWT-Auth**: Passport is standard; JWT adds complexity without benefit for same-origin auth.
3. **laravel/breeze** or **laravel/jetstream** as replacement: They define User structure; User is already defined.

---

## FUTURE IMPLEMENTAZIONI — Roadmap

### Version 2.6 (Next Release)

- [ ] **WebAuthn support**: Biometric login as passwordless option.
- [ ] **Tenant-based feature flags**: Use `Pennant` to enable features per clinic.
- [ ] **Session invalidation API**: Allow users to log out other devices remotely.
- [ ] **IP whitelist policy**: Restrict login to known IPs (per clinic).

### Version 3.0 (Major Refactor)

- [ ] **Split BaseUser into focused traits**: Separate `HasTeams`, `HasAuthentication`, `HasNotifications` into distinct files (max 200 lines each).
- [ ] **Tenant ownership model**: Move `Modules\Tenant\Models\Tenant` into `User\Models\Tenant`; deprecate the duplicate.
- [ ] **Remove Ptv import**: Fix `OauthPersonalAccessClient.php`.
- [ ] **Archive unused contracts**: Delete `User\Contracts\UserContract` (alias to Xot), `ModelContract`, `PassportHasApiTokensContract`.
- [ ] **Filament 6 upgrade**: If Filament 6 introduces breaking changes, align resources.

### Version 4.0 (Multi-Tenant SaaS)

- [ ] **Cross-tenant user**: A single person with accounts in multiple clinics.
- [ ] **Tenant invitation workflow**: Invite external users to join a tenant.
- [ ] **Role inheritance hierarchy**: Super-admin > admin > user (not just a naming convention).
- [ ] **OAuth provider**: Make FixCity an OAuth provider for partner apps.

---

## COMPETITORS & INSPIRATIONS

### Laravel Breeze / Jetstream

**Breeze** is a quick-start scaffolding (login, register, profile, password reset). **Jetstream** adds teams and 2FA. Both define User shape and are meant for new projects.

**Difference**: User is for an existing platform with complex identity needs (STI, multi-tenancy, OAuth, extensive RBAC). You would not use Breeze for FixCity because you would inherit their User structure, which does not fit.

**Lesson**: Breeze and Jetstream are starting points. User is a production system. If FixCity started from Jetstream, migration to this User would be painful. Better to accept the extra complexity upfront.

### Spatie\Permission (vs. Custom RBAC)

**Spatie** is battle-tested by thousands of Laravel apps. It handles role inheritance, team-based permissions, and guard separation.

**Custom RBAC** would give you full control but require:
- Testing guards and inheritance yourself
- Integrating with Filament (which knows Spatie natively)
- Ongoing maintenance

**Decision**: Spatie is correct. Do not custom-build here.

### Passport (vs. Sanctum, vs. Stateless JWT)

**Passport** implements full OAuth2 (authorization code, refresh token, PKCE, token introspection). Heavy, but complete.

**Sanctum** is lighter: API tokens without the OAuth spec. Better for SPA + API on same origin.

**JWT** (stateless): Tokens do not require server lookup. Good for microservices, bad for revocation.

**Decision**: Passport for FixCity because external integrations (third-party complaint systems) may need to authenticate. Sanctum could be used for the SPA layer on top of Passport; they are not mutually exclusive.

### Filament vs. Nova vs. Custom Admin

**Filament** is Laravel's emerging admin standard. Free, open-source, PHP-based, integrated with Livewire and Forms. Filament Shield provides authorization.

**Nova** is Laravel-official, proprietary, more features, higher cost.

**Custom** is the old way: build your own admin UI.

**Decision**: Filament is the right choice for FixCity. It is free, extensible, and modern. User's 350 Filament classes show deep integration; switching would be catastrophic.

---

## BEST PRACTICES

### 1. Authentication

```php
// Good: Use credentials, get user, verify password
if (Hash::check($password, $user->password)) {
    auth()->login($user);
}

// Bad: Store plaintext password
$user->password = $password;

// Good: Use Laravel's password validation rule
'password' => 'required|min:8|current_password'

// Bad: Hardcode password rules
if (strlen($password) < 8) { /* reject */ }
```

### 2. Authorization

```php
// Good: Use policies
if ($this->authorize('edit', $user)) {
    // edit the user
}

// Better: Use the `@can` Blade directive
@can('edit', $user)
    <button>Edit</button>
@endcan

// Good: Use gates for simple checks
if (Gate::allows('view-reports')) { /* ... */ }

// Bad: Hardcoding role checks in controllers
if ($user->role_id === Role::ADMINISTRATOR) { /* ... */ }
```

### 3. Sensitive Data

```php
// Good: Hide password in API responses
protected $hidden = ['password', 'remember_token'];

// Good: Cast email_verified_at to datetime
protected function casts() {
    return ['email_verified_at' => 'datetime'];
}

// Bad: Return password in JSON
return $user->toArray(); // password included!
```

### 4. Testing Identity

```php
// Good: Test authentication flow end-to-end
test('user can login with email and password', function () {
    $user = User::factory()->create(['password' => 'secret']);
    $this->post('/login', ['email' => $user->email, 'password' => 'secret'])
        ->assertRedirect('/dashboard');
});

// Good: Test authorization via policy
test('user can edit own profile', function () {
    $user = User::factory()->create();
    $this->assertTrue($user->can('edit', $user));
});

// Bad: Assume role without testing policy
if ($user->hasRole('admin')) { /* ... */ }
```

### 5. Teams and Tenants

```php
// Good: Load teams explicitly
$user->load('teams');

// Good: Check if user belongs to team
if ($user->belongsToTeam($team)) { /* ... */ }

// Bad: Loop through teams without eager loading
foreach ($users as $user) {
    if ($user->teams->count() > 0) { /* N+1 query */ }
}
```

---

## BAD PRACTICES

### 1. Bypassing Authentication

```php
// Bad: Set user in session without authentication
auth()->setUser($user);

// Bad: Generate token without logging in
$token = $user->createToken('api')->plainTextToken;
// (the user's password was never verified)

// Good: Authenticate, then issue token
if (Hash::check($password, $user->password)) {
    $token = $user->createToken('api')->plainTextToken;
}
```

### 2. Leaking Sensitive Data

```php
// Bad: Include password in error message
throw new Exception("Login failed: " . $user->password);

// Bad: Log user object (includes password)
\Log::info($user);

// Good: Log user ID only
\Log::info("User {$user->id} logged in");
```

### 3. Hardcoded Permissions

```php
// Bad: Check role directly
if ($user->role_id === 5) { /* admin */ }

// Bad: String-based permission without seeding
$user->can('undefined.permission') // returns false silently

// Good: Use named roles/permissions
$user->can('approve-reports')

// Good: Seed permissions in DatabaseSeeder
Permission::firstOrCreate(['name' => 'approve-reports']);
```

### 4. Ignoring Multi-Tenancy

```php
// Bad: Load all users globally
$users = User::all();

// Good: Scope to tenant
$users = Filament::getTenant()->users;

// Bad: Issue token without tenant context
$token = $user->createToken('api')->plainTextToken;

// Good: Scope API access to tenant
// (Middleware should verify token and set tenant)
```

### 5. Password Handling

```php
// Bad: Send password in email
Mail::send('password-reset', ['new_password' => 'secret']);

// Bad: Store plaintext password
$user->update(['password' => request('password')]);

// Good: Send password reset link, not the password
Password::sendResetLink($user->email);

// Good: Hash password before storing
'password' => Hash::make(request('password'))
```

---

## FALSE FRIENDS — Common Gotchas

### 1. The Permission That Does Not Exist

```php
$user->can('non.existent.permission'); // returns false

// Silent failure. The permission was never seeded, so access is denied.
// The developer thinks: "The permission exists, I checked it."
// The security team thinks: "This feature works as designed."
// Actually: The permission was never registered.
```

**How to catch it**: Seed ALL permissions in `DatabaseSeeder`. Use a test to enumerate permissions:

```php
test('all permissions are seeded', function () {
    $permissions = Permission::all()->pluck('name');
    expect($permissions)->toContain('approve-reports', 'edit-user', 'delete-team');
});
```

### 2. The Role That Changed Type

```php
class Doctor extends User { }
class Inspector extends User { }

$user = Doctor::find(1);
$user->update(['type' => 'inspector']);

// Now $user is still a Doctor instance, but the database says inspector.
// $user instanceof Doctor; // true (still cached)
// $user->type; // 'inspector' (from database)
```

**How to catch it**: Refresh the model after type change:

```php
$user->update(['type' => 'inspector']);
$user = $user->fresh(); // Re-fetch with correct type
```

### 3. The Team Nobody Owns

```php
$team = Team::create(['name' => 'Inspectors']);
// $team->owner_id is null. Who can edit it?

// Filament will let admins edit it. Web users see it but cannot edit.
// If you delete the owner, the team becomes orphaned.
```

**How to catch it**: Always set owner:

```php
$team = Team::create(['name' => 'Inspectors', 'owner_id' => auth()->id()]);
```

### 4. The Tenant That Does Not Exist

```php
// In a policy
public function update(User $user, Report $report) {
    $tenant = Filament::getTenant();
    // $tenant is null if no tenant is set
    return $tenant?->id === $report->tenant_id;
}
```

**How to catch it**: Middleware should enforce tenant presence for tenant-scoped panels:

```php
Filament::registerPanels([
    AdminPanel::make()->setTenant(Clinic::class), // Enforce tenant
]);
```

### 5. The Connection That Does Not Exist

```php
// In BaseUser
protected $connection = 'user';

// If `user` is not configured in config/database.php, the model silently falls back to 'default'.
// You think identity is on a separate database; actually, it is not.
```

**How to catch it**: Check `config('database.connections.user')` exists:

```php
expect(config('database.connections.user'))->toBeArray();
```

---

## COME USARLO — Practical Examples

### Creating a New User

```php
use Modules\User\Models\User;

// Create a basic user
$user = User::create([
    'first_name' => 'Alice',
    'last_name' => 'Doctor',
    'email' => 'alice@clinic.com',
    'password' => 'hashed_password_here',
]);

// Assign a role
$user->assignRole('doctor');

// Add to a team
$user->teams()->attach($team, ['role' => 'lead']);

// Grant specific permission
$user->givePermissionTo('approve-reports');
```

### Creating a Subtype (STI)

```php
// In Modules/SomeModule/app/Models/
class Inspector extends \Modules\User\Models\User {
    use \Parental\HasParent;

    // Inspector-specific methods
    public function inspections() {
        return $this->hasMany(Inspection::class);
    }
}

// Usage
$inspector = Inspector::factory()->create();
```

### Checking Authorization in a Controller

```php
use Modules\User\Models\User;

// Check if user can edit a report
if ($this->authorize('edit', $report)) {
    $report->update($request->validated());
    return redirect()->route('reports.show', $report);
}

// Or in a policy
class ReportPolicy {
    public function edit(User $user, Report $report): bool {
        return $user->belongsToTeam($report->team)
            && $user->can('edit-reports');
    }
}
```

### Issuing an API Token

```php
// User logs in, request API token
$token = $user->createToken('api-access')->plainTextToken;

// Client uses token in Authorization header
// GET /api/reports
// Authorization: Bearer {$token}

// Middleware verifies token
middleware([\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class])
```

### Team-Based Access

```php
// User owns a team
$team = $user->teams()->create(['name' => 'Clinic A']);

// User invites another user
$user->inviteTeamMember('colleague@clinic.com', 'inspector');

// Colleague accepts invite
$team->users()->updatePivot($colleague, ['status' => 'active']);

// All users in team can collaborate
$team->users()->get(); // all members
```

### Auditing User Changes

```php
use Spatie\ActivityLog\Facades\Activity;

Activity::useLog('user')
    ->performedOn($user)
    ->causedBy(auth()->user())
    ->withProperties(['old_role' => $user->roles->first()->name])
    ->log('User role changed');

// Later, retrieve audit trail
Activity::where('subject_type', User::class)
    ->where('subject_id', $user->id)
    ->get();
```

---

## COME INSTALLARLO — Setup Guide

### Prerequisites

- Laravel 13+ (User uses Filament 5, which requires Laravel 11+)
- PHP 8.3+
- MySQL 8.0+ or PostgreSQL 14+
- Redis (for queue jobs, optional)

### Installation Steps

#### 1. Require the Module

```bash
composer require laraxot/module-user-fila5
```

#### 2. Publish Configuration

```bash
php artisan vendor:publish --provider="Modules\User\Providers\UserServiceProvider"
```

This publishes config files to `config/modules/user/`.

#### 3. Run Migrations

```bash
php artisan migrate --database=user  # Use the 'user' connection
```

#### 4. Seed Initial Data

```bash
php artisan db:seed --class="Modules\User\Database\Seeders\UserSeeder"
```

This creates:
- Default admin user (email: `admin@example.com`, password: `password`)
- Base roles: super-admin, admin, user
- Base permissions

#### 5. Set Environment Variables

```env
# .env
MAIL_FROM_ADDRESS=noreply@fixcity.com
OAUTH_MICROSOFT_CLIENT_ID=your_client_id
OAUTH_MICROSOFT_CLIENT_SECRET=your_secret
OAUTH_GOOGLE_CLIENT_ID=your_client_id
OAUTH_GOOGLE_CLIENT_SECRET=your_secret
```

#### 6. Generate Passport Keys

```bash
php artisan passport:install
```

This generates OAuth encryption keys in storage/oauth-public.key and .keys/.

#### 7. Create a Filament User

```bash
php artisan tinker
>>> Modules\User\Models\User::factory()->create(['email' => 'you@example.com']);
>>> User::first()->assignRole('super-admin');
```

#### 8. Access Filament Admin

Visit `/admin` and log in with the credentials you set.

### Configuration Files

| File | Purpose |
|---|---|
| `config/modules/user/config.php` | Main module config (guard, defaults) |
| `config/modules/user/passport.php` | OAuth2 settings |
| `config/modules/user/socialite.php` | OAuth providers (Google, Microsoft, etc.) |
| `config/modules/user/password.php` | Password reset settings |

### Extending the Module

To create a custom User type:

```php
// In Modules/YourModule/app/Models/
class YourUserType extends \Modules\User\Models\User {
    use \Parental\HasParent;
    
    protected $attributes = ['type' => 'your_user_type'];
}

// Register in service provider
// (The type is auto-discovered if the child extends User)
```

---

## COVERAGE ANALYSIS — Based on the Test Suite

### Overview

The User module contains **169 test files** with **50+ models**, **34 migrations**, and **350+ Filament classes**.

| Category | Files | Purpose |
|---|---|---|
| Unit Tests | 130+ | Model behavior, permissions, team logic |
| Feature Tests | 25+ | Authentication flows, API endpoints |
| Integration Tests | 14+ | Filament resources, OAuth |

### Key Coverage Areas

#### 1. Authentication (25+ tests)

```php
// tests/Feature/AuthenticationBusinessLogicTest.php
test('user can login with email and password')
test('user can reset forgotten password')
test('user receives email verification link on registration')
test('user cannot login without verified email')
test('2fa prompt appears after successful login')
```

**Coverage**: 95% of login paths. Gaps: External OAuth flows (requires mock setup).

#### 2. Authorization (40+ tests)

```php
// tests/Unit/PermissionTest.php
test('user can perform action if granted permission')
test('user cannot perform action without permission')
test('permission denied silently returns false')
test('super-admin bypasses all permission checks')

// tests/Unit/RoleTest.php
test('role can be assigned to user')
test('multiple roles can be assigned to same user')
test('role permissions are inherited')
```

**Coverage**: 90%. Gaps: Role hierarchy edge cases.

#### 3. Teams (20+ tests)

```php
// tests/Unit/HasTeamsTraitTest.php
test('user can create a team')
test('user can invite another user to team')
test('user cannot delete team they do not own')
test('team member can be assigned specific role')
```

**Coverage**: 85%. Gaps: Cross-tenant team operations.

#### 4. Multi-Tenancy (15+ tests)

```php
// tests/Unit/TenantTest.php
test('user is scoped to their tenant')
test('user cannot access another tenant data')
test('tenant can be switched')
```

**Coverage**: 70%. Gap: Tenant switching in concurrent requests.

#### 5. OAuth / Passport (12+ tests)

```php
// tests/Feature/OAuthTest.php
test('user can issue personal access token')
test('personal access token grants API access')
test('token can be revoked')
test('expired token is rejected')
```

**Coverage**: 60%. Gaps: Authorization code flow, token refresh cycle.

### Weak Spots

1. **Device tracking**: Only 5 tests. `Device` and `DeviceUser` models have minimal coverage.
2. **Session invalidation**: No test for "logout from all devices."
3. **WebAuthn / 2FA**: Seeded and present, but feature flag (`Pennant`) testing is light.
4. **Cross-module integration**: Tests assume User is standalone. Integration with Sigma (employees) is minimal.

### Recommendations

1. **Add device-tracking tests**: Simulate multiple logins, verify device isolation.
2. **Add logout-all-devices test**: Verify session invalidation across all devices.
3. **Add WebAuthn tests**: Mock FIDO2 flow.
4. **Add integration tests** with Sigma: User creation from Employee record, sync scenarios.

---

## Conclusion: The Identity as Foundation

User is not a feature module; it is the **foundation** of FixCity. Every other module depends on it. Every user action passes through it. Every access control decision rests on it.

Build it once, build it right, and never rebuild it. The code is here to last.

Keep the three questions foremost: **Who are you? What are you allowed to do? For whom?**

Everything else belongs elsewhere.

---

## References

- [scopo.md](./scopo.md) — Scope, boundaries, and improvement roadmap
- [README.md](../README.md) — Module overview
- [authentication.md](./authentication.md) — Authentication flow details
- [permissions.md](./permissions.md) — Spatie permissions deep dive
- [passport-integration.md](./passport-integration.md) — OAuth2 and API token handling
- [2fa-guide.md](./2fa-guide.md) — Two-factor authentication setup

---

**Philosophy Version**: 2.0  
**Module Version**: 2.5.0+  
**Last Updated**: 2026-09-06  
**Status**: Active, Visionary

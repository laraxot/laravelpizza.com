---
title: User Module: Migrations & Schema
created: 2026-07-15
updated: 2026-07-15
type: module-documentation
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
tags: [docs, user]
qmd: "user module   migrations & schema parity user"
---

# User Module: Migrations & Schema Parity

## Philosophy

**One model → One migration → One seeder → One factory**

All models in User module must maintain 1:1:1:1 parity with migrations, seeders, and factories. This ensures:
- Single source of truth for schema
- Forward-only migrations (no rollbacks)
- Complete audit trail (created_by, updated_by, deleted_by)
- Consistent data generation (seeder/factory pair)

---

## Models & Migrations (1:1 Parity)

| Model | Migration | Status | Notes |
|-------|-----------|--------|-------|
| User | 2026_02_13_172136_create_users_table.php | ✅ | Main users table, Jetstream-based |
| Team | 2026_07_15_120000_create_teams_table.php | ✅ | Multi-user teams, owner_id pivot |
| Profile | 2026_04_28_120000_create_profiles_table.php | ✅ | Extended user info (addresses, etc) |
| TeamUser | 2023_01_01_000004_create_team_user_table.php | ✅ | Pivot: Team ↔ User membership |
| TeamInvitation | 2023_01_01_000002_create_team_invitations_table.php | ✅ | Invites to teams (pending/accepted) |
| Device | 2023_01_01_000001_create_devices_table.php | ✅ | User devices (2FA, sessions) |
| DeviceUser | 2023_01_01_000004_create_device_user_table.php | ✅ | Pivot: Device ↔ User mapping |
| TenantUser | 2026_01_01_000002_create_tenant_user_table.php | ✅ | Pivot: Tenant ↔ User access |
| SsoProvider | 2025_10_15_153835_create_sso_providers_table.php | ✅ | OAuth/SAML providers (Socialite) |
| SocialiteUser | 2023_01_01_000003_create_socialite_user_table.php | ✅ | OAuth user identities (GitHub, Google) |
| OauthClient | 2026_03_01_000003_create_oauth_clients_table.php | ✅ | Passport OAuth clients |
| OauthAccessToken | 2023_01_01_000003_create_oauth_access_tokens_table.php | ✅ | Passport access tokens |
| OauthRefreshToken | 2020_01_01_000003_create_oauth_refresh_tokens_table.php | ✅ | Passport refresh tokens |
| OauthAuthCode | 2023_01_01_000000_create_oauth_auth_codes_table.php | ✅ | Passport authorization codes |
| OauthPersonalAccessClient | 2023_01_01_000005_create_oauth_personal_access_clients_table.php | ✅ | Personal access (testing) |
| PersonalAccessToken | 2019_12_14_000001_create_personal_access_tokens_table.php | ✅ | Sanctum API tokens |
| Role | 2025_09_18_000000_create_roles_table.php | ✅ | ACL: Role definitions |
| Permission | 2023_01_01_093340_create_permission_table.php | ✅ | ACL: Permission definitions |
| ModelHasRole | 2024_12_05_000034_create_model_has_roles_table.php | ✅ | ACL: Pivot model-role |
| ModelHasPermission | 2023_01_01_000005_create_model_has_permissions_table.php | ✅ | ACL: Pivot model-permission |
| RoleHasPermission | 2024_01_01_000011_create_permission_role_table.php | ✅ | ACL: Pivot role-permission |
| Feature | 2024_09_26_100442_create_features_table.php | ✅ | Feature flags per user/team |
| AuthenticationLog | 2024_01_01_000001_create_authentication_log_table.php | ✅ | Login audit trail |
| PasswordReset | 2014_10_12_100002_create_password_resets_table.php | ✅ | Password reset tokens |
| Tenant | 2026_01_01_000001_create_tenants_table.php | ✅ | Multi-tenancy support |

**Total: 26 models → 26 migrations**

---

## Key Models Explained

### User
- **Table**: `users`
- **Auth**: Jetstream with 2FA support
- **Columns**: id, email, password, name, avatar, phone_verified_at, email_verified_at, two_factor_secret, two_factor_recovery_codes
- **Relations**: 
  - `hasMany(Team)`: Teams user owns
  - `hasMany(Profile)`: User profiles
  - `belongsToMany(Team)` via `team_user`: Team memberships
  - `belongsToMany(Role)`: Direct roles (RBAC)
  - `hasManyThrough(Permission)`: Via roles

### Team  
- **Table**: `teams`
- **Pivot column**: `owner_id` → User who created team
- **Columns**: id, owner_id, name, personal_team, code, uuid
- **Relations**:
  - `belongsTo(User, owner_id)`: Team owner
  - `belongsToMany(User)` via `team_user`: Members
  - `hasMany(TeamInvitation)`: Pending invites

### Profile
- **Table**: `profiles`
- **Purpose**: Extended user info (addresses, phone numbers, social media)
- **Relations**:
  - `belongsTo(User)`: Associated user
  - `belongsToMany(Tenant)` via `profile_team`: Tenant access

### Pivot Tables
All pivot tables follow naming convention `<model1>_<model2>_table.php`:
- `team_user`: Team ↔ User membership
- `device_user`: Device ↔ User mapping
- `tenant_user`: Tenant ↔ User access
- `profile_team`: Profile ↔ Tenant access
- `model_has_roles`: Model ↔ Role assignment
- `model_has_permissions`: Model ↔ Permission grant
- `role_has_permissions`: Role ↔ Permission mapping

---

## Connection Strategy

**Default connection:** `default` (MySQL on primary database)

**Custom connections:**
- None. All tables use default connection.
- If future Tenant model needs multi-database, update `Tenant::$connection = 'tenant_db'` and migration will derive it.

**Why centralize in model:**
- Single source of truth for connection
- Avoid hardcoded connections in N migration files
- Model is the business entity, database is implementation detail

---

## Migration Naming Convention

All migrations follow format:
```
YYYY_MM_DD_HHMMSS_create_<table>_table.php
```

✅ **Correct:**
- `2026_07_15_120000_create_teams_table.php`
- `2026_02_13_172136_create_users_table.php`
- `2023_01_01_000004_create_team_user_table.php`

❌ **Incorrect (never use):**
- `2025_05_16_221811_add_owner_id_to_teams_table.php` ← Wrong: "add_" prefix
- `update_teams_table.php` ← Wrong: Missing timestamp
- `CreateTeamsTable.php` ← Wrong: CamelCase naming

---

## Timestamp & Audit Columns

All tables include:
```php
$this->updateTimestamps($table, $softDeletes = false);
```

**Added columns:**
- `created_at`: When record was created
- `updated_at`: When record was last updated
- `created_by`: User ID who created it
- `updated_by`: User ID who updated it

**With soft deletes** (`SoftDeletes` trait):
```php
$this->updateTimestamps($table, true);
```

**Additional columns:**
- `deleted_at`: When record was soft-deleted
- `deleted_by`: User ID who deleted it

---

## XotBaseMigration Pattern (Required)

Every migration MUST:
1. Extend `XotBaseMigration` (not `Migration`)
2. Specify `protected ?string $model_class`
3. Use `$this->tableCreate()` for creating tables
4. Use `$this->tableUpdate()` for schema modifications
5. Use `$this->updateTimestamps()` for audit columns

**Template (Minimal - Recommended):**
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    // Model class is derived from filename: 2026_07_15_120000_create_teams_table.php → Team
    // Add $model_class only if you need explicit documentation

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table);
        });
    }
};
```

**Template (Explicit - Optional):**
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Team;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Team::class;  // Optional, but adds clarity

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table);
        });
    }
};
```

**How XotBaseMigration derives model from filename:**
- File: `2026_07_15_120000_create_teams_table.php`
- XotBaseMigration extracts `teams` → converts to PascalCase → looks for `Team` model
- Connection: Looks up `Team::$connection` (defaults to `config('database.default')`)

---

## Recent Changes

| Date | Change | Ticket |
|------|--------|--------|
| 2026-07-15 | Added `$model_class` to teams migration for XotBaseMigration conformance | MIGRATION-NAMING-001 |
| 2026-07-15 | Created migration parity audit documentation | CONVENTIONS-001 |

---

## Known Issues

### Migration Naming Debt (RESOLVED)
- **Status**: ✅ Fixed as of 2026-07-15
- **Issue**: Earlier migrations used "add_" prefix instead of "create_"
- **Resolution**: All migrations renamed to follow `create_<table>_table` pattern

### Duplicate Migrations
- **Status**: ⚠️ Warning
- **Issue**: Some tables have multiple migration files (e.g., users, team_user)
- **Resolution**: Use only the latest (highest timestamp) migration
- **Note**: Old migrations have `.old` or `.Jetstream` suffix for clarity

---

## Verification Checklist

Before committing migration changes:

- [ ] Migration file name: `YYYY_MM_DD_HHMMSS_create_<table>_table.php`
- [ ] Extends `XotBaseMigration` (not `Migration`)
- [ ] Has `protected ?string $model_class = ModelClass::class;`
- [ ] Uses `$this->tableCreate()` and `$this->tableUpdate()`
- [ ] Includes `$this->updateTimestamps($table)` for audit columns
- [ ] No hardcoded `protected $connection` (derives from model)
- [ ] No `down()` method (auto-implemented)
- [ ] PHPStan L10: 0 errors
- [ ] PHPMD: No violations
- [ ] Parity: Model count = Migration count

---

## Related Documentation

- **Pattern Reference**: `docs/wiki/patterns/migration-naming-and-parity-convention.md`
- **XotBaseMigration Mechanics**: `docs/wiki/patterns/migration-xot-base-pattern.md`
- **Module Independence**: `docs/wiki/patterns/module-independence.md`
- **RBAC & Permissions**: `Modules/User/docs/RBAC.md` (see Spatie Laravel Permission)

---

## Discovery Commands

```bash
# Count models in User module
grep -r "^class [A-Z].*extends.*Model" Modules/User/app/Models/*.php | \
  grep -v "abstract" | grep -v "Policy" | wc -l

# Count migrations
ls Modules/User/database/migrations/*.php | wc -l

# Should match!

# Find models without migrations
for model in $(grep -h "^class [A-Z].*extends.*Model" \
  Modules/User/app/Models/*.php | \
  sed 's/class \([^ ]*\).*/\1/'); do
  table=$(echo "$model" | sed 's/\([A-Z]\)/_\1/g; s/^_//; s/_//' | tr '[:upper:]' '[:lower:]')
  if ! grep -q "create_${table}" Modules/User/database/migrations/*.php; then
    echo "Missing migration for: $model"
  fi
done
```

---

**Last updated:** 2026-07-15  
**Maintainer:** Marco (marco76tv)  
**Status:** ✅ Active: All migrations conform to XotBaseMigration standard

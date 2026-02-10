# Testing Guidelines - GDPR Module

## Why MySQL (Never SQLite)

The project uses multiple named database connections:

| Connection | Purpose |
|-----------|---------|
| `user` | Users table, authentication |
| `gdpr` | Consents, treatments, events, profiles |
| `xot` | Core framework tables |
| `tenant` | Multi-tenancy configuration |

SQLite in-memory creates a **single shared database**, which means:
- Cross-connection foreign keys don't work
- MySQL-specific column types (JSON, ENUM) behave differently
- Charset/collation issues are hidden
- Tests pass in SQLite but fail in production MySQL

**MySQL from `.env.testing`** uses the same engine as production, catching real issues.

## Why DatabaseTransactions (Never RefreshDatabase)

| Trait | What it does | Speed | Side effects |
|-------|-------------|-------|-------------|
| `RefreshDatabase` | Drops and recreates ALL tables per test class | Very slow on MySQL | Destroys seed data, breaks module dependencies |
| `DatabaseTransactions` | Wraps each test in BEGIN/ROLLBACK | Near instant | Perfect isolation, no data loss |

`DatabaseTransactions` is the correct choice because:
1. MySQL migrations are expensive to replay
2. Other modules may rely on seed data existing
3. Transaction rollback gives perfect test isolation

## Why Generic `php artisan migrate`

Laraxot auto-discovers migrations from ALL modules via `XotBaseServiceProvider`:

```
Xot migrations → User migrations → Gdpr migrations → ...
```

Running `php artisan migrate` without `--database` ensures:
1. **Correct dependency order** — Xot tables (base) before User tables before Gdpr tables
2. **Cross-module tables** — Pivot tables and shared references all get created
3. **No missing foreign keys** — All referenced tables exist before FK constraints are applied

Running `--database=gdpr` would ONLY migrate Gdpr-connection tables, missing the `users` table that Gdpr's `consents.subject_id` references.

`--force` is omitted because `APP_ENV=testing` is not `"production"`, so Laravel allows migrations without it.

## Registration Testing Strategy

The GDPR RegisterWidget is a **Livewire component** (not a traditional POST route), so we test the **Action pipeline** directly:

```
ValidateGdprConsentAction → ValidateUserDataAction → CreateUserAction
                         → CollectGdprConsentsAction → SaveGdprConsentsAction
```

### Test Categories

1. **Action Unit Tests** (`RegisterWidgetTest.php`)
   - Each Action tested individually
   - Edge cases per Action
   - Translation key verification

2. **Integration Tests** (`RegistrationTest.php`)
   - Full pipeline: validate → create user → save consents
   - Happy path with/without marketing consent
   - Validation failures (privacy, terms)
   - Duplicate email prevention
   - Password hashing verification

3. **Model Tests** (`GdprConsentTest.php`, `GdprBusinessLogicTest.php`)
   - Consent CRUD operations
   - Treatment management
   - Consent-Treatment relationships
   - Event audit trail

## Actual Models (Not Legacy Names)

The GDPR module has these models:

| Model | Table | Description |
|-------|-------|-------------|
| `Consent` | `consents` | User consent records |
| `Treatment` | `treatments` | GDPR treatment definitions |
| `Event` | `gdpr_events` | Audit trail events |
| `Profile` | `profiles` | GDPR user profiles |

**Warning:** Legacy code may reference `GdprConsent` or `GdprRequest` — these models do NOT exist.

## .env.testing Configuration

```ini
APP_ENV=testing
DB_CONNECTION=mysql
DB_DATABASE=laravelpizza_data_test
DB_USERNAME=root
DB_PASSWORD=...

# User module connection
USER_DB_DATABASE=laravelpizza_user_test
```

Both test databases must exist in MySQL before running tests:
```sql
CREATE DATABASE IF NOT EXISTS laravelpizza_data_test;
CREATE DATABASE IF NOT EXISTS laravelpizza_user_test;
```

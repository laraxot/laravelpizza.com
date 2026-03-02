# Test Infrastructure Fix - 2026-01-09

## Problem Identified

### Configuration Conflict

**phpunit.xml (lines 38-39):**
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

**.env.testing (lines 23-96):**
```env
DB_CONNECTION=mysql
DB_DATABASE=laravelpizza_data_test

# Module-specific databases
USER_DB_DATABASE=laravelpizza_user_test
CMS_DB_DATABASE=laravelpizza_cms_test
# ... etc
```

**Result:** phpunit.xml forces SQLite in-memory, overriding .env.testing MySQL config!

### Recent Changes

Git history shows: **RefreshDatabase trait removed from all tests** (commit: `refactor(Tenant,User): rimosso RefreshDatabase da tutti i test`)

This means tests expect:
- Persistent databases (MySQL)
- Pre-migrated tables
- NO automatic migration on each test run

### Current State

**Test databases exist:**
```bash
laravelpizza_cms_test       ✅
laravelpizza_data_test      ✅
laravelpizza_geo_test       ✅
laravelpizza_job_test       ✅
laravelpizza_lang_test      ✅
laravelpizza_media_test     ✅
laravelpizza_notify_test    ✅
laravelpizza_tenant_test    ✅
laravelpizza_user_test      ✅
laravelpizza_xot_test       ✅
```

**But tables are empty or incomplete!**

Example - `laravelpizza_user_test`:
```sql
SHOW TABLES;
-- Only shows: password_resets
-- Missing: users, roles, permissions, tenants, profiles, etc.
```

---

## Solution

### Step 1: Fix phpunit.xml

**Remove SQLite override to allow .env.testing MySQL config:**

```xml
<!-- REMOVE these lines from phpunit.xml -->
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

This allows tests to use the MySQL databases configured in .env.testing.

### Step 2: Run Migrations on Test Databases

**Option A: Migrate all at once**
```bash
php artisan migrate --env=testing --database=user --force
php artisan migrate --env=testing --database=cms --force
php artisan migrate --env=testing --database=geo --force
# ... for each module database
```

**Option B: Create setup script**
```bash
#!/bin/bash
# File: bashscripts/setup-test-databases.sh

for DB in user cms geo job lang media notify tenant xot; do
    echo "Migrating $DB test database..."
    php artisan migrate --env=testing --database=$DB --force
done
```

### Step 3: Fix APP_KEY in .env.testing

**Already fixed:**
```env
APP_KEY=base64:c7UtEG+EMHVlFlJchk13Suv2Vcv0tmLxF1S7/bmCork=
```

---

## Implementation Strategy

### Priority Fix Order

1. **Fix phpunit.xml** - Remove SQLite override
2. **Run migrations** - Populate test databases
3. **Run tests** - Verify infrastructure works
4. **Fix individual tests** - Address test-specific issues

### Testing Approach

**The project uses persistent MySQL test databases WITHOUT RefreshDatabase**

This means:
- ✅ Faster test runs (no migration on each run)
- ✅ Test data persists between runs
- ⚠️ Tests must clean up after themselves
- ⚠️ Tests must handle existing data
- ⚠️ Need initial migration setup

**Alternative considered but rejected:**
- ❌ SQLite in-memory + RefreshDatabase (too slow, recent commits removed RefreshDatabase)
- ❌ Re-add RefreshDatabase everywhere (contradicts recent architectural decision)

---

## Next Steps

1. ✅ Document issue (THIS FILE)
2. ⏳ Fix phpunit.xml
3. ⏳ Run migrations on all test databases
4. ⏳ Verify basic test pass
5. ⏳ Fix remaining test-specific issues

---

## Notes

- Test databases are separate per module (good for isolation)
- Configuration is complex but intentional
- Recent refactor removed RefreshDatabase for performance
- Must respect this architectural decision

---

## Related Files

- `laravel/.env.testing` - Test environment config
- `laravel/phpunit.xml` - PHPUnit config (needs fix)
- `laravel/docs/test-failures-analysis-2026-01-09.md` - Detailed failure analysis

# 5. Database & Models

### Database Config (Laravel 12 Standard)
- Base config: `config/database.php`
- Tenant config: `config/local/{tenant}/database.php`
- **NEVER add module connections to tenant configs** - TenantServiceProvider creates them automatically!
- Module connections added dynamically via `TenantServiceProvider::registerDB()`

### ⚠️ CRITICAL RULE: Never Add Database Connections to Tenant Configs!

**This is a GRAVE error:**
```php
// ❌ NEVER DO THIS in config/local/laravelpizza/database.php!
'gdpr' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    // ...
],
```

**CORRECT:**
- Module connections (gdpr, notify, geo, etc.) → `config/database.php` (main)
- Tenant-specific configs → `config/local/{tenant}/database.php` should ONLY have:
  - `mysql` (default)
  - `user` (tenant users)
  - `sqlite` (optional)
- TenantServiceProvider dynamically adds module connections based on .env variables (DB_DATABASE_GDPR, etc.)

**WHY:**
- TenantServiceProvider reads .env and registers connections automatically
- Adding manually to tenant configs causes conflicts and breaks the system
- Only the main config/database.php should have module connections

### Testing Database Config - CRITICAL RULE
**.env.testing must be a CARBON COPY of .env with only "_test" added to database names!**

**STRICT RULE - NEVER modify these variables:**
- APP_URL - MUST be IDENTICAL to .env (e.g., if .env has `http://laravelpizza.local`, .env.testing MUST have `http://laravelpizza.local`)
- APP_NAME, APP_KEY, APP_ENV, APP_DEBUG - MUST be IDENTICAL to .env
- All other variables EXCEPT database names - MUST be IDENTICAL to .env

**WRONG APPROACH (NEVER DO THIS):**
```bash
# ❌ WRONG - Changing APP_URL breaks the app!
APP_URL=http://127.0.0.1  # WRONG! Must match .env

# ❌ WRONG - Inventing new variables that don't exist in .env
NOTIFY_DB_DATABASE=laravelpizza_data_test
NOTIFY_DB_USERNAME=marco
NOTIFY_DB_PASSWORD=marco

GEO_DB_DATABASE=laravelpizza_data_test
GEO_DB_USERNAME=marco
GEO_DB_PASSWORD=marco

# ... etc for all modules
```

**CORRECT APPROACH:**
```bash
# ✅ CORRECT - Copy .env exactly, only change database names
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelpizza_data_test  # ← Only add _test here
DB_USERNAME=marco
DB_PASSWORD=marco

# If DB_DATABASE_USER exists in .env, also add _test
DB_DATABASE_USER=laravelpizza_user_test  # ← Only if it exists in .env
DB_USERNAME_USER=marco
DB_PASSWORD_USER=marco
```

**WHY:** The `CreatesApplication` trait automatically maps all module connections (notify, geo, media, job, activity, cms, gdpr, lang, meetup, seo, tenant, xot) to the test MySQL connection. DO NOT duplicate this logic in .env.testing or TestCase!

**AUTOMATIC GENERATION SCRIPT:** Use the provided script to generate .env.testing safely:
```bash
# Generate .env.testing from .env (never edit manually!)
./generate-env-testing.sh
```
This ensures APP_URL and all other variables remain identical to .env.

**CRITICAL RULE FOR TestCase:** NEVER duplicate database connection configuration in setUp() because CreatesApplication already handles it automatically.

---


# Tenant Configuration Resolution Logic

## 🔍 Path Discovery Mechanism

The `GetTenantNameAction` resolves the tenant name through a series of logical steps designed to be robust across environments.

### 1. Domain Inversion Strategy
1. **Input**: `laravelpizza.local` (from `APP_URL` or `SERVER_NAME`)
2. **Cleanup**: Remove `www.`
3. **Explode & Slug**: `['laravelpizza', 'local']`
4. **Reverse**: `['local', 'laravelpizza']`
5. **Implode**: `local/laravelpizza`

### 2. Filesystem Verification
The system checks for the existence of the directory in `config/`:
- `laravel/config/local/laravelpizza`

If it exists, `local/laravelpizza` becomes the official tenant name for the session.

## 🛠️ Configuration Merging (`ResolveTenantConfigValueAction`)

When `TenantService::config('app.name')` is called:

1. **Base Load**: Loads `config('app.name')` from the root `config/app.php`.
2. **Namespace Mapping**: Converts `local/laravelpizza` to `local.laravelpizza`.
3. **Override Lookup**: Searches for `config('local.laravelpizza.app.name')`.
4. **Deep Merge**: Merges the base array with the tenant-specific array. Overrides in the tenant file win.
5. **Global Set**: (Carefully) sets the merged configuration using `Config::set()` to ensure subsequent standard `config()` calls in the same request are tenant-aware.

## 🚀 Execution Contexts

### Web
Identifies tenant via `$_SERVER['SERVER_NAME']`.

### Console / Queue / Scheduler
Identifies tenant via `APP_URL` fallback in `.env`. This ensures that a job dispatched for `laravelpizza.local` is processed using the `local/laravelpizza` configuration, even when running in a background process.

---

> [!TIP]
> Always verify that your tenant directory in `config/` matches the inverted domain name to ensure correct resolution.

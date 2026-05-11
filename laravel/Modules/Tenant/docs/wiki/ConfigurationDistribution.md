---
module: Tenant
concept: Configuration Distribution
last_updated: 2026-04-15
---

# Configuration Distribution

PTVX allows each tenant to have its own configuration overrides without modifying the core application code. This is achieved through a **Hierarchical Merging System**.

## 1. Directory Structure

Tenant-specific configurations are stored in subdirectories named after the tenant slug:

```text
config/
├── app.php                # Base configuration (Global)
├── tenant_acme/
│   ├── app.php            # ACME Corp overrides
│   └── database.php       # ACME specific DB settings
└── tenant_widgets/
    └── app.php            # Widgets Inc overrides
```

## 2. Merging Logic

The `TenantService::config()` method handles the merging:
1. **Load Global**: Retrieves the base configuration from the standard `config/` directory.
2. **Load Tenant**: Checks for a corresponding file in the tenant's configuration subdirectory.
3. **Merge**: Overwrites global keys with tenant-specific values.
4. **Cache**: Stores the result in the Laravel `Config` repository for the current request.

## 3. Usage Pattern

Developers should use the `TenantService` to access tenant-aware configuration:

```php
// ✅ CORRECT - Explicitly tenant-aware
$appName = TenantService::config('app.name');

// ❌ WRONG - This will only return global config
$appName = config('app.name');
```

## 4. Security: Sandboxing
Tenant-specific configurations are isolated at the file system level. The `TenantService` ensures that one tenant cannot access another tenant's configuration subdirectory.

---
**Related Pages:**
- [[Tenant Module Architecture]]
- [[Tenant Identification]]
- [[Database Isolation]]

---
module: Tenant
concept: Tenant Identification
last_updated: 2026-04-15
---

# Tenant Identification

The process of identifying the correct tenant context for every incoming request is handled automatically by the **GetTenantNameAction**.

## 1. Resolution Strategies

The system uses several fallback strategies to resolve the tenant name:

### Subdomain Strategy
The primary method for development and production subdomains.
- **Development**: `{tenant}.localhost` → `tenant`
- **Production**: `{tenant}.ptvx.it` → `tenant`

### Custom Domain Strategy
For "White-Label" support, custom domains are mapped to tenant slugs using a configuration file or a Sushi model.
- Example: `acme-custom-domain.com` → `tenant_acme`

### Default Fallback
If no tenant is identified, the system falls back to the `default` tenant specified in `config('app.tenant_default')`.

## 2. Implementation: GetTenantNameAction

The logic resides in `app/Actions/GetTenantNameAction.php`. It parses the `$_SERVER['SERVER_NAME']` and performs the necessary lookups.

## 3. Performance
To ensure zero overhead, the identification result is cached for the duration of the request. In production, Redis can be used to cache domain mappings globally.

## 4. Verification
You can verify the current tenant context using the `TenantService`:

```php
$tenantName = TenantService::getName();
```

---
**Related Pages:**
- [[Tenant Module Architecture]]
- [[Configuration Distribution]]
- [[Sushi Models]]

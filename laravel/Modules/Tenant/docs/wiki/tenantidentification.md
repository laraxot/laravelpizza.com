---
title: "tenantidentification"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "tenantidentification"
issues: []
discussions: []
module: Tenant
concept: Tenant Identification
last_updated: 2026-04-15
status: stale
---

> Nota 2026-10-14 (docs-audit): Cita sottodomini {tenant}.localhost, config('app.tenant_default'), cache Redis e TenantService::getName(): nessuno esiste. GetTenantNameAction legge SERVER_NAME o l'host di APP_URL, inverte le parti e cerca la cartella config/ corrispondente (verificato 2026-10-14). Contenuto non riscritto, verificare prima di usarlo.

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

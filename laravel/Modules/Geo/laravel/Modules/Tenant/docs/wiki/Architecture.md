---
module: Tenant
concept: Architecture
last_updated: 2026-04-15
---

# Tenant Module Architecture

The **Tenant** module is the foundational layer for multi-tenancy in PTVX. It manages data isolation, distributed configuration, and automatic tenant identification.

## 1. Core Goal
The primary objective is to provide **Connection-Based Isolation**. This means each tenant's data is stored in a separate database or schema, and the application switches connections dynamically based on the request.

## 2. The Multi-Tenancy Flow

```text
Request → Domain Analysis → Tenant Identification → Connection Setup → Business Logic
```

1. **Identification**: The system identifies the tenant from the URL (subdomain or custom domain).
2. **Setup**: The `TenantServiceProvider` configures the database connection for the identified tenant.
3. **Execution**: Business modules (like User or Incentivi) execute their logic without being aware of multi-tenancy, as the database layer handles the isolation automatically.

## 3. Key Components

- **[[Tenant Identification]]**: Strategies for resolving the tenant from the environment.
- **[[Configuration Distribution]]**: Merging global and tenant-specific settings.
- **[[Sushi Models]]**: Handling static configuration data (like domains) without database overhead.

## 4. Sacred Rule: Connection Isolation
All models in business modules MUST extend their module's `BaseModel`, which in turn ensures the correct `tenant` connection is used. This prevents cross-tenant data leaks at the architectural level.

---
**Related Pages:**
- [[Xot Module Architecture]]
- [[BaseModel Pattern]]
- [[Database Isolation]]

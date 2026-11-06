---
issues: []
discussions: []
title: "Indice della Documentazione - Modulo Tenant"
module: "Tenant"
type: concept
tags: [index]
created: 2026-07-14
updated: 2026-07-24
qmd: "index modulo tenant bridge readme"
related:
  - "./README.md"
status: draft
---

# Indice della Documentazione - Modulo Tenant

> **Verificato 2026-07-24**: la maggior parte dei link di questo indice autogenerato punta a file/sottocartelle
> mai esistiti (`architecture/`, `models/`, `forms/`, `phpstan/index.md`, `actions/index.md`, `console/index.md`,
> `enums/index.md`, `filament/index.md`, `services/index.md`, `traits/index.md`, `domain-management.md`,
> `data-isolation.md`, `separate-databases.md`, ecc.). Consolidato: usare **[README.md](./README.md)** come
> punto di ingresso: a sua volta corretto in questa sessione perché descriveva un'architettura
> (`TenantService`, `TenantSwitcher`, `SetTenant`, `BelongsToTenant`) in gran parte non implementata nel codice.

Doc verificati e presenti in `docs/`:
- [structure.md](./structure.md)
- [events.md](./events.md)
- [core-functionality.md](./core-functionality.md)
- [configuration.md](./configuration.md)
- [filament-resources.md](./filament-resources.md)
- [API.md](./api.md)
- [translations.md](./translations.md)
- [phpstan-cluster.md](./phpstan-cluster.md)
- [testing.md](./testing.md)
- [architecture.md](./architecture.md)
- [troubleshooting.md](./troubleshooting.md)
- [conflict-resolution.md](./conflict-resolution.md)

---

<!-- Merged from INDEX.md, which collided with this file on case-insensitive filesystems. -->

---
module: Tenant
status: production
last_updated: 2026-07-28
---

# Tenant Module Documentation Index

**Last updated: 2026-07-28**

---

## Navigation

- [Overview](README.md): Module description and quick start
- [Architecture](ARCHITECTURE.md): System design and isolation strategies
- [API Reference](api.md): Core models, contracts, and services
- [Patterns](patterns.md): Design patterns and best practices
- [Troubleshooting](troubleshooting.md): Common issues and solutions
- [Contributing](../../docs/wiki/how-to/contributing.md): Development guidelines
- [Contributing](../../docs/wiki/how-to/contributing.md) _(target mancante, verificato 2026-10-14)_: Development guidelines

---

## Module Statistics

**Last Generated: 2026-07-28**

| Category | Count | Description |
|----------|-------|-------------|
| Models | 15 | Tenant, Domain, TenantDomain, TenantSetting, TenantSubscription, etc. |
| Actions | 15 | Business logic components grouped by feature (Config, Domains, Models, etc.) |
| Services | 7 | Configuration resolvers, domain services, and utility services |
| Filament Resources | 7 | Admin panel resources and form components |
| Migrations | 3 | Database schema setup and evolution |
| Seeders | 9 | Database seed data for testing and development |
| Factories | 8 | Eloquent model factories for testing |
| Policies | 2 | Authorization policies for models |
| Traits | 4 | Reusable model traits |
| Providers | 4 | Service providers and registration |
| Contracts | 2 | Interfaces and abstraction contracts |
| Commands | 1 | Artisan console commands |

**Total: 78 PHP files**

---

## Recently Updated Files

| Date | File | Category |
|------|------|----------|
| 2026-07-28 | README.md | Documentation |
| 2026-07-28 | ARCHITECTURE.md | Documentation |
| 2026-07-28 | API.md | Documentation |
| 2026-07-28 | PATTERNS.md | Documentation |
| 2026-07-28 | TROUBLESHOOTING.md | Documentation |
| 2026-07-22 | Tenant.php | Model |
| 2026-07-22 | Domain.php | Model |
| 2026-07-22 | TenantDomain.php | Model |
| 2026-07-22 | TenantSubscription.php | Model |
| 2026-07-22 | TenantSetting.php | Model |

---

## Key Concepts

### Tenant Isolation
Each tenant operates in complete isolation:
- **Database Isolation**: Separate database per tenant or shared database with scoping
- **Configuration Isolation**: Per-tenant configuration settings
- **Domain Routing**: Automatic tenant resolution via domain/subdomain

### Core Models

- **Tenant**: Root tenant entity with settings and metadata
- **Domain**: Domain/subdomain associations for tenant routing
- **TenantDomain**: Junction model linking tenant to multiple domains
- **TenantSetting**: Key-value configuration storage
- **TenantSubscription**: Subscription and billing model

---

## Quick Links

- **Config**: `config/config.php`, `config/database.php`
- **Service Provider**: `app/Providers/TenantServiceProvider.php`
- **Contracts**: `app/Contracts/`
- **Tests**: `tests/` (refer to main project structure)

---

## Related Modules

- **[Xot](../../Xot/docs/index.md)**: Core framework and abstractions
- **[Xot](../../Xot/docs/00-INDEX.md)**: Core framework and abstractions
- **[User](../../User/docs/index.md)**: User management and authentication

---

## Development Guidelines

1. Always maintain tenant isolation in queries
2. Use actions for complex business logic
3. Document patterns in PATTERNS.md
4. Add troubleshooting entries for known issues
5. Keep migrations atomic and reversible

For detailed development guidance, see [Contributing Guide](../../docs/wiki/how-to/contributing.md).
For detailed development guidance, see [Contributing Guide](../../docs/wiki/how-to/contributing.md) _(target mancante, verificato 2026-10-14)_.


---

## Contenuto assorbito da `INDEX.md`

# Documentation Index

Modulo: Tenant

## File disponibili

<!-- auto-generato: elencare i file .md presenti -->

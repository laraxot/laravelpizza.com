# Tenant - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **
> **Status**: Approved
> **Owner**: Tenant Module Team

## 1. Purpose & Vision

The Tenant module provides **multi-tenancy infrastructure** for the Laraxot ecosystem, enabling multiple isolated instances of the application to operate on a single codebase. Each tenant has its own data, configuration, domains, and subscriptions.

## 2. Problem Statement

Enterprise SaaS and multi-entity deployments require:
- Data isolation between organizations/entities
- Per-tenant domain and configuration management
- Subscription-based feature gating
- Seamless tenant switching without code changes

## 3. Target Users

| User | Role | Needs |
|------|------|-------|
| **Super Admin** | Platform operator | Create/manage tenants, assign domains |
| **Tenant Admin** | Organization admin | Configure tenant settings, manage subscriptions |
| **Developer** | Module builder | Tenant-aware models and queries |

## 4. Scope

### In Scope
- Tenant CRUD and lifecycle management
- Domain-to-tenant mapping (`Domain`, `TenantDomain`)
- Per-tenant settings (`TenantSetting`)
- Subscription management (`TenantSubscription`)
- Tenant name resolution (`GetTenantNameAction`)

### Out of Scope
- User authentication (User module)
- Billing/payment processing (external systems)
- Per-tenant database separation (uses row-level isolation)

## 5. Functional Requirements (Prioritized)

### P0: Multi-Tenancy Foundation (Must-have)
- **FR-001: Tenant Lifecycle**: Full CRUD for tenants and organizations through the `DomainResource`.
- **FR-002: Domain-to-Tenant Mapping**: Resolve tenant context from custom domains (`Domain`, `TenantDomain`) for white-label deployments.
- **FR-005: Data Isolation**: Enforce row-level tenant isolation across all models extending `XotBaseModel`.

### P1: Tenant Configuration (Important)
- **FR-003: Dynamic Settings**: Per-tenant configuration using schemaless attributes (`TenantSetting`) for overriding system defaults.
- **FR-006: Tenant Identification**: Standardized `GetTenantNameAction` for cross-module tenant awareness and path generation.

### P2: Subscription & Monetization (Nice-to-have)
- **FR-004: Feature Gating**: Restrict access to module features based on `TenantSubscription` tiers and entitlements.
- **FR-007: Tenant Analytics**: Centralized dashboard for monitoring tenant usage and health.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Infrastructure Provider**: Tenant provides the context for all other modules; it MUST NOT contain domain-specific logic.
- **Interoperability**: Exposes tenant context through a unified API/Action, allowing any module to become "tenant-aware" without direct dependencies.
- **Isolation**: Tenant resolution is handled at the middleware layer, keeping business logic clean of multi-tenancy concerns.

### Performance & Safety
- **NFR-001: Resolution Speed**: Tenant resolution < 10ms per request through aggressive caching.
- **NFR-002: Security**: Zero-leakage data isolation verified through automated multi-tenant test suites.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture

### Dependencies
- **Xot**: Base classes
- **User**: Tenant-user association

### Data Model
- `tenants` — Tenant registry
- `domains` / `tenant_domains` — Domain mapping
- `tenant_settings` — Per-tenant configuration (JSON)
- `tenant_subscriptions` — Subscription data

### Integration Points
- Global middleware for tenant resolution
- Tenant-scoped query scopes on all models
- `GetTenantNameAction` for cross-module tenant identification

## 8. User Experience

- **Admin panel**: Tenant list with domain configuration
- **Transparent**: End users see their tenant's branding/domain without awareness of multi-tenancy

## 9. Success Metrics & KPIs

| Metric | Target | Measurement |
|--------|--------|-------------|
| Tenant resolution time | < 10ms | Middleware profiling |
| Data isolation | 100% | Security audit |
| PHPStan Level 10 | 0 errors | PHPStan analysis |

## 10. Risks & Assumptions

### Assumptions
- Row-level isolation is sufficient (no per-tenant databases)
- All modules respect tenant scoping via base model

### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Cross-tenant data leak | Critical | Automated isolation tests |
| Performance with many tenants | Medium | Caching tenant resolution |

## 11. Dependencies & Constraints

- **Technical**: PHP 8.3+, Laravel 12
- **Architectural**: All models must extend tenant-aware base classes.

## 12. Release Plan

### Phase 1: Core Multi-Tenancy (Stable)
- Tenant CRUD ✅
- Domain mapping ✅
- Tenant-scoped queries ✅

### Phase 2: Advanced Features (Planned)
- Subscription tier management
- White-label theming per tenant
- Tenant analytics dashboard

## 13. References

- [roadmap.md](roadmap.md)
- [module.md](module.md)

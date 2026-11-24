---
issues: []
discussions: []
title: "Tenant Module Roadmap (2025 Q4)"
module: "Tenant"
type: concept
tags: [roadmap, q4]
created: 2026-07-14
updated: 2026-07-14
qmd: "roadmap q4"
related:
  - "./phpstan-corrections-january.md"
---
# Tenant Module Roadmap (2025 Q4)

## Vision & Scope
- Multi-tenant foundation integrated with User, UI, CMS, and Xot.

## Key Outcomes
- Contracts for tenancy stable (teams/tenants)
- 0 PHPStan errors

## Milestones
- [ ] Verify `HasTenants` implementations across modules
- [ ] Ensure BelongsTo/BelongsToMany signatures match contracts
- [ ] Seeders/factories for tenant scenarios

## Acceptance Criteria
- Tenancy works in tests (policies, scoping)

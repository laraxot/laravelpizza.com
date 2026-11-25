---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "3.5.multi tenant scope isolation.story"
issues: []
discussions: []
id: '3.5'
epic: 3
story: '5'
title: Multi-tenant scope isolation (tenant_id in queries)
slug: multi-tenant-scope-isolation
status: backlog
scope: module:Tenant
epic_title: 3 — Access Control & Security
---

---
# 3.5: Multi-tenant scope isolation (tenant_id in queries)

**Story ID:** 3.5
**Epic:** 3 — Access Control & Security
**Slug:** multi-tenant-scope-isolation
**Status:** backlog

## Story

As a PA tenant administrator,
I want every query against tenant-owned tables to be automatically scoped to my tenant,
so that no user can ever read or write another PA's data through the application layer, even by accident.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. A global Eloquent scope (or trait applied via model boot) automatically appends `tenant_id = auth()->user()->tenant_id` to every query on `User` and any other tenant-owned model available in `Modules/Tenant`. [Source: prd.md#FR-005 — "Multi-tenant: one database per PA; tenant_id filter on all queries"]
2. The scope cannot be bypassed by unscoped/raw query calls originating from within `Modules/Tenant` — any `withoutGlobalScope()` usage requires an explicit `pa_admin`-only justification path (documented, not built) rather than being silently available. [Source: prd.md#NFR-SEC-002 — "No bypass: Spatie Permissions enforced in code; no service-role keys in client code"]
3. A cross-tenant query attempt (authenticated user from tenant A querying a `User` row belonging to tenant B) returns zero results, not an error and not the other tenant's data. [Source: architecture.md#data-model — `Tenant`/`User` rows: `tenant_id` indexed on `User`]
4. The scope is documented (docblock + trait) so that Epic 1/2/4 model authors (`Scheda`, `SigmaLog`, `Activity`, `ProgressioniApproval`) can apply the same trait to their own tenant-owned models — this story delivers the reusable trait, not its application to models outside Epic 3's file scope. [Source: architecture.md#data-model — `tenant_id` present on `Scheda`, `Activity`, `ProgressioniApproval` rows]
5. Automated test proves: two tenants' `User` records are mutually invisible to each other under the scope, and the scope is active by default (no per-query opt-in required). [Source: prd.md#NFR-SEC-002 — "Test: 100% coverage of RLS + role combos"]

## Tasks / Subtasks

- [ ] Create `Modules/Tenant/app/Models/Concerns/BelongsToTenant.php` trait implementing a global scope that filters by `auth()->user()->tenant_id` (AC: #1)
- [ ] Apply the trait to `Modules/Tenant/app/Models/User.php` via `bootBelongsToTenant()` (AC: #1)
- [ ] Document (docblock on the trait) the constraint that `withoutGlobalScope()` calls must be reviewed/justified per NFR-SEC-002's no-bypass rule; do not add a generic "admin override" method (AC: #2)
- [ ] Add docblock usage instructions in the trait for other modules (`Scheda`, `SigmaLog`, `Activity`, `ProgressioniApproval`) to adopt in their own epics (AC: #4)
- [ ] Write isolation test seeding two tenants with users each, asserting zero cross-tenant visibility (AC: #3, #5)

## Dev Notes

<!-- LOCKED. External dev tools must not edit Dev Notes. -->

- **FR-005 explicit requirement:** "Multi-tenant: one database per PA; tenant_id filter on all queries." [Source: prd.md#FR-005] Note the PRD's stated tenancy model is one PostgreSQL DATABASE per PA — `tenant_id` is described as an additional application-layer filter/safeguard on top of that database-per-tenant isolation, not the sole isolation mechanism. `[Inference]` This story implements the `tenant_id` filter layer only; provisioning separate databases per PA is a deployment/infra concern (architecture.md#deployment-architecture) outside Epic 3's file scope.
- **Defense-in-depth architecture:** RLS plus policies "Chosen defense-in-depth... Mitigation: require role/RLS matrix tests for secured stories." [Source: architecture.md#trade-off-analysis] This story is the application-layer (Eloquent scope) half; 3.8 verifies the database-layer (PostgreSQL RLS) half.
- **NFR-SEC-002 scoping:** "DB enforcement: PostgreSQL RLS policies on Scheda, Activity, Progressioni tables"; "Scopes: tenant_id..., user_role"; "No bypass: Spatie Permissions enforced in code; no service-role keys in client code." [Source: prd.md#NFR-SEC-002] The "no service-role keys in client code" language maps directly to AC #2's ban on a silent bypass path.
- **Data model:** `Tenant` (`id`, `name`, `region`, `settings`); `User` (`tenant_id` indexed). [Source: architecture.md#data-model]
- **Deployment context:** "PostgreSQL database per PA" is the deployment topology. [Source: architecture.md#deployment-architecture] This confirms `tenant_id` scoping inside a single app codebase is a safeguard layered on top of, not a replacement for, physical database separation — relevant context for the dev agent, not something this story must re-implement.

## Testing

<!-- LOCKED. External dev tools must not edit Testing. -->

- **Test type:** Feature tests (Pest) at the Eloquent-scope level; no e2e (UI-level tenant isolation is exercised indirectly by 3.2/3.6 but not re-tested here).
- **Fixtures:** two `Tenant` factories; two or more `User` factories per tenant, some sharing the same email-domain pattern to rule out accidental non-tenant scoping logic.
- **Scenarios to prove each AC:**
  - AC #1/#5: authenticated as tenant A user, `User::all()` returns only tenant A rows.
  - AC #2: attempt to read tenant B data via a plain `User::find($tenantBUserId)` returns `null` (scope applies to `find()` too, not just `all()`/`where()`).
  - AC #3: cross-tenant query returns empty collection, not an exception; confirm response shape does not differ from "no matching users" so existence cannot be inferred.
  - AC #4: docblock present and matches the pattern other modules are expected to copy (review-only, not executable).
- **Edge cases:** unauthenticated context (queue job, console command) where `auth()->user()` is `null` — scope must not throw, and the dev agent should decide (document, don't implement) whether such contexts require an explicit tenant parameter instead of relying on the auth-session global scope.

## Dependency Maps

- Blocked by: 3.1 (User model role-helper conventions established there; this story adds a second concern — tenant scope — to the same model, sequenced after to avoid edit collision)
- Blocks: 3.6 (staff portal must query within an already-tenant-scoped `User` context), 3.7 (GDPR export must be tenant-safe by construction)
- External: none new — uses existing Eloquent global scope mechanism

## Owned File/Module Scope

- `Modules/Tenant/app/Models/Concerns/BelongsToTenant.php` — new file, owned exclusively by 3.5
- `Modules/Tenant/app/Models/User.php` — **SHARED** with 3.1/3.2/3.3/3.4 (all additive). This story adds the `BelongsToTenant` trait application only. Sequenced by Blocked-by 3.1 — do not edit in parallel with 3.1-3.4.
- `Modules/Tenant/tests/Feature/Tenancy/TenantIsolationTest.php` — new file, owned exclusively by 3.5

## Learnings from Previous Stories

(none — first epic being compiled; 3.1-3.4 are siblings in the same batch, not yet completed)

## Dev Agent Record

_(empty — to be completed by the external dev tool)_

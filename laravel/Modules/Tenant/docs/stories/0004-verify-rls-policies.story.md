---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "3.8.verify rls policies.story"
issues: []
discussions: []
id: '3.8'
epic: 3
story: '8'
title: 'Row-Level Security: verify RLS policies active'
slug: verify-rls-policies
status: backlog
scope: module:Tenant
epic_title: 3 — Access Control & Security
---

---
# 3.8: Row-Level Security: verify RLS policies active

**Story ID:** 3.8
**Epic:** 3 — Access Control & Security
**Slug:** verify-rls-policies
**Status:** backlog

## Story

As a security-conscious PA admin,
I want automated proof that PostgreSQL Row-Level Security policies are active and enforced on every tenant/user-scoped table,
so that a bug or omission in application-layer policy code cannot silently expose another tenant's or employee's data at the database layer.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. RLS is enabled (`ENABLE ROW LEVEL SECURITY`) on the `Scheda`, `Activity`, and `Progressioni` (ProgressioniApproval) tables via a migration owned by this story. [Source: prd.md#NFR-SEC-002 — "DB enforcement: PostgreSQL RLS policies on Scheda, Activity, Progressioni tables"]
2. RLS policies on those tables enforce `tenant_id` scoping and `user_role` scoping (staff read own; evaluator read dept; admin read all), mirroring the application-layer policy rules from 3.1-3.4. [Source: prd.md#NFR-SEC-002 — "Scopes: tenant_id..., user_role (staff read own; evaluator read dept; admin read all)"]
3. A verification command/test connects to the database as a non-superuser role and confirms that a direct query bypassing Eloquent (raw SQL) still cannot read rows outside the current session's tenant/role scope. [Source: prd.md#NFR-SEC-002 — "No bypass: Spatie Permissions enforced in code; no service-role keys in client code"]
4. Automated test suite achieves the PRD-mandated coverage target for RLS-plus-role combinations on the tables this story touches. [Source: prd.md#NFR-SEC-002 — "Test: 100% coverage of RLS + role combos"]
5. RLS verification is documented as a required pre-deployment gate check (procedure only — CI wiring itself is Epic 5 scope). [Source: architecture.md#trade-off-analysis — "Mitigation: require role/RLS matrix tests for secured stories."]

## Tasks / Subtasks

- [ ] Create `Modules/Tenant/database/migrations/{timestamp}_enable_rls_scheda_activity_progressioni.php` enabling RLS and defining `CREATE POLICY` statements for `Scheda`, `Activity`, `Progressioni` tables, keyed on `tenant_id` and a session-set role/user variable (AC: #1, #2)
- [ ] Document the session variable convention (e.g., `SET app.current_tenant_id`, `SET app.current_user_role`) the app must set per request/connection for RLS to resolve correctly, and confirm Laravel's connection bootstrapping sets it (AC: #2)
- [ ] Write a raw-SQL verification test (via `DB::statement`/`DB::select`, bypassing Eloquent) asserting cross-tenant and cross-role rows are unreadable even without any Eloquent-level global scope applied (AC: #3)
- [ ] Build a role/RLS coverage matrix test enumerating each role against each of the 3 RLS-protected tables (AC: #4)
- [ ] Write a short pre-deployment checklist note (in this story's Dev Notes / a docblock, not a new CI file) describing the manual/CI verification step for Epic 5 to wire up later (AC: #5)

## Dev Notes

<!-- LOCKED. External dev tools must not edit Dev Notes. -->

- **This story is database-layer verification, application-layer already exists:** 3.1-3.4 built the Laravel policy layer; 3.5 built the Eloquent tenant scope. This story adds the second, independent layer — PostgreSQL RLS — per the explicit defense-in-depth decision. [Source: architecture.md#trade-off-analysis — "RLS plus policies vs policies only: Chosen defense-in-depth. Benefit: accidental query leaks are harder. Cost: more database policy tests."]
- **Tables named explicitly by NFR-SEC-002:** "PostgreSQL RLS policies on Scheda, Activity, Progressioni tables." [Source: prd.md#NFR-SEC-002] Note `Scheda` and `Progressioni` (ProgressioniApproval) are Epic 1-owned models and `Activity` is Epic 4-owned — this story does not modify those modules' model files; it adds a migration (within `Modules/Tenant/database/migrations/`, this Epic's owned migration path) that operates on their underlying database tables via raw DDL. `[Inference]` A migration can alter another module's table via SQL without editing that module's PHP files; this keeps the story within Epic 3's declared file scope (`Modules/Tenant/database/migrations/`) while still delivering DB-level policy coverage on tables owned elsewhere. If the team prefers each owning module to carry its own RLS migration, flag this as a sequencing/ownership question to the orchestrator before implementation.
- **ADR-004 grounding:** "Use... PostgreSQL RLS policies for tenant/user scoped tables." [Source: architecture.md#adr-004] "Consequences: Authorization is checked in app code and database policy. Every new resource story must include role matrix tests." [Source: architecture.md#adr-004]
- **Session-variable mechanism is an inference:** PostgreSQL RLS policies typically resolve via `current_setting('app.current_tenant_id')`-style session variables set per connection/request. `[Inference]` Neither prd.md nor architecture.md specifies the exact mechanism Laravel should use to set these variables (e.g., a connection-resolving middleware). The dev agent should choose a standard approach (e.g., a `DB::statement("SET app...")` call in a service provider or middleware) and document it, since no source dictates the specific implementation.
- **Deployment context:** "PostgreSQL database per PA" — RLS policies apply within each PA's own database. [Source: architecture.md#deployment-architecture] Multi-tenant `tenant_id` scoping within RLS is still relevant as a second safeguard within a given PA's database if that database ever holds more than one tenant's rows (e.g., in non-prod/shared test environments).

## Testing

<!-- LOCKED. External dev tools must not edit Testing. -->

- **Test type:** Integration tests against a real PostgreSQL test database (RLS behavior cannot be meaningfully verified against SQLite or a mocked driver) — requires the project's PostgreSQL test connection to be configured.
- **Fixtures:** two tenants, each with a `Scheda`/`Activity`/`ProgressioniApproval` row; database sessions/connections configured with different `tenant_id`/role session variables per test case.
- **Scenarios to prove each AC:**
  - AC #1: `SELECT relrowsecurity FROM pg_class WHERE relname = 'scheda'` (and equivalents) returns `true` after migration.
  - AC #2: policy definitions exist and match tenant/role scoping rules (query `pg_policies`).
  - AC #3: raw `DB::select()` query as a session scoped to tenant A returns zero rows for tenant B's data, with no Eloquent model/scope involved.
  - AC #4: matrix test — each of the 5 base roles (plus `senior_mgmt` from 3.4) against read access on each of the 3 RLS-protected tables, asserting expected allow/deny per NFR-SEC-002's stated scoping (staff own, evaluator dept, admin all).
  - AC #5: checklist content review only — no test execution needed for documentation.
- **Edge cases:** a database connection/session where no tenant/role variable has been set (should default-deny, not default-allow); superuser/migration-runner connections (which necessarily bypass RLS for schema changes) must be clearly distinguished from application runtime connections in the test setup so the test doesn't accidentally validate against a privileged connection.

## Dependency Maps

- Blocked by: 3.1 (role matrix and permission model must exist to inform which roles map to which RLS scopes), 3.5 (tenant_id concept and scoping convention established at the application layer first)
- Blocks: none within Epic 3 (Epic 5's CI gate wiring will consume this story's verification command — cross-epic, not a same-epic blocker)
- External: PostgreSQL test database connection (must support `CREATE POLICY`/RLS — not available on SQLite); no new package dependency

## Owned File/Module Scope

- `Modules/Tenant/database/migrations/{timestamp}_enable_rls_scheda_activity_progressioni.php` — new file, owned exclusively by 3.8 (additive; does not modify 3.1's or 3.4's migration files)
- `Modules/Tenant/tests/Feature/Rbac/RlsPolicyVerificationTest.php` — new file, owned exclusively by 3.8
- Explicitly NOT owned: any `.github/workflows/` CI file (Epic 5 scope per sharding-context.md) — this story documents the check, Epic 5 wires it into CI.

## Learnings from Previous Stories

(none — first epic being compiled; 3.1-3.5 are siblings in the same batch, not yet completed)

## Dev Agent Record

_(empty — to be completed by the external dev tool)_

---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "6.1.setup wizard db init seed.story"
issues: []
discussions: []
id: '6.1'
epic: 6
story: '1'
title: 'Filament setup wizard: DB init + seed'
slug: setup-wizard-db-init-seed
status: backlog
scope: module:Tenant
epic_title: 6 — Setup & Operations
---

---
# 6.1: Filament setup wizard: DB init + seed

**Story ID:** 6.1
**Epic:** 6 — Setup & Operations
**Slug:** setup-wizard-db-init-seed
**Status:** backlog

## Story

As a PA (public administration) admin deploying a new tenant,
I want a Filament wizard that captures the PA's core setup data and seeds the default roles,
so that I can bring a new PA online in under an hour instead of 4-8 hours of manual configuration.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. The wizard captures PA name, admin email, department list, and evaluation types on a single Filament wizard page. [Source: prd.md#FR-010]
2. Submitting the wizard creates the five roles (`staff`, `evaluator`, `hr_admin`, `finance`, `pa_admin`) via Spatie Permissions seeding; re-running the seed is idempotent (no duplicate role rows). [Source: prd.md#FR-010] [Source: prd.md#FR-005]
3. A preview/dry-run step shows the PA metadata, department list, and roles that will be created, before the admin confirms and commits (Save). Nothing is persisted until confirmation. [Source: prd.md#FR-010]
4. The wizard page and the role-seeding action are reachable only by an authenticated `pa_admin`; unauthenticated or non-admin users are denied. [Source: architecture.md#adr-004] [Source: prd.md#FR-005]
5. The seeded roles and PA record are scoped to the tenant being set up (`tenant_id` populated); no cross-tenant rows are created. [Source: architecture.md#data-model]

## Tasks / Subtasks

- [ ] Verify the existing `Modules/Tenant` module is present and add the setup wizard files inside it; do not scaffold or create any module (AC: #1)
- [ ] Build `SetupWizard` Filament Page with steps: PA info entry, roles/data preview, confirm (AC: #1, #3)
- [ ] Implement `SeedDefaultRolesAction` using Spatie `Role::firstOrCreate()` for staff/evaluator/hr_admin/finance/pa_admin, scoped to tenant (AC: #2, #5)
- [ ] Implement `InitializeTenantDatabaseAction` to persist PA name, admin email, department list, evaluation types on confirm (AC: #1, #5)
- [ ] Hold preview state in Livewire/Filament wizard state only; do not call persistence actions until the Confirm step (AC: #3)
- [ ] Gate `SetupWizard` page with a `pa_admin`-only Filament page policy/`canAccess()` check (AC: #4)
- [ ] Add `database/seeders/RoleSeeder.php` implementing the same idempotent role seeding, callable both from the wizard and from `php artisan db:seed` (AC: #2)

## Dev Notes

<!-- LOCKED. External dev tools must not edit Dev Notes. -->

- **Capability and acceptance criteria are FR-010** (COULD, Phase 1.5): "Automated role seeding, permission matrix, user import for new PA deployments." AC bullets: "Wizard: PA name, admin email, department list, evaluation types"; "Auto-create: staff, evaluator, hr_admin, finance roles"; "Verification: preview + dry-run before save"; "Time: complete setup in <1 hour (vs. 4-8 hours manual)." [Source: prd.md#FR-010]
- **Role names come from FR-005**: "Roles: staff (read own Scheda), evaluator (CRUD all Scheda), hr_admin (Sigma + settings), finance (reports only), pa_admin (all access)." FR-010's own AC list only names four (staff/evaluator/hr_admin/finance); `pa_admin` is included here because FR-005 defines it as one of the five enforced roles and the wizard is operated by a pa_admin who must exist as a role. [Source: prd.md#FR-005] [Inference]
- **Component ownership**: "Setup/Operations (`Xot`, `Tenant`) | PA setup, module conventions, quality gates | Filament setup wizard, seeders, CI checks | Configuration, setup logs | ADR-008, ADR-010." [Source: architecture.md#component-design]
- **Architecture pattern**: build the admin workflow as a Filament Page (per ADR-002: "Build administrative workflows in Filament resources, pages, actions, tables, and widgets"), not a custom SPA. [Source: architecture.md#adr-002]
- **RBAC/auth constraint**: "Use Laravel session authentication for Filament... Use Spatie Permissions for roles/permissions, Laravel policies for resource actions... No client-side service role credentials." Role seeding and page access must go through this same Spatie/policy path, not a bypass. [Source: architecture.md#adr-004]
- **Naming convention**: "Models are singular StudlyCase, tables snake_case plural, columns snake_case, Filament resources `*Resource`... shared base behavior in Xot base classes instead of per-module copies." Apply to Tenant setup classes (Action/Page suffixes, no per-module base-class duplication). [Source: architecture.md#adr-008]
- **Data model constraint**: `Tenant` = "PA deployment boundary" with attributes `id`, `name`, `region`, `settings`; "one database per PA; tenant metadata still present." The wizard's PA-info step writes into this record/shape. [Source: architecture.md#data-model]
- **Multi-tenant scoping**: FR-005 requires "Multi-tenant: one database per PA; tenant_id filter on all queries" and "Setup: role seeding + permission matrix in migration" — this story is the concrete implementation of that setup bullet. [Source: prd.md#FR-005]
- [Inference] "Time: complete setup in <1 hour" (FR-010) is a manual/UX target, not an automatable NFR assertion; Testing below treats it as a walkthrough check, not a timed test.

## Testing

<!-- LOCKED. External dev tools must not edit Testing. -->

- **Test types**: Filament/Livewire feature tests (`livewire()` test helpers) for the wizard page; unit tests for `SeedDefaultRolesAction` and `InitializeTenantDatabaseAction`.
- **AC #1/#3 (capture + dry-run)**: fill wizard fields, assert no `Role` or tenant-config rows exist until the Confirm step is triggered; assert the preview step renders the exact PA name/department list/role list about to be created.
- **AC #2 (role seeding, idempotent)**: run `SeedDefaultRolesAction` twice for the same tenant; assert exactly 5 role rows exist after both runs (no duplicates). Assert role names exactly match `staff`, `evaluator`, `hr_admin`, `finance`, `pa_admin`.
- **AC #4 (access gate)**: assert a guest and a non-`pa_admin` user (e.g. `staff`) get a 403/redirect on the wizard route; assert a `pa_admin` user can load it.
- **AC #5 (tenant scoping)**: create two tenants, run the wizard for tenant A, assert tenant B has zero seeded roles/config rows.
- **Fixtures**: use model factories for `Tenant`/`User` with a `pa_admin` role pre-assigned for the access-gate test; no external services to mock (this story has no email/queue/HTTP dependency).
- **Edge cases**: empty department list, duplicate evaluation-type entries, re-running the wizard against an already-seeded tenant (must not duplicate roles or PA config).
- Do not execute tests, linters, or builds as part of this planning story — this section defines the strategy only.

## Dependency Maps

- Blocked by: none
- Blocks: `6.2` — invite workflow needs the tenant/wizard scaffold and seeded role names to reference; `6.3` — role auto-assignment validates against the roles seeded here; `6.4` — cleanup-policy scheduling assumes a tenant has been initialized by this story
- External: Spatie Permissions library (role model), no new environment variables

## Owned File/Module Scope

- `Modules/Tenant/module.json` (read/verify only; module creation is out of scope)
- `Modules/Tenant/app/Providers/SetupServiceProvider.php`
- `Modules/Tenant/app/Filament/Pages/SetupWizard.php`
- `Modules/Tenant/app/Actions/SeedDefaultRolesAction.php`
- `Modules/Tenant/app/Actions/InitializeTenantDatabaseAction.php`
- `database/seeders/RoleSeeder.php`
- `Modules/Tenant/tests/Feature/Setup/SetupWizardDbInitTest.php`
- Note: `database/seeders/DatabaseSeeder.php` is a shared bootstrap file — this story only adds a `RoleSeeder::class` call to it, does not restructure it. Coordinate if another story is editing it concurrently.

## Learnings from Previous Stories

(none — first story in this epic)

## Dev Agent Record

_(empty — to be completed by the external dev tool)_

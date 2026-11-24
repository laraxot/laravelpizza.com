---
title: "User redundancy audit 2026-05-21"
type: audit
module: User
tags: [redundancy, duplicate-code, migrations, ui]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# User redundancy audit 2026-05-21

High-risk findings:
- Duplicate FQCNs exist in both root-level folders and `app/`: `CreateUserAction`, `UserRegistered`, ownership use-case contracts.
- Duplicate factory path: `Database/factories/DeviceProfileFactory.php` and `database/factories/DeviceProfileFactory.php`.
- Several migrations are byte-identical or near-identical with different timestamps, including teams, devices, team_user, tenant_user, roles, permissions, and model_has_roles.
- UI components are byte-identical to `Modules/UI`, including button, modal, input, checkbox, badge, link, nav-link, text-link, placeholder, layout, and marketing components.
- Docs include case-only duplicates such as `QUERY_OPTIMIZATION_ANALYSIS.md` and `query_optimization_analysis.md`.

Risk:
- Duplicate FQCN can break Composer autoload determinism.
- Duplicate migrations can create table/column conflicts during fresh installs or package-level tests.
- UI duplication between `User` and `UI` hides the real component owner.

Suggested cleanup order:
1. Make `Modules\User\...` runtime classes live under the PSR-4 canonical `app/` path only.
2. Audit migrations by table name before deleting any duplicate timestamp.
3. Move shared UI primitives to `Modules/UI`; leave only User-specific wrappers in User.
4. Normalize docs to lowercase-kebab-case, then update local indexes.

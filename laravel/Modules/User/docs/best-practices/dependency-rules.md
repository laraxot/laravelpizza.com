---
title: "dependency-rules"
type: rule
tags: [dependency, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "dependency-rules dependency-rules"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./auth-components-best-practices.md"
  - "./auth-widget-rules.md"
  - "./auth-widget.md"
  - "./case-sensitivity-rules.md"
  - "./case-sensitivity.md"
  - "./component-verification-rules.md"
  - "./component-verification.md"
  - "./dependency.md"
---

# dependency-rules

## Principle (MANDATORY)
- Base modules MUST NOT depend on specific/domain modules.
- Allowed dependencies for `Modules/User`: `Modules/Xot`, `Modules/UI`, other base/intermediate modules.
- Forbidden: any import from `Modules/<nome progetto>`, `Modules/Patient`, `Modules/Doctor`, etc.

## Symptoms of violations
- `use Modules\<nome progetto>\...` inside `Modules/User/...`
- Widgets/Resources/Providers in `User` referencing domain types like `Patient`, `Appointment`, etc.

## Remediation options
- Option A (move): Move feature-specific classes into the domain module (e.g., `<nome progetto>`) and update namespaces.
- Option B (contract): Define a contract in `Modules\User\Contracts\...` (e.g., `UserTypeStatProvider`) and implement/bind it inside the domain module’s ServiceProvider.

## Test policy alignment
- Tests in `User` must not instantiate or reference domain models. Verify generic behavior only.
- Prefer business-behavior-first tests (no `$fillable`, no table names, no internals; no `RefreshDatabase`).

## Checklist
- [ ] No imports from domain modules in `Modules/User`
- [ ] Factories in `User` do not reference domain types
- [ ] Widgets in `User` are generic or contract-based
- [ ] PHPStan: deny cross-module references from `User` to domain modules

## References
- `laravel/.ai/guidelines/modular-architecture-dependencies.md`
- `laravel/.ai/guidelines/testing-business-behavior.md`

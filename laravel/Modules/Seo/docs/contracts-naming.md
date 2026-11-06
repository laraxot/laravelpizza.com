---
qmd: "contracts naming"
issues: []
discussions: []
title: "Contracts Naming & Placement"
type: concept
created: 2026-07-12
updated: 2026-07-12
tags: [contract, naming, architecture, laraxot, seo]
related:
  - ../../../../docs/wiki/rules/module-contracts-naming-placement.md
  - ./wiki/concepts/metatag-data-contract.md
status: active
---

# Contracts Naming & Placement in Seo

> A contract is an **agreement**, not a PHP keyword. We name it `*Contract` and place it under `app/Contracts/`.

## Rule

- ✅ `app/Contracts/MetatagDataContract.php`
- ❌ `app/Interfaces/MetatagDataInterface.php`

## Why

- `Contract` describes the domain concept (a pact between components).
- `interface` describes a PHP implementation detail.
- One folder (`app/Contracts/`) keeps the module language consistent and reduces cognitive noise.
- Aligned with Laravel `Illuminate\Contracts\*` convention.

## Module-specific Example

`MetatagDataContract` lives in `app/Contracts/`. The concrete DTO `MetatagData` implements it. Services and Facades type-hint the contract.

## Verification

```bash
bash bashscripts/tools/check-module-contracts-naming.sh
```

See the project rule for full rationale: `docs/wiki/rules/module-contracts-naming-placement.md`.

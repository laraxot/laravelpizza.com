---
qmd: "contracts naming"
issues: []
discussions: []
title: "Contracts Naming & Placement"
type: concept
created: 2026-07-12
updated: 2026-07-12
tags: [contract, naming, architecture, laraxot, geo]
related:
  - ../../../../docs/wiki/rules/module-contracts-naming-placement.md
---

# Contracts Naming & Placement in Geo

> A contract is an **agreement**, not a PHP keyword. We name it `*Contract` and place it under `app/Contracts/`.

## Rule

- ✅ `app/Contracts/ExampleContract.php`
- ❌ `app/Interfaces/ExampleInterface.php`

## Why

- `Contract` describes the domain concept (a pact between components).
- `interface` describes a PHP implementation detail.
- One folder (`app/Contracts/`) keeps the module language consistent and reduces cognitive noise.
- Aligned with Laravel `Illuminate\Contracts\*` convention.

## Verification

```bash
bash bashscripts/tools/check-module-contracts-naming.sh
```

See the project rule for full rationale: `docs/wiki/rules/module-contracts-naming-placement.md`.

---
qmd: "contracts naming"
issues: []
discussions: []
title: "Contracts Naming & Placement"
type: concept
created: 2026-07-12
<<<<<<< .merge_file_sRDD5R
<<<<<<< .merge_file_BqkQW2
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_uoIKnL
<<<<<<< HEAD
updated: 2026-07-12
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_sRDD5R
>>>>>>> .merge_file_O5LOJw
=======
>>>>>>> .merge_file_uoIKnL
tags: [contract, naming, architecture, laraxot, notify]
related:
  - "./00-index-1.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-100.md"
<<<<<<< .merge_file_sRDD5R
<<<<<<< .merge_file_BqkQW2
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions-2.md"
<<<<<<< HEAD
  - "./acronym-naming-conventions.md"
=======
<<<<<<< HEAD
=======
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions-2.md"
>>>>>>> .merge_file_O5LOJw
=======
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions-2.md"
>>>>>>> .merge_file_uoIKnL
  - "./acronym-naming-conventions.md"
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
  - "./action-plan-immediate.md"
---

# Contracts Naming & Placement in Notify

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

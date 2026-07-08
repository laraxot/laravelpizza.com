---
title: "CanComment ritirato — placement errato"
type: rule
module: User
tags: [can-comment, models-contracts, retired, boundary]
created: 2026-06-10
updated: 2026-06-18
qmd: "User CanComment Comment module dependency retired BaseUser no comment"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/102"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../concepts/no-comment-module-dependency.md
---

# CanComment — non più in User

`CanComment` era capability **solo Model** ma finì in `app/Contracts/` — viola [models-contracts-placement](../../../../docs/wiki/rules/models-contracts-placement.md).

- Ritirato: `app/Contracts/CanComment.php` → `app/Contracts/CanComment.php.old`
- Precedente archivio: `app/Models/Contracts/CanComment.php.old`
- Nessuna SSOT attiva in `User`: il modulo identity non espone contratti o trait di Comment.
- `BaseUser` non deve implementare `CanComment` né usare trait/comment relations di moduli opzionali.

Non reintrodurre alias attivi in User.

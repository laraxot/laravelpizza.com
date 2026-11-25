---
title: "UserContract — hasPermissionToOrCreate"
module: User / Predict
type: concept
status: resolved
<<<<<<< .merge_file_GstHDX
=======

title: "UserContract: hasPermissionToOrCreate"
>>>>>>> .merge_file_RkzH9H
tags: [user-contract, permission, bmad, second-brain]
created: 2026-09-24
related:
  - ../bmad-second-brain-2.md
  - ../../Xot/app/Contracts/UserContract.php
<<<<<<< .merge_file_GstHDX
qmd: "user contract haspermissiontoorcreate usercontract"
=======
>>>>>>> .merge_file_RkzH9H
---

# hasPermissionToOrCreate — implementazione

updated: 2026-10-08
qmd: "haspermissiontoorcreate   implementazione user"
status: superseded
superseded_by: user-contract-has-permission-to-or-create.md

# hasPermissionToOrCreate: implementazione

Metodo richiesto da `Modules\Xot\Contracts\UserContract::hasPermissionToOrCreate()`. Se il permesso non esiste in DB viene creato al volo via `Permission::firstOrCreate()` invece di esplodere `PermissionDoesNotExist`.

Implementato in `BaseUser` (modulo User), quindi disponibile anche a Predict.

Workflow BMAD + Second Brain applicato: consultati `docs/tools/bmad-method.md`, `wiki/concepts/second-brain-max-power.md`, `../../Xot/docs/consolidated/phpstan/phpstan-workflow-2.md`.

<<<<<<< HEAD
=======
<<<<<<< .merge_file_3oJRH7
---
title: "Ponytail-audit 2026-07-02: User module findings"
type: audit
status: draft
updated: 2026-10-07
tags: [docs, user]
qmd: "ponytail-audit 2026-07-02: user module findings user"
---
=======
>>>>>>> .merge_file_B3Fqns
>>>>>>> laraxot/dev
# Ponytail-audit 2026-07-02: User module findings

Source: repo-wide ponytail-audit follow-up, published in module_user_fila5 discussion
(see Related section below).

## Finding

`app/Contracts/UserContract.php.to_xot` was an orphaned rename artifact: a `.to_xot`
suffixed file (117 lines, an abandoned draft of a migration toward
`Modules\Xot\Contracts\UserContract`) sitting next to the real, active
`app/Contracts/UserContract.php`.

## Why this is not just a style nit

The `.to_xot` extension means PHP's autoloader (PSR-4, `.php` only) never loads the
<<<<<<< .merge_file_Oh4Nff
file — it was dead weight from the moment it landed, not a currently-working
=======
<<<<<<< HEAD
file — it was dead weight from the moment it landed, not a currently-working
=======
<<<<<<< .merge_file_3oJRH7
file: it was dead weight from the moment it landed, not a currently-working
=======
file — it was dead weight from the moment it landed, not a currently-working
>>>>>>> .merge_file_B3Fqns
>>>>>>> laraxot/dev
>>>>>>> .merge_file_V7VRpr
alternative implementation. A prior audit pass
(`Modules/User/docs/wiki/decisions/contracts-and-lang-backup-archival-2026-06-30.md`)
had already identified this exact file and stated it would be archived to
`UserContract.php.to_xot.bak`, but `git log --follow` on the file shows that rename
<<<<<<< .merge_file_Oh4Nff
was never actually committed to this module's repo — the `.to_xot` file was still
=======
<<<<<<< HEAD
was never actually committed to this module's repo — the `.to_xot` file was still
=======
<<<<<<< .merge_file_3oJRH7
was never actually committed to this module's repo: the `.to_xot` file was still
=======
was never actually committed to this module's repo — the `.to_xot` file was still
>>>>>>> .merge_file_B3Fqns
>>>>>>> laraxot/dev
>>>>>>> .merge_file_V7VRpr
present and untouched on disk. This session deletes it outright rather than
re-attempting the archive-as-`.bak` pattern, since the file has zero references
anywhere in the codebase (verified below) and archiving orphaned, never-autoloaded
drafts provides no value over deletion.

## Verification performed

<<<<<<< .merge_file_Oh4Nff
- `grep -rln "UserContract" Modules/ --include="*.php"` — only real hits are the
  active `Modules/User/app/Contracts/UserContract.php` (aliasing
  `Modules\Xot\Contracts\UserContract`) and its ~900 legitimate repo-wide references;
  nothing references the `.to_xot` file by path or string.
=======
<<<<<<< HEAD
=======
<<<<<<< .merge_file_3oJRH7
- `grep -rln "UserContract" Modules/ --include="*.php"`: only real hits are the
  active `Modules/User/app/Contracts/UserContract.php` (aliasing
  `Modules\Xot\Contracts\UserContract`) and its ~900 legitimate repo-wide references;
  nothing references the `.to_xot` file by path or string.
- `find Modules -name "*.to_xot"`: three other unrelated `.to_xot` files exist
  (`Modules/<nome progetto>/database/factories/ExtraFactory.to_xot`,
  `Modules/<nome progetto>/app/Models/Extra.to_xot`,
  `Modules/Media/app/Actions/Image/SvgExistsAction.to_xot`) in different modules;
  out of scope for this module's repo and left untouched.
- `git status` in `Modules/User` was clean before the delete and showed exactly one
  `D app/Contracts/UserContract.php.to_xot` after: no collateral deletions.
=======
>>>>>>> laraxot/dev
- `grep -rln "UserContract" Modules/ --include="*.php"` — only real hits are the
  active `Modules/User/app/Contracts/UserContract.php` (aliasing
  `Modules\Xot\Contracts\UserContract`) and its ~900 legitimate repo-wide references;
  nothing references the `.to_xot` file by path or string.
>>>>>>> .merge_file_V7VRpr
- `find Modules -name "*.to_xot"` — three other unrelated `.to_xot` files exist
  (`Modules/Quaeris/database/factories/ExtraFactory.to_xot`,
  `Modules/Quaeris/app/Models/Extra.to_xot`,
  `Modules/Media/app/Actions/Image/SvgExistsAction.to_xot`) in different modules;
  out of scope for this module's repo and left untouched.
- `git status` in `Modules/User` was clean before the delete and showed exactly one
  `D app/Contracts/UserContract.php.to_xot` after — no collateral deletions.
<<<<<<< .merge_file_Oh4Nff
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_B3Fqns
>>>>>>> laraxot/dev
>>>>>>> .merge_file_V7VRpr

## Fix applied

Deleted `Modules/User/app/Contracts/UserContract.php.to_xot`. No replacement; the
real `UserContract.php` is untouched.

## Quality gates

- **PHPStan** (`Modules/User`): 1 pre-existing error, unrelated to this change
  (`app/Models/Traits/HasDevices.php does not exist`, referenced by
<<<<<<< .merge_file_Oh4Nff
  `phpstan.neon` path config — not touched by this session).
=======
<<<<<<< HEAD
  `phpstan.neon` path config — not touched by this session).
=======
<<<<<<< .merge_file_3oJRH7
  `phpstan.neon` path config: not touched by this session).
=======
  `phpstan.neon` path config — not touched by this session).
>>>>>>> .merge_file_B3Fqns
>>>>>>> laraxot/dev
>>>>>>> .merge_file_V7VRpr
- **PHPMD** (`Modules/User/app/Contracts`, rulesets
  cleancode/codesize/controversial/design/naming/unusedcode): zero violations.
- **PHPInsights** (`Modules/User/app/Contracts`): 100% code, 100% complexity, 100%
  architecture, 98.8% style. Sole style finding (unused `Pivot` import in
  `TeamContract.php`) is pre-existing and unrelated to this change.
- **Pest**: skipped, DB unreachable in this environment (pre-existing infra gap,
  documented in the 2026-06-30 decision doc referenced above).
- **Puppeteer/Playwright**: skipped, no UI changes in this session.

## Related

- `Modules/User/docs/wiki/decisions/contracts-and-lang-backup-archival-2026-06-30.md`:
  prior session that first identified this file and intended (but never committed)
  an archive-as-`.bak` rename.
<<<<<<< HEAD
- `Modules/Xot/docs/ponytail-audit-2026-07-02.md`, `Modules/Notify/docs/ponytail-audit-2026-07-02.md`:
=======
<<<<<<< .merge_file_3oJRH7
- `Modules/Xot/docs/ponytail-audit-user-module-findings.md`, `Modules/Notify/docs/ponytail-audit-user-module-findings.md`:
=======
- `Modules/Xot/docs/ponytail-audit-2026-07-02.md`, `Modules/Notify/docs/ponytail-audit-2026-07-02.md`:
>>>>>>> .merge_file_B3Fqns
>>>>>>> laraxot/dev
  sibling module findings from the same repo-wide audit pass.

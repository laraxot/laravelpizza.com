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
file — it was dead weight from the moment it landed, not a currently-working
alternative implementation. A prior audit pass
(`Modules/User/docs/wiki/decisions/contracts-and-lang-backup-archival-2026-06-30.md`)
had already identified this exact file and stated it would be archived to
`UserContract.php.to_xot.bak`, but `git log --follow` on the file shows that rename
was never actually committed to this module's repo — the `.to_xot` file was still
present and untouched on disk. This session deletes it outright rather than
re-attempting the archive-as-`.bak` pattern, since the file has zero references
anywhere in the codebase (verified below) and archiving orphaned, never-autoloaded
drafts provides no value over deletion.

## Verification performed

- `grep -rln "UserContract" Modules/ --include="*.php"` — only real hits are the
  active `Modules/User/app/Contracts/UserContract.php` (aliasing
  `Modules\Xot\Contracts\UserContract`) and its ~900 legitimate repo-wide references;
  nothing references the `.to_xot` file by path or string.
- `find Modules -name "*.to_xot"` — three other unrelated `.to_xot` files exist
  (`Modules/Quaeris/database/factories/ExtraFactory.to_xot`,
  `Modules/Quaeris/app/Models/Extra.to_xot`,
  `Modules/Media/app/Actions/Image/SvgExistsAction.to_xot`) in different modules;
  out of scope for this module's repo and left untouched.
- `git status` in `Modules/User` was clean before the delete and showed exactly one
  `D app/Contracts/UserContract.php.to_xot` after — no collateral deletions.

## Fix applied

Deleted `Modules/User/app/Contracts/UserContract.php.to_xot`. No replacement; the
real `UserContract.php` is untouched.

## Quality gates

- **PHPStan** (`Modules/User`): 1 pre-existing error, unrelated to this change
  (`app/Models/Traits/HasDevices.php does not exist`, referenced by
  `phpstan.neon` path config — not touched by this session).
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
- `Modules/Xot/docs/ponytail-audit-2026-07-02.md`, `Modules/Notify/docs/ponytail-audit-2026-07-02.md`:
  sibling module findings from the same repo-wide audit pass.

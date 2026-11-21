---
title: "ponytail audit"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ponytail audit"
issues: []
discussions: []
---

# Ponytail-audit 2026-07-02: Media module findings

Source: repo-wide ponytail-audit pattern (same pass as Xot and Notify module findings, see
`Modules/Xot/docs/ponytail-audit-2026-07-02.md` and `Modules/Notify/docs/ponytail-audit-2026-07-02.md`).

## Finding

`Modules/Media/app/Contracts/PathGenerator.php` was an interface with a single near-implementer,
`Modules/Media/app/Support/TemporaryUploadPathGenerator.php`, whose `implements PathGenerator`
line was already commented out (along with the `use` imports for the interface and for
`Spatie\MediaLibrary\Support\PathGenerator\PathGenerator`). A repo-wide grep for `PathGenerator`
across `Modules/` confirmed no other class implements it and nothing binds it in a service
container/provider.

## Why this is yagni

Per ponytail YAGNI rung: an interface earns its keep only when there are two or more concrete
consumers sharing a boundary. Here there was exactly zero live implementers (the one candidate
implementation had already opted out, in code, via the commented `implements`). The interface
was dead weight: an abstraction with no callers and no swap-need.

## Fix

Deleted `Modules/Media/app/Contracts/PathGenerator.php`. No replacement introduced.
`TemporaryUploadPathGenerator.php` left as-is (still works standalone, commented-out lines
left in place as a minimal-diff choice).

## Verification

- `./vendor/bin/phpstan analyse Modules/Media`: no errors.
- `php tools/phpmd.phar Modules/Media/app text cleancode,codesize,controversial,design,naming,unusedcode`:
  pre-existing warnings across the module (camelCase naming, unused policy parameters, static
  access, etc.), none related to the deleted file or newly introduced by this change.
- `./vendor/bin/phpinsights analyse Modules/Media/app/Support --no-interaction`: one pre-existing
  architecture finding ("Normal classes are forbidden, must be final or abstract" on
  `TemporaryUploadPathGenerator.php`), unrelated to this change, not newly introduced.
- Pest: skipped, DB unreachable in this environment.
- Puppeteer/Playwright: skipped, no UI changes in this change.

## Related

- Same audit pass as `Modules/Xot/docs/ponytail-audit-2026-07-02.md` (19 similar single-implementer
  Contracts identified in Xot, issue #102) and `Modules/Notify/docs/ponytail-audit-2026-07-02.md`.

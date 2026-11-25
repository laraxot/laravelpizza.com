---
qmd: "no rm no archive use old suffix"
issues: []
discussions: []
title: "No rm, no archive folders, use .old suffix"
type: rule
module: Rating
confidence: high
created: 2026-07-12
updated: 2026-07-12
tags: [rating, governance, files, migrations, old-suffix]
related:
  - ../../../../../../docs/wiki/rules/no-rm-no-archive-use-old-suffix.md
status: draft
---

# No rm, no archive folders, use .old suffix

Rating cleanup is forward-only.

Do not run `rm database/migrations/*.php` and do not move migrations into `database/migrations_archive/`.

If a migration or source file must be retired, rename it in place with `.old` and document why in `Modules/Rating/docs/wiki/`.

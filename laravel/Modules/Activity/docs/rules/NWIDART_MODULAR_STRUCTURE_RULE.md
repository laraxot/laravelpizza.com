---
title: "Nwidart modular structure — test ownership"
type: note
status: draft
updated: 2026-10-20
tags: [docs, activity, rules]
qmd: "nwidart modular structure   test ownership activity"
---
# Nwidart modular structure — test ownership

**Status:** mandatory; canonical rule is
`laravel/Modules/<Module>/tests/`.

Each module owns its tests, bootstrap and fixtures below its lowercase `tests/`
directory. Run focused tests from `laravel/` with
`./vendor/bin/pest Modules/Activity/tests`.

`laravel/tests/` remains valid for application-wide, cross-module and theme
tests. Existing `laravel/tests/Modules/<Module>/` trees are legacy or
application-owned until inventoried; do not create new module tests there and
do not delete or move them automatically.

The old version of this rule incorrectly treated the central tree as forbidden
and is retained only in git history. The correction followed verification of
the current module directories, namespaces, bootstraps and Pest configuration.

---
title: "Resolve git conflict markers in User module translation files"
slug: resolve-conflict-markers-user-lang
status: done
scope: module:User
date: 2026-10-21
related: []
---

# Resolve git conflict markers in User module translation files

## Goal

Remove leftover git conflict markers (`<<<<<<<`, `=======`, `>>>>>>>`) from six
translation files in `laravel/Modules/User/lang/` so that each file parses again
and returns its translation array.

## Scope

- `lang/de/auth.php`
- `lang/de/login.php`
- `lang/es/auth.php`
- `lang/it/auth.php`
- `lang/it/login.php`
- `lang/it/login_widget.php`

Out of scope: any other file, any git operation (no add, commit, reset, stash or
checkout), and any existing story (none renumbered, renamed or deleted).

## Method

1. Locked each file with `bashscripts/lock/lock.sh` before editing.
2. Compared the two sides of every conflict block key by key.
3. Kept the incoming side (the block between `=======` and `>>>>>>>`) in every
   block. In all six files the other side was either empty, a placeholder equal to
   the key or project name (`'label' => 'Missing Label'`, `'authenticate'`,
   `'Benvenuto a <nome progetto>!'`), or an exact duplicate of keys already
   present above the conflict.
4. Expanded one nested inline array that came in with the incoming side
   (`'google' => ['label' => ...]` in `it/auth.php`) to one key per line.
5. Removed the `.lock` markers after editing.

## Per-file decisions

| File | Conflict blocks | Decision |
|------|-----------------|----------|
| `de/auth.php` | 1 | Kept the `forgot-password` block. The other side was empty. |
| `de/login.php` | 1 | Kept `actions.login.throttle`. The other side was empty. |
| `es/auth.php` | 1 | Kept `login-failed`, `user-not-allowed`, `registration-not-enabled`. Dropped the `login_page` and `register_page` copy on the removed side, which was byte-identical to the blocks already above the conflict and would have duplicated keys. |
| `it/auth.php` | 1 | Kept `forgot-password` and `login_widget.providers.google`. The other side was empty. The `google` entry was expanded to one key per line. |
| `it/login.php` | 4 | Kept the real Italian values: `actions.login.throttle`, `actions.authenticate` and `actions.save` (real labels and heroicons instead of `authenticate` and `save` placeholders), `navigation` and `label`/`plural_label` (`Accesso` instead of `Missing ...`), and `page` title/subtitle (`Accedi a FixCity`, without the placeholder `<nome progetto>` and emoji). |
| `it/login_widget.php` | 1 | Kept `fields.email` and `fields.password`. The other side was empty. |

## Verification

Run on 2026-10-21 from `laravel/Modules/User/lang`:

```
php -l de/auth.php        -> No syntax errors detected in de/auth.php
php -l de/login.php       -> No syntax errors detected in de/login.php
php -l es/auth.php        -> No syntax errors detected in es/auth.php
php -l it/auth.php        -> No syntax errors detected in it/auth.php
php -l it/login.php       -> No syntax errors detected in it/login.php
php -l it/login_widget.php -> No syntax errors detected in it/login_widget.php
```

Array load (`require`, `is_array`): de/auth.php (47 top-level keys), de/login.php
(9), es/auth.php (14), it/auth.php (53), it/login.php (19), it/login_widget.php
(1). All return `true`.

Duplicate-key scan (php-parser AST, every array level): 0 duplicates in all six files.

Targeted key check: every key introduced by a conflict block resolves to its real
translation (for example `it/login.php` `actions.authenticate.label` is `Accedi`,
`page.title` is `Accedi a FixCity`; `it/login_widget.php` `fields.email.label` is
`Indirizzo email`). No `Missing` placeholders and no `<nome progetto>` remain.

No conflict markers remain in the six files.

## Notes

- A full recursive key-set diff against `lang/en/` was tried and rejected: the
  locales already differ widely from `en` (for example, de and es carry many keys
  that `en` does not), so the diff is noise rather than a signal for this fix.
- `it/login_widget.php` still contains a pre-existing single-line
  `'remember' => ['label' => 'Ricordami']`. It is not part of the conflict and
  was left unchanged.
- The `.merge_file_*` temporary names in the markers do not identify a branch;
  the choice above is based on the content of each side, not on which side came
  from which branch.
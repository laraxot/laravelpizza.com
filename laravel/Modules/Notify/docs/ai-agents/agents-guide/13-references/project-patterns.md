---
title: "project patterns"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
<<<<<<< .merge_file_MPBD0a
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_CfZxcu
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_MPBD0a
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_CfZxcu
qmd: "project patterns"
issues: []
discussions: []
status: draft
---

# Action Pattern (CRITICAL)

PTVX uses Spatie QueueableAction for business logic.

```php
// CORRECT - Spatie QueueableAction + app() resolution
app(CreateClientAction::class)->execute($data);

// WRONG - constructor DI is forbidden in Actions
public function __construct(private readonly DatabaseManager $db) {}

// WRONG - method must be named execute()
app(MyAction::class)->createPersonalAccessClient();
```

## Key Guidelines

- **Short array syntax (CRITICAL)**: **ALWAYS** `[]`: **NEVER** `array()` in any PHP file.
- **Packages**: Add to `Modules/{Module}/composer.json`, then run `composer go` from `laravel/`.
<<<<<<< HEAD
<<<<<<< .merge_file_MPBD0a
<<<<<<< HEAD
=======
>>>>>>> .merge_file_CfZxcu
- **Git Rules**:
  - NEVER `git remote set-url`: only project owner does this.
  - Git goes forward only: never restore old versions.
=======
<<<<<<< .merge_file_rO33t1
- **Git Rules**: 
  - NEVER `git remote set-url` — only project owner does this.
  - Git goes forward only — never restore old versions.
=======
- **Git Rules**:
<<<<<<< .merge_file_MPBD0a
  - NEVER `git remote set-url`: only project owner does this.
  - Git goes forward only: never restore old versions.
>>>>>>> .merge_file_ZKezpx
>>>>>>> laraxot/dev
=======
- **Git Rules**:
  - NEVER `git remote set-url`: only project owner does this.
  - Git goes forward only: never restore old versions.
=======
  - NEVER `git remote set-url`: only project owner does this.
  - Git goes forward only: never restore old versions.
>>>>>>> .merge_file_ZKezpx
>>>>>>> .merge_file_CfZxcu
>>>>>>> laraxot/dev
  - Every error fix: git commit + GitHub issue + GitHub discussion.

## Session Best Practices

- GitHub Projects CLI needs `read:project` scope: `gh project list --owner provtv` may fail.
- For PHPMD use PHAR only: `bash laravel/tools/phpmd.sh ...` (never composer package).
- Never use `RefreshDatabase`, `migrate:fresh`, or `migrate --force` in tests.
- Central discussion for shared agent learning: `https://github.com/provtv/base_ptv_fila5/discussions/18`

---
[Back to index](../index.md)
[Back to index](../../../index.md)

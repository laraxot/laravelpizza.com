---
title: "agents first rule"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
<<<<<<< .merge_file_iUxhYs
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_tYHAhA
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_iUxhYs
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_tYHAhA
qmd: "agents first rule"
issues: []
discussions: []
---

# Agents first rule: Read → Reason → Study → Update → Improve

<<<<<<< HEAD
> Source: [AGENTS.md](../../AGENTS.md)
> Source: [AGENTS.md](../../AGENTS.md)
=======
<<<<<<< HEAD
<<<<<<< .merge_file_iUxhYs
<<<<<<< HEAD
> Source: [AGENTS.md](../../AGENTS.md)
> Source: [AGENTS.md](../../AGENTS.md)
=======
<<<<<<< HEAD
> Source: [AGENTS.md](../../agents.md)
> Source: [agents.md](../../agents.md)
=======
> Source: [AGENTS.md](../../AGENTS.md)
> Source: [AGENTS.md](../../AGENTS.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
> Source: [AGENTS.md](../../agents.md)
> Source: [agents.md](../../agents.md)
=======
> Source: [AGENTS.md](../../agents.md)
> Source: [agents.md](../../agents.md)
=======
> Source: [AGENTS.md](../../AGENTS.md)
> Source: [AGENTS.md](../../AGENTS.md)
>>>>>>> .merge_file_tYHAhA
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
> Back: [index](index.md) | [workflow.md](workflow.md)

## The fundamental rule

**Before modifying ANY file, always follow this sequence:**

1. **Read** — read the file carefully with the Read tool (mandatory — Edit/Write fail without it)
2. **Reason** — think about context and implications
3. **Study** — study existing code, module patterns, and conventions
4. **Update docs** — update `docs/` folders inside modules and themes
5. **Improve** — only then make changes following project conventions

## Post-edit cycle (mandatory)

After every code edit:
```
RE-READ → PHPStan → PHPMD → PHPInsights → UPDATE DOCS → GIT COMMIT → GITHUB ISSUE → GITHUB DISCUSSION
```

- PHPStan: `./vendor/bin/phpstan analyse Modules/{Module} --level=10` (run from `laravel/`)
- PHPMD: `bash laravel/tools/phpmd.sh laravel text phpmd.xml --exclude vendor,...`
- PHPInsights: `.phar ONLY` — NEVER in `composer.json` require-dev

All errors from all 3 tools MUST be resolved before commit.

## NEVER simplify domain logic

1. **Never remove options** from Selects or Filters
2. **Never delete** `getHeaderActions()` or custom actions
3. **Never replace** `@include` with inline code
4. **Never remove** traits from models
5. **Preserve** array string keys in all schemas

## No Log::debug() in production code

Use `Log::info()`, `Log::warning()`, or `Log::error()` for production logging.

For temporary debugging use `dd()` and **remove before commit**.

See `.cursor/rules/no-log-debug.mdc`.

## PHPMD PHAR-only rule

- NEVER add `phpmd/phpmd` to `composer.json`
- NEVER use `./vendor/bin/phpmd`
- ALWAYS use: `bash laravel/tools/phpmd.sh ...`
- If missing, install with: `bash bashscripts/quality/ensure_phpmd_phar.sh`

## InteractsWithRecord property rule

When a Filament page uses `Filament\Resources\Pages\Concerns\InteractsWithRecord`:
- **Never redeclare** `$record` in the page class
- Use `getRecord()` from the trait
- Add a typed narrowing getter (e.g., `getSpecificRecord(): ModuleModel`) if needed
- Redeclaring `$record` with a narrower type causes a PHP 8.3 fatal trait composition error

## Quality checks after every change

```bash
# PHPStan Level 10 (all errors must be fixed)
php -d memory_limit=2G ./vendor/bin/phpstan analyse

# PHPMD via PHAR
bash bashscripts/quality/ensure_phpmd_phar.sh
bash laravel/tools/phpmd.sh laravel text phpmd.xml --exclude vendor,node_modules,bootstrap,caches

# PHPInsights
./vendor/bin/phpinsights -v --no-interaction
```

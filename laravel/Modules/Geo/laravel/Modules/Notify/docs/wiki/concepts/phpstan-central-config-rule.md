---
title: PHPStan Central Config Rule
type: concept
tags: [phpstan, quality, workflow, governance]
sources: [AGENTS.md]
created: 2026-04-16
updated: 2026-04-16
related: [llm-wiki-governance.md, ../project/qmd-local-docs-search.md]
---

# PHPStan Central Config Rule

## Rule

In this repository, PHPStan analysis must use the shared Laravel root configuration.

Default validation flow:

```bash
cd laravel
./vendor/bin/phpstan analyse
```

If the whole-project run returns too many errors to be actionable, narrow the scope progressively, for example:

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/<ModuleName>
```

Only fall back to module-by-module analysis when the full-project run is too noisy.

Do not run analysis with `--configuration=Modules/<ModuleName>/phpstan.neon.dist`.

Do not modify `laravel/phpstan.neon` during routine module work. It is the central project configuration and must be reused consistently across all modules.

## Reason

- Keeps static analysis behavior consistent across modules.
- Avoids drift between module-local and project-wide PHPStan settings.
- Matches the project workflow explicitly requested by the user: validate the entire project first, then reduce scope only when needed.

## Operational Notes

- Module-local `phpstan.neon.dist` files are not the default execution path for this project workflow.
- If PHPStan fails on a module, fix code or test issues under the shared root config instead of switching configs.
- If a module needs special handling, treat that as an explicit exception, not the default rule.

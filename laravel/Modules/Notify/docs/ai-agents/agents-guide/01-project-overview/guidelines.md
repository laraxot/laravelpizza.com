# Guidelines for Claude/Gemini

- **ALWAYS use short array syntax `[]`** - NEVER use `array()` in PHP files.
- Do not extend Filament classes directly in application modules: use `XotBase*` wrappers.
- Translations must not be hardcoded in Filament components.
- Prefer Actions (e.g. Spatie Queueable Action) over Services - call via `app(ActionClass::class)->execute()`.
- **NEVER use constructor DI** - use `app(ActionClass::class)->execute()` pattern instead.
- Use PHPStan Level 10 approach: "Fix, Don't Ignore" - all errors must be resolved.
- Follow module-per-module workflow: complete one module before moving to the next.
- Use MCP tools when encountering file access limitations.
- **New packages go in module `composer.json`**, never in `laravel/composer.json`. Run `composer go` from `laravel/` to merge.
- **NEVER run `git remote set-url`** - only the project owner does this.
- **Git goes forward only** - never restore old versions. Study git logs, but don't revert.
- **Commit/push are never automatic** - do them only after real end-to-end verification and after `phpstan`, `phpmd`, `phpinsights`, and tests have been run on the scope requested by the user.
- If those quality gates were not run, say so explicitly and do not commit or push.

---
[Back to index](../index.md) | [Overview](project-overview.md) | [Links](links.md)

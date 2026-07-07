# Overview

## Project

PTVX is a modular HR & Performance evaluation system built on Laravel + Filament + Laraxot.

## Non-negotiables (Laraxot)

- Do not extend Filament classes directly in application modules: use `XotBase*` wrappers.
- Translations must not be hardcoded in Filament components.
- Prefer Actions (e.g. Spatie Queueable Action) over Services.
- Use PHPStan Level 10 approach: "Fix, Don't Ignore" - all errors must be resolved.
- Follow module-per-module workflow: complete one module before moving to the next.
- Use MCP tools when encountering file access limitations.

## Where the authoritative docs live

- Project docs: `docs/`
- Module docs: `laravel/Modules/{Module}/docs/`
- MCP configuration: `laravel/.mcp.json`

## Links

- [General docs index](../../docs/README.md)
- [Claude docs index](./context.md)
- [Workflow](./workflow.md)
- [PHPStan](./phpstan.md)
- [Filament](./filament.md)
- [MCP](./mcp.md)

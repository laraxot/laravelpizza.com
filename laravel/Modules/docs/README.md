# Laravel Modules Documentation

This directory routes to the active documentation roots for the Laravel modules in this repository.

## How To Use This Index

- Start here only to choose the module.
- Then open that module's `docs/README.md`.
- Use archive files only when the active docs do not answer the question.

The governing rule for all module docs is in
[docs/project/docs-governance.md](../../../docs/project/docs-governance.md).

## Core Modules

| Module | Role | Docs |
| --- | --- | --- |
| `Xot` | shared base framework, conventions, base classes | [README](../Xot/docs/README.md) |
| `User` | auth, profiles, permissions | [README](../User/docs/README.md) |
| `Tenant` | tenant isolation and tenancy contracts | [README](../Tenant/docs/README.md) |
| `UI` | shared UI components and Filament-facing primitives | [README](../UI/docs/README.md) |
| `Lang` | translations and localization | [README](../Lang/docs/README.md) |
| `Job` | queues and background processing | [README](../Job/docs/README.md) |
| `Media` | uploads and media handling | [README](../Media/docs/README.md) |
| `Notify` | notifications and templates | [README](../Notify/docs/README.md) |
| `Activity` | audit trail and activity logging | [README](../Activity/docs/README.md) |
| `Gdpr` | privacy and GDPR support | [README](../Gdpr/docs/README.md) |

## Domain Modules

| Module | Role | Docs |
| --- | --- | --- |
| `Fixcity` | ticketing and frontoffice reporting flows | [README](../Fixcity/docs/README.md) |
| `Cms` | CMS blocks, content modeling, frontoffice composition | [README](../Cms/docs/README.md) |
| `Blog` | editorial content | [README](../Blog/docs/README.md) |
| `Comment` | comments and moderation | [README](../Comment/docs/README.md) |
| `Rating` | ratings and feedback | [README](../Rating/docs/README.md) |
| `Seo` | metadata and SEO support | [README](../Seo/docs/README.md) |
| `Geo` | geography, addresses, map-related concerns | [README](../Geo/docs/README.md) |
| `AI` | AI integration and MCP-related work | [README](../AI/docs/README.md) |

## Documentation Rules For Modules

- The active documentation home for a module is `laravel/Modules/<Module>/docs/README.md`.
- Never create `lang/lang/` or `_docs/` in a module; see [directory-structure-rules.md](./directory-structure-rules.md).
- Do not create new parallel entry files if `README.md` already exists.
- Prefer links over copied explanations across modules.
- Keep implementation details inside topic files, not inside indexes.
- Treat `app/docs`, `resources/views/docs`, and nested `docs/docs` as non-canonical unless explicitly justified.

## Fast Paths

- Shared project rules: [docs/README.md](../../../docs/README.md)
- Project documentation governance: [docs/project/docs-governance.md](../../../docs/project/docs-governance.md)
- Theme index: [laravel/Themes/docs/README.md](../../Themes/docs/README.md)
- LLM wiki workflow: [docs/wiki/README.md](../../../docs/wiki/README.md)
- Modules note: [llm-wiki.md](./llm-wiki.md)
- Agent rules: [AGENTS.md](../../../AGENTS.md)

## Documentation

- [On-Demand Pattern](./ON-DEMAND-PATTERN.md) — Pattern per caricamento efficiente
- [QMD Setup](./QMD-SETUP.md) — Configurazione ricerca locale
- [Performance](./PERFORMANCE-OPTIMIZATION.md) — Metriche e best practice
- [Project Structure](./PROJECT-STRUCTURE.md) — Directory layout
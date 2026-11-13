---
concept: Project Home
last_updated: 2026-05-20
qmd: "project home, ptvx-project, getting started, overview, module structure"
---

# PTVX LLM Wiki

Welcome to the central knowledge base for the **PTVX** project. This wiki is automatically compiled and maintained by AI agents using the **Karpathy Pattern**.

## Core Modules

- [Xot](../../laravel/Modules/Xot/docs/wiki/): Core framework wrappers and shared utilities.
- [User](../../laravel/Modules/User/docs/wiki/): Identity, authentication, and profiles.
- [Tenant](../../laravel/Modules/Tenant/docs/wiki/): Multi-tenancy and data isolation.
- [UI](../../laravel/Modules/UI/docs/wiki/): Shared Blade and Filament components.
- [Lang](../../laravel/Modules/Lang/docs/wiki/): Internationalization and translation logic.

## Architectural Principles

- [BaseModel Pattern](../../laravel/Modules/Xot/docs/wiki/BaseModel.md): The sacred inheritance chain.
- [Actions Over Services](concepts/actions-over-services.md): Preferred business logic pattern.
- [Database guidelines](rules/database-guidelines.md): Managing connections across modules.
- [Translation standards](rules/translation-standards.md): Automatic localization rules.

## Core Patterns

- [Module Structure](concepts/module-structure.md): Standard organization for all modules.
- [Accessor Auto-Persistence](concepts/accessor-auto-persistence.md): Automatic calculation persistence pattern.
- [Accessor zen level 3](concepts/accessor-zen-level-3.md): Accessor/mutator implementation guide.

## Developer Guide

- [Agents index](agents/INDEX.md): Agent roles and coordination.
- [On-demand pattern](rules/on-demand-pattern.md): How to maintain this wiki.
- [QMD search guide](how-to/qmd-search-guide.md): Searching and indexing documentation.
- [Validation post-edit](rules/validation-post-edit-rule.md): PHPStan, PHPMD, PHPInsights, UI checks.

---

*This wiki is a living document. Every interaction with an AI agent helps it grow and interlink.*

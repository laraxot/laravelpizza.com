# AI Skills Reference - Laraxot Project

## Overview

This project uses AI coding assistant skills across three platforms:
- **Claude Code**: `.claude/commands/` (21 slash commands)
- **Cursor**: `.cursor/skills/` (30 skills)
- **Windsurf**: `.windsurfrules` (per-module rules)

## Claude Code Slash Commands

| Command | Purpose |
|---------|---------|
| `/phpstan-fix` | Fix PHPStan Level 10 errors module-by-module |
| `/module-audit` | Full compliance audit against all standards |
| `/create-action` | Create Spatie QueueableAction |
| `queueable-actions` | Regole operative e testing per Spatie QueueableAction |
| `/create-resource` | Create Filament XotBase resource |
| `/create-model` | Create Eloquent model extending BaseModel |
| `/create-migration` | Create XotBaseMigration |
| `/create-test` | Create PestPHP test |
| `/create-widget` | Create XotBase widget |
| `/create-page` | Create XotBase page |
| `/create-dto` | Create Spatie Laravel Data DTO |
| `/quality-check` | Full pipeline (PHPStan + Pint + PHPMD + Tests) |
| `/xotbase-check` | XotBase extension compliance |
| `/translation-check` | Translation compliance |
| `/update-docs` | Module documentation update |
| `/chart-export` | Chart generation patterns |
| `/limesurvey-query` | LimeSurvey query patterns |
| `/pdf-generate` | PDF generation with embedded charts |
| `/pint-format` | Laravel Pint code formatting |
| `/git-maintenance` | Git cleanup and maintenance |
| `/super-mucca` | Deep analysis "Super Mucca" workflow |
| `/service-provider-check` | Service provider compliance |

## Cursor Skills (30)

Organized by category:

### Code Generation
- `create-action` - Spatie QueueableAction
- `queueable-actions` - QueueableAction rules, chaining, queue fake assertions
- `create-filament-page` - Filament page
- `create-migration` - Database migration
- `create-model` - Eloquent model
- `create-test` - PestPHP test
- `filament-resource` - Filament resource

### Code Quality
- `phpstan-fix` - Fix PHPStan errors
- `phpstan-level10` - PHPStan Level 10 patterns
- `pint-format` - Code formatting
- `pest-testing` - PestPHP patterns
- `xotbase-check` - XotBase compliance
- `translation-check` - Translation compliance
- `module-audit` - Full compliance audit

### Architecture
- `laraxot-filament-rules` - Filament patterns
- `laraxot-model-rules` - Model patterns
- `laraxot-service-provider` - Provider patterns
- `laraxot-testing-pest` - Testing patterns
- `laraxot-translation-files` - Translation patterns
- `never-simplify-domain` - Domain complexity rules

### Workflow
- `git-commit` - Commit conventions
- `git-maintenance` - Git maintenance
- `git-push-pack-repair` - Git pack repair
- `github-releases-workflow` - Release automation
- `larastan-workflow` - Larastan analysis
- `laraxot-docs-workflow` - Documentation workflow
- `laraxot-git-conflicts` - Conflict resolution
- `module-docs` - Module documentation
- `module-roadmap` - Roadmap management
- `module-workspace` - Workspace setup
- `semantic-versioning` - Version management

## Prompt Library

Location: `bashscripts/tools/prompts/`

### System Prompts (Read in Order)
- `00-master-prompt.md` - Main system prompt with role, constraints, and behavioral rules
- `01-architecture-patterns.md` - Universal patterns for models, Filament, Actions, migrations
- `02-workflow-operations.md` - Standard operating procedures from preparation to finalization
- `03-quality-gates.md` - Technical validation standards for PHPStan, PHPMD, Insights, Pint, Tests
- `04-filament-rules.md` - Filament-specific patterns and rules
- `05-phpstan-patterns.md` - PHPStan Level 10 compliance patterns
- `06-testing-standards.md` - Pest testing format and best practices
- `07-documentation-standards.md` - Documentation conventions and structure

### Legacy Prompts (Archived)
Old prompts moved to `archive/legacy/` for reference. Do not use for new work.

### Prompt Philosophy
- **Project-Agnostic**: No specific project names, use placeholders
- **Reusable**: Can be applied to any Laravel/modular project
- **Contract-Based**: Clear rules, explicit constraints
- **Structured**: Visual separation with clear sections
- **Quality-Focused**: Emphasize type safety and testing
- **Documentation-First**: Documentation is memory, not afterthought

### Reading Order
For comprehensive understanding, read in this order:
1. `00-master-prompt.md` - Understand the framework
2. `01-architecture-patterns.md` - Learn the patterns
3. `02-workflow-operations.md` - Follow the workflow
4. `03-quality-gates.md` - Meet quality standards
5. Specialized prompts as needed

## Chaos Monkey Skill

- `chaos-monkey-response` - Incident triage and recovery workflow for randomized breakages across CMS/theme/lang/tenant/xot layers.
- Use together with package matrix: `./package-risk-matrix-2026-03-02.md`

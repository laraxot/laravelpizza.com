# laravel-specialist skill installation - 2026-03-02

## Skill installed

**Package**: `jeffallan/claude-skills`
**Skill**: `laravel-specialist`
**Author**: https://github.com/Jeffallan

## What this skill provides

The `laravel-specialist` skill gives Claude deep Laravel expertise as a senior PHP engineer with 10+ years of Laravel experience. It activates when working with:

- Laravel 10+ applications
- Eloquent ORM, relationships, scopes
- RESTful APIs with API resources
- Queue systems, jobs, Horizon
- Livewire reactive components
- Sanctum/Passport authentication
- Performance and query optimization
- Pest/PHPUnit testing

## Files installed

```
laravel/.ai/skills/laravel-specialist/
├── SKILL.md              # Role definition and workflow
└── references/
    ├── eloquent.md       # Eloquent patterns, relationships, scopes, N+1 avoidance
    ├── routing.md        # Routes, controllers, middleware, API resources
    ├── queues.md         # Jobs, workers, Horizon, failed jobs, batching
    ├── livewire.md       # Components, wire:model, actions, real-time
    └── testing.md        # Feature tests, factories, mocking, Pest PHP
```

The CLAUDE.md also gained a `laravel-specialist` entry in the skills activation section.

## Installation command

```bash
cd laravel
php artisan boost:add-skill jeffallan/claude-skills --skill laravel-specialist
```

Note: Run from within `laravel/` directory, not from project root.

## Relevance to the AI module

This skill is directly relevant to AI module development:
- Eloquent models for AI request/response storage
- Queue system for async AI processing
- API resources for AI result formatting
- Testing patterns for AI service stubs and mocks

## Errors fixed before installation

Before the skill could be installed, three blocking errors were resolved:

1. **Stale bootstrap cache** - `services.php`, `packages.php` and `modules.php` contained references to removed packages. Fixed by deleting cache files.

2. **GdprServiceProvider fatal error** - Duplicate `use function Safe\realpath;` statement caused PHP fatal error. Fixed by removing both duplicate lines.

3. **Working directory issue** - Command must be run from `laravel/` directory, not project root.

See `Modules/Xot/docs/bootstrap-cache-stale-fix.md` and `Modules/Gdpr/docs/provider-fix-2026-03-02.md` for details.

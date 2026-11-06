---
title: "10000-phpstan-modules-fix.story.md"
type: story
status: draft
updated: 2026-10-20
tags: [docs, xot, bmad]
qmd: "10000-phpstan-modules-fix.story.md xot"
---
# 10000-phpstan-modules-fix.story.md

## Overview
BMAD Story for PHPStan analysis and fix of all reported errors in `Modules` directory. Total errors: 154 (as of 2026-03-02).

## Scope
- Fix all PHPStan Level 10 errors across all modules
- Maintain module artifact parity
- Improve documentation organization
- Update prompts and second brain
- Use swarm + subagents in random order
- Always work in BMAD phase

## Workflow
1. **Plan** - Create task list and assign subagents
2. **Execute** - Run PHPStan, analyze errors, fix in parallel
3. **Verify** - Run PHPStan again, check docs, verify fixes
4. **Document** - Update stories, docs, prompts, second brain
5. **Close** - Mark task complete with verification

## Subagents Plan
- **scout**: Rapid error exploration and module mapping
- **reviewer**: Code quality assessment for each fix
- **security-reviewer**: Security implications of fixes
- **task**: Parallel execution of fixes on specific modules

## Acceptance Criteria
- PHPStan reports 0 errors after fixes
- All module docs are properly organized
- Prompts in `bashscripts/docs/prompts/` are updated/improved
- Second brain (`docs/wiki/memories/`) is updated with new learnings
- All changes are documented in appropriate stories

## Dependencies
- PHPStan configuration (`phpstan.neon`) is correct
- All modules are accessible
- Subagents can access `Modules/` directory
- Second brain memory is accessible

## Notes
- Fixes must be done in random order (not sequential)
- Use swarm coordination via task subagents
- Always consult second brain for design patterns
- Update `docs/wiki/log.md` with major changes
- Ensure no breaking changes to module functionality
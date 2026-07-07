# AI Agents Documentation Index

**Project**: FixCity Platform  
**Purpose**: Centralized documentation for all AI assistant configurations  
**Last Updated**: 2026-04-11  

---

## Overview

This directory contains split documentation files for AI assistants used in the FixCity project. Each file is focused on a specific area to improve readability and maintainability.

**Original Files** (kept for backward compatibility):
- [`AGENTS.md`](../../../../AGENTS.md) — 5349 lines, comprehensive BMad agents + tasks
- [`docs/CLAUDE.md`](../../../../docs/CLAUDE.md) — 833 lines, Laravel Boost guidelines
- [`QWEN.md`](../../../../QWEN.md) — 47 lines, Qwen output language rules
- [`laravel/GEMINI.md`](../../../../laravel/GEMINI.md) — 581 lines, Gemini-specific rules

---

## BMad Agents

| Agent | ID | File | Lines |
|-------|----|----|----|
| UX Expert | ux-expert | [agents/ux-expert.md](agents/ux-expert.md) | ~66 |
| Scrum Master | sm | [agents/scrum-master.md](agents/scrum-master.md) | ~62 |
| Test Architect & QA Advisor | qa | [agents/test-architect.md](agents/test-architect.md) | ~84 |
| Product Owner | po | [agents/product-owner.md](agents/product-owner.md) | ~76 |
| Product Manager | pm | [agents/product-manager.md](agents/product-manager.md) | ~81 |
| Full Stack Developer | dev | [agents/full-stack-developer.md](agents/full-stack-developer.md) | ~78 |
| BMad Master Orchestrator | bmad-orchestrator | [agents/bmad-orchestrator.md](agents/bmad-orchestrator.md) | ~144 |
| BMad Master Task Executor | bmad-master | [agents/bmad-master.md](agents/bmad-master.md) | ~107 |
| Architect | architect | [agents/architect.md](agents/architect.md) | ~82 |
| Business Analyst | analyst | [agents/business-analyst.md](agents/business-analyst.md) | ~85 |

**See Also**: [BMad Agents Directory](agents/)

---

## BMad Tasks

| Task | File | Lines |
|------|----|----|
| validate-next-story | [tasks/validate-next-story.md](tasks/validate-next-story.md) | ~143 |
| trace-requirements | [tasks/trace-requirements.md](tasks/trace-requirements.md) | ~273 |
| test-design | [tasks/test-design.md](tasks/test-design.md) | ~183 |
| shard-doc | [tasks/shard-doc.md](tasks/shard-doc.md) | ~194 |
| risk-profile | [tasks/risk-profile.md](tasks/risk-profile.md) | ~362 |
| review-story | [tasks/review-story.md](tasks/review-story.md) | ~323 |
| qa-gate | [tasks/qa-gate.md](tasks/qa-gate.md) | ~170 |
| nfr-assess | [tasks/nfr-assess.md](tasks/nfr-assess.md) | ~352 |
| kb-mode-interaction | [tasks/kb-mode-interaction.md](tasks/kb-mode-interaction.md) | ~84 |
| index-docs | [tasks/index-docs.md](tasks/index-docs.md) | ~182 |
| generate-ai-frontend-prompt | [tasks/generate-ai-frontend-prompt.md](tasks/generate-ai-frontend-prompt.md) | ~60 |
| facilitate-brainstorming-session | [tasks/facilitate-brainstorming-session.md](tasks/facilitate-brainstorming-session.md) | ~145 |
| execute-checklist | [tasks/execute-checklist.md](tasks/execute-checklist.md) | ~95 |
| document-project | [tasks/document-project.md](tasks/document-project.md) | ~352 |
| create-next-story | [tasks/create-next-story.md](tasks/create-next-story.md) | ~121 |
| create-doc | [tasks/create-doc.md](tasks/create-doc.md) | ~110 |
| create-deep-research-prompt | [tasks/create-deep-research-prompt.md](tasks/create-deep-research-prompt.md) | ~287 |
| create-brownfield-story | [tasks/create-brownfield-story.md](tasks/create-brownfield-story.md) | ~321 |
| correct-course | [tasks/correct-course.md](tasks/correct-course.md) | ~79 |
| brownfield-create-story | [tasks/brownfield-create-story.md](tasks/brownfield-create-story.md) | ~155 |
| brownfield-create-epic | [tasks/brownfield-create-epic.md](tasks/brownfield-create-epic.md) | ~169 |
| apply-qa-fixes | [tasks/apply-qa-fixes.md](tasks/apply-qa-fixes.md) | ~157 |
| advanced-elicitation | [tasks/advanced-elicitation.md](tasks/advanced-elicitation.md) | ~127 |

**See Also**: [BMad Tasks Directory](tasks/)

---

## Laravel Boost (CLAUDE.md)

Split from [`docs/CLAUDE.md`](../../../../docs/CLAUDE.md):

| Section | File | Lines |
|---------|----|----|
| Foundation Rules | [claude/foundation-rules.md](claude/foundation-rules.md) | ~50 |
| Boost Rules | [claude/boost-rules.md](claude/boost-rules.md) | ~80 |
| PHP Rules | [claude/php-rules.md](claude/php-rules.md) | ~60 |
| Filament Rules | [claude/filament-rules.md](claude/filament-rules.md) | ~120 |
| Folio Rules | [claude/folio-rules.md](claude/folio-rules.md) | ~60 |
| Laravel Core Rules | [claude/laravel-core-rules.md](claude/laravel-core-rules.md) | ~100 |
| Livewire/Volt Rules | [claude/livewire-volt-rules.md](claude/livewire-volt-rules.md) | ~120 |
| Pest Testing Rules | [claude/pest-testing-rules.md](claude/pest-testing-rules.md) | ~80 |
| Tailwind Rules | [claude/tailwind-rules.md](claude/tailwind-rules.md) | ~40 |
| Theme Build Rules | [claude/theme-build-rules.md](claude/theme-build-rules.md) | ~40 |
| Project Architecture | [claude/project-architecture.md](claude/project-architecture.md) | ~80 |

**See Also**: [CLAUDE Directory](claude/)

---

## Gemini Rules

Split from [`laravel/GEMINI.md`](../../../../laravel/GEMINI.md):

| Section | File | Lines |
|---------|----|----|
| Gemini Core Rules | [gemini/core-rules.md](gemini/core-rules.md) | ~200 |
| Gemini Project Context | [gemini/project-context.md](gemini/project-context.md) | ~200 |
| Gemini Development Rules | [gemini/development-rules.md](gemini/development-rules.md) | ~180 |

**See Also**: [GEMINI Directory](gemini/)

---

## Qwen Rules

| File | Lines | Notes |
|----|----|----|
| [QWEN.md](../../../../QWEN.md) | 47 | Too small to split — kept as single file |

---

## Cross-References

### Related Documentation
- [BMad Method Setup](../../docs/bmad/setup-guide.md)
- [Project Configuration](../../docs/project/configuration.md)
- [Module Docs Index](../../docs/modules/index.md)
- [Theme Docs Index](../../docs/themes/index.md)
- [AI Workflow](../../docs/project/ai-workflow/)

### Bidirectional Links
- ← Back to [Project Root](../../)
- ← Back to [Docs Index](../../docs/README.md)
- ← Back to [AGENTS.md](../../../../AGENTS.md) (original)
- ← Back to [CLAUDE.md](../../../../docs/CLAUDE.md) (original)
- ← Back to [GEMINI.md](../../../../laravel/GEMINI.md) (original)
- ← Back to [QWEN.md](../../../../QWEN.md) (original)

---

## Maintenance

### Adding New Split Files
1. Create file in appropriate subdirectory (`agents/`, `tasks/`, `claude/`, `gemini/`)
2. Add entry to this INDEX.md table
3. Add bidirectional link back to this INDEX.md
4. Update original file to reference split version

### Updating Split Files
1. Update the split file
2. Update line count in this INDEX.md
3. Add changelog entry below

### Changelog
| Date | Change | Author |
|------|--------|--------|
| 2026-04-11 | Initial split of AGENTS.md, CLAUDE.md, GEMINI.md | Qwen |

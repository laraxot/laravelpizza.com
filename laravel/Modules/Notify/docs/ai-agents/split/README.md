---
title: "AI Assistant Documentation"
type: index
tags: [notify, docs, ai-agents, split]
module: Notify
created: 2026-07-20
updated: 2026-11-23
qmd: "notify documentazione ai agents split readme ai assistant documentation index readme frontmatter qmd search"
issues:
  - "https://github.com/laraxot/module_notify_fila5/issues/56"
discussions:
  - "https://github.com/laraxot/module_notify_fila5/discussions/57"
related:
  - ../../README.md
  - ../../wiki/index.md
  - ../../notifications/README.md
  - ../../integrations/README.md
  - ../../templates/README.md
status: draft
---
# AI Assistant Documentation

**Purpose**: Centralized documentation for all AI assistants used in the FixCity project  
**Purpose**: Centralized documentation for all AI assistants used in the Notify project  
**Last Updated**: 2026-04-11  

---

## Quick Access

| Assistant | Original File | Split Files | Index |
|-----------|--------------|----|----|
| BMad Agents | [AGENTS.md](../../../AGENTS.md) | 32 files | [agents/index.md](agents/index.md) + [tasks/index.md](tasks/index.md) |
| Claude/Laravel Boost | [CLAUDE.md](../../claude.md) | 21 files | [claude/index.md](claude/index.md) |
| Gemini | [gemini.md](../../../laravel/gemini.md) | 14 files | [gemini/index.md](gemini/index.md) |
| BMad Agents | [AGENTS.md](../../../AGENTS.md) | 32 files | [agents/index.md](agents/index.md) + [tasks/index.md](tasks/index.md) |
| Claude/Laravel Boost | [CLAUDE.md](../../claude.md) | 21 files | [claude/index.md](claude/index.md) |
| Gemini | [gemini.md](../../../laravel/gemini.md) | 14 files | [gemini/index.md](gemini/index.md) |
| Qwen | [qwen.md](../../../qwen.md) | 1 file (no split needed) |: |
| BMad Agents | [AGENTS.md](../../agents.md) | 32 files | [agents/index.md](agents/index.md) + [tasks/index.md](tasks/index.md) |
| Claude/Laravel Boost | [CLAUDE.md](../../claude.md) | 21 files | [claude/index.md](claude/index.md) |
| Gemini | [gemini.md](../../../../../gemini.md) | 14 files | [gemini/index.md](gemini/index.md) |
| BMad Agents | [AGENTS.md](../../agents.md) | 32 files | [agents/index.md](agents/index.md) + [tasks/index.md](tasks/index.md) |
| Claude/Laravel Boost | [CLAUDE.md](../../claude.md) | 21 files | [claude/index.md](claude/index.md) |
| Gemini | [gemini.md](../../../../../gemini.md) | 14 files | [gemini/index.md](gemini/index.md) |
| Qwen | [qwen.md](../../qwen.md) | 1 file (no split needed) |: |

**Total**: 68 split files across 4 assistants

---

## Directory Structure

```
.agents/docs/
├── index.md                    ← Master index (this is referenced by all)
├── README.md                   ← This file
├── agents/                     ← 10 BMad agent definitions
│   ├── index.md
│   ├── ux-expert.md
│   ├── scrum-master.md
│   ├── test-architect.md
│   ├── product-owner.md
│   ├── product-manager.md
│   ├── full-stack-developer.md
│   ├── bmad-orchestrator.md
│   ├── bmad-master.md
│   ├── architect.md
│   └── business-analyst.md
├── tasks/                      ← 22 BMad task definitions
│   ├── index.md
│   ├── index.md
│   ├── validate-next-story.md
│   ├── trace-requirements.md
│   ├── ... (20 more)
├── claude/                     ← 20 Laravel Boost sections
│   ├── index.md
│   ├── index.md
│   ├── foundation-rules.md
│   ├── boost-rules.md
│   ├── ... (18 more)
├── gemini/                     ← 13 Gemini sections
│   ├── index.md
│   ├── index.md
│   ├── boost-integration.md
│   ├── foundation-rules.md
│   ├── ... (11 more)
└── qwen/                       ← Qwen rules (no split needed)
    └── (referenced from ../../../qwen.md)
```

---

## Why Split?

The original files were very large:
- **AGENTS.md**: 5,349 lines → 32 focused files
- **CLAUDE.md**: 833 lines → 21 focused files
- **gemini.md**: 581 lines → 14 focused files

Splitting improves:
- **Readability**: Each file focuses on one topic
- **Maintainability**: Easier to update individual sections
- **AI Context**: AI assistants can load only relevant sections
- **Navigation**: Clear index files with bidirectional links

---

## Cross-References

### Bidirectional Links
Every split file contains links back to:
- Its section index (e.g., `agents/index.md`)
<<<<<<< HEAD
- Its section index (e.g., `agents/index.md`)
=======
<<<<<<< HEAD
- Its section index (e.g., `agents/index.md`)
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
- The master index (`index.md`)
- The original source file

### Related Documentation
- [BMad Method Setup](../../bmad/setup-guide.md)
- [Project Configuration](../../docs/project/configuration.md)
- [Module Docs Index](../../docs/modules/index.md)
- [BMad Method Setup](../../bmad/setup-guide.md)
- [Project Configuration](../../project/configuration.md)
- [Module Docs Index](../../modules/index.md)
- [AI Workflow](../../docs/project/ai-workflow/)

---

## Maintenance

### Adding New Split Files
1. Create file in appropriate subdirectory
2. Add entry to the section index.md
3. Add bidirectional link back to index.md
4. Update master index.md if needed

### Updating Split Files
1. Update the split file
2. Update line count in section index.md
3. Add changelog entry to master index.md

### Changelog
| Date | Change | Author |
|------|--------|--------|
| 2026-04-11 | Initial split of AGENTS.md, CLAUDE.md, gemini.md | Qwen |
| 2026-04-11 | Initial split of AGENTS.md, CLAUDE.md, gemini.md | Qwen |

---

**Maintained By**: AI Agents + Development Team

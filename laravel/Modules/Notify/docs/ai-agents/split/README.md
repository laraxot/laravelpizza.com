# AI Assistant Documentation

**Purpose**: Centralized documentation for all AI assistants used in the FixCity project  
**Last Updated**: 2026-04-11  

---

## Quick Access

| Assistant | Original File | Split Files | Index |
|-----------|--------------|----|----|
| BMad Agents | [AGENTS.md](../../../AGENTS.md) | 32 files | [agents/INDEX.md](agents/INDEX.md) + [tasks/INDEX.md](tasks/INDEX.md) |
| Claude/Laravel Boost | [CLAUDE.md](../../../docs/CLAUDE.md) | 21 files | [claude/INDEX.md](claude/INDEX.md) |
| Gemini | [GEMINI.md](../../../laravel/GEMINI.md) | 14 files | [gemini/INDEX.md](gemini/INDEX.md) |
| Qwen | [QWEN.md](../../../QWEN.md) | 1 file (no split needed) | — |

**Total**: 68 split files across 4 assistants

---

## Directory Structure

```
.agents/docs/
├── INDEX.md                    ← Master index (this is referenced by all)
├── README.md                   ← This file
├── agents/                     ← 10 BMad agent definitions
│   ├── INDEX.md
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
│   ├── INDEX.md
│   ├── validate-next-story.md
│   ├── trace-requirements.md
│   ├── ... (20 more)
├── claude/                     ← 20 Laravel Boost sections
│   ├── INDEX.md
│   ├── foundation-rules.md
│   ├── boost-rules.md
│   ├── ... (18 more)
├── gemini/                     ← 13 Gemini sections
│   ├── INDEX.md
│   ├── boost-integration.md
│   ├── foundation-rules.md
│   ├── ... (11 more)
└── qwen/                       ← Qwen rules (no split needed)
    └── (referenced from ../../../QWEN.md)
```

---

## Why Split?

The original files were very large:
- **AGENTS.md**: 5,349 lines → 32 focused files
- **CLAUDE.md**: 833 lines → 21 focused files
- **GEMINI.md**: 581 lines → 14 focused files

Splitting improves:
- **Readability**: Each file focuses on one topic
- **Maintainability**: Easier to update individual sections
- **AI Context**: AI assistants can load only relevant sections
- **Navigation**: Clear index files with bidirectional links

---

## Cross-References

### Bidirectional Links
Every split file contains links back to:
- Its section index (e.g., `agents/INDEX.md`)
- The master index (`INDEX.md`)
- The original source file

### Related Documentation
- [BMad Method Setup](../../docs/bmad/setup-guide.md)
- [Project Configuration](../../docs/project/configuration.md)
- [Module Docs Index](../../docs/modules/index.md)
- [AI Workflow](../../docs/project/ai-workflow/)

---

## Maintenance

### Adding New Split Files
1. Create file in appropriate subdirectory
2. Add entry to the section INDEX.md
3. Add bidirectional link back to INDEX.md
4. Update master INDEX.md if needed

### Updating Split Files
1. Update the split file
2. Update line count in section INDEX.md
3. Add changelog entry to master INDEX.md

### Changelog
| Date | Change | Author |
|------|--------|--------|
| 2026-04-11 | Initial split of AGENTS.md, CLAUDE.md, GEMINI.md | Qwen |

---

**Maintained By**: AI Agents + Development Team

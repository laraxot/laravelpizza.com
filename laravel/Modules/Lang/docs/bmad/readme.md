---
qmd: "lang bmad readme md"
bmad: true
module: Lang
---
# Lang Module — Documentation

Complete translation and localization management system for Laravel applications.

## Structure (BMAD)

```
docs/
├── README.md                    # This file
├── 00-index.md                 # Documentation index
├── README-en.md                # English version
├── bmad/                        # BMAD — architecture & decisions
│   ├── architecture/           # Design specs & rules
│   │   ├── core-architecture.md
│   │   ├── api-reference.md
│   │   ├── rules.md
│   │   ├── module-architecture-legacy.md
│   │   ├── autolabel-flow-complete.md
│   │   ├── translation-structure-expanded.md
│   │   └── translation-field-structure-complete.md
│   ├── stories/                # BMAD story tracking
│   ├── epics/                  # Epic roadmap
│   ├── brainstorming/          # Brainstorming artifacts
│   ├── decision-log.md         # Decision history
│   ├── bugfix/                 # Bug fixes & analysis
│   ├── ../wiki/analysis-results.md     # Analysis findings
│   ├── code-quality-report.md  # Quality gates
│   ├── code-quality-improvement-report.md
│   ├── code-redundancy-audit.md
│   ├── ../coverage.md
│   ├── database-model-coverage.md
│   └── ../wiki/bottlenecks.md
├── wiki/                        # Knowledge & patterns
│   ├── how-to/                 # Implementation guides
│   ├── reference/              # Language patterns & concepts
│   ├── rules/                  # Local rules & constraints
│   ├── memories/               # Agent protocols & methodologies
│   ├── product/                # Product specs & purpose
│   ├── overviews/              # Business logic overviews
│   ├── skills/                 # Skills & tool references
│   ├── commands/               # Command reference
│   ├── concepts/               # Concepts & terminology
│   └── index.md                # Wiki navigation
├── bugfix/                      # Bug reports & fixes
├── best-practices/             # Legacy best practices
└── [other]/                    # Raw research, screenshots, tasks
```

## Key Categories

### BMAD: Architecture & Decisions
- **bmad/architecture/**: Core design, rules, API contract
- **bmad/stories/**: Epic tracking & backlog
- **bmad/decision-log.md**: All architectural decisions

### Wiki: Knowledge Base
- **wiki/how-to/**: Implementation guides (language switching, automatic translations, etc.)
- **wiki/reference/**: Language patterns (case sensitivity, translation errors, etc.)
- **wiki/rules/**: Local constraints & rules
- **wiki/memories/**: Agent protocols (confidence, edit discipline, AI methodologies)

## Quick Start

1. **Understanding the module**: Read `00-index.md` and `wiki/product/purpose.md`
2. **Architecture overview**: Start with `bmad/architecture/core-architecture.md`
3. **How to implement**: Browse `wiki/how-to/` for practical guides
4. **Understanding patterns**: See `wiki/reference/` for language-specific concepts

## Consolidation Status (2026-10-06)

✓ Removed 13 duplicate files (case variants, outdated versions)
✓ Reorganized 37 orphaned files into BMAD structure
✓ Cleaned up legacy directories
✓ Total: 87 documented artifacts, zero orphans

---
Last updated: 2026-10-06 by Claude Haiku 4.5 (BMAD consolidation task)

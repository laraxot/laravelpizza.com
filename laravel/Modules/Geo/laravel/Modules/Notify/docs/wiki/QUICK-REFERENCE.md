# LLM Wiki Quick Reference

> **Based on**: Karpathy's LLM Wiki pattern
> **Purpose**: Quick reference for daily wiki operations

## Directory Structure

```
docs/
├── raw/              # IMMUTABLE sources (never modify)
│   ├── articles/     # Web articles
│   ├── papers/       # Academic papers
│   └── data/         # Structured data
│
└── wiki/             # LLM-generated knowledge
    ├── concepts/     # Topic pages
    ├── entities/     # People/orgs/modules
    ├── sources/      # Source summaries
    ├── comparisons/  # Analysis pages
    ├── decisions/    # Architecture decisions
    ├── index.md      # Content catalog
    ├── log.md        # Activity log
    └── overview.md   # High-level synthesis
```

## Common Commands

### Ingest a Source

```
User: "ingest docs/raw/articles/filename.md"

What happens:
1. LLM reads source from raw/
2. Extracts concepts, entities, data
3. Creates/updates wiki pages
4. Updates index.md and log.md
5. Commits changes
```

### Query the Wiki

```
User: "How does {concept} work?"

What happens:
1. LLM searches index.md
2. Reads relevant wiki pages
3. Synthesizes answer with citations
4. Creates new pages for valuable insights
```

### Lint the Wiki

```
User: "lint wiki"

What happens:
1. Scans for contradictions
2. Finds orphan pages
3. Identifies stale claims
4. Reports findings
5. Applies fixes (if approved)
```

## Frontmatter Schema

```yaml
---
title: "Page Title"                    # Required
type: concept|entity|source|comparison|decision|troubleshooting  # Required
sources: ["raw/articles/file.md"]      # Required (array)
confidence: high|medium|low            # Required
created: 2026-04-15                    # Required (ISO date)
updated: 2026-04-15                    # Required (ISO date)
tags: [tag1, tag2]                     # Required (array)
related:                               # Optional (array of paths)
  - concepts/related.md
  - entities/entity.md
---
```

## Naming Conventions

- **Filenames**: lowercase-kebab-case.md
  - ✅ `lmsr-mechanics.md`
  - ❌ `LMSR_Mechanics.md`
- **Directories**: lowercase
  - ✅ `concepts/`, `entities/`
- **Titles**: Title Case
  - ✅ `title: "LMSR Market Mechanics"`

## Page Types

| Type | Directory | Purpose |
|------|-----------|---------|
| `concept` | `wiki/concepts/` | Topic/theme explanations |
| `entity` | `wiki/entities/` | People, orgs, modules |
| `source` | `wiki/sources/` | Individual source summaries |
| `comparison` | `wiki/comparisons/` | Cross-source analysis |
| `decision` | `wiki/decisions/` | Architecture decision records |
| `troubleshooting` | `wiki/troubleshooting/` | Bug fixes, error resolutions |

## Rules

1. **raw/ is READ-ONLY** - Never modify files in raw/
2. **All pages use frontmatter** - Follow schema exactly
3. **DRY knowledge** - One concept = one page, no duplication
4. **Link heavily** - 3+ incoming links, 3+ outgoing links per page
5. **Atomic commits** - One ingestion = one commit
6. **Cite sources** - Always cite specific wiki pages in answers

## Setup Commands

### Initialize Module Wiki

```bash
bashscripts/ai/init-llm-wiki.sh module Fixcity
bashscripts/ai/init-llm-wiki.sh theme Sixteen
```

### Install qmd Search

```bash
npm install -g qmd
qmd serve ./docs/wiki
```

### Configure Obsidian

1. Open Obsidian → "Open folder as vault"
2. Select: `/var/www/_bases/base_fixcity_fila5/docs`
3. Configuration already in `.obsidian/`

## Quality Checklist

### Before Committing

- [ ] Frontmatter schema valid
- [ ] Filename lowercase-kebab-case.md
- [ ] Page has 1+ outgoing links
- [ ] index.md updated (if new page)
- [ ] log.md updated (if ingestion)
- [ ] No content duplication
- [ ] Commit message: `docs: {action} {description}`

### After Ingestion

- [ ] All concepts extracted
- [ ] Source summary created
- [ ] Cross-references added
- [ ] index.md updated
- [ ] log.md updated
- [ ] Committed and pushed

## Templates Location

- Project wiki: `docs/wiki/_templates/`
- Module wiki: `Modules/{Name}/docs/llm-wiki/_templates/`

Templates available:
- `concept.md` - For concept pages
- `entity.md` - For entity pages
- `source.md` - For source summaries
- `comparison.md` - For comparison pages

## Related Documentation

- [Complete Integration Guide](wiki/README.md)
- [Agent Instructions](wiki/AGENTS.md)
- [Wiki Overview](wiki/overview.md)
- [Obsidian Setup](.obsidian/README.md)
- [Module Wiki Guide](Modules/Xot/docs/llm-wiki-integration.md)

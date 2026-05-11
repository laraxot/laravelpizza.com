# Cms {{TYPE^}} LLM Wiki Agent Instructions

> **Module/Theme:** Cms
> **Scope:** Cms-specific knowledge only
> **Created:** 2026-04-15
> **Based on:** Karpathy's LLM Wiki pattern

## Role

You are the **Cms Wiki Maintainer**. Your job is to:
1. Ingest raw sources into structured wiki pages
2. Answer queries by synthesizing wiki content with citations
3. Lint wiki for consistency (resolve contradictions, orphans, stale claims)

## Directory Rules

- **raw/** = READ-ONLY (curated sources, NEVER modify)
- **llm-wiki/** = WRITE-ALLOWED (LLM-generated knowledge)
- All pages MUST use YAML frontmatter schema

## Frontmatter Schema

```yaml
---
title: "Page Title"
type: concept|entity|source|comparison|decision|troubleshooting
sources: ["raw/articles/filename.md"]
confidence: high|medium|low
created: YYYY-MM-DD
updated: YYYY-MM-DD
tags: [tag1, tag2]
related:
  - concepts/related.md
---
```

## Naming Conventions

- **Filenames**: lowercase-kebab-case.md
- **Directories**: lowercase
- **Titles**: Title Case

## Strict Rules

### Rule 1: raw/ is IMMUTABLE
- NEVER modify files in raw/ after placement
- NEVER delete files from raw/ (use Git for history)
- ONLY read from raw/ during ingestion

### Rule 2: DRY Knowledge
- ONE concept = ONE page (no duplication)
- Cross-reference via links, don't copy-paste
- Link to project wiki for cross-module concepts

### Rule 3: Link Heavily
- Every page MUST have 3+ incoming links
- Every page MUST have 3+ outgoing links
- Use wikilinks: `[[concepts/page]]`

### Rule 4: Atomic Commits
- One ingestion = one commit
- Message format: `docs: {action} {description}`

## When to Use Module Wiki vs Project Wiki

### Create Module Page If:
- Concept is unique to Cms
- Pattern is Cms-specific
- Decision only affects Cms

### Reference Project Wiki (`../../docs/wiki/`) If:
- Concept spans multiple modules
- Pattern is project-wide (e.g., Actions over Services)
- Decision affects architecture globally

## Workflows

### Ingest

```
User: "ingest {path-to-raw-file}"

Steps:
1. Read source from raw/
2. Extract key concepts, entities, data
3. Create/update wiki pages
4. Update index.md and log.md
5. Commit changes
```

### Query

```
User: Ask a question

Steps:
1. Search index.md for relevant categories
2. Read matching wiki pages
3. Synthesize answer with explicit citations
4. Create new pages for high-value insights
```

### Lint

```
User: "lint wiki"

Steps:
1. Scan for contradictions, orphans, stale claims
2. Report findings with file paths
3. Suggest and apply fixes
4. Commit changes
```

## Cross-Linking to Project Wiki

When referencing project-wide concepts:

```markdown
Related:
- Project-wide: [[../../docs/wiki/concepts/laraxot-architecture]]
- Module-specific: [[concepts/module-concept]]
```

## Quality Checklist

### Before Committing
- [ ] Frontmatter schema is valid
- [ ] Filename is lowercase-kebab-case.md
- [ ] Page has at least 1 outgoing link
- [ ] index.md is updated (if new page)
- [ ] log.md is updated (if ingestion)
- [ ] No content duplication (DRY)
- [ ] Commit message: `docs: {action} {description}`

## Related Documentation

- [Project Wiki Integration](../../docs/wiki/README.md)
- [Project Wiki Agent Instructions](../../docs/wiki/AGENTS.md)
- [Module Documentation](../README.md)

# Cms Module LLM Wiki Agent Instructions

> **Module/Theme:** Cms
> **Scope:** Cms-specific knowledge only
> **Created:** 2026-04-28
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
created: 2026-04-28
updated: 2026-04-28
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

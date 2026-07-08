---
title: "Wiki Overview"
module: "Media"
type: overview
created: "2026-04-15T08:28:44Z"
updated: "2026-04-15T08:28:44Z"
---

# Media Wiki Overview

> **Based on:** Andrej Karpathy's LLM Knowledge Base pattern  
> **Created:** 2026-04-15T08:28:44Z

## What This Wiki Is

This is a **self-maintaining knowledge base** for the Media module. AI agents ingest raw documents, synthesize wiki pages, and keep everything organized.

## How to Use

### For Humans

1. **Drop raw documents** in `raw/articles/`, `raw/code-examples/`, etc.
2. **Tell AI:** "Ingest docs/raw/articles/{filename}"
3. **Ask questions:** "Based on the wiki, how does {feature} work?"
4. **Search:** `qmd search "your question"` (in docs/ folder)

### For AI Agents

1. **Read** `wiki/index.md` for overview
2. **Ingest** raw documents → create wiki pages with YAML frontmatter
3. **Update** `wiki/index.md` and `wiki/log.md` after each operation
4. **Link** related pages in frontmatter `related:` field
5. **Commit** after each ingest/query/lint

## Structure

```
docs/
├── wiki/           # LLM-generated knowledge
│   ├── index.md    # Content catalog
│   ├── log.md      # Activity log
│   ├── overview.md # This file
│   ├── concepts/   # Topics and themes
│   ├── entities/   # People, orgs, models
│   ├── sources/    # Raw file summaries
│   └── comparisons/# Synthesized analyses
├── raw/            # Immutable source material
│   ├── articles/
│   ├── papers/
│   ├── code-examples/
│   └── decisions/
└── schema.md       # Module-specific schema
```

## Quick Stats

- **Wiki Pages:** 0
- **Raw Sources:** 0
- **Last Ingest:** None
- **Last Query:** None
- **Last Lint:** None

---

**Status:** 🟢 Initialized, ready for ingest  
**Maintained By:** All AI agents working on Media

---
title: "Module Schema"
module: "Activity"
created: "2026-04-15T08:28:40Z"
---

# Activity Module Schema

> **Purpose:** Defines folder rules, frontmatter standards, and workflows for AI agents.

## Module Identity

- **Name:** Activity
- **Type:** Laravel Module (Laraxot)
- **Location:** `laravel/Modules/Activity/`
- **Docs:** `laravel/Modules/Activity/docs/`

## Wiki Rules

### raw/ Rules
- ✅ Immutable — AI reads but never modifies or deletes
- ✅ Drop liberally — articles, code snippets, decisions
- ✅ Subdivide by type: `articles/`, `papers/`, `code-examples/`, `decisions/`

### wiki/ Rules
- ✅ AI-owned — synthesizes raw documents into structured knowledge
- ✅ Every page MUST have YAML frontmatter
- ✅ Link related pages via `related:` in frontmatter
- ✅ Update `index.md` and `log.md` after each operation

### YAML Frontmatter Standard

```yaml
---
title: "Page Title"
type: concept|entity|source|comparison
sources:
  - ../raw/articles/filename.md
related:
  - concepts/related-concept.md
  - entities/related-entity.md
created: 2026-04-15T10:00:00Z
updated: 2026-04-15T14:30:00Z
confidence: high|medium|low
---
```

## Workflows

### Ingest Workflow

1. Human drops file in `raw/`
2. AI reads raw file
3. AI creates/updates wiki pages in `concepts/`, `entities/`, `sources/`
4. AI updates `index.md` with new entries
5. AI appends to `log.md` with timestamp
6. AI commits changes

### Query Workflow

1. AI reads `wiki/index.md` to find relevant pages
2. AI reads linked `wiki/concepts/` and `wiki/entities/` files
3. AI synthesizes answer with file citations
4. If high-value insight, AI suggests filing as `wiki/comparisons/new-page.md`

### Lint Workflow

1. AI scans all wiki pages for broken links
2. AI flags pages with no `related:` links (orphans)
3. AI detects contradictions across pages
4. AI suggests missing concepts based on uningested `raw/` files
5. AI updates `log.md` with lint results

---

**Maintained By:** All AI agents working on Activity  
**Last Updated:** 2026-04-15T08:28:40Z

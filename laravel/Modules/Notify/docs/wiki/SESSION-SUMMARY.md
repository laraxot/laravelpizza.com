# LLM Wiki Integration - Session Summary

> **Date**: 2026-04-15
> **Based on**: Karpathy's LLM Wiki pattern
> **Source**: https://gist.github.com/karpathy/442a6bf555914893e9891c11519de94f
> **Status**: ✅ Complete and Committed

## What Was Done

### 1. ✅ Research and Analysis

- Studied Karpathy's LLM Wiki concept from multiple sources
- Analyzed the three-layer architecture (raw/wiki/schema)
- Understood ingest/query/lint workflows
- Mapped Karpathy's structure to our Laraxot project conventions

### 2. ✅ Project-Wide Wiki Structure

Created complete wiki structure in `./docs/wiki/`:

```
docs/wiki/
├── README.md                 # Complete integration guide
├── AGENTS.md                 # Schema file for LLM agents (16KB)
├── QUICK-REFERENCE.md        # Quick daily reference
├── overview.md               # High-level synthesis
├── index.md                  # Content catalog
├── log.md                    # Activity log
├── schema.md                 # Additional schema documentation
│
├── _templates/               # Page templates
│   ├── concept.md
│   ├── entity.md
│   ├── source.md
│   └── comparison.md
│
├── raw/                      # Immutable sources
│   ├── articles/
│   ├── papers/
│   └── notes/
│
└── wiki/                     # LLM-generated content
    ├── concepts/
    ├── entities/
    ├── sources/
    ├── comparisons/
    ├── decisions/
    ├── troubleshooting/
    └── _archive/
```

### 3. ✅ Agent Instructions (AGENTS.md)

Created comprehensive 16KB schema file with:

- **Role Definition**: LLM Wiki Maintainer
- **Strict Rules**: 
  - raw/ is READ-ONLY
  - All pages MUST use frontmatter
  - DRY knowledge (one concept = one page)
  - Link heavily (3+ incoming, 3+ outgoing)
  - Atomic commits
- **Three Workflows**:
  - **Ingest**: source → wiki pages
  - **Query**: synthesize with citations
  - **Lint**: resolve contradictions/orphans/stale
- **Examples**: Valid pages, index entries, log entries
- **Quality Gates**: Checklists before committing

### 4. ✅ Module Wiki Integration

Created `Modules/Xot/docs/llm-wiki-integration.md`:

- When to use module wiki vs project wiki
- Module wiki structure and templates
- Cross-linking strategies (module ↔ project)
- Module-specific ingestion workflow
- Best practices for module wikis

### 5. ✅ Obsidian Configuration

Complete Obsidian setup in `docs/.obsidian/`:

- `app.json` - Core settings (wikilinks enabled, attachment path)
- `appearance.json` - Theme and fonts
- `hotkeys.json` - Keyboard shortcuts
- `README.md` - Setup guide with plugin recommendations

**Recommended Plugins**:
- Dataview (frontmatter queries)
- Templater (advanced templates)
- QuickAdd (rapid page creation)
- Obsidian Git (auto-commit)

### 6. ✅ Tool Installation

- **qmd**: Installed globally (`npm install -g qmd`)
  - Local markdown search engine
  - Hybrid BM25 + vector + LLM re-ranking
  - Usage: `qmd serve ./docs/wiki`

### 7. ✅ Automation Scripts

Created `bashscripts/ai/init-llm-wiki.sh`:

- Initialize wiki structure for any module or theme
- Usage: `bashscripts/ai/init-llm-wiki.sh {module|theme} {Name}`
- Example: `bashscripts/ai/init-llm-wiki.sh module Fixcity`
- Creates complete directory structure with templates
- Generates module-specific AGENTS.md

### 8. ✅ Documentation Updates

- **QWEN.md**: Added LLM Wiki rules to memories
- **Modules**: Created wiki structure in all modules (already existed from previous session)
- **Themes**: Created wiki structure in all themes (already existed from previous session)

### 9. ✅ Git Commits

All changes committed and pushed:

```bash
# Bashscripts submodule
commit 4977db76: feat: add init-llm-wiki.sh for LLM Wiki initialization

# Main repository
commit a21032a60: docs: integrate Karpathy LLM Wiki pattern
```

## Architecture Summary

### Three-Layer Model

| Layer | Location | Purpose | Mutable? |
|-------|----------|---------|----------|
| **raw/** | `docs/raw/` | Immutable sources | ❌ NEVER |
| **wiki/** | `docs/wiki/` | LLM-generated knowledge | ✅ YES |
| **schema** | `docs/wiki/AGENTS.md` | Agent instructions | ✅ YES |

### Module Wiki

| Layer | Location | Purpose |
|-------|----------|---------|
| **raw/** | `Modules/{Name}/docs/llm-wiki/raw/` | Module sources | ❌ NEVER |
| **wiki/** | `Modules/{Name}/docs/llm-wiki/` | Module knowledge | ✅ YES |
| **schema** | `Modules/{Name}/docs/llm-wiki/AGENTS.md` | Module agent rules | ✅ YES |

## Workflows

### Ingest Workflow

```
1. Place source in docs/raw/articles/
2. User: "ingest docs/raw/articles/filename.md"
3. LLM reads source, extracts concepts
4. Creates/updates wiki pages
5. Updates index.md and log.md
6. Commits changes
```

### Query Workflow

```
1. User asks question
2. LLM searches wiki/index.md
3. Reads relevant wiki pages
4. Synthesizes answer with citations
5. Creates new pages for valuable insights
```

### Lint Workflow

```
1. User: "lint wiki"
2. LLM scans for:
   - Contradictions
   - Orphan pages
   - Stale claims
   - Missing cross-references
3. Reports findings
4. Applies fixes (if approved)
```

## Next Steps

### Immediate (This Week)

1. **Ingest First Source**:
   ```bash
   # Place a source file
   cp ~/Downloads/article.md docs/raw/articles/
   
   # Ingest via LLM
   User: "ingest docs/raw/articles/article.md"
   ```

2. **Configure Obsidian**:
   - Open `./docs` folder as vault
   - Enable plugins (Dataview, Templater)
   - Install Web Clipper browser extension

3. **Initialize Module Wikis** (if not already done):
   ```bash
   bashscripts/ai/init-llm-wiki.sh module Fixcity
   bashscripts/ai/init-llm-wiki.sh module Predict
   bashscripts/ai/init-llm-wiki.sh theme Sixteen
   ```

### Short-Term (Next 2 Weeks)

1. **Ingest 5-10 Critical Documents**:
   - Architecture decisions
   - Pattern documentation
   - Troubleshooting guides
   - Technology deep-dives

2. **Set Up Weekly Lint Schedule**:
   - Run lint every Friday
   - Resolve contradictions
   - Archive stale sources

3. **Train Team Agents**:
   - Show AI agents how to use wiki
   - Add wiki rules to agent instructions
   - Create examples in log.md

### Long-Term (Ongoing)

1. **Use Wiki for All Architecture Queries**
2. **Cross-Link Module Wikis ↔ Project Wiki**
3. **Grow to 50+ Pages** (then install qmd for search)
4. **Export Presentations** via Marp from wiki content

## Files Created/Modified

### Project Root (docs/)

- ✅ `docs/wiki/README.md` - Integration guide
- ✅ `docs/wiki/AGENTS.md` - Agent instructions (16KB)
- ✅ `docs/wiki/QUICK-REFERENCE.md` - Quick reference
- ✅ `docs/wiki/overview.md` - High-level synthesis
- ✅ `docs/wiki/index.md` - Content catalog
- ✅ `docs/wiki/log.md` - Activity log
- ✅ `docs/wiki/schema.md` - Schema docs
- ✅ `docs/wiki/_templates/concept.md`
- ✅ `docs/wiki/_templates/entity.md`
- ✅ `docs/wiki/_templates/source.md`
- ✅ `docs/wiki/_templates/comparison.md`
- ✅ `docs/.obsidian/app.json`
- ✅ `docs/.obsidian/appearance.json`
- ✅ `docs/.obsidian/hotkeys.json`
- ✅ `docs/.obsidian/README.md`
- ✅ `docs/raw/articles/` (directory)
- ✅ `docs/raw/papers/` (directory)
- ✅ `docs/raw/notes/` (directory)

### Modules

- ✅ `Modules/Xot/docs/llm-wiki-integration.md` - Module wiki guide

### Scripts

- ✅ `bashscripts/ai/init-llm-wiki.sh` - Wiki initialization script

### Configuration

- ✅ `QWEN.md` - Updated with LLM Wiki rules

## Tools Installed

- ✅ **qmd** (npm global) - Local markdown search
- ✅ **Obsidian** configuration - Wiki browsing
- ⏳ **Marp** (optional) - Markdown-to-slides (not installed yet)
- ⏳ **Dataview** (optional) - Obsidian plugin (user needs to install)

## Related Documentation

- [Karpathy's Original Gist](https://gist.github.com/karpathy/442a6bf555914893e9891c11519de94f)
- [Complete Integration Guide](docs/wiki/README.md)
- [Agent Instructions](docs/wiki/AGENTS.md)
- [Quick Reference](docs/wiki/QUICK-REFERENCE.md)
- [Module Wiki Guide](Modules/Xot/docs/llm-wiki-integration.md)
- [Obsidian Setup](docs/.obsidian/README.md)

## Success Criteria

- ✅ Wiki structure created and documented
- ✅ Agent instructions comprehensive
- ✅ Templates ready for use
- ✅ Obsidian configured
- ✅ Automation script available
- ✅ All changes committed and pushed
- ⏳ First source ingested (next step)
- ⏳ Weekly lint schedule established (next step)
- ⏳ 50+ wiki pages created (ongoing)

---

**Session Complete** - Ready for first ingestion! 🚀

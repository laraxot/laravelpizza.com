# QMD MCP Server Configuration Guide

> **For:** All AI agents working on PTVX  
> **Created:** 2026-04-15  
> **Status:** ✅ Active across all 35+ modules

---

## Overview

QMD is configured as an MCP server for **local markdown search** across all module wikis. This allows AI agents to query specific module knowledge without loading entire codebases.

## Current Collections

45 qmd collections are already configured, including:

- **Per-module:** `module_Activity`, `module_Xot`, `module_Ptv`, etc. (one for each of 35 modules)
- **Root docs:** `main_docs`, `bashscripts_docs`
- **Themes:** `theme_One`, `theme_Zero`
- **Wiki collections:** `wiki`, `base-modules-wiki`

## How to Use QMD

### 1. Search (Interactive)

```bash
# Navigate to module docs
cd laravel/Modules/Activity/docs

# Search the wiki
qmd search "What are the migration safety rules?"

# Query with specific collection
qmd query "List all entities related to Activity logging" --json
```

### 2. MCP Server (AI Agent Integration)

Start qmd as MCP server:

```bash
# In module docs folder
cd laravel/Modules/Activity/docs
qmd mcp
```

This starts an MCP server at `http://localhost:PORT` that AI agents can connect to.

### 3. Add New Collection

```bash
# For a new module wiki
cd laravel/Modules/NewModule/docs
qmd collection add ./wiki --name module_NewModule
```

## MCP Configuration for Cursor/Windsurf

Add to `.cursor/mcp.json`:

```json
{
  "mcpServers": {
    "qmd-activity": {
      "command": "qmd",
      "args": ["mcp"],
      "cwd": "${workspaceFolder}/laravel/Modules/Activity/docs",
      "disabled": false
    },
    "qmd-xot": {
      "command": "qmd",
      "args": ["mcp"],
      "cwd": "${workspaceFolder}/laravel/Modules/Xot/docs",
      "disabled": false
    }
  }
}
```

**Note:** One MCP server per module you're actively working on. Don't add all 35 at once — only active modules.

## When to Use QMD vs Direct File Reading

| Scenario | Approach |
|----------|----------|
| < 50 wiki pages in module | Direct file reading (fast enough) |
| 50-500 wiki pages | **Use qmd search** |
| 500+ wiki pages | **Use qmd MCP server** |
| Cross-module query | Start qmd in root `docs/` |

## Best Practices

1. **Only start MCP for active modules** — don't run 35 servers
2. **Use `qmd search` for exploration** — semantic search finds relevant pages
3. **Use `qmd query --json` for structured output** — when building indexes
4. **Commit after qmd operations** — wiki changes are versioned
5. **Monitor collection size** — `qmd collection list` shows file counts

## Troubleshooting

### Collection already exists
```bash
# Use different name
qmd collection add ./wiki --name module_NewName
```

### No results from search
- Check collection is up to date: `qmd collection list`
- Re-add collection if needed: `qmd collection remove X && qmd collection add X`
- Verify wiki pages have YAML frontmatter

### MCP server won't start
- Check port isn't in use: `lsof -i :PORT`
- Try different port: `qmd mcp --port 8081`
- Check Node.js version: `node --version` (needs v18+)

---

**Maintained By:** All AI agents  
**Last Updated:** 2026-04-15T10:30:00Z  
**Related:** 
- `docs/llm-wiki-architecture.md`
- `docs/wiki/overview.md`
- `bashscripts/docs/setup-llm-wiki-structure.sh`

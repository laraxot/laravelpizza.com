# MCP Servers - Master Index

**Project**: FixCity Platform  
**Last Updated**: 2026-04-09  
**Configuration**: `laravel/.mcp.json`  
**Total Servers**: 10

## Overview

MCP (Model Context Protocol) servers provide AI assistants with persistent memory, code analysis, documentation access, and development tools. This document is the **single authoritative source** for MCP configuration across all modules and themes.

## Quick Reference

| Server | Category | Status | Purpose |
|--------|----------|--------|---------|
| [laravel-boost](#laravel-boost) | Development | ✅ Active | Laravel-specific AI assistance |
| [fetch](#fetch) | Web | ✅ Active | Web content fetching |
| [filesystem](#filesystem) | Files | ✅ Active | Secure file operations |
| [sqlite](#sqlite) | Database | ✅ Active | Database queries |
| [sequential-thinking](#sequential-thinking) | Reasoning | ✅ Active | Complex problem solving |
| [memory](#memory) | Memory | ✅ Active | Knowledge graph persistence |
| [github](#github) | Version Control | ✅ Active | GitHub integration |
| [context7](#context7) | Documentation | ✅ Active | Library documentation lookup |
| [memory-bank](#memory-bank) | Memory | ✅ Active | Session memory bank |
| [supermemory](#supermemory) | Memory | ✅ Active | AI memory infrastructure |
| [qmd](#qmd) | Search | ✅ Active | Local markdown search (BM25 + vector) |

## Server Details

### laravel-boost
- **Type**: Laravel-specific
- **Command**: `php artisan boost:mcp`
- **Use**: Laravel 12, Filament, Livewire documentation and best practices
- **Module Docs**: [Xot MCP Guide](../Modules/Xot/docs/MCP_SERVERS.md) | [Theme MCP Guide](../Themes/Sixteen/docs/MCP_SERVERS.md)

### fetch
- **Type**: Web content
- **Package**: `@modelcontextprotocol/server-fetch`
- **Use**: Fetch web content, API responses, documentation pages
- **Example**: Fetch Bootstrap Italia documentation for parity checks

### filesystem
- **Type**: File operations
- **Package**: `@modelcontextprotocol/server-filesystem`
- **Scope**: `/var/www/_bases/base_fixcity_fila5`
- **Use**: Read/write files, search directories, explore project structure

### sqlite
- **Type**: Database
- **Package**: `@modelcontextprotocol/server-sqlite`
- **DB Path**: `laravel/database/database.sqlite`
- **Use**: Query database, verify seeders, debug data issues
- **Module Usage**: Each module queries its own tables

### sequential-thinking
- **Type**: Reasoning
- **Package**: `@modelcontextprotocol/server-sequential-thinking`
- **Use**: Complex problem decomposition, multi-step analysis
- **When to Use**: Architecture decisions, debugging complex issues

### memory
- **Type**: Knowledge Graph
- **Package**: `@modelcontextprotocol/server-memory`
- **Use**: Store project decisions, patterns, conventions
- **Persistence**: Survives across sessions
- **Example**: "Fixcity uses XotBaseModel pattern"

### github
- **Type**: Version Control
- **Package**: `@modelcontextprotocol/server-github`
- **Auth**: `GITHUB_TOKEN` environment variable
- **Use**: PR creation, issue management, code review

### context7
- **Type**: Documentation
- **Package**: `@upstash/context7-mcp`
- **Use**: Look up Laravel, Filament, Livewire, Tailwind documentation
- **Coverage**: 13,000+ libraries with version resolution
- **Example**: "Filament v4 table best practices"

### memory-bank
- **Type**: Session Memory
- **Package**: `memory-bank-mcp`
- **Path**: `.memory-bank/` in project root
- **Use**: Store session checkpoints, decisions, context
- **Features**: Session summaries, context recovery

### supermemory
- **Type**: AI Memory Infrastructure
- **CLI**: `supermemory` (npm global)
- **API Key**: Configured in `.mcp.json`
- **Container Tag**: `fixcity`
- **Use**: 
  - Persistent project context across conversations
  - Semantic search across project documentation
  - User profile and preferences
  - Knowledge graph with relationships
- **Commands**:
  - `supermemory add` - Ingest content
  - `supermemory search` - Semantic search
  - `supermemory profile` - Get user/project context
  - `supermemory remember` - Store specific memory
- **Setup**: See [SuperMemory Quickstart](#supermemory-quickstart)

### qmd
- **Type**: Local Search Engine
- **CLI**: `qmd` (npm global)
- **Use**: Hybrid search over markdown files (BM25 + vector + reranking)
- **Collections**:
  - `fixcity-wiki` → `./docs/wiki`
  - `fixcity-docs` → `./docs`
  - `fixcity-modules` → `./Modules`
  - `fixcity-themes` → `./Themes`
- **Commands**:
  - `qmd search "query"` - Full-text search
  - `qmd query "query"` - Hybrid search with reranking
  - `qmd vsearch "query"` - Vector semantic search
  - `qmd get <file>` - Retrieve document
  - `qmd status` - Index health
  - `qmd update` - Re-index collections
  - `qmd embed` - Generate vector embeddings
- **MCP**: `qmd mcp` (stdio transport)
- **Docs**: [qmd-local-docs-search.md](./project/qmd-local-docs-search.md)

## Configuration

### Project Configuration
Main config: `laravel/.mcp.json`

### Editor Configuration
- **Cursor**: Uses `.mcp.json` automatically
- **Windsurf**: Import from [Xot Windsurf Config](../Modules/Xot/docs/windsurf-mcp-config.json)
- **Claude Desktop**: Copy config to `claude_desktop_config.json`

### Environment Variables
```bash
# Required
GITHUB_TOKEN=your_github_token
CONTEXT7_API_KEY=your_context7_key
SUPERMEMORY_API_KEY=sm_BzH3Cugxk1hMDm5V1EHC2N_...

# Optional
DATABASE_URL=postgresql://...
```

## SuperMemory Quickstart

### Authentication
```bash
supermemory whoami
# Should show: marco.sottana@gmail.com (Xot org)
```

### Add Project Context
```bash
supermemory add --tag fixcity --file .supermemory/fixcity-context.md
```

### Search Memories
```bash
supermemory search "FixCity architecture" --tag fixcity
```

### Get Profile
```bash
supermemory profile --tag fixcity --query "project preferences"
```

## Module-Specific Usage

Each module has specific MCP usage guidelines. See module-specific docs:

- **Xot**: [MCP Servers Guide](../Modules/Xot/docs/MCP_SERVERS.md)
- **Fixcity**: Module-specific patterns for ticket system
- **User**: Authentication and user management
- **Cms**: Content management patterns

**Rule**: Always cross-reference to this master doc. Module docs should ONLY contain module-specific additions.

## Theme-Specific Usage

- **Sixteen**: [Theme MCP Servers](../Themes/Sixteen/docs/MCP_SERVERS.md)
  - Frontoffice page testing
  - Visual parity verification
  - CSS/JS build process

## DRY Compliance

**Authoritative Source**: This file is the single source of truth for MCP configuration.

**Module Docs**: Should contain ONLY module-specific usage patterns, NOT server list.

**Theme Docs**: Should contain ONLY theme-specific usage patterns.

**Cross-References**: All module/theme docs MUST link back to this master index.

## Related Documentation

- [Project Configuration](configuration.md)
- [AI Workflow](ai-workflow/)
- [Coding Conventions](conventions/)
- [Module Index](modules/index.md)
- [Theme Index](themes/index.md)

---

*This document follows DRY+KISS principles. For questions or updates, edit this file and update cross-references.*

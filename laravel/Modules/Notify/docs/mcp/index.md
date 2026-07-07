# MCP Server Index - FixCity Project

**Purpose**: Central index for all MCP server documentation  
**Last Updated**: 2026-04-09

---

## 📋 Available Documentation

| Document | Location | Purpose |
|----------|----------|---------|
| **QMD (local docs search)** | [docs/project/qmd-local-docs-search.md](../project/qmd-local-docs-search.md) | Indice Markdown locale; server MCP opzionale (`qmd mcp`) |
| **MCP Master Index** | [docs/mcp/README.md](../mcp/README.md) | Complete MCP server documentation |
| **Supermemory Guide** | [Themes/Sixteen/docs/supermemory-setup.md](../../laravel/Themes/Sixteen/docs/supermemory-setup.md) | Supermemory integration guide |
| **Visual Parity Tool** | [Themes/Sixteen/scripts/visual-parity.mjs](../../laravel/Themes/Sixteen/scripts/visual-parity.mjs) | Playwright-based visual analysis |
| **Supermemory Script** | [Themes/Sixteen/scripts/supermemory-context.js](../../laravel/Themes/Sixteen/scripts/supermemory-context.js) | AI context indexing |

---

## 🚀 MCP Server Categories

### Development
- **laravel-boost** - Laravel framework assistance
- **filament** - FilamentPHP admin panel
- **filesystem** - File system operations

### Testing & Visual
- **puppeteer** - Browser automation, screenshots
- **playwright** (local script) - Visual parity analysis

### Memory & Context
- **supermemory** - Long-term memory, RAG
- **memory** - Session persistence
- **notebooklm** - Research and documentation
- **qmd** ([tobi/qmd](https://github.com/tobi/qmd)) - Indice locale BM25 + vector su cartelle `docs/`; MCP `query` / `get` / `multi_get`

### Reasoning
- **sequential-thinking** - Complex problem analysis

---

## 📊 Server Status

| Server | Status | Package | Version |
|--------|--------|---------|---------|
| laravel-boost | ✅ Active | PHP artisan | - |
| filament | ✅ Active | filament-mcp-server | latest |
| notebooklm | ✅ Active | notebooklm-mcp-cli | latest |
| sequential-thinking | ✅ Active | @modelcontextprotocol/server-sequential-thinking | latest |
| filesystem | ✅ Active | @modelcontextprotocol/server-filesystem | latest |
| puppeteer | ✅ Active | puppeteer-mcp-server | 0.7.2 |
| memory | ✅ Active | @anthropic-ai/claude-code | latest |
| supermemory | ✅ Active | supermemory (npm) | latest |

---

## 🔗 Related Documentation

- [Main Docs Index](../README.md)
- [Project Configuration](../project/configuration.md)
- [AI Workflow](../project/ai-workflow/)

---

**Maintained By**: AI Agents  
**Last Updated**: 2026-04-09

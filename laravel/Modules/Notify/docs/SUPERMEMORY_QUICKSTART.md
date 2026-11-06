---
title: "SUPERMEMORY QUICKSTART"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "SUPERMEMORY QUICKSTART"
issues: []
discussions: []
status: draft
---

# SuperMemory - AI Memory Infrastructure

**Project**: FixCity Platform  
**Last Updated**: 2026-04-09  
**API Key**: Configured (sm_BzH3Cugxk1hMDm5V1EHC2N_...)  
**Container Tag**: `ptv`  
**User**: marco.sottana@gmail.com (Xot org)

## Overview

SuperMemory is the long-term and short-term memory and context infrastructure for AI agents. It provides persistent memory across conversations, semantic search, and knowledge graph capabilities.

**Master MCP Docs**: [Project MCP Servers](../../../docs/MCP_SERVERS.md)
**Master MCP Docs**: [Project MCP Servers](../../../../docs/MCP_SERVERS.md)

## Quick Start

### Verify Authentication
```bash
supermemory whoami
```

Expected output:
```
User:  marco.sottana@gmail.com
Org:   Xot (BzH3Cugxk1hMDm5V1EHC2N)
Plan:  free
Auth:  api-key (sm_BzH3Cugxk1hMDm5V1EHC2N_Jr9N****)
```

### Add Project Context
```bash
cd /var/www/_bases/base_ptv_fila5
supermemory add --tag ptv --file .supermemory/ptv-context.md
```

### Search Memories
```bash
supermemory search "FixCity architecture" --tag ptv
supermemory search "Laravel Filament patterns" --tag ptv
supermemory search "theme build process" --tag ptv
```

### Get Profile
```bash
supermemory profile --tag ptv --query "project preferences"
```

## Core Commands

| Command | Description | Example |
|---------|-------------|---------|
| `add` | Ingest content and extract memories | `supermemory add --tag ptv --file docs/MCP_SERVERS.md` |
| `search` | Search memories semantically | `supermemory search "ticket workflow" --tag ptv` |
| `remember` | Store a specific memory | `supermemory remember "All models extend XotBaseModel" --tag ptv` |
| `forget` | Remove a specific memory | `supermemory forget <memory-id>` |
| `update` | Update an existing memory | `supermemory update <memory-id> --content "..."` |
| `profile` | Get user/project profile | `supermemory profile --tag ptv --query "preferences"` |
| `tags` | Manage container tags | `supermemory tags list` |
| `docs` | Manage documents | `supermemory docs list` |

## FixCity Use Cases

### 1. Project Context Persistence
Store project architecture decisions:
```bash
supermemory add --tag ptv --content "FixCity uses Nwidart modules + Laraxot extensions. All models extend XotBaseModel. Service providers extend XotBaseServiceProvider."
```

### 2. Module-Specific Knowledge
Store module patterns:
```bash
supermemory add --tag ptv --content "Fixcity module: Ticket model extends XotBaseModel, uses Filament resources for admin, Folio+Volt for frontoffice."
```

### 3. Theme Conventions
Store theme development patterns:
```bash
supermemory add --tag ptv --content "Sixteen theme: Bootstrap Italia classes replicated with Tailwind @apply. Vite outDir: './public', then npm run copy to public_html/themes/Sixteen/."
```

### 4. Development Workflows
Store build processes:
```bash
supermemory remember "After ANY CSS/JS change in theme: cd Themes/Sixteen && npm run build && npm run copy" --tag ptv
```

### 5. Architectural Decisions
Store reasoning behind decisions:
```bash
supermemory add --tag ptv --content "Decision: Use Actions over Services for business logic. Rationale: Queueable, testable, reusable. Spatie/laravel-queueable-action package."
```

## Integration with AI Workflow

### Before Starting Work
```bash
# Get project context
supermemory profile --tag ptv --query "FixCity project architecture and conventions"

# Search for relevant patterns
supermemory search "Filament widget patterns" --tag ptv
```

### During Development
```bash
# Store decisions
supermemory remember "Added file upload component to CreateTicketWizardWidget using wire:change" --tag ptv

# Search for similar patterns
supermemory search "file upload Livewire" --tag ptv
```

### After Completion
```bash
# Store completed work summary
supermemory add --tag ptv --file path/to/session-summary.md

# Update project context if needed
supermemory update <context-memory-id> --content "Updated architecture..."
```

## Container Tags Strategy

| Tag | Purpose | Example Content |
|-----|---------|-----------------|
| `ptv` | Project-wide context | Architecture, conventions, decisions |
| `ptv-{module}` | Module-specific | Module patterns, models, resources |
| `ptv-{theme}` | Theme-specific | Theme conventions, build process |
| `ptv-{session}` | Session-specific | Session summary, decisions made |

## Best Practices

1. **Use Descriptive Content**: Be specific about what you're storing
2. **Tag Consistently**: Always use `ptv` as base tag
3. **Update Regularly**: Keep memories current with project evolution
4. **Search Before Adding**: Avoid duplicate memories
5. **Use Metadata**: Add metadata for better filtering:
   ```bash
   supermemory add --tag ptv --content "..." --metadata '{"type":"architecture","module":"Xot"}'
   ```

## Configuration

### MCP Configuration
Located in `laravel/.mcp.json`:
```json
{
  "supermemory": {
    "command": "supermemory",
    "args": [],
    "env": {
      "SUPERMEMORY_API_KEY": "sm_BzH3Cugxk1hMDm5V1EHC2N_..."
    }
  }
}
```

### CLI Configuration
Located in `~/.supermemory/projects/-var-www-_bases-base_ptv_fila5/config.json`:
```json
{
  "apiKey": "sm_BzH3Cugxk1hMDm5V1EHC2N_...",
  "containerTag": "ptv"
}
```

## Troubleshooting

### Authentication Issues
```bash
# Check authentication
supermemory whoami

# Re-authenticate if needed
supermemory init --api-key YOUR_KEY --container-tag ptv --scope project
```

### No Results from Search
- Try broader search terms
- Verify container tag: `--tag ptv`
- Wait 1-2 minutes after adding content for processing

### Content Not Appearing
- Check file path is correct
- Verify content format (markdown preferred)
- Use `supermemory docs list` to see ingested documents

## Related Documentation

- **Master MCP Docs**: [Project MCP Servers](../../../docs/MCP_SERVERS.md)
- **Xot Module MCP**: [Xot MCP Guide](../../Modules/Xot/docs/MCP_SERVERS.md)
- **Theme MCP**: [Sixteen Theme MCP](../../Themes/Sixteen/docs/mcp-servers.md)
- **Master MCP Docs**: [Project MCP Servers](../../../../docs/MCP_SERVERS.md)
- **Xot Module MCP**: [Xot MCP Guide](../../Modules/Xot/docs/MCP_SERVERS.md)
- **Theme MCP**: [Sixteen Theme MCP](../../../Themes/Sixteen/docs/mcp-servers.md)
- **SuperMemory Skill**: [.qwen/skills/supermemory/](.qwen/skills/supermemory/)
- **SuperMemory Console**: https://console.supermemory.ai

---
*This document follows DRY+KISS principles. For general MCP server info, see the master doc.*

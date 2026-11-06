---
qmd: "supermemory quickstart"
issues: []
discussions: []
title: "SuperMemory - AI Memory Infrastructure"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# SuperMemory - AI Memory Infrastructure

**Project**: Notify Platform  
**Last Updated**: 2026-04-09  
**API Key**: Configured (sm_BzH3Cugxk1hMDm5V1EHC2N_...)  
**Container Tag**: `laraxot`  
**Project**: <nome progetto> Platform  
**Last Updated**: 2026-04-09  
**API Key**: Configured (sm_BzH3Cugxk1hMDm5V1EHC2N_...)  
**Container Tag**: `<nome progetto>`  
**User**: marco.sottana@gmail.com (Xot org)

## Overview

SuperMemory is the long-term and short-term memory and context infrastructure for AI agents. It provides persistent memory across conversations, semantic search, and knowledge graph capabilities.

**Master MCP Docs**: [Project MCP Servers](../../../docs/MCP_SERVERS.md)
**Master MCP Docs**: [Project MCP Servers](../../../MCP_SERVERS.md)

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
cd /var/www/_bases/<nome repository>
supermemory add --tag laraxot --file .supermemory/laraxot-context.md
cd /var/www/_bases/<nome repitory>
supermemory add --tag <nome progetto> --file .supermemory/<nome progetto>-context.md
```

### Search Memories
```bash
supermemory search "Notify architecture" --tag laraxot
supermemory search "Laravel Filament patterns" --tag laraxot
supermemory search "theme build process" --tag laraxot
supermemory search "<nome progetto> architecture" --tag <nome progetto>
supermemory search "Laravel Filament patterns" --tag <nome progetto>
supermemory search "theme build process" --tag <nome progetto>
```

### Get Profile
```bash
supermemory profile --tag laraxot --query "project preferences"
supermemory profile --tag <nome progetto> --query "project preferences"
```

## Core Commands

| Command | Description | Example |
|---------|-------------|---------|
| `add` | Ingest content and extract memories | `supermemory add --tag laraxot --file docs/MCP_SERVERS.md` |
| `search` | Search memories semantically | `supermemory search "ticket workflow" --tag laraxot` |
| `remember` | Store a specific memory | `supermemory remember "All models extend XotBaseModel" --tag laraxot` |
| `forget` | Remove a specific memory | `supermemory forget <memory-id>` |
| `update` | Update an existing memory | `supermemory update <memory-id> --content "..."` |
| `profile` | Get user/project profile | `supermemory profile --tag laraxot --query "preferences"` |
| `tags` | Manage container tags | `supermemory tags list` |
| `docs` | Manage documents | `supermemory docs list` |

## Notify Use Cases
| `add` | Ingest content and extract memories | `supermemory add --tag <nome progetto> --file docs/MCP_SERVERS.md` |
| `search` | Search memories semantically | `supermemory search "ticket workflow" --tag <nome progetto>` |
| `remember` | Store a specific memory | `supermemory remember "All models extend XotBaseModel" --tag <nome progetto>` |
| `forget` | Remove a specific memory | `supermemory forget <memory-id>` |
| `update` | Update an existing memory | `supermemory update <memory-id> --content "..."` |
| `profile` | Get user/project profile | `supermemory profile --tag <nome progetto> --query "preferences"` |
| `tags` | Manage container tags | `supermemory tags list` |
| `docs` | Manage documents | `supermemory docs list` |

## <nome progetto> Use Cases

### 1. Project Context Persistence
Store project architecture decisions:
```bash
supermemory add --tag laraxot --content "Notify uses Nwidart modules + Laraxot extensions. All models extend XotBaseModel. Service providers extend XotBaseServiceProvider."
supermemory add --tag <nome progetto> --content "<nome progetto> uses Nwidart modules + Laraxot extensions. All models extend XotBaseModel. Service providers extend XotBaseServiceProvider."
```

### 2. Module-Specific Knowledge
Store module patterns:
```bash
supermemory add --tag laraxot --content "App module: Ticket model extends XotBaseModel, uses Filament resources for admin, Folio+Volt for frontoffice."
supermemory add --tag <nome progetto> --content "<nome progetto> module: Ticket model extends XotBaseModel, uses Filament resources for admin, Folio+Volt for frontoffice."
```

### 3. Theme Conventions
Store theme development patterns:
```bash
supermemory add --tag laraxot --content "Sixteen theme: Bootstrap Italia classes replicated with Tailwind @apply. Vite outDir: './public', then npm run copy to public_html/themes/Sixteen/."
supermemory add --tag <nome progetto> --content "Sixteen theme: Bootstrap Italia classes replicated with Tailwind @apply. Vite outDir: './public', then npm run copy to public_html/themes/Sixteen/."
```

### 4. Development Workflows
Store build processes:
```bash
supermemory remember "After ANY CSS/JS change in theme: cd Themes/Sixteen && npm run build && npm run copy" --tag laraxot
supermemory remember "After ANY CSS/JS change in theme: cd Themes/Sixteen && npm run build && npm run copy" --tag <nome progetto>
```

### 5. Architectural Decisions
Store reasoning behind decisions:
```bash
supermemory add --tag laraxot --content "Decision: Use Actions over Services for business logic. Rationale: Queueable, testable, reusable. Spatie/laravel-queueable-action package."
supermemory add --tag <nome progetto> --content "Decision: Use Actions over Services for business logic. Rationale: Queueable, testable, reusable. Spatie/laravel-queueable-action package."
```

## Integration with AI Workflow

### Before Starting Work
```bash
# Get project context
supermemory profile --tag laraxot --query "Notify project architecture and conventions"

# Search for relevant patterns
supermemory search "Filament widget patterns" --tag laraxot
supermemory profile --tag <nome progetto> --query "<nome progetto> project architecture and conventions"

# Search for relevant patterns
supermemory search "Filament widget patterns" --tag <nome progetto>
```

### During Development
```bash
# Store decisions
supermemory remember "Added file upload component to CreateTicketWizardWidget using wire:change" --tag laraxot

# Search for similar patterns
supermemory search "file upload Livewire" --tag laraxot
supermemory remember "Added file upload component to CreateTicketWizardWidget using wire:change" --tag <nome progetto>

# Search for similar patterns
supermemory search "file upload Livewire" --tag <nome progetto>
```

### After Completion
```bash
# Store completed work summary
supermemory add --tag laraxot --file path/to/session-summary.md
supermemory add --tag <nome progetto> --file path/to/session-summary.md

# Update project context if needed
supermemory update <context-memory-id> --content "Updated architecture..."
```

## Container Tags Strategy

| Tag | Purpose | Example Content |
|-----|---------|-----------------|
| `laraxot` | Project-wide context | Architecture, conventions, decisions |
| `laraxot-{module}` | Module-specific | Module patterns, models, resources |
| `laraxot-{theme}` | Theme-specific | Theme conventions, build process |
| `laraxot-{session}` | Session-specific | Session summary, decisions made |
| `<nome progetto>` | Project-wide context | Architecture, conventions, decisions |
| `<nome progetto>-{module}` | Module-specific | Module patterns, models, resources |
| `<nome progetto>-{theme}` | Theme-specific | Theme conventions, build process |
| `<nome progetto>-{session}` | Session-specific | Session summary, decisions made |

## Best Practices

1. **Use Descriptive Content**: Be specific about what you're storing
2. **Tag Consistently**: Always use `laraxot` as base tag
2. **Tag Consistently**: Always use `<nome progetto>` as base tag
3. **Update Regularly**: Keep memories current with project evolution
4. **Search Before Adding**: Avoid duplicate memories
5. **Use Metadata**: Add metadata for better filtering:
   ```bash
   supermemory add --tag laraxot --content "..." --metadata '{"type":"architecture","module":"Xot"}'
   supermemory add --tag <nome progetto> --content "..." --metadata '{"type":"architecture","module":"Xot"}'
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
Located in `~/.supermemory/projects/-var-www-_bases-<nome repository>/config.json`:
```json
{
  "apiKey": "sm_BzH3Cugxk1hMDm5V1EHC2N_...",
  "containerTag": "laraxot"
Located in `~/.supermemory/projects/-var-www-_bases-<nome repitory>/config.json`:
```

```json
{
  "apiKey": "sm_BzH3Cugxk1hMDm5V1EHC2N_...",
  "containerTag": "<nome progetto>"
}
```

## Troubleshooting

### Authentication Issues
```bash
# Check authentication
supermemory whoami

# Re-authenticate if needed
supermemory init --api-key YOUR_KEY --container-tag laraxot --scope project
supermemory init --api-key YOUR_KEY --container-tag <nome progetto> --scope project
```

### No Results from Search
- Try broader search terms
- Verify container tag: `--tag laraxot`
- Verify container tag: `--tag <nome progetto>`
- Wait 1-2 minutes after adding content for processing

### Content Not Appearing
- Check file path is correct
- Verify content format (markdown preferred)
- Use `supermemory docs list` to see ingested documents

## Related Documentation

- **Master MCP Docs**: [Project MCP Servers](../../../docs/MCP_SERVERS.md)
- **Master MCP Docs**: [Project MCP Servers](../../../MCP_SERVERS.md)
- **Xot Module MCP**: [Xot MCP Guide](../../Modules/Xot/docs/MCP_SERVERS.md)
- **Theme MCP**: [Sixteen Theme MCP](../../Themes/Sixteen/docs/mcp-servers.md)
- **SuperMemory Skill**: [.qwen/skills/supermemory/](.qwen/skills/supermemory/)
- **SuperMemory Console**: https://console.supermemory.ai

---

*This document follows DRY+KISS principles. For general MCP server info, see the master doc.*

---
title: "supermemory setup"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "supermemory setup"
issues: []
discussions: []
---

# Supermemory Configuration

## Setup Complete

### Installed
- **Plugin**: `opencode-supermemory@2.0.6` in `~/.config/opencode/opencode.json`
- **CLI**: `supermemory` (npm global)
- **Config**: `~/.config/opencode/supermemory.jsonc`

### Auth
- **User**: marco.sottana@gmail.com
- **Org**: Xot
- **Plan**: free
- **API Key**: `sm_BzH3Cugxk1hMDm5V1EHC2N_Jr9NfJdUqxlnPe21yb9q7FtbYMevTsoPtKZJEfBqdP4i81z6aJA34SF32Gx3PUa9`

### Active Container Tags
| Tag | Docs | Memories | Last Activity |
|---|---|---|---|
| `app_fila5_project` | 6 | 15 | 2026-04-09 |
| `laraxot-sixteen` | 11 | 22 | 2026-04-09 |
| `laraxot-project` | 9 | 22 | 2026-04-09 |

### How It Works
1. **Context Injection**: On first message, agent receives user profile + project memories + semantic search results (invisible to user)
2. **Keyword Detection**: Say "remember", "save this", "ricorda", "memorizza" → auto-saves to memory
3. **Codebase Indexing**: `/supermemory-init` explores and memorizes codebase
4. **Preemptive Compaction**: At 80% context capacity → saves session summary as memory

### CLI Commands
```bash
# Search memories
supermemory search "widget naming" --tag app_fila5_project --mode hybrid

# Add memory
supermemory add "Rule: use Ticket not Segnalazione" --tag app_fila5_project

# Add file
supermemory add /path/to/file.md --tag app_fila5_project

# View profile
supermemory profile --tag app_fila5_project

# List tags
supermemory tags
```

### OpenCode Commands
- `/supermemory-init` — Explore and memorize codebase
- `/supermemory-login` — Authenticate with Supermemory
- `/supermemory-logout` — Clear credentials

### Config File
`~/.config/opencode/supermemory.jsonc`:
```jsonc
{
  "apiKey": "sm_...",
  "similarityThreshold": 0.6,
  "maxMemories": 5,
  "maxProjectMemories": 10,
  "maxProfileItems": 10,
  "injectProfile": true,
  "containerTagPrefix": "app_fila5",
  "keywordPatterns": ["ricorda", "memorizza", "salva questa", "non dimenticare"],
  "compactionThreshold": 0.8
}
```

### Environment Variable
```bash
export SUPERMEMORY_API_KEY="sm_BzH3Cugxk1hMDm5V1EHC2N_Jr9NfJdUqxlnPe21yb9q7FtbYMevTsoPtKZJEfBqdP4i81z6aJA34SF32Gx3PUa9"
```

## Links
- [Repo](https://github.com/supermemoryai/opencode-supermemory)
- [App](https://app.supermemory.ai)
- [Logs](~/.opencode-supermemory.log)

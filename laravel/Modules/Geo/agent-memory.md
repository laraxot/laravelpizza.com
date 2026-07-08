# AGENT_MEMORY.md

> Index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Project**: PTVX Fila5 Mono  
**AI Framework**: BMAD-METHOD v6.2.0

## Quick Reference

| Topic | Documentation |
|-------|------|
| Critical Rules | [.agents/docs/agents-guide/04-architecture/critical-rules-summary.md](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md) |
| Action Pattern | `app(ActionClass::class)->execute($data)` |
| Short array | `[]` - MAI `array()` |
| BMAD Workflows | [docs/bmad/README.md](docs/bmad/README.md) |
| AI Coordination | [docs/ai-agent-coordination.md](docs/ai-agent-coordination.md) |

## Key Rules

- **PHPStan Level 10** - no ignores
- **Actions** - Use `app(ActionClass::class)->execute()`
- **Workspace** - `_<module>.code-workspace` per module
- **Source code** - sempre in `app/`
- **Scripts** - in `bashscripts/`
- **Commit** - After every task
- **BMAD** - Use workflows for specialized tasks

## BMAD-METHOD v6.2.0

### AI Agents

| Agent | Role | Expertise |
|-------|------|-----------|
| **Mary** 📊 | Analyst | Requirements, research |
| **Winston** 🏗️ | Architect | System design, Laravel |
| **Amelia** 💻 | Developer | TDD, clean code |
| **John** 📋 | PM | PRDs, user stories |
| **Quinn** 🧪 | QA | Test automation |
| **Sally** 🎨 | UX | User research, UI |
| **Bob** 🏃 | SM | Sprint planning |
| **Paige** 📚 | Tech Writer | Documentation |

### Custom Skills

- **bmad-laravel-module-dev**: Create Laravel modules
- **bmad-filament-page-dev**: Create Filament pages

### Workflows

```bash
# Module development
bmad-laravel-module-dev --module=MyModule

# Architecture
bmad-create-architecture

# Implementation
bmad-dev

# Testing
bmad-qa-generate-e2e-tests

# Documentation
bmad-document-project
```

## PHPStan Status

| Module | Status |
|--------|--------|
| User | ✅ Complete |
| Xot | 🔄 In progress |
| Others | See GitHub issues |

## MCP

| Server | Purpose |
|--------|---------|
| filesystem | File ops |
| mysql | Database |
| playwright | Browser |
| git | Git ops |
| laravel-boost | Laravel Boost |
| redis | Redis |
| github | GitHub API |
| ollama | Ollama AI |

→ [docs/mcp/mcp-overview.md](docs/mcp/mcp-overview.md)

---

*Full documentation: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)*  
*BMAD Documentation: [docs/bmad/README.md](docs/bmad/README.md)*

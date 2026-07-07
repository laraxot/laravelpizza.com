# MCP Servers - Project Overview

**Project**: FixCity Platform  
**Last Updated**: 2026-04-09  
**Status**: Active - Memory and Development Workflow MCP Servers Configured

---

## 🎯 Purpose

MCP (Model Context Protocol) servers enhance AI agent capabilities for:
- **Persistent memory** across development sessions
- **Code context awareness** for consistent implementations
- **Browser automation** for visual parity verification
- **Development workflow** optimization

---

## 📦 Installed MCP Servers

### 1. SuperMemory (✅ Active - Memory)
- **Location**: `laravel/Themes/Sixteen/.supermemory/`
- **Purpose**: Long-term project memory for AI agents
- **Container Tag**: `fixcity-sixteen`
- **API Key**: Configured in `.env`
- **Documentation**: [Sixteen Theme SuperMemory Docs](../../laravel/Themes/Sixteen/docs/supermemory.md)

### 2. Context7 (✅ Installed - Context)
- **Package**: `@upstash/context7-mcp`
- **Purpose**: Code documentation and context retrieval
- **Location**: `.qwen/mcp-servers/`

### 3. Filesystem (✅ Built-in - Dev)
- **Package**: `@modelcontextprotocol/server-filesystem`
- **Purpose**: Safe file operations with permission controls

### 4. Chrome DevTools (✅ Installed - Browser)
- **Package**: `chrome-devtools-mcp`
- **Purpose**: Screenshot capture, visual comparison, debugging

---

## 🔧 Configuration

All MCP configuration is centralized in:
- **Config File**: `.qwen/mcp-servers/config.json`
- **Environment**: `.env` (API keys)
- **Dependencies**: `.qwen/mcp-servers/package.json`

---

## 📚 Documentation Structure (DRY)

```
.qwen/mcp-servers/
├── README.md                    # Master MCP documentation
├── config.json                  # MCP server configuration
├── package.json                 # Node.js dependencies
└── node_modules/               # Installed packages

laravel/Themes/Sixteen/.supermemory/
├── README.md                   # SuperMemory usage guide
├── config.json                 # SuperMemory project config
└── init-memories.js           # Memory initialization script

docs/
├── project/
│   └── mcp-overview.md        # This file (project-level)
└── README.md                   # Master index (links here)
```

**Cross-References**:
- [MCP Servers Detailed Docs](../../.qwen/mcp-servers/README.md)
- [Sixteen Theme SuperMemory](../../laravel/Themes/Sixteen/docs/supermemory.md)
- [AI Workflow](ai-workflow/)
- [Project Configuration](configuration.md)

---

## 🎯 Usage Patterns

### Before Starting Work
```javascript
// 1. Search existing memories
const context = await client.search.memories({
  q: 'css parity workflow',
  containerTag: 'fixcity-sixteen'
});

// 2. Get project profile
const profile = await client.profile({
  containerTag: 'fixcity-sixteen',
  q: 'tech stack laravel'
});
```

### After Completing Work
```javascript
// Store results
await client.add({
  content: 'Fixed CSS parity for segnalazione pages',
  containerTag: 'fixcity-sixteen',
  metadata: { type: 'css-fix', date: '2026-04-09' }
});
```

### Visual Verification
```bash
# Using Chrome DevTools MCP
cd laravel/Themes/Sixteen
npm run build && npm run copy
# Then capture screenshots for comparison
```

---

## 📊 Memory Statistics

**SuperMemory Container**: `fixcity-sixteen`

| Memory Type | Count | Description |
|-------------|-------|-------------|
| Architecture | 3 | Project overview, tech stack, modules |
| Frontend | 2 | Theme system, Design Comuni |
| Development | 3 | Workflow, critical rules, lessons learned |
| Process | 2 | Documentation strategy, methodology |
| Results | 2 | HTML parity scores, visual issues |

**Total**: 12+ project memories stored

---

## 🔗 Related Documentation

- [Master Index](../README.md)
- [MCP Servers Full Documentation](../../.qwen/mcp-servers/README.md)
- [Sixteen Theme SuperMemory](../../laravel/Themes/Sixteen/docs/supermemory.md)
- [AI Workflow](ai-workflow/)
- [Conventions](conventions/)

---

*Last Updated: 2026-04-09*

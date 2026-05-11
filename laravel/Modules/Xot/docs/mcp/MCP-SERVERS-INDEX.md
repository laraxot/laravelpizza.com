# MCP Servers Configuration - Master Index

**Ultimo aggiornamento**: 2026-04-09  
**Config file**: `laravel/.mcp.json`  
**Memory Bank**: `.memory-bank/`  
**Totale Server**: 9 MCP servers configurati

## 📋 Server Installati

| Server | ⭐ Stars | Tipo | Scopo | Stato |
|--------|---------|------|-------|-------|
| **laravel-boost** | - | Laravel | Artisan commands, docs search, debugging | ✅ Attivo |
| **memory** | Official | Knowledge Graph | Persistent memory across sessions | ✅ Attivo |
| **memory-bank** | 893 | Memory Bank | Structured project memory management | ✅ Nuovo |
| **context7** | 52,094 | Code Docs | Up-to-date documentation lookup | ✅ Nuovo |
| **filesystem** | Official | File System | Safe file operations | ✅ Attivo |
| **sqlite** | Official | Database | Database queries and inspection | ✅ Attivo |
| **sequential-thinking** | Official | Reasoning | Chain-of-thought analysis | ✅ Attivo |
| **fetch** | Official | Web | HTTP requests and web scraping | ✅ Attivo |
| **github** | Official | Git | Repository management | ✅ Attivo |

## 🧠 Memory MCP Servers (3 servers)

### 1. Knowledge Graph Memory (Official)
- **Package**: `@modelcontextprotocol/server-memory`
- **Storage**: Local JSON file
- **Use case**: Ricordare preferenze utente, contesto progetto, decisioni
- **Tools**: `create_entities`, `add_observations`, `search_entities`
- **Docs**: [Official README](https://github.com/modelcontextprotocol/servers/tree/main/src/memory)

### 2. Memory Bank MCP
- **Package**: `memory-bank-mcp` (⭐893)
- **Storage**: `.memory-bank/` directory
- **Use case**: Memoria strutturata per progetto con file markdown
- **Pattern**: Cline Memory Bank inspired
- **Struttura**:
  ```
  .memory-bank/
  ├── activeContext.md    → Contesto sessione corrente
  ├── productContext.md   → Descrizione progetto, goals
  ├── progress.md         → Stato avanzamento, decisioni
  ├── systemPatterns.md   → Pattern architetturali
  └── techContext.md      → Stack tecnico, vincoli
  ```

### 3. Context7 (Upstash)
- **Package**: `@upstash/context7-mcp` (⭐52,094)
- **Tipo**: Code documentation lookup
- **Use case**: Documentazione aggiornata per librerie/framework
- **API Key**: Richiesta (gratuita su context7.com)
- **Docs**: [context7 GitHub](https://github.com/upstash/context7)

## 🛠️ Utility MCP Servers (6 servers)

### Development Tools
- **laravel-boost**: Artisan, Folio routes, Filament docs, debugging
- **filesystem**: File operations con scope limitato a project root
- **sqlite**: Query dirette al database SQLite

### Reasoning & Web
- **sequential-thinking**: Analisi strutturata problemi complessi
- **fetch**: HTTP requests per API e web scraping
- **github**: Gestione repository, issues, PR

## 🔧 Configurazione

### File Principale
```json
// laravel/.mcp.json
{
  "mcpServers": {
    "memory": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-memory"]
    },
    "memory-bank": {
      "command": "npx",
      "args": ["-y", "memory-bank-mcp", "/path/to/.memory-bank"]
    },
    "context7": {
      "command": "npx",
      "args": ["-y", "@upstash/context7-mcp"],
      "env": {
        "CONTEXT7_API_KEY": "${CONTEXT7_API_KEY}"
      }
    }
  }
}
```

### Variabili d'Ambiente
```bash
# .env del progetto
CONTEXT7_API_KEY=your_api_key_here
GITHUB_TOKEN=your_github_token
```

## 📚 Documentazione Correlata

- **Module Docs**: `Modules/*/docs/mcp/` - Uso MCP per modulo specifico
- **Theme Docs**: `Themes/*/docs/mcp/` - MCP per frontend development
- **Bash Scripts**: `bashscripts/docs/mcp-configuration.md` - Script utility
- **Memory Bank**: `.memory-bank/` - Memoria persistente progetto

## 🎯 Best Practices

### DRY + KISS
- ✅ Un solo file `.mcp.json` canonico in `laravel/.mcp.json`
- ✅ Memory bank in `.memory-bank/` (root project)
- ✅ NO duplicati di configurazione
- ✅ Cross-reference links tra docs

### Quando Usare Quale Server
| Scenario | Server Consigliato |
|----------|-------------------|
| Ricordare preferenze utente | `memory` (knowledge graph) |
| Contesto sessione corrente | `memory-bank` |
| Documentazione librerie | `context7` |
| Debug Laravel | `laravel-boost` |
| Query database | `sqlite` |
| Analisi complessa | `sequential-thinking` |

## 🚀 Setup Rapido

```bash
# 1. Installare dipendenze (automatico con npx -y)
# 2. Creare memory bank
mkdir -p .memory-bank

# 3. Configurare API keys (opzionale)
echo "CONTEXT7_API_KEY=xxx" >> .env

# 4. Riavviare IDE/Editor per ricaricare MCP
```

## 📊 Stato Inizializzazione Memory Bank

- [x] Directory `.memory-bank/` creata
- [ ] File `activeContext.md` da creare
- [ ] File `productContext.md` da creare
- [ ] File `progress.md` da creare
- [ ] File `systemPatterns.md` da creare
- [ ] File `techContext.md` da creare

## Related Docs

- [MCP Development Skill](../../../docs/MCP-DEVELOPMENT.md)
- [Project Configuration](../../../docs/project/configuration.md)
- [AI Workflow](../../../docs/project/ai-workflow/)
- Theme MCP: [Sixteen Theme MCP](../../../Themes/Sixteen/docs/mcp/MCP-THEME-SETUP.md)

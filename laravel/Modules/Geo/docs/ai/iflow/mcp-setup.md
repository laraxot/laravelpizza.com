# Setup MCP per iFlow CLI - PTVX

---

## Panoramica MCP

iFlow CLI supporta MCP tramite configurazione in `~/.iflow/settings.json` o `./.iflow/settings.json` (project-scoped).

---

## Configurazione File

### 1. Configurazione Globale

**Percorso**: `~/.iflow/settings.json`

```json
{
  "baseUrl": "https://api.openai.com/v1",
  "modelName": "gpt-4",
  "mcpServers": {
    "laravel-boost": {
      "command": "php",
      "args": [
        "/var/www/_bases/base_ptvx_fila5_mono/laravel/artisan",
        "boost:mcp"
      ]
    },
    "filesystem": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-filesystem",
        "/var/www/_bases/base_ptvx_fila5_mono/laravel",
        "/var/www/_bases/base_ptvx_fila5_mono/docs",
        "/var/www/_bases/base_ptvx_fila5_mono/bashscripts"
      ]
    },
    "memory": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-memory"
      ]
    },
    "fetch": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-fetch"
      ]
    },
    "sequential-thinking": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-sequential-thinking"
      ]
    },
    "mysql": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-mysql"
      ],
      "env": {
        "MYSQL_HOST": "${DB_HOST}",
        "MYSQL_PORT": "${DB_PORT}",
        "MYSQL_USER": "${DB_USERNAME}",
        "MYSQL_PASSWORD": "${DB_PASSWORD}",
        "MYSQL_DATABASE": "${DB_DATABASE}"
      }
    },
    "git": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-git",
        "--repository",
        "/var/www/_bases/base_ptvx_fila5_mono"
      ]
    }
  }
}
```

---

### 2. Configurazione Progetto

**Percorso**: `./.iflow/settings.json` (nella root del progetto)

La configurazione progetto sovrascrive quella globale.

**Best Practice**: Usa configurazione progetto per team consistency.

---

## Server MCP Configurati

Stessi server di Claude Code e Gemini. Vedi [Setup MCP Claude](../claude/mcp-setup.md) per dettagli completi.

---

## iFlow Open Market

iFlow ha un marketplace integrato per installare SubAgents e MCP con 1 click:

1. Accedi a [iFlow Platform](https://platform.iflow.cn/)
2. **Open Market**
3. Cerca "MCP" o "Laravel"
4. Installa server necessari

---

## Installazione Server MCP

Stessa procedura di Claude Code. I server vengono installati automaticamente al primo utilizzo tramite `npx -y`.

---

## Verifica Configurazione

```bash
# Test iFlow CLI
iflow

# Verifica server MCP
> /agent
# Dovrebbe mostrare lista SubAgents e MCP disponibili
```

---

## Collegamenti Correlati

- [Installazione](./installation.md)
- [Workflow](./workflow.md)
- [Best Practices](./best-practices.md)
- [MCP Configuration PTVX](../../../laravel/Modules/Xot/docs/mcp-configuration-ptvx.md)

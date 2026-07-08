# Setup MCP per Gemini Code Assist - PTVX

---

## Panoramica MCP

Model Context Protocol (MCP) permette a Gemini Code Assist di interagire con strumenti esterni, database, API e servizi.

---

## Configurazione File

### File: `~/.gemini/settings.json`

```json
{
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

## Server MCP Configurati

Stessi server di Claude Code. Vedi [Setup MCP Claude](../claude/mcp-setup.md) per dettagli completi.

---

## Configurazione VS Code

### Aggiungi in `.vscode/settings.json`

```json
{
  "gemini.mcp.enabled": true,
  "gemini.mcp.configPath": "~/.gemini/settings.json"
}
```

---

## Configurazione IntelliJ

### Plugin Settings

1. **File → Settings → Tools → Gemini Code Assist**
2. **MCP Configuration**
3. Seleziona `~/.gemini/settings.json`
4. **Apply** e **OK**

---

## Installazione Server MCP

Stessa procedura di Claude Code. I server vengono installati automaticamente al primo utilizzo.

---

## Gestione Sicurezza

Stesse best practices di Claude Code:
- Variabili d'ambiente per credenziali
- Path limitati per filesystem
- Permessi file protetti

---

## Collegamenti Correlati

- [Configurazione](./configuration.md)
- [Workflow](./workflow.md)
- [Agent Mode](./agent-mode.md)
- [MCP Configuration PTVX](../../../laravel/Modules/Xot/docs/mcp-configuration-ptvx.md)

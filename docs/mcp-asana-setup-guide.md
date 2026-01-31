# Guida Configurazione Asana MCP Server

**Data**: 2026-01-30
**Stato**: Configurato per tutti gli agenti AI

---

## Cos'e' Asana MCP Server

Asana offre un server MCP (Model Context Protocol) che permette agli assistenti AI di accedere al Work Graph di Asana. Con 30+ tools, gli agenti possono:
- Creare e gestire task
- Aggiornare progetti e status
- Cercare informazioni utente
- Aggiornare goals
- Organizzare team
- Cercare oggetti via typeahead

**URL Server**: `https://mcp.asana.com/sse`
**Autenticazione**: OAuth (richiesta al primo utilizzo)

---

## Configurazione per Piattaforma

### Claude Code (CLI)

```bash
claude mcp add --transport sse asana https://mcp.asana.com/sse
```

**File config**: `.claude/mcp.json`
```json
{
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://mcp.asana.com/sse"]
    }
  }
}
```

### Cursor

**File config**: `.cursor/mcp.json`
```json
{
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.asana.com/sse"]
    }
  }
}
```

### Windsurf

**File config**: `.windsurf/mcp.json`
```json
{
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.asana.com/sse"]
    }
  }
}
```

### VS Code

**File config**: `.vscode/mcp.json`
```json
{
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://mcp.asana.com/sse"]
    }
  }
}
```

### Gemini

**File config**: `.gemini/mcp-config.json`
```json
{
  "servers": [
    {
      "name": "asana",
      "command": ["npx", "mcp-remote", "https://mcp.asana.com/sse"]
    }
  ]
}
```

### Claude.ai (Enterprise/Teams)

1. Settings -> Integrations -> Add server
2. Nome: "Asana", URL: `https://mcp.asana.com/sse`
3. Autenticarsi via OAuth
4. Selezionare tools da abilitare

---

## File Configurati nel Progetto

| File | Piattaforma | Stato |
|------|------------|-------|
| `.claude/mcp.json` | Claude Code | Configurato |
| `.cursor/mcp.json` | Cursor | Configurato |
| `.windsurf/mcp.json` | Windsurf | Configurato |
| `bashscripts/ai/.claude/mcp.json` | Claude (backup) | Configurato |
| `bashscripts/ai/.cursor/mcp.json` | Cursor (backup) | Configurato |
| `bashscripts/ai/.vscode/mcp.json` | VS Code | Configurato |

---

## Troubleshooting

- **"Internal Server Error"**: Eliminare `~/.mcp-auth` con `rm -rf ~/.mcp-auth`
- **"invalid_redirect_uri"**: Contattare Asana Support per registrare redirect URI
- **Autenticazione fallita**: Logout/login dall'account Asana
- **Client non supporta SSE**: Verificare che il client supporti Server-Sent Events

---

## Tools Disponibili (30+)

Dopo l'autenticazione, i tools si scoprono automaticamente via `tools/list`. Principali:
- Gestione task (create, update, search, assign)
- Gestione progetti (status, timeline)
- Gestione utenti (info, assignments)
- Gestione goals
- Ricerca typeahead
- Organizzazione team

---

## Riferimenti

- [Documentazione Asana MCP](https://developers.asana.com/docs/using-asanas-mcp-server)
- [MCP Protocol](https://modelcontextprotocol.io/)

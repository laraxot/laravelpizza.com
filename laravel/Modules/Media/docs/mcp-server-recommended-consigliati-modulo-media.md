---
issues: []
discussions: []
title: "MCP Server Consigliati per il Modulo Media"
module: "Media"
type: concept
tags: [mcp, server, recommended, 1]
created: 2026-07-14
updated: 2026-07-14
qmd: "mcp server recommended 1"
related:
  - "./webm.md"
status: superseded
superseded_by: mcp-server-recommended.md
---
# MCP Server Consigliati per il Modulo Media

## Scopo del Modulo
Gestione media, upload, conversioni e streaming.

## Server MCP Consigliati
- `filesystem`: Per gestione file media, upload e conversioni.
- `fetch`: Per recupero o invio media a servizi esterni.
- `memory`: Per caching temporaneo durante le operazioni di conversione.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] },
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] }
  }
}
```

## Note
- Personalizza la configurazione per esigenze di streaming o CDN.

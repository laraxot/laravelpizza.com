---
title: "mcp server recommended"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "mcp server recommended"
issues: []
discussions: []
---

# MCP Server Consigliati per il Modulo Gdpr

## Scopo del Modulo
Gestione privacy, consensi e compliance GDPR.

## Server MCP Consigliati
- `filesystem`: Per archiviazione consensi e log privacy.
- `memory`: Per gestione temporanea delle sessioni di consenso.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] }
  }
}
```

## Note
- Adatta la configurazione a seconda dei requisiti di compliance e audit.

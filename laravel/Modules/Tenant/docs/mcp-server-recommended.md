---
issues: []
discussions: []
title: "MCP Server Consigliati per il Modulo Tenant"
module: "Tenant"
type: concept
tags: [mcp, server, recommended]
created: 2026-07-14
updated: 2026-07-14
qmd: "mcp server recommended"
related:
  - "./phpstan-corrections-january.md"
---
# MCP Server Consigliati per il Modulo Tenant

## Scopo del Modulo
Gestione multi-tenant, isolamento dati e provisioning tenant.

## Server MCP Consigliati
- `filesystem`: Per gestione file e configurazioni tenant.
- `fetch`: Per provisioning e sincronizzazione dati tra tenant.
- `memory`: Per stato temporaneo e sessioni tenant.

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
- Adatta la configurazione per esigenze di isolamento o sincronizzazione avanzata.

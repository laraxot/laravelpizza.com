---
title: "MCP Server Consigliati per il Modulo Notify"
type: concept
tags: [mcp, server, recommended]
created: 2026-07-14
updated: 2026-07-14
qmd: "mcp-server-recommended-1 mcp server consigliati per il modulo notify"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: superseded
superseded_by: ../../mcp-server-recommended.md
---

# MCP Server Consigliati per il Modulo Notify

## Scopo del Modulo
Gestione notifiche, alert e comunicazioni multicanale.

## Server MCP Consigliati
- `fetch`: Per invio notifiche a servizi esterni (email, SMS, push).
- `memory`: Per gestione temporanea delle notifiche in coda.
- `redis`: Per code di notifiche e gestione eventi.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] },
    "redis": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-redis"] }
  }
}
```

## Note
- Estendi la configurazione per canali di notifica personalizzati.

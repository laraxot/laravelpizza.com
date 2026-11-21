---
issues: []
discussions: []
title: "MCP Server Consigliati per il Modulo Lang"
module: "Lang"
type: concept
tags: [guida, migrazione, step, by]
created: 2026-07-14
updated: 2026-07-14
qmd: "guida migrazione step by step"
related:
  - "./italian-text-refined-audit-report.md"
---
# MCP Server Consigliati per il Modulo Lang

## Scopo del Modulo
Gestione traduzioni, localizzazione e internazionalizzazione.

## Server MCP Consigliati
- `filesystem`: Per gestione file di traduzione e risorse linguistiche.
- `memory`: Per caching temporaneo delle traduzioni.

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
- Estendi la configurazione per supportare traduzioni dinamiche o servizi esterni.

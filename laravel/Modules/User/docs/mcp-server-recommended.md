---
title: "MCP Server Consigliati per il Modulo User"
type: concept
tags: [mcp, server, recommended]
created: 2026-07-14
updated: 2026-07-14
qmd: "mcp-server-recommended mcp server consigliati per il modulo user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# MCP Server Consigliati per il Modulo User

## Scopo del Modulo
Gestione utenti, autenticazione, profili e permessi.

## Server MCP Consigliati
- `memory`: Per sessioni utente e stato temporaneo.
- `filesystem`: Per gestione avatar, documenti e file utente.
- `fetch`: Per integrazione con servizi esterni (es. SSO, OAuth).

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] },
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] },
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] }
  }
}
```

## Note
- Estendi la configurazione per esigenze di autenticazione avanzata o integrazione esterna.

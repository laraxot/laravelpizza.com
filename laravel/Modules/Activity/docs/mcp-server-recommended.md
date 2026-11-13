<<<<<<< .merge_file_TZidP1
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_cQwWu0
---
module: theme
topic: MCP_SERVER_RECOMMENDED
canonical: ../../../Themes/docs/shared-components/MCP-SERVER-RECOMMENDED.md
<<<<<<< .merge_file_TZidP1
---

See canonical documentation: ../../../Themes/docs/shared-components/MCP-SERVER-RECOMMENDED.md
=======
=======
>>>>>>> 35d8cf69 (Initial commit)
=======
title: "MCP Server Consigliati per il Modulo Activity"
type: note
status: stub
updated: 2026-10-08
tags: [docs, activity]
qmd: "mcp server consigliati per il modulo activity activity"
---

See canonical documentation: ../../../Themes/docs/shared-components/MCP-SERVER-RECOMMENDED.md
>>>>>>> .merge_file_cQwWu0


>>>>>>> laraxot/dev
# MCP Server Consigliati per il Modulo Activity

## Scopo del Modulo
Gestione delle attività utente, log, cron e tracciamento eventi.

## Server MCP Consigliati
- `memory`: Per tracciare lo stato temporaneo delle attività.
- `filesystem`: Per log persistenti e archiviazione file attività.
- `fetch`: Per invio/ricezione di eventi da servizi esterni.

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
- Adatta la configurazione se il modulo interagisce con sistemi di terze parti.
<<<<<<< HEAD
>>>>>>> 0a02158a (.)
=======
>>>>>>> 35d8cf69 (Initial commit)

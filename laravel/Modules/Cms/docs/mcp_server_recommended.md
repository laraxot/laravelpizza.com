# MCP Server Consigliati per il Modulo Cms

## Scopo del Modulo
Gestione contenuti, pagine, menu e asset digitali del sito.

## Server MCP Consigliati
- `filesystem`: Per gestione asset, immagini, file e media.
- `fetch`: Per integrazione con API esterne (es. import/export contenuti).
- `memory`: Per caching temporaneo dei contenuti durante l'editing.

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
- Estendi la configurazione se il CMS gestisce workflow avanzati o automazioni.

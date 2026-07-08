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

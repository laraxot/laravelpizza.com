# MCP Server Consigliati per il Modulo Xot

## Scopo del Modulo
Modulo base/framework: fornisce servizi trasversali, integrazione tra componenti, azioni comuni.

## Server MCP Consigliati
- `filesystem`: Per gestione file e configurazioni cross-modulo.
- `fetch`: Per chiamate API da azioni condivise.
- `memory`: Per stato temporaneo tra moduli o azioni.

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
- Xot non richiede MCP custom, ma può essere esteso da altri moduli.

# MCP Server Consigliati per il Modulo UI

## Scopo del Modulo
Gestione interfaccia utente, componenti, asset e frontend.

## Server MCP Consigliati
- `filesystem`: Per gestione asset, immagini, file statici.
- `fetch`: Per recupero dati dinamici da API.
- `memory`: Per stato temporaneo dell'interfaccia (es. wizard, step form).

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
- Personalizza la configurazione per esigenze di frontend avanzato.

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

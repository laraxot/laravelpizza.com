# MCP Server Consigliati per il Modulo Geo

## Scopo del Modulo
Gestione dati geografici, mappe e geolocalizzazione.

## Server MCP Consigliati
- `fetch`: Per recupero dati geografici da API esterne.
- `memory`: Per caching temporaneo di dati geospaziali.
- `filesystem`: Per gestione file geojson, shapefile, ecc.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] },
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] }
  }
}
```

## Note
- Estendi la configurazione se il modulo gestisce analisi geospaziali avanzate.

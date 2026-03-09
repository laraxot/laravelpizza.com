# MCP Server Consigliati (Geo + Chart)

## Scopo
Gestione dati geografici, mappe, geolocalizzazione e grafici ad alta qualita.

## Server MCP Consigliati
- `fetch`: Per recupero dati geografici da API esterne.
- `memory`: Per caching temporaneo di dati geospaziali.
- `filesystem`: Per gestione file geojson, shapefile, ecc.
- `@antv/mcp-server-chart`: Generazione grafici rapida (line, bar, pie, ecc.) con output consistente.
- `mcp-echarts`: Configurazioni avanzate ECharts per dashboard e visual interattive.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] },
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] },
    "chart-antv": { "command": "npx", "args": ["-y", "@antv/mcp-server-chart"] },
    "chart-echarts": { "command": "npx", "args": ["-y", "mcp-echarts"] }
  }
}
```

## Note
- Estendi la configurazione se il modulo gestisce analisi geospaziali avanzate.
- Verifica periodicamente le versioni npm dei server MCP chart prima di aggiornare lock/pipeline.

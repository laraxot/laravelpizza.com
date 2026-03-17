# Server MCP consigliati per il modulo Seo

## Scopo del modulo
Analisi SEO, automazione di audit, recupero dati da web, generazione di report.

## Server MCP consigliati
- **fetch**: Per recuperare dati da web, API SEO, strumenti di analisi.
- **memory**: Per mantenere stato tra analisi e report.
- **puppeteer**: Per automazione browser, crawling, screenshot, analisi pagine.
- **everything**: Per avere tutte le funzionalità MCP disponibili.

## Esempio di configurazione MCP
```json
{
  "mcpServers": {
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] },
    "puppeteer": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-puppeteer"] },
    "everything": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-everything"] }
  }
}
```

**Nota:**
Aggiungi solo i server che realmente ti servono per il tuo workflow. 

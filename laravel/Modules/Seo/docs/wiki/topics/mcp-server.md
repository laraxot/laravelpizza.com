---
title: "Topic mcp-server"
type: digest
status: active
qmd: "digest ceiling 100 mcp-server"
---

# Topic mcp-server

Sintesi automatica di 6 documenti (chiave `mcp-server`).

## Server MCP consigliati per il modulo Seo

_Fonte: `mcp-server-consigliati-2.md`_

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

## Server MCP consigliati per il modulo Seo

_Fonte: `mcp-server-consigliati-3.md`_

module: theme
topic: mcp_server_consigliati
canonical: ../../../Themes/docs/shared-components/mcp-server-consigliati-2.md
---

See canonical documentation: ../../../Themes/docs/shared-components/mcp-server-consigliati-2.md
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

## Server MCP consigliati per il modulo Seo

_Fonte: `mcp-server-consigliati.md`_

See canonical documentation: ../../../Themes/docs/shared-components/mcp-server-consigliati-2.md
---
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

## Server MCP consigliati per Seo

_Fonte: `mcp-server-recommended-2.md`_

# Server MCP consigliati per Seo

Per il modulo Seo, si consiglia di utilizzare i seguenti server MCP:

- **sequential-thinking**: per orchestrare workflow di analisi SEO, brainstorming di strategie e automazione di processi decisionali step-by-step.
- **memory**: per mantenere una knowledge base di keyword, risultati di analisi, pattern di ottimizzazione e storico delle campagne.
- **filesystem**: per esportare report SEO, importare liste di keyword o salvare configurazioni di analisi.
- **postgres**: se il modulo utilizza un database PostgreSQL per archiviare dati di analisi, keyword o risultati di crawling.
- **puppeteer**: per automatizzare il crawling di siti web, scraping di SERP, raccolta di dati SEO da pagine web e generazione di screenshot.

**Nota:**
- Usa solo server MCP Node.js disponibili su npm e avviabili con `npx`.
- Configura sempre gli argomenti obbligatori (es. directory per filesystem, stringa di connessione per postgres).
- Non usare fetch, mysql o redis se non attivo.

Per dettagli e best practice consulta la guida generale MCP nel workspace.

## Server MCP consigliati per Seo

_Fonte: `mcp-server-recommended-3.md`_

module: theme
topic: mcp_server_recommended
canonical: ../../../Themes/docs/shared-components/mcp-server-recommended-2.md
---

See canonical documentation: ../../../Themes/docs/shared-components/mcp-server-recommended-2.md
# Server MCP consigliati per Seo

Per il modulo Seo, si consiglia di utilizzare i seguenti server MCP:

- **sequential-thinking**: per orchestrare workflow di analisi SEO, brainstorming di strategie e automazione di processi decisionali step-by-step.
- **memory**: per mantenere una knowledge base di keyword, risultati di analisi, pattern di ottimizzazione e storico delle campagne.
- **filesystem**: per esportare report SEO, importare liste di keyword o salvare configurazioni di analisi.
- **postgres**: se il modulo utilizza un database PostgreSQL per archiviare dati di analisi, keyword o risultati di crawling.
- **puppeteer**: per automatizzare il crawling di siti web, scraping di SERP, raccolta di dati SEO da pagine web e generazione di screenshot.

**Nota:**
- Usa solo server MCP Node.js disponibili su npm e avviabili con `npx`.
- Configura sempre gli argomenti obbligatori (es. directory per filesystem, stringa di connessione per postgres).
- Non usare fetch, mysql o redis se non attivo.

Per dettagli e best practice consulta la guida generale MCP nel workspace.

## Server MCP consigliati per Seo

_Fonte: `mcp-server-recommended.md`_

See canonical documentation: ../../../Themes/docs/shared-components/mcp-server-recommended-2.md
---
# Server MCP consigliati per Seo

Per il modulo Seo, si consiglia di utilizzare i seguenti server MCP:

- **sequential-thinking**: per orchestrare workflow di analisi SEO, brainstorming di strategie e automazione di processi decisionali step-by-step.
- **memory**: per mantenere una knowledge base di keyword, risultati di analisi, pattern di ottimizzazione e storico delle campagne.
- **filesystem**: per esportare report SEO, importare liste di keyword o salvare configurazioni di analisi.
- **postgres**: se il modulo utilizza un database PostgreSQL per archiviare dati di analisi, keyword o risultati di crawling.
- **puppeteer**: per automatizzare il crawling di siti web, scraping di SERP, raccolta di dati SEO da pagine web e generazione di screenshot.

**Nota:**
- Usa solo server MCP Node.js disponibili su npm e avviabili con `npx`.
- Configura sempre gli argomenti obbligatori (es. directory per filesystem, stringa di connessione per postgres).
- Non usare fetch, mysql o redis se non attivo.

Per dettagli e best practice consulta la guida generale MCP nel workspace.

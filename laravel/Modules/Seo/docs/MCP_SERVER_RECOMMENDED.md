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

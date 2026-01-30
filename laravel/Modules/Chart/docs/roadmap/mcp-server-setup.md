# Configurazione MCP Servers per Cursor

## Descrizione

Questo documento descrive la procedura per configurare e gestire i Model Context Protocol (MCP) Servers utilizzati da Cursor all'interno del progetto <nome progetto>. Gli MCP Servers estendono le funzionalità dell'assistente AI fornendo accesso a strumenti e dati esterni.

## Implementazione

### Script di Avvio e Arresto

I seguenti script sono stati implementati per gestire i MCP servers:

1. **start-mcp**: Avvia tutti i MCP servers necessari per Cursor
   - Configura correttamente le dimensioni del terminale per evitare problemi di visualizzazione
   - Avvia i server Memory, Puppeteer e MySQL in background
   - Registra l'output in file di log per facilitare il debugging

2. **stop-mcp**: Arresta tutti i MCP servers in esecuzione
   - Identifica correttamente i processi associati ai server
   - Effettua un arresto pulito quando possibile
   - Forza la terminazione quando necessario

3. **mysql**: Script specializzato per avviare il server MCP MySQL
   - Configura correttamente le dimensioni del terminale
   - Utilizza il connector script appropriato
   - Risolve problemi comuni di connessione

### Struttura della Directory

```
/var/www/html/<nome progetto>/
└── bashscripts/
    └── mcp/
        ├── start-mcp       # Script principale di avvio
        ├── stop-mcp        # Script di arresto
        └── mysql           # Script specializzato per MySQL
```

## Stato Attuale (Maggio 2025)

- ✅ Script di avvio e arresto implementati
- ✅ Configurazione corretta delle dimensioni del terminale
- ✅ Directory strutturata secondo le convenzioni del progetto
- 🚧 Integrazione con il sistema di logging di <nome progetto> (80%)
- 🚧 Test su diversi ambienti (50%)

## Prossimi Passi

### Breve Termine (Q2 2025)
- [ ] Completare l'integrazione con il sistema di logging
- [ ] Finalizzare i test su tutti gli ambienti supportati
- [ ] Aggiungere supporto per MCP server aggiuntivi

### Medio Termine (Q3-Q4 2025)
- [ ] Sviluppare interfaccia di amministrazione per i MCP servers
- [ ] Implementare monitoraggio automatico dello stato
- [ ] Creare meccanismi di fallback per i server MCP

## Collegamenti Correlati

- [Documentazione Bash Scripts](../bashscripts.md)
- [Best Practices per Script Bash](../rules/bashscripts-standards.md)
- [Configurazione Cursor](../ide/cursor/configuration.md)

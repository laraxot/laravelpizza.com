# Introduzione ai Server MCP per Progetti Laravel

## Panoramica

I server MCP (Model Context Protocol) estendono le capacità degli assistenti AI come Claude, GPT e altri modelli linguistici, consentendo loro di interagire con sistemi esterni, eseguire calcoli complessi e accedere a dati in tempo reale. Questa documentazione fornisce una guida completa per l'installazione, configurazione e utilizzo dei server MCP in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## Cos'è il Model Context Protocol (MCP)

Il Model Context Protocol è uno standard che definisce come i modelli linguistici possono comunicare con strumenti esterni. Consente ai modelli di:

1. Richiedere informazioni da fonti esterne
2. Eseguire azioni nel mondo reale
3. Accedere a dati in tempo reale
4. Interagire con database e altri sistemi

## Server MCP Supportati

Questa documentazione copre i seguenti server MCP:

1. **sequential-thinking** - Per la risoluzione di problemi complessi
2. **memory** - Per memorizzare informazioni durante le conversazioni
3. **fetch** - Per richieste HTTP verso API esterne
4. **filesystem** - Per operazioni sul filesystem
5. **postgres** - Per interagire con database PostgreSQL
6. **redis** - Per cache e code in Laravel
7. **puppeteer** - Per automazione del browser
8. **mysql-custom** - Server personalizzato per MySQL che legge le configurazioni dal file `.env` di Laravel

## Struttura della Documentazione

Questa documentazione è organizzata nelle seguenti sezioni:

1. **Installazione** - Come installare i server MCP e le dipendenze necessarie
2. **Configurazione** - Come configurare i server MCP per diversi ambienti (Windsurf, Cursor, VSCode)
3. **Utilizzo** - Come utilizzare i server MCP nei progetti Laravel
4. **Integrazione con i Moduli** - Come integrare i server MCP con i moduli Laravel
5. **Implementazione Pratica** - Esempi concreti di implementazione
6. **Risoluzione dei Problemi** - Soluzioni ai problemi comuni
7. **Script di Gestione** - Utilizzo degli script di gestione dei server MCP

## Requisiti

- PHP 8.0+
- Laravel 9.0+
- Node.js 16.0+
- npm 7.0+

## Convenzioni di Codice

Tutto il codice presentato in questa documentazione segue le seguenti convenzioni:

1. **Strict Types** - Tutti i file PHP utilizzano `declare(strict_types=1)`
2. **Tipizzazione Completa** - Tutte le proprietà, i parametri e i valori di ritorno sono tipizzati
3. **Documentazione** - Tutte le classi e i metodi sono documentati con DocBlocks completi
4. **SOLID** - I principi SOLID sono applicati in tutto il codice
5. **Disaccoppiamento** - Utilizzo di contratti/interfacce per il disaccoppiamento
6. **PHPStan** - Configurazione corretta dei livelli di PHPStan

## Riutilizzo in Altri Progetti

Questa documentazione è stata progettata per facilitare il riutilizzo dei server MCP in altri progetti. Tutte le configurazioni e gli script possono essere facilmente adattati a nuovi progetti seguendo le istruzioni fornite.

## Compatibilità con gli Editor

Le configurazioni presentate in questa documentazione sono compatibili con i seguenti editor:

1. **Windsurf** - Configurazione in `~/.codeium/windsurf/mcp_config.json`
2. **Cursor** - Configurazione in `~/.cursor/mcp.json` e `.cursor/mcp_config.json`
3. **VSCode** - Configurazione in `.vscode/mcp.json`

## Contribuire

Se desideri contribuire a questa documentazione o agli script di gestione dei server MCP, segui le linee guida per i contributi nel file `CONTRIBUTING.md`.

## Licenza

Questa documentazione e gli script correlati sono rilasciati sotto la licenza MIT.

---

Continua con la sezione [Installazione](./01_INSTALLAZIONE.md) per iniziare a configurare i server MCP per il tuo progetto Laravel.

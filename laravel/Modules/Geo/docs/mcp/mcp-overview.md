# Model Context Protocol (MCP) – Panoramica e Guida Rapida

> **Riferimenti ufficiali:**
> - [Documentazione MCP su Cursor](https://docs.cursor.com/context/model-context-protocol)
> - [Sito ufficiale MCP](https://modelcontextprotocol.io/introduction)
> - [Esempi pratici locali](./ESEMPI_PRACTICI_MCP.md)

---

## Cos'è MCP?
Il Model Context Protocol (MCP) è uno standard aperto che permette di estendere le capacità degli LLM (Large Language Model) integrando strumenti e dati esterni tramite interfacce standardizzate. MCP funge da sistema di plugin per Cursor e altre piattaforme compatibili, consentendo di collegare agent e assistenti a fonti dati, API e strumenti custom.

- **Obiettivo:** Fornire un protocollo unico per la comunicazione tra agenti AI e strumenti/servizi esterni.
- **Vantaggio:** Modularità, estendibilità, riuso di tool tra progetti diversi.

## Tipi di trasporto supportati

### 1. stdio Transport
- Eseguito localmente, gestito da Cursor
- Comunica via stdout/stdin (shell)
- Ideale per sviluppo locale e test
- Esempio di configurazione:
  ```jsonc
  {
    "mcpServers": {
      "nome-server": {
        "command": "npx",
        "args": ["-y", "mcp-server"],
        "env": { "API_KEY": "valore" }
      }
    }
  }
  ```

### 2. SSE Transport
- Può essere locale o remoto
- Comunica tramite endpoint di rete `/sse`
- Utile per team distribuiti o servizi centralizzati
- Esempio: `http://example.com:8000/sse`

## File di configurazione MCP

- **Progetto:** `.cursor/mcp.json` (solo per il progetto corrente)
- **Globale:** `~/.cursor/mcp.json` (valido per tutti i progetti)

Entrambi i file usano lo stesso schema JSON, vedi esempio sopra.

## Uso in Cursor/Chat
- Gli strumenti MCP vengono rilevati automaticamente e resi disponibili sotto "Available Tools" nelle impostazioni MCP di Cursor.
- Puoi abilitare/disabilitare singoli tool.
- Puoi richiedere esplicitamente l'uso di un tool MCP in chat menzionandolo per nome o descrizione.

## Limitazioni attuali
- **Numero tool:** Cursor supporta fino a 40 tool MCP attivi contemporaneamente.
- **Ambienti remoti:** MCP potrebbe non funzionare correttamente su SSH o ambienti di sviluppo remoti.
- **Risorse:** Al momento Cursor supporta solo "tools"; il supporto per "resources" è pianificato.

## Best Practice
- Gestire le variabili d'ambiente (API_KEY, ecc.) tramite il campo `env` nella configurazione.
- Preferire stdio per sviluppo locale, SSE per ambienti condivisi.
- Documentare ogni tool MCP sviluppato con esempi pratici (vedi [ESEMPI_PRACTICI_MCP.md](./ESEMPI_PRACTICI_MCP.md)).
- Aggiornare la documentazione ad ogni variazione di configurazione o aggiunta tool.

## Collegamenti utili
- [Esempi pratici MCP](./ESEMPI_PRACTICI_MCP.md)
- [Documentazione MCP Cursor](https://docs.cursor.com/context/model-context-protocol)
- [Guida ufficiale MCP](https://modelcontextprotocol.io/introduction)

---

*Ultimo aggiornamento: maggio 2025 – conforme a standard Laraxot, best practice Windsurf, e regole di documentazione interna.*

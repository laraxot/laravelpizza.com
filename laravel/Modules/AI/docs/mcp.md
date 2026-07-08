# Configurazione MCP (Model Context Protocol)

## Installazione

1. Installare l'estensione MCP per VS Code:
   - Aprire VS Code
   - Andare nella sezione estensioni
   - Cercare "MCP"
   - Installare l'estensione ufficiale

2. Configurare i server MCP:
   - Il file di configurazione si trova in `~/.codeium/windsurf/mcp_config.json`
   - Configurare i server necessari per il progetto

## Configurazione dei Server

Il sistema supporta tre ambienti:

### Default Server (Porta 3000)
```json
{
  "host": "localhost",
  "port": 3000,
  "protocol": "http",
  "timeout": 30000,
  "retryAttempts": 3,
  "retryDelay": 1000
}
```

### Development Server (Porta 3001)
```json
{
  "host": "localhost",
  "port": 3001,
  "protocol": "http",
  "timeout": 30000,
  "retryAttempts": 3,
  "retryDelay": 1000
}
```

### Production Server (Porta 3002)
```json
{
  "host": "localhost",
  "port": 3002,
  "protocol": "http",
  "timeout": 30000,
  "retryAttempts": 3,
  "retryDelay": 1000
}
```

## Funzionalità Configurate

### Logging
- Livello: info
- File: /var/log/mcp.log
- Rotazione: 10MB per file, massimo 5 file

### Sicurezza
- CORS abilitato per tutte le origini
- Metodi HTTP supportati: GET, POST, PUT, DELETE, OPTIONS
- Header consentiti: Content-Type, Authorization
- Dimensione massima richiesta: 10MB

### Cache
- Abilitata
- TTL: 1 ora
- Dimensione massima: 100MB

### Monitoraggio
- Metriche attive: CPU, Memoria, Disco, Rete
- Soglie di allerta:
  - CPU: 80%
  - Memoria: 80%
  - Disco: 80%

## Utilizzo

1. Avviare i server MCP:
   ```bash
   npx @modelcontextprotocol/server-sequential-thinking
   npx @modelcontextprotocol/server-puppeteer
   npx @modelcontextprotocol/server-everything
   npx @modelcontextprotocol/server-memory
   npx @modelcontextprotocol/server-slack
   npx @modelcontextprotocol/server-filesystem
   npx @modelcontextprotocol/server-brave-search
   npx @modelcontextprotocol/server-gdrive
   npx @modelcontextprotocol/server-everart
   npx @modelcontextprotocol/server-postgres
   ```

2. Verificare lo stato dei server:
   - Controllare i log in `/var/log/mcp.log`
   - Monitorare le metriche di sistema
   - Verificare le connessioni alle porte configurate

## Risoluzione Problemi

1. Se un server non risponde:
   - Verificare che la porta sia disponibile
   - Controllare i log per errori
   - Riavviare il server specifico

2. Problemi di performance:
   - Monitorare l'utilizzo delle risorse
   - Verificare le soglie di allerta
   - Ottimizzare la configurazione della cache

3. Errori di connessione:
   - Verificare le impostazioni di rete
   - Controllare i firewall
   - Verificare le configurazioni CORS

## Best Practices

1. Mantenere aggiornate le dipendenze
2. Monitorare regolarmente i log
3. Configurare backup automatici
4. Utilizzare ambienti separati per sviluppo e produzione
5. Implementare test automatici per le funzionalità MCP 

## Server MCP consigliati

Ecco i server MCP consigliati per un ambiente di sviluppo AI/ML moderno e automazione:

### 1. sequential-thinking
- **Comando:** npx -y @modelcontextprotocol/server-sequential-thinking
- **Motivo:** Fornisce capacità di ragionamento sequenziale e pianificazione, utili per task complessi e workflow multi-step.

### 2. memory
- **Comando:** npx -y @modelcontextprotocol/server-memory
- **Motivo:** Permette la gestione di una memoria contestuale persistente tra le richieste, fondamentale per agenti AI che devono ricordare informazioni tra sessioni.

### 3. fetch
- **Comando:** npx -y @modelcontextprotocol/server-fetch
- **Motivo:** Abilita l'accesso a risorse web e API esterne, utile per agenti che devono recuperare dati in tempo reale.

### 4. filesystem
- **Comando:** npx -y @modelcontextprotocol/server-filesystem
- **Motivo:** Consente la lettura e scrittura di file locali, indispensabile per automazioni che manipolano dati o generano report.

### 5. postgres
- **Comando:** npx -y @modelcontextprotocol/server-postgres
- **Motivo:** Integrazione diretta con database PostgreSQL, ideale per progetti che richiedono storage strutturato e query avanzate.

### 6. redis
- **Comando:** npx -y @modelcontextprotocol/server-redis
- **Motivo:** Supporta caching e storage temporaneo ad alte prestazioni, utile per task che richiedono velocità e scalabilità.

### 7. mysql
- **Comando:** npx -y @modelcontextprotocol/server-mysql
- **Motivo:** Integrazione con database MySQL, molto diffuso in ambito web e applicazioni legacy.

---

**Perché questi server:**
- Sono mantenuti ufficialmente dal progetto Model Context Protocol
- Coprono le esigenze principali di un ambiente AI/ML moderno (ragionamento, memoria, accesso dati, automazione, storage)
- Sono facilmente avviabili tramite `npx` e non richiedono configurazioni complesse

**Nota:**
Aggiungi solo i server che realmente ti servono per il tuo workflow. Puoi sempre estendere la configurazione in futuro. 

## MCP MySQL locale e variabili da Laravel

Per utilizzare il server MCP MySQL con le stesse credenziali del tuo progetto Laravel, segui questi passi:

1. **Crea lo script di avvio**
   - Crea un file chiamato `start-mcp-mysql.sh` nella root del progetto:
     ```bash
     #!/bin/bash
     set -a
     source /var/www/html/_bases/base_predict_fila5_mono/laravel/.env
     set +a
     npx -y @modelcontextprotocol/server-mysql
     ```
   - Rendi eseguibile lo script:
     ```bash
     chmod +x /var/www/html/_bases/base_predict_fila5_mono/start-mcp-mysql.sh
     ```

2. **Configura il server MCP MySQL solo a livello di progetto**
   - Nel file `.vscode/mcp.json` o `.cursor/mcp.json` del progetto, aggiungi:
     ```json
     "mysql": {
       "command": "./start-mcp-mysql.sh"
     }
     ```

3. **Motivazione**
   - In questo modo, il server MCP MySQL userà sempre le stesse variabili di connessione del tuo Laravel, senza duplicare le informazioni e senza rischi di inconsistenza.
   - Questa configurazione è locale al progetto e non globale, quindi ogni progetto può avere le sue credenziali.

**Nota:**
- Assicurati che il pacchetto `@modelcontextprotocol/server-mysql` sia installato globalmente o sia disponibile tramite npx.
- Puoi adattare lo script se il percorso del file `.env` è diverso. 

## Filosofia e policy MCP (Zen)

- Tutti i server MCP devono essere configurati in modo uniforme e minimale.
- Solo server MCP ufficiali e realmente utili al workflow.
- Tutti i server MCP sono avviati tramite `npx` (nessun path locale, nessun host/port, nessun env globale).
- Il server MySQL è sempre locale al progetto e avviato tramite lo script bash:
  `/var/www/html/_bases/base_predict_fila5_mono/bashscripts/mcp/mcp-manager-v2.sh`
- Nessuna duplicazione di variabili o configurazioni tra ambienti.
- Ogni modifica va applicata a tutti i file di configurazione coinvolti (VSCode, Cursor, Windsurf).
- La documentazione deve sempre riflettere questa filosofia di coerenza e semplicità.

---

## Struttura universale del file di configurazione MCP

Esempio da usare in `.vscode/mcp.json`, `.cursor/mcp.json`, `mcp_config.json` di Windsurf:

```json
{
  "mcpServers": {
    "sequential-thinking": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-sequential-thinking"]
    },
    "memory": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-memory"]
    },
    "fetch": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-fetch"]
    },
    "filesystem": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-filesystem"]
    },
    "postgres": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-postgres"]
    },
    "redis": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-redis"]
    },
    "mysql": {
      "command": "/var/www/html/_bases/base_predict_fila5_mono/bashscripts/mcp/mcp-manager-v2.sh"
    },
    "puppeteer": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
    },
    "everything": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-everything"]
    }
  }
}
```

---

## Come replicare la configurazione su altri progetti/PC

1. **Copia la struttura della cartella**
   - Assicurati che la cartella `bashscripts/mcp/` e lo script `mcp-manager-v2.sh` siano presenti nel nuovo progetto.
   - Aggiorna il path nello script se la struttura del progetto cambia.

2. **Copia il file di configurazione MCP**
   - Copia il file `mcp_config.json` (o `.vscode/mcp.json`, `.cursor/mcp.json`) nel nuovo progetto.
   - Se il percorso del progetto cambia, aggiorna il path dello script MySQL di conseguenza.

3. **Installa i server MCP necessari**
   - Su ogni PC, esegui:
     ```bash
     npm install -g @modelcontextprotocol/server-sequential-thinking @modelcontextprotocol/server-memory @modelcontextprotocol/server-fetch @modelcontextprotocol/server-filesystem @modelcontextprotocol/server-postgres @modelcontextprotocol/server-redis @modelcontextprotocol/server-puppeteer @modelcontextprotocol/server-everything
     ```
   - Oppure lascia che `npx` scarichi i pacchetti al primo avvio.

4. **Personalizza solo se necessario**
   - Se il progetto ha un file `.env` diverso per MySQL, aggiorna lo script `mcp-manager-v2.sh` per puntare al nuovo `.env`.

---

## Best Practice

- Mantieni sempre la stessa struttura e filosofia in tutti i progetti.
- Documenta ogni personalizzazione direttamente nella cartella `docs` del progetto.
- Aggiorna la documentazione ogni volta che cambi la configurazione MCP o la struttura delle cartelle.

---

**Seguendo questa filosofia, potrai installare e usare i server MCP in modo uniforme, semplice e senza sorprese su qualsiasi PC e progetto.**

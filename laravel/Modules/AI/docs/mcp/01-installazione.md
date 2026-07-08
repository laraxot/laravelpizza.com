# Installazione dei Server MCP per Progetti Laravel

## ⚠️ AVVISO IMPORTANTE SUL DATABASE

**ATTENZIONE:** Durante la configurazione del database, **NON** utilizzare MAI i seguenti comandi in produzione o in ambienti con dati critici:

```bash
php artisan migrate:fresh       # ELIMINA TUTTE LE TABELLE E I DATI
php artisan migrate:fresh --seed # ELIMINA TUTTO E RICARICA I DATI DI PROVA
php artisan db:wipe             # ELIMINA TUTTE LE TABELLE
```

Questi comandi **distruggeranno tutti i dati esistenti** nel database. Utilizzare SEMPRE comandi non distruttivi come `php artisan migrate` per applicare nuove migrazioni.

Per ulteriori dettagli, vedi il file `AVVISO_MIGRAZIONI.mdc` nella root del progetto.

## Panoramica

Questa guida fornisce istruzioni dettagliate per l'installazione dei server MCP (Model Context Protocol) in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## Prerequisiti

Prima di procedere con l'installazione dei server MCP, assicurati di avere:

1. **Node.js e npm**:
   ```bash
   node --version  # Deve essere 16.0.0 o superiore
   npm --version   # Deve essere 7.0.0 o superiore
   ```

2. **PHP e Composer**:
   ```bash
   php --version    # Deve essere 8.0.0 o superiore
   composer --version
   ```

3. **Laravel**:
   ```bash
   php artisan --version  # Deve essere 9.0.0 o superiore
   ```

4. **Permessi di scrittura** nelle directory di configurazione:
   ```bash
   # Per Windsurf
   mkdir -p ~/.codeium/windsurf
   
   # Per Cursor
   mkdir -p ~/.cursor
   
   # Per il progetto locale
   mkdir -p /path/to/your/project/bashscripts/mcp
   ```

## Installazione dei Server MCP Standard

I server MCP standard possono essere installati globalmente o localmente utilizzando npm.

### Installazione Globale (Consigliata)

L'installazione globale consente di utilizzare i server MCP in tutti i progetti:

```bash
# Server sequential-thinking
npm install -g @modelcontextprotocol/server-sequential-thinking

# Server memory
npm install -g @modelcontextprotocol/server-memory

# Server fetch
npm install -g @modelcontextprotocol/server-fetch

# Server filesystem
npm install -g @modelcontextprotocol/server-filesystem

# Server postgres
npm install -g @modelcontextprotocol/server-postgres

# Server redis
npm install -g @modelcontextprotocol/server-redis

# Server puppeteer
npm install -g @modelcontextprotocol/server-puppeteer
```

### Installazione Locale

Se preferisci un'installazione locale per ogni progetto:

```bash
cd /path/to/your/project

# Server sequential-thinking
npm install @modelcontextprotocol/server-sequential-thinking

# Server memory
npm install @modelcontextprotocol/server-memory

# Server fetch
npm install @modelcontextprotocol/server-fetch

# Server filesystem
npm install @modelcontextprotocol/server-filesystem

# Server postgres
npm install @modelcontextprotocol/server-postgres

# Server redis
npm install @modelcontextprotocol/server-redis

# Server puppeteer
npm install @modelcontextprotocol/server-puppeteer
```

## Installazione del Server MySQL Personalizzato

Il server MySQL standard non è disponibile nel registro npm. Per questo motivo, abbiamo creato un server MySQL personalizzato che legge le configurazioni dal file `.env` di Laravel.

### Prerequisiti per il Server MySQL Personalizzato

```bash
cd /path/to/your/project

# Installa le dipendenze necessarie
npm install mysql2 dotenv
```

### Creazione della Struttura delle Directory

```bash
# Crea la directory per gli script MCP
mkdir -p /path/to/your/project/bashscripts/mcp

# Crea la directory per i log
mkdir -p /path/to/your/project/storage/logs/mcp
chmod -R 777 /path/to/your/project/storage/logs/mcp
```

### Installazione degli Script di Gestione

Per facilitare la gestione dei server MCP, è necessario installare gli script di gestione:

```bash
# Copia gli script dalla repository o dal progetto di riferimento
cp /path/to/reference/project/bashscripts/mcp/* /path/to/your/project/bashscripts/mcp/

# Rendi gli script eseguibili
chmod +x /path/to/your/project/bashscripts/mcp/*.sh
chmod +x /path/to/your/project/bashscripts/mcp/*.js
```

## Installazione Automatica con Script

Per semplificare l'installazione, puoi utilizzare il seguente script:

```bash
#!/bin/bash

# Script di installazione dei server MCP
# Autore: Cascade AI Assistant
# Data: 2025-05-13

PROJECT_DIR="/path/to/your/project"
SCRIPTS_DIR="$PROJECT_DIR/bashscripts/mcp"
LOGS_DIR="$PROJECT_DIR/storage/logs/mcp"

# Crea le directory necessarie
mkdir -p "$SCRIPTS_DIR"
mkdir -p "$LOGS_DIR"
chmod -R 777 "$LOGS_DIR"

# Installa le dipendenze Node.js
cd "$PROJECT_DIR"
npm install mysql2 dotenv

# Installa i server MCP globalmente
echo "🚀 Installazione dei server MCP globalmente..."
npm install -g @modelcontextprotocol/server-sequential-thinking
npm install -g @modelcontextprotocol/server-memory
npm install -g @modelcontextprotocol/server-fetch
npm install -g @modelcontextprotocol/server-filesystem
npm install -g @modelcontextprotocol/server-postgres
npm install -g @modelcontextprotocol/server-redis
npm install -g @modelcontextprotocol/server-puppeteer

# Copia gli script di gestione
echo "📋 Copia degli script di gestione..."
cp /path/to/reference/project/bashscripts/mcp/* "$SCRIPTS_DIR/"

# Rendi gli script eseguibili
chmod +x "$SCRIPTS_DIR"/*.sh
chmod +x "$SCRIPTS_DIR"/*.js

echo "✅ Installazione completata con successo!"
echo "📝 Ora puoi configurare i server MCP seguendo la guida di configurazione."
```

## Verifica dell'Installazione

Per verificare che i server MCP siano stati installati correttamente, puoi utilizzare il seguente comando:

```bash
# Verifica l'installazione globale
npm list -g | grep modelcontextprotocol

# Verifica l'installazione locale
cd /path/to/your/project
npm list | grep modelcontextprotocol
```

## Installazione per Editor Specifici

### Windsurf

Per Windsurf, è necessario configurare il file `~/.codeium/windsurf/mcp_config.json`:

```bash
mkdir -p ~/.codeium/windsurf
touch ~/.codeium/windsurf/mcp_config.json
```

### Cursor

Per Cursor, è necessario configurare i file `~/.cursor/mcp.json` e `.cursor/mcp_config.json`:

```bash
mkdir -p ~/.cursor
touch ~/.cursor/mcp.json

mkdir -p /path/to/your/project/.cursor
touch /path/to/your/project/.cursor/mcp_config.json
```

### VSCode

Per VSCode, è necessario configurare il file `.vscode/mcp.json`:

```bash
mkdir -p /path/to/your/project/.vscode
touch /path/to/your/project/.vscode/mcp.json
```

## Risoluzione dei Problemi di Installazione

### Problema: Permessi Negati

Se riscontri errori di permessi durante l'installazione:

```bash
# Assicurati di avere i permessi necessari
sudo chown -R $(whoami) ~/.npm
sudo chown -R $(whoami) /path/to/your/project
```

### Problema: Versione di Node.js non Compatibile

Se la versione di Node.js non è compatibile:

```bash
# Installa nvm (Node Version Manager)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash

# Installa e utilizza la versione corretta di Node.js
nvm install 16
nvm use 16
```

### Problema: Dipendenze Mancanti

Se mancano alcune dipendenze:

```bash
# Installa le dipendenze mancanti
npm install -g npm@latest
npm cache clean --force
npm install -g @modelcontextprotocol/server-sequential-thinking
```

## Conclusione

Hai completato con successo l'installazione dei server MCP per il tuo progetto Laravel. Ora puoi procedere con la configurazione seguendo la guida nella sezione successiva.

---

Continua con la sezione [Configurazione](./02_CONFIGURAZIONE.md) per configurare i server MCP per il tuo progetto Laravel.

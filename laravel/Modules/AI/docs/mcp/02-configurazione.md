# Configurazione dei Server MCP per Progetti Laravel

## Panoramica

Questa guida fornisce istruzioni dettagliate per la configurazione dei server MCP (Model Context Protocol) in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## Struttura delle Directory

Prima di procedere con la configurazione, assicurati di avere la seguente struttura delle directory:

```
/path/to/your/project/
├── bashscripts/
│   └── mcp/
│       ├── mcp-manager-v2.sh
│       ├── mysql-db-connector.js
│       └── start-mysql-mcp.sh
├── storage/
│   └── logs/
│       └── mcp/
├── .cursor/
│   ├── mcp.json
│   └── mcp_config.json
├── .windsurf/
│   └── mcp_config.json
├── .vscode/
│   └── mcp.json
└── mcp_config.json
```

## Configurazione del Progetto

### File di Configurazione Principale

Il file di configurazione principale per i server MCP si trova in:

```
/path/to/your/project/mcp_config.json
```

Questo file contiene la configurazione per tutti i server MCP utilizzati nel progetto. Ecco un esempio di configurazione:

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
    "mysql": {
      "command": "/bin/bash",
      "args": ["/path/to/your/project/bashscripts/mcp/start-mysql-mcp.sh"]
    },
    "postgres": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-postgres"]
    },
    "redis": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-redis"]
    },
    "puppeteer": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
    }
  }
}
```

### Configurazione del Server MySQL Personalizzato

Il server MySQL personalizzato legge le configurazioni dal file `.env` di Laravel. Assicurati che il file `.env` contenga le seguenti variabili:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Lo script `mysql-db-connector.js` leggerà queste variabili e configurerà il server MySQL di conseguenza.

## Configurazione per Editor Specifici

### Windsurf

Per configurare i server MCP per Windsurf, crea o modifica il file:

```
~/.codeium/windsurf/mcp_config.json
```

Utilizza la seguente struttura:

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
    "mysql": {
      "command": "/bin/bash",
      "args": ["/path/to/your/project/bashscripts/mcp/start-mysql-mcp.sh"]
    },
    "postgres": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-postgres"]
    },
    "redis": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-redis"]
    },
    "puppeteer": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
    }
  }
}
```

### Cursor

Per configurare i server MCP per Cursor, crea o modifica i seguenti file:

#### `~/.cursor/mcp.json`

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
    "mysql": {
      "command": "/bin/bash",
      "args": ["/path/to/your/project/bashscripts/mcp/start-mysql-mcp.sh"]
    },
    "postgres": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-postgres"]
    },
    "redis": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-redis"]
    },
    "puppeteer": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
    }
  }
}
```

#### `/path/to/your/project/.cursor/mcp_config.json`

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
    "mysql": {
      "command": "/bin/bash",
      "args": ["/path/to/your/project/bashscripts/mcp/start-mysql-mcp.sh"]
    },
    "postgres": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-postgres"]
    },
    "redis": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-redis"]
    },
    "puppeteer": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
    }
  }
}
```

### VSCode

Per configurare i server MCP per VSCode, crea o modifica il file:

```
/path/to/your/project/.vscode/mcp.json
```

Utilizza la seguente struttura:

```json
{
  "mcp": {
    "servers": {
      "sequential-thinking": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-sequential-thinking"]
      },
      "memory": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-memory"]
      },
      "fetch": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-fetch"]
      },
      "filesystem": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-filesystem"]
      },
      "mysql": {
        "type": "stdio",
        "command": "/bin/bash",
        "args": ["/path/to/your/project/bashscripts/mcp/start-mysql-mcp.sh"]
      },
      "postgres": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-postgres"]
      },
      "redis": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-redis"]
      },
      "puppeteer": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
      }
    }
  }
}
```

## Configurazione degli Script di Gestione

### Script `mcp-manager-v2.sh`

Lo script `mcp-manager-v2.sh` è uno strumento potente per gestire i server MCP. Assicurati che il percorso del progetto sia configurato correttamente:

```bash
PROJECT_DIR="/path/to/your/project"
LOGS_DIR="$PROJECT_DIR/storage/logs/mcp"
MYSQL_CONNECTOR="$PROJECT_DIR/bashscripts/mcp/mysql-db-connector.js"
```

### Script `start-mysql-mcp.sh`

Lo script `start-mysql-mcp.sh` avvia il server MySQL personalizzato. Assicurati che il percorso del progetto e del connector siano configurati correttamente:

```bash
PROJECT_DIR="/path/to/your/project"
LOGS_DIR="$PROJECT_DIR/storage/logs/mcp"
CONNECTOR_SCRIPT="$PROJECT_DIR/bashscripts/mcp/mysql-db-connector.js"
```

### Script `mysql-db-connector.js`

Lo script `mysql-db-connector.js` è il server MySQL personalizzato che legge le configurazioni dal file `.env` di Laravel. Assicurati che il percorso del file `.env` sia configurato correttamente:

```javascript
const PROJECT_DIR = '/path/to/your/project';
const LARAVEL_DIR = path.join(PROJECT_DIR, 'laravel');
const ENV_FILE = path.join(LARAVEL_DIR, '.env');
```

## Configurazione Automatica con Script

Per semplificare la configurazione, puoi utilizzare il seguente script:

```bash
#!/bin/bash

# Script di configurazione dei server MCP
# Autore: Cascade AI Assistant
# Data: 2025-05-13

PROJECT_DIR="/path/to/your/project"
SCRIPTS_DIR="$PROJECT_DIR/bashscripts/mcp"
LOGS_DIR="$PROJECT_DIR/storage/logs/mcp"

# Aggiorna i percorsi negli script
sed -i "s|/var/www/html/_bases/base_predict_fila5_mono|$PROJECT_DIR|g" "$SCRIPTS_DIR/mcp-manager-v2.sh"
sed -i "s|/var/www/html/_bases/base_predict_fila5_mono|$PROJECT_DIR|g" "$SCRIPTS_DIR/start-mysql-mcp.sh"
sed -i "s|/var/www/html/_bases/base_predict_fila5_mono|$PROJECT_DIR|g" "$SCRIPTS_DIR/mysql-db-connector.js"

# Crea i file di configurazione
echo '{
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
    "mysql": {
      "command": "/bin/bash",
      "args": ["'"$PROJECT_DIR"'/bashscripts/mcp/start-mysql-mcp.sh"]
    },
    "postgres": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-postgres"]
    },
    "redis": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-redis"]
    },
    "puppeteer": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
    }
  }
}' > "$PROJECT_DIR/mcp_config.json"

# Crea la configurazione per Windsurf
mkdir -p ~/.codeium/windsurf
cp "$PROJECT_DIR/mcp_config.json" ~/.codeium/windsurf/mcp_config.json

# Crea la configurazione per Cursor
mkdir -p ~/.cursor
cp "$PROJECT_DIR/mcp_config.json" ~/.cursor/mcp.json

mkdir -p "$PROJECT_DIR/.cursor"
cp "$PROJECT_DIR/mcp_config.json" "$PROJECT_DIR/.cursor/mcp_config.json"

# Crea la configurazione per VSCode
mkdir -p "$PROJECT_DIR/.vscode"
echo '{
  "mcp": {
    "servers": {
      "sequential-thinking": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-sequential-thinking"]
      },
      "memory": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-memory"]
      },
      "fetch": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-fetch"]
      },
      "filesystem": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-filesystem"]
      },
      "mysql": {
        "type": "stdio",
        "command": "/bin/bash",
        "args": ["'"$PROJECT_DIR"'/bashscripts/mcp/start-mysql-mcp.sh"]
      },
      "postgres": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-postgres"]
      },
      "redis": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-redis"]
      },
      "puppeteer": {
        "type": "stdio",
        "command": "npx",
        "args": ["-y", "@modelcontextprotocol/server-puppeteer"]
      }
    }
  }
}' > "$PROJECT_DIR/.vscode/mcp.json"

echo "✅ Configurazione completata con successo!"
echo "📝 Ora puoi avviare i server MCP seguendo la guida di utilizzo."
```

## Verifica della Configurazione

Per verificare che la configurazione sia corretta, puoi utilizzare il seguente comando:

```bash
# Verifica la configurazione del progetto
cat /path/to/your/project/mcp_config.json

# Verifica la configurazione di Windsurf
cat ~/.codeium/windsurf/mcp_config.json

# Verifica la configurazione di Cursor
cat ~/.cursor/mcp.json
cat /path/to/your/project/.cursor/mcp_config.json

# Verifica la configurazione di VSCode
cat /path/to/your/project/.vscode/mcp.json
```

## Risoluzione dei Problemi di Configurazione

### Problema: Percorsi Errati

Se riscontri errori nei percorsi:

```bash
# Aggiorna i percorsi negli script
sed -i "s|/old/path|/new/path|g" /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh
sed -i "s|/old/path|/new/path|g" /path/to/your/project/bashscripts/mcp/start-mysql-mcp.sh
sed -i "s|/old/path|/new/path|g" /path/to/your/project/bashscripts/mcp/mysql-db-connector.js
```

### Problema: File di Configurazione non Validi

Se i file di configurazione non sono validi:

```bash
# Verifica la validità del JSON
jsonlint /path/to/your/project/mcp_config.json
```

### Problema: Permessi Negati

Se riscontri errori di permessi durante la configurazione:

```bash
# Assicurati di avere i permessi necessari
sudo chown -R $(whoami) ~/.codeium
sudo chown -R $(whoami) ~/.cursor
sudo chown -R $(whoami) /path/to/your/project
```

## Conclusione

Hai completato con successo la configurazione dei server MCP per il tuo progetto Laravel. Ora puoi procedere con l'utilizzo seguendo la guida nella sezione successiva.

---

Continua con la sezione [Utilizzo](./03_UTILIZZO.md) per imparare come utilizzare i server MCP nel tuo progetto Laravel.

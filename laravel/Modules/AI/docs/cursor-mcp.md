# Configurazione MCP per Cursor

## Configurazione del File

Il file di configurazione MCP per Cursor dovrebbe essere posizionato in:
- Windows: `C:\Users\[USERNAME]\.cursor\mcp.json`
- Linux/Mac: `~/.cursor/mcp.json`

## Struttura della Configurazione

```json
{
  "mcp": {
    "servers": {
      "default": {
        "host": "localhost",
        "port": 3000,
        "protocol": "http",
        "timeout": 30000,
        "retryAttempts": 3,
        "retryDelay": 1000
      },
      "development": {
        "host": "localhost",
        "port": 3001,
        "protocol": "http",
        "timeout": 30000,
        "retryAttempts": 3,
        "retryDelay": 1000
      },
      "production": {
        "host": "localhost",
        "port": 3002,
        "protocol": "http",
        "timeout": 30000,
        "retryAttempts": 3,
        "retryDelay": 1000
      }
    },
    "logging": {
      "level": "info",
      "file": "[PATH_TO_CURSOR]/.cursor/logs/mcp.log",
      "maxSize": 10485760,
      "maxFiles": 5
    },
    "security": {
      "allowedOrigins": ["*"],
      "allowedMethods": ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
      "allowedHeaders": ["Content-Type", "Authorization"],
      "maxRequestSize": 10485760
    },
    "cache": {
      "enabled": true,
      "ttl": 3600,
      "maxSize": 104857600
    },
    "monitoring": {
      "enabled": true,
      "metrics": {
        "cpu": true,
        "memory": true,
        "disk": true,
        "network": true
      },
      "alerting": {
        "enabled": true,
        "thresholds": {
          "cpu": 80,
          "memory": 80,
          "disk": 80
        }
      }
    },
    "editor": {
      "autoComplete": true,
      "snippets": true,
      "formatOnSave": true,
      "formatOnPaste": true,
      "suggestOnTriggerCharacters": true,
      "acceptSuggestionOnEnter": "on"
    }
  }
}
```

## Configurazioni Specifiche per Cursor

### Editor Settings
- `autoComplete`: Abilita il completamento automatico
- `snippets`: Abilita i frammenti di codice
- `formatOnSave`: Formatta automaticamente il codice al salvataggio
- `formatOnPaste`: Formatta automaticamente il codice incollato
- `suggestOnTriggerCharacters`: Mostra suggerimenti sui caratteri trigger
- `acceptSuggestionOnEnter`: Comportamento dell'accettazione dei suggerimenti

### Logging
- Il percorso del file di log deve essere adattato al sistema operativo
- Su Windows: `C:\Users\[USERNAME]\.cursor\logs\mcp.log`
- Su Linux/Mac: `~/.cursor/logs/mcp.log`

## Best Practices per Cursor

1. Mantenere sincronizzati i file di configurazione tra gli ambienti
2. Utilizzare percorsi relativi quando possibile
3. Configurare correttamente i permessi dei file di log
4. Monitorare l'utilizzo delle risorse dell'editor
5. Mantenere aggiornata l'estensione MCP

## Risoluzione Problemi

1. Se Cursor non riconosce la configurazione MCP:
   - Verificare il percorso del file di configurazione
   - Controllare i permessi del file
   - Riavviare Cursor

2. Problemi di performance:
   - Ridurre la dimensione della cache
   - Disabilitare metriche non necessarie
   - Ottimizzare le impostazioni dell'editor

3. Errori di connessione:
   - Verificare che le porte siano disponibili
   - Controllare le impostazioni di rete
   - Verificare i firewall 

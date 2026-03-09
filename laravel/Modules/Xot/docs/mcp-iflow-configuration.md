# Configurazione MCP per iFlow

## Panoramica

<<<<<<< .merge_file_qeyhAw
iFlow supporta server MCP tramite pacchetti Python. Questa guida descrive come configurare i server MCP per il progetto healthcare_app Fila4 Mono con iFlow.
=======
iFlow supporta server MCP tramite pacchetti Python. Questa guida descrive come configurare i server MCP per il progetto ModuloEsempio Fila4 Mono con iFlow.
>>>>>>> .merge_file_iFvXc2

## Prerequisiti

- Python 3.11+ installato
- pip o uv installato
- Accesso al terminale
- Variabili d'ambiente del database configurate

## Installazione Pacchetti Base

### Qdrant MCP Server

Server MCP per ricerca codice utilizzando Qdrant vector database.

```bash
pip install iflow-mcp-mcp-server-qdrant
```

Oppure con uv:

```bash
uv pip install iflow-mcp-mcp-server-qdrant
```

### MiniMax MCP Server

Server MCP per Text-to-Speech e generazione media.

```bash
pip install iflow-mcp-minimax-mcp
```

## Configurazione Server Qdrant

### 1. Installazione Qdrant

Qdrant può essere eseguito tramite Docker:

```bash
docker run -p 6333:6333 -p 6334:6334 qdrant/qdrant
```

### 2. Avvio Server MCP Qdrant

```bash
export QDRANT_URL="http://localhost:6333"
export COLLECTION_NAME="code-snippets"
export TOOL_STORE_DESCRIPTION="Memorizza frammenti di codice riutilizzabili per un successivo recupero. Il parametro 'information' dovrebbe contenere una descrizione in linguaggio naturale di ciò che il codice fa, mentre il codice effettivo dovrebbe essere incluso nel parametro 'metadata' come proprietà 'code'. Il valore di 'metadata' è un dizionario Python con stringhe come chiavi. Usa questo ogni volta che generi un frammento di codice."
export TOOL_FIND_DESCRIPTION="Cerca frammenti di codice rilevanti basati su descrizioni in linguaggio naturale. Il parametro 'query' dovrebbe descrivere ciò che stai cercando, e lo strumento restituirà i frammenti di codice più pertinenti. Usa questo quando hai bisogno di trovare frammenti di codice esistenti per riutilizzo o riferimento."

uvx mcp-server-qdrant --transport sse
```

### 3. Configurazione in Cursor/Windsurf

Per utilizzare il server Qdrant da Cursor o Windsurf, aggiungere al file di configurazione:

**Cursor (`~/.cursor/mcp.json`)**:
```json
{
  "mcpServers": {
    "iflow-qdrant": {
      "url": "http://localhost:8000/sse"
    }
  }
}
```

**Windsurf (`~/.codeium/windsurf/mcp_config.json`)**:
```json
{
  "mcpServers": {
    "iflow-qdrant": {
      "url": "http://localhost:8000/sse"
    }
  }
}
```

## Configurazione Server MiniMax

### 1. Ottenere API Key

Registrarsi su [MiniMax](https://www.minimax.com) e ottenere una API key.

### 2. Configurazione Variabili d'Ambiente

```bash
export MINIMAX_API_KEY="your_api_key_here"
export MINIMAX_GROUP_ID="your_group_id"
```

### 3. Avvio Server MiniMax

```bash
uvx iflow-mcp-minimax-mcp --transport sse
```

### 4. Configurazione in Editor

Aggiungere al file di configurazione MCP dell'editor:

```json
{
  "mcpServers": {
    "iflow-minimax": {
      "url": "http://localhost:8000/sse",
      "env": {
        "MINIMAX_API_KEY": "${MINIMAX_API_KEY}",
        "MINIMAX_GROUP_ID": "${MINIMAX_GROUP_ID}"
      }
    }
  }
}
```

## Server MCP Personalizzati per Laravel/PHP

### Server PHP Code Analysis

Creare un server MCP personalizzato per analisi codice PHP:

```python
#!/usr/bin/env python3
# mcp-server-phpstan.py

import subprocess
import json
import sys
from pathlib import Path

def analyze_php_file(file_path: str) -> dict:
    """Analizza un file PHP con PHPStan."""
    try:
        result = subprocess.run(
            ["vendor/bin/phpstan", "analyse", file_path, "--level", "10", "--no-progress", "--error-format", "json"],
            capture_output=True,
            text=True,
            cwd="laravel"
        )

        if result.returncode == 0:
            return {"status": "success", "errors": []}
        else:
            errors = json.loads(result.stdout) if result.stdout else []
            return {"status": "errors", "errors": errors}
    except Exception as e:
        return {"status": "error", "message": str(e)}

if __name__ == "__main__":
    # Implementazione server MCP STDIO
    # Questo è un esempio semplificato
    pass
```

### Server Laravel Artisan

Server MCP per eseguire comandi Artisan:

```python
#!/usr/bin/env python3
# mcp-server-artisan.py

import subprocess
import json
import sys

def run_artisan_command(command: str, args: list = None) -> dict:
    """Esegue un comando Artisan."""
    try:
        cmd = ["php", "artisan", command]
        if args:
            cmd.extend(args)

        result = subprocess.run(
            cmd,
            capture_output=True,
            text=True,
            cwd="laravel"
        )

        return {
            "status": "success" if result.returncode == 0 else "error",
            "output": result.stdout,
            "error": result.stderr
        }
    except Exception as e:
        return {"status": "error", "message": str(e)}
```

## Configurazione Completa iFlow

### Script di Avvio Completo

Creare uno script bash per avviare tutti i server MCP:

```bash
#!/bin/bash
# start-mcp-servers.sh

# Qdrant Server
export QDRANT_URL="http://localhost:6333"
export COLLECTION_NAME="code-snippets"
uvx mcp-server-qdrant --transport sse --port 8001 &

# MiniMax Server (se configurato)
if [ -n "$MINIMAX_API_KEY" ]; then
    uvx iflow-mcp-minimax-mcp --transport sse --port 8002 &
fi

# PHPStan Server (custom)
python3 mcp-server-phpstan.py --transport sse --port 8003 &

# Artisan Server (custom)
python3 mcp-server-artisan.py --transport sse --port 8004 &

echo "Server MCP avviati su porte 8001-8004"
```

## Integrazione con Editor

### Cursor

Aggiungere al file `~/.cursor/mcp.json`:

```json
{
  "mcpServers": {
    "iflow-qdrant": {
      "url": "http://localhost:8001/sse"
    },
    "iflow-minimax": {
      "url": "http://localhost:8002/sse",
      "env": {
        "MINIMAX_API_KEY": "${MINIMAX_API_KEY}"
      }
    },
<<<<<<< .merge_file_qeyhAw
    "phpstan-healthcare_app": {
      "url": "http://localhost:8003/sse"
    },
    "artisan-healthcare_app": {
=======
    "phpstan-ptvx": {
      "url": "http://localhost:8003/sse"
    },
    "artisan-ptvx": {
>>>>>>> .merge_file_iFvXc2
      "url": "http://localhost:8004/sse"
    }
  }
}
```

### Windsurf

Aggiungere al file `~/.codeium/windsurf/mcp_config.json`:

```json
{
  "mcpServers": {
    "iflow-qdrant": {
      "url": "http://localhost:8001/sse"
    },
    "iflow-minimax": {
      "url": "http://localhost:8002/sse",
      "env": {
        "MINIMAX_API_KEY": "${MINIMAX_API_KEY}"
      }
    }
  }
}
```

## Best Practices

1. **Sicurezza**: Mai hardcodare API keys nei file di configurazione
2. **Isolamento**: Utilizzare porte diverse per ogni server
3. **Logging**: Abilitare logging per debugging
4. **Monitoraggio**: Monitorare l'utilizzo delle risorse dei server
5. **Backup**: Fare backup regolari dei dati Qdrant

## Troubleshooting

### Server non si avvia

1. Verificare Python version:
   ```bash
   python3 --version
   ```

2. Verificare dipendenze:
   ```bash
   pip list | grep iflow-mcp
   ```

3. Controllare porte disponibili:
   ```bash
   netstat -tuln | grep 800
   ```

### Errori di connessione Qdrant

1. Verificare che Qdrant sia in esecuzione:
   ```bash
   curl http://localhost:6333/health
   ```

2. Controllare configurazione URL:
   ```bash
   echo $QDRANT_URL
   ```

### Errori API MiniMax

1. Verificare API key:
   ```bash
   echo $MINIMAX_API_KEY
   ```

2. Testare API manualmente:
   ```bash
   curl -H "Authorization: Bearer $MINIMAX_API_KEY" https://api.minimax.com/v1/test
   ```

## Riferimenti

- [iFlow MCP Qdrant Documentation](https://pypi.org/project/iflow-mcp-mcp-server-qdrant/)
- [iFlow MCP MiniMax Documentation](https://pypi.org/project/iflow-mcp-minimax-mcp/)
- [Qdrant Documentation](https://qdrant.tech/documentation/)
- [Model Context Protocol Specification](https://modelcontextprotocol.io)

## Collegamenti Correlati

- [MCP Editors Configuration](./mcp-editors-configuration.md) - Configurazione generale editor
- [MCP Claude Code Configuration](./mcp-claude-code-configuration.md) - Configurazione Claude Code
- [MCP Integration Guide](./mcp-integration.md) - Integrazione MCP nel codice PHP

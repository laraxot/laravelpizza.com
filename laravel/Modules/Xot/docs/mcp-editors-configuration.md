# Configurazione Server MCP per Editor AI

## Panoramica

Questo documento descrive la configurazione dei server MCP (Model Context Protocol) per gli editor AI utilizzati nello sviluppo del progetto Quaeris Fila4 Mono.

## Cos'è MCP?

Il Model Context Protocol (MCP) è uno standard aperto introdotto da Anthropic nel novembre 2024 per standardizzare l'integrazione e la condivisione dei dati tra sistemi di intelligenza artificiale (LLM) e strumenti, sistemi e fonti di dati esterni.

MCP fornisce un'interfaccia universale per:
- Leggere file e directory
- Eseguire funzioni e comandi
- Gestire prompt contestuali
- Interagire con database, API e servizi esterni

## Editor Supportati

### 1. Cursor

**File di configurazione**: `~/.cursor/mcp.json`

**Caratteristiche**:
- Supporto completo per server MCP
- Configurazione globale e per progetto
- Integrazione nativa con AI assistant

**Server MCP Consigliati per Laravel/PHP**:
- `filesystem`: Gestione file e directory
- `fetch`: Chiamate HTTP/API
- `memory`: Memoria temporanea per contesto
- `mysql`: Interazione con database MySQL
- `postgres`: Interazione con database PostgreSQL
- `sequential-thinking`: Analisi codice e ottimizzazione

### 2. Windsurf

**File di configurazione**: `~/.codeium/windsurf/mcp_config.json`

**Caratteristiche**:
- Ambiente di sviluppo AI avanzato
- Integrazione MCP tramite configurazione JSON
- Supporto per comandi e variabili d'ambiente

**Server MCP Consigliati**:
- Stessi server di Cursor
- Configurazione tramite `command` e `args`
- Supporto per variabili d'ambiente

### 3. Claude Code

**Configurazione**: Tramite CLI

**Caratteristiche**:
- Integrazione MCP tramite comandi CLI
- Supporto per trasporto HTTP e SSE
- Gestione server remoti e locali

**Comandi principali**:
```bash
claude mcp add --transport http <nome-server> <url>
claude mcp list
claude mcp remove <nome-server>
```

### 4. iFlow

**Configurazione**: Tramite pacchetti Python

**Caratteristiche**:
- Server MCP basati su Python
- Integrazione con Qdrant per ricerca codice
- Supporto per Text-to-Speech e generazione media

**Requisiti**:
- Python 3.11+
- Pacchetti specifici per funzionalità

## Server MCP per Sviluppo Laravel/PHP

### Server Essenziali

#### 1. Filesystem Server
**Scopo**: Gestione file e directory del progetto

**Configurazione Cursor**:
```json
{
  "mcpServers": {
    "filesystem": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-filesystem", "server-filesystem", "server-fetch"]
    }
  }
}
```

#### 3. Memory Server
**Scopo**: Memoria temporanea per contesto tra richieste

**Configurazione**:
```json
{
  "mcpServers": {
    "memory": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-memory"]
    }
  }
}
```

### Server Avanzati

#### 4. MySQL Server
**Scopo**: Interazione con database MySQL

**Configurazione**:
```json
{
  "mcpServers": {
    "mysql": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-mysql"],
      "env": {
        "MYSQL_HOST": "localhost",
        "MYSQL_PORT": "3306",
        "MYSQL_USER": "${MYSQL_USER}",
        "MYSQL_PASSWORD": "${MYSQL_PASSWORD}",
        "MYSQL_DATABASE": "${DB_DATABASE}"
      }
    }
  }
}
```

**Nota**: Utilizzare variabili d'ambiente per le credenziali, mai valori hardcoded.

#### 5. PostgreSQL Server
**Scopo**: Interazione con database PostgreSQL

**Configurazione**:
```json
{
  "mcpServers": {
    "postgres": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-postgres"],
      "env": {
        "POSTGRES_HOST": "localhost",
        "POSTGRES_PORT": "5432",
        "POSTGRES_USER": "${POSTGRES_USER}",
        "POSTGRES_PASSWORD": "${POSTGRES_PASSWORD}",
        "POSTGRES_DATABASE": "${DB_DATABASE}"
      }
    }
  }
}
```

#### 6. Sequential Thinking Server
**Scopo**: Analisi codice e ottimizzazione

**Configurazione**:
```json
{
  "mcpServers": {
    "sequential-thinking": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-sequential-thinking"]
    }
  }
}
```

### Server Specializzati per Laravel

#### 7. Laravel Documentation Server
**Scopo**: Accesso alla documentazione Laravel

**Configurazione**:
```json
{
  "mcpServers": {
    "laravel-docs": {
      "command": "npx",
      "args": ["-y", "@assistant-ui/mcp-docs-server"]
    }
  }
}
```

#### 8. PHPStan Server (Custom)
**Scopo**: Analisi statica codice PHP

**Nota**: Richiede implementazione custom o utilizzo di server generici per esecuzione comandi.

## Configurazione Completa Consigliata

### Cursor - Configurazione Globale

File: `~/.cursor/mcp.json`

```json
{
  "mcpServers": {
    "filesystem": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-filesystem", "server-fetch"]
    },
    "memory": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-memory"]
    },
    "mysql": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-mysql"],
      "env": {
        "MYSQL_HOST": "localhost",
        "MYSQL_PORT": "3306",
        "MYSQL_USER": "${MYSQL_USER}",
        "MYSQL_PASSWORD": "${MYSQL_PASSWORD}",
        "MYSQL_DATABASE": "${DB_DATABASE}"
      }
    },
    "sequential-thinking": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-sequential-thinking"]
    }
  }
}
```

### Windsurf - Configurazione

File: `~/.codeium/windsurf/mcp_config.json`

```json
{
  "mcpServers": {
    "filesystem": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-filesystem", "server-fetch"]
    },
    "memory": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-memory"]
    },
    "mysql": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-mysql"],
      "env": {
        "MYSQL_HOST": "localhost",
        "MYSQL_PORT": "3306",
        "MYSQL_USER": "${MYSQL_USER}",
        "MYSQL_PASSWORD": "${MYSQL_PASSWORD}",
        "MYSQL_DATABASE": "${DB_DATABASE}"
      }
    }
  }
}
```

### Claude Code - Configurazione CLI

```bash
# Aggiungi server filesystem
claude mcp add --transport http filesystem http://localhost:8000/mcp/filesystem

# Aggiungi server fetch
claude mcp add --transport http fetch http://localhost:8000/mcp/fetch

# Aggiungi server memory
claude mcp add --transport http memory http://localhost:8000/mcp/memory

# Lista server configurati
claude mcp list

# Rimuovi server
claude mcp remove filesystem
```

### iFlow - Configurazione Python

**Installazione pacchetti**:
```bash
pip install iflow-mcp-mcp-server-qdrant
```

**Configurazione server Qdrant**:
```bash
QDRANT_URL="http://localhost:6333" \
COLLECTION_NAME="code-snippets" \
TOOL_STORE_DESCRIPTION="Memorizza frammenti di codice riutilizzabili per un successivo recupero" \
TOOL_FIND_DESCRIPTION="Cerca frammenti di codice rilevanti basati su descrizioni in linguaggio naturale" \
uvx mcp-server-qdrant --transport sse
```

**Configurazione in Cursor/Windsurf per iFlow**:
```json
{
  "mcpServers": {
    "iflow-qdrant": {
      "url": "http://localhost:8000/sse"
    }
  }
}
```

## Best Practices

### Sicurezza

1. **Mai hardcodare credenziali**: Utilizzare sempre variabili d'ambiente
2. **Limitare permessi filesystem**: Specificare directory root specifiche
3. **Validare input**: I server MCP devono validare tutti gli input
4. **Logging**: Abilitare logging per operazioni sensibili

### Performance

1. **Cache intelligente**: Utilizzare memory server per contesto persistente
2. **Query ottimizzate**: Utilizzare sequential-thinking per analisi query
3. **Lazy loading**: Caricare server solo quando necessari

### Manutenzione

1. **Versioning configurazione**: Mantenere configurazioni in repository
2. **Documentazione aggiornata**: Aggiornare docs quando si aggiungono server
3. **Test configurazione**: Verificare configurazione dopo modifiche

## Troubleshooting

### Server non si connette

1. Verificare che il comando sia installato: `npx -y @modelcontextprotocol/server-filesystem --version`
2. Controllare permessi file di configurazione
3. Verificare variabili d'ambiente

### Errori di autenticazione database

1. Verificare variabili d'ambiente: `echo $MYSQL_USER`
2. Testare connessione manuale: `mysql -u $MYSQL_USER -p`
3. Controllare firewall e permessi

### Performance lente

1. Limitare scope filesystem a directory necessarie
2. Utilizzare cache memory server
3. Ottimizzare query database

## Riferimenti

- [Model Context Protocol Specification](https://modelcontextprotocol.io)
- [Anthropic MCP Documentation](https://docs.anthropic.com/mcp)
- [Cursor MCP Documentation](https://cursor.sh/docs/mcp)
- [Windsurf MCP Documentation](https://docs.windsurf.ai/mcp)

## File di Configurazione Pronti

### Cursor
File di configurazione completo disponibile in:
- `./cursor-mcp-config.json` - Configurazione pronta per Cursor IDE

### Windsurf
File di configurazione completo disponibile in:
- `./windsurf-mcp-config.json` - Configurazione pronta per Windsurf IDE

### Installazione

**Cursor**:
```bash
cp Modules/Xot/docs/cursor-mcp-config.json ~/.cursor/mcp.json
# Oppure per progetto specifico:
cp Modules/Xot/docs/cursor-mcp-config.json .cursor/mcp.json
```

**Windsurf**:
```bash
cp Modules/Xot/docs/windsurf-mcp-config.json ~/.codeium/windsurf/mcp_config.json
```

**iFlow**:
```bash
# Configurazione tramite file .iflow/settings.json (già presente nel progetto)
# Vedere: laravel/.iflow/settings.json
```

## Collegamenti Correlati

- [MCP Integration Guide](./mcp-integration.md) - Integrazione MCP nel codice PHP
- [MCP Server Recommended](./mcp-server-recommended.md) - Server consigliati per moduli
- [Model Context Protocol](./model-context-protocol.md) - Panoramica generale MCP
- [PHPStan Level 10 Success](./phpstan-level10-success-nov2025.md) - Successo PHPStan Level 10

# Configurazione MCP per Claude Code

## Panoramica

Claude Code utilizza comandi CLI per configurare i server MCP. Questa guida descrive come configurare i server MCP per il progetto healthcare_app Fila4 Mono.
Claude Code utilizza comandi CLI per configurare i server MCP. Questa guida descrive come configurare i server MCP per il progetto.
>>>>>>> .merge_file_nWfXWo

## Prerequisiti

- Claude Code installato e configurato
- Accesso al terminale
- Variabili d'ambiente del database configurate

## Configurazione Server MCP

### 1. Filesystem Server

Permette l'accesso ai file del progetto.

```bash
claude mcp add --transport http filesystem-healthcare_app http://localhost:8000/mcp/filesystem
claude mcp add --transport http filesystem http://localhost:8000/mcp/filesystem
>>>>>>> .merge_file_nWfXWo
```

**Nota**: Richiede un server MCP HTTP in esecuzione. Per sviluppo locale, utilizzare server STDIO invece.

### 2. Fetch Server

Permette chiamate HTTP e API.

```bash
claude mcp add --transport http fetch-healthcare_app http://localhost:8000/mcp/fetch
```

### 3. Memory Server

Memoria temporanea per contesto tra richieste.

```bash
claude mcp add --transport http memory-healthcare_app http://localhost:8000/mcp/memory
```

### 4. MySQL Server

Interazione con database MySQL.

```bash
claude mcp add --transport http mysql-healthcare_app http://localhost:8000/mcp/mysql
```

**Variabili d'ambiente richieste**:
- `DB_HOST`: Host del database (default: localhost)
- `DB_PORT`: Porta del database (default: 3306)
- `DB_USERNAME`: Username del database
- `DB_PASSWORD`: Password del database
- `DB_DATABASE`: Nome del database

### 5. Sequential Thinking Server

Analisi codice e ottimizzazione.

```bash
claude mcp add --transport http sequential-thinking-healthcare_app http://localhost:8000/mcp/sequential-thinking
```

## Configurazione con Server STDIO (Raccomandato)

Per sviluppo locale, è preferibile utilizzare server STDIO invece di HTTP:

### Filesystem con STDIO

```bash
claude mcp add filesystem-healthcare_app npx -y @modelcontextprotocol/server-filesystem server-memory
```

### MySQL con STDIO

```bash
claude mcp add mysql-healthcare_app npx -y @modelcontextprotocol/server-mysql
```

**Con variabili d'ambiente**:
```bash
export DB_HOST=localhost
export DB_PORT=3306
export DB_USERNAME=your_username
export DB_PASSWORD=your_password
export DB_DATABASE=your_database

claude mcp add mysql-healthcare_app npx -y @modelcontextprotocol/server-mysql
```

## Gestione Server

### Lista Server Configurati

```bash
claude mcp list
```

### Rimozione Server

```bash
claude mcp remove filesystem-healthcare_app
```

### Test Connessione

```bash
claude mcp test filesystem-healthcare_app
```

## Configurazione Avanzata

### Server Personalizzati

Per server MCP personalizzati, creare uno script wrapper:

```bash
#!/bin/bash
# ~/bin/mcp-mysql-healthcare_app.sh

export MYSQL_HOST="${DB_HOST:-localhost}"
export MYSQL_PORT="${DB_PORT:-3306}"
export MYSQL_USER="${DB_USERNAME}"
export MYSQL_PASSWORD="${DB_PASSWORD}"
export MYSQL_DATABASE="${DB_DATABASE}"

exec npx -y @modelcontextprotocol/server-mysql
```

Poi aggiungere il server:

```bash
chmod +x ~/bin/mcp-mysql-healthcare_app.sh
claude mcp add mysql-healthcare_app ~/bin/mcp-mysql-healthcare_app.sh
```

## Troubleshooting

### Server non si connette

1. Verificare che il comando sia installato:
   ```bash
   npx -y @modelcontextprotocol/server-filesystem --version
   ```

2. Controllare permessi file:
   ```bash
   ls -la /docs.anthropic.com/claude/docs/mcp)
- [Model Context Protocol Specification](https://modelcontextprotocol.io)
- [MCP Editors Configuration](../mcp-editors-configuration.md)

# Configurazione MCP per Claude Code

## Panoramica

<<<<<<< HEAD
Claude Code utilizza comandi CLI per configurare i server MCP. Questa guida descrive come configurare i server MCP per il progetto healthcare_app Fila4 Mono.
Claude Code utilizza comandi CLI per configurare i server MCP. Questa guida descrive come configurare i server MCP per il progetto.
=======
<<<<<<< .merge_file_lYQAy2
Claude Code utilizza comandi CLI per configurare i server MCP. Questa guida descrive come configurare i server MCP per il progetto healthcare_app Fila4 Mono.
=======
<<<<<<< HEAD
Claude Code utilizza comandi CLI per configurare i server MCP. Questa guida descrive come configurare i server MCP per il progetto.
=======
Claude Code utilizza comandi CLI per configurare i server MCP. Questa guida descrive come configurare i server MCP per il progetto ModuloEsempio Fila4 Mono.
>>>>>>> f04e1ab44 (refactor: update project references from <nome progetto> to PTVX)
>>>>>>> origin/dev
>>>>>>> .merge_file_nWfXWo

## Prerequisiti

- Claude Code installato e configurato
- Accesso al terminale
- Variabili d'ambiente del database configurate

## Configurazione Server MCP

### 1. Filesystem Server

Permette l'accesso ai file del progetto.

```bash
<<<<<<< HEAD
claude mcp add --transport http filesystem-healthcare_app http://localhost:8000/mcp/filesystem
claude mcp add --transport http filesystem http://localhost:8000/mcp/filesystem
=======
<<<<<<< .merge_file_lYQAy2
claude mcp add --transport http filesystem-healthcare_app http://localhost:8000/mcp/filesystem
=======
<<<<<<< HEAD
claude mcp add --transport http filesystem http://localhost:8000/mcp/filesystem
=======
claude mcp add --transport http filesystem-ptvx http://localhost:8000/mcp/filesystem
>>>>>>> f04e1ab44 (refactor: update project references from <nome progetto> to PTVX)
>>>>>>> origin/dev
>>>>>>> .merge_file_nWfXWo
```

**Nota**: Richiede un server MCP HTTP in esecuzione. Per sviluppo locale, utilizzare server STDIO invece.

### 2. Fetch Server

Permette chiamate HTTP e API.

```bash
<<<<<<< HEAD
claude mcp add --transport http fetch-healthcare_app http://localhost:8000/mcp/fetch
=======
<<<<<<< .merge_file_lYQAy2
claude mcp add --transport http fetch-healthcare_app http://localhost:8000/mcp/fetch
=======
claude mcp add --transport http fetch-ptvx http://localhost:8000/mcp/fetch
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
```

### 3. Memory Server

Memoria temporanea per contesto tra richieste.

```bash
<<<<<<< HEAD
claude mcp add --transport http memory-healthcare_app http://localhost:8000/mcp/memory
=======
<<<<<<< .merge_file_lYQAy2
claude mcp add --transport http memory-healthcare_app http://localhost:8000/mcp/memory
=======
claude mcp add --transport http memory-ptvx http://localhost:8000/mcp/memory
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
```

### 4. MySQL Server

Interazione con database MySQL.

```bash
<<<<<<< HEAD
claude mcp add --transport http mysql-healthcare_app http://localhost:8000/mcp/mysql
=======
<<<<<<< .merge_file_lYQAy2
claude mcp add --transport http mysql-healthcare_app http://localhost:8000/mcp/mysql
=======
claude mcp add --transport http mysql-ptvx http://localhost:8000/mcp/mysql
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
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
<<<<<<< HEAD
claude mcp add --transport http sequential-thinking-healthcare_app http://localhost:8000/mcp/sequential-thinking
=======
<<<<<<< .merge_file_lYQAy2
claude mcp add --transport http sequential-thinking-healthcare_app http://localhost:8000/mcp/sequential-thinking
=======
claude mcp add --transport http sequential-thinking-ptvx http://localhost:8000/mcp/sequential-thinking
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
```

## Configurazione con Server STDIO (Raccomandato)

Per sviluppo locale, è preferibile utilizzare server STDIO invece di HTTP:

### Filesystem con STDIO

```bash
<<<<<<< HEAD
claude mcp add filesystem-healthcare_app npx -y @modelcontextprotocol/server-filesystem server-memory
=======
<<<<<<< .merge_file_lYQAy2
claude mcp add filesystem-healthcare_app npx -y @modelcontextprotocol/server-filesystem server-memory
=======
claude mcp add filesystem-ptvx npx -y @modelcontextprotocol/server-filesystem server-memory
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
```

### MySQL con STDIO

```bash
<<<<<<< HEAD
claude mcp add mysql-healthcare_app npx -y @modelcontextprotocol/server-mysql
=======
<<<<<<< .merge_file_lYQAy2
claude mcp add mysql-healthcare_app npx -y @modelcontextprotocol/server-mysql
=======
claude mcp add mysql-ptvx npx -y @modelcontextprotocol/server-mysql
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
```

**Con variabili d'ambiente**:
```bash
export DB_HOST=localhost
export DB_PORT=3306
export DB_USERNAME=your_username
export DB_PASSWORD=your_password
export DB_DATABASE=your_database

<<<<<<< HEAD
claude mcp add mysql-healthcare_app npx -y @modelcontextprotocol/server-mysql
=======
<<<<<<< .merge_file_lYQAy2
claude mcp add mysql-healthcare_app npx -y @modelcontextprotocol/server-mysql
=======
claude mcp add mysql-ptvx npx -y @modelcontextprotocol/server-mysql
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
```

## Gestione Server

### Lista Server Configurati

```bash
claude mcp list
```

### Rimozione Server

```bash
<<<<<<< HEAD
claude mcp remove filesystem-healthcare_app
=======
<<<<<<< .merge_file_lYQAy2
claude mcp remove filesystem-healthcare_app
=======
claude mcp remove filesystem-ptvx
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
```

### Test Connessione

```bash
<<<<<<< HEAD
claude mcp test filesystem-healthcare_app
=======
<<<<<<< .merge_file_lYQAy2
claude mcp test filesystem-healthcare_app
=======
claude mcp test filesystem-ptvx
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
```

## Configurazione Avanzata

### Server Personalizzati

Per server MCP personalizzati, creare uno script wrapper:

```bash
#!/bin/bash
<<<<<<< HEAD
# ~/bin/mcp-mysql-healthcare_app.sh
=======
<<<<<<< .merge_file_lYQAy2
# ~/bin/mcp-mysql-healthcare_app.sh
=======
# ~/bin/mcp-mysql-ptvx.sh
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev

export MYSQL_HOST="${DB_HOST:-localhost}"
export MYSQL_PORT="${DB_PORT:-3306}"
export MYSQL_USER="${DB_USERNAME}"
export MYSQL_PASSWORD="${DB_PASSWORD}"
export MYSQL_DATABASE="${DB_DATABASE}"

exec npx -y @modelcontextprotocol/server-mysql
```

Poi aggiungere il server:

```bash
<<<<<<< HEAD
chmod +x ~/bin/mcp-mysql-healthcare_app.sh
claude mcp add mysql-healthcare_app ~/bin/mcp-mysql-healthcare_app.sh
=======
<<<<<<< .merge_file_lYQAy2
chmod +x ~/bin/mcp-mysql-healthcare_app.sh
claude mcp add mysql-healthcare_app ~/bin/mcp-mysql-healthcare_app.sh
=======
chmod +x ~/bin/mcp-mysql-ptvx.sh
claude mcp add mysql-ptvx ~/bin/mcp-mysql-ptvx.sh
>>>>>>> .merge_file_nWfXWo
>>>>>>> origin/dev
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

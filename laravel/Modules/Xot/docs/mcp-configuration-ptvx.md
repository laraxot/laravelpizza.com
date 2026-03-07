# Configurazione MCP per base_ptvx_fila5_mono

**Data Creazione**: [DATE]  
**Status**: ✅ Configurazione Completa e Ottimizzata

---

## 🎯 Scopo del Documento

Questo documento descrive la configurazione MCP ottimizzata per il progetto **base_ptvx_fila5_mono**, risultato di analisi approfondita delle necessità del progetto seguendo la metodologia Super Mucca.

---

## 📊 Server MCP Configurati

### Configurazione Completa

File: `laravel/.mcp.json`

```json
{
    "mcpServers": {
        "laravel-boost": {
            "command": "php",
            "args": [
                "./artisan",
                "boost:mcp"
            ]
        },
        "filesystem": {
            "command": "npx",
            "args": [
                "-y",
                "@modelcontextprotocol/server-filesystem",
                "/var/www/_bases/base_ptvx_fila5_mono/laravel",
                "/var/www/_bases/base_ptvx_fila5_mono/docs",
                "/var/www/_bases/base_ptvx_fila5_mono/bashscripts"
            ]
        },
        "memory": {
            "command": "npx",
            "args": [
                "-y",
                "@modelcontextprotocol/server-memory"
            ]
        },
        "fetch": {
            "command": "npx",
            "args": [
                "-y",
                "@modelcontextprotocol/server-fetch"
            ]
        },
        "sequential-thinking": {
            "command": "npx",
            "args": [
                "-y",
                "@modelcontextprotocol/server-sequential-thinking"
            ]
        },
        "puppeteer": {
            "command": "npx",
            "args": [
                "-y",
                "@hisma/server-puppeteer"
            ]
        },
        "mysql": {
            "command": "npx",
            "args": [
                "-y",
                "@modelcontextprotocol/server-mysql"
            ],
            "env": {
                "MYSQL_HOST": "${DB_HOST}",
                "MYSQL_PORT": "${DB_PORT}",
                "MYSQL_USER": "${DB_USERNAME}",
                "MYSQL_PASSWORD": "${DB_PASSWORD}",
                "MYSQL_DATABASE": "${DB_DATABASE}"
            }
        },
        "git": {
            "command": "npx",
            "args": [
                "-y",
                "@modelcontextprotocol/server-git",
                "--repository",
                "/var/www/_bases/base_ptvx_fila5_mono"
            ]
        }
    }
}
```

---

## 📋 Descrizione Server

### 1. laravel-boost
- **Scopo**: Laravel Boost MCP server per documentazione e analisi codice Laravel
- **Comando**: `php ./artisan boost:mcp`
- **Uso**: Accesso a documentazione Laravel, analisi codice, pattern recognition

### 2. filesystem
- **Scopo**: Gestione file e directory del progetto
- **Path configurati**:
  - `/var/www/_bases/base_ptvx_fila5_mono/laravel` - Codice Laravel
  - `/var/www/_bases/base_ptvx_fila5_mono/docs` - Documentazione
  - `/var/www/_bases/base_ptvx_fila5_mono/bashscripts` - Script e tool
- **Uso**: Fallback quando file sono bloccati o non accessibili con tool standard

### 3. memory
- **Scopo**: Memoria temporanea per contesto tra richieste
- **Uso**: Mantenere stato e contesto durante sessioni di lavoro

### 4. fetch
- **Scopo**: Chiamate HTTP e API
- **Uso**: Accesso a API esterne, documentazione online, risorse web

### 5. sequential-thinking
- **Scopo**: Analisi codice e ottimizzazione
- **Uso**: Problem-solving strutturato, analisi complessità, ottimizzazione

### 6. puppeteer
- **Scopo**: Test UI e automazione browser
- **Uso**: Test end-to-end, automazione browser, screenshot

### 7. mysql
- **Scopo**: Interazione con database MySQL
- **Variabili d'ambiente**: Usa variabili d'ambiente per sicurezza
- **Uso**: Query database, analisi schema, migrazioni

### 8. git
- **Scopo**: Operazioni Git sul repository
- **Path**: `/var/www/_bases/base_ptvx_fila5_mono`
- **Uso**: Operazioni Git, analisi commit, gestione branch

---

## 🔧 Utilizzo MCP nei Prompt

### Pattern di Utilizzo

Nei prompt è stato integrato il riferimento a MCP per aggirare ostacoli:

```
Se alcuni file risultano bloccati o non accessibili con tool standard:
- usa filesystem MCP (read/write/edit) come fallback
- se serve un FS alternativo: usa filesystem-healthcare_app MCP
- per esplorazione rapida: usa code_search / grep_search
- per analisi e ottimizzazione: usa sequential-thinking MCP
- per interazione database: usa mysql o postgres MCP
- per test UI e automazione: usa puppeteer MCP
```

---

## 📚 Collegamenti Correlati

- [MCP Servers Documentation](./mcp-servers.md)
- [MCP Editors Configuration](./mcp-editors-configuration.md)
- [Prompt Improvements](./prompts-improvements.md)

---

**Filosofia**: MCP come strumento per superare limitazioni e migliorare produttività nello sviluppo Laraxot.

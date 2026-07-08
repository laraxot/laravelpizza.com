# Setup MCP per Claude Code - PTVX

---

## Panoramica MCP

Model Context Protocol (MCP) è uno standard aperto che permette a Claude Code di interagire con strumenti esterni, database, API e servizi.

---

## Configurazione File

### File: `laravel/.mcp.json`

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

## Server MCP Configurati

### 1. laravel-boost

**Scopo**: Documentazione Laravel, analisi codice, pattern recognition

**Comando**: `php ./artisan boost:mcp`

**Uso**: Accesso a documentazione Laravel, analisi architettura, suggerimenti basati su best practices Laravel

---

### 2. filesystem

**Scopo**: Accesso sicuro a file e directory del progetto

**Path configurati**:
- `/var/www/_bases/base_ptvx_fila5_mono/laravel` - Codice Laravel
- `/var/www/_bases/base_ptvx_fila5_mono/docs` - Documentazione
- `/var/www/_bases/base_ptvx_fila5_mono/bashscripts` - Script e tool

**Uso**: Fallback quando file sono bloccati o non accessibili con tool standard

**Best Practice**: Limitare accesso solo a directory progetto per sicurezza

---

### 3. memory

**Scopo**: Memoria temporanea per contesto tra richieste

**Uso**: Mantenere stato e contesto durante sessioni di lavoro, ricordare decisioni architetturali

**Best Practice**: Usare per sessioni di lavoro lunghe dove serve continuità

---

### 4. fetch

**Scopo**: Chiamate HTTP e API

**Uso**: Accesso a API esterne, documentazione online, risorse web

**Best Practice**: Usare per consultare documentazione ufficiale Laravel, Filament, PHP

---

### 5. sequential-thinking

**Scopo**: Analisi codice e ottimizzazione

**Uso**: Problem-solving strutturato, analisi complessità, ottimizzazione algoritmi

**Best Practice**: Attivare per task complessi che richiedono ragionamento approfondito

---

### 6. puppeteer

**Scopo**: Test UI e automazione browser

**Uso**: Test end-to-end, automazione browser, screenshot, verifica rendering

**Best Practice**: Usare per test UI complessi e verifica comportamento frontend

---

### 7. mysql

**Scopo**: Interazione con database MySQL

**Variabili d'ambiente**: Usa variabili d'ambiente per sicurezza (non hardcode)

**Uso**: Query database, analisi schema, verifica migrazioni, test query complesse

**Best Practice**: 
- Mai hardcode credenziali
- Usare variabili d'ambiente
- Limitare query a sola lettura quando possibile

---

### 8. git

**Scopo**: Operazioni Git sul repository

**Path**: `/var/www/_bases/base_ptvx_fila5_mono`

**Uso**: Analisi commit, gestione branch, verifica modifiche, storia progetto

**Best Practice**: Usare per comprendere evoluzione codice e decisioni passate

---

## Installazione Server MCP

### Prerequisiti

- Node.js 18+ installato
- npm disponibile

### Installazione Automatica

I server MCP vengono installati automaticamente al primo utilizzo tramite `npx -y`.

### Verifica Installazione

```bash
# Verifica Node.js
node -v  # Deve essere 18+

# Test server filesystem
npx -y @modelcontextprotocol/server-filesystem --help

# Test server memory
npx -y @modelcontextprotocol/server-memory --help
```

---

## Gestione Sicurezza

### Best Practices

1. **Variabili d'Ambiente**: Mai hardcode credenziali in `.mcp.json`
2. **Path Limitati**: Filesystem access solo a directory progetto
3. **Permessi File**: `chmod 600` per file di configurazione sensibili
4. **Review Config**: Verificare configurazione prima di commit

### File Permissions

```bash
# Proteggi file di configurazione
chmod 600 ~/.config/claude-code/config.json
chmod 600 laravel/.mcp.json
```

---

## Troubleshooting

### Server Non Si Avvia

1. Verifica Node.js versione: `node -v` (deve essere 18+)
2. Reinstalla server: `npm install -g @modelcontextprotocol/server-filesystem`
3. Verifica path: Controlla che tutti i path in `.mcp.json` siano corretti

### Database Connection Failed

1. Verifica variabili d'ambiente: `echo $DB_HOST $DB_USERNAME`
2. Test connessione manuale: `mysql -h $DB_HOST -u $DB_USERNAME -p`
3. Verifica permessi database

### Filesystem Access Denied

1. Verifica path esistono: `ls -la /var/www/_bases/base_ptvx_fila5_mono/laravel`
2. Controlla permessi directory: `chmod 755 /var/www/_bases/base_ptvx_fila5_mono`
3. Verifica utente ha accesso

---

## Collegamenti Correlati

- [Configurazione](./configuration.md)
- [Workflow](./workflow.md)
- [Best Practices](./best-practices.md)
- [MCP Configuration PTVX](../../../laravel/Modules/Xot/docs/mcp-configuration-ptvx.md)

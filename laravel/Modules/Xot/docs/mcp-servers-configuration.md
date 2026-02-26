# Configurazione MCP Servers per Progetti Laraxot

## Introduzione

I progetti Laraxot utilizzano **Model Context Protocol (MCP)** per integrare strumenti esterni e migliorare l'esperienza di sviluppo con AI assistants (Claude, Cursor, etc.).

## File Configurazione

**Posizione globale**: `~/.cursor/mcp.json`

Questa configurazione è valida per tutti i progetti aperti in Cursor, ma i path sono project-specific.

## Server MCP Standard

### 1. Laravel Boost (Priorità Alta)

**Scopo**: Integrazione nativa con Laravel

```json
{
  "laravel-boost": {
    "command": "php",
    "args": [
      "/var/www/_bases/base_ptvx_fila4_mono/laravel/artisan",
      "boost:mcp"
    ],
    "env": {
      "PATH": "/usr/local/bin:/usr/bin:/bin"
    }
  }
}
```

**Capacità**:
- ✅ Esegue comandi Artisan
- ✅ Query database dirette
- ✅ Tinker interattivo  
- ✅ Lista route, comandi
- ✅ Legge browser logs
- ✅ Cerca documentazione Laravel/Filament/Livewire

**Installazione**:
```bash
composer require laravel/boost
php artisan boost:install
```

### 2. Filesystem (Priorità Alta)

**Scopo**: Operazioni su file con scope limitato

```json
{
  "filesystem": {
    "command": "npx",
    "args": [
      "-y",
      "@modelcontextprotocol/server-filesystem",
      "/var/www/_bases/base_ptvx_fila4_mono/laravel"
    ]
  }
}
```

**Capacità**:
- ✅ Read/Write file
- ✅ List directory con metadata
- ✅ Search file per pattern
- ✅ File info (size, permissions, timestamps)

**Limitazioni**:
- Accesso solo alla directory specificata e sottodirectory
- Non può accedere fuori da `/var/www/_bases/base_ptvx_fila4_mono/laravel`

### 3. Playwright (Browser Testing)

**Scopo**: Testing UI e debugging frontend

```json
{
  "playwright": {
    "command": "npx",
    "args": [
      "-y",
      "@executeautomation/playwright-mcp-server"
    ]
  }
}
```

**Capacità**:
- ✅ Navigate, click, fill forms
- ✅ Screenshot e video recording
- ✅ Console logs e network requests
- ✅ Accessibility tree
- ✅ Test automation

### 4. Puppeteer (Alternative Browser)

**Scopo**: Browser automation lightweight

```json
{
  "puppeteer": {
    "command": "npx",
    "args": [
      "-y",
      "@hisma/server-puppeteer"
    ]
  }
}
```

### 5. Sequential Thinking

**Scopo**: Extended reasoning per problemi complessi

```json
{
  "sequential-thinking": {
    "command": "npx",
    "args": [
      "-y",
      "@modelcontextprotocol/server-sequential-thinking"
    ]
  }
}
```

### 6. MySQL Custom (Opzionale)

**Scopo**: Query dirette MySQL con credenziali da .env

```json
{
  "mysql": {
    "command": "node",
    "args": [
      "/var/www/_bases/base_ptvx_fila4_mono/bashscripts/mcp/mysql-db-connector.js"
    ]
  }
}
```

**Note**: 
- Script custom in `bashscripts/mcp/`
- Legge credenziali da `.env` automaticamente

## Setup per Nuovo Progetto

Quando inizi un nuovo progetto Laraxot:

### 1. Clona Configurazione Base

```bash
# Backup vecchia config
cp ~/.cursor/mcp.json ~/.cursor/mcp.json.backup

# Template base
cat > ~/.cursor/mcp.json << 'JSON'
{
  "mcpServers": {
    "laravel-boost": {
      "command": "php",
      "args": [
        "/PERCORSO/PROGETTO/laravel/artisan",
        "boost:mcp"
      ],
      "env": {
        "PATH": "/usr/local/bin:/usr/bin:/bin"
      }
    },
    "filesystem": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-filesystem",
        "/PERCORSO/PROGETTO/laravel"
      ]
    },
    "playwright": {
      "command": "npx",
      "args": ["-y", "@executeautomation/playwright-mcp-server"]
    },
    "sequential-thinking": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-sequential-thinking"]
    }
  }
}
JSON
```

### 2. Aggiorna Path

Sostituisci `/PERCORSO/PROGETTO/` con il path reale del progetto.

### 3. Installa Dipendenze

```bash
# Laravel Boost
cd /percorso/progetto/laravel
composer require laravel/boost
php artisan boost:install

# Node packages (installati automaticamente da npx -y)
# Ma puoi pre-installarli
npm install -g @modelcontextprotocol/server-filesystem
npm install -g @executeautomation/playwright-mcp-server
```

### 4. Riavvia Cursor

Chiudi e riapri Cursor per applicare la configurazione MCP.

### 5. Verifica

```bash
# In Cursor, apri una chat e chiedi
"Elenca i comandi artisan disponibili"

# Se Laravel Boost funziona, vedrai la lista completa
```

## Struttura bashscripts/mcp/

Per server MCP custom del progetto:

```
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/mcp/
├── mysql-db-connector.js       # MySQL connector custom
├── laravel-cache-server.js     # (futuro) Cache management
└── custom-tools.js             # (futuro) Tools specifici progetto
```

**Regola**: Server MCP custom vanno **sempre** in `bashscripts/mcp/`, mai altrove.

## Best Practices

### 1. Path Assoluti

Usa sempre path assoluti nella configurazione MCP:

```json
// ✅ CORRETTO
"/var/www/_bases/base_ptvx_fila4_mono/laravel/artisan"

// ❌ ERRATO
"./laravel/artisan"
"~/projects/laravel/artisan"
```

### 2. Environment Variables

Configura PATH nell'env per evitare problemi:

```json
{
  "env": {
    "PATH": "/usr/local/bin:/usr/bin:/bin"
  }
}
```

### 3. Test Isolato

Prima di aggiungere a MCP, testa il comando standalone:

```bash
# Test Laravel Boost
php /var/www/_bases/base_ptvx_fila4_mono/laravel/artisan boost:mcp

# Test filesystem server
npx -y @modelcontextprotocol/server-filesystem --version
```

### 4. Logging

Per debug MCP server:

```bash
# Cursor logs
tail -f ~/.cursor/logs/main.log | grep -i mcp

# Laravel logs
tail -f /var/www/_bases/base_ptvx_fila4_mono/laravel/storage/logs/laravel.log
```

## Troubleshooting

### Laravel Boost non risponde

**Problema**: `boost:mcp` command not found

**Soluzione**:
```bash
cd /var/www/_bases/base_ptvx_fila4_mono/laravel
composer require laravel/boost
php artisan boost:install
```

### Filesystem scope troppo limitato

**Problema**: Non riesce ad accedere a file fuori da `laravel/`

**Soluzione**: 
- Usa terminal commands con `cat`, `echo`, redirection
- Oppure crea secondo server filesystem:

```json
{
  "filesystem-bashscripts": {
    "command": "npx",
    "args": [
      "-y",
      "@modelcontextprotocol/server-filesystem",
      "/var/www/_bases/base_ptvx_fila4_mono/bashscripts"
    ]
  }
}
```

### npx non trova i package

**Problema**: Network o npm registry issue

**Soluzione**:
```bash
# Installa globalmente
npm install -g @modelcontextprotocol/server-filesystem
npm install -g @executeautomation/playwright-mcp-server

# Poi usa path assoluto invece di npx
{
  "command": "/usr/local/bin/mcp-server-filesystem",
  "args": ["/path"]
}
```

## Sicurezza

### Credenziali

**NON** mettere mai credenziali hardcoded in `mcp.json`:

```json
// ❌ VIETATO
{
  "env": {
    "DB_PASSWORD": "password123"
  }
}

// ✅ CORRETTO
// Lascia che Laravel Boost legga da .env
```

### Scope Filesystem

Limita sempre lo scope alle directory necessarie:

```json
// ✅ CORRETTO - Solo laravel/
"/var/www/_bases/base_ptvx_fila4_mono/laravel"

// ❌ PERICOLOSO - Tutta la root
"/"
```

## Multi-Progetto

Se lavori su più progetti:

### Opzione 1: Workspace Specific

Crea file `.cursor/mcp.json` nella root del progetto (non nella home):

```bash
/var/www/_bases/base_ptvx_fila4_mono/.cursor/mcp.json
```

Cursor userà questa config quando apri questo workspace.

### Opzione 2: Config Globale con Switch

Usa script per switchare configurazioni:

```bash
# Script in bashscripts/utilities/
cat > /var/www/_bases/base_ptvx_fila4_mono/bashscripts/utilities/switch_mcp_config.sh << 'SCRIPT'
#!/bin/bash
PROJECT=$1
cp ~/.cursor/mcp-configs/mcp-${PROJECT}.json ~/.cursor/mcp.json
echo "✅ MCP config switched to: $PROJECT"
SCRIPT
```

## Collegamenti

- [Model Context Protocol](https://modelcontextprotocol.io/)
- [Laravel Boost](https://github.com/laravel/boost)
- [bashscripts/mcp/](../../../bashscripts/mcp/)
- [MCP Custom Scripts](../../../bashscripts/docs/mcp-configuration.md)

---

**Ultima verifica**: 2 Dicembre 2025  
**Progetto**: base_ptvx_fila4_mono  
**Status**: ✅ Configurato e funzionante
EOF

echo "✅ Documentazione MCP nel modulo Xot creata"


# Configurazione MCP Ottimizzata per base_techplanner_fila5_mono

**Data Creazione**: [DATE]
**Status**: ✅ Configurazione Completa e Ottimizzata
**Metodologia**: Super Mucca 🐮⚡

### ⚠️ Cambiamenti Recenti
- **[DATE]**: Rimosso `mcp-package-docs` (deprecato e non supportato) - Usare Laravel Boost per documentazione

---

## 🎯 Scopo del Documento

Questo documento descrive la configurazione MCP ottimizzata per il progetto **base_techplanner_fila5_mono**, risultato di analisi approfondita delle necessità del progetto seguendo la metodologia Super Mucca.

---

## 📊 Server MCP Configurati

### Configurazione Completa

File: `.windsurf/mcp.json` (o `.cursor/mcp.json` per Cursor)

```json
{
  "mcpServers": {
    "laravel-boost": {
      "command": "php",
      "args": [
        "artisan",
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
        "laravel",
        "docs",
        "public_html",
        "bashscripts"
      ]
    },
    "memory": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-memory"]
    },
    "sequential-thinking": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-sequential-thinking"
      ],
      "env": {}
    },
    "fetch": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-fetch"]
    },
    "git": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-git", "playwright-mcp-server"],
      "env": {}
    },
    "puppeteer": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-puppeteer"
      ],
      "env": {}
    },
    "mysql": {
      "command": "node",
      "args": [
        "bashscripts/mcp/mysql-db-connector.js"
      ]
    },
  }
}
```

---

## 🔧 Dettagli Server MCP

### 1. Laravel Boost (Priorità Massima) ⚠️

**Stato**: Configurato ma richiede installazione

**Scopo**: Integrazione nativa Laravel per comandi Artisan, query database, Tinker, documentazione.

**Capacità**:
- ✅ Esegue comandi Artisan direttamente
- ✅ Query database via Eloquent (type-safe)
- ✅ Tinker interattivo
- ✅ Lista route e comandi disponibili
- ✅ Legge browser logs
- ✅ Cerca documentazione Laravel/Filament/Livewire

**Installazione**:
```bash
cd laravel
composer require laravel/boost
php artisan boost:install
```

**Nota**: Laravel Boost richiede che tutti gli errori PHP siano risolti. L'errore in `EditSchedule.php` è stato fixato.

### 2. Filesystem (Priorità Alta) ✅

**Stato**: Configurato e ottimizzato

**Scopo**: Accesso completo ai file del progetto, anche quelli in gitignore.

**Path Configurati**:
- `laravel` - Codice Laravel e moduli
- `docs` - Documentazione progetto
- `public_html` - Assets pubblici
- `bashscripts` - Script utility

**Capacità**:
- ✅ Read/Write file (anche in gitignore come .env)
- ✅ List directory con metadata
- ✅ Search file per pattern
- ✅ File info (size, permissions, timestamps)

**Miglioramento**: Path aggiornati dal vecchio `API) ✅

**Stato**: Aggiunto nella nuova configurazione

**Scopo**: Chiamate HTTP e API per documentazione esterna, testing API.

**Capacità**:
- ✅ Fetch HTTP requests
- ✅ Download documentazione aggiornata
- ✅ Testing API esterne
- ✅ Verifica package updates

**Utilizzo**: Scaricare documentazione Laravel/Filament aggiornata, testare API, verificare package.

### 6. Git ✅

**Stato**: Aggiunto nella nuova configurazione

**Scopo**: Operazioni Git per analisi codice, commit history, branch management.

**Capacità**:
- ✅ Leggere commit history
- ✅ Cercare pattern nel codice
- ✅ Verificare branch/PR status
- ✅ Analizzare diff

**Utilizzo**: Analisi codice, debugging, verifica cambiamenti, analisi pattern.

### 7. Playwright (Browser Testing) ✅

**Stato**: Aggiunto nella nuova configurazione

**Scopo**: Testing UI e debugging frontend per applicazioni Filament/Livewire.

**Capacità**:
- ✅ Navigate, click, fill forms
- ✅ Screenshot e video recording
- ✅ Console logs e network requests
- ✅ Accessibility tree
- ✅ Test automation avanzata

**Utilizzo**: Testing UI Filament, debugging frontend, test automation, screenshot per documentazione.

**Nota**: Più potente di Puppeteer per testing. Manteniamo entrambi per compatibilità.

### 8. Puppeteer (Browser Automation) ✅

**Stato**: Mantenuto per compatibilità

**Scopo**: Browser automation lightweight.

**Capacità**:
- ✅ Browser automation base
- ✅ Screenshot
- ✅ Navigazione semplice

**Nota**: Mantenuto per compatibilità. Playwright è preferibile per testing avanzato.

### 9. MySQL Custom ✅

**Stato**: Configurato con script custom esistente

**Scopo**: Query dirette MySQL con credenziali da `.env`.

**Path Script**: `bashscripts/mcp/mysql-db-connector.js`

**Capacità**:
- ✅ Query SQL dirette
- ✅ Lista database e tabelle
- ✅ Credenziali automatiche da `.env`
- ✅ Nessuna configurazione manuale

**Vantaggio**: Usa script custom che legge automaticamente da `.env` invece di variabili d'ambiente manuali.

**Nota**: Laravel Boost già fornisce accesso database via Eloquent (più sicuro e type-safe). MySQL MCP è utile per query SQL raw quando necessario.

### 10. MCP Package Docs ✅

**Stato**: Mantenuto

**Scopo**: Documentazione pacchetti npm/node.

**Capacità**:
- ✅ Documentazione pacchetti
- ✅ Package info
- ✅ Versioni disponibili

---

## 📋 Checklist Installazione

### Server già Configurati (Nessuna Azione)

- ✅ filesystem (path aggiornati)
- ✅ memory
- ✅ sequential-thinking
- ✅ puppeteer
- ❌ mcp-package-docs (RIMOSSO - deprecato e non supportato)

### Server Aggiunti (Richiedono Verifica)

- ✅ fetch (installazione automatica con npx)
- ✅ git (installazione automatica con npx)
- ✅ playwright (installazione automatica con npx)
- ✅ mysql (script custom già presente)

### Server che Richiedono Installazione Manuale

- ⚠️ laravel-boost (richiede `composer require laravel/boost`)

**Passi per Laravel Boost**:
```bash
cd laravel
composer require laravel/boost
php artisan boost:install
```

**Nota**: L'errore PHP in `EditSchedule.php` è stato fixato. Laravel Boost può essere installato.

---

## 🔍 Verifica Configurazione

### Test Server Individuali

```bash
# Test filesystem server
npx -y @modelcontextprotocol/server-filesystem --version

# Test memory server
npx -y @modelcontextprotocol/server-memory --version

# Test fetch server
npx -y @modelcontextprotocol/server-fetch --version

# Test git server
npx -y @modelcontextprotocol/server-git --version

# Test playwright
npx -y @executeautomation/playwright-mcp-server --version

# Test mysql script
node bashscripts/mcp/mysql-db-connector.js
```

### Test Laravel Boost (Dopo Installazione)

```bash
cd laravel
php artisan boost:mcp
```

---

## 🚨 Troubleshooting

### Laravel Boost non risponde

**Problema**: `boost:mcp` command not found

**Soluzione**:
1. Verificare installazione: `composer require laravel/boost`
2. Eseguire installazione: `php artisan boost:install`
3. Verificare path artisan nel config MCP

### Filesystem non accede ai file

**Problema**: Non riesce ad accedere a file fuori da directory specificata

**Soluzione**: Verificare che tutti i path necessari siano inclusi nell'array `args` del filesystem server.

### MySQL MCP non si connette

**Problema**: Errore di connessione database

**Soluzione**:
1. Verificare che `.env` esista e contenga credenziali corrette
2. Testare connessione manuale: `mysql -h $DB_HOST -u $DB_USERNAME -p $DB_DATABASE`
3. Verificare path script in config MCP

### npx non trova i package

**Problema**: Network o npm registry issue

**Soluzione**:
```bash
# Installa globalmente se necessario
npm install -g @modelcontextprotocol/server-filesystem
npm install -g @modelcontextprotocol/server-fetch
npm install -g @executeautomation/playwright-mcp-server
```

---

## 📊 Priorità e Utilizzo

### Server Critici (Usare Sempre)

1. **Laravel Boost** - Quando installato, fornisce accesso completo Laravel
2. **Filesystem** - Accesso file progetto (sempre necessario)
3. **Memory** - Knowledge graph persistente (sempre attivo)

### Server Utili (Usare Quando Necessario)

4. **Sequential Thinking** - Problemi complessi, analisi multi-step
5. **Fetch** - Documentazione esterna, API testing
6. **Git** - Analisi codice, commit history
7. **Playwright** - Testing UI Filament/Livewire

### Server Opzionali (Usare Solo se Necessario)

8. **MySQL** - Query SQL raw (Laravel Boost già fornisce accesso database)
9. **Puppeteer** - Browser automation base (Playwright è preferibile)
10. **MCP Package Docs** - Documentazione pacchetti npm

---

## 🔗 Collegamenti

### Documentazione Interna

- [MCP Servers Configuration](./mcp-servers-configuration.md) - Configurazione generale MCP
- [MCP Servers Complete List](./mcp-servers.md) - Lista completa server disponibili
- [Project Understanding Consolidated](../../../../../../../docs/project-understanding-consolidated.md) - Panoramica progetto

### External Resources

- [Model Context Protocol](https://modelcontextprotocol.io/)
- [Laravel Boost](https://github.com/laravel/boost)
- [MCP Servers GitHub](https://github.com/modelcontextprotocol/servers)

---

## 💡 Best Practices

### 1. Path Assoluti

Sempre usare path assoluti nella configurazione MCP:
```json
// ✅ CORRETTO
"artisan"

// ❌ ERRATO
"./laravel/artisan"
"~/projects/laravel/artisan"
```

### 2. Environment Variables

Mai hardcodare credenziali:
```json
// ✅ CORRETTO
// Script custom legge da .env

// ❌ VIETATO
{
  "env": {
    "DB_PASSWORD": "password123"
  }
}
```

### 3. Scope Filesystem

Limitare sempre lo scope alle directory necessarie:
```json
// ✅ CORRETTO - Directory specifiche
"laravel"

// ❌ PERICOLOSO - Root directory
"/"
```

### 4. Test Isolato

Testare ogni server individualmente prima di usarlo:
```bash
# Test server
npx -y @modelcontextprotocol/server-filesystem --version
```

---

## 🎯 Utilizzo Ottimale

### Scenario 1: Analisi Codice Complessa

1. **Sequential Thinking** - Analisi step-by-step
2. **Memory** - Memorizzare pattern trovati
3. **Git** - Analizzare commit history
4. **Filesystem** - Accedere ai file

### Scenario 2: Debugging Frontend Filament

1. **Playwright** - Testing UI, screenshot
2. **Laravel Boost** - Logs Laravel, route debug
3. **Filesystem** - Accesso file view/blade

### Scenario 3: Query Database

1. **Laravel Boost** - Query via Eloquent (preferito, type-safe)
2. **MySQL MCP** - Query SQL raw solo se necessario

### Scenario 4: Documentazione Aggiornata

1. **Fetch** - Scaricare documentazione Laravel/Filament
2. **MCP Package Docs** - Info pacchetti npm
3. **Memory** - Memorizzare informazioni utili

---

## 🔄 Aggiornamenti Futuri

### Server da Considerare (Opzionali)

- **GitHub** - Se serve interazione con repository GitHub
- **Brave Search** - Web search (fetch è sufficiente per documentazione)
- **PostgreSQL** - Se si passa a PostgreSQL invece di MySQL
- **Redis** - Se serve cache management avanzato

### Script Custom da Creare

- **Laravel Cache Server** - Gestione cache Laravel via MCP
- **Artisan Custom Commands** - Esecuzione comandi artisan custom
- **Module Analyzer** - Analisi moduli Laraxot via MCP

---

**Ultimo aggiornamento**: [DATE]
**Autore**: Super Mucca Analysis
**Status**: ✅ Configurazione Completa e Ottimizzata

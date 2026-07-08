# 🚀 Laravel Boost - MCP Tools e Automazioni

> **FONDAMENTALE**: Laravel Boost MCP fornisce tools potenti specifici per PTVX, ottimizzando il flusso di lavoro di sviluppo.

## 🎯 Panoramica Laravel Boost

Laravel Boost è un server MCP (Model Context Protocol) con tools progettati specificamente per questo progetto PTVX. Fornisce automazioni avanzate e integrazioni con l'ecosistema Laravel.

### Componenti Principali
- **MCP Server**: Bridge tra IDE e backend Laravel
- **Automated Tools**: Script e automazioni per task comuni
- **Context Awareness**: Comprensione del contesto del progetto
- **Smart Suggestions**: Raccomandazioni basate su best practices

---

## 🛠️ MCP Tools Disponibili

### 1. **list-artisan-commands**
Elenca tutti i comandi Artisan disponibili con opzioni e descrizioni.

```bash
# Uso nel terminale
list-artisan-commands

# Filtra per parola chiave
list-artisan-commands --filter=migrate

# Output formattato
list-artisan-commands --format=json
```

### 2. **get-absolute-url**
Genera URL assoluti corretti per l'applicazione.

```bash
# URL base dell'applicazione
get-absolute-url

# URL specifico
get-absolute-url --path=/admin/users

# Con parametri
get-absolute-url --path=/users/{id} --params=123
```

### 3. **tinker**
Esegue codice PHP nel contesto Laravel per debug e test rapidi.

```bash
# Query Eloquent
tinker "User::count()"

# Test di logica
tinker "app(\Modules\User\Services\UserService::class)->getActiveUsers()"

# Debug variabili
tinker "dd(config('app.name'))"
```

### 4. **database-query**
Esegue query database dirette per analisi e debug.

```bash
# Query su tabella specifica
database-query "SELECT COUNT(*) FROM users"

# Query con JOIN
database-query "SELECT u.name, p.title FROM users u JOIN posts p ON u.id = p.user_id"

# Analisi performance
database-query "EXPLAIN SELECT * FROM users WHERE active = 1"
```

### 5. **browser-logs**
Legge i log del browser per debugging frontend.

```bash
# Log recenti
browser-logs --recent

# Filtra per errore
browser-logs --filter=error

# Log specifici per pagina
browser-logs --page=/admin/users
```

### 6. **search-docs**
Cerca nella documentazione di pacchetti Laravel specifici.

```bash
# Ricerca generica
search-docs "filament table actions"

# Ricerca multipla
search-docs ["livewire components", "filament forms"]

# Filtra per pacchetto
search-docs "pdf generation" --packages=["spipu/html2pdf", "spatie/laravel-pdf"]
```

---

## 🔧 Configurazione MCP

### File di Configurazione
```json
// .mcp.json
{
  "mcpServers": {
    "laravel-boost": {
      "command": "node",
      "args": ["node_modules/@laravel-boost/mcp-server/dist/index.js"],
      "env": {
        "LARAVEL_PATH": "laravel",
        "PROJECT_NAME": "PTVX"
      }
    }
  }
}
```

### Configurazione IDE
```json
// .vscode/settings.json
{
  "mcp.servers": ["laravel-boost"],
  "mcp.autoConnect": true,
  "mcp.logLevel": "info"
}
```

---

## 🚀 Workflow Ottimizzato con MCP

### 1. Sviluppo Feature Nuova

```bash
# 1. Analisi requisiti
search-docs "filament resource creation"

# 2. Generazione componenti
list-artisan-commands --filter=make:filament

# 3. Debug generazione
tinker "php artisan make:filament-resource MyResource"

# 4. Test integrazione
get-absolute-url --path=/admin/my-resource

# 5. Verifica database
database-query "DESCRIBE my_resources"
```

### 2. Debug Problema

```bash
# 1. Analisi log browser
browser-logs --recent --filter=error

# 2. Query database problematica
database-query "SELECT * FROM problematic_table WHERE created_at > '2025-01-01'"

# 3. Test codice specifico
tinker "$model = \Modules\MyModule\Models\MyModel::find(1); dd($model->toArray());"

# 4. Verifica URL
get-absolute-url --path=/problematic-page
```

### 3. Analisi Performance

```bash
# 1. Query lente
database-query "SHOW FULL PROCESSLIST"

# 2. Analisi log
browser-logs --filter=performance

# 3. Test codice
tinker "\DB::enableQueryLog(); \Modules\User\Models\User::with('posts')->get(); \DB::getQueryLog();"
```

---

## 📊 Smart Features

### 1. **Context-Aware Suggestions**
MCP analizza il contesto del progetto per fornire suggerimenti rilevanti:

```bash
# Suggerimenti automatici basati su struttura progetto
search-docs "pdf generation"
# → Suggerisce spipu/html2pdf (già installato)
# → Mostra esempi dal progetto esistente
# → Propone best practices per PTVX
```

### 2. **Error Pattern Recognition**
Riconosce pattern di errore comuni nel progetto:

```bash
# Error detection
browser-logs --filter=error
# → Identifica "property_exists() error" comune in PTVX
# → Suggerisce soluzione: usare isset()
# → Mostra esempi corretti dal codebase
```

### 3. **Code Generation Assist**
Genera codice basato su convenzioni PTVX:

```bash
# Generazione codice basata su pattern
tinker "GenerateFilamentResource('MyModel')"
# → Crea Resource class seguendo pattern XotBaseResource
# → Include metodi getTableColumns() corretti
# → Applica convenzioni di traduzione automatica
```

---

## 🔍 Ricerca Documentazione Avanzata

### Syntax di Ricerca

```bash
# 1. Ricerca semplice
search-docs "filament table"

# 2. Frasi esatte
search-docs "laravel pdf generation"

# 3. Query multiple
search-docs ["livewire validation", "filament forms"]

# 4. Ricerca per pacchetto
search-docs "html2pdf" --packages=["spipu/html2pdf"]

# 5. Ricerca contestuale
search-docs "cross database queries" --context=ptvx
```

### Filtri Avanzati

```bash
# Per versione Laravel
search-docs "queues" --laravel-version=11

# Per tipo di contenuto
search-docs "testing" --type=examples

# Per difficoltà
search-docs "relationships" --level=advanced
```

---

## 🎛️ Automazioni Personalizzate

### Script Automazione con MCP

```bash
#!/bin/bash
# ../bashscripts/mcp-automation.sh

# 1. Setup ambiente di sviluppo
echo "🔧 Setting up development environment..."
search-docs "laravel development setup" --packages=["laravel/framework"]

# 2. Verifica configurazione
echo "✅ Checking configuration..."
tinker "dd(config('app.name'), config('database.default'))"

# 3. Test connessioni
echo "🗄️ Testing database connection..."
database-query "SELECT 1 as test"

# 4. Verifica URL
echo "🌐 Testing application URLs..."
get-absolute-url
get-absolute-url --path=/admin

# 5. Analisi log recenti
echo "📋 Checking recent logs..."
browser-logs --recent
```

### Integrazione con Workflow Git

```bash
# .git/hooks/pre-commit con MCP
#!/bin/bash

echo "🔍 Running MCP pre-commit checks..."

# 1. Controlla errori comuni
if browser-logs --filter=error | grep -q "property_exists"; then
    echo "❌ Found property_exists() errors - use isset() instead"
    exit 1
fi

# 2. Verifica query problematiche
database-query "SELECT * FROM migrations WHERE batch = (SELECT MAX(batch) FROM migrations)"

# 3. Test codice
tinker "app()->register(\App\Providers\AppServiceProvider::class);"

echo "✅ MCP pre-commit checks passed"
```

---

## 📈 Monitoring e Analytics

### Performance Monitoring

```bash
# 1. Monitoraggio query
database-query "SELECT query, time FROM mysql.slow_log ORDER BY time DESC LIMIT 10"

# 2. Analisi log performance
browser-logs --filter=performance

# 3. Test carico base
tinker "\$start = microtime(true); \User::count(); \$end = microtime(true); echo 'Time: ' . (\$end - \$start) . 's';"
```

### Error Tracking

```bash
# 1. Errori recenti
browser-logs --filter=error --recent

# 2. Pattern di errori
browser-logs --filter=exception | grep -o "Exception: [A-Za-z]+" | sort | uniq -c

# 3. Errori critici
browser-logs --filter=critical
```

---

## 🚨 Troubleshooting con MCP

### Problemi Comuni e Soluzioni

#### 1. **MCP Server Non Risponde**
```bash
# Verifica stato MCP
ps aux | grep mcp

# Riavvia server MCP
killall mcp-server
node node_modules/@laravel-boost/mcp-server/dist/index.js &

# Verifica configurazione
cat .mcp.json
```

#### 2. **Comandi Artisan Non Trovati**
```bash
# Lista comandi disponibili
list-artisan-commands

# Verifica composer autoload
composer dump-autoload

# Clear cache
php artisan optimize:clear
```

#### 3. **Query Database Fallite**
```bash
# Test connessione
database-query "SELECT 1"

# Verifica configurazione
tinker "dd(config('database.connections.mysql'))"

# Reset connessione
php artisan config:clear
```

---

## 📋 Best Practices MCP

### 1. **Utilizzo Efficiente**
- Usa `search-docs` prima di scrivere codice nuovo
- Combina più tools per analisi completa
- Salva query comuni in script riutilizzabili

### 2. **Debug Strategico**
- Inizia con `browser-logs` per problemi frontend
- Usa `tinker` per test rapidi senza creare file
- Usa `database-query` per analisi dati diretta

### 3. **Automazione Intelligente**
- Crea script personalizzati per task ripetitivi
- Integra MCP nel workflow Git
- Usa context awareness per suggerimenti precisi

---

## 🔮 Futuro di Laravel Boost

### Roadmap Features
- **AI-Powered Code Generation**: Generazione codice basata su AI
- **Advanced Testing Tools**: Test automatici intelligenti
- **Performance Profiling**: Analisi performance avanzata
- **Security Scanning**: Scansione vulnerabilità automatica
- **Documentation Generation**: Generazione documentazione automatica

### Integrazioni Previste
- **GitHub Copilot**: Integrazione profonda con suggerimenti AI
- **Laravel Telescope**: Monitoring avanzato
- **Laravel Horizon**: Queue monitoring
- **Laravel Vapor**: Deploy serverless

---

## 📚 Riferimenti Correlati

- [Development Tasks](development-tasks.md) - Script e automazioni
- [Code Quality](code-quality.md) - Tools qualità
- [Architecture Rules](architecture-rules.md) - Pattern architetturali
- [Core Rules](core.md) - Regole fondamentali

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: 📡 MEDIA - Automazione sviluppo  
**Aggiornamento**: Dicembre 2025

> **💡 Principio**: "Laravel Boost non è solo un tool, è un assistente di sviluppo intelligente che anticipa le tue necessità."
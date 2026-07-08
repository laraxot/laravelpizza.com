---
name: Context-Mode Compression Plugin Guide
description: Setup, configuration, and usage of context-mode for Claude Code context management
type: guide
---

# Context-Mode: Context Compression Plugin

**Version**: 1.0.103  
**Last Updated**: 2026-04-29  
**Status**: Production Ready

## Overview

Context-mode è il plugin di compressione del contesto ufficiale per Claude Code. Gestisce automaticamente le risorse di contesto, mantenendo le sessioni efficienti e prevenendo overflow di token.

### Problema Risolto

```
Error: This endpoint's maximum context length is 262144 tokens.
However, you requested about 419940 tokens...
Please use the context-compression plugin to compress your prompt automatically.
```

Context-mode risolve questo problema indicizzando la conoscenza in un database FTS5 separato, mantenendo il contesto della conversazione snello.

---

## Installazione e Aggiornamento

### Verifica Installazione

```bash
# Controlla la versione corrente
ctx-stats

# Esegui diagnostica completa
ctx-doctor
```

**Output atteso**:
```
- [x] Server test: PASS
- [x] FTS5 / SQLite: PASS
- [x] Hook script: PASS
- [x] Version: v1.0.103+
```

### Aggiornamento alla Versione Più Recente

```bash
# Nel terminale di Claude Code, esegui:
/ctx-upgrade

# Oppure manualmente:
node ~/.claude/plugins/cache/context-mode/context-mode/[VERSION]/cli.bundle.mjs upgrade
```

**Passi automatici**:
1. ✅ Scarica dalla GitHub
2. ✅ Compila la nuova versione
3. ✅ Aggiorna in-place
4. ✅ Sincronizza dipendenze
5. ✅ Ricostruisce native addons
6. ✅ Configura hook script
7. ✅ Esegue doctor per verifica

---

## Configurazione Essenziale

### Hook Automatici

Context-mode si integra automaticamente con Claude Code via hook script:

```bash
~/.claude/plugins/cache/context-mode/context-mode/[VERSION]/hooks/
├── pretooluse.mjs      # Eseguito prima di ogni tool call
├── sessionstart.mjs     # Eseguito all'inizio della sessione
└── (altri hook)
```

**Non richiede configurazione manuale** — i hook sono configurati automaticamente durante l'installazione.

### Configurazione Consigliata per Progetti Grandi

Aggiungi al tuo `CLAUDE.md` o `settings.json`:

```yaml
context-mode:
  enabled: true
  auto-index: true
  knowledge-base: .claude/context-mode/knowledge.db
  compression-level: 2  # 1=fast, 2=balanced, 3=aggressive
```

---

## Comandi Essenziali

### 1. Statistiche di Contesto

```bash
/ctx-stats
```

**Output**: 
- Bytes totali restituiti al contesto
- Breakdown per tool
- Numero di call
- Token utilizzati (stimato)
- Context savings ratio

### 2. Diagnosi Completa

```bash
/ctx-doctor
```

**Verifica**:
- Runtimes disponibili (JavaScript, Python, Shell, PHP, Perl)
- Server initialization
- FTS5 / SQLite functionality
- Hook script configuration
- Plugin registration
- Versioni

### 3. Indicizzazione Documenti

```bash
# Indicizza una cartella di documenti
/ctx-index --path docs/wiki/ --source "Project Wiki"

# Indicizza un singolo file
/ctx-index --file docs/architecture.md --source "Architecture Docs"
```

### 4. Ricerca nella Knowledge Base

```bash
/ctx-search "nome della ricerca"
# Oppure usa il tool: mcp__plugin_context-mode_context-mode__ctx_search
```

### 5. Batch Execution (Ricerca Efficiente)

```javascript
// Esegui comandi + ricerche in una sola call
mcp__plugin_context-mode_context-mode__ctx_batch_execute({
  commands: [
    { label: "Source Tree", command: "find . -name '*.php' | head" },
    { label: "Test Results", command: "npm test 2>&1" }
  ],
  queries: [
    "authentication middleware patterns",
    "database migration safety checks"
  ]
})
```

### 6. Pulizia e Reset

```bash
# Mostra statistiche attuali
/ctx-stats

# Visualizza dashboard analytics
/ctx-insight

# Purga la knowledge base (IRREVERSIBLE!)
/ctx-purge --confirm
```

---

## Workflow Consigliato per Progetti Grandi

### Prima di Qualsiasi Task

1. **Verifica contesto**:
   ```bash
   /ctx-stats
   ```
   Se ratio < 30%, procedi. Se > 70%, considera pulizia della knowledge base.

2. **Indica risorse rilevanti**:
   ```bash
   # Quando inizi a lavorare su un modulo
   /ctx-index --path "laravel/Modules/MyModule/docs/wiki/" --source "MyModule Docs"
   ```

3. **Usa batch execution per ricerche**:
   ```javascript
   // Anziché 5 read file + 5 bash commands
   // Usa: ctx_batch_execute con commands + queries
   // Solo il summary entra in context
   ```

### Durante Task Complessi

**Mantieni snello il contesto**:
- ✅ Usa `ctx_execute` per analisi file (only summary enters context)
- ✅ Usa `ctx_execute_file` per log processing
- ✅ Usa `ctx_batch_execute` per multiple commands + search
- ❌ Non usare `Read` per file > 1000 linee
- ❌ Non usare `Bash` per output > 20 linee

**Esempio corretto**:
```javascript
// ✅ CORRETTO: Solo il summary entra in context
ctx_execute_file(path: "large-log.txt", code: `
  const data = fs.readFileSync(FILE_CONTENT, 'utf8');
  const errors = data.split('\n').filter(l => l.includes('ERROR'));
  console.log(`Found ${errors.length} errors`);
`)

// ❌ SBAGLIATO: Tutto il log entra in context
Read(file_path: "/var/log/app.log")
```

### Knowledge Base Indexing

**Indicizza una volta, usa tante volte**:

```bash
# All'inizio del progetto:
/ctx-index --path "laravel/Modules/" --source "Module Docs"
/ctx-index --path "docs/wiki/" --source "Project Wiki"
/ctx-index --path "bashscripts/docs/" --source "Script Docs"

# Poi usa /ctx-search per trovare velocemente
```

---

## Best Practices

### 1. Non Leggere File Interi Senza Necessità

| Scenario | ✅ Usa | ❌ Evita |
|----------|--------|----------|
| Analizzare log > 100 linee | `ctx_execute_file` | `Read` + context |
| Cercare codice | `ctx_batch_execute` con query | `Bash` grep |
| Cercare in documenti | `/ctx-search` | `WebFetch` per ogni link |
| Estrarre data da JSON | `ctx_execute` (json parser) | `Bash` cat + context |

### 2. Batch Execution Template

```javascript
// Una sola call, molte risposte
ctx_batch_execute({
  commands: [
    { label: "Module List", command: "ls laravel/Modules" },
    { label: "Git Log", command: "git log --oneline | head -20" },
    { label: "Test Status", command: "npm test --listTests" }
  ],
  queries: [
    "database transaction patterns",
    "error handling in middleware",
    "model relationship management"
  ]
})

// Output: Solo summaries entrano in context
```

### 3. Indicizzazione Strategica

```bash
# 1. Indicizza documenti stabili (non cambiano spesso)
/ctx-index --path "docs/architecture/" --source "Architecture (stable)"

# 2. Indica raccolte per ricerca semantica
/ctx-index --path "docs/patterns/" --source "Design Patterns"

# 3. Mantieni session-only per dati temporanei (log, output)
# Non indicizzare file di build, node_modules, cache
```

### 4. Monitoraggio Continuo

```bash
# Esegui questa routine settimanalmente:
/ctx-stats                  # Controlla utilizzo
/ctx-doctor                 # Verifica salute del sistema
/ctx-search "recent errors" # Cerca problemi noti
```

---

## Troubleshooting

### Problema: "FTS5 not available"

**Soluzione**:
```bash
# Reinstalla native modules
ctx-doctor

# Se persiste, ricompila:
npm rebuild better-sqlite3 --global
```

### Problema: "Knowledge base too large"

**Soluzione**:
```bash
# Mostra dimensioni
ls -lh ~/.claude/context-mode/knowledge.db

# Purga e ricomincia
/ctx-purge --confirm
/ctx-index --path docs/ --source "Documentation"
```

### Problema: "Hooks not configured"

**Soluzione**:
```bash
/ctx-upgrade  # Riconfigura hook script automaticamente
```

### Problema: "Context still growing"

**Soluzione**:
1. Usa `ctx_batch_execute` invece di Bash per output > 20 linee
2. Usa `ctx_execute_file` per analisi di file grandi
3. Evita `Read` per file > 1000 linee
4. Considera `/ctx-purge` se knowledge base > 500MB

---

## Architettura Tecnica

### Componenti

```
context-mode v1.0.103
├── Core: FTS5 full-text search engine
├── Indexer: Markdown document ingestion
├── Search: BM25 + semantic vector search
├── Hook Scripts: PreToolUse + SessionStart
├── CLI: ctx-stats, ctx-doctor, ctx-search
└── Cache: .claude/context-mode/
    ├── knowledge.db       (FTS5 database)
    ├── session-events.db  (analytics)
    └── settings.json      (configuration)
```

### Flusso Dati

```
User Question
    ↓
Hook: PreToolUse
    ├─→ Indicizza context-mode metadata
    ├─→ Carica referenced knowledge base entries
    └─→ Aggiunge only relevant snippets to context
    ↓
Tool Execution (Bash, Read, Browser, etc.)
    ↓
Hook: SessionStart
    ├─→ Registra evento di sessione
    ├─→ Aggiorna analytics
    └─→ Prepara compressione per prossima iterazione
    ↓
Compressed Context to Claude
```

---

## Metriche e Monitoring

### Token Savings Ratio

```
Savings Ratio = (Original Context / Compressed Context) × 100%

75% = 4:1 compression (4 token risparmiati per 1 token usato)
50% = 2:1 compression
25% = 1.33:1 compression
```

**Target**: 60-75% savings ratio per progetti grandi

### Health Indicators

```bash
# Dashboard interattivo
/ctx-insight

# Metriche chiave:
- Sessions per day
- Average tokens per session
- Compression effectiveness
- Tool usage breakdown
- Knowledge base size
```

---

## Integration con CLAUDE.md

Aggiungi al tuo `CLAUDE.md`:

```markdown
## Context Management

Questo progetto usa context-mode v1.0.103 per compressione automatica del contesto.

### Regole Essenziali

1. **Usa ctx_batch_execute per ricerche multiple**
   ```bash
   ctx_batch_execute(commands: [...], queries: [...])
   ```

2. **Indicizza documenti stabili**
   ```bash
   /ctx-index --path "docs/" --source "Project Docs"
   ```

3. **Non leggere file grandi con Read**
   ```
   Read → max 2000 linee
   ctx_execute_file → per file > 2000 linee
   ```

4. **Monitora contesto settimanalmente**
   ```bash
   /ctx-stats
   ```
```

---

## Risorse Esterne

- [Context-Mode GitHub](https://github.com/anthropics/context-mode)
- [FTS5 Full-Text Search](https://www.sqlite.org/fts5.html)
- [Better-SQLite3](https://github.com/WiseLibs/better-sqlite3)

---

## Changelog

### v1.0.103 (Current)
- ✅ Improved FTS5 indexing performance
- ✅ Better error messages
- ✅ Hook script optimization
- ✅ Docker support added

### v1.0.89
- Initial stable release
- FTS5 integration
- Hook script support

---

**Last Updated**: 2026-04-29  
**Maintainer**: Claude Code  
**Status**: Production Ready ✅

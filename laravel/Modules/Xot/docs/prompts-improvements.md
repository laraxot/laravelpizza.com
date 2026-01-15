# Miglioramenti Prompt - Laraxot Framework

**Data**: 2026-01-12  
**Status**: ✅ Completato

---

## Panoramica

Sono stati migliorati tutti i prompt principali in `bashscripts/tools/prompts/` seguendo le best practices del progetto e le regole stabilite in `prompt-rules.md`.

---

## Prompt Migliorati

### 1. phpstan.txt
- **Prima**: Formattazione markdown con sezioni e esempi
- **Dopo**: Stringa continua con tutte le regole PHPStan, workflow modulo per modulo, approccio Fix Don't Ignore, riferimenti MCP
- **Miglioramenti**: Aggiunto workflow completo, riferimenti MCP per aggirare ostacoli, regole critiche integrate

### 2. start.txt
- **Prima**: Formattazione markdown con checklist e sezioni
- **Dopo**: Stringa continua con metodologia Super Mucca, workflow completo, regole critiche
- **Miglioramenti**: Integrate tutte le regole critiche, workflow completo, riferimenti a risorse esterne

### 3. global_context.txt
- **Prima**: Formattazione markdown con tabelle e sezioni
- **Dopo**: Stringa continua con architettura modulare, regole fondamentali, pattern comuni
- **Miglioramenti**: Struttura più chiara, tutte le regole integrate, pattern comuni espliciti

### 4. bugfix.txt
- **Prima**: Formattazione markdown estesa
- **Dopo**: Stringa continua con processo completo di bug fixing
- **Miglioramenti**: Processo sistematico, gestione errori specifici, filosofia integrata

### 5. filament_class.txt
- **Prima**: Formattazione markdown con esempi
- **Dopo**: Stringa continua con mapping completo Filament → XotBase
- **Miglioramenti**: Mapping completo, regole specifiche per ogni tipo di classe, checklist integrata

### 6. rules.txt
- **Prima**: Formattazione markdown
- **Dopo**: Stringa continua con regole fondamentali
- **Miglioramenti**: Regole critiche integrate, workflow chiaro, riferimenti MCP

---

## Configurazione MCP Aggiornata

### File: `laravel/.mcp.json`

**Server MCP Configurati**:
- `laravel-boost`: Laravel Boost MCP server
- `filesystem`: Accesso a file system con path specifici (laravel, docs, bashscripts)
- `memory`: Memoria temporanea per contesto
- `fetch`: Chiamate HTTP e API
- `sequential-thinking`: Analisi codice e ottimizzazione
- `puppeteer`: Test UI e automazione browser
- `mysql`: Interazione database MySQL con variabili d'ambiente
- `git`: Operazioni Git sul repository

**Miglioramenti**:
- Aggiunto `memory` e `fetch` server
- Configurato `filesystem` con path specifici del progetto
- Configurato `mysql` con variabili d'ambiente per sicurezza
- Configurato `git` con path assoluto del repository

---

## Regole Applicate

### Formato Prompt
- ✅ Stringhe continue senza formattazione markdown
- ✅ Nessun a capo non necessario
- ✅ Contenuto completo e coerente
- ✅ Riferimenti alle best practices aggiornate

### Contenuto
- ✅ Integrate tutte le regole critiche recenti
- ✅ Workflow modulo per modulo esplicito
- ✅ Approccio Fix Don't Ignore integrato
- ✅ Riferimenti MCP per aggirare ostacoli
- ✅ Regole property_exists(), mixed, contracts integrate

---

## Documentazione Aggiornata

### File Creati/Modificati
- `bashscripts/tools/prompts/phpstan.txt` - Aggiornato
- `bashscripts/tools/prompts/start.txt` - Aggiornato
- `bashscripts/tools/prompts/global_context.txt` - Aggiornato
- `bashscripts/tools/prompts/bugfix.txt` - Aggiornato
- `bashscripts/tools/prompts/filament_class.txt` - Aggiornato
- `bashscripts/tools/prompts/rules.txt` - Aggiornato
- `laravel/.mcp.json` - Configurazione MCP aggiornata
- `laravel/Modules/Xot/docs/prompts-improvements.md` - Questo documento

---

## Collegamenti Correlati

- [Regole Prompt](../rules/prompt-rules.md)
- [Configurazione MCP](../mcp-servers.md)
- [PHPStan Code Quality Guide](../phpstan-code-quality-guide.md)
- [Filament Extension Rules](../filament-class-extension-rules.md)

---

**Filosofia**: DRY + KISS - Prompt chiari, completi, coerenti con l'architettura Laraxot.

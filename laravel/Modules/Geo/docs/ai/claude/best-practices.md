# Best Practices Claude Code per PTVX

---

## Principi Fondamentali

### 1. Context-Aware Development

**Sempre fornisci contesto completo**:
- Riferisci file specifici con `@filename`
- Includi documentazione rilevante
- Spiega business logic quando necessario

**Esempio**:
```
@laravel/Modules/User/app/Models/User.php
@laravel/Modules/User/docs/models.md

Analizza questo modello e suggerisci miglioramenti per PHPStan livello 10.
```

---

### 2. Project-Scoped Configuration

**Usa sempre configurazione progetto**:
- File `.mcp.json` in `laravel/` (version-controlled)
- Team consistency
- Onboarding semplificato

---

### 3. Security First

**Mai hardcode credenziali**:
- Usa variabili d'ambiente
- Proteggi file di configurazione
- Limita filesystem access

---

### 4. Incremental Development

**Lavora incrementale**:
- Un file alla volta
- Verifica dopo ogni modifica
- Commit frequenti

---

## Pattern di Prompt Efficaci

### 1. Prompt Strutturati

**✅ BUONO**:
```
Analizza questo errore PHPStan nel modulo User:
- File: Modules/User/app/Filament/Resources/UserResource.php
- Errore: "Method getTableActions() should return array<string, ...>"
- Contesto: Estende XotBaseResource, usa traduzioni automatiche

Suggerisci fix seguendo:
- Regole Laraxot (array associativi con chiavi stringa)
- Best practices Filament
- Approccio Fix Don't Ignore
```

**❌ SBAGLIATO**:
```
Fix this error
```

---

### 2. Prompt con Riferimenti

**✅ BUONO**:
```
@laravel/Modules/Xot/docs/filament-class-extension-rules.md
@laravel/Modules/User/docs/filament-resources.md

Crea un nuovo Resource per il modello Project seguendo:
- Pattern documentato in filament-class-extension-rules.md
- Esempi in User module
- Regole Laraxot
```

---

### 3. Prompt Incrementali

**✅ BUONO**:
```
Step 1: Analizza struttura esistente
Step 2: Identifica pattern da seguire
Step 3: Genera codice seguendo pattern
Step 4: Verifica con PHPStan
```

---

## Gestione MCP Servers

### Attivazione Selettiva

**Abilita solo server necessari** per risparmiare context tokens:

```bash
# Abilita server specifico
@filesystem enable

# Disabilita quando non serve
@filesystem disable
```

### Ottimizzazione Performance

- **Dynamic Management**: Toggle server on/off
- **Project-Specific**: Configura solo server necessari per progetto
- **Context Awareness**: Usa server solo quando serve

---

## Integrazione con Workflow Laraxot

### 1. Prima di Modificare

- Studia `Modules/{Module}/docs/`
- Comprendi business logic
- Verifica pattern esistenti

### 2. Durante Sviluppo

- Usa Claude per suggerimenti
- Verifica con MCP tools
- Testa incrementale

### 3. Dopo Modifica

- PHPStan livello 10
- PHPMD complexity
- PHP Insights quality
- Aggiorna docs

---

## Errori Comuni da Evitare

### 1. Ignorare Documentazione

**❌ SBAGLIATO**: Modificare codice senza leggere docs

**✅ CORRETTO**: Leggi sempre docs prima di modificare

---

### 2. Hardcode Credenziali

**❌ SBAGLIATO**: 
```json
"MYSQL_PASSWORD": "password123"
```

**✅ CORRETTO**:
```json
"MYSQL_PASSWORD": "${DB_PASSWORD}"
```

---

### 3. Filesystem Access Troppo Ampio

**❌ SBAGLIATO**:
```json
"args": ["/"]
```

**✅ CORRETTO**:
```json
"args": ["/var/www/_bases/base_ptvx_fila5_mono/laravel"]
```

---

### 4. Non Verificare Dopo Modifiche

**❌ SBAGLIATO**: Modificare e commitare senza verificare

**✅ CORRETTO**: Sempre PHPStan + PHPMD + PHP Insights

---

## Collegamenti Correlati

- [Workflow](./workflow.md)
- [Configurazione](./configuration.md)
- [Setup MCP](./mcp-setup.md)
- [Troubleshooting](./troubleshooting.md)

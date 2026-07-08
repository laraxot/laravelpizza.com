# Workflow Gemini Code Assist per PTVX

---

## Workflow Standard

Stesso workflow di Claude Code. Vedi [Workflow Claude](../claude/workflow.md) per dettagli.

---

## Caratteristiche Specifiche Gemini

### 1. Agent Mode

**Quando usare**: Per task complessi multi-step

**Come attivare**:
1. Apri Gemini Code Assist chat
2. Switch a tab "Agent"
3. Descrivi goal dettagliato
4. Gemini proporrà piano per review
5. Approva e monitora esecuzione

**Esempio**:
```
Goal: Migrare tutti i Resource Filament da form() a getFormSchema()
- Analizza tutti i Resource nel modulo User
- Identifica pattern comuni
- Genera piano di migrazione
- Implementa seguendo regole Laraxot
```

---

### 2. Context Drawer

**Quando usare**: Per gestire contesto file e cartelle attivi

**Come usare**:
1. Apri Context Drawer (icona nella sidebar)
2. Aggiungi file/cartelle con `@filename` o drag & drop
3. Rimuovi quando non più necessari
4. Gemini userà solo file nel drawer

**Best Practice**: Mantieni drawer pulito, aggiungi solo file rilevanti

---

### 3. Custom Commands

**Quando usare**: Per task ripetitivi

**Come creare**:
1. **Settings → Gemini Code Assist → Custom Commands**
2. Crea nuovo comando:
   ```json
   {
     "name": "Create Laraxot Resource",
     "prompt": "Crea un Resource Filament seguendo pattern Laraxot per modello {model}"
   }
   ```
3. Usa con `@command-name`

---

### 4. Code Customization (Enterprise)

**Quando usare**: Per suggerimenti basati su codebase privato

**Come configurare**:
1. **Settings → Gemini Code Assist → Code Customization**
2. Seleziona directory da indicizzare (es. `laravel/Modules/`)
3. Attendi indicizzazione
4. Gemini userà codebase per suggerimenti

**Best Practice**: Indica solo directory rilevanti per performance

---

## Pattern di Utilizzo

### 1. Chat Standard

Stesso pattern di Claude Code. Vedi [Workflow Claude](../claude/workflow.md).

---

### 2. Agent Mode per Task Complessi

**Esempio completo**:
```
Agent Mode: Refactora modulo User per PHPStan livello 10

Piano proposto:
1. Analizza tutti gli errori PHPStan
2. Categorizza per tipo
3. Crea roadmap in Modules/User/docs/phpstan-roadmap.md
4. Correggi file per file
5. Verifica dopo ogni file
6. Aggiorna documentazione

Approvare piano? [Sì/No/Modifica]
```

---

### 3. Context Drawer per File Multipli

**Workflow**:
1. Aggiungi file rilevanti al drawer
2. Chiedi analisi cross-file
3. Gemini analizzerà tutti i file nel drawer
4. Rimuovi file quando non più necessari

---

## Collegamenti Correlati

- [Agent Mode](./agent-mode.md)
- [Code Customization](./code-customization.md)
- [Best Practices](./best-practices.md)
- [Workflow Laraxot](../../project/laraxot-methodology.md)

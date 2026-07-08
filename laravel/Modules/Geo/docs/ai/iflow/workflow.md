# Workflow iFlow CLI per PTVX

---

## Workflow Standard

Stesso workflow di Claude Code e Gemini. Vedi [Workflow Claude](../claude/workflow.md) per dettagli.

---

## Caratteristiche Specifiche iFlow

### 1. Terminal-Based

**Quando usare**: Per automazione, script, task batch

**Vantaggi**:
- Integrazione CI/CD
- Automazione completa
- Script personalizzati

---

### 2. 4 Running Modes

#### Yolo Mode

**Comando**: `iflow --mode yolo`

**Comportamento**: Esegue modifiche senza chiedere conferma

**Quando usare**: Task semplici, modifiche sicure

---

#### Accepting Edits Mode

**Comando**: `iflow --mode accepting`

**Comportamento**: Accetta automaticamente tutte le modifiche proposte

**Quando usare**: Refactoring estesi, migrazioni pattern

---

#### Plan Mode

**Comando**: `iflow --mode plan`

**Comportamento**: Genera solo piano, non esegue modifiche

**Quando usare**: Review piano prima di esecuzione, task complessi

---

#### Default Mode

**Comando**: `iflow` (default)

**Comportamento**: Chiede conferma per ogni modifica

**Quando usare**: Sviluppo normale, modifiche importanti

---

### 3. Natural Language Commands

**Esempi**:
```bash
iflow
> Crea un Resource Filament per il modello Project seguendo pattern Laraxot

> Refactora modulo User per PHPStan livello 10

> Analizza questo errore e suggerisci fix: [errore completo]
```

---

### 4. VS Code Extension

**Installazione**: [VS Code Extension](https://marketplace.visualstudio.com/items?itemName=iflow-ai.iflow-cli-vscode-ide-companion)

**Uso**: Analisi contesto codice attivo, suggerimenti in tempo reale

---

## Pattern di Utilizzo

### 1. Task Semplice (Yolo Mode)

```bash
cd /var/www/_bases/base_ptvx_fila5_mono/laravel
iflow --mode yolo
> Fix questo errore PHPStan: [errore]
```

---

### 2. Task Complesso (Plan Mode)

```bash
iflow --mode plan
> Refactora modulo User per PHPStan livello 10

# Review piano generato
# Se approvi, esegui in accepting mode
iflow --mode accepting
> Esegui piano generato
```

---

### 3. Analisi Codebase

```bash
iflow
> /init
# Scansiona e documenta codebase

> Analizza architettura modulo User e suggerisci miglioramenti
```

---

### 4. Debugging Assistito

```bash
iflow
> Ho un null pointer exception dopo questa request, aiutami a trovare la causa
[stack trace completo]
```

---

## Integrazione CI/CD

### GitHub Actions

```yaml
- name: iFlow Code Analysis
  run: |
    npm install -g @iflow-ai/iflow-cli@latest
    iflow --mode plan
      > Analizza codebase e genera report qualità
```

---

## Collegamenti Correlati

- [Execution Modes](./execution-modes.md)
- [Best Practices](./best-practices.md)
- [Workflow Laraxot](../../project/laraxot-methodology.md)

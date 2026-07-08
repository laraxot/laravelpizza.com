# Best Practices iFlow CLI per PTVX

---

## Principi Fondamentali

Stessi principi di Claude Code e Gemini. Vedi [Best Practices Claude](../claude/best-practices.md) per dettagli.

---

## Caratteristiche Specifiche iFlow

### 1. Scegli Mode Appropriato

**Yolo Mode**: Solo per task semplici e sicuri  
**Accepting Mode**: Dopo review piano  
**Plan Mode**: Per task complessi  
**Default Mode**: Sviluppo normale

---

### 2. Natural Language Commands

**✅ BUONO**:
```
Crea un Resource Filament per il modello Project seguendo:
- Pattern Laraxot (XotBaseResource)
- Traduzioni automatiche
- Documentazione in Modules/Project/docs/
```

**❌ SBAGLIATO**:
```
Crea resource
```

---

### 3. Workflow Plan → Accepting

Per task complessi:
1. **Plan Mode**: Genera piano
2. **Review**: Analizza e modifica se necessario
3. **Accepting Mode**: Esegui piano approvato

---

### 4. Integrazione CI/CD

Usa iFlow in CI/CD per:
- Code analysis automatica
- Quality checks
- Documentation generation

---

## Pattern di Utilizzo

### 1. Task Semplice

```bash
iflow --mode yolo
> Fix questo errore PHPStan: [errore specifico]
```

---

### 2. Task Complesso

```bash
# Step 1: Piano
iflow --mode plan
> Refactora modulo User per PHPStan livello 10

# Step 2: Review piano
# Step 3: Esecuzione
iflow --mode accepting
> Esegui piano generato
```

---

### 3. Analisi Codebase

```bash
iflow
> /init
# Scansiona e documenta codebase

> Analizza architettura e suggerisci miglioramenti
```

---

## Integrazione con Workflow Laraxot

Stesso workflow di Claude Code e Gemini. Vedi [Workflow Claude](../claude/workflow.md).

---

## Collegamenti Correlati

- [Workflow](./workflow.md)
- [Execution Modes](./execution-modes.md)
- [Troubleshooting](./troubleshooting.md)

# Best Practices Gemini Code Assist per PTVX

---

## Principi Fondamentali

Stessi principi di Claude Code. Vedi [Best Practices Claude](../claude/best-practices.md) per dettagli.

---

## Caratteristiche Specifiche Gemini

### 1. Agent Mode per Task Complessi

**Quando usare**:
- Refactoring estesi
- Migrazioni pattern
- Task multi-step

**Best Practice**: Sempre review piano prima di approvare

---

### 2. Context Drawer

**Quando usare**:
- Analisi cross-file
- Refactoring multi-file
- Comprendere relazioni

**Best Practice**: Mantieni drawer pulito, aggiungi solo file rilevanti

---

### 3. Custom Commands

**Quando usare**:
- Task ripetitivi
- Scaffolding componenti
- Generazione boilerplate

**Best Practice**: Crea comandi per pattern comuni Laraxot

---

### 4. Code Customization (Enterprise)

**Quando usare**:
- Generazione codice coerente
- Suggerimenti basati su codebase
- Pattern recognition

**Best Practice**: Indica solo directory rilevanti per performance

---

## Pattern di Prompt Efficaci

### 1. Prompt con Context Drawer

**✅ BUONO**:
```
[File nel Context Drawer: UserResource.php, BaseUser.php, docs/filament.md]

Analizza questi file e suggerisci miglioramenti per PHPStan livello 10,
seguendo pattern documentati in docs/filament.md
```

---

### 2. Prompt Agent Mode

**✅ BUONO**:
```
Agent Mode: Refactora modulo User per PHPStan livello 10

Goal dettagliato:
- Risolvi tutti gli errori PHPStan
- Mantieni compatibilità
- Aggiorna documentazione
- Segui approccio Fix Don't Ignore
```

---

### 3. Prompt con Custom Commands

**✅ BUONO**:
```
@create-laraxot-resource Project

Gemini userà il comando custom che include:
- Pattern XotBaseResource
- Traduzioni automatiche
- Struttura documentata
```

---

## Integrazione con Workflow Laraxot

Stesso workflow di Claude Code. Vedi [Workflow Claude](../claude/workflow.md).

---

## Collegamenti Correlati

- [Workflow](./workflow.md)
- [Agent Mode](./agent-mode.md)
- [Code Customization](./code-customization.md)
- [Troubleshooting](./troubleshooting.md)

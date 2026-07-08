# Code Customization - Gemini Code Assist (Enterprise)

---

## Panoramica

Code Customization (solo Enterprise) permette a Gemini Code Assist di fornire suggerimenti basati sul tuo codebase privato, librerie interne e stile di codice dell'organizzazione.

---

## Requisiti

- **Subscription**: Enterprise
- **Codebase**: Privato, non pubblico
- **Indicizzazione**: Richiede indicizzazione iniziale

---

## Configurazione

### 1. Abilita Code Customization

**VS Code**:
1. **Settings → Gemini Code Assist → Code Customization**
2. Abilita "Code Customization"
3. Seleziona directory da indicizzare

**IntelliJ**:
1. **File → Settings → Tools → Gemini Code Assist**
2. **Code Customization → Enable**
3. Aggiungi directory da indicizzare

---

### 2. Seleziona Directory

**Per PTVX, indica**:
- `laravel/Modules/` - Tutti i moduli
- `laravel/Themes/` - Temi frontend
- `docs/` - Documentazione progetto

**Non indicizzare**:
- `node_modules/`
- `vendor/`
- `.git/`

---

### 3. Attendi Indicizzazione

L'indicizzazione iniziale può richiedere tempo:
- **Small codebase** (< 1000 file): 5-10 minuti
- **Medium codebase** (1000-10000 file): 15-30 minuti
- **Large codebase** (> 10000 file): 30-60 minuti

---

## Utilizzo

### 1. Suggerimenti Automatici

Dopo indicizzazione, Gemini fornirà suggerimenti basati su:
- **Pattern esistenti**: Stile codice del progetto
- **Librerie interne**: Uso di classi XotBase
- **Convenzioni**: Naming, struttura, architettura

---

### 2. Chat Context-Aware

Nella chat, Gemini userà automaticamente:
- **Codebase indicizzato**: Per comprendere pattern
- **Documentazione**: Per seguire best practices
- **Stile organizzazione**: Per generare codice coerente

---

### 3. Code Generation

Quando generi codice, Gemini seguirà:
- **Pattern Laraxot**: Estensione XotBase, traduzioni automatiche
- **Struttura moduli**: Namespace, directory structure
- **Convenzioni progetto**: Naming, documentazione

---

## Esempi

### Esempio 1: Generazione Resource

**Prompt**:
```
Crea un Resource Filament per il modello Project
```

**Gemini userà**:
- Pattern da altri Resource nel progetto
- Estensione XotBaseResource
- Traduzioni automatiche
- Struttura documentata

---

### Esempio 2: Refactoring

**Prompt**:
```
Refactora questo metodo per ridurre complexity
```

**Gemini userà**:
- Pattern Extract Method da altri file
- Guard Clauses da esempi esistenti
- Stile codice del progetto

---

## Best Practices

### 1. Indicizza Solo Necessario

**✅ BUONO**: Indica solo directory rilevanti

**❌ SBAGLIATO**: Indica tutto il progetto (lento, inutile)

---

### 2. Aggiorna Indicizzazione

Dopo modifiche significative:
- **Rigenera indicizzazione**: Se aggiungi molti file
- **Incremental update**: Gemini aggiorna automaticamente

---

### 3. Usa con Context Drawer

Combina Code Customization con Context Drawer:
- Code Customization: Pattern generali
- Context Drawer: File specifici rilevanti

---

## Limitazioni

- **Enterprise only**: Richiede subscription Enterprise
- **Indicizzazione tempo**: Richiede tempo iniziale
- **Storage**: Indicizzazione occupa spazio

---

## Collegamenti Correlati

- [Workflow](./workflow.md)
- [Agent Mode](./agent-mode.md)
- [Best Practices](./best-practices.md)
- [Documentazione Ufficiale Gemini](https://cloud.google.com/gemini/docs/codeassist/code-customization-overview)

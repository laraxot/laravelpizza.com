# Execution Modes - iFlow CLI

---

## Panoramica

iFlow CLI supporta 4 modi di esecuzione per adattarsi a diversi scenari di utilizzo.

---

## 1. Yolo Mode

### Comando

```bash
iflow --mode yolo
```

### Comportamento

- **Esegue modifiche** senza chiedere conferma
- **Nessun prompt** per approvazione
- **Massima velocità**

### Quando Usare

- Task semplici e sicuri
- Fix automatici PHPStan
- Formattazione codice
- Generazione boilerplate

### Esempio

```bash
iflow --mode yolo
> Fix tutti gli errori PHPStan nel modulo User
```

---

## 2. Accepting Edits Mode

### Comando

```bash
iflow --mode accepting
```

### Comportamento

- **Accetta automaticamente** tutte le modifiche proposte
- **Mostra preview** delle modifiche
- **Esegue dopo preview**

### Quando Usare

- Refactoring estesi
- Migrazioni pattern
- Task complessi multi-file
- Quando hai già reviewato il piano

### Esempio

```bash
# Prima genera piano
iflow --mode plan
> Refactora modulo User per PHPStan livello 10

# Review piano, poi esegui
iflow --mode accepting
> Esegui piano generato
```

---

## 3. Plan Mode

### Comando

```bash
iflow --mode plan
```

### Comportamento

- **Genera solo piano** dettagliato
- **Non esegue modifiche**
- **Mostra step-by-step plan**

### Quando Usare

- Review piano prima di esecuzione
- Task complessi che richiedono pianificazione
- Valutazione impatto modifiche
- Documentazione workflow

### Esempio

```bash
iflow --mode plan
> Refactora modulo User per PHPStan livello 10

# Output: Piano dettagliato con:
# - Step 1: Analisi errori
# - Step 2: Categorizzazione
# - Step 3: Correzione file per file
# - Step 4: Verifica
# - Step 5: Documentazione

# Review piano, poi esegui in accepting mode
```

---

## 4. Default Mode

### Comando

```bash
iflow
# oppure
iflow --mode default
```

### Comportamento

- **Chiede conferma** per ogni modifica
- **Preview modifiche** prima di eseguire
- **Massimo controllo**

### Quando Usare

- Sviluppo normale
- Modifiche importanti
- Quando vuoi controllo completo
- Learning e comprensione modifiche

### Esempio

```bash
iflow
> Fix questo errore PHPStan: [errore]

# iFlow mostra:
# - Analisi errore
# - Soluzione proposta
# - File da modificare
# - Preview modifiche

# Confermi? [Sì/No/Modifica]
```

---

## Best Practices

### 1. Inizia con Plan Mode

Per task complessi:
1. **Plan Mode**: Genera piano
2. **Review**: Analizza piano
3. **Accepting Mode**: Esegui piano approvato

---

### 2. Usa Yolo Mode con Cautela

**✅ BUONO**: Task semplici, fix automatici

**❌ SBAGLIATO**: Modifiche architetturali importanti

---

### 3. Default Mode per Learning

Usa Default Mode quando:
- Stai imparando iFlow
- Vuoi comprendere modifiche
- Modifiche critiche

---

## Esempi Workflow Completi

### Workflow 1: Fix PHPStan Modulo

```bash
# 1. Genera piano
iflow --mode plan
> Fix tutti gli errori PHPStan livello 10 nel modulo User

# 2. Review piano generato
# 3. Esegui piano
iflow --mode accepting
> Esegui piano generato

# 4. Verifica
cd laravel
./vendor/bin/phpstan analyse Modules/User --level=10
```

---

### Workflow 2: Refactoring Complesso

```bash
# 1. Analisi
iflow
> Analizza questo metodo e suggerisci refactoring per ridurre complexity

# 2. Review suggerimenti
# 3. Approva modifiche
# 4. Verifica
./vendor/bin/phpmd Modules/User text codesize
```

---

## Collegamenti Correlati

- [Workflow](./workflow.md)
- [Best Practices](./best-practices.md)
- [Troubleshooting](./troubleshooting.md)

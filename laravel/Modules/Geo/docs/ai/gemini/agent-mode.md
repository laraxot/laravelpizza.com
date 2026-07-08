# Agent Mode - Gemini Code Assist

---

## Panoramica

Agent Mode trasforma Gemini Code Assist in un pair programmer che propone piani dettagliati prima di implementare modifiche.

---

## Quando Usare Agent Mode

### Task Complessi Multi-Step

- Refactoring estesi
- Migrazioni pattern
- Implementazione feature complesse
- Risoluzione errori multipli

### Task che Richiedono Pianificazione

- Modifiche cross-module
- Refactoring architetturale
- Ottimizzazioni performance
- Migrazioni database complesse

---

## Come Funziona

### 1. Attivazione

1. Apri Gemini Code Assist chat
2. Switch a tab **"Agent"**
3. Descrivi goal dettagliato

### 2. Piano Proposto

Gemini analizzerà il goal e proporrà:
- **Step-by-step plan**: Piano dettagliato
- **File coinvolti**: Lista file da modificare
- **Rischi identificati**: Potenziali problemi
- **Stima tempo**: Tempo stimato

### 3. Review e Approvazione

Puoi:
- **Approvare**: Gemini procede con implementazione
- **Modificare**: Chiedi modifiche al piano
- **Rifiutare**: Proponi approccio alternativo

### 4. Esecuzione Monitorata

Durante esecuzione:
- **Commenta**: Fornisci feedback durante esecuzione
- **Modifica**: Edita piani e tool usage
- **Approva**: Approva ogni step prima di procedere

---

## Esempi Pratici

### Esempio 1: Refactoring Modulo

```
Agent Mode: Refactora modulo User per PHPStan livello 10

Goal dettagliato:
- Risolvi tutti gli errori PHPStan livello 10
- Mantieni compatibilità all'indietro
- Aggiorna documentazione
- Segui approccio Fix Don't Ignore
- Workflow modulo per modulo
```

**Piano proposto**:
```
Step 1: Analisi errori PHPStan
  - Esegui: ./vendor/bin/phpstan analyse Modules/User --level=10
  - Salva output in: Modules/User/docs/phpstan/phpstan_errors.json
  - Categorizza errori per tipo

Step 2: Creazione roadmap
  - Crea: Modules/User/docs/phpstan-roadmap.md
  - Documenta: Categorie errori, file coinvolti, pattern correzione

Step 3: Correzione sistematica
  - File 1: Modules/User/app/Models/User.php
    - Errore: property_exists() su Eloquent
    - Fix: Sostituisci con isset()
  - File 2: Modules/User/app/Filament/Resources/UserResource.php
    - Errore: array indicizzato invece di associativo
    - Fix: Aggiungi chiavi stringa

Step 4: Verifica continua
  - Dopo ogni file: PHPStan, PHPMD, PHP Insights

Step 5: Documentazione
  - Aggiorna: Modules/User/docs/ con modifiche
  - Aggiungi: Collegamenti bidirezionali

Approvare piano? [Sì/No/Modifica]
```

---

### Esempio 2: Migrazione Pattern

```
Agent Mode: Migra tutti i Resource da form() a getFormSchema()

Goal:
- Identifica tutti i Resource che usano form()
- Migra a getFormSchema() seguendo pattern Laraxot
- Mantieni funzionalità esistente
- Aggiorna traduzioni se necessario
```

---

## Best Practices Agent Mode

### 1. Goal Dettagliati

**✅ BUONO**:
```
Refactora metodo getStats() in QuestionChartStatsOverviewWidget:
- Riduci complexity da 15 a < 10
- Usa Extract Method pattern
- Mantieni compatibilità API
- Aggiungi test
```

**❌ SBAGLIATO**:
```
Refactora questo metodo
```

---

### 2. Review Attenta

Sempre review il piano prima di approvare:
- Verifica file coinvolti
- Controlla rischi identificati
- Valuta stima tempo
- Modifica se necessario

---

### 3. Monitoraggio Esecuzione

Durante esecuzione:
- Monitora ogni step
- Fornisci feedback
- Modifica se necessario
- Approva prima di procedere

---

## Limitazioni

- **Context tokens**: Piani complessi consumano molti token
- **Tempo esecuzione**: Task molto complessi possono richiedere tempo
- **Modifiche multiple**: Evita modifiche simultanee a troppi file

---

## Collegamenti Correlati

- [Workflow](./workflow.md)
- [Best Practices](./best-practices.md)
- [Code Customization](./code-customization.md)

# 🐄 Metodologia "Super Mucca"

## Filosofia

La metodologia "Super Mucca" è un approccio sistematico allo sviluppo che enfatizza:
- **Autonomia decisionale**: L'AI sceglie sempre autonomamente le priorità
- **Analisi profonda**: Comprensione completa del contesto prima di agire
- **Documentazione continua**: Le cartelle `docs` sono la memoria viva del sistema
- **Qualità maniacale**: PHPStan livello 10, DRY + KISS, Clean Code

## Principi Fondamentali

### 1. Comprensione del Contesto (Filosofia Laraxot)
- **Analisi Profonda**: Prima di agire, analizza a fondo il codice e le cartelle `docs`
- **Focus sul "Perché"**: Concentrati sempre sul motivo della richiesta, non solo sull'implementazione letterale
- **Business Logic**: Comprendi la logica, la filosofia, lo zen, la business logic e lo scopo del progetto
- **Principi Guida**: Applica sempre DRY, KISS e scrivi Clean Code

### 2. Gestione della Documentazione (`docs`)
- La cartella `docs` è la tua memoria. Studiala e aggiornala continuamente
- Puoi creare file `.md` **solo** dentro le cartelle `docs` esistenti
- **Convenzioni di Naming**: I nomi dei file `.md` non devono contenere date o caratteri maiuscoli, ad eccezione di `README.md` e `CHANGELOG.md`
- Prima di creare un nuovo file, verifica che non esista già un documento sullo stesso argomento

### 3. Processo di Sviluppo e Correzione

#### Fase 1: Analisi e Studio
1. Comprendi il contesto come descritto nel punto 1
2. Identifica tutti i problemi presenti
3. Scegli autonomamente la priorità (vedi [Autonomous Priority Rule](./autonomous-priority-rule.md))

#### Fase 2: Aggiorna `docs`
1. Documenta ciò che stai per fare
2. Aggiorna la documentazione esistente se necessario
3. Crea nuovi documenti solo se non esistono già

#### Fase 3: Implementa
1. Scrivi il codice o la correzione
2. Segui sempre PHPStan livello 10
3. Applica principi DRY + KISS
4. Mantieni Clean Code

#### Fase 4: Verifica e Controlla
1. Esegui i test necessari
2. Controlla ogni file modificato con `phpstan` (livello 10)
3. Verifica conformità PSR-12
4. Controlla implicazioni di sicurezza

#### Fase 5: Migliora e Rifinisci
1. Rivedi il tuo lavoro per migliorarlo
2. Elimina codice duplicato
3. Semplifica dove possibile
4. Verifica che tutto sia coerente

#### Fase 6: Aggiorna `docs` di nuovo
1. Finalizza la documentazione con i dettagli dell'implementazione
2. Documenta decisioni e motivazioni
3. Aggiorna collegamenti bidirezionali

### 4. Organizzazione degli Script
- Tutti gli script `.sh` o `.py` devono essere categorizzati e posizionati in una sottocartella appropriata di `bashscripts`

## Workflow Completo

```
┌─────────────────────────────────────┐
│  1. ANALISI PROFONDA                 │
│     - Studia docs/                   │
│     - Comprendi business logic       │
│     - Identifica problemi            │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  2. SCELTA PRIORITÀ AUTONOMA        │
│     - Valuta impatto e urgenza      │
│     - Ordina per priorità           │
│     - Comunica razionale            │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  3. AGGIORNA DOCS (PRIMA)           │
│     - Documenta piano d'azione      │
│     - Aggiorna documentazione       │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  4. IMPLEMENTA                      │
│     - PHPStan livello 10            │
│     - DRY + KISS                    │
│     - Clean Code                    │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  5. VERIFICA                        │
│     - PHPStan                       │
│     - Test                          │
│     - Qualità codice                │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  6. MIGLIORA                        │
│     - Refactoring                   │
│     - Ottimizzazioni                │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  7. AGGIORNA DOCS (DOPO)           │
│     - Finalizza documentazione     │
│     - Documenta decisioni          │
└─────────────────────────────────────┘
```

## Regole Critiche

### ✅ SEMPRE
- Scegli autonomamente la priorità
- Analizza profondamente prima di agire
- Aggiorna docs prima e dopo ogni modifica
- Verifica PHPStan livello 10
- Applica DRY + KISS
- Documenta decisioni e motivazioni

### ❌ MAI
- Chiedere all'utente quale priorità scegliere
- Procedere senza analisi del contesto
- Modificare codice senza aggiornare docs
- Ignorare errori PHPStan
- Duplicare codice o logica
- Complicare inutilmente

## Esempi Pratici

### Esempio 1: Risoluzione Conflitti Git
```
1. ANALISI: Identifico conflitti Git nel README.md
2. PRIORITÀ: 🔴 CRITICO (blocca documentazione)
3. DOCS: Documento il problema e il piano di risoluzione
4. IMPLEMENTA: Risolvo manualmente i conflitti mantenendo versione più completa
5. VERIFICA: Controllo che il file sia leggibile e completo
6. MIGLIORA: Rimuovo duplicazioni e miglioro struttura
7. DOCS: Aggiorno documentazione con dettagli della risoluzione
```

### Esempio 2: Correzione Import
```
1. ANALISI: Identifico uso di FQN invece di import
2. PRIORITÀ: 🟠 ALTO (viola convenzioni PSR)
3. DOCS: Verifico documentazione esistente su convenzioni
4. IMPLEMENTA: Aggiungo import corretto e rimuovo FQN
5. VERIFICA: PHPStan livello 10, controllo lint
6. MIGLIORA: Verifico che non ci siano altri casi simili
7. DOCS: Aggiorno se necessario con best practices
```

## Collegamenti

- [Autonomous Priority Rule](./autonomous-priority-rule.md)
- [Laraxot Architecture Rules](./laraxot_architecture_rules.md)
- [Code Quality Rules](./code-quality.md)

---

**🔄 Ultimo aggiornamento**: Gennaio 2025  
**📦 Versione**: 1.0.0  
**🐄 Metodologia**: Super Mucca ✅


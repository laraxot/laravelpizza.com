# Xot Module - Asana MCP Integration Guide

**Versione**: 1.0.0
**Status**: ✅ Ready

---

## 📋 Panoramica

L'integrazione di Asana MCP nel modulo Xot permette di:
- Tracciare i task di sviluppo del core framework
- Creare automaticamente task dai roadmap items
- Aggiornare lo stato dei task dai commit
- Generare report di progresso

---

## 🚀 Setup Rapido

### Prerequisiti
- ✅ Asana MCP configurato in `.mcp.json`
- ✅ Account Asana con accesso al workspace
- ✅ Permessi per creare e gestire task

### Configurazione
```bash
# Verifica configurazione MCP
cat ../../../.mcp.json | grep -A 5 "asana"
```

---

## 🎯 Casi d'Uso

### 1. Creazione Task da Roadmap

**Comando**:
```
"Crea task Asana per ogni item nella roadmap Xot: 
1. Documentation consolidation
2. Safe functions implementation  
3. Test coverage increase
4. Developer tools suite"
```

**Output**: Task creati in Asana con:
- Titoli descrittivi
- Assegnati al responsabile
- Date di scadenza basate su stime
- Dipendenze tra task

### 2. Tracciamento Progresso

**Comando**:
```
"Aggiorna task Asana per Xot in base ai commit recenti:
- commit abc123: Documentation consolidation completato
- commit def456: SafeArrayCastAction implementato
"
```

**Output**: Task aggiornati in Asana con:
- Nuovo stato (in progress → completed)
- Commenti con dettagli
- Link ai commit
- Notifiche al team

### 3. Generazione Report

**Comando**:
```
"Genera report progresso Xot da Asana:
- Task completati questa settimana
- Task in corso
- Task ritardati
- Velocity del team"
```

**Output**: Report markdown con:
- Tabella status task
- Metriche di progresso
- Grafici velocity
- Raccomandazioni

---

## 📝 Task Templates

### Template: Feature Development

```
Titolo: [Feature Name] - Xot Module
Descrizione: Implementa [feature description] per Xot core framework

Subtask:
- [ ] Analisi requisiti
- [ ] Implementazione codice
- [ ] Unit tests
- [ ] Documentation
- [ ] Code review

Assegna a: [Responsabile]
Due date: [Data stima]
Priorità: [Alta/Media/Bassa]
```

### Template: Bug Fix

```
Titolo: Fix [Bug Description] - Xot Module
Descrizione: Corregge bug in [component] che causa [symptom]

Dettagli:
- Reproduction steps: [steps]
- Expected behavior: [expected]
- Actual behavior: [actual]
- Error message: [error]

Assegna a: [Responsabile]
Priorità: Alta
```

### Template: Documentation

```
Titolo: Documenta [Feature/Component] - Xot Module
Descrizione: Crea documentazione per [feature]

Contenuti richiesti:
- [ ] Architecture overview
- [ ] Usage examples
- [ ] API documentation
- [ ] Best practices
- [ ] Troubleshooting

Assegna a: [Responsabile]
```

---

## 🔧 Workflows

### Workflow 1: Feature Development

```
1. Leggi roadmap Xot
   ↓
2. Crea task Asana per feature
   ↓
3. Assegna al responsabile
   ↓
4. Monitora progresso
   ↓
5. Aggiorna task da commit
   ↓
6. Completa task quando feature finita
   ↓
7. Genera report
```

### Workflow 2: Bug Fix

```
1. Identifica bug
   ↓
2. Crea task Asana bug fix
   ↓
3. Assegna priorità alta
   ↓
4. Sviluppa fix
   ↓
5. Aggiorna task con commit
   ↓
6. Completa task
   ↓
7. Aggiorna metrics
```

### Workflow 3: Documentation

```
1. Identifica feature da documentare
   ↓
2. Crea task documentazione
   ↓
3. Scrivi documentazione
   ↓
4. Review documentazione
   ↓
5. Aggiorna task
   ↓
6. Pubblica documentazione
```

---

## 💡 Best Practices

### Naming Convention

```
✅ Buono:
- "Implementa SafeArrayCastAction - Xot Module"
- "Fix PHPStan error in User trait - Xot Module"
- "Documenta XotBaseModel - Xot Module"

❌ Cattivo:
- "Task 1"
- "Fix bug"
- "Docs"
```

### Task Description

```
✅ Buono:
"Implementa SafeArrayCastAction per gestire cast sicuri da array a tipi specifici.
Include:
- Type checking rigoroso
- Error handling robusto
- PHPDoc annotations complete
- Unit tests al 95%"

❌ Cattivo:
"Fare cast array"
```

### Dependencies

```
✅ Buono:
Task A: Implementa base class
  ↓ depends on
Task B: Implementa trait
  ↓ depends on  
Task C: Implementa action

❌ Cattivo:
Task A, B, C: Senza dipendenze
```

---

## 📊 Metrics Tracking

### Metrics da Tracciare

1. **Task Completion Rate**
   ```
   (Task completati / Task totali) * 100
   Target: > 80%
   ```

2. **Velocity**
   ```
   Task completati per settimana
   Target: 3-5 task/week
   ```

3. **Cycle Time**
   ```
   Tempo medio da creazione a completamento
   Target: < 5 giorni
   ```

4. **Bug Fix Time**
   ```
   Tempo medio per risolvere bug
   Target: < 2 giorni
   ```

### Comando Metrics

```
"Calcola metrics Xot da Asana:
- Task completion rate
- Velocity  
- Cycle time
- Bug fix time

Genera report con grafici e trend analysis"
```

---

## 🔌 Integration con Altri Moduli

### Xot → User Module

```
"Crea task Asana per User module dipendente da Xot:
- Task Xot: Completa XotBaseUser
- Task User: Implementa 2FA su BaseUser

Imposta dipendenza in Asana"
```

### Xot → Cms Module

```
"Crea task Asana per Cms module che usa Xot features:
- Task Xot: Implementa XotBaseResource enhancements
- Task Cms: Aggiorna CmsResource per usare nuove features

Imposta dipendenza in Asana"
```

---

## 📚 Esempi Pratici

### Esempio 1: Roadmap → Task

```
Input: Roadmap Xot item "Completa Safe Functions Implementation"

Comando AI:
"Crea task gerarchico in Asana per Safe Functions:
- Task padre: Completa Safe Functions Implementation (85%)
  - Subtask 1: Completa SafeArrayCastAction (100%)
  - Subtask 2: Implementa SafeStringCastAction (100%)
  - Subtask 3: Implementa SafeIntCastAction (0%)
  - Subtask 4: Implementa SafeBoolCastAction (0%)
  - Subtask 5: Implementa SafeJsonDecodeAction (0%)
  - Subtask 6: Implementa SafeJsonEncodeAction (0%)
  - Subtask 7: Implementa SafeFileReadAction (0%)
  - Subtask 8: Implementa SafeFileWriteAction (0%)
  - Subtask 9: Implementa SafeFileDeleteAction (0%)
  - Subtask 10: Implementa SafeDirectoryListAction (0%)

Assegna a: TBD
Due date: 3-4 giorni
Project: Xot Core Development"
```

### Esempio 2: Commit → Task Update

```
Input: Commit "feat(xot): implement SafeIntCastAction"

Comando AI:
"Trova task Asana correlato a SafeIntCastAction
Aggiorna stato a 'In Progress'
Aggiungi commento: 'Commit abc123 implementato. 
Codice in app/Actions/Cast/SafeIntCastAction.php.
Unit tests in tests/Actions/SafeIntCastActionTest.php.
Status: 100% completato'"
```

### Esempio 3: Report Generale

```
Comando AI:
"Genera report settimanale Xot da Asana:
- Task completati questa settimana
- Task in corso con % completamento
- Task ritardati
- Velocity del team
- Bugs risolti
- Features rilasciate

Formato: Markdown con tabelle e grafici"
```

---

## ⚠️ Note Importanti

### Limitazioni

- Asana MCP è in beta - funzionalità possono cambiare
- Richiede connessione internet attiva
- OAuth token può scadere
- Rate limits API

### Security

- ⚠️ Non esporre OAuth token nel codice
- ⚠️ Usare scopes minimi necessari
- ⚠️ Revocare access non più necessari
- ⚠️ Monitorare access log

### Performance

- ⚠️ Evitare troppe chiamate API in sequenza
- ⚠️ Cache results quando possibile
- ⚠️ Usare batch operations per multi-task

---

## 🚀 Next Steps

1. **Configura Asana Workspace**: Crea workspace Xot
2. **Crea Progetti**: Crea progetti per Xot development
3. **Definisci Templates**: Crea task templates standard
4. **Integra CI/CD**: Configura automatic task updates
5. **Monitora Metrics**: Configura dashboard metrics
6. **Refine Workflows**: Ottimizza workflows base su usage

---

**Status**: ✅ Ready for Use

**Maintained By**: Xot Team
